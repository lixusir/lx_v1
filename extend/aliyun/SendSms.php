<?php
namespace aliyun;
/**
 * 阿里云短信验证码发送类
 * @author Administrator
 *
 */
class SendSms {
    // 保存错误信息
    public $error;
    // Access Key ID
    private $accessKeyId = '';
    // Access Access Key Secret
    private $accessKeySecret = '';
    // 签名
    private $signName = '';
//    // 模版ID
//    private $templateCode = '';
    public function __construct($cofig = array()) {
        // 配置参数
        $this->accessKeyId = $cofig ['accessKeyId'];
        $this->accessKeySecret = $cofig ['accessKeySecret'];
        $this->signName = $cofig ['signName'];
//        $this->templateCode = $cofig ['templateCode'];
    }
    private function percentEncode($string) {
        $string = urlencode ( $string );//urlencode()函数原理就是首先把中文字符转换为十六进制，然后在每个字符前面加一个标识符%
        $string = preg_replace ( '/\+/', '%20', $string );//preg_replace() 函数用于正则表达式的搜索和替换。
        $string = preg_replace ( '/\*/', '%2A', $string );
        $string = preg_replace ( '/%7E/', '~', $string );
        return $string;
    }
    /*
     * 签名
     *
     * @param unknown $parameters
     * @param unknown $accessKeySecret
     * @return string
     */
    private function computeSignature($parameters, $accessKeySecret) {
        ksort ( $parameters );
        $canonicalizedQueryString = '';
        foreach ( $parameters as $key => $value ) {
            $canonicalizedQueryString .= '&' . $this->percentEncode ( $key ) . '=' . $this->percentEncode ( $value );
        }
        $stringToSign = 'GET&%2F&' . $this->percentencode ( substr ( $canonicalizedQueryString, 1 ) );
        $signature = base64_encode ( hash_hmac ( 'sha1', $stringToSign, $accessKeySecret . '&', true ) );//base64_encode 将字符串以 BASE64 编码。
        return $signature;
    }
    /*
     * 发送验证码 https://help.aliyun.com/document_detail/56189.html
     *
     * @param unknown $mobile
     * @param unknown $verify_code
     *
     */
    public function send_verify($mobile, $verify_code ,$tpl_code) {
        $params = array (
            // 公共参数
            'SignName' => $this->signName,
            'Format' => 'JSON',
            'Version' => '2017-05-25',
            'RegionId' => 'cn-hangzhou',
            'AccessKeyId' => $this->accessKeyId,
            'SignatureVersion' => '1.0',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => uniqid (),
            'Timestamp' => gmdate ( 'Y-m-d\TH:i:s\Z' ),
            // 接口参数
            'Action' => 'SendSms',
            'TemplateCode' => $tpl_code,
            'PhoneNumbers' => $mobile,
            'TemplateParam' => '{"code":"' . $verify_code . '"}'
        );
        // 计算签名并把签名结果加入请求参数
        $params ['Signature'] = $this->computeSignature ( $params, $this->accessKeySecret );
        // 发送请求
        $url = 'https://dysmsapi.aliyuncs.com/?' . http_build_query ( $params );//http_build_query -- 生成 url-encoded 之后的请求字符串描述string

        $ch = curl_init ();//curl_init — 初始化一个curl会话
        curl_setopt ( $ch, CURLOPT_URL, $url );//curl_setopt()函数将为一个CURL会话设置选项
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        $result = json_decode ( $result, true );
        if($result['Code'] !='OK'){
            return ['code'=>1,'msg'=>$this->getErrorMessage ( $result ['Code'] )];
        }
        return ['code'=>0,'msg'=>'发送成功'];
    }
    /*
     * 获取详细错误信息
     *
     * @param unknown $status
     */
    public function getErrorMessage($status) {
        // 阿里云的短信
        // https://help.aliyun.com/document_detail/55451.html?spm=5176.sms-account.109.2.66e3621wwA63w
        $message = array (
            'isv.TEMPLATE_MISSING_PARAMETERS'=>'模板缺少变量',
            'isp.RAM_PERMISSION_DENY'=>'RAM权限DENY',
            'isv.OUT_OF_SERVICE'=>'业务停机',
            'isv.PRODUCT_UN_SUBSCRIPT'=>'未开通云通信产品的阿里云客户',
            'isv.PRODUCT_UNSUBSCRIBE'=>'产品未开通',
            'isv.ACCOUNT_NOT_EXISTS'=>'账户不存在',
            'isv.ACCOUNT_ABNORMAL'=>'账户异常',
            'isv.SMS_TEMPLATE_ILLEGAL'=>'短信模板不合法',
            'isv.SMS_SIGNATURE_ILLEGAL'=>'短信签名不合法',
            'isv.INVALID_PARAMETERS'=>'参数异常',
            'isp.SYSTEM_ERROR'=>'系统错误',
            'isv.MOBILE_NUMBER_ILLEGAL'=>'非法手机号',
            'isv.MOBILE_COUNT_OVER_LIMIT'=>'手机号码数量超过限制',
            'isv.TEMPLATE_MISSING_PARAMETERS'=>'模板缺少变量',
            'isv.BUSINESS_LIMIT_CONTROL'=>'业务限流',
            'isv.INVALID_JSON_PARAM'=>'JSON参数不合法，只接受字符串值',
            'isv.BLACK_KEY_CONTROL_LIMIT'=>'黑名单管控',
            'isv.PARAM_LENGTH_LIMIT'=>'参数超出长度限制',
            'isv.PARAM_NOT_SUPPORT_URL'=>'不支持URL',
            'isv.AMOUNT_NOT_ENOUGH'=>'账户余额不足',
        );
        if (isset ( $message [$status] )) {
            return $message [$status];
        }
        return $status;
    }
}