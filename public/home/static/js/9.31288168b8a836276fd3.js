webpackJsonp([9],{"+PvC":function(t,e,a){"use strict";function i(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}var n,o=a("i9vB"),s=(a.n(o),a("Mqtp")),r=a.n(s),A=a("GKy3"),l=(a.n(A),a("4vvA")),c=a.n(l),d=a("MHRi"),f=(a.n(d),a("6xqC")),u=a.n(f),p=a("FDxC"),v=(a.n(p),a("w+oK")),m=a.n(v),h=a("cnGM"),C=(a.n(h),a("S6j6")),g=a.n(C),w=a("QP/A"),B=(a.n(w),a("pyxX")),_=a.n(B),b=a("dKGA"),x=(a.n(b),a("kSul")),k=a.n(x),y=a("jgNZ"),q=(a.n(y),a("syWm")),S=a.n(q),W=a("/kVe"),Y=a("Q3je");e.a={name:"Comments",components:(n={},i(n,S.a.name,S.a),i(n,k.a.name,k.a),i(n,_.a.name,_.a),i(n,g.a.name,g.a),i(n,m.a.name,m.a),i(n,W.a.name,W.a),i(n,c.a.name,c.a),i(n,r.a.name,r.a),n),props:{id:this.id},created:function(){this.initPage()},data:function(){return{isSubmit:!1,goods:[],task:[],files:"",demoImg:a("mU2b")}},methods:{initPage:function(){var t=this;if(!this.id)return void c.a.fail("参数错误");this.$reqGet(Y.h+this.id).then(function(e){t.getTaskBack(e)}).catch(function(e){t.getTaskBack(e)})},getTaskBack:function(t){var e=t.data;if(0!=e.code){var a=e&&e.msg?e.msg:"获取任务失败";return void c.a.fail(a)}var i=e.data;this.task=i.task,this.goods=i.goods},subComment:function(){var t=this,e=new FormData;e.append("order_id",this.id),this.isSubmit=!0,this.$reqPost(Y.i,e).then(function(e){t.commentBack(e)}).catch(function(e){t.commentBack(e)})},commentBack:function(t){var e=this;this.isSubmit=!1;var a=t.data;if(0!=a.code){var i=a&&a.msg?a.msg:"获取任务失败";return void c.a.fail(i)}var n=this.task.brokerage,o='<p style="text-align: center;">商家会再12小时内核对，超时会自动核对通过</p>\n      <p style="text-align: center;">核对通过之后，佣金'+n+'元即会充值到您的账号中，</p>\n      <p style="text-align: center;">届时您可以申请提现~！</p>';u.a.alert({title:"好评截图提交成功",message:o}).then(function(){e.$router.push({name:"orders",params:{source:1}})}).catch(function(t){})},onCopy:function(t){c()("复制成功")},onError:function(){c()("复制失败")},goBack:function(){this.$router.push({name:"orders",params:{source:1}})},showImagePreview:function(t){r()([t])},setFiles:function(t){console.log(t),this.files=t}}}},"/kVe":function(t,e,a){"use strict";function i(t){a("e9pW")}var n=a("aczI"),o=a("usIK"),s=a("VU/8"),r=i,A=s(n.a,o.a,!1,r,"data-v-4e6247a0",null);e.a=A.exports},"24wo":function(t,e,a){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}e.__esModule=!0;var n=a("ArwO"),o=i(n),s=a("pNwR"),r=i(s);e.default=(0,o.default)({render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{class:t.b()},[a("div",{class:t.b("track"),style:t.trackStyle,on:{touchstart:t.onTouchStart,touchmove:t.onTouchMove,touchend:t.onTouchEnd,touchcancel:t.onTouchEnd,transitionend:function(e){t.$emit("change",t.activeIndicator)}}},[t._t("default")],2),t.showIndicators&&t.count>1?a("div",{class:t.b("indicators",{vertical:t.vertical})},t._l(t.count,function(e){return a("i",{class:t.b("indicator",{active:e-1===t.activeIndicator})})})):t._e()])},name:"swipe",mixins:[r.default],props:{autoplay:Number,vertical:Boolean,loop:{type:Boolean,default:!0},touchable:{type:Boolean,default:!0},initialSwipe:{type:Number,default:0},showIndicators:{type:Boolean,default:!0},duration:{type:Number,default:500}},data:function(){return{width:0,height:0,offset:0,active:0,deltaX:0,deltaY:0,swipes:[],swiping:!1}},mounted:function(){this.initialize()},destroyed:function(){this.clear()},watch:{swipes:function(){this.initialize()},initialSwipe:function(){this.initialize()},autoplay:function(t){t||this.clear()}},computed:{count:function(){return this.swipes.length},delta:function(){return this.vertical?this.deltaY:this.deltaX},size:function(){return this[this.vertical?"height":"width"]},trackSize:function(){return this.count*this.size},activeIndicator:function(){return(this.active+this.count)%this.count},trackStyle:function(){var t;return t={},t[this.vertical?"height":"width"]=this.trackSize+"px",t.transitionDuration=(this.swiping?0:this.duration)+"ms",t.transform="translate"+(this.vertical?"Y":"X")+"("+this.offset+"px)",t}},methods:{initialize:function(){if(clearTimeout(this.timer),this.$el){var t=this.$el.getBoundingClientRect();this.width=t.width,this.height=t.height}this.swiping=!0,this.active=this.initialSwipe,this.offset=this.count>1?-this.size*this.active:0,this.swipes.forEach(function(t){t.offset=0}),this.autoPlay()},onTouchStart:function(t){this.touchable&&(this.clear(),this.swiping=!0,this.touchStart(t),this.correctPosition())},onTouchMove:function(t){this.touchable&&(this.touchMove(t),(this.vertical&&"vertical"===this.direction||"horizontal"===this.direction)&&(t.preventDefault(),t.stopPropagation()),this.move(0,Math.min(Math.max(this.delta,-this.size),this.size)))},onTouchEnd:function(){if(this.touchable){if(this.delta){var t=this.vertical?this.offsetY:this.offsetX;this.move(t>50?this.delta>0?-1:1:0),this.swiping=!1}this.autoPlay()}},move:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0,a=this.delta,i=this.active,n=this.count,o=this.swipes,s=this.trackSize,r=0===i,A=i===n-1;!this.loop&&(r&&(e>0||t<0)||A&&(e<0||t>0))||n<=1||(t?(-1===i&&(o[n-1].offset=0),o[0].offset=A&&t>0?s:0,this.active+=t):r?o[n-1].offset=a>0?-s:0:A&&(o[0].offset=a<0?s:0),this.offset=e-this.active*this.size)},correctPosition:function(){this.active<=-1&&this.move(this.count),this.active>=this.count&&this.move(-this.count)},clear:function(){clearTimeout(this.timer)},autoPlay:function(){var t=this,e=this.autoplay;e&&this.count>1&&(this.clear(),this.timer=setTimeout(function(){t.swiping=!0,t.correctPosition(),setTimeout(function(){t.swiping=!1,t.move(1),t.autoPlay()},30)},e))}}})},"9B0/":function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".van-swipe{overflow:hidden;position:relative;-webkit-user-select:none;user-select:none}.van-swipe-item{float:left;height:100%}.van-swipe__track{height:100%}.van-swipe__indicators{display:-webkit-box;display:-webkit-flex;display:flex;position:absolute;left:50%;bottom:10px;-webkit-transform:translateX(-50%);transform:translateX(-50%)}.van-swipe__indicators--vertical{left:10px;top:50%;bottom:auto;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.van-swipe__indicators--vertical .van-swipe__indicator:not(:last-child){margin-bottom:6px}.van-swipe__indicator{border-radius:100%;background-color:#999;width:6px;height:6px}.van-swipe__indicator:not(:last-child){margin-right:6px}.van-swipe__indicator--active{background-color:#f60}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/node_modules/vant/lib/vant-css/swipe.css"],names:[],mappings:"AAAA,WAAW,gBAAgB,kBAAkB,yBAAyB,gBAAgB,CAAC,gBAAgB,WAAW,WAAW,CAAC,kBAAkB,WAAW,CAAC,uBAAuB,oBAAoB,qBAAqB,aAAa,kBAAkB,SAAS,YAAY,mCAAmC,0BAA0B,CAAC,iCAAiC,UAAU,QAAQ,YAAY,4BAA4B,6BAA6B,8BAA8B,sBAAsB,mCAAmC,0BAA0B,CAAC,wEAAwE,iBAAiB,CAAC,sBAAsB,mBAAmB,sBAAsB,UAAU,UAAU,CAAC,uCAAuC,gBAAgB,CAAC,8BAA8B,qBAAqB,CAAC",file:"swipe.css",sourcesContent:[".van-swipe{overflow:hidden;position:relative;-webkit-user-select:none;user-select:none}.van-swipe-item{float:left;height:100%}.van-swipe__track{height:100%}.van-swipe__indicators{display:-webkit-box;display:-webkit-flex;display:flex;position:absolute;left:50%;bottom:10px;-webkit-transform:translateX(-50%);transform:translateX(-50%)}.van-swipe__indicators--vertical{left:10px;top:50%;bottom:auto;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.van-swipe__indicators--vertical .van-swipe__indicator:not(:last-child){margin-bottom:6px}.van-swipe__indicator{border-radius:100%;background-color:#999;width:6px;height:6px}.van-swipe__indicator:not(:last-child){margin-right:6px}.van-swipe__indicator--active{background-color:#f60}"],sourceRoot:""}])},"9nkg":function(t,e,a){var i=a("9B0/");"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);a("rjj0")("a1cb1b4c",i,!0,{})},Fw7G:function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".van-col{float:left;box-sizing:border-box}.van-col-1{width:4.16667%}.van-col-offset-1{margin-left:4.16667%}.van-col-2{width:8.33333%}.van-col-offset-2{margin-left:8.33333%}.van-col-3{width:12.5%}.van-col-offset-3{margin-left:12.5%}.van-col-4{width:16.66667%}.van-col-offset-4{margin-left:16.66667%}.van-col-5{width:20.83333%}.van-col-offset-5{margin-left:20.83333%}.van-col-6{width:25%}.van-col-offset-6{margin-left:25%}.van-col-7{width:29.16667%}.van-col-offset-7{margin-left:29.16667%}.van-col-8{width:33.33333%}.van-col-offset-8{margin-left:33.33333%}.van-col-9{width:37.5%}.van-col-offset-9{margin-left:37.5%}.van-col-10{width:41.66667%}.van-col-offset-10{margin-left:41.66667%}.van-col-11{width:45.83333%}.van-col-offset-11{margin-left:45.83333%}.van-col-12{width:50%}.van-col-offset-12{margin-left:50%}.van-col-13{width:54.16667%}.van-col-offset-13{margin-left:54.16667%}.van-col-14{width:58.33333%}.van-col-offset-14{margin-left:58.33333%}.van-col-15{width:62.5%}.van-col-offset-15{margin-left:62.5%}.van-col-16{width:66.66667%}.van-col-offset-16{margin-left:66.66667%}.van-col-17{width:70.83333%}.van-col-offset-17{margin-left:70.83333%}.van-col-18{width:75%}.van-col-offset-18{margin-left:75%}.van-col-19{width:79.16667%}.van-col-offset-19{margin-left:79.16667%}.van-col-20{width:83.33333%}.van-col-offset-20{margin-left:83.33333%}.van-col-21{width:87.5%}.van-col-offset-21{margin-left:87.5%}.van-col-22{width:91.66667%}.van-col-offset-22{margin-left:91.66667%}.van-col-23{width:95.83333%}.van-col-offset-23{margin-left:95.83333%}.van-col-24{width:100%}.van-col-offset-24{margin-left:100%}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/node_modules/vant/lib/vant-css/col.css"],names:[],mappings:"AAAA,SAAS,WAAW,qBAAqB,CAAC,WAAW,cAAc,CAAC,kBAAkB,oBAAoB,CAAC,WAAW,cAAc,CAAC,kBAAkB,oBAAoB,CAAC,WAAW,WAAW,CAAC,kBAAkB,iBAAiB,CAAC,WAAW,eAAe,CAAC,kBAAkB,qBAAqB,CAAC,WAAW,eAAe,CAAC,kBAAkB,qBAAqB,CAAC,WAAW,SAAS,CAAC,kBAAkB,eAAe,CAAC,WAAW,eAAe,CAAC,kBAAkB,qBAAqB,CAAC,WAAW,eAAe,CAAC,kBAAkB,qBAAqB,CAAC,WAAW,WAAW,CAAC,kBAAkB,iBAAiB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,SAAS,CAAC,mBAAmB,eAAe,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,WAAW,CAAC,mBAAmB,iBAAiB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,SAAS,CAAC,mBAAmB,eAAe,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,WAAW,CAAC,mBAAmB,iBAAiB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,eAAe,CAAC,mBAAmB,qBAAqB,CAAC,YAAY,UAAU,CAAC,mBAAmB,gBAAgB,CAAC",file:"col.css",sourcesContent:[".van-col{float:left;box-sizing:border-box}.van-col-1{width:4.16667%}.van-col-offset-1{margin-left:4.16667%}.van-col-2{width:8.33333%}.van-col-offset-2{margin-left:8.33333%}.van-col-3{width:12.5%}.van-col-offset-3{margin-left:12.5%}.van-col-4{width:16.66667%}.van-col-offset-4{margin-left:16.66667%}.van-col-5{width:20.83333%}.van-col-offset-5{margin-left:20.83333%}.van-col-6{width:25%}.van-col-offset-6{margin-left:25%}.van-col-7{width:29.16667%}.van-col-offset-7{margin-left:29.16667%}.van-col-8{width:33.33333%}.van-col-offset-8{margin-left:33.33333%}.van-col-9{width:37.5%}.van-col-offset-9{margin-left:37.5%}.van-col-10{width:41.66667%}.van-col-offset-10{margin-left:41.66667%}.van-col-11{width:45.83333%}.van-col-offset-11{margin-left:45.83333%}.van-col-12{width:50%}.van-col-offset-12{margin-left:50%}.van-col-13{width:54.16667%}.van-col-offset-13{margin-left:54.16667%}.van-col-14{width:58.33333%}.van-col-offset-14{margin-left:58.33333%}.van-col-15{width:62.5%}.van-col-offset-15{margin-left:62.5%}.van-col-16{width:66.66667%}.van-col-offset-16{margin-left:66.66667%}.van-col-17{width:70.83333%}.van-col-offset-17{margin-left:70.83333%}.van-col-18{width:75%}.van-col-offset-18{margin-left:75%}.van-col-19{width:79.16667%}.van-col-offset-19{margin-left:79.16667%}.van-col-20{width:83.33333%}.van-col-offset-20{margin-left:83.33333%}.van-col-21{width:87.5%}.van-col-offset-21{margin-left:87.5%}.van-col-22{width:91.66667%}.van-col-offset-22{margin-left:91.66667%}.van-col-23{width:95.83333%}.van-col-offset-23{margin-left:95.83333%}.van-col-24{width:100%}.van-col-offset-24{margin-left:100%}"],sourceRoot:""}])},"HA/b":function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".pay_way_title[data-v-4e6247a0]{font-weight:700;padding:0}.id_card_upload[data-v-4e6247a0]{margin:10px 0;background-color:#fff;padding:15px}.id_card_upload>div[data-v-4e6247a0]{margin-bottom:15px}.upload_hint[data-v-4e6247a0]{position:relative;padding-left:20px;line-height:1.6}.upload_hint i[data-v-4e6247a0]{position:absolute;top:2px;left:0}.id_card_row>div[data-v-4e6247a0]{text-align:center}.id_card_row .text-desc[data-v-4e6247a0]{margin-bottom:8px}.id_card_row .red_color[data-v-4e6247a0]{color:darkred;font-size:14px;font-weight:700}.upload_box .upload_wrap[data-v-4e6247a0]{position:relative;border:1px dashed #bfbfbf;min-height:145px;box-sizing:border-box;padding:5px;text-align:center}.upload_box .upload_wrap img[data-v-4e6247a0]{max-width:100%;height:120px}.upload_box .upload_wrap .van-uploader[data-v-4e6247a0]{width:100%;height:100%;position:absolute;top:0;left:0}.upload_box .upload_wrap .add_btn[data-v-4e6247a0]{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%);color:#bfbfbf}.upload_box .upload_wrap .add_btn p[data-v-4e6247a0]{white-space:nowrap;margin:0;font-size:18px}.upload_box .upload_wrap .add_btn i[data-v-4e6247a0]{font-size:26px}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/src/views/order/comment/comment-upload.vue"],names:[],mappings:"AACA,gCACE,gBAAkB,AAClB,SAAW,CACZ,AACD,iCACE,cAAsB,AACtB,sBAAuB,AACvB,YAAc,CACf,AACD,qCACI,kBAAoB,CACvB,AACD,8BACE,kBAAmB,AACnB,kBAAmB,AACnB,eAAiB,CAClB,AACD,gCACI,kBAAmB,AACnB,QAAS,AACT,MAAQ,CACX,AACD,kCACE,iBAAmB,CACpB,AACD,yCACE,iBAAmB,CACpB,AACD,yCACE,cAAe,AACf,eAAgB,AAChB,eAAiB,CAClB,AACD,0CACE,kBAAmB,AACnB,0BAA2B,AAC3B,iBAAkB,AAClB,sBAAuB,AACvB,YAAa,AACb,iBAAmB,CACpB,AACD,8CACI,eAAgB,AAChB,YAAc,CACjB,AACD,wDACI,WAAY,AACZ,YAAa,AACb,kBAAmB,AACnB,MAAO,AACP,MAAQ,CACX,AACD,mDACI,kBAAmB,AACnB,QAAS,AACT,SAAU,AACV,uCAAyC,AACjC,+BAAiC,AACzC,aAAe,CAClB,AACD,qDACM,mBAAoB,AACpB,SAAU,AACV,cAAgB,CACrB,AACD,qDACM,cAAgB,CACrB",file:"comment-upload.vue",sourcesContent:["\n.pay_way_title[data-v-4e6247a0] {\n  font-weight: bold;\n  padding: 0;\n}\n.id_card_upload[data-v-4e6247a0] {\n  margin: 10px 0 10px 0;\n  background-color: #fff;\n  padding: 15px;\n}\n.id_card_upload > div[data-v-4e6247a0] {\n    margin-bottom: 15px;\n}\n.upload_hint[data-v-4e6247a0] {\n  position: relative;\n  padding-left: 20px;\n  line-height: 1.6;\n}\n.upload_hint i[data-v-4e6247a0] {\n    position: absolute;\n    top: 2px;\n    left: 0;\n}\n.id_card_row > div[data-v-4e6247a0] {\n  text-align: center;\n}\n.id_card_row .text-desc[data-v-4e6247a0] {\n  margin-bottom: 8px;\n}\n.id_card_row .red_color[data-v-4e6247a0] {\n  color: darkred;\n  font-size: 14px;\n  font-weight: 700;\n}\n.upload_box .upload_wrap[data-v-4e6247a0] {\n  position: relative;\n  border: 1px dashed #bfbfbf;\n  min-height: 145px;\n  box-sizing: border-box;\n  padding: 5px;\n  text-align: center;\n}\n.upload_box .upload_wrap img[data-v-4e6247a0] {\n    max-width: 100%;\n    height: 120px;\n}\n.upload_box .upload_wrap .van-uploader[data-v-4e6247a0] {\n    width: 100%;\n    height: 100%;\n    position: absolute;\n    top: 0;\n    left: 0;\n}\n.upload_box .upload_wrap .add_btn[data-v-4e6247a0] {\n    position: absolute;\n    top: 50%;\n    left: 50%;\n    -webkit-transform: translate(-50%, -50%);\n            transform: translate(-50%, -50%);\n    color: #bfbfbf;\n}\n.upload_box .upload_wrap .add_btn p[data-v-4e6247a0] {\n      white-space: nowrap;\n      margin: 0;\n      font-size: 18px;\n}\n.upload_box .upload_wrap .add_btn i[data-v-4e6247a0] {\n      font-size: 26px;\n}\n"],sourceRoot:""}])},"Hn/3":function(t,e,a){var i=a("rJyx");"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);a("rjj0")("39850e4c",i,!0,{})},L00R:function(t,e,a){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}e.__esModule=!0;var n=a("//Fk"),o=i(n),s=a("ArwO"),r=i(s);e.default=(0,r.default)({render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{class:t.b()},[t._t("default"),a("input",t._b({ref:"input",class:t.b("input"),attrs:{type:"file",accept:t.accept,disabled:t.disabled},on:{change:t.onChange}},"input",t.$attrs,!1))],2)},name:"uploader",inheritAttrs:!1,props:{disabled:Boolean,beforeRead:Function,afterRead:Function,accept:{type:String,default:"image/*"},resultType:{type:String,default:"dataUrl"},maxSize:{type:Number,default:Number.MAX_VALUE}},methods:{onChange:function(t){var e=this,a=t.target.files;!this.disabled&&a.length&&(!(a=1===a.length?a[0]:[].slice.call(a,0))||this.beforeRead&&!this.beforeRead(a)||(Array.isArray(a)?o.default.all(a.map(this.readFile)).then(function(t){var i=!1,n=a.map(function(n,o){return n.size>e.maxSize&&(i=!0),{file:a[o],content:t[o]}});e.onAfterRead(n,i)}):this.readFile(a).then(function(t){e.onAfterRead({file:a,content:t},a.size>e.maxSize)})))},readFile:function(t){var e=this;return new o.default(function(a){var i=new FileReader;i.onload=function(t){a(t.target.result)},"dataUrl"===e.resultType?i.readAsDataURL(t):"text"===e.resultType&&i.readAsText(t)})},onAfterRead:function(t,e){e?this.$emit("oversize",t):(this.afterRead&&this.afterRead(t),this.$refs.input&&(this.$refs.input.value=""))}}})},Mqtp:function(t,e,a){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}e.__esModule=!0;var n=a("7+uW"),o=i(n),s=a("jNK6"),r=i(s),A=void 0,l=function(){A=new(o.default.extend(r.default))({el:document.createElement("div")}),document.body.appendChild(A.$el)},c=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0;return A||l(),A.images=t,A.startPosition=e,A.value=!0,A.$on("input",function(t){A.value=t}),A};c.install=function(){o.default.use(r.default)},e.default=c},Qe9A:function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".pay_way_title{font-weight:700;padding:15px;background-color:#fff}.tip_r{color:red}.pic_list{padding:10px 15px;background-color:#fff}.flex{display:-webkit-box;display:flex;display:-webkit-flex;-webkit-flex-wrap:wrap;flex-wrap:wrap;margin-top:15px}.flex img{width:80px;height:80px;margin:8px 4px 0 0}.pic-box{width:100%;overflow-y:scroll}.btn{margin-bottom:15px}.btn_list{padding:20px;background-color:#fff}.upload-title{color:red;padding:12px;font-size:16px}.upload-desc{font-size:16px;font-weight:700;padding:15px 0;color:darkred}.demo-pic,.upload-desc{text-align:center}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/src/views/order/comment/index.vue"],names:[],mappings:"AACA,eACE,gBAAkB,AAClB,aAAc,AACd,qBAAuB,CACxB,AACD,OACE,SAAW,CACZ,AACD,UACE,kBAAmB,AACnB,qBAAuB,CACxB,AACD,MACE,oBAAqB,AACrB,aAAc,AACd,qBAAsB,AACtB,uBAAwB,AAChB,eAAgB,AACxB,eAAiB,CAClB,AACD,UACE,WAAY,AACZ,YAAa,AACb,kBAAoB,CACrB,AACD,SACE,WAAY,AACZ,iBAAmB,CACpB,AACD,KACE,kBAAoB,CACrB,AACD,UACE,aAAc,AACd,qBAAuB,CACxB,AACD,cACE,UAAW,AACX,aAAc,AACd,cAAgB,CACjB,AACD,aACE,eAAgB,AAChB,gBAAkB,AAClB,eAAgB,AAChB,aAAe,CAEhB,AACD,uBAFE,iBAAmB,CAIpB",file:"index.vue",sourcesContent:["\n.pay_way_title {\r\n  font-weight: bold;\r\n  padding: 15px;\r\n  background-color: #fff;\n}\n.tip_r {\r\n  color: red;\n}\n.pic_list {\r\n  padding: 10px 15px;\r\n  background-color: #fff;\n}\n.flex {\r\n  display: -webkit-box;\r\n  display: flex;\r\n  display: -webkit-flex;\r\n  -webkit-flex-wrap: wrap;\r\n          flex-wrap: wrap;\r\n  margin-top: 15px;\n}\n.flex img {\r\n  width: 80px;\r\n  height: 80px;\r\n  margin: 8px 4px 0 0;\n}\n.pic-box {\r\n  width: 100%;\r\n  overflow-y: scroll;\n}\n.btn {\r\n  margin-bottom: 15px;\n}\n.btn_list {\r\n  padding: 20px;\r\n  background-color: #fff;\n}\n.upload-title {\r\n  color: red;\r\n  padding: 12px;\r\n  font-size: 16px;\n}\n.upload-desc{\r\n  font-size: 16px;\r\n  font-weight: bold;\r\n  padding: 15px 0;\r\n  color: darkred;\r\n  text-align: center;\n}\n.demo-pic{\r\n  text-align: center;\n}\r\n"],sourceRoot:""}])},aczI:function(t,e,a){"use strict";function i(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}var n,o=a("dL9u"),s=(a.n(o),a("L00R")),r=a.n(s),A=a("i9vB"),l=(a.n(A),a("Mqtp")),c=a.n(l),d=a("dKGA"),f=(a.n(d),a("kSul")),u=a.n(f),p=a("jgNZ"),v=(a.n(p),a("syWm")),m=a.n(v);e.a={name:"commentUpload",props:["comment_pic"],data:function(){return{files:{comment_file:""},comment_pic:"",demoImg:a("mU2b")}},methods:{onRead1:function(t){var e=new Image;e.src=t.content;var a=this;e.onload=function(){var t=a.compress(e);a.files.comment_file=t,a.comment_pic=t.content},this.$emit("setFiles",this.files)},compress:function(t){var e=t.width,a=t.height,i=document.createElement("canvas"),n=i.getContext("2d");i.width=600,i.height=a/e*600,n.drawImage(t,0,0,i.width,i.height);var o=i.toDataURL("image/jpeg",.8),s=this.dataURLtoFile(o,Date.parse(Date())+".jpg");return s={content:o,file:s}},dataURLtoFile:function(t,e){for(var a=t.split(","),i=a[0].match(/:(.*?);/)[1],n=atob(a[1]),o=n.length,s=new Uint8Array(o);o--;)s[o]=n.charCodeAt(o);return new File([s],e,{type:i})},maxReadBack:function(t){Toast("图片不能超出4M")},showImagePreview:function(t){c()([t])}},components:(n={},i(n,m.a.name,m.a),i(n,u.a.name,u.a),i(n,c.a.name,c.a),i(n,r.a.name,r.a),n)}},beN6:function(t,e,a){"use strict";e.__esModule=!0;var i=a("ArwO"),n=function(t){return t&&t.__esModule?t:{default:t}}(i);e.default=(0,n.default)({render:function(){var t=this,e=t.$createElement;return(t._self._c||e)("div",{class:t.b(),style:t.style},[t._t("default")],2)},name:"swipe-item",data:function(){return{offset:0}},computed:{style:function(){var t=this.$parent,e=t.vertical,a=t.width,i=t.height;return{width:a+"px",height:e?i+"px":"100%",transform:"translate"+(e?"Y":"X")+"("+this.offset+"px)"}}},beforeCreate:function(){this.$parent.swipes.push(this)},destroyed:function(){this.$parent.swipes.splice(this.$parent.swipes.indexOf(this),1)}})},dKGA:function(t,e,a){a("xL5C"),a("qCSc")},dL9u:function(t,e,a){a("xL5C"),a("mLTM")},e9pW:function(t,e,a){var i=a("HA/b");"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);a("rjj0")("10873a72",i,!0,{})},i9vB:function(t,e,a){a("xL5C"),a("itIU"),a("9nkg"),a("Hn/3")},jG6b:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"content"},[a("van-nav-bar",{attrs:{title:"好评任务","left-text":"返回","right-text":"","left-arrow":""},on:{"click-left":t.goBack}}),t._v(" "),a("div",{staticClass:"pay_way_group"},[a("van-cell-group",{staticClass:"payment_group"},[a("van-cell",{attrs:{title:"使用买号"}},[t._v(t._s(t.task.tbUser))]),t._v(" "),a("van-cell",{attrs:{title:"订单编号"}},[t._v(t._s(t.task.orderNo))]),t._v(" "),a("van-cell",{attrs:{title:"店铺名称"}},[t._v(t._s(t.goods.shop_name))]),t._v(" "),a("van-cell",{attrs:{title:"件数"}},[t._v(t._s(t.task.goodsNum)+"件")]),t._v(" "),a("van-cell",{attrs:{title:"返现金额"}},[t._v(t._s(t.task.tbMoney)+"元")]),t._v(" "),a("van-cell",{attrs:{title:"佣金奖励"}},[t._v(t._s(t.task.brokerage)+"元")]),t._v(" "),a("van-cell",{attrs:{title:"商品主图"}},[a("img",{directives:[{name:"lazy",rawName:"v-lazy",value:t.goods.main_img,expression:"goods.main_img"}],attrs:{width:"100%"},on:{click:function(e){t.showImagePreview(t.goods.main_img)}}})])],1)],1),t._v(" "),a("div",{staticClass:"pay_way_group"},[a("van-cell-group",[a("van-cell",{staticClass:"tip_r",attrs:{title:"温馨提示："}},[t._v("如果乱评价，将扣除本单佣金")]),t._v(" "),1==t.task.commentType?a("van-cell",{staticClass:"tip_r",attrs:{title:"评价要求："}},[t._v("全5星好评，且自由发挥评价，十五个字以上。")]):t._e(),t._v(" "),2==t.task.commentType?a("van-cell",{staticClass:"tip_r",attrs:{title:"评价要求："}},[t._v("全5星好评，不用写文字评价")]):t._e(),t._v(" "),3==t.task.commentType?a("van-cell",{staticClass:"tip_r",attrs:{title:"评价要求："}},[t._v("全5星好评，并按照下方指定要求评价~!。")]):t._e()],1)],1),t._v(" "),3==t.task.commentType?a("div",{staticClass:"pay_way_group"},[a("van-cell-group",[a("van-cell",{attrs:{title:"指定文字"}},[t._v("\n              "+t._s(t.task.commentBody)+"\n              "),""!=t.task.commentBody?a("div",{directives:[{name:"clipboard",rawName:"v-clipboard:copy",value:t.task.commentBody,expression:"task.commentBody",arg:"copy"},{name:"clipboard",rawName:"v-clipboard:success",value:t.onCopy,expression:"onCopy",arg:"success"},{name:"clipboard",rawName:"v-clipboard:error",value:t.onError,expression:"onError",arg:"error"}],staticClass:"tip_r"},[t._v("点击复制")]):t._e()]),t._v(" "),a("van-cell",{attrs:{title:"额外好评奖励"}},[t._v(t._s(t.task.CommentMoney)+"元")])],1),t._v(" "),a("div",{staticClass:"pic_list"},[a("div",{staticClass:"pic_title"},[t._v("指定图片")]),t._v(" "),a("div",{staticClass:"flex"},t._l(t.task.commentPic,function(e,i){return a("img",{key:i,attrs:{src:e},on:{click:function(a){t.showImagePreview(e)}}})}))])],1):t._e(),t._v(" "),a("div",{staticClass:"pay_way_group"},[a("van-cell-group",[a("div",{staticClass:"upload-title"},[t._v("商家会在后台核对，无需截图好评")]),t._v(" "),a("div",{staticClass:"upload-desc"},[t._v("好评示列（点击可放大）")]),t._v(" "),a("div",{staticClass:"demo-pic"},[a("img",{attrs:{src:t.demoImg,width:"50%"},on:{click:function(e){t.showImagePreview(t.demoImg)}}})])])],1),t._v(" "),a("div",{staticClass:"btn_list"},[1!=t.task.commentStatus&&2!=t.task.commentStatus?a("van-button",{staticClass:"btn",attrs:{loading:t.isSubmit,type:"danger","bottom-action":!0},on:{click:t.subComment}},[t._v("提交审核")]):t._e(),t._v(" "),a("van-button",{staticClass:"btn",attrs:{loading:!1,type:"default","bottom-action":!0},on:{click:t.goBack}},[t._v("返回")])],1)],1)},n=[],o={render:i,staticRenderFns:n};e.a=o},jNK6:function(t,e,a){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}e.__esModule=!0;var n=a("ArwO"),o=i(n),s=a("/4KT"),r=i(s),A=a("24wo"),l=i(A),c=a("beN6"),d=i(c);e.default=(0,o.default)({render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"show",rawName:"v-show",value:t.value,expression:"value"}],class:t.b(),on:{touchstart:t.onTouchStart,touchend:t.onTouchEnd,touchcancel:t.onTouchEnd}},[a("swipe",{ref:"swipe",attrs:{"initial-swipe":t.startPosition}},t._l(t.images,function(e,i){return a("swipe-item",{key:i},[a("img",{class:t.b("image"),attrs:{src:e}})])}))],1)},name:"image-preview",mixins:[r.default],components:{Swipe:l.default,SwipeItem:d.default},props:{overlay:{type:Boolean,default:!0},closeOnClickOverlay:{type:Boolean,default:!0}},data:function(){return{images:[],startPosition:0}},methods:{onTouchStart:function(){this.touchStartTime=new Date},onTouchEnd:function(t){t.preventDefault();var e=new Date-this.touchStartTime,a=this.$refs.swipe,i=a.offsetX,n=a.offsetY;e<500&&i<10&&n<10&&this.$emit("input",!1)}}})},jgNZ:function(t,e,a){a("xL5C"),a("qzWe")},kSul:function(t,e,a){"use strict";e.__esModule=!0;var i=a("ArwO"),n=function(t){return t&&t.__esModule?t:{default:t}}(i);e.default=(0,n.default)({render:function(){var t=this,e=t.$createElement;return(t._self._c||e)("div",{staticClass:"van-col",class:(a={},a["van-col-"+t.span]=t.span,a["van-col-offset-"+t.offset]=t.offset,a),style:t.style},[t._t("default")],2);var a},name:"col",props:{span:[Number,String],offset:[Number,String]},computed:{gutter:function(){return this.$parent&&Number(this.$parent.gutter)||0},style:function(){var t=this.gutter/2+"px";return this.gutter?{paddingLeft:t,paddingRight:t}:{}}}})},mLTM:function(t,e,a){var i=a("nqhd");"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);a("rjj0")("2f181a3a",i,!0,{})},mU2b:function(t,e,a){t.exports=a.p+"static/img/hp.247d03a.jpg"},nqhd:function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".van-uploader{position:relative;display:inline-block}.van-uploader__input{position:absolute;top:0;right:0;bottom:0;left:0;width:100%;height:100%;opacity:0;cursor:pointer}.van-uploader input[type=file]::-webkit-file-upload-button{cursor:pointer}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/node_modules/vant/lib/vant-css/uploader.css"],names:[],mappings:"AAAA,cAAc,kBAAkB,oBAAoB,CAAC,qBAAqB,kBAAkB,MAAM,QAAQ,SAAS,OAAO,WAAW,YAAY,UAAU,cAAc,CAAC,2DAA2D,cAAc,CAAC",file:"uploader.css",sourcesContent:[".van-uploader{position:relative;display:inline-block}.van-uploader__input{position:absolute;top:0;right:0;bottom:0;left:0;width:100%;height:100%;opacity:0;cursor:pointer}.van-uploader input[type=file]::-webkit-file-upload-button{cursor:pointer}"],sourceRoot:""}])},qCSc:function(t,e,a){var i=a("Fw7G");"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);a("rjj0")("a2e656cc",i,!0,{})},qdwC:function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,'.van-row:after{content:"";display:table;clear:both}',"",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/node_modules/vant/lib/vant-css/row.css"],names:[],mappings:"AAAA,eAAe,WAAW,cAAc,UAAU,CAAC",file:"row.css",sourcesContent:['.van-row:after{content:"";display:table;clear:both}'],sourceRoot:""}])},qzWe:function(t,e,a){var i=a("qdwC");"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);a("rjj0")("38b70ada",i,!0,{})},rJyx:function(t,e,a){e=t.exports=a("FZ+f")(!0),e.push([t.i,".van-image-preview{top:0;left:0;width:100%;height:100%;position:fixed}.van-image-preview__image{top:0;left:0;right:0;bottom:0;margin:auto;max-width:100%;max-height:100%;position:absolute}.van-image-preview .van-swipe{height:100%}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/node_modules/vant/lib/vant-css/image-preview.css"],names:[],mappings:"AAAA,mBAAmB,MAAM,OAAO,WAAW,YAAY,cAAc,CAAC,0BAA0B,MAAM,OAAO,QAAQ,SAAS,YAAY,eAAe,gBAAgB,iBAAiB,CAAC,8BAA8B,WAAW,CAAC",file:"image-preview.css",sourcesContent:[".van-image-preview{top:0;left:0;width:100%;height:100%;position:fixed}.van-image-preview__image{top:0;left:0;right:0;bottom:0;margin:auto;max-width:100%;max-height:100%;position:absolute}.van-image-preview .van-swipe{height:100%}"],sourceRoot:""}])},syWm:function(t,e,a){"use strict";e.__esModule=!0;var i=a("ArwO"),n=function(t){return t&&t.__esModule?t:{default:t}}(i);e.default=(0,n.default)({render:function(){var t=this,e=t.$createElement;return(t._self._c||e)("div",{class:t.b(),style:t.style},[t._t("default")],2)},name:"row",props:{gutter:{type:[Number,String],default:0}},computed:{style:function(){var t="-"+Number(this.gutter)/2+"px";return this.gutter?{marginLeft:t,marginRight:t}:{}}}})},thUO:function(t,e,a){"use strict";function i(t){a("xIxw")}Object.defineProperty(e,"__esModule",{value:!0});var n=a("+PvC"),o=a("jG6b"),s=a("VU/8"),r=i,A=s(n.a,o.a,!1,r,null,null);e.default=A.exports},usIK:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"id_card_upload"},[a("div",{staticClass:"pay_way_title"},[t._v("上传评价图片")]),t._v(" "),a("van-row",{staticClass:"upload_hint text-desc"},[a("van-icon",{attrs:{name:"hint"}}),t._v("\n    温馨提示: 请参考下方示例图\n  ")],1),t._v(" "),a("van-row",{staticClass:"id_card_row upload_box",attrs:{gutter:"20"}},[a("van-col",{attrs:{span:"24"}},[a("div",{staticClass:"upload_wrap"},[a("van-uploader",{attrs:{"max-size":"4194304","after-read":t.onRead1},on:{oversize:t.maxReadBack}},[a("div",{staticClass:"add_btn"},[t.comment_pic?a("div",[a("img",{attrs:{src:t.comment_pic}})]):a("div",[a("van-icon",{attrs:{name:"photograph"}}),t._v(" "),a("p",[t._v("上传照片")])],1)])])],1)])],1),t._v(" "),a("van-row",{staticClass:"id_card_row",attrs:{gutter:"10"}},[a("van-col",{attrs:{span:"24"}},[a("div",{staticClass:"text-desc red_color"},[t._v("截图示列（点击可放大）")]),t._v(" "),a("img",{attrs:{src:t.demoImg,width:"50%"},on:{click:function(e){t.showImagePreview(t.demoImg)}}})])],1)],1)},n=[],o={render:i,staticRenderFns:n};e.a=o},xIxw:function(t,e,a){var i=a("Qe9A");"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);a("rjj0")("c3346834",i,!0,{})}});
//# sourceMappingURL=9.31288168b8a836276fd3.js.map