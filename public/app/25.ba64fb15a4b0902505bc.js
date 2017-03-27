webpackJsonp([25],{535:function(e,t,s){var r=s(0)(s(628),s(716),null,null);e.exports=r.exports},605:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=s(530),i=s(531),a=function(e){return e&&e.__esModule?e:{default:e}}(i);t.default={props:{session:{type:Object,required:!0},remove:{type:Boolean,default:!1}},filters:{dateForHumans:r.dateForHumans},components:{TeacherCard:a.default}}},628:function(e,t,s){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=s(5),i=_interopRequireDefault(r),a=s(4),n=s(534),o=_interopRequireDefault(n),c=s(674),u=_interopRequireDefault(c),l=s(531),d=_interopRequireDefault(l),p=s(536),_=_interopRequireDefault(p);t.default={name:"Course",computed:(0,i.default)({title:function(){return this.course?this.course.name:"..."},department:function(){return this.course?this.departmentById(this.course.department_id)||{}:{}},semester:function(){return this.course?this.semesterById(this.course.semester_id)||{}:{}},disciplines:function(){var e=this,t=this.course;return t&&t.prerequisites?t.prerequisites.filter(function(e){return"discipline"===e.constraint_type}).map(function(t){return e.disciplineById(t.constraint_id)}):[]}},(0,a.mapGetters)({departmentById:"departments/departmentById",disciplineById:"disciplines/disciplineById",semesterById:"semesters/semesterById"})),components:{CourseCard:o.default,SessionCard:u.default,TeacherCard:d.default},mixins:[_.default]}},652:function(e,t,s){t=e.exports=s(528)(void 0),t.push([e.i,".c-course-session-card-title{font-size:1.14285rem}.c-course-session-card-subtitle{font-size:.75rem}",""])},664:function(e,t,s){var r=s(652);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);s(529)("ce6346d6",r,!0)},674:function(e,t,s){s(664);var r=s(0)(s(605),s(718),null,null);e.exports=r.exports},716:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("container-window",e._b({attrs:{subtitle:"Course information",back:""},on:{back:function(t){e.$router.go(-1)}}},"container-window",{title:e.title}),[s("template",{slot:"buttons"},[s("router-link",{staticClass:"btn btn-primary",attrs:{to:{name:"course.edit",params:{id:e.id}}}},[e._v("Edit")])],1),e._v(" "),e.course?s("div",{staticClass:"my-3"},[s("div",{staticClass:"container-zero text-center"},[s("img",{staticClass:"rounded m-3",attrs:{src:e.course.photo,height:"128"}})]),e._v(" "),s("div",{staticClass:"conatiner-zero text-center"},[s("h2",{staticClass:"mb-1"},[e._v(e._s(e.course.code)+" - "+e._s(e.course.name))]),e._v(" "),s("p",[s("small",[e._v(e._s(e.department.name))])]),e._v(" "),s("p",[e._v(e._s(e.course.description))])]),e._v(" "),s("h6",{staticClass:"split-header my-3 p-3 text-uppercase"},[e._v("Prerequisite Courses")]),e._v(" "),s("div",{staticClass:"container-zero"},[s("div",{staticClass:"row"},[e._l(e.course.prerequisites,function(t){return s("div",{key:t,staticClass:"col-12 col-lg-6 mb-3"},[s("router-link",{staticClass:"no-link",attrs:{to:{name:"course.show",params:{id:t.id}}}},[s("course-card",e._b({},"course-card",{course:t}))],1)],1)}),e._v(" "),0===e.course.prerequisites.length?s("div",{staticClass:"col-12 py-3 mb-3"},[s("span",{staticClass:"text-muted"},[e._v("No prerequisites")])]):e._e()],2)]),e._v(" "),s("h6",{staticClass:"split-header my-3 p-3 text-uppercase"},[e._v("Sessions")]),e._v(" "),s("div",{staticClass:"container-zero"},[s("div",{staticClass:"row"},[e._l(e.course.sessions,function(t){return s("div",{key:t,staticClass:"col-12 col-lg-6 mb-3"},[s("session-card",e._b({},"session-card",{session:t}))],1)}),e._v(" "),0===e.course.sessions.length?s("div",{staticClass:"col-12 py-3 mb-3"},[s("span",{staticClass:"text-muted"},[e._v("No sessions")])]):e._e()],2)])]):e._e()],2)},staticRenderFns:[]}},718:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("abstract-card",e._b({staticClass:"c-course-session-card",on:{remove:function(t){e.$emit("remove",e.course)}}},"abstract-card",{remove:e.remove,footer:!0}),[s("div",{staticClass:"d-flex flex-column"},[s("div",{staticClass:"c-course-session-card-title card-title",class:{"text-muted":!e.session.name}},[e._v("\n      "+e._s(e.session.name||"Session name not set")+"\n    ")]),e._v(" "),s("div",{staticClass:"c-course-session-card-subtitle"},[s("span",{staticClass:"text-muted"},[e._v("Instructed by:")]),e._v(" "),s("teacher-card",{staticClass:"border-0",attrs:{teacher:e.session.instructor,role:"button"},nativeOn:{click:function(t){e.$router.push({name:"teacher.show",params:{uid:e.session.instructor.uid}})}}})],1)]),e._v(" "),e._t("default"),e._v(" "),s("template",{slot:"footer"},[s("div",{staticClass:"d-flex flex-row align-items-center"},[s("div",{staticClass:"profile-field mb-0 flex-auto text-center"},[s("div",{staticClass:"label"},[e._v("Start Date")]),e._v(" "),s("div",{staticClass:"value"},[e._v(e._s(e._f("dateForHumans")(e.session.started_on)))])]),e._v(" "),s("div",{staticClass:"profile-field mb-0 flex-auto text-center"},[s("div",{staticClass:"label"},[e._v("End Date")]),e._v(" "),s("div",{staticClass:"value"},[e._v(e._s(e._f("dateForHumans")(e.session.ended_on)))])])])])],2)},staticRenderFns:[]}}});
//# sourceMappingURL=25.ba64fb15a4b0902505bc.js.map