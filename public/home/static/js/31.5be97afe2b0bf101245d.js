webpackJsonp([31],{"/HaV":function(e,t,n){"use strict";function i(e){return Array.isArray(e)?e.map(function(e){return i(e)}):"object"==typeof e?(0,a.deepAssign)({},e):e}t.__esModule=!0,t.deepClone=i;var a=n("bhS9")},"0Y+T":function(e,t,n){var i=n("wwb+");"string"==typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);n("FIqI")("0580a18a",i,!0,{})},"1Y2g":function(e,t,n){"use strict";t.a={bank_list:[{value:"ICBC",text:"中国工商银行"},{value:"CCB",text:"中国建设银行"},{value:"ABC",text:"中国农业银行"},{value:"BOC",text:"中国银行"},{value:"PSBC",text:"中国邮政储蓄银行"},{value:"CMB",text:"招商银行"},{value:"COMM",text:"交通银行"},{value:"SPABANK",text:"平安银行"},{value:"CITIC",text:"中信银行"},{value:"CIB",text:"兴业银行"},{value:"CMBC",text:"中国民生银行"},{value:"HXBANK",text:"华夏银行"},{value:"CEB",text:"中国光大银行"}]}},B29Z:function(e,t,n){"use strict";function i(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var a,o=n("GKy3"),s=(n.n(o),n("4vvA")),r=n.n(s),l=n("wvM5"),c=(n.n(l),n("MyDk")),u=n.n(c),d=n("FDxC"),f=(n.n(d),n("w+oK")),h=n.n(f),m=n("Rv11"),p=(n.n(m),n("TMdk")),v=n.n(p),A=n("tLo2"),b=(n.n(A),n("blRl")),g=n.n(b),k=n("cnGM"),x=(n.n(k),n("S6j6")),_=n.n(x),C=n("QP/A"),B=(n.n(C),n("pyxX")),w=n.n(B),y=n("vMJZ"),I=n("1Y2g"),M=I.a.bank_list;t.a={components:(a={},i(a,w.a.name,w.a),i(a,_.a.name,_.a),i(a,g.a.name,g.a),i(a,v.a.name,v.a),i(a,h.a.name,h.a),i(a,u.a.name,u.a),a),data:function(){return{real_name:"",bank_name:"",bank_number:"",errorMsg:"",bankColumns:M,showBank:!1,bank_prompt:"",flag:!1,status:""}},computed:{prompt:function(){return this.bank_name?"":"请务必填写真实姓名以及对应的银行卡号，否则无法正常收款！"}},vuelidation:{data:{bank_name:{required:{msg:function(){return"请选择开户银行"}}},bank_number:{required:{msg:function(){return"请填写银行卡号"}}}}},mounted:function(){this.getBank()},methods:{getBank:function(){var e=this;e.$user.getUserInfo(function(t){e.status=t.bank_status,e.real_name=t.name,e.bank_name=t.bank,e.bank_number=t.bank_number,e.errorMsg=t.bank_remark,e.bank_name&&e.bank_number&&e.real_name&&(e.flag=!0,e.showCode=!1)})},getDesc:function(){switch(this.status){case 0:return"待提交";case 1:return"待审核";case 2:return"已审核通过";case 3:return"审核不通过"}},save:function(){var e=this;this.mixValid()&&this.$reqPost(y.v,{bank_name:this.bank_name,bank_number:this.bank_number}).then(function(t){var n=t.data;return 0!=n.code?void r.a.fail(n.msg):(e.$router.go(-1),e.$dialog.alert({message:"保存成功"}))}).catch(function(e){})},onBankConfirm:function(e,t){this.showBank=!1,this.bank_name=e.text},goBack:function(){this.$router.go(-1)}}}},Rv11:function(e,t,n){n("XqYu"),n("0Y+T")},TMdk:function(e,t,n){"use strict";var i=n("6ko4");t.__esModule=!0,t.default=void 0;var a=i(n("yM34")),o=n("VxeN"),s=n("NrR7"),r=n("/HaV"),l=n("eUvd"),c=i(n("Jq84")),u=i(n("oCfm")),d=(0,o.use)("picker"),f=d[0],h=d[1],m=d[2],p=f({props:(0,a.default)({},l.pickerProps,{columns:Array,defaultIndex:{type:Number,default:0},valueKey:{type:String,default:"text"}}),data:function(){return{children:[]}},computed:{simple:function(){return this.columns.length&&!this.columns[0].values}},watch:{columns:function(){this.setColumns()}},methods:{setColumns:function(){var e=this;(this.simple?[{values:this.columns}]:this.columns).forEach(function(t,n){e.setColumnValues(n,(0,r.deepClone)(t.values))})},emit:function(e){this.simple?this.$emit(e,this.getColumnValue(0),this.getColumnIndex(0)):this.$emit(e,this.getValues(),this.getIndexes())},onChange:function(e){this.simple?this.$emit("change",this,this.getColumnValue(0),this.getColumnIndex(0)):this.$emit("change",this,this.getValues(),e)},getColumn:function(e){return this.children[e]},getColumnValue:function(e){var t=this.getColumn(e);return t&&t.getValue()},setColumnValue:function(e,t){var n=this.getColumn(e);n&&n.setValue(t)},getColumnIndex:function(e){return(this.getColumn(e)||{}).currentIndex},setColumnIndex:function(e,t){var n=this.getColumn(e);n&&n.setIndex(t)},getColumnValues:function(e){return(this.children[e]||{}).options},setColumnValues:function(e,t){var n=this.children[e];n&&JSON.stringify(n.options)!==JSON.stringify(t)&&(n.options=t,n.setIndex(0))},getValues:function(){return this.children.map(function(e){return e.getValue()})},setValues:function(e){var t=this;e.forEach(function(e,n){t.setColumnValue(n,e)})},getIndexes:function(){return this.children.map(function(e){return e.currentIndex})},setIndexes:function(e){var t=this;e.forEach(function(e,n){t.setColumnIndex(n,e)})},onConfirm:function(){this.emit("confirm")},onCancel:function(){this.emit("cancel")}},render:function(e){var t=this,n=this.itemHeight,i=this.simple?[this.columns]:this.columns,a={height:n+"px"},o={height:n*this.visibleItemCount+"px"},r=this.showToolbar&&e("div",{class:["van-hairline--top-bottom",h("toolbar")]},[this.slots()||[e("div",{class:h("cancel"),on:{click:this.onCancel}},[this.cancelButtonText||m("cancel")]),this.slots("title")||this.title&&e("div",{class:["van-ellipsis",h("title")]},[this.title]),e("div",{class:h("confirm"),on:{click:this.onConfirm}},[this.confirmButtonText||m("confirm")])]]);return e("div",{class:h()},[r,this.loading?e("div",{class:h("loading")},[e(c.default)]):e(),e("div",{class:h("columns"),style:o,on:{touchmove:s.preventDefault}},[i.map(function(n,i){return e(u.default,{attrs:{valueKey:t.valueKey,className:n.className,itemHeight:t.itemHeight,defaultIndex:n.defaultIndex||t.defaultIndex,visibleItemCount:t.visibleItemCount,initialOptions:t.simple?n:n.values},on:{change:function(){t.onChange(i)}}})}),e("div",{class:["van-hairline--top-bottom",h("frame")],style:a})])])}});t.default=p},UwdF:function(e,t,n){"use strict";var i=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"set_nickname"},[n("van-nav-bar",{attrs:{title:"银行卡认证","left-text":"返回","right-text":"","left-arrow":""},on:{"click-left":e.goBack}}),e._v(" "),n("van-cell-group",[n("van-cell",{attrs:{title:"认证状态"}},[e._v(e._s(e.getDesc()))]),e._v(" "),e.errorMsg&&3==e.status?n("van-cell",{staticStyle:{color:"red"},attrs:{title:"审核提示"}},[e._v(e._s(e.errorMsg))]):e._e()],1),e._v(" "),n("van-cell-group",[n("van-field",{attrs:{label:"姓名",disabled:e.flag,placeholder:e.real_name?"":"请填写您银行卡姓名",error:!!e.$vuelidation.error("real_name")},model:{value:e.real_name,callback:function(t){e.real_name=t},expression:"real_name"}}),e._v(" "),n("van-field",{attrs:{label:"开户银行",disabled:e.flag,placeholder:e.bank_name?"":"请选择开户银行",readonly:"","error-message":e.bank_prompt,error:!!e.$vuelidation.error("bank_name")},on:{click:function(t){e.showBank=!0}},model:{value:e.bank_name,callback:function(t){e.bank_name=t},expression:"bank_name"}}),e._v(" "),n("van-field",{attrs:{label:"银行卡号",disabled:e.flag,placeholder:e.bank_number?"":"请填写银行卡号",error:!!e.$vuelidation.error("bank_number")},model:{value:e.bank_number,callback:function(t){e.bank_number=t},expression:"bank_number"}})],1),e._v(" "),n("div",{staticClass:"bottom_btn"},[0==e.status||3==e.status?n("van-button",{attrs:{size:"large",type:"danger"},on:{click:e.save}},[e._v("保存")]):e._e()],1),e._v(" "),n("van-popup",{attrs:{position:"bottom"},model:{value:e.showBank,callback:function(t){e.showBank=t},expression:"showBank"}},[n("van-picker",{attrs:{"show-toolbar":"",columns:e.bankColumns,title:"选择银行"},on:{cancel:function(t){e.showBank=!1},confirm:e.onBankConfirm}})],1)],1)},a=[],o={render:i,staticRenderFns:a};t.a=o},aKX9:function(e,t,n){var i=n("o3Pg");"string"==typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);n("FIqI")("1778bbd9",i,!0,{})},eUvd:function(e,t,n){"use strict";t.__esModule=!0,t.pickerProps=void 0;var i={title:String,loading:Boolean,showToolbar:Boolean,cancelButtonText:String,confirmButtonText:String,visibleItemCount:{type:Number,default:5},itemHeight:{type:Number,default:44}};t.pickerProps=i},o3Pg:function(e,t,n){t=e.exports=n("UTlt")(!0),t.push([e.i,".bottom_btn[data-v-622d6f74]{padding:30px 15px 0}","",{version:3,sources:["D:/javascript/ditui_clients/src/views/user/user-information-set/set-bank/index.vue"],names:[],mappings:"AACA,6BACC,mBAA0B,CAC1B",file:"index.vue",sourcesContent:["\n.bottom_btn[data-v-622d6f74]{\n\tpadding: 30px 15px 0 15px;\n}\n"],sourceRoot:""}])},oCfm:function(e,t,n){"use strict";t.__esModule=!0,t.default=void 0;var i=n("/HaV"),a=n("VxeN"),o=n("NrR7"),s=(0,a.use)("picker-column"),r=s[0],l=s[1],c=r({props:{valueKey:String,className:String,itemHeight:Number,defaultIndex:Number,initialOptions:Array,visibleItemCount:Number},data:function(){return{startY:0,offset:0,duration:0,startOffset:0,options:(0,i.deepClone)(this.initialOptions),currentIndex:this.defaultIndex}},created:function(){this.$parent.children&&this.$parent.children.push(this),this.setIndex(this.currentIndex)},destroyed:function(){var e=this.$parent.children;e&&e.splice(e.indexOf(this),1)},watch:{defaultIndex:function(){this.setIndex(this.defaultIndex)}},computed:{count:function(){return this.options.length}},methods:{onTouchStart:function(e){this.startY=e.touches[0].clientY,this.startOffset=this.offset,this.duration=0},onTouchMove:function(e){(0,o.preventDefault)(e);var t=e.touches[0].clientY-this.startY;this.offset=(0,a.range)(this.startOffset+t,-this.count*this.itemHeight,this.itemHeight)},onTouchEnd:function(){if(this.offset!==this.startOffset){this.duration=200;var e=(0,a.range)(Math.round(-this.offset/this.itemHeight),0,this.count-1);this.setIndex(e,!0)}},adjustIndex:function(e){e=(0,a.range)(e,0,this.count);for(var t=e;t<this.count;t++)if(!this.isDisabled(this.options[t]))return t;for(var n=e-1;n>=0;n--)if(!this.isDisabled(this.options[n]))return n},isDisabled:function(e){return(0,a.isObj)(e)&&e.disabled},getOptionText:function(e){return(0,a.isObj)(e)&&this.valueKey in e?e[this.valueKey]:e},setIndex:function(e,t){e=this.adjustIndex(e)||0,this.offset=-e*this.itemHeight,e!==this.currentIndex&&(this.currentIndex=e,t&&this.$emit("change",e))},setValue:function(e){for(var t=this.options,n=0;n<t.length;n++)if(this.getOptionText(t[n])===e)return this.setIndex(n)},getValue:function(){return this.options[this.currentIndex]}},render:function(e){var t=this,n=this.itemHeight,i=this.visibleItemCount,a={height:n*i+"px"},o=n*(i-1)/2,s={transition:this.duration+"ms",transform:"translate3d(0, "+(this.offset+o)+"px, 0)",lineHeight:n+"px"},r={height:n+"px"};return e("div",{style:a,class:[l(),this.className],on:{touchstart:this.onTouchStart,touchmove:this.onTouchMove,touchend:this.onTouchEnd,touchcancel:this.onTouchEnd}},[e("ul",{style:s},[this.options.map(function(n,i){return e("li",{style:r,class:["van-ellipsis",l("item",{disabled:t.isDisabled(n),selected:i===t.currentIndex})],domProps:{innerHTML:t.getOptionText(n)},on:{click:function(){t.setIndex(i,!0)}}})})])])}});t.default=c},qhMN:function(e,t,n){"use strict";function i(e){n("aKX9")}Object.defineProperty(t,"__esModule",{value:!0});var a=n("B29Z"),o=n("UwdF"),s=n("C7Lr"),r=i,l=s(a.a,o.a,!1,r,"data-v-622d6f74",null);t.default=l.exports},"wwb+":function(e,t,n){t=e.exports=n("UTlt")(!0),t.push([e.i,".van-picker{overflow:hidden;-webkit-user-select:none;user-select:none;position:relative;background-color:#fff;-webkit-text-size-adjust:100%}.van-picker__toolbar{display:-webkit-box;display:-webkit-flex;display:flex;height:44px;line-height:44px;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.van-picker__cancel,.van-picker__confirm{color:#1989fa;padding:0 15px;font-size:14px}.van-picker__cancel:active,.van-picker__confirm:active{background-color:#f2f3f5}.van-picker__title{max-width:50%;font-size:16px;font-weight:500;text-align:center}.van-picker__columns{display:-webkit-box;display:-webkit-flex;display:flex;position:relative}.van-picker__loading{top:0;left:0;right:0;bottom:0;z-index:2;position:absolute;background-color:hsla(0,0%,100%,.9)}.van-picker__loading circle{stroke:#1989fa}.van-picker__frame,.van-picker__loading .van-loading{top:50%;left:0;width:100%;z-index:1;position:absolute;pointer-events:none;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.van-picker-column{-webkit-box-flex:1;-webkit-flex:1;flex:1;overflow:hidden;font-size:16px;text-align:center}.van-picker-column__item{padding:0 5px;color:#969799}.van-picker-column__item--selected{font-weight:500;color:#323233}.van-picker-column__item--disabled{opacity:.3}","",{version:3,sources:["D:/javascript/ditui_clients/node_modules/vant/lib/picker/index.css"],names:[],mappings:"AAAA,YAAY,gBAAgB,yBAAyB,iBAAiB,kBAAkB,sBAAsB,6BAA6B,CAAC,qBAAqB,oBAAoB,qBAAqB,aAAa,YAAY,iBAAiB,yBAAyB,sCAAsC,6BAA6B,CAAC,yCAAyC,cAAc,eAAe,cAAc,CAAC,uDAAuD,wBAAwB,CAAC,mBAAmB,cAAc,eAAe,gBAAgB,iBAAiB,CAAC,qBAAqB,oBAAoB,qBAAqB,aAAa,iBAAiB,CAAC,qBAAqB,MAAM,OAAO,QAAQ,SAAS,UAAU,kBAAkB,mCAAqC,CAAC,4BAA4B,cAAc,CAAC,qDAAqD,QAAQ,OAAO,WAAW,UAAU,kBAAkB,oBAAoB,mCAAmC,0BAA0B,CAAC,mBAAmB,mBAAmB,eAAe,OAAO,gBAAgB,eAAe,iBAAiB,CAAC,yBAAyB,cAAc,aAAa,CAAC,mCAAmC,gBAAgB,aAAa,CAAC,mCAAmC,UAAU,CAAC",file:"index.css",sourcesContent:[".van-picker{overflow:hidden;-webkit-user-select:none;user-select:none;position:relative;background-color:#fff;-webkit-text-size-adjust:100%}.van-picker__toolbar{display:-webkit-box;display:-webkit-flex;display:flex;height:44px;line-height:44px;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.van-picker__cancel,.van-picker__confirm{color:#1989fa;padding:0 15px;font-size:14px}.van-picker__cancel:active,.van-picker__confirm:active{background-color:#f2f3f5}.van-picker__title{max-width:50%;font-size:16px;font-weight:500;text-align:center}.van-picker__columns{display:-webkit-box;display:-webkit-flex;display:flex;position:relative}.van-picker__loading{top:0;left:0;right:0;bottom:0;z-index:2;position:absolute;background-color:rgba(255,255,255,.9)}.van-picker__loading circle{stroke:#1989fa}.van-picker__frame,.van-picker__loading .van-loading{top:50%;left:0;width:100%;z-index:1;position:absolute;pointer-events:none;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.van-picker-column{-webkit-box-flex:1;-webkit-flex:1;flex:1;overflow:hidden;font-size:16px;text-align:center}.van-picker-column__item{padding:0 5px;color:#969799}.van-picker-column__item--selected{font-weight:500;color:#323233}.van-picker-column__item--disabled{opacity:.3}"],sourceRoot:""}])}});
//# sourceMappingURL=31.5be97afe2b0bf101245d.js.map