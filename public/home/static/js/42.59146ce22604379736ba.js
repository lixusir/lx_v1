webpackJsonp([42],{BfTD:function(t,s,c){"use strict";var a=function(){var t=this,s=t.$createElement,c=t._self._c||s;return c("div",{staticClass:"payment_status"},[c("div",{staticClass:"status_top"},[c("van-icon",{class:t.statusClass,attrs:{name:t.statusIcon}}),t._v(" "),c("div",[t._v(t._s(t.statusText))])],1),t._v(" "),t.isSuccess?c("div",{staticClass:"time_down status_text"},[c("span",{ref:"timeSpan",staticClass:"red"},[t._v("3秒")]),t._v("后返回到任务列表")]):c("div",{staticClass:"status_text"},[t._v("系统繁忙, 资料提交遇到问题, 请您稍后再试!")]),t._v(" "),c("div",{staticClass:"status_goLink"},[c("router-link",{staticClass:"red",attrs:{to:{name:t.details,params:{id:t.taskId,status:20}}}},[t._v("查看任务详情"),c("van-icon",{attrs:{name:"arrow"}})],1)],1)])},n=[],i={render:a,staticRenderFns:n};s.a=i},C1kZ:function(t,s,c){"use strict";s.a={name:"task-status",props:{status:String,taskId:String,redirect:String,details:String},data:function(){return{isSuccess:!0,taskId:"0",timer:null}},computed:{statusText:function(){return this.isSuccess?"提交成功":"提交失败"},statusIcon:function(){return this.isSuccess?"checked":"fail"},statusClass:function(){return this.isSuccess?"success_icon":"fail_icon"}},activated:function(){this.isSuccess="success"===this.status},created:function(){var t=this,s=3;this.timer=setInterval(function(){if(--s<=0)return t.$router.replace({name:t.redirect}),!1;t.$refs.timeSpan.innerHTML=s+"秒"},1e3)},beforeDestroy:function(){this.timer&&clearInterval(this.timer)}}},P3MI:function(t,s,c){"use strict";function a(t){c("pBzW")}Object.defineProperty(s,"__esModule",{value:!0});var n=c("C1kZ"),i=c("BfTD"),e=c("VU/8"),o=a,r=e(n.a,i.a,!1,o,"data-v-3cb88c0c",null);s.default=r.exports},jhhv:function(t,s,c){s=t.exports=c("FZ+f")(!0),s.push([t.i,".payment_status[data-v-3cb88c0c]{padding-top:30px;box-sizing:border-box;background-color:#fff;text-align:center}.status_top[data-v-3cb88c0c]{margin-bottom:15px}.status_top i[data-v-3cb88c0c]{margin-bottom:5px}.status_top>div[data-v-3cb88c0c]{font-size:18px}.status_text[data-v-3cb88c0c]{color:#999;margin-bottom:50px}.status_icon[data-v-3cb88c0c],i.fail_icon[data-v-3cb88c0c],i.success_icon[data-v-3cb88c0c]{font-size:80px}i.success_icon[data-v-3cb88c0c]{color:#06bf04}i.fail_icon[data-v-3cb88c0c]{color:#f44}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/src/views/order/task-status/index.vue"],names:[],mappings:"AACA,iCACE,iBAAkB,AAClB,sBAAuB,AACvB,sBAAuB,AACvB,iBAAmB,CACpB,AACD,6BACE,kBAAoB,CACrB,AACD,+BACI,iBAAmB,CACtB,AACD,iCACI,cAAgB,CACnB,AACD,8BACE,WAAY,AACZ,kBAAoB,CACrB,AACD,2FACE,cAAgB,CACjB,AACD,gCACE,aAAe,CAChB,AACD,6BACE,UAAY,CACb",file:"index.vue",sourcesContent:["\n.payment_status[data-v-3cb88c0c] {\n  padding-top: 30px;\n  box-sizing: border-box;\n  background-color: #fff;\n  text-align: center;\n}\n.status_top[data-v-3cb88c0c] {\n  margin-bottom: 15px;\n}\n.status_top i[data-v-3cb88c0c] {\n    margin-bottom: 5px;\n}\n.status_top > div[data-v-3cb88c0c] {\n    font-size: 18px;\n}\n.status_text[data-v-3cb88c0c] {\n  color: #999;\n  margin-bottom: 50px;\n}\n.status_icon[data-v-3cb88c0c], i.success_icon[data-v-3cb88c0c], i.fail_icon[data-v-3cb88c0c] {\n  font-size: 80px;\n}\ni.success_icon[data-v-3cb88c0c] {\n  color: #06bf04;\n}\ni.fail_icon[data-v-3cb88c0c] {\n  color: #f44;\n}\n"],sourceRoot:""}])},pBzW:function(t,s,c){var a=c("jhhv");"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);c("rjj0")("41cb0bf5",a,!0,{})}});
//# sourceMappingURL=42.59146ce22604379736ba.js.map