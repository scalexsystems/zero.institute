webpackJsonp([21],{1079:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("container",{attrs:{title:"Employees",subtitle:"Search employees",back:""},on:{back:function(t){e.$router.go(-1)}}},[r("div",{staticClass:"employee-search-container"},[r("div",{staticClass:"container"},[r("h3",{staticClass:"text-center"},[e._v("Employees")]),e._v(" "),r("div",{staticClass:"row"},[r("div",{staticClass:"col-12 col-md-6 offset-md-3"},[r("typeahead",e._b({attrs:{"input-class":"form-control-lg",component:"SelectOptionUser"},on:{select:e.onSelect,enter:e.onSearch,search:e.onInput},model:{value:e.query,callback:function(t){e.query=t},expression:"query"}},"typeahead",{suggestions:e.suggestions}))],1)]),e._v(" "),r("p",{staticClass:"text-center"},[e._v("\n        Find employees by their roll number or name.\n      ")])])]),e._v(" "),r("div",{staticClass:"container people-d-links"},[r("div",{staticClass:"card text-center"},[r("div",{staticClass:"card-block"},[r("h5",[e._v("Departments")]),e._v(" "),e._l(e.departments,function(t){return r("div",{key:t,staticClass:"item"},[r("router-link",{staticClass:"btn btn-secondary",attrs:{to:{name:"employee.index",query:{department:[t.id]}}}},[e._v("\n            "+e._s(t.name)+"\n          ")])],1)})],2)])])])},staticRenderFns:[]}},474:function(e,t,r){r(865),r(864);var a=r(0)(r(798),r(1079),"data-v-08049192",null);e.exports=a.exports},551:function(e,t,r){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var a=r(3),n=_interopRequireDefault(a),s=r(2),i=_interopRequireDefault(s),o=r(50),c=_interopRequireDefault(o);t.default={data:function(){return{query:"",suggestions:[]}},methods:{onSearchInput:(0,c.default)(function(){this.fetch()},400),onInput:function(e){this.query=e,this.onSearchInput()},fetch:function(){var e=this;return(0,i.default)(n.default.mark(function _callee(){var t,r;return n.default.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,e.callAPI(e.query);case 2:t=a.sent,r=t.items,r&&(e.suggestions=r);case 5:case"end":return a.stop()}},_callee,e)}))()},onSearch:function(){this.$router.push({name:this.type+".index",query:{q:this.query}})},onSelect:function(e){var t=e.uid;this.$router.push({name:this.type+".show",params:{uid:t}})}},created:function(){this.fetch()}}},691:function(e,t){e.exports="/app/images/resources/assets/app/pages/people/employee/assets/cover.jpg?4392c0684e835fcf64dd190ea00e2288"},692:function(e,t){e.exports="/app/images/resources/assets/app/pages/people/employee/assets/m-cover.jpg?dad1559f59fb9cc95668d5b12c9728dd"},798:function(e,t,r){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var a=r(3),n=_interopRequireDefault(a),s=r(2),i=_interopRequireDefault(s),o=r(5),c=_interopRequireDefault(o),u=r(4),l=r(551),p=_interopRequireDefault(l);t.default={name:"EmployeeDashboard",data:function(){return{type:"employee"}},computed:(0,u.mapGetters)({departments:"departments/departments"}),methods:(0,c.default)({callAPI:function(e){var t=this;return(0,i.default)(n.default.mark(function _callee(){var r,a;return n.default.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,t.index({q:e});case 2:return r=n.sent,a=r.employees,n.abrupt("return",{items:a});case 5:case"end":return n.stop()}},_callee,t)}))()}},(0,u.mapActions)("employees",["index"])),mixins:[p.default]}},821:function(e,t,r){t=e.exports=r(443)(void 0),t.push([e.i,".people-d-links h5{text-transform:uppercase;letter-spacing:to-rem(1px)}.people-d-links .item{margin:1rem;display:inline-block}",""])},822:function(e,t,r){t=e.exports=r(443)(void 0),t.push([e.i,".employee-search-container[data-v-08049192]{background-size:cover;padding-top:8rem;padding-bottom:11rem;margin-bottom:-5rem;color:#fff;background-image:-webkit-linear-gradient(left,rgba(0,0,0,.35),rgba(0,0,0,.35)),url("+r(692)+");background-image:linear-gradient(90deg,rgba(0,0,0,.35),rgba(0,0,0,.35)),url("+r(692)+")}.employee-search-container h3[data-v-08049192]{text-transform:uppercase;letter-spacing:to-rem(2px)}@media (min-width:768px){.employee-search-container[data-v-08049192]{background-image:-webkit-linear-gradient(left,rgba(0,0,0,.35),rgba(0,0,0,.35)),url("+r(691)+");background-image:linear-gradient(90deg,rgba(0,0,0,.35),rgba(0,0,0,.35)),url("+r(691)+")}}",""])},864:function(e,t,r){var a=r(821);"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);r(444)("763ce949",a,!0)},865:function(e,t,r){var a=r(822);"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);r(444)("82a67c3e",a,!0)}});
//# sourceMappingURL=21.911a949fb80ab63a8747.js.map