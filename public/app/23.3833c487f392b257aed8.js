webpackJsonp([23,39],{422:function(e,t,s){s(683);var r=s(0)(s(621),s(745),null,null);e.exports=r.exports},573:function(e,t,s){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=s(5),n=_interopRequireDefault(r),i=s(4);t.default={props:{id:{type:Number,required:!0}},computed:(0,n.default)({user:function(){return this.userById(this.id)}},(0,i.mapGetters)("messages",["userById"])),methods:(0,i.mapActions)("messages",{find:"find"}),created:function(){this.userById(this.id)||this.find(this.id)},watch:{id:function(e){this.userById(e)||this.find(e)}}}},621:function(e,t,s){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=s(5),n=_interopRequireDefault(r),i=s(4),u=s(573),a=_interopRequireDefault(u);t.default={name:"User",computed:(0,n.default)({title:function(){var e=this.user||{};return e.name||"..."},subtitle:function(){var e=this.user||{};return e.bio||"View information"},department:function(){var e=this.user||{person:{}};return this.departmentById(e.person.department_id)||{}}},(0,i.mapGetters)("departments",["departmentById"])),mixins:[a.default]}},655:function(e,t,s){t=e.exports=s(398)(),t.push([e.i,".user-preview-photo{width:11.42857rem;height:11.42857rem;border-radius:.2rem}.user-preview-tag{padding:.5rem}",""])},683:function(e,t,s){var r=s(655);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);s(399)("eecb271e",r,!0)},745:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("container-window",e._b({attrs:{back:""},on:{back:function(t){e.$router.go(-1)}}},"container-window",{title:e.title,subtitle:e.subtitle}),[e.user?s("div",{staticClass:"container py-2"},[s("div",{staticClass:"text-center"},[s("img",{staticClass:"user-preview-photo my-2",attrs:{src:e.user.photo}}),e._v(" "),s("h2",[e._v(e._s(e.user.name))]),e._v(" "),s("p",["student"===e.user.type?s("span",{staticClass:"text-muted"},[e._v("Roll Number:")]):s("span",{staticClass:"text-muted"},[e._v("Employee ID:")]),e._v(" "+e._s(e.user.person.uid)+"\n      ")]),e._v(" "),"student"===e.user.type?s("p",[e._v("\n        Student · "+e._s(e.department.name)+"\n      ")]):"teacher"===e.user.type?s("p",[e._v("\n        "+e._s(e.user.person.designation||"Teacher")+" · "+e._s(e.department.name)+"\n      ")]):"employee"===e.user.type?s("p",[e._v("\n        "+e._s(e.user.person.designation||"Employee")+" · "+e._s(e.department.name)+"\n      ")]):e._e(),e._v(" "),s("div",{staticClass:"my-3"},[s("router-link",{staticClass:"btn btn-primary",attrs:{to:{name:"user.messages",params:{id:e.user.id}}}},[e._v("Send Message")]),e._v(" "),s("router-link",{staticClass:"btn btn-secondary",attrs:{to:{name:e.user.type+".show",params:{uid:e.user.person.uid}}}},[e._v("View Profile")])],1)])]):s("loading")],1)},staticRenderFns:[]}}});
//# sourceMappingURL=23.3833c487f392b257aed8.js.map