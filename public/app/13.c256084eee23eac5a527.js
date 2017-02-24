webpackJsonp([13,39],{436:function(e,t,i){i(763);var n=i(0)(i(635),i(743),null,null);e.exports=n.exports},600:function(e,t,i){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var n=i(3),a=_interopRequireDefault(n),s=i(2),r=_interopRequireDefault(s),l=i(5),o=_interopRequireDefault(l),u=i(4),c=i(39);t.default={name:"InvitePanel",props:{type:{type:String,required:!0}},data:function(){return{invited:0,emails:""}},computed:{placeholder:function(){return"Enter alias address e.g. "+this.type+"@domain.com"}},methods:(0,o.default)({cancel:function(){this.emails=""},sendInvite:function(){var e=this;return(0,r.default)(a.default.mark(function _callee(){var t,i,n,s;return a.default.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:if(t=e.getArrayFromString(e.emails),!t){a.next=9;break}if(i=e.validateEmails(t),!i.length){a.next=9;break}return a.next=6,e.store({emails:i,type:e.type});case 6:n=a.sent,s=n.errors,s?e.setErrors(s):(e.invited+=i.length,e.emails="");case 9:case"end":return a.stop()}},_callee,e)}))()},getArrayFromString:function(e){return e.split(/[;,\s\r\n\t]+/g)},validateEmails:function(e){var t=/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;return e.filter(function(e){return t.test(e)})}},(0,u.mapActions)("invitations",["store"])),mixins:[c.formHelper]}},635:function(e,t,i){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var n=i(709),a=_interopRequireDefault(n),s=i(120),r=_interopRequireDefault(s);t.default={name:"InstituteInvite",data:function(){return{}},components:{InvitePanel:a.default,Sidebar:r.default}}},659:function(e,t,i){t=e.exports=i(398)(),t.push([e.i,".invite-input[data-v-84649728]{padding:rem(20px) 0 rem(10px)}.invite-actions[data-v-84649728]{padding:rem(20px) 0}.btn-default[data-v-84649728]{border:1px solid #9b9b9b}.btn[data-v-84649728]{margin:0 rem(2px);width:rem(100px)}",""])},667:function(e,t,i){t=e.exports=i(398)(),t.push([e.i,"",""])},687:function(e,t,i){var n=i(659);"string"==typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);i(399)("387b770e",n,!0)},701:function(e,t){e.exports="/app/images/resources/assets/app/assets/settings/invitations.svg?627b10743198288a3ab24322ae72712f"},709:function(e,t,i){i(687);var n=i(0)(i(600),i(751),"data-v-84649728",null);e.exports=n.exports},743:function(e,t,i){e.exports={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("container-window",{attrs:{title:"Invites",subtitle:"Invite students,teachers and employees of the institute"}},[n("template",{slot:"sidebar"},[n("sidebar")],1),e._v(" "),n("div",{staticClass:"container-zero my-3 py-3 text-center"},[n("img",{attrs:{src:i(701)}})]),e._v(" "),n("div",{staticClass:"container-fluid text-center"},[n("h2",{staticClass:"text-center my-3 py-3"},[e._v("Invitations")]),e._v(" "),n("p")]),e._v(" "),n("invite-panel",{attrs:{type:"student"}}),e._v(" "),n("invite-panel",{attrs:{type:"teacher"}}),e._v(" "),n("invite-panel",{attrs:{type:"employee"}})],2)},staticRenderFns:[]}},751:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",[i("h6",{staticClass:"split-header text-uppercase text-muted"},[e._v("Invite "+e._s(e.type)+"s")]),e._v(" "),i("div",{staticClass:"container-zero my-3 py-3"},[i("input-textarea",{directives:[{name:"model",rawName:"v-model",value:e.emails,expression:"emails"}],attrs:{title:"Send email invites",errors:e.errors,placeholder:e.placeholder,subtitle:"yes"},domProps:{value:e.emails},on:{input:function(t){e.emails=t}}},[i("template",{slot:"subtitle"},[i("div",{staticClass:"d-flex flex-row"},[i("div",{staticClass:"flex-auto"},[e._v("An invite will be sent to all "+e._s(e.type)+"s using this list.")]),e._v(" "),i("div",{staticClass:"ml-auto text-muted"},[e._v(e._s(e.invited)+" Invited")])])])],2),e._v(" "),i("div",{staticClass:"text-right mt-3"},[e.emails&&e.emails.trim().length>0?i("div",{staticClass:"btn btn-default",attrs:{role:"button"},on:{click:e.cancel}},[e._v("Reset")]):e._e(),e._v(" "),i("div",{staticClass:"btn btn-primary",attrs:{role:"button"},on:{click:e.sendInvite}},[e._v("Send Invite")])])],1)])},staticRenderFns:[]}},763:function(e,t,i){var n=i(667);"string"==typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);i(399)("629cbcd6",n,!0)}});
//# sourceMappingURL=13.c256084eee23eac5a527.js.map