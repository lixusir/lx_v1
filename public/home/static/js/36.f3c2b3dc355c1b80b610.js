webpackJsonp([36],{"+gff":function(t,e,n){"use strict";function a(t){return function(){var e=t.apply(this,arguments);return new Promise(function(t,n){function a(i,r){try{var o=e[i](r),s=o.value}catch(t){return void n(t)}if(!o.done)return Promise.resolve(s).then(function(t){a("next",t)},function(t){a("throw",t)});t(s)}return a("next")})}}e.a={data:function(){return{pages:{perPage:8,currPage:1,pageCount:1,totalCount:1},items:[],loading:!1,finished:!0,isEmpty:!1}},methods:{resetInit:function(t){var e=this;return a(regeneratorRuntime.mark(function t(){var n;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e.resetData(),t.next=3,e.initData();case 3:n=t.sent,e.$nextTick(function(){e.setPages(n)});case 5:case"end":return t.stop()}},t,e)}))()},isFinished:function(){this.finished=!0,this.loading=!1},loadMore:function(){var t=this;return a(regeneratorRuntime.mark(function e(){var n,a;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(n=t,!(n.pages.pageCount<n.pages.currPage)){e.next=6;break}n.$toast({message:"没有更多了~",position:"top"}),n.isFinished(),e.next=10;break;case 6:return e.next=8,n.initData(!0);case 8:a=e.sent,n.nextPage(a.pageCount);case 10:n.loading=!1;case 11:case"end":return e.stop()}},e,t)}))()},nextPage:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:1;this.pages.currPage+=1,this.pages.pageCount=t},setPages:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};this.isEmpty=0===t.totalCount,t.totalCount<=this.pages.perPage?this.isFinished():(this.finished=!1,this.nextPage(t.pageCount))},resetData:function(){this.items=[],this.pages={perPage:8,currPage:1,pageCount:1,totalCount:1},this.loading=!1,this.finished=!0,this.isEmpty=!1}}}},"35/g":function(t,e,n){"use strict";var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{attrs:{id:"app"}},[n("van-list",{attrs:{finished:t.finished,"immediate-check":!1,offset:100},on:{load:t.loadMore},model:{value:t.loading,callback:function(e){t.loading=e},expression:"loading"}},t._l(t.items,function(e){return n("van-cell",{key:e.id,attrs:{title:e.title,"is-link":""},on:{click:function(n){t.openNotice(e)}}})})),t._v(" "),n("van-popup",{staticClass:"bounced",domProps:{innerHTML:t._s(t.content)},model:{value:t.show,callback:function(e){t.show=e},expression:"show"}})],1)},i=[],r={render:a,staticRenderFns:i};e.a=r},BSMq:function(t,e,n){"use strict";function a(t){if(Array.isArray(t)){for(var e=0,n=Array(t.length);e<t.length;e++)n[e]=t[e];return n}return Array.from(t)}var i=n("cnGM"),r=(n.n(i),n("S6j6")),o=n.n(r),s=n("Mcfu"),u=(n.n(s),n("r9aq")),c=n.n(u),p=n("vMJZ"),d=n("+gff");e.a={name:"notice",mixins:[d.a],data:function(){return{show:!1,content:""}},components:{List:c.a,Cell:o.a},created:function(){this.resetInit()},methods:{initData:function(){var t=this,e=(arguments.length>0&&void 0!==arguments[0]&&arguments[0],localStorage.getItem("token"));this.$reqGet(p.B,{token:e,per_page:20,page:1}).then(function(e){return t.loadSuccess(e)}).catch(function(t){})},loadSuccess:function(t){var e,n=t.data.data.list;if(!n)return this.pages;var i={pageCount:t.data.data.pageCount,currPage:t.data.data.currPage,perPage:t.data.data.perPage,totalCount:t.data.data.totalCount};return(e=this.items).push.apply(e,a(n)),i},openNotice:function(t){1==t.type?(this.show=!0,this.content=t.content):2==t.type&&(window.location.href=t.url)}}}},"R+aU":function(t,e,n){"use strict";function a(t){n("s21d")}Object.defineProperty(e,"__esModule",{value:!0});var i=n("BSMq"),r=n("35/g"),o=n("VU/8"),s=a,u=o(i.a,r.a,!1,s,"data-v-13000f34",null);e.default=u.exports},s21d:function(t,e,n){var a=n("sRTV");"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);n("rjj0")("6b3756d9",a,!0,{})},sRTV:function(t,e,n){e=t.exports=n("FZ+f")(!0),e.push([t.i,".bounced[data-v-13000f34]{width:70%;height:60%;padding:20px 10px;font-size:12px}","",{version:3,sources:["D:/phpserver/wwwroot/ditui_clients/src/views/home/notice.vue"],names:[],mappings:"AACA,0BACE,UAAW,AACX,WAAY,AACZ,kBAAmB,AACnB,cAAgB,CACjB",file:"notice.vue",sourcesContent:["\n.bounced[data-v-13000f34] {\n  width: 70%;\n  height: 60%;\n  padding: 20px 10px;\n  font-size: 12px;\n}\n"],sourceRoot:""}])}});
//# sourceMappingURL=36.f3c2b3dc355c1b80b610.js.map