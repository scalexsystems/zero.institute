webpackJsonp([25,39],{420:function(e,t,n){n(674);var r=n(0)(n(619),n(733),null,null);e.exports=r.exports},619:function(e,t,n){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=n(3),a=_interopRequireDefault(r),o=n(118),i=_interopRequireDefault(o),s=n(2),u=_interopRequireDefault(s),c=n(5),l=_interopRequireDefault(c),p=n(115),f=_interopRequireDefault(p),d=n(4);t.default={name:"PeopleDirectory",data:function(){return{page:1,query:"",persons:[]}},methods:(0,l.default)({onSearch:(0,f.default)(function(){this.$refs.list.$emit("reset"),this.page=1,this.onLoad()},800),onLoad:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},n=t.loaded,r=void 0===n?function(){return 0}:n,o=t.complete,s=void 0===o?function(){return 0}:o;return(0,u.default)(a.default.mark(function _callee(){var t,n,o,u;return a.default.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,e.index({page:e.page,query:e.query});case 2:if(t=a.sent,n=t.meta,o=t.items,!n){a.next=12;break}if(1===e.page&&(e.persons=[]),o&&(u=e.persons).splice.apply(u,[e.persons.length,0].concat((0,i.default)(o))),e.page=n.pagination.current_page+1,!(n.pagination.current_page<n.pagination.total_pages)){a.next=12;break}return r(),a.abrupt("return",!0);case 12:s();case 13:case"end":return a.stop()}},_callee,e)}))()},goToUser:function(e){this.$router.push({name:"user.messages",params:{id:e.user_id}})}},(0,d.mapActions)("people",["index"])),created:function(){0===this.persons.length&&this.index()}}},646:function(e,t,n){t=e.exports=n(398)(),t.push([e.i,"",""])},674:function(e,t,n){var r=n(646);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);n(399)("32e736a4",r,!0)},733:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("container-window",{attrs:{title:"People",subtitle:"Send direct messages",back:!0},on:{back:function(t){e.$router.go(-1)}}},[n("searchable-list",{directives:[{name:"model",rawName:"v-model",value:e.query,expression:"query"}],ref:"list",staticClass:"mt-3",attrs:{placeholder:"Start typing..."},domProps:{value:e.query},on:{search:e.onSearch,infinite:e.onLoad,input:function(t){e.query=t}}},[n("div",{staticClass:"row"},e._l(e.persons,function(t){return n("div",{key:t,staticClass:"col-12 col-lg-6 mt-3"},[n("user-card",{attrs:{user:t,role:"button"},nativeOn:{click:function(n){e.goToUser(t)}}})],1)}))])],1)},staticRenderFns:[]}}});
//# sourceMappingURL=25.45449041dc47d4a413bc.js.map