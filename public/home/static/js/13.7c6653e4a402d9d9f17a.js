webpackJsonp([13],{"24wo":function(t,e,a){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}e.__esModule=!0;var i=a("ArwO"),o=n(i),s=a("pNwR"),r=n(s);e.default=(0,o.default)({render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{class:t.b()},[a("div",{class:t.b("track"),style:t.trackStyle,on:{touchstart:t.onTouchStart,touchmove:t.onTouchMove,touchend:t.onTouchEnd,touchcancel:t.onTouchEnd,transitionend:function(e){t.$emit("change",t.activeIndicator)}}},[t._t("default")],2),t.showIndicators&&t.count>1?a("div",{class:t.b("indicators",{vertical:t.vertical})},t._l(t.count,function(e){return a("i",{class:t.b("indicator",{active:e-1===t.activeIndicator})})})):t._e()])},name:"swipe",mixins:[r.default],props:{autoplay:Number,vertical:Boolean,loop:{type:Boolean,default:!0},touchable:{type:Boolean,default:!0},initialSwipe:{type:Number,default:0},showIndicators:{type:Boolean,default:!0},duration:{type:Number,default:500}},data:function(){return{width:0,height:0,offset:0,active:0,deltaX:0,deltaY:0,swipes:[],swiping:!1}},mounted:function(){this.initialize()},destroyed:function(){this.clear()},watch:{swipes:function(){this.initialize()},initialSwipe:function(){this.initialize()},autoplay:function(t){t||this.clear()}},computed:{count:function(){return this.swipes.length},delta:function(){return this.vertical?this.deltaY:this.deltaX},size:function(){return this[this.vertical?"height":"width"]},trackSize:function(){return this.count*this.size},activeIndicator:function(){return(this.active+this.count)%this.count},trackStyle:function(){var t;return t={},t[this.vertical?"height":"width"]=this.trackSize+"px",t.transitionDuration=(this.swiping?0:this.duration)+"ms",t.transform="translate"+(this.vertical?"Y":"X")+"("+this.offset+"px)",t}},methods:{initialize:function(){if(clearTimeout(this.timer),this.$el){var t=this.$el.getBoundingClientRect();this.width=t.width,this.height=t.height}this.swiping=!0,this.active=this.initialSwipe,this.offset=this.count>1?-this.size*this.active:0,this.swipes.forEach(function(t){t.offset=0}),this.autoPlay()},onTouchStart:function(t){this.touchable&&(this.clear(),this.swiping=!0,this.touchStart(t),this.correctPosition())},onTouchMove:function(t){this.touchable&&(this.touchMove(t),(this.vertical&&"vertical"===this.direction||"horizontal"===this.direction)&&(t.preventDefault(),t.stopPropagation()),this.move(0,Math.min(Math.max(this.delta,-this.size),this.size)))},onTouchEnd:function(){if(this.touchable){if(this.delta){var t=this.vertical?this.offsetY:this.offsetX;this.move(t>50?this.delta>0?-1:1:0),this.swiping=!1}this.autoPlay()}},move:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0,a=this.delta,n=this.active,i=this.count,o=this.swipes,s=this.trackSize,r=0===n,c=n===i-1;!this.loop&&(r&&(e>0||t<0)||c&&(e<0||t>0))||i<=1||(t?(-1===n&&(o[i-1].offset=0),o[0].offset=c&&t>0?s:0,this.active+=t):r?o[i-1].offset=a>0?-s:0:c&&(o[0].offset=a<0?s:0),this.offset=e-this.active*this.size)},correctPosition:function(){this.active<=-1&&this.move(this.count),this.active>=this.count&&this.move(-this.count)},clear:function(){clearTimeout(this.timer)},autoPlay:function(){var t=this,e=this.autoplay;e&&this.count>1&&(this.clear(),this.timer=setTimeout(function(){t.swiping=!0,t.correctPosition(),setTimeout(function(){t.swiping=!1,t.move(1),t.autoPlay()},30)},e))}}})},"4m/J":function(t,e,a){t.exports=a.p+"static/img/img05.5cdc03d.png"},"5MoP":function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".task-countdown[data-v-59abcdf6]{text-align:center;font-size:12px;background-color:#fffeec;position:fixed;top:0;width:100%;height:30px;line-height:30px;z-index:999}.pay_submit[data-v-59abcdf6]{width:100%}.cannel_submit[data-v-59abcdf6]{margin-top:10px;width:100%}.pay_way_group[data-v-59abcdf6]{background-color:#fff;margin-bottom:10px}.pay_way_group img[data-v-59abcdf6]{vertical-align:middle}.pay_way_title[data-v-59abcdf6]{font-weight:700;padding:15px;background-color:#fff}.upload_hint[data-v-59abcdf6]{position:relative;padding-left:20px;line-height:1.6;margin:10px}.upload_hint i[data-v-59abcdf6]{position:absolute;top:2px;left:0}.vacancy_row .van-col[data-v-59abcdf6]{font-size:13px;line-height:30px;text-align:center;vertical-align:middle;margin-bottom:0;background-clip:content-box}.countdown[data-v-59abcdf6]{text-align:center;width:100%;height:50px;line-height:50px;border:0;border-radius:0;font-size:16px;color:#fff;background-color:#29a0f6}.van-cell__right-icon[data-v-59abcdf6]{top:3px}.text_style[data-v-59abcdf6]{color:#29a0f6}.text_red[data-v-59abcdf6],.text_style[data-v-59abcdf6]{font-size:12px;padding-left:15px;text-align:left;margin:0;padding-bottom:7px}.text_red[data-v-59abcdf6]{color:red}.no-longtap[data-v-59abcdf6]{-webkit-user-select:none;-o-user-select:none;user-select:none}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/src/views/order/sales-details/index.vue"],names:[],mappings:"AACA,iCACE,kBAAmB,AACnB,eAAgB,AAChB,yBAA0B,AAC1B,eAAgB,AAChB,MAAO,AACP,WAAY,AACZ,YAAa,AACb,iBAAkB,AAClB,WAAa,CACd,AACD,6BAGE,UAAY,CACb,AACD,gCACE,gBAAiB,AACjB,UAAY,CACb,AACD,gCACE,sBAA0B,AAC1B,kBAAoB,CACrB,AACD,oCACE,qBAAuB,CACxB,AACD,gCACE,gBAAkB,AAClB,aAAc,AACd,qBAAuB,CACxB,AACD,8BACE,kBAAmB,AACnB,kBAAmB,AACnB,gBAAiB,AACjB,WAAa,CACd,AACD,gCACI,kBAAmB,AACnB,QAAS,AACT,MAAQ,CACX,AACD,uCACE,eAAgB,AAChB,iBAAkB,AAClB,kBAAmB,AACnB,sBAAuB,AACvB,gBAAmB,AACnB,2BAA6B,CAC9B,AACD,4BACE,kBAAmB,AACnB,WAAY,AACZ,YAAa,AACb,iBAAkB,AAClB,SAAU,AACV,gBAAiB,AACjB,eAAgB,AAChB,WAAY,AACZ,wBAA0B,CAC3B,AACD,uCACE,OAAS,CACV,AACD,6BACE,aAAe,CAMhB,AACD,wDANE,eAAgB,AAChB,kBAAmB,AACnB,gBAAiB,AACjB,SAAU,AACV,kBAAoB,CASrB,AAPD,2BACE,SAAW,CAMZ,AACD,6BACE,yBAA0B,AAC1B,oBAAqB,AACrB,gBAAkB,CACnB",file:"index.vue",sourcesContent:["\n.task-countdown[data-v-59abcdf6] {\n  text-align: center;\n  font-size: 12px;\n  background-color: #fffeec;\n  position: fixed;\n  top: 0;\n  width: 100%;\n  height: 30px;\n  line-height: 30px;\n  z-index: 999;\n}\n.pay_submit[data-v-59abcdf6] {\n  /*position: fixed;*/\n  /*bottom: 0;*/\n  width: 100%;\n}\n.cannel_submit[data-v-59abcdf6] {\n  margin-top: 10px;\n  width: 100%;\n}\n.pay_way_group[data-v-59abcdf6] {\n  background-color: #ffffff;\n  margin-bottom: 10px;\n}\n.pay_way_group img[data-v-59abcdf6] {\n  vertical-align: middle;\n}\n.pay_way_title[data-v-59abcdf6] {\n  font-weight: bold;\n  padding: 15px;\n  background-color: #fff;\n}\n.upload_hint[data-v-59abcdf6] {\n  position: relative;\n  padding-left: 20px;\n  line-height: 1.6;\n  margin: 10px;\n}\n.upload_hint i[data-v-59abcdf6] {\n    position: absolute;\n    top: 2px;\n    left: 0;\n}\n.vacancy_row .van-col[data-v-59abcdf6] {\n  font-size: 13px;\n  line-height: 30px;\n  text-align: center;\n  vertical-align: middle;\n  margin-bottom: 0px;\n  background-clip: content-box;\n}\n.countdown[data-v-59abcdf6] {\n  text-align: center;\n  width: 100%;\n  height: 50px;\n  line-height: 50px;\n  border: 0;\n  border-radius: 0;\n  font-size: 16px;\n  color: #fff;\n  background-color: #29a0f6;\n}\n.van-cell__right-icon[data-v-59abcdf6] {\n  top: 3px;\n}\n.text_style[data-v-59abcdf6] {\n  color: #29a0f6;\n  font-size: 12px;\n  padding-left: 15px;\n  text-align: left;\n  margin: 0;\n  padding-bottom: 7px;\n}\n.text_red[data-v-59abcdf6] {\n  color: red;\n  font-size: 12px;\n  padding-left: 15px;\n  text-align: left;\n  margin: 0;\n  padding-bottom: 7px;\n}\n.no-longtap[data-v-59abcdf6] {\n  -webkit-user-select: none;\n  -o-user-select: none;\n  user-select: none;\n}\n"],sourceRoot:""}])},"8BoJ":function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"content"},[a("countdown",{staticClass:"task-countdown",attrs:{time:t.countdown},on:{countdownend:t.countdownend},scopedSlots:t._u([{key:"default",fn:function(e){return[a("van-icon",{attrs:{name:"hint"}}),t._v("任务将在"+t._s(e.hours||"00")+"小时"+t._s(+e.minutes||"00")+"分"+t._s(+e.seconds||"00")+"秒后到期")]}}])}),t._v(" "),a("div",{staticClass:"pay_way_group",staticStyle:{"margin-top":"30px"}},[a("div",{staticClass:"pay_way_title"},[t._v("销量任务")]),t._v(" "),a("van-cell-group",{staticClass:"payment_group"},[a("van-cell",{attrs:{title:"店铺名称"}},[t._v(t._s(t.salesTask.goods.shop_name))]),t._v(" "),a("van-cell",{staticStyle:{color:"red"}},[a("template",{slot:"title"},[a("span",{staticClass:"van-cell-text"},[t._v("关键字")]),t._v(" "),a("van-icon",{staticClass:"van-cell__right-icon",attrs:{slot:"right-icon",name:"question"},on:{click:function(e){t.showHelp(1)}},slot:"right-icon"})],1),t._v(" "),[a("span",{staticClass:"van-cell-text no-longtap",attrs:{onselectstart:"return false;",ontouchstart:"return false;"}},[t._v(t._s(t.salesTask.goods.key))])]],2),t._v(" "),a("van-cell",{attrs:{title:"宝贝单价"}},[t._v("\n        "+t._s(t.salesTask.goods.goods_price)+"\n      ")]),t._v(" "),a("van-cell",{attrs:{title:""}},[a("template",{slot:"title"},[a("span",{staticClass:"van-cell-text"},[t._v("宝贝数量")]),t._v(" "),a("van-icon",{staticClass:"van-cell__right-icon",attrs:{slot:"right-icon",name:"question"},on:{click:function(e){t.showHelp(2)}},slot:"right-icon"})],1),t._v("\n        "+t._s(t.salesTask.goods.num)+"\n      ")],2),t._v(" "),a("van-cell",{attrs:{title:""}},[a("template",{slot:"title"},[a("span",{staticClass:"van-cell-text"},[t._v("应付金额")]),t._v(" "),a("van-icon",{staticClass:"van-cell__right-icon",attrs:{slot:"right-icon",name:"question"},on:{click:function(e){t.showHelp(5)}},slot:"right-icon"})],1),t._v("\n        "+t._s(t._f("money")(t.salesTask.goods.goods_price*t.salesTask.goods.num))+"\n      ")],2),t._v(" "),a("van-cell",{attrs:{title:""}},[a("template",{slot:"title"},[a("span",{staticClass:"van-cell-text"},[t._v("商品主图")]),t._v(" "),a("van-icon",{staticClass:"van-cell__right-icon",attrs:{slot:"right-icon",name:"question"},on:{click:function(e){t.showHelp(3)}},slot:"right-icon"})],1)],2)],1),t._v(" "),a("img",{directives:[{name:"lazy",rawName:"v-lazy",value:t.salesTask.goods.main_img,expression:"salesTask.goods.main_img"}],attrs:{width:"100%"},on:{click:function(e){t.showImagePreview(t.salesTask.goods.main_img)}}})],1),t._v(" "),a("div",{staticClass:"pay_way_group"},[a("div",{staticClass:"pay_way_title"},[t._v("任务要求")]),t._v(" "),a("van-cell-group",{staticClass:"payment_group"},[a("van-cell",{attrs:{title:"地区"}},[t._v(t._s(t.salesTask.task.address))]),t._v(" "),a("van-cell",{attrs:{title:"价格区间"}},[t._v(t._s(t.salesTask.task.range))]),t._v(" "),a("van-cell",{attrs:{title:"浏览时间"}},[t._v(t._s(t.salesTask.task.browsing_time))]),t._v(" "),a("van-cell",{attrs:{title:"是否收藏"}},[t._v(t._s(t.salesTask.task.conllect))]),t._v(" "),a("van-cell",{attrs:{title:"加购物车"}},[t._v(t._s(t.salesTask.task.shopping_cart))]),t._v(" "),a("van-cell",{attrs:{title:"是否假聊"}},[t._v(t._s("是"==t.salesTask.task.chat?t.salesTask.task.chat_remark:"否"))]),t._v(" "),a("van-cell",{attrs:{title:"备注"}},[t._v(t._s(t.salesTask.task.remark||"无"))])],1)],1),t._v(" "),a("div",{staticClass:"pay_way_group"},[a("div",{staticClass:"pay_way_title"},[t._v("店铺验证")]),t._v(" "),a("van-cell-group",{staticClass:"payment_group"},[a("van-field",{attrs:{type:"text",placeholder:"请输入完整的店铺名进行验证",error:t.errorInfo.shopName},model:{value:t.shopName,callback:function(e){t.shopName=e},expression:"shopName"}},[a("van-button",{attrs:{slot:"button",size:"small",type:"primary"},on:{click:function(e){t.validShopName()}},slot:"button"},[t._v("验证店铺名称")])],1)],1)],1),t._v(" "),a("div",{staticClass:"pay_way_group"},[a("div",{staticClass:"pay_way_title"},[t._v("上传1个其他宝贝链接"),a("span",{staticStyle:{color:"darkred","margin-left":"5px"}},[t._v("如何获取宝贝链接")]),a("van-icon",{staticClass:"van-cell__right-icon",attrs:{slot:"right-icon",name:"question"},on:{click:function(e){t.showHelp(4)}},slot:"right-icon"})],1),t._v(" "),a("p",{staticClass:"text_style"},[t._v("\n      请花2-3分钟浏览2-3款其他店铺的宝贝，并上传1个宝贝的链接\n    ")]),t._v(" "),a("p",{staticClass:"text_red"},[t._v("\n      商家后台可检测，请浏览足够时间，时间不足将可能扣除此单佣金奖励\n    ")]),t._v(" "),a("van-cell-group",[a("van-field",{attrs:{type:"textarea",placeholder:"请输入宝贝链接或淘宝口令",error:t.errorInfo.others1},model:{value:t.others1,callback:function(e){t.others1=e},expression:"others1"}})],1)],1),t._v(" "),a("div",{staticClass:"pay_way_group"},[a("div",{staticClass:"pay_way_title"},[t._v("上传店内另一宝贝链接")]),t._v(" "),t._m(0),t._v(" "),a("p",{staticClass:"text_red"},[t._v("\n      商家后台可检测，请浏览足够时间，时间不足将可能扣除此单佣金奖励\n    ")]),t._v(" "),a("van-cell-group",{staticClass:"payment_group"},[a("van-field",{attrs:{type:"textarea",placeholder:"请输入宝贝链接或淘宝口令",error:t.errorInfo.theShop},model:{value:t.theShop,callback:function(e){t.theShop=e},expression:"theShop"}})],1)],1),t._v(" "),t.salesTask.pick_details.length>0?a("div",{staticClass:"pay_way_group",staticStyle:{"padding-bottom":"10px"}},[a("div",{staticClass:"pay_way_title"},[t._v("详情找茬")]),t._v(" "),a("van-row",{staticClass:"upload_hint text-desc"},[a("van-icon",{attrs:{name:"hint"}}),t._v("\n      详情找茬: 请在商品详情页中搜索以下文案出现的位置，复制开头/结尾中间的文本内容\n    ")],1),t._v(" "),t._l(t.salesTask.pick_details,function(e,n){return a("van-row",{key:n,staticClass:"vacancy_row"},[a("van-col",{attrs:{span:"8"}},[t._v(t._s(e.front))]),t._v(" "),a("van-col",{attrs:{span:"8"}},[a("input",{ref:"inputDetail"+n,refInFor:!0,staticClass:"van-field__control",attrs:{type:"text",placeholder:"请补充详情内容",pid:e.id}})]),t._v(" "),a("van-col",{attrs:{span:"8"}},[t._v(t._s(e.ending))])],1)})],2):t._e(),t._v(" "),t.salesTask.pick_comments.length>0?a("div",{staticClass:"pay_way_group",staticStyle:{"padding-bottom":"10px"}},[a("div",{staticClass:"pay_way_title"},[t._v("评论找茬")]),t._v(" "),a("van-row",{staticClass:"upload_hint text-desc"},[a("van-icon",{attrs:{name:"hint"}}),t._v("\n      评论找茬: 请在商品评论中查找以下评论的日期，格式：201806012530\n    ")],1),t._v(" "),t._l(t.salesTask.pick_comments,function(e,n){return a("van-row",{key:n,staticClass:"vacancy_row"},[a("van-col",{attrs:{span:"8"}},[t._v(t._s(e.comments))]),t._v(" "),a("van-col",{attrs:{span:"16"}},[a("input",{ref:"inputComment"+n,refInFor:!0,staticClass:"van-field__control",attrs:{type:"text",placeholder:"请输入评论日期",pid:e.id}})])],1)})],2):t._e(),t._v(" "),a("div",{staticClass:"pay_way_group"},[t._m(1),t._v(" "),1==t.orderType?a("p",{staticClass:"text_style"},[t._v("\n      请提交已拍下未付款的订单号进行审核；提交审核之后，管理员会在1小时内将宝贝款项打到您的银行卡中，收到款之后请立即付款\n    ")]):t._e(),t._v(" "),2==t.orderType?a("p",{staticClass:"text_style"},[t._v("\n      请提交已拍下未付款的订单号进行验证。"),a("br"),t._v("温馨提示：订单号能提交成功，就意味着您拍下的宝贝是正确的。\n    ")]):t._e(),t._v(" "),a("van-cell-group",{staticClass:"payment_group"},[a("van-field",{attrs:{type:"text",placeholder:"请输入您拍下的订单号",error:t.errorInfo.orderNo},model:{value:t.orderNo,callback:function(e){t.orderNo=e},expression:"orderNo"}})],1)],1),t._v(" "),a("div",{staticClass:"pay_way_group"},[t._m(2),t._v(" "),a("van-cell-group",{staticClass:"payment_group"},[a("van-field",{attrs:{type:"text",placeholder:"请输入淘宝实际付款金额"},model:{value:t.tbMoney,callback:function(e){t.tbMoney=e},expression:"tbMoney"}})],1)],1),t._v(" "),t.counting?a("countdown",{staticClass:"countdown van-button",attrs:{slot:"button",time:18e4},on:{countdownend:t.countdownend},slot:"button",scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(t._s(+e.minutes||"00")+"分"+t._s(+e.seconds||"00")+"秒后继续")]}}])}):a("van-button",{staticClass:"pay_submit",attrs:{loading:t.isSubmit,type:"danger","bottom-action":!0},on:{click:t.submit}},[t._v("提交审核\n  ")]),t._v(" "),a("van-button",{staticClass:"cannel_submit",attrs:{type:"default","bottom-action":!0},on:{click:t.cancel}},[t._v("关闭订单\n  ")])],1)},i=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("p",{staticClass:"text_style"},[t._v("\n      请花2-3分钟浏览主宝贝，并花1-2分钟浏览店铺里其他宝贝(副款)，"),a("br"),t._v("并上传1个副款宝贝的连接\n    ")])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"pay_way_title"},[t._v("订单验证:"),a("span",{staticStyle:{color:"darkred"}},[t._v("付款金额要在任务金额的±100内")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"pay_way_title"},[t._v("淘宝实际金额:"),a("span",{staticStyle:{color:"darkred"}})])}],o={render:n,staticRenderFns:i};e.a=o},"9B0/":function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".van-swipe{overflow:hidden;position:relative;-webkit-user-select:none;user-select:none}.van-swipe-item{float:left;height:100%}.van-swipe__track{height:100%}.van-swipe__indicators{display:-webkit-box;display:-webkit-flex;display:flex;position:absolute;left:50%;bottom:10px;-webkit-transform:translateX(-50%);transform:translateX(-50%)}.van-swipe__indicators--vertical{left:10px;top:50%;bottom:auto;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.van-swipe__indicators--vertical .van-swipe__indicator:not(:last-child){margin-bottom:6px}.van-swipe__indicator{border-radius:100%;background-color:#999;width:6px;height:6px}.van-swipe__indicator:not(:last-child){margin-right:6px}.van-swipe__indicator--active{background-color:#f60}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/node_modules/vant/lib/vant-css/swipe.css"],names:[],mappings:"AAAA,WAAW,gBAAgB,kBAAkB,yBAAyB,gBAAgB,CAAC,gBAAgB,WAAW,WAAW,CAAC,kBAAkB,WAAW,CAAC,uBAAuB,oBAAoB,qBAAqB,aAAa,kBAAkB,SAAS,YAAY,mCAAmC,0BAA0B,CAAC,iCAAiC,UAAU,QAAQ,YAAY,4BAA4B,6BAA6B,8BAA8B,sBAAsB,mCAAmC,0BAA0B,CAAC,wEAAwE,iBAAiB,CAAC,sBAAsB,mBAAmB,sBAAsB,UAAU,UAAU,CAAC,uCAAuC,gBAAgB,CAAC,8BAA8B,qBAAqB,CAAC",file:"swipe.css",sourcesContent:[".van-swipe{overflow:hidden;position:relative;-webkit-user-select:none;user-select:none}.van-swipe-item{float:left;height:100%}.van-swipe__track{height:100%}.van-swipe__indicators{display:-webkit-box;display:-webkit-flex;display:flex;position:absolute;left:50%;bottom:10px;-webkit-transform:translateX(-50%);transform:translateX(-50%)}.van-swipe__indicators--vertical{left:10px;top:50%;bottom:auto;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.van-swipe__indicators--vertical .van-swipe__indicator:not(:last-child){margin-bottom:6px}.van-swipe__indicator{border-radius:100%;background-color:#999;width:6px;height:6px}.van-swipe__indicator:not(:last-child){margin-right:6px}.van-swipe__indicator--active{background-color:#f60}"],sourceRoot:""}])},"9nkg":function(t,e,a){var n=a("9B0/");"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);a("rjj0")("a1cb1b4c",n,!0,{})},Fw7G:function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".van-col{float:left;box-sizing:border-box}.van-col-1{width:4.16667%}.van-col-offset-1{margin-left:4.16667%}.van-col-2{width:8.33333%}.van-col-offset-2{margin-left:8.33333%}.van-col-3{width:12.5%}.van-col-offset-3{margin-left:12.5%}.van-col-4{width:16.66667%}.van-col-offset-4{margin-left:16.66667%}.van-col-5{width:20.83333%}.van-col-offset-5{margin-left:20.83333%}.van-col-6{width:25%}.van-col-offset-6{margin-left:25%}.van-col-7{width:29.16667%}.van-col-offset-7{margin-left:29.16667%}.van-col-8{width:33.33333%}.van-col-offset-8{margin-left:33.33333%}.van-col-9{width:37.5%}.van-col-offset-9{margin-left:37.5%}.van-col-10{width:41.66667%}.van-col-offset-10{margin-left:41.66667%}.van-col-11{width:45.83333%}.van-col-offset-11{margin-left:45.83333%}.van-col-12{width:50%}.van-col-offset-12{margin-left:50%}.van-col-13{width:54.16667%}.van-col-offset-13{margin-left:54.16667%}.van-col-14{width:58.33333%}.van-col-offset-14{margin-left:58.33333%}.van-col-15{width:62.5%}.van-col-offset-15{margin-left:62.5%}.van-col-16{width:66.66667%}.van-col-offset-16{margin-left:66.66667%}.van-col-17{width:70.83333%}.van-col-offset-17{margin-left:70.83333%}.van-col-18{width:75%}.van-col-offset-18{margin-left:75%}.van-col-19{width:79.16667%}.van-col-offset-19{margin-left:79.16667%}.van-col-20{width:83.33333%}.van-col-offset-20{margin-left:83.33333%}.van-col-21{width:87.5%}.van-col-offset-21{margin-left:87.5%}.van-col-22{width:91.66667%}.van-col-offset-22{margin-left:91.66667%}.van-col-23{width:95.83333%}.van-col-offset-23{margin-left:95.83333%}.van-col-24{width:100%}.van-col-offset-24{margin-left:100%}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/node_modules/vant/lib/vant-css/col.css"],names:[],mappings:"AAAA,SAAS,WAAW,qBAAqB,CAAC,WAAW,cAAc,CAAC,kBAAkB,oBAAoB,CAAC,WAAW,cAAc,CAAC,kBAAkB,oBAAoB,CAAC,WAAW,WAAW,CAAC,kBAAkB,iBAAiB,CAAC,WAAW,eAAe,CAAC,kBAAkB,qBAAqB,CAAC,WAAW,eAAe,CAAC,kBAAkB,qBAAqB,CAAC,WAAW,SAAS,CAAC,kBAAkB,eAAe,CAAC,WAAW,eAAe,CAAC,kBAAkB,qBAAqB,CAAC,WAAW,eAAe,CAAC,kBAAkB,qBAAqB,CAAC,WAAW,WAAW,CAAC,kBAAkB,iBAAiB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,SAAS,CAAC,mBAAmB,eAAe,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,WAAW,CAAC,mBAAmB,iBAAiB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,SAAS,CAAC,mBAAmB,eAAe,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,WAAW,CAAC,mBAAmB,iBAAiB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,UAAU,CAAC,mBAAmB,gBAAgB,CAAC",file:"col.css",sourcesContent:[".van-col{float:left;box-sizing:border-box}.van-col-1{width:4.16667%}.van-col-offset-1{margin-left:4.16667%}.van-col-2{width:8.33333%}.van-col-offset-2{margin-left:8.33333%}.van-col-3{width:12.5%}.van-col-offset-3{margin-left:12.5%}.van-col-4{width:16.66667%}.van-col-offset-4{margin-left:16.66667%}.van-col-5{width:20.83333%}.van-col-offset-5{margin-left:20.83333%}.van-col-6{width:25%}.van-col-offset-6{margin-left:25%}.van-col-7{width:29.16667%}.van-col-offset-7{margin-left:29.16667%}.van-col-8{width:33.33333%}.van-col-offset-8{margin-left:33.33333%}.van-col-9{width:37.5%}.van-col-offset-9{margin-left:37.5%}.van-col-10{width:41.66667%}.van-col-offset-10{margin-left:41.66667%}.van-col-11{width:45.83333%}.van-col-offset-11{margin-left:45.83333%}.van-col-12{width:50%}.van-col-offset-12{margin-left:50%}.van-col-13{width:54.16667%}.van-col-offset-13{margin-left:54.16667%}.van-col-14{width:58.33333%}.van-col-offset-14{margin-left:58.33333%}.van-col-15{width:62.5%}.van-col-offset-15{margin-left:62.5%}.van-col-16{width:66.66667%}.van-col-offset-16{margin-left:66.66667%}.van-col-17{width:70.83333%}.van-col-offset-17{margin-left:70.83333%}.van-col-18{width:75%}.van-col-offset-18{margin-left:75%}.van-col-19{width:79.16667%}.van-col-offset-19{margin-left:79.16667%}.van-col-20{width:83.33333%}.van-col-offset-20{margin-left:83.33333%}.van-col-21{width:87.5%}.van-col-offset-21{margin-left:87.5%}.van-col-22{width:91.66667%}.van-col-offset-22{margin-left:91.66667%}.van-col-23{width:95.83333%}.van-col-offset-23{margin-left:95.83333%}.van-col-24{width:100%}.van-col-offset-24{margin-left:100%}"],sourceRoot:""}])},"Hn/3":function(t,e,a){var n=a("rJyx");"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);a("rjj0")("39850e4c",n,!0,{})},Jp9Q:function(t,e,a){t.exports=a.p+"static/img/img02.0385dd4.png"},LDUO:function(t,e,a){"use strict";function n(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}var i,o=a("wvM5"),s=(a.n(o),a("MyDk")),r=a.n(s),c=a("tcuZ"),l=(a.n(c),a("iMPx")),A=a.n(l),d=a("GKy3"),f=(a.n(d),a("4vvA")),u=a.n(f),v=a("i9vB"),p=(a.n(v),a("Mqtp")),h=a.n(p),m=a("FDxC"),g=(a.n(m),a("w+oK")),_=a.n(g),C=a("cnGM"),w=(a.n(C),a("S6j6")),B=a.n(w),b=a("QP/A"),x=(a.n(b),a("pyxX")),y=a.n(x),k=a("dKGA"),S=(a.n(k),a("kSul")),Y=a.n(S),q=a("jgNZ"),T=(a.n(q),a("syWm")),W=a.n(T),M=a("MHRi"),N=(a.n(M),a("6xqC")),E=a.n(N),D=a("Q3je"),z=a("YEAZ"),$=a.n(z),P=a("Jp9Q"),j=a.n(P),U=a("TSR/"),I=a.n(U),O=a("YU5H"),R=a.n(O),Z=a("4m/J"),F=a.n(Z),X=a("a1Kk"),H=a.n(X),J=a("Y372"),Q=a.n(J);e.a={name:"salesDetails",data:function(){return{isSubmit:!1,countdown:21e4,shopName:"",others1:"",theShop:"",tbMoney:"",orderNo:"",orderType:"",counting:!0,salesTask:{task:{id:"",type:"",overtime:"",conllect:"",shopping_cart:"",chat:"",screenshot_pay:"",screenshot_search:"",address:"",range:"",browsing_time:"",chat_remark:"",remark:"",status:"",othersExample:""},goods:{id:"",key:"",main_img:"",price:"",shop_name:""},pick_details:[{id:"",front:"",ending:"",answer:""}],pick_comments:[{id:"",comments:"",answer:""}]},errorInfo:{shopName:!1,others1:!1,theShop:!1,orderNo:!1}}},props:{id:this.id},watch:{$route:"changeRouter"},created:function(){this.initPage()},methods:{copytouch:function(t,e){t.preventDefault=!0,alert("不可复制")},initPage:function(){var t=this;this.id&&this.$reqGet(D.h+this.id).then(function(e){t.getSuccess(e)}).catch(function(e){t.getSuccess(e)})},getSuccess:function(t){var e=t.data;if(!e||0!=e.code){var a=e.msg?e.msg:"获取任务失败";return void u.a.fail(a)}var n=e.data;this.salesTask=n,this.orderType=n.task.order_type,this.countdown=this.salesTask.task.overtime},validShopName:function(){if(!this.shopName)return void u.a.fail("请输入店铺名称");this.$reqPost(D.j,{order_id:this.id,shop_name:this.shopName}).then(function(t){u()(t.data.msg)}).catch(function(t){u()(t.data.msg)})},submit:function(){var t=this,e=(this.salesTask.pick_details,!0);(e=["shopName","others1","theShop","orderNo"].every(function(e){var a=t.getErrorMessage(e);return a&&(t.errorInfo[e]=!0,u.a.fail(a)),!a}))||u.a.fail("参数错误");var a=new FormData;a.append("order_id",this.id),a.append("tb_order_id",this.orderNo),a.append("others1",this.others1),a.append("shopName",this.shopName),a.append("theShop",this.theShop),a.append("tbMoney",this.tbMoney),this.$reqPost(D.h,a).then(function(e){t.submitSuccess(e)}).catch(function(t){})},getErrorMessage:function(t){switch(t){case"shopName":return this.shopName?"":"请填写完整店铺名称";case"others1":return this.others1?"":"请上传3个其他店铺宝贝链接";case"theShop":return this.theShop?"":"请上传店内另一宝贝链接";case"orderNo":return this.orderNo?"":"请输入您拍下的订单号"}},submitSuccess:function(t){var e=this;t.data;if(1==this.orderType)var a='<p style="text-align: center;">订单号提交成功，商家会在1小时内将应付的金额转入您的银行卡中；请你收到款后尽快付款。</p>\n            <p style="color: darkred; text-align: center;">（请勿使用花呗或信用卡支付，否则将赔付商家1%手续费）</p>';if(2==this.orderType)var a='<p style="text-align: center;">订单号提交成功，请您前往手淘付款。</p>\n            <p style="color: darkred; text-align: center;">（如果您拍了多个订单号，请不要付款错误，任务提交的是哪个订单号，就付款哪个订单哦~）</p>\n            <p style="color:red;text-align:center">(请勿使用花呗或信用卡支付，否则将赔付商家1%手续费)</p>\n            ';E.a.alert({message:a}).then(function(){e.$router.push({path:"/orders"})}).catch(function(t){})},showImagePreview:function(t){h()([t])},countdownend:function(){this.counting=!1},cancel:function(){var t=this;E.a.confirm({title:"提示",message:"您确定要关闭订单吗？"}).then(function(){t.$reqPost(D.k,{order_id:t.id}).then(function(e){u()(e.data.msg),0==e.data.code&&t.$router.go(-1)}).catch(function(e){u()(e.data.msg),0==e.data.code&&t.$router.go(-1)})}).catch(function(){})},showHelp:function(t){switch(t){case 1:u()({message:"必须用指定的关键词来找到宝贝。如果找不到宝贝请联系微信客服求助",position:"top"});break;case 2:u()({message:"必须拍下指定件数，否则无法提交任务",position:"top"});break;case 3:u()({message:"请根据关键字找到和下图一样的宝贝",position:"top"});break;case 4:h()([$.a,j.a,I.a,R.a,F.a,H.a,Q.a]);break;case 5:u()({message:"应付金额=宝贝单价*宝贝数量（应付金额允许存在正负100的差价）",position:"top"})}}},components:(i={},n(i,W.a.name,W.a),n(i,Y.a.name,Y.a),n(i,y.a.name,y.a),n(i,B.a.name,B.a),n(i,_.a.name,_.a),n(i,h.a.name,h.a),n(i,u.a.name,u.a),n(i,A.a.name,A.a),n(i,r.a.name,r.a),i),filters:{money:function(t){t=t.toString().replace(/\$|\,/g,""),isNaN(t)&&(t="0");var e=t==(t=Math.abs(t));t=Math.floor(100*t+.50000000001);var a=t%100;t=Math.floor(t/100).toString(),a<10&&(a="0"+a);for(var n=0;n<Math.floor((t.length-(1+n))/3);n++)t=t.substring(0,t.length-(4*n+3))+","+t.substring(t.length-(4*n+3));return(e?"":"-")+t+"."+a}}}},Mqtp:function(t,e,a){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}e.__esModule=!0;var i=a("7+uW"),o=n(i),s=a("jNK6"),r=n(s),c=void 0,l=function(){c=new(o.default.extend(r.default))({el:document.createElement("div")}),document.body.appendChild(c.$el)},A=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0;return c||l(),c.images=t,c.startPosition=e,c.value=!0,c.$on("input",function(t){c.value=t}),c};A.install=function(){o.default.use(r.default)},e.default=A},"TSR/":function(t,e,a){t.exports=a.p+"static/img/img03.c49fc4c.png"},Y372:function(t,e,a){t.exports=a.p+"static/img/img07.7a40a4f.png"},YEAZ:function(t,e,a){t.exports=a.p+"static/img/img01.7b5af7a.png"},YU5H:function(t,e,a){t.exports=a.p+"static/img/img04.fce382e.png"},a1Kk:function(t,e,a){t.exports=a.p+"static/img/img06.10f6e8f.png"},beN6:function(t,e,a){"use strict";e.__esModule=!0;var n=a("ArwO"),i=function(t){return t&&t.__esModule?t:{default:t}}(n);e.default=(0,i.default)({render:function(){var t=this,e=t.$createElement;return(t._self._c||e)("div",{class:t.b(),style:t.style},[t._t("default")],2)},name:"swipe-item",data:function(){return{offset:0}},computed:{style:function(){var t=this.$parent,e=t.vertical,a=t.width,n=t.height;return{width:a+"px",height:e?n+"px":"100%",transform:"translate"+(e?"Y":"X")+"("+this.offset+"px)"}}},beforeCreate:function(){this.$parent.swipes.push(this)},destroyed:function(){this.$parent.swipes.splice(this.$parent.swipes.indexOf(this),1)}})},dKGA:function(t,e,a){a("xL5C"),a("qCSc")},i9vB:function(t,e,a){a("xL5C"),a("itIU"),a("9nkg"),a("Hn/3")},jNK6:function(t,e,a){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}e.__esModule=!0;var i=a("ArwO"),o=n(i),s=a("/4KT"),r=n(s),c=a("24wo"),l=n(c),A=a("beN6"),d=n(A);e.default=(0,o.default)({render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"show",rawName:"v-show",value:t.value,expression:"value"}],class:t.b(),on:{touchstart:t.onTouchStart,touchend:t.onTouchEnd,touchcancel:t.onTouchEnd}},[a("swipe",{ref:"swipe",attrs:{"initial-swipe":t.startPosition}},t._l(t.images,function(e,n){return a("swipe-item",{key:n},[a("img",{class:t.b("image"),attrs:{src:e}})])}))],1)},name:"image-preview",mixins:[r.default],components:{Swipe:l.default,SwipeItem:d.default},props:{overlay:{type:Boolean,default:!0},closeOnClickOverlay:{type:Boolean,default:!0}},data:function(){return{images:[],startPosition:0}},methods:{onTouchStart:function(){this.touchStartTime=new Date},onTouchEnd:function(t){t.preventDefault();var e=new Date-this.touchStartTime,a=this.$refs.swipe,n=a.offsetX,i=a.offsetY;e<500&&n<10&&i<10&&this.$emit("input",!1)}}})},jgNZ:function(t,e,a){a("xL5C"),a("qzWe")},kSul:function(t,e,a){"use strict";e.__esModule=!0;var n=a("ArwO"),i=function(t){return t&&t.__esModule?t:{default:t}}(n);e.default=(0,i.default)({render:function(){var t=this,e=t.$createElement;return(t._self._c||e)("div",{staticClass:"van-col",class:(a={},a["van-col-"+t.span]=t.span,a["van-col-offset-"+t.offset]=t.offset,a),style:t.style},[t._t("default")],2);var a},name:"col",props:{span:[Number,String],offset:[Number,String]},computed:{gutter:function(){return this.$parent&&Number(this.$parent.gutter)||0},style:function(){var t=this.gutter/2+"px";return this.gutter?{paddingLeft:t,paddingRight:t}:{}}}})},nGws:function(t,e,a){"use strict";function n(t){a("tVJu")}Object.defineProperty(e,"__esModule",{value:!0});var i=a("LDUO"),o=a("8BoJ"),s=a("VU/8"),r=n,c=s(i.a,o.a,!1,r,"data-v-59abcdf6",null);e.default=c.exports},qCSc:function(t,e,a){var n=a("Fw7G");"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);a("rjj0")("a2e656cc",n,!0,{})},qdwC:function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,'.van-row:after{content:"";display:table;clear:both}',"",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/node_modules/vant/lib/vant-css/row.css"],names:[],mappings:"AAAA,eAAe,WAAW,cAAc,UAAU,CAAC",file:"row.css",sourcesContent:['.van-row:after{content:"";display:table;clear:both}'],sourceRoot:""}])},qzWe:function(t,e,a){var n=a("qdwC");"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);a("rjj0")("38b70ada",n,!0,{})},rJyx:function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".van-image-preview{top:0;left:0;width:100%;height:100%;position:fixed}.van-image-preview__image{top:0;left:0;right:0;bottom:0;margin:auto;max-width:100%;max-height:100%;position:absolute}.van-image-preview .van-swipe{height:100%}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/node_modules/vant/lib/vant-css/image-preview.css"],names:[],mappings:"AAAA,mBAAmB,MAAM,OAAO,WAAW,YAAY,cAAc,CAAC,0BAA0B,MAAM,OAAO,QAAQ,SAAS,YAAY,eAAe,gBAAgB,iBAAiB,CAAC,8BAA8B,WAAW,CAAC",file:"image-preview.css",sourcesContent:[".van-image-preview{top:0;left:0;width:100%;height:100%;position:fixed}.van-image-preview__image{top:0;left:0;right:0;bottom:0;margin:auto;max-width:100%;max-height:100%;position:absolute}.van-image-preview .van-swipe{height:100%}"],sourceRoot:""}])},syWm:function(t,e,a){"use strict";e.__esModule=!0;var n=a("ArwO"),i=function(t){return t&&t.__esModule?t:{default:t}}(n);e.default=(0,i.default)({render:function(){var t=this,e=t.$createElement;return(t._self._c||e)("div",{class:t.b(),style:t.style},[t._t("default")],2)},name:"row",props:{gutter:{type:[Number,String],default:0}},computed:{style:function(){var t="-"+Number(this.gutter)/2+"px";return this.gutter?{marginLeft:t,marginRight:t}:{}}}})},tVJu:function(t,e,a){var n=a("5MoP");"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);a("rjj0")("e9f4f724",n,!0,{})}});
//# sourceMappingURL=13.7c6653e4a402d9d9f17a.js.map