webpackJsonp([31,40],{1006:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("container-window",{attrs:{title:"Courses",subtitle:"Join or create courses",back:""},on:{back:function(t){e.$router.go(-1)}}},[r("template",{slot:"buttons"},[r("router-link",{staticClass:"btn btn-primary",attrs:{to:{name:"course.create"}}},[e._v("Create Course")])],1),e._v(" "),r("searchable-list",{directives:[{name:"model",rawName:"v-model",value:e.query,expression:"query"}],ref:"list",staticClass:"my-3",attrs:{placeholder:"Start typing..."},domProps:{value:e.query},on:{infinite:function(e){var t=e.complete;return t()},input:function(t){e.query=t}}},[r("div",{staticClass:"row"},e._l(e.items,function(e){return r("router-link",{key:e,staticClass:"col-12 col-lg-6 mt-3 no-link",attrs:{to:{name:"course.show",params:{id:e.id}}}},[r("course-card",{attrs:{course:e}})],1)}))])],2)},staticRenderFns:[]}},418:function(e,t,r){var s=r(0)(r(728),r(1006),null,null);e.exports=s.exports},728:function(e,t,r){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var s=r(5),n=_interopRequireDefault(s),o=r(51),u=_interopRequireDefault(o),a=r(4),i=r(410),c=_interopRequireDefault(i);t.default={name:"CourseDirectory",data:function(){return{query:""}},computed:(0,n.default)({items:function(){var e=this,t=this.query,r=new u.default(this.courses||[]),s=r.search(t,{fields:["name","code"]});return s.items.map(function(t){var r=t.id;return e.courses[r]})}},(0,a.mapGetters)("courses",["courses"])),methods:(0,n.default)({},(0,a.mapActions)("courses",["index"])),created:function(){this.index()},components:{CourseCard:c.default}}}});
//# sourceMappingURL=31.16080261716f56b0b2e4.js.map