webpackJsonp([9,25],{1053:function(e,t,s){var r=s(0)(s(755),s(1111),null,null);e.exports=r.exports},1100:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("container-window",e._b({attrs:{subtitle:"Enroll students",back:""},on:{back:function(t){e.$router.go(-1)}}},"container-window",{title:e.title}),[e.course&&e.session?s("div",{staticClass:"row"},[s("enrollment-list",{staticClass:"col-12 mt-3",attrs:{session:e.session}}),e._v(" "),s("div",{staticClass:"col-12",staticStyle:{"margin-bottom":"128px"}})],1):s("div",{staticClass:"row"},[s("div",{staticClass:"col-12"},[s("loading")],1)])])},staticRenderFns:[]}},1111:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"container-zero"},[s("typeahead",e._b({attrs:{component:"SelectOptionUser",placeholder:"Start typing..."},on:{search:e.onSearch,select:e.add}},"typeahead",{suggestions:e.items,value:[]})),e._v(" "),s("div",{staticClass:"row"},[e.error?s("div",{staticClass:"col-12 mt-3"},[s("alert",{attrs:{type:"danger",dissmissable:""},domProps:{innerHTML:e._s(e.error)}})],1):e._e(),e._v(" "),e._l(e.source,function(t){return s("div",{key:t,staticClass:"col-12 col-lg-6 mt-3"},[s("student-card",{attrs:{student:t,remove:""},on:{remove:function(s){e.remove(t)}}})],1)}),e._v(" "),0===e.source.length?s("div",{staticClass:"col-12 my-3 py-3 text-center text-muted"},[e._v("\n      No Students\n    ")]):e._e()],2)],1)},staticRenderFns:[]}},450:function(e,t,s){var r=s(0)(s(543),s(629),null,null);e.exports=r.exports},460:function(e,t,s){s(879);var r=s(0)(s(784),s(1100),null,null);e.exports=r.exports},520:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=s(445),n=s(446),i=function(e){return e&&e.__esModule?e:{default:e}}(n);t.default={props:{session:{type:Object,required:!0},remove:{type:Boolean,default:!1}},filters:{dateForHumans:r.dateForHumans},components:{TeacherCard:i.default}}},543:function(e,t,s){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=s(5),n=_interopRequireDefault(r),i=s(4),o=s(449),a=_interopRequireDefault(o),l=s(589),u=_interopRequireDefault(l),c=s(446),p=_interopRequireDefault(c),d=s(451),h=_interopRequireDefault(d);t.default={name:"Course",computed:(0,n.default)({title:function(){return this.course?this.course.name:"..."},department:function(){return this.course?this.departmentById(this.course.department_id)||{}:{}},semester:function(){return this.course?this.semesterById(this.course.semester_id)||{}:{}},disciplines:function(){var e=this,t=this.course;return t&&t.prerequisites?t.prerequisites.filter(function(e){return"discipline"===e.constraint_type}).map(function(t){return e.disciplineById(t.constraint_id)}):[]}},(0,i.mapGetters)({departmentById:"departments/departmentById",disciplineById:"disciplines/disciplineById",semesterById:"semesters/semesterById"})),components:{CourseCard:a.default,SessionCard:u.default,TeacherCard:p.default},mixins:[h.default]}},561:function(e,t,s){t=e.exports=s(443)(void 0),t.push([e.i,".c-course-session-card-title{font-size:1.14285rem}.c-course-session-card-subtitle{font-size:.75rem}",""])},573:function(e,t,s){var r=s(561);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);s(444)("69a9281c",r,!0)},589:function(e,t,s){s(573);var r=s(0)(s(520),s(611),null,null);e.exports=r.exports},611:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("abstract-card",e._b({staticClass:"c-course-session-card",on:{remove:function(t){e.$emit("remove",e.course)}}},"abstract-card",{remove:e.remove,footer:!0}),[s("div",{staticClass:"d-flex flex-column"},[s("div",{staticClass:"c-course-session-card-title card-title",class:{"text-muted":!e.session.name}},[e._v("\n      "+e._s(e.session.name||"Session name not set")+"\n    ")]),e._v(" "),s("div",{staticClass:"c-course-session-card-subtitle"},[s("span",{staticClass:"text-muted"},[e._v("Instructed by:")]),e._v(" "),s("teacher-card",{staticClass:"border-0",attrs:{teacher:e.session.instructor,role:"button"},nativeOn:{click:function(t){e.$router.push({name:"teacher.show",params:{uid:e.session.instructor.uid}})}}})],1)]),e._v(" "),e._t("default"),e._v(" "),s("template",{slot:"footer"},[s("div",{staticClass:"d-flex flex-row align-items-center"},[s("div",{staticClass:"profile-field mb-0 flex-auto text-center"},[s("div",{staticClass:"label"},[e._v("Start Date")]),e._v(" "),s("div",{staticClass:"value"},[e._v(e._s(e._f("dateForHumans")(e.session.started_on)))])]),e._v(" "),s("div",{staticClass:"profile-field mb-0 flex-auto text-center"},[s("div",{staticClass:"label"},[e._v("End Date")]),e._v(" "),s("div",{staticClass:"value"},[e._v(e._s(e._f("dateForHumans")(e.session.ended_on)))])])])])],2)},staticRenderFns:[]}},629:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("container-window",e._b({attrs:{subtitle:"Course information",back:""},on:{back:function(t){e.$router.go(-1)}}},"container-window",{title:e.title}),[s("template",{slot:"buttons"},[s("router-link",{staticClass:"btn btn-primary",attrs:{to:{name:"course.edit",params:{id:e.id}}}},[e._v("Edit")])],1),e._v(" "),e.course?s("div",{staticClass:"my-3"},[s("div",{staticClass:"container-zero text-center"},[s("img",{staticClass:"rounded m-3",attrs:{src:e.course.photo,height:"128"}})]),e._v(" "),s("div",{staticClass:"conatiner-zero text-center"},[s("h2",{staticClass:"mb-1"},[e._v(e._s(e.course.code)+" - "+e._s(e.course.name))]),e._v(" "),s("p",[s("small",[e._v(e._s(e.department.name))])]),e._v(" "),s("p",[e._v(e._s(e.course.description))])]),e._v(" "),s("h6",{staticClass:"split-header my-3 p-3 text-uppercase"},[e._v("Prerequisite Courses")]),e._v(" "),s("div",{staticClass:"container-zero"},[s("div",{staticClass:"row"},[e._l(e.course.prerequisites,function(t){return s("div",{key:t,staticClass:"col-12 col-lg-6 mb-3"},[s("router-link",{staticClass:"no-link",attrs:{to:{name:"course.show",params:{id:t.id}}}},[s("course-card",e._b({},"course-card",{course:t}))],1)],1)}),e._v(" "),0===e.course.prerequisites.length?s("div",{staticClass:"col-12 py-3 mb-3"},[s("span",{staticClass:"text-muted"},[e._v("No prerequisites")])]):e._e()],2)]),e._v(" "),s("h6",{staticClass:"split-header my-3 p-3 text-uppercase"},[e._v("Sessions")]),e._v(" "),s("div",{staticClass:"container-zero"},[s("div",{staticClass:"row"},[e._l(e.course.sessions,function(t){return s("div",{key:t,staticClass:"col-12 col-lg-6 mb-3"},[s("session-card",e._b({},"session-card",{session:t}))],1)}),e._v(" "),0===e.course.sessions.length?s("div",{staticClass:"col-12 py-3 mb-3"},[s("span",{staticClass:"text-muted"},[e._v("No sessions")])]):e._e()],2)])]):e._e()],2)},staticRenderFns:[]}},649:function(e,t,s){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=s(3),n=_interopRequireDefault(r),i=s(2),o=_interopRequireDefault(i),a=s(5),l=_interopRequireDefault(a),u=s(51),c=_interopRequireDefault(u),p=s(4),d=s(447),h=_interopRequireDefault(d);t.default={name:"CourseSessionEnrollmentList",props:{session:{type:Object,required:!0}},data:function(){return{query:"",source:[]}},computed:{students:function students(){var students=this.source;return new c.default(students).search(this.query,{fields:["uid","name"]}).items.map(function(e){var t=e.id;return students[t]})}},methods:(0,l.default)({init:function(){var e=this;return(0,o.default)(n.default.mark(function _callee(){var t,s;return n.default.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,e.enrollments(e.session.id);case 2:t=r.sent,s=t.students,e.source=s||[];case 5:case"end":return r.stop()}},_callee,e)}))()}},(0,p.mapActions)("courses",["enrollments"])),components:{StudentCard:h.default},created:function(){this.init()},watch:{$route:function(){this.init()}}}},683:function(e,t,s){(function(t){(function(){function Lexer(e){this.tokens=[],this.tokens.links={},this.options=e||marked.defaults,this.rules=t.normal,this.options.gfm&&(this.options.tables?this.rules=t.tables:this.rules=t.gfm)}function InlineLexer(e,t){if(this.options=t||marked.defaults,this.links=e,this.rules=s.normal,this.renderer=this.options.renderer||new Renderer,this.renderer.options=this.options,!this.links)throw new Error("Tokens array requires a `links` property.");this.options.gfm?this.options.breaks?this.rules=s.breaks:this.rules=s.gfm:this.options.pedantic&&(this.rules=s.pedantic)}function Renderer(e){this.options=e||{}}function Parser(e){this.tokens=[],this.token=null,this.options=e||marked.defaults,this.options.renderer=this.options.renderer||new Renderer,this.renderer=this.options.renderer,this.renderer.options=this.options}function escape(e,t){return e.replace(t?/&/g:/&(?!#?\w+;)/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#39;")}function unescape(e){return e.replace(/&(#(?:\d+)|(?:#x[0-9A-Fa-f]+)|(?:\w+));?/g,function(e,t){return t=t.toLowerCase(),"colon"===t?":":"#"===t.charAt(0)?"x"===t.charAt(1)?String.fromCharCode(parseInt(t.substring(2),16)):String.fromCharCode(+t.substring(1)):""})}function replace(e,t){return e=e.source,t=t||"",function self(s,r){return s?(r=r.source||r,r=r.replace(/(^|[^\[])\^/g,"$1"),e=e.replace(s,r),self):new RegExp(e,t)}}function noop(){}function merge(e){for(var t,s,r=1;r<arguments.length;r++){t=arguments[r];for(s in t)Object.prototype.hasOwnProperty.call(t,s)&&(e[s]=t[s])}return e}function marked(e,t,s){if(s||"function"==typeof t){s||(s=t,t=null),t=merge({},marked.defaults,t||{});var r,n,i=t.highlight,o=0;try{r=Lexer.lex(e,t)}catch(e){return s(e)}n=r.length;var a=function(e){if(e)return t.highlight=i,s(e);var n;try{n=Parser.parse(r,t)}catch(t){e=t}return t.highlight=i,e?s(e):s(null,n)};if(!i||i.length<3)return a();if(delete t.highlight,!n)return a();for(;o<r.length;o++)!function(e){"code"!==e.type?--n||a():i(e.text,e.lang,function(t,s){return t?a(t):null==s||s===e.text?--n||a():(e.text=s,e.escaped=!0,void(--n||a()))})}(r[o])}else try{return t&&(t=merge({},marked.defaults,t)),Parser.parse(Lexer.lex(e,t),t)}catch(e){if(e.message+="\nPlease report this to https://github.com/chjj/marked.",(t||marked.defaults).silent)return"<p>An error occured:</p><pre>"+escape(e.message+"",!0)+"</pre>";throw e}}var t={newline:/^\n+/,code:/^( {4}[^\n]+\n*)+/,fences:noop,hr:/^( *[-*_]){3,} *(?:\n+|$)/,heading:/^ *(#{1,6}) *([^\n]+?) *#* *(?:\n+|$)/,nptable:noop,lheading:/^([^\n]+)\n *(=|-){2,} *(?:\n+|$)/,blockquote:/^( *>[^\n]+(\n(?!def)[^\n]+)*\n*)+/,list:/^( *)(bull) [\s\S]+?(?:hr|def|\n{2,}(?! )(?!\1bull )\n*|\s*$)/,html:/^ *(?:comment *(?:\n|\s*$)|closed *(?:\n{2,}|\s*$)|closing *(?:\n{2,}|\s*$))/,def:/^ *\[([^\]]+)\]: *<?([^\s>]+)>?(?: +["(]([^\n]+)[")])? *(?:\n+|$)/,table:noop,paragraph:/^((?:[^\n]+\n?(?!hr|heading|lheading|blockquote|tag|def))+)\n*/,text:/^[^\n]+/};t.bullet=/(?:[*+-]|\d+\.)/,t.item=/^( *)(bull) [^\n]*(?:\n(?!\1bull )[^\n]*)*/,t.item=replace(t.item,"gm")(/bull/g,t.bullet)(),t.list=replace(t.list)(/bull/g,t.bullet)("hr","\\n+(?=\\1?(?:[-*_] *){3,}(?:\\n+|$))")("def","\\n+(?="+t.def.source+")")(),t.blockquote=replace(t.blockquote)("def",t.def)(),t._tag="(?!(?:a|em|strong|small|s|cite|q|dfn|abbr|data|time|code|var|samp|kbd|sub|sup|i|b|u|mark|ruby|rt|rp|bdi|bdo|span|br|wbr|ins|del|img)\\b)\\w+(?!:/|[^\\w\\s@]*@)\\b",t.html=replace(t.html)("comment",/<!--[\s\S]*?-->/)("closed",/<(tag)[\s\S]+?<\/\1>/)("closing",/<tag(?:"[^"]*"|'[^']*'|[^'">])*?>/)(/tag/g,t._tag)(),t.paragraph=replace(t.paragraph)("hr",t.hr)("heading",t.heading)("lheading",t.lheading)("blockquote",t.blockquote)("tag","<"+t._tag)("def",t.def)(),t.normal=merge({},t),t.gfm=merge({},t.normal,{fences:/^ *(`{3,}|~{3,})[ \.]*(\S+)? *\n([\s\S]*?)\s*\1 *(?:\n+|$)/,paragraph:/^/,heading:/^ *(#{1,6}) +([^\n]+?) *#* *(?:\n+|$)/}),t.gfm.paragraph=replace(t.paragraph)("(?!","(?!"+t.gfm.fences.source.replace("\\1","\\2")+"|"+t.list.source.replace("\\1","\\3")+"|")(),t.tables=merge({},t.gfm,{nptable:/^ *(\S.*\|.*)\n *([-:]+ *\|[-| :]*)\n((?:.*\|.*(?:\n|$))*)\n*/,table:/^ *\|(.+)\n *\|( *[-:]+[-| :]*)\n((?: *\|.*(?:\n|$))*)\n*/}),Lexer.rules=t,Lexer.lex=function(e,t){return new Lexer(t).lex(e)},Lexer.prototype.lex=function(e){return e=e.replace(/\r\n|\r/g,"\n").replace(/\t/g,"    ").replace(/\u00a0/g," ").replace(/\u2424/g,"\n"),this.token(e,!0)},Lexer.prototype.token=function(e,s,r){for(var n,i,o,a,l,u,c,p,d,e=e.replace(/^ +$/gm,"");e;)if((o=this.rules.newline.exec(e))&&(e=e.substring(o[0].length),o[0].length>1&&this.tokens.push({type:"space"})),o=this.rules.code.exec(e))e=e.substring(o[0].length),o=o[0].replace(/^ {4}/gm,""),this.tokens.push({type:"code",text:this.options.pedantic?o:o.replace(/\n+$/,"")});else if(o=this.rules.fences.exec(e))e=e.substring(o[0].length),this.tokens.push({type:"code",lang:o[2],text:o[3]||""});else if(o=this.rules.heading.exec(e))e=e.substring(o[0].length),this.tokens.push({type:"heading",depth:o[1].length,text:o[2]});else if(s&&(o=this.rules.nptable.exec(e))){for(e=e.substring(o[0].length),u={type:"table",header:o[1].replace(/^ *| *\| *$/g,"").split(/ *\| */),align:o[2].replace(/^ *|\| *$/g,"").split(/ *\| */),cells:o[3].replace(/\n$/,"").split("\n")},p=0;p<u.align.length;p++)/^ *-+: *$/.test(u.align[p])?u.align[p]="right":/^ *:-+: *$/.test(u.align[p])?u.align[p]="center":/^ *:-+ *$/.test(u.align[p])?u.align[p]="left":u.align[p]=null;for(p=0;p<u.cells.length;p++)u.cells[p]=u.cells[p].split(/ *\| */);this.tokens.push(u)}else if(o=this.rules.lheading.exec(e))e=e.substring(o[0].length),this.tokens.push({type:"heading",depth:"="===o[2]?1:2,text:o[1]});else if(o=this.rules.hr.exec(e))e=e.substring(o[0].length),this.tokens.push({type:"hr"});else if(o=this.rules.blockquote.exec(e))e=e.substring(o[0].length),this.tokens.push({type:"blockquote_start"}),o=o[0].replace(/^ *> ?/gm,""),this.token(o,s,!0),this.tokens.push({type:"blockquote_end"});else if(o=this.rules.list.exec(e)){for(e=e.substring(o[0].length),a=o[2],this.tokens.push({type:"list_start",ordered:a.length>1}),o=o[0].match(this.rules.item),n=!1,d=o.length,p=0;p<d;p++)u=o[p],c=u.length,u=u.replace(/^ *([*+-]|\d+\.) +/,""),~u.indexOf("\n ")&&(c-=u.length,u=this.options.pedantic?u.replace(/^ {1,4}/gm,""):u.replace(new RegExp("^ {1,"+c+"}","gm"),"")),this.options.smartLists&&p!==d-1&&(l=t.bullet.exec(o[p+1])[0],a===l||a.length>1&&l.length>1||(e=o.slice(p+1).join("\n")+e,p=d-1)),i=n||/\n\n(?!\s*$)/.test(u),p!==d-1&&(n="\n"===u.charAt(u.length-1),i||(i=n)),this.tokens.push({type:i?"loose_item_start":"list_item_start"}),this.token(u,!1,r),this.tokens.push({type:"list_item_end"});this.tokens.push({type:"list_end"})}else if(o=this.rules.html.exec(e))e=e.substring(o[0].length),this.tokens.push({type:this.options.sanitize?"paragraph":"html",pre:!this.options.sanitizer&&("pre"===o[1]||"script"===o[1]||"style"===o[1]),text:o[0]});else if(!r&&s&&(o=this.rules.def.exec(e)))e=e.substring(o[0].length),this.tokens.links[o[1].toLowerCase()]={href:o[2],title:o[3]};else if(s&&(o=this.rules.table.exec(e))){for(e=e.substring(o[0].length),u={type:"table",header:o[1].replace(/^ *| *\| *$/g,"").split(/ *\| */),align:o[2].replace(/^ *|\| *$/g,"").split(/ *\| */),cells:o[3].replace(/(?: *\| *)?\n$/,"").split("\n")},p=0;p<u.align.length;p++)/^ *-+: *$/.test(u.align[p])?u.align[p]="right":/^ *:-+: *$/.test(u.align[p])?u.align[p]="center":/^ *:-+ *$/.test(u.align[p])?u.align[p]="left":u.align[p]=null;for(p=0;p<u.cells.length;p++)u.cells[p]=u.cells[p].replace(/^ *\| *| *\| *$/g,"").split(/ *\| */);this.tokens.push(u)}else if(s&&(o=this.rules.paragraph.exec(e)))e=e.substring(o[0].length),this.tokens.push({type:"paragraph",text:"\n"===o[1].charAt(o[1].length-1)?o[1].slice(0,-1):o[1]});else if(o=this.rules.text.exec(e))e=e.substring(o[0].length),this.tokens.push({type:"text",text:o[0]});else if(e)throw new Error("Infinite loop on byte: "+e.charCodeAt(0));return this.tokens};var s={escape:/^\\([\\`*{}\[\]()#+\-.!_>])/,autolink:/^<([^ >]+(@|:\/)[^ >]+)>/,url:noop,tag:/^<!--[\s\S]*?-->|^<\/?\w+(?:"[^"]*"|'[^']*'|[^'">])*?>/,link:/^!?\[(inside)\]\(href\)/,reflink:/^!?\[(inside)\]\s*\[([^\]]*)\]/,nolink:/^!?\[((?:\[[^\]]*\]|[^\[\]])*)\]/,strong:/^__([\s\S]+?)__(?!_)|^\*\*([\s\S]+?)\*\*(?!\*)/,em:/^\b_((?:[^_]|__)+?)_\b|^\*((?:\*\*|[\s\S])+?)\*(?!\*)/,code:/^(`+)\s*([\s\S]*?[^`])\s*\1(?!`)/,br:/^ {2,}\n(?!\s*$)/,del:noop,text:/^[\s\S]+?(?=[\\<!\[_*`]| {2,}\n|$)/};s._inside=/(?:\[[^\]]*\]|[^\[\]]|\](?=[^\[]*\]))*/,s._href=/\s*<?([\s\S]*?)>?(?:\s+['"]([\s\S]*?)['"])?\s*/,s.link=replace(s.link)("inside",s._inside)("href",s._href)(),s.reflink=replace(s.reflink)("inside",s._inside)(),s.normal=merge({},s),s.pedantic=merge({},s.normal,{strong:/^__(?=\S)([\s\S]*?\S)__(?!_)|^\*\*(?=\S)([\s\S]*?\S)\*\*(?!\*)/,em:/^_(?=\S)([\s\S]*?\S)_(?!_)|^\*(?=\S)([\s\S]*?\S)\*(?!\*)/}),s.gfm=merge({},s.normal,{escape:replace(s.escape)("])","~|])")(),url:/^(https?:\/\/[^\s<]+[^<.,:;"')\]\s])/,del:/^~~(?=\S)([\s\S]*?\S)~~/,text:replace(s.text)("]|","~]|")("|","|https?://|")()}),s.breaks=merge({},s.gfm,{br:replace(s.br)("{2,}","*")(),text:replace(s.gfm.text)("{2,}","*")()}),InlineLexer.rules=s,InlineLexer.output=function(e,t,s){return new InlineLexer(t,s).output(e)},InlineLexer.prototype.output=function(e){for(var t,s,r,n,i="";e;)if(n=this.rules.escape.exec(e))e=e.substring(n[0].length),i+=n[1];else if(n=this.rules.autolink.exec(e))e=e.substring(n[0].length),"@"===n[2]?(s=":"===n[1].charAt(6)?this.mangle(n[1].substring(7)):this.mangle(n[1]),r=this.mangle("mailto:")+s):(s=escape(n[1]),r=s),i+=this.renderer.link(r,null,s);else if(this.inLink||!(n=this.rules.url.exec(e))){if(n=this.rules.tag.exec(e))!this.inLink&&/^<a /i.test(n[0])?this.inLink=!0:this.inLink&&/^<\/a>/i.test(n[0])&&(this.inLink=!1),e=e.substring(n[0].length),i+=this.options.sanitize?this.options.sanitizer?this.options.sanitizer(n[0]):escape(n[0]):n[0];else if(n=this.rules.link.exec(e))e=e.substring(n[0].length),this.inLink=!0,i+=this.outputLink(n,{href:n[2],title:n[3]}),this.inLink=!1;else if((n=this.rules.reflink.exec(e))||(n=this.rules.nolink.exec(e))){if(e=e.substring(n[0].length),t=(n[2]||n[1]).replace(/\s+/g," "),!(t=this.links[t.toLowerCase()])||!t.href){i+=n[0].charAt(0),e=n[0].substring(1)+e;continue}this.inLink=!0,i+=this.outputLink(n,t),this.inLink=!1}else if(n=this.rules.strong.exec(e))e=e.substring(n[0].length),i+=this.renderer.strong(this.output(n[2]||n[1]));else if(n=this.rules.em.exec(e))e=e.substring(n[0].length),i+=this.renderer.em(this.output(n[2]||n[1]));else if(n=this.rules.code.exec(e))e=e.substring(n[0].length),i+=this.renderer.codespan(escape(n[2],!0));else if(n=this.rules.br.exec(e))e=e.substring(n[0].length),i+=this.renderer.br();else if(n=this.rules.del.exec(e))e=e.substring(n[0].length),i+=this.renderer.del(this.output(n[1]));else if(n=this.rules.text.exec(e))e=e.substring(n[0].length),i+=this.renderer.text(escape(this.smartypants(n[0])));else if(e)throw new Error("Infinite loop on byte: "+e.charCodeAt(0))}else e=e.substring(n[0].length),s=escape(n[1]),r=s,i+=this.renderer.link(r,null,s);return i},InlineLexer.prototype.outputLink=function(e,t){var s=escape(t.href),r=t.title?escape(t.title):null;return"!"!==e[0].charAt(0)?this.renderer.link(s,r,this.output(e[1])):this.renderer.image(s,r,escape(e[1]))},InlineLexer.prototype.smartypants=function(e){return this.options.smartypants?e.replace(/---/g,"—").replace(/--/g,"–").replace(/(^|[-\u2014\/(\[{"\s])'/g,"$1‘").replace(/'/g,"’").replace(/(^|[-\u2014\/(\[{\u2018\s])"/g,"$1“").replace(/"/g,"”").replace(/\.{3}/g,"…"):e},InlineLexer.prototype.mangle=function(e){if(!this.options.mangle)return e;for(var t,s="",r=e.length,n=0;n<r;n++)t=e.charCodeAt(n),Math.random()>.5&&(t="x"+t.toString(16)),s+="&#"+t+";";return s},Renderer.prototype.code=function(e,t,s){if(this.options.highlight){var r=this.options.highlight(e,t);null!=r&&r!==e&&(s=!0,e=r)}return t?'<pre><code class="'+this.options.langPrefix+escape(t,!0)+'">'+(s?e:escape(e,!0))+"\n</code></pre>\n":"<pre><code>"+(s?e:escape(e,!0))+"\n</code></pre>"},Renderer.prototype.blockquote=function(e){return"<blockquote>\n"+e+"</blockquote>\n"},Renderer.prototype.html=function(e){return e},Renderer.prototype.heading=function(e,t,s){return"<h"+t+' id="'+this.options.headerPrefix+s.toLowerCase().replace(/[^\w]+/g,"-")+'">'+e+"</h"+t+">\n"},Renderer.prototype.hr=function(){return this.options.xhtml?"<hr/>\n":"<hr>\n"},Renderer.prototype.list=function(e,t){var s=t?"ol":"ul";return"<"+s+">\n"+e+"</"+s+">\n"},Renderer.prototype.listitem=function(e){return"<li>"+e+"</li>\n"},Renderer.prototype.paragraph=function(e){return"<p>"+e+"</p>\n"},Renderer.prototype.table=function(e,t){return"<table>\n<thead>\n"+e+"</thead>\n<tbody>\n"+t+"</tbody>\n</table>\n"},Renderer.prototype.tablerow=function(e){return"<tr>\n"+e+"</tr>\n"},Renderer.prototype.tablecell=function(e,t){var s=t.header?"th":"td";return(t.align?"<"+s+' style="text-align:'+t.align+'">':"<"+s+">")+e+"</"+s+">\n"},Renderer.prototype.strong=function(e){return"<strong>"+e+"</strong>"},Renderer.prototype.em=function(e){return"<em>"+e+"</em>"},Renderer.prototype.codespan=function(e){return"<code>"+e+"</code>"},Renderer.prototype.br=function(){return this.options.xhtml?"<br/>":"<br>"},Renderer.prototype.del=function(e){return"<del>"+e+"</del>"},Renderer.prototype.link=function(e,t,s){if(this.options.sanitize){try{var r=decodeURIComponent(unescape(e)).replace(/[^\w:]/g,"").toLowerCase()}catch(e){return""}if(0===r.indexOf("javascript:")||0===r.indexOf("vbscript:"))return""}var n='<a href="'+e+'"';return t&&(n+=' title="'+t+'"'),n+=">"+s+"</a>"},Renderer.prototype.image=function(e,t,s){var r='<img src="'+e+'" alt="'+s+'"';return t&&(r+=' title="'+t+'"'),r+=this.options.xhtml?"/>":">"},Renderer.prototype.text=function(e){return e},Parser.parse=function(e,t,s){return new Parser(t,s).parse(e)},Parser.prototype.parse=function(e){this.inline=new InlineLexer(e.links,this.options,this.renderer),this.tokens=e.reverse();for(var t="";this.next();)t+=this.tok();return t},Parser.prototype.next=function(){return this.token=this.tokens.pop()},Parser.prototype.peek=function(){return this.tokens[this.tokens.length-1]||0},Parser.prototype.parseText=function(){for(var e=this.token.text;"text"===this.peek().type;)e+="\n"+this.next().text;return this.inline.output(e)},Parser.prototype.tok=function(){switch(this.token.type){case"space":return"";case"hr":return this.renderer.hr();case"heading":return this.renderer.heading(this.inline.output(this.token.text),this.token.depth,this.token.text);case"code":return this.renderer.code(this.token.text,this.token.lang,this.token.escaped);case"table":var e,t,s,r,n="",i="";for(s="",e=0;e<this.token.header.length;e++)({header:!0,align:this.token.align[e]}),s+=this.renderer.tablecell(this.inline.output(this.token.header[e]),{header:!0,align:this.token.align[e]});for(n+=this.renderer.tablerow(s),e=0;e<this.token.cells.length;e++){for(t=this.token.cells[e],s="",r=0;r<t.length;r++)s+=this.renderer.tablecell(this.inline.output(t[r]),{header:!1,align:this.token.align[r]});i+=this.renderer.tablerow(s)}return this.renderer.table(n,i);case"blockquote_start":for(var i="";"blockquote_end"!==this.next().type;)i+=this.tok();return this.renderer.blockquote(i);case"list_start":for(var i="",o=this.token.ordered;"list_end"!==this.next().type;)i+=this.tok();return this.renderer.list(i,o);case"list_item_start":for(var i="";"list_item_end"!==this.next().type;)i+="text"===this.token.type?this.parseText():this.tok();return this.renderer.listitem(i);case"loose_item_start":for(var i="";"list_item_end"!==this.next().type;)i+=this.tok();return this.renderer.listitem(i);case"html":var a=this.token.pre||this.options.pedantic?this.token.text:this.inline.output(this.token.text);return this.renderer.html(a);case"paragraph":return this.renderer.paragraph(this.inline.output(this.token.text));case"text":return this.renderer.paragraph(this.parseText())}},noop.exec=noop,marked.options=marked.setOptions=function(e){return merge(marked.defaults,e),marked},marked.defaults={gfm:!0,tables:!0,breaks:!1,pedantic:!1,sanitize:!1,sanitizer:null,mangle:!0,smartLists:!1,silent:!1,highlight:null,langPrefix:"lang-",smartypants:!1,headerPrefix:"",renderer:new Renderer,xhtml:!1},marked.Parser=Parser,marked.parser=Parser.parse,marked.Renderer=Renderer,marked.Lexer=Lexer,marked.lexer=Lexer.lex,marked.InlineLexer=InlineLexer,marked.inlineLexer=InlineLexer.output,marked.parse=marked,e.exports=marked}).call(function(){return this||("undefined"!=typeof window?window:t)}())}).call(t,s(1))},684:function(e,t,s){var r=s(0)(s(649),s(687),null,null);e.exports=r.exports},687:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("searchable-list",{ref:"list",attrs:{placeholder:"Start typing..."},on:{infinite:function(e){return(0,e.complete)()}},model:{value:e.query,callback:function(t){e.query=t},expression:"query"}},[s("h5",{staticClass:"text-center",slot:"header"},[e._v("Enrolled Students")]),e._v(" "),s("div",{staticClass:"row"},e._l(e.students,function(e){return s("router-link",{key:e,staticClass:"col-12 col-lg-6 mt-3 no-link",attrs:{to:{name:"student.show",params:{uid:e.uid}}}},[s("student-card",{attrs:{student:e}})],1)}))])},staticRenderFns:[]}},755:function(e,t,s){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=s(3),n=_interopRequireDefault(r),i=s(2),o=_interopRequireDefault(i),a=s(5),l=_interopRequireDefault(a),u=s(50),c=_interopRequireDefault(u),p=s(4),d=s(684),h=_interopRequireDefault(d),f=s(447),g=_interopRequireDefault(f),m=s(7);t.default={name:"EditEnrollmentList",extends:h.default,data:function(){return{items:[],error:null}},methods:(0,l.default)({onSearch:(0,c.default)(function(){var e=(0,o.default)(n.default.mark(function _callee(e){var t,s;return n.default.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,this.search({q:e,personType:["student"]});case 2:t=r.sent,s=t.items,this.items=s||[];case 5:case"end":return r.stop()}},_callee,this)}));return function(t){return e.apply(this,arguments)}}(),400),add:function(e){var t=this;return(0,o.default)(n.default.mark(function _callee2(){var s,r;return n.default.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(!(t.source.findIndex(function(t){return e.id===t.id})>-1)){n.next=2;break}return n.abrupt("return",!1);case 2:return e=(0,m.clone)(e),t.source.push(e),e.$wait=!0,t.error=null,n.next=8,t.enroll({session:t.session,student:e.id});case 8:s=n.sent,s===!0?e.$wait=!1:(t.error=s.errors.$message,(r=t.source.findIndex(function(t){return e.id===t.id}))>-1&&t.source.splice(r,1));case 10:case"end":return n.stop()}},_callee2,t)}))()},remove:function(e){var t=this;return(0,o.default)(n.default.mark(function _callee3(){var s,r;return n.default.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(e.$wait!==!0){n.next=2;break}return n.abrupt("return",!1);case 2:return e.$wait=!0,t.error=null,n.next=6,t.expel({session:t.session,student:e.id});case 6:s=n.sent,e.$wait=!1,s===!0?(r=t.source.findIndex(function(t){return e.id===t.id}))>-1&&t.source.splice(r,1):"errors"in s&&(t.error=s.errors.$message);case 9:case"end":return n.stop()}},_callee3,t)}))()}},(0,p.mapActions)("people",{search:"index"}),(0,p.mapActions)("courses",["enroll","expel"])),created:function(){this.onSearch("")},components:{StudentCard:g.default}}},784:function(e,t,s){"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=s(3),n=_interopRequireDefault(r),i=s(2),o=_interopRequireDefault(i),a=s(5),l=_interopRequireDefault(a),u=s(4),c=s(450),p=_interopRequireDefault(c),d=s(683),h=_interopRequireDefault(d),f=s(1053),g=_interopRequireDefault(f);t.default={name:"CourseSession",extends:p.default,props:{sessionId:{type:Number,required:!0}},data:function(){return{attributes:{syllabus:""}}},computed:(0,l.default)({session:function(){return this.sessionById(this.sessionId)},syllabus:function(){return(0,h.default)(this.session.syllabus||"",{sanitize:!0})}},(0,u.mapGetters)("courses",["sessionById"])),methods:(0,l.default)({onUpdateSyllabus:function(){var e=this;return(0,o.default)(n.default.mark(function _callee(){return n.default.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.updateSession({session:e.session,payload:e.attributes});case 2:e.$refs&&e.$refs.syllabus.$emit("close");case 3:case"end":return t.stop()}},_callee,e)}))()}},(0,u.mapActions)("courses",["updateSession"])),components:{EnrollmentList:g.default},watch:{sessionId:function(e){this.sessionById(e)||this.$store.dispatch("courses/myFind",e)},session:function(e){this.attributes.syllabus=e.syllabus}}}},836:function(e,t,s){t=e.exports=s(443)(void 0),t.push([e.i,".p-course-syllabus h1{font-size:18px}.p-course-syllabus h2{font-size:16px}.p-course-syllabus h3,.p-course-syllabus h4,.p-course-syllabus h5,.p-course-syllabus h6{font-size:14px}",""])},879:function(e,t,s){var r=s(836);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);s(444)("15a38c0c",r,!0)}});
//# sourceMappingURL=9.4dbac869f527356e0a02.js.map