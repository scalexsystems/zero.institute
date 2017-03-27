webpackJsonp([21],{1188:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("container",{attrs:{title:"Employees",subtitle:"Search employees",back:""},on:{back:function(t){e.$router.go(-1)}}},[a("div",{staticClass:"employee-search-container"},[a("div",{staticClass:"container"},[a("h3",{staticClass:"text-center"},[e._v("Employees")]),e._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-12 col-md-6 offset-md-3"},[a("typeahead",e._b({attrs:{"input-class":"form-control-lg",component:"SelectOptionUser"},on:{select:e.onSelect,enter:e.onSearch,search:e.onInput},model:{value:e.query,callback:function(t){e.query=t},expression:"query"}},"typeahead",{suggestions:e.suggestions}))],1)]),e._v(" "),a("p",{staticClass:"text-center"},[e._v("\n        Find employees by their roll number or name.\n      ")])])]),e._v(" "),a("div",{staticClass:"container people-d-links"},[a("div",{staticClass:"card text-center"},[a("div",{staticClass:"card-block"},[a("h5",[e._v("Departments")]),e._v(" "),e._l(e.departments,function(t){return a("div",{key:t,staticClass:"item"},[a("router-link",{staticClass:"btn btn-secondary",attrs:{to:{name:"employee.index",query:{department:[t.id]}}}},[e._v("\n            "+e._s(t.name)+"\n          ")])],1)})],2)])])])},staticRenderFns:[]}},559:function(e,t,a){a(962),a(961);var r=a(0)(a(883),a(1188),"data-v-43e4437a",null);e.exports=r.exports},636:function(e,t,a){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=a(3),n=_interopRequireDefault(r),s=a(2),i=_interopRequireDefault(s),o=a(66),c=_interopRequireDefault(o);t.default={data:function(){return{query:"",suggestions:[]}},methods:{onSearchInput:(0,c.default)(function(){this.fetch()},400),onInput:function(e){this.query=e,this.onSearchInput()},fetch:function(){var e=this;return(0,i.default)(n.default.mark(function _callee(){var t,a;return n.default.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,e.callAPI(e.query);case 2:t=r.sent,a=t.items,a&&(e.suggestions=a);case 5:case"end":return r.stop()}},_callee,e)}))()},onSearch:function(){this.$router.push({name:this.type+".index",query:{q:this.query}})},onSelect:function(e){var t=e.uid;this.$router.push({name:this.type+".show",params:{uid:t}})}},created:function(){this.fetch()}}},776:function(e,t){e.exports="/app/images/resources/assets/app/pages/people/employee/assets/cover.jpg?4392c0684e835fcf64dd190ea00e2288"},777:function(e,t){e.exports="/app/images/resources/assets/app/pages/people/employee/assets/m-cover.jpg?dad1559f59fb9cc95668d5b12c9728dd"},883:function(e,t,a){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=a(3),n=_interopRequireDefault(r),s=a(2),i=_interopRequireDefault(s),o=a(5),c=_interopRequireDefault(o),u=a(4),l=a(636),p=_interopRequireDefault(l);t.default={name:"EmployeeDashboard",data:function(){return{type:"employee"}},computed:(0,u.mapGetters)({departments:"departments/departments"}),methods:(0,c.default)({callAPI:function(e){var t=this;return(0,i.default)(n.default.mark(function _callee(){var a,r;return n.default.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,t.index({q:e});case 2:return a=n.sent,r=a.employees,n.abrupt("return",{items:r});case 5:case"end":return n.stop()}},_callee,t)}))()}},(0,u.mapActions)("employees",["index"])),mixins:[p.default]}},918:function(e,t,a){t=e.exports=a(528)(void 0),t.push([e.i,".people-d-links h5{text-transform:uppercase;letter-spacing:to-rem(1px)}.people-d-links .item{margin:1rem;display:inline-block}",""])},919:function(e,t,a){t=e.exports=a(528)(void 0),t.push([e.i,".employee-search-container[data-v-43e4437a]{background-size:cover;padding-top:8rem;padding-bottom:11rem;margin-bottom:-5rem;color:#fff;background-image:-webkit-linear-gradient(left,rgba(0,0,0,.35),rgba(0,0,0,.35)),url("+a(777)+");background-image:linear-gradient(90deg,rgba(0,0,0,.35),rgba(0,0,0,.35)),url("+a(777)+")}.employee-search-container h3[data-v-43e4437a]{text-transform:uppercase;letter-spacing:to-rem(2px)}@media (min-width:768px){.employee-search-container[data-v-43e4437a]{background-image:-webkit-linear-gradient(left,rgba(0,0,0,.35),rgba(0,0,0,.35)),url("+a(776)+");background-image:linear-gradient(90deg,rgba(0,0,0,.35),rgba(0,0,0,.35)),url("+a(776)+")}}",""])},961:function(e,t,a){var r=a(918);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);a(529)("397a1883",r,!0)},962:function(e,t,a){var r=a(919);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);a(529)("1fcfc367",r,!0)}});
//# sourceMappingURL=21.e64de58784220ea7213a.js.map