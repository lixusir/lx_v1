webpackJsonp([46],{"+ed2":function(n,e){},"/nV0":function(n,e,t){"use strict";function r(n){if(Array.isArray(n)){for(var e=0,t=Array(n.length);e<n.length;e++)t[e]=n[e];return t}return Array.from(n)}var o=t("7+uW"),a=t("/ocq"),u=t("Jw+o"),i=t("9iJv"),s=t("HtrO"),c=t("eq3C"),l=t("i11s"),f=t("SshP"),d=t("ae3s"),m=t("ws3L"),p=t("GkzX");o.default.use(a.a);var h=new a.a({routes:[].concat(r(u.a),r(i.a),r(s.a),r(c.a),r(l.a),r(f.a),r(d.a),r(m.a),r(p.a))});h.beforeEach(function(n,e,t){localStorage.getItem("token")||(n.meta.notLogin?t():t({path:"/login"})),t()}),e.a=h},"1fAN":function(n,e){},"2Ium":function(n,e,t){"use strict";e.a={install:function(n){Object.defineProperty(n.prototype,"$bus",{value:new n({data:function(){return{item_list:[]}},created:function(){var n=this;this.$on("item_list",function(e){if(!Array.isArray(e))throw Error("item_list必须为数组");n.item_list=e})}})})}}},"3U+z":function(n,e,t){"use strict";var r=t("PJh5"),o=t.n(r);o.a.locale("zh-cn");var a=function(n){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"YYYY-MM-DD";return n?o()(1e3*n).format(e):""},u=function(n){return isNaN(n)?n:"¥"+(n/100).toFixed(2)};e.a={install:function(n){n.filter("yuan",u),n.filter("dateFormat",a)}}},"9S6h":function(n,e){},"9iJv":function(n,e,t){"use strict";var r=function(){return t.e(27).then(t.bind(null,"o/VF"))},o=function(){return t.e(26).then(t.bind(null,"ZJxW"))},a=function(){return t.e(43).then(t.bind(null,"5iBL"))},u=function(){return t.e(40).then(t.bind(null,"1NW5"))},i=function(){return t.e(39).then(t.bind(null,"qG4m"))},s=function(){return t.e(32).then(t.bind(null,"WMKc"))},c=function(){return t.e(41).then(t.bind(null,"AmmI"))},l=function(){return t.e(30).then(t.bind(null,"IuOv"))},f=function(){return t.e(31).then(t.bind(null,"qhMN"))},d=function(){return t.e(38).then(t.bind(null,"8+7J"))},m=function(){return t.e(37).then(t.bind(null,"6Pzj"))},p=function(){return t.e(12).then(t.bind(null,"p/KA"))},h=function(){return t.e(28).then(t.bind(null,"wLKH"))},v=function(){return t.e(34).then(t.bind(null,"YxWH"))},b=function(){return t.e(15).then(t.bind(null,"bWgs"))},w=function(){return t.e(24).then(t.bind(null,"H7fU"))},g=function(){return t.e(0).then(t.bind(null,"nCc6"))};e.a=[{path:"/user",name:"user",meta:{keepAlive:!0},components:{default:r,tabbar:g}},{path:"/user/information",name:"user-information",component:o},{path:"/user/information/setbg",name:"user-info-setbg",component:a},{path:"/user/information/setMobile",name:"user-info-setMobile",component:u},{path:"/user/information/setNickname",name:"user-info-setNickname",component:i},{path:"/user/information/setAge",name:"user-info-setAge",component:c},{path:"/user/information/setArea",name:"user-info-setArea",component:l},{path:"/user/information/setBank",name:"user-info-setBank",component:f},{path:"/user/information/setPassword",name:"user-info-setPassword",component:s},{path:"/user/information/setQQ",name:"user-info-setQQ",component:d},{path:"/user/information/setWechat",name:"user-info-setWechat",component:m},{path:"/user/information/id",name:"user-info-id",component:p},{path:"/user/information/taobao",name:"user-info-taobao",component:h},{path:"/user/earnings/list",name:"user-earnings-list",component:v},{path:"/user/withdraw/list",name:"user-order-ele-list",component:b},{path:"/user/withdraw",name:"withdraw",component:w}]},FkOt:function(n,e,t){"use strict";var r={methods:{mixValid:function(){if(!this.$vuelidation.valid()){var n=this.$vuelidation.errors(),e=Object.keys(n)[0];return this.$toast(n[e][0]),!1}return!0}}};e.a={install:function(n){n.mixin(r)}}},GkzX:function(n,e,t){"use strict";var r=function(){return t.e(5).then(t.bind(null,"Rf88"))},o=function(){return t.e(4).then(t.bind(null,"55d8"))},a=function(){return t.e(22).then(t.bind(null,"xQ4s"))},u=function(){return t.e(21).then(t.bind(null,"goVv"))},i=function(){return t.e(33).then(t.bind(null,"u3hU"))},s=function(){return t.e(0).then(t.bind(null,"nCc6"))};e.a=[{path:"/message",name:"message",meta:{keepAlive:!0},components:{default:r,tabbar:s}},{path:"/message/notice-details/:id",name:"noticeViews",component:a,props:!0},{path:"/message/notice-list",name:"noticeList",components:{default:o,tabbar:s},props:!0},{path:"/message/work-details/:id",name:"workViews",component:u,props:!0},{path:"/message/work-edit",name:"workEdit",component:i,props:!0}]},HtrO:function(n,e,t){"use strict";var r=function(){return t.e(14).then(t.bind(null,"GQSW"))},o=function(){return t.e(11).then(t.bind(null,"nGws"))},a=function(){return t.e(10).then(t.bind(null,"xRwC"))},u=function(){return t.e(8).then(t.bind(null,"thUO"))},i=function(){return t.e(19).then(t.bind(null,"RIlR"))},s=function(){return t.e(42).then(t.bind(null,"P3MI"))},c=function(){return t.e(0).then(t.bind(null,"nCc6"))},l=function(){return t.e(18).then(t.bind(null,"K5MM"))};e.a=[{path:"/orders",name:"orders",meta:{keepAlive:!0},components:{default:r,tabbar:c}},{path:"/order/sales-details/:id",name:"salesDetails",component:o,props:!0},{path:"/order/view-details/:id",name:"viewDetails",component:a,props:!0},{path:"/items/task-status/:status/:taskId/:redirect/:details",name:"task-status",props:!0,component:s},{path:"/order/comment/:id",name:"comment",component:u,props:!0},{path:"/order/chase-com/:id",name:"chase-com",component:i,props:!0},{path:"/order/collectUpload/:id",name:"collectUpload",component:l,props:!0}]},"Jw+o":function(n,e,t){"use strict";var r=function(){return t.e(7).then(t.bind(null,"KR8f"))},o=function(){return t.e(36).then(t.bind(null,"R+aU"))},a=function(){return t.e(0).then(t.bind(null,"nCc6"))},u=function(){return t.e(23).then(t.bind(null,"YzbF"))},i=function(){return t.e(44).then(t.bind(null,"4IBH"))};e.a=[{path:"/",name:"index",components:{default:r,tabbar:a},meta:{keepAlive:!0}},{path:"/home/notice",name:"notice",component:o},{path:"/home/invite",name:"invite",component:u},{path:"/home/wxerror",name:"wxerror",component:i,meta:{notLogin:!0}}]},LOkV:function(n,e,t){"use strict";var r=function(){for(var n=arguments.length,e=Array(n),t=0;t<n;t++)e[t]=arguments[t];var r={},o=!0,a=!1,u=void 0;try{for(var i,s=e[Symbol.iterator]();!(o=(i=s.next()).done);o=!0){var c=i.value;r[c]=window.localStorage.getItem(c)||""}}catch(n){a=!0,u=n}finally{try{!o&&s.return&&s.return()}finally{if(a)throw u}}return r},o=function(n){for(var e in n)window.localStorage.setItem(e,n[e])},a=function(){for(var n=arguments.length,e=Array(n),t=0;t<n;t++)e[t]=arguments[t];var r=!0,o=!1,a=void 0;try{for(var u,i=e[Symbol.iterator]();!(r=(u=i.next()).done);r=!0){var s=u.value;window.localStorage.removeItem(s)}}catch(n){o=!0,a=n}finally{try{!r&&i.return&&i.return()}finally{if(o)throw a}}},u=function(n,e,t){var r=void 0,o=void 0,a=void 0,u=void 0,i=void 0;return function(){a=this,o=arguments,u=new Date;var t=function t(){var s=new Date-u;s<e?r=setTimeout(t,e-s):(r=null,i=n.apply(a,o))};return r||(r=setTimeout(t,e)),i}},i=function(n,e,t){var r,o,a,u,i=0;t||(t={});var s=function(){i=!1===t.leading?0:new Date,r=null,u=n.apply(o,a),r||(o=a=null)},c=function(){var c=new Date;i||!1!==t.leading||(i=c);var l=e-(c-i);return o=this,a=arguments,l<=0||l>e?(r&&(clearTimeout(r),r=null),i=c,u=n.apply(o,a),r||(o=a=null)):r||!1===t.trailing||(r=setTimeout(s,l)),u};return c.cancel=function(){clearTimeout(r),i=0,r=o=a=null},c},s=function(n){var e=new RegExp("(^|&)"+n+"=([^&]*)(&|$)"),t=window.location.search.substr(1).match(e);return null!=t?decodeURIComponent(t[2]):""};e.a={install:function(n){Object.defineProperties(n.prototype,{$util:{value:{getLocalStorage:r,setLocalStorage:o,removeLocalStorage:a,getLocationParam:s,debounce:u,throttle:i}}})}}},LtSP:function(n,e,t){"use strict";var r=t("MHRi"),o=(t.n(r),t("6xqC")),a=t.n(o),u=t("GKy3"),i=(t.n(u),t("4vvA")),s=t.n(i),c=t("mtWM"),l=t.n(c),f=t("mw3O"),d=(t.n(f),t("/nV0")),m=Object.assign||function(n){for(var e=1;e<arguments.length;e++){var t=arguments[e];for(var r in t)Object.prototype.hasOwnProperty.call(t,r)&&(n[r]=t[r])}return n},p=l.a.create({timeout:6e4,baseURL:"http://dt.kejic.net/"});p.interceptors.request.use(function(n){!n.hideLoading&&s.a.loading({mask:!0,duration:0});var e=localStorage.token;return e&&(n.headers["Auth-Token"]=e),n},function(n){return Promise.reject(n)}),p.interceptors.response.use(function(n){return s.a.clear(),n},function(n){if(s.a.clear(),n&&n.response)switch(n.response.status){case 400:var e=n.response.data.msg,t=n.response.data.code;40014===t?a.a.alert({title:"提示",message:"当前进行中的任务太多了，请完成之后，再接任务哦~！\n              （签收、确认收货并好评收到佣金之后，即算完成任务哦！没有物流信息的，请发货后5天后再签收、确认收货）"}):50020===t?a.a.alert({title:"提示",message:"请在tb付款后再点击【确认付款】；若失败，请刷新页面再尝试即可。（付款的订单号必须和提交的订单号相同）"}):50021===t?a.a.alert({title:"提示",message:"请物流签收并在 tb收货 之后，再来点击【确认收货】按钮哦~！（没有物流信息的，请发货后5天后再收货）"}):s.a.fail(e),10001===n.response.data.code&&setTimeout(function(){localStorage.removeItem("token"),d.a.push({path:"login"})},500);break;case 500:s.a.fail("抱歉，服务端异常");break;default:s.a.fail("未知错误！！")}return Promise.reject(n)});var h=function(n,e){var t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};return p.post(n,e,t)},v=function(n,e){var t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};return p.put(n,e,t)},b=function(n,e){var t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};return p.get(n,m({params:e},t))},w=function(n){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return p(m({url:n,method:"delete"},e))};e.a={install:function(n){Object.defineProperties(n.prototype,{$reqGet:{value:b},$reqPost:{value:h},$reqPut:{value:v},$reqDel:{value:w}})}}},M93x:function(n,e,t){"use strict";function r(n){t("1fAN")}var o=t("zEjG"),a=t("VU/8"),u=r,i=a(null,o.a,!1,u,null,null);e.a=i.exports},NHnr:function(n,e,t){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=t("GKy3"),o=(t.n(r),t("4vvA")),a=t.n(o),u=t("yZCJ"),i=(t.n(u),t("OjEV")),s=t.n(i),c=t("YaUx"),l=(t.n(c),t("kj6/")),f=t.n(l),d=t("6dbz"),m=(t.n(d),t("9MkJ")),p=t.n(m),h=t("tcuZ"),v=(t.n(h),t("iMPx")),b=t.n(v),w=t("Mcfu"),g=(t.n(w),t("r9aq")),k=t.n(g),y=t("uTM9"),A=(t.n(y),t("Jq84")),j=t.n(A),L=t("tLo2"),S=(t.n(L),t("blRl")),O=t.n(S),x=t("FDxC"),I=(t.n(x),t("w+oK")),V=t.n(I),M=t("jydU"),P=(t.n(M),t("WQwN")),W=t.n(P),C=t("wvM5"),U=(t.n(C),t("MyDk")),q=t.n(U),G=t("QP/A"),J=(t.n(G),t("pyxX")),z=t.n(J),Y=t("cnGM"),_=(t.n(Y),t("S6j6")),N=t.n(_),R=t("2PSJ"),T=(t.n(R),t("A9fu")),$=t.n(T),H=t("ORyp"),B=(t.n(H),t("3p6b")),D=t.n(B),E=t("ptjA"),Q=(t.n(E),t("Jj8k")),F=t.n(Q),K=t("9mmO"),X=(t.n(K),t("52Wt")),Z=(t.n(X),t("TFWu")),nn=(t.n(Z),t("MyjO")),en=(t.n(nn),t("qtRy")),tn=(t.n(en),t("THnP")),rn=(t.n(tn),t("K0JP")),on=(t.n(rn),t("NfZy")),an=(t.n(on),t("dTzs")),un=(t.n(an),t("+vXH")),sn=(t.n(un),t("MsuQ")),cn=(t.n(sn),t("dSUw")),ln=(t.n(cn),t("ZDXm")),fn=(t.n(ln),t("V/H1")),dn=(t.n(fn),t("CVR+")),mn=(t.n(dn),t("vmSu")),pn=(t.n(mn),t("4ZU1")),hn=(t.n(pn),t("yx1U")),vn=(t.n(hn),t("SPtU")),bn=(t.n(vn),t("A52B")),wn=(t.n(bn),t("PuTd")),gn=(t.n(wn),t("dm+7")),kn=(t.n(gn),t("JG34")),yn=(t.n(kn),t("Rw4K")),An=(t.n(yn),t("9mGU")),jn=(t.n(An),t("bUY0")),Ln=(t.n(jn),t("mTp7")),Sn=(t.n(Ln),t("y9m4")),On=(t.n(Sn),t("A0n/")),xn=(t.n(On),t("VTn2")),In=(t.n(xn),t("W/IU")),Vn=(t.n(In),t("Y5ex")),Mn=(t.n(Vn),t("WpPb")),Pn=(t.n(Mn),t("+yjc")),Wn=(t.n(Pn),t("gPva")),Cn=(t.n(Wn),t("C+4B")),Un=(t.n(Cn),t("W4Z6")),qn=(t.n(Un),t("tJwI")),Gn=(t.n(qn),t("eC2H")),Jn=(t.n(Gn),t("n12u")),zn=(t.n(Jn),t("nRs1")),Yn=(t.n(zn),t("jrHM")),_n=(t.n(Yn),t("EuXz")),Nn=(t.n(_n),t("F3sI")),Rn=(t.n(Nn),t("bqOW")),Tn=(t.n(Rn),t("Racj")),$n=(t.n(Tn),t("tqSY")),Hn=(t.n($n),t("CvWX")),Bn=(t.n(Hn),t("Y1S0")),Dn=(t.n(Bn),t("Gh7F")),En=(t.n(Dn),t("pd+2")),Qn=(t.n(En),t("MfeA")),Fn=(t.n(Qn),t("VjuZ")),Kn=(t.n(Fn),t("mJx5")),Xn=(t.n(Kn),t("qwQ3")),Zn=(t.n(Xn),t("beEN")),ne=(t.n(Zn),t("xMpm")),ee=(t.n(ne),t("9vc3")),te=(t.n(ee),t("WpTh")),re=(t.n(te),t("U6qc")),oe=(t.n(re),t("No4x")),ae=(t.n(oe),t("WgSQ")),ue=(t.n(ae),t("yuXV")),ie=(t.n(ue),t("XtiL")),se=(t.n(ie),t("A1ng")),ce=(t.n(se),t("LG56")),le=(t.n(ce),t("Stuz")),fe=(t.n(le),t("aJ2J")),de=(t.n(fe),t("WiIn")),me=(t.n(de),t("v2lb")),pe=(t.n(me),t("7Jvp")),he=(t.n(pe),t("lyhN")),ve=(t.n(he),t("kBOG")),be=(t.n(ve),t("xONB")),we=(t.n(be),t("LlNE")),ge=(t.n(we),t("9xIj")),ke=(t.n(ge),t("m6Yj")),ye=(t.n(ke),t("wrs0")),Ae=(t.n(ye),t("Lqg1")),je=(t.n(Ae),t("pWGb")),Le=(t.n(je),t("1ip3")),Se=(t.n(Le),t("N4KQ")),Oe=(t.n(Se),t("Hl+4")),xe=(t.n(Oe),t("MjHD")),Ie=(t.n(xe),t("SRCy")),Ve=(t.n(Ie),t("H0mh")),Me=(t.n(Ve),t("gbyG")),Pe=(t.n(Me),t("YVn/")),We=(t.n(Pe),t("FKfb")),Ce=(t.n(We),t("zmx7")),Ue=(t.n(Ce),t("smQ+")),qe=(t.n(Ue),t("m8F4")),Ge=(t.n(qe),t("v8VU")),Je=(t.n(Ge),t("dich")),ze=(t.n(Je),t("fx22")),Ye=(t.n(ze),t("SldL")),_e=(t.n(Ye),t("z2xj")),Ne=(t.n(_e),t("7+uW")),Re=t("M93x"),Te=t("/nV0"),$e=t("W6q6"),He=t("FkOt"),Be=t("Ows0"),De=t("wvfG"),Ee=t.n(De),Qe=t("LtSP"),Fe=t("LOkV"),Ke=t("WWGC"),Xe=t("3U+z"),Ze=t("2Ium");Ne.default.use(Ee.a);navigator.userAgent.toLowerCase();Ne.default.use(Be.a),Ne.default.use(Qe.a),Ne.default.use($e.a),Ne.default.use(He.a),Ne.default.use(Ze.a),Ne.default.use(Xe.a),Ne.default.use(Fe.a),Ne.default.use(Ke.a),Ne.default.use(F.a),Ne.default.use(D.a,{preLoad:1.3,error:"/static/img/goods_default.png",loading:"/static/img/goods_default.png",attempt:1,listenEvents:["scroll"],lazyComponent:!0}),Ne.default.use($.a),Ne.default.use(N.a),Ne.default.use(z.a),Ne.default.use(q.a),Ne.default.use(W.a),Ne.default.use(V.a),Ne.default.use(O.a),Ne.default.use(j.a),Ne.default.use(k.a),Ne.default.use(b.a),Ne.default.use(f.a).use(p.a),Ne.default.use(s.a),a.a.setDefaultOptions({duration:1500}),new Ne.default({el:"#app",router:Te.a,render:function(n){return n(Re.a)}})},Ows0:function(n,e,t){"use strict";var r=t("+ikV"),o=t.n(r);e.a={install:function(n){n.component("countdown",o.a)}}},Q3je:function(n,e,t){"use strict";t.d(e,"g",function(){return r}),t.d(e,"c",function(){return o}),t.d(e,"d",function(){return a}),t.d(e,"a",function(){return u}),t.d(e,"b",function(){return i}),t.d(e,"h",function(){return s}),t.d(e,"e",function(){return c}),t.d(e,"i",function(){return l}),t.d(e,"j",function(){return f}),t.d(e,"k",function(){return d}),t.d(e,"f",function(){return m});var r="task/taskList",o="task/taskView",a="task/subTaskOrder",u="task/orderView",i="task/updateOrderInfo",s="task/sales/",c="task/sales/list",l="task/comments/",f="task/validShop",d="task/cancel",m="task/delivery"},SshP:function(n,e,t){"use strict";var r=function(){return t.e(17).then(t.bind(null,"4KEO"))},o=function(){return t.e(6).then(t.bind(null,"6URT"))},a=function(){return t.e(20).then(t.bind(null,"uBXe"))},u=function(){return t.e(0).then(t.bind(null,"nCc6"))},i=function(){return t.e(13).then(t.bind(null,"57K6"))};e.a=[{path:"/task",name:"tasks",meta:{keepAlive:!0},components:{default:r,tabbar:u}},{path:"/task/tasks-details/:id",name:"taskViews",component:o,props:!0},{path:"/task/order-details/:id",name:"orderViews",component:a,props:!0},{path:"/task/tasks-details/:id",name:"uploadNew",component:i,props:!0}]},W6q6:function(n,e,t){"use strict";var r=t("ByX0"),o=t.n(r);r.defaultOptions.methods={mobile:function(n,e){return[/^1[0-9]{10}$/.test(n),"请填入正确的手机号码"]}},e.a=o.a},WWGC:function(n,e,t){"use strict";var r=t("GKy3"),o=(t.n(r),t("4vvA")),a=(t.n(o),t("vMJZ")),u=t("Q3je"),i=(t("LOkV"),t("7+uW")),s=this,c=function(n){i.default.prototype.$reqGet(u.g).then(function(e){l(e,n)}).catch(function(e){l(e,n)})},l=function(n,e){if(n.data&&0==n.data.code){e(n.data.data.comments,n.data.data.sales)}},f=function(n){i.default.prototype.$reqGet(a.D).then(function(e){if(10==e.data.code)return window.localStorage.removeItem("token"),window.localStorage.removeItem("account"),window.localStorage.removeItem("name"),window.localStorage.removeItem("first_leader"),window.localStorage.removeItem("superior_id"),window.localStorage.removeItem("superior_name"),window.localStorage.removeItem("invite_auth"),void s.$router.push({name:"login"});e.data&&0==e.data.code&&n(e.data.data)}).catch(function(e){e.data&&0==e.data.code&&n(e.data.data)})};e.a={install:function(n){Object.defineProperties(n.prototype,{$user:{value:{getTaskList:c,getUserInfo:f}}})}}},XqYu:function(n,e){},"Y/Gm":function(n,e){},YAYC:function(n,e){},"Z+4s":function(n,e){},ae3s:function(n,e,t){"use strict";var r=function(){return t.e(1).then(t.bind(null,"b8lP"))},o=function(){return t.e(0).then(t.bind(null,"nCc6"))};e.a=[{path:"/review",name:"review",meta:{keepAlive:!0},components:{default:r,tabbar:o}}]},eq3C:function(n,e,t){"use strict";var r=function(){return t.e(16).then(t.bind(null,"W2Q3"))},o=function(){return t.e(9).then(t.bind(null,"8dlf"))},a=function(){return t.e(29).then(t.bind(null,"1owN"))},u=function(){return t.e(25).then(t.bind(null,"+VIY"))},i=function(){return t.e(3).then(t.bind(null,"Y6EY"))},s=function(){return t.e(35).then(t.bind(null,"xYVd"))};e.a=[{path:"/login",name:"login",component:r,meta:{notLogin:!0}},{path:"/login/bindInfo",name:"bindInfo",props:!0,component:o,meta:{notLogin:!0}},{path:"/login/regByOrder",name:"regByOrder",props:!0,component:a,meta:{notLogin:!0}},{path:"/login/shops",name:"shops",props:!0,component:u,meta:{notLogin:!0}},{path:"/login/invite/:invite_code/:auth_time/:auth_code",name:"regInvite",component:i,props:!0,meta:{notLogin:!0}},{path:"/login/follow",name:"follow",component:s,meta:{notLogin:!0}}]},hSFT:function(n,e){},i11s:function(n,e,t){"use strict";var r=function(){return t.e(1).then(t.bind(null,"Xmjn"))},o=function(){return t.e(0).then(t.bind(null,"nCc6"))};e.a=[{path:"/history",name:"history",meta:{keepAlive:!0},components:{default:r,tabbar:o}}]},jLuM:function(n,e){},oFBU:function(n,e){},tsur:function(n,e,t){function r(n){return t(o(n))}function o(n){var e=a[n];if(!(e+1))throw new Error("Cannot find module '"+n+"'.");return e}var a={"./zh-cn":"Vz2w","./zh-cn.js":"Vz2w"};r.keys=function(){return Object.keys(a)},r.resolve=o,n.exports=r,r.id="tsur"},vMJZ:function(n,e,t){"use strict";t.d(e,"p",function(){return r}),t.d(e,"x",function(){return o}),t.d(e,"D",function(){return a}),t.d(e,"q",function(){return u}),t.d(e,"r",function(){return i}),t.d(e,"g",function(){return s}),t.d(e,"z",function(){return c}),t.d(e,"w",function(){return l}),t.d(e,"y",function(){return f}),t.d(e,"e",function(){return d}),t.d(e,"b",function(){return m}),t.d(e,"a",function(){return p}),t.d(e,"d",function(){return h}),t.d(e,"c",function(){return v}),t.d(e,"v",function(){return b}),t.d(e,"i",function(){return w}),t.d(e,"m",function(){return g}),t.d(e,"t",function(){return k}),t.d(e,"u",function(){return y}),t.d(e,"f",function(){return A}),t.d(e,"s",function(){return j}),t.d(e,"B",function(){return L}),t.d(e,"C",function(){return S}),t.d(e,"n",function(){return O}),t.d(e,"j",function(){return x}),t.d(e,"o",function(){return I}),t.d(e,"A",function(){return V}),t.d(e,"k",function(){return M}),t.d(e,"l",function(){return P}),t.d(e,"h",function(){return W});var r="user/login",o="user/logout",a="user/getUserInfo",u="user/withdraw",i="user/withdrawList",s="user/profile",c="user/update/info",l="user/upPassword",f="user/update/mobile",d="user/workList",m="user/workView",p="user/workEdit",h="user/noticeList",v="user/noticeView",b="user/bindBank",w="common/sendcode",g="user/register",k="user/taobao",y="user/card",A="user/friends",j="user/earnings/list",L="common/notices",S="common/noticesStatus",O="user/shoplist",x="user/verifyOrder",I="user/registerVerify",V="user/conf",M="common/conf",P="user/verifyInvite",W="user/reviews"},ws3L:function(n,e,t){"use strict";var r=function(){return t.e(2).then(t.bind(null,"JoaB"))},o=function(){return t.e(2).then(t.bind(null,"9y8k"))},a=function(){return t.e(0).then(t.bind(null,"nCc6"))};e.a=[{path:"/team",name:"team",meta:{keepAlive:!0},components:{default:r,tabbar:a}},{path:"/team/invitation",name:"invitation",meta:{keepAlive:!0},component:o}]},yggM:function(n,e){},z2xj:function(n,e){},zEjG:function(n,e,t){"use strict";var r=function(){var n=this,e=n.$createElement,t=n._self._c||e;return t("div",{attrs:{id:"app"}},[t("keep-alive",[n.$route.meta.keepAlive?t("router-view",{staticClass:"view-router"}):n._e()],1),n._v(" "),n.$route.meta.keepAlive?n._e():t("router-view",{staticClass:"view-router"}),n._v(" "),t("router-view",{attrs:{name:"tabbar"}})],1)},o=[],a={render:r,staticRenderFns:o};e.a=a}},["NHnr"]);
//# sourceMappingURL=app.26a251a4c230d94718d0.js.map