webpackJsonp([41],{"/ZKT":function(e,t,a){"use strict";var n=a("vMJZ");t.a={data:function(){return{age:""}},vuelidation:{data:{age:{required:{msg:function(){return"请填写年龄"}}}}},created:function(){this.getAge()},methods:{getAge:function(){this.age=localStorage.getItem("age")||""},save:function(){var e=this;this.mixValid()&&this.$reqPut(n.g,{age:this.age}).then(function(t){return localStorage.setItem("age",t.data.data.age),e.$dialog.alert({message:"保存成功"})}).then(function(){e.$router.go(-1)})}}}},"4eDA":function(e,t,a){"use strict";var n=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"set_nickname"},[a("van-cell-group",[a("van-field",{attrs:{label:"年龄",error:!!e.$vuelidation.error("age")},model:{value:e.age,callback:function(t){e.age=t},expression:"age"}})],1),e._v(" "),a("div",{staticClass:"bottom_btn"},[a("van-button",{attrs:{size:"large",type:"danger"},on:{click:e.save}},[e._v("保存")])],1)],1)},i=[],s={render:n,staticRenderFns:i};t.a=s},AmmI:function(e,t,a){"use strict";function n(e){a("dje3")}Object.defineProperty(t,"__esModule",{value:!0});var i=a("/ZKT"),s=a("4eDA"),r=a("VU/8"),o=n,u=r(i.a,s.a,!1,o,"data-v-95699492",null);t.default=u.exports},D303:function(e,t,a){t=e.exports=a("FZ+f")(!0),t.push([e.i,".bottom_btn[data-v-95699492]{padding:30px 15px 0}","",{version:3,sources:["D:/javascript/ditui_clients/src/views/user/user-information-set/set-age/index.vue"],names:[],mappings:"AACA,6BACC,mBAA0B,CAC1B",file:"index.vue",sourcesContent:["\n.bottom_btn[data-v-95699492]{\n\tpadding: 30px 15px 0 15px;\n}\n"],sourceRoot:""}])},dje3:function(e,t,a){var n=a("D303");"string"==typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);a("rjj0")("3b5a3bae",n,!0,{})}});
//# sourceMappingURL=41.2a1c4a50084e3d39e578.js.map