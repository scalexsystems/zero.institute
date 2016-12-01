webpackJsonp([2,0],[
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _vue = __webpack_require__(12);
	
	var _vue2 = _interopRequireDefault(_vue);
	
	var _vueResource = __webpack_require__(560);
	
	var _vueResource2 = _interopRequireDefault(_vueResource);
	
	var _vueRouter = __webpack_require__(240);
	
	var _vueRouter2 = _interopRequireDefault(_vueRouter);
	
	var _each = __webpack_require__(31);
	
	var _each2 = _interopRequireDefault(_each);
	
	var _echo = __webpack_require__(255);
	
	var _echo2 = _interopRequireDefault(_echo);
	
	var _debug = __webpack_require__(254);
	
	var _debug2 = _interopRequireDefault(_debug);
	
	var _input = __webpack_require__(251);
	
	var inputs = _interopRequireWildcard(_input);
	
	var _App = __webpack_require__(510);
	
	var _App2 = _interopRequireDefault(_App);
	
	var _store = __webpack_require__(259);
	
	var _store2 = _interopRequireDefault(_store);
	
	var _router = __webpack_require__(253);
	
	var _router2 = _interopRequireDefault(_router);
	
	var _apps = __webpack_require__(252);
	
	var _apps2 = _interopRequireDefault(_apps);
	
	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	window.$ = window.jQuery = __webpack_require__(94);
	window.io = __webpack_require__(500);
	window.Tether = __webpack_require__(507);
	__webpack_require__(296);
	
	window.Vue = _vue2.default;
	
	_vue2.default.use(_debug2.default, { debug: true });
	_vue2.default.use(_vueResource2.default);
	_vue2.default.use(_echo2.default, window.Laravel.broadcast);
	
	_vue2.default.http.options.root = '/api';
	if ('token' in window.Laravel) {
	  _vue2.default.http.headers.common.Authorization = 'Bearer ' + window.Laravel.token;
	} else {
	  _vue2.default.http.headers.common['X-CSRF-Token'] = window.Laravel.csrfToken;
	}
	
	(0, _each2.default)(inputs, function (input, name) {
	  return _vue2.default.component(name, input);
	});
	(0, _each2.default)(_apps2.default, function (app) {
	  return app(_vue2.default, { store: _store2.default, routes: _router2.default.routes });
	});
	
	var router = new _vueRouter2.default(_router2.default);
	
	new _vue2.default({
	  render: function render(h) {
	    return h(_App2.default);
	  },
	  store: _store2.default,
	  router: router
	}).$mount('#app');

/***/ },
/* 1 */,
/* 2 */,
/* 3 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	exports.httpThen = exports.normalizeValidationErrors = exports.isValidationException = exports.pushIf = exports.mapObject = exports.nl2br = exports.unescapeHtml = exports.escapeHtml = exports.bool = undefined;
	
	var _lodash = __webpack_require__(470);
	
	var _lodash2 = _interopRequireDefault(_lodash);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var bool = exports.bool = function bool(any) {
	  return [true, 'true', 'yes', '1', 1].indexOf(any) > -1;
	};
	
	var escapeHtml = exports.escapeHtml = function escapeHtml(unsafeString) {
	  var div = document.createElement('div');
	  div.appendChild(document.createTextNode(unsafeString));
	  return div.innerHTML;
	};
	
	var unescapeHtml = exports.unescapeHtml = function unescapeHtml(escapedString) {
	  var div = document.createElement('div');
	  div.innerHTML = escapedString;
	  var child = div.childNodes[0];
	
	  return child ? child.nodeValue : '';
	};
	
	var nl2br = exports.nl2br = function nl2br(content) {
	  return content.replace(/\n/g, '<br>');
	};
	
	var mapObject = exports.mapObject = function mapObject(source, mappings) {
	  var output = {};
	
	  if (_lodash2.default.isArray(mappings)) {
	    _lodash2.default.each(mappings, function (key) {
	      output[key] = source[key];
	    });
	  } else {
	    _lodash2.default.each(mappings, function (newKey, oldKey) {
	      output[newKey] = source[oldKey];
	    });
	  }
	
	  return output;
	};
	
	var pushIf = exports.pushIf = function pushIf(target, items) {
	  var mappings = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
	
	  if (!_lodash2.default.isArray(items)) {
	    return pushIf(target, [items], mappings);
	  }
	
	  items.forEach(function (item) {
	    if (item.id in mappings) return;
	
	    mappings[item.id] = target.length;
	
	    target.push(item);
	  });
	
	  return target;
	};
	
	var isValidationException = exports.isValidationException = function isValidationException(response) {
	  if (response.status === 422) return true;
	
	  return true;
	};
	
	var normalizeValidationErrors = exports.normalizeValidationErrors = function normalizeValidationErrors(errors) {
	  var transformed = {};
	  _lodash2.default.each(errors, function (value, key) {
	    transformed[key] = _lodash2.default.isArray(value) ? value.join(' ') : value;
	  });
	  return transformed;
	};
	
	var httpThen = exports.httpThen = function httpThen(response) {
	  if ('ok' in response) {
	    if (response.ok === true) {
	      return response.json();
	    }
	
	    throw response;
	  }
	
	  return response;
	};

/***/ },
/* 4 */,
/* 5 */,
/* 6 */
/***/ function(module, exports) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	var types = exports.types = {
	  ADD_USER: 'school/ADD_USER',
	  ADD_EMPLOYEE: 'school/ADD_EMPLOYEE',
	  ADD_STUDENT: 'school/ADD_STUDENT',
	  ADD_TEACHER: 'school/ADD_TEACHER',
	  ADD_GROUP: 'school/ADD_GROUP',
	
	  SET_USER: 'me/SET_USER'
	};
	
	var actions = exports.actions = {
	  getGroups: 'school/getGroups',
	  getUsers: 'school/getUsers',
	  getStudents: 'school/getStudents',
	  getTeachers: 'school/getTeachers',
	  getEmployees: 'school/getEmployees',
	  getUser: 'me/getUser'
	};
	
	var getters = exports.getters = {
	  groups: 'school/groups',
	  users: 'school/users',
	  employees: 'school/employees',
	  students: 'school/students',
	  teachers: 'school/teachers',
	
	  user: 'me/user'
	};

/***/ },
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */
/***/ function(module, exports) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	var types = exports.types = {
	  ADD_GROUP: 'hub/ADD_GROUP',
	  ADD_MESSAGE_TO_GROUP: 'hub/ADD_MESSAGE_TO_GROUP',
	  SET_MESSAGE_PAGE_TO_GROUP: 'hub/SET_MESSAGE_PAGE_TO_GROUP',
	  STATUS_GROUP_MESSAGE: 'hub/STATUS_GROUP_MESSAGE',
	  READ_GROUP_MESSAGE: 'hub/READ_GROUP_MESSAGE',
	
	  ADD_USER: 'hub/ADD_USER',
	  ADD_MESSAGE: 'hub/ADD_MESSAGE',
	  SET_MESSAGE_PAGE_TO_USER: 'hub/SET_MESSAGE_PAGE_TO_GROUP',
	  STATUS_MESSAGE: 'hub/STATUS_MESSAGE',
	  READ_MESSAGE: 'hub/READ_MESSAGE'
	};
	
	var actions = exports.actions = {
	  getGroups: 'hub/getUsers',
	  getMessagesFromGroup: 'hub/getMessagesFromGroup',
	  sendMessageToGroup: 'hub/sendMessageToGroup',
	  sendMessageReadReceiptForGroup: 'hub/sendMessageReadReceiptForGroup',
	  onNewMessageToGroup: 'hub/onNewMessageToGroup',
	
	  getMessagedUsers: 'hub/getMessagedUsers',
	  getMessagesFromUser: 'hub/getMessagesFromUser',
	  sendMessageToUser: 'hub/sendMessageToUser',
	  sendMessageReadReceipt: 'hub/sendMessageReadReceipt',
	  onNewMessageToUser: 'hub/onNewMessageToUser'
	};
	
	var getters = exports.getters = {
	  groups: 'hub/groups',
	  groupMap: 'hub/groupMap',
	
	  users: 'hub/users',
	  userMap: 'hub/userMap'
	};

/***/ },
/* 14 */,
/* 15 */,
/* 16 */,
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _ActionMenu = __webpack_require__(235);
	
	Object.defineProperty(exports, 'ActionMenu', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_ActionMenu).default;
	  }
	});
	
	var _ActivityBox = __webpack_require__(236);
	
	Object.defineProperty(exports, 'ActivityBox', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_ActivityBox).default;
	  }
	});
	
	var _LayoutBox = __webpack_require__(77);
	
	Object.defineProperty(exports, 'LayoutBox', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_LayoutBox).default;
	  }
	});
	
	var _MessageBox = __webpack_require__(523);
	
	Object.defineProperty(exports, 'MessageBox', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_MessageBox).default;
	  }
	});
	
	var _Navbar = __webpack_require__(238);
	
	Object.defineProperty(exports, 'NavBar', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_Navbar).default;
	  }
	});
	
	var _SidebarBox = __webpack_require__(526);
	
	Object.defineProperty(exports, 'SidebarBox', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_SidebarBox).default;
	  }
	});
	
	var _Loading = __webpack_require__(522);
	
	Object.defineProperty(exports, 'LoadingPlaceholder', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_Loading).default;
	  }
	});
	
	var _MessageEditor = __webpack_require__(524);
	
	Object.defineProperty(exports, 'MessageEditor', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_MessageEditor).default;
	  }
	});
	
	var _PersonCard = __webpack_require__(239);
	
	Object.defineProperty(exports, 'PersonCard', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_PersonCard).default;
	  }
	});

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/***/ },
/* 25 */,
/* 26 */,
/* 27 */,
/* 28 */,
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */,
/* 33 */,
/* 34 */,
/* 35 */,
/* 36 */,
/* 37 */,
/* 38 */,
/* 39 */,
/* 40 */,
/* 41 */,
/* 42 */,
/* 43 */,
/* 44 */,
/* 45 */,
/* 46 */,
/* 47 */,
/* 48 */,
/* 49 */,
/* 50 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _isString = __webpack_require__(113);
	
	var _isString2 = _interopRequireDefault(_isString);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: {
	    name: String,
	    title: String,
	    subtitle: String,
	    value: {
	      default: false
	    },
	    feedback: null,
	    feedbackType: {
	      default: 'danger',
	      validator: function validator(value) {
	        return ['danger', 'success', 'warning'].indexOf(value) > -1;
	      }
	    }
	  },
	  computed: {
	    id: function id() {
	      var uid = this._uid;
	
	      return 'id' + uid;
	    },
	    identifier: function identifier() {
	      var name = this.name;
	      var raw = null;
	
	      return name || raw;
	    },
	    feedbackState: function feedbackState() {
	      var feedback = this.feedbackType;
	      var condition = this.feedback !== undefined;
	
	      if (condition && (0, _isString2.default)(feedback)) {
	        return 'has-' + feedback;
	      }
	
	      return '';
	    },
	    formControlState: function formControlState() {
	      var feedback = this.feedbackType;
	      var condition = this.feedback !== undefined;
	
	      if (condition && (0, _isString2.default)(feedback)) {
	        return 'form-control-' + feedback;
	      }
	
	      return '';
	    }
	  },
	  methods: {
	    is: _isString2.default
	  }
	};

/***/ },
/* 51 */,
/* 52 */,
/* 53 */,
/* 54 */,
/* 55 */,
/* 56 */,
/* 57 */,
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */,
/* 62 */,
/* 63 */,
/* 64 */,
/* 65 */,
/* 66 */,
/* 67 */,
/* 68 */,
/* 69 */,
/* 70 */,
/* 71 */,
/* 72 */,
/* 73 */,
/* 74 */,
/* 75 */,
/* 76 */
/***/ function(module, exports) {

	module.exports = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAkACQAAD/4QCMRXhpZgAATU0AKgAAAAgABQESAAMAAAABAAEAAAEaAAUAAAABAAAASgEbAAUAAAABAAAAUgEoAAMAAAABAAIAAIdpAAQAAAABAAAAWgAAAAAAAACQAAAAAQAAAJAAAAABAAOgAQADAAAAAQABAACgAgAEAAAAAQAAAECgAwAEAAAAAQAAAEAAAAAA/+0AOFBob3Rvc2hvcCAzLjAAOEJJTQQEAAAAAAAAOEJJTQQlAAAAAAAQ1B2M2Y8AsgTpgAmY7PhCfv/AABEIAEAAQAMBEQACEQEDEQH/xAAfAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgv/xAC1EAACAQMDAgQDBQUEBAAAAX0BAgMABBEFEiExQQYTUWEHInEUMoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+fr/xAAfAQADAQEBAQEBAQEBAAAAAAAAAQIDBAUGBwgJCgv/xAC1EQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwP/2wBDAQEBAQEBAQIBAQICAgECAgMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwP/3QAEAAj/2gAMAwEAAhEDEQA/AP7MKACgAoAKACgAoAKACgD/0P7MKACgAoAKACgAoAKACgD/0f7MKACgAoAME9P8aAOE+JfxD0L4V+DtV8a+I0vZtP0xrSBbTT4o5b+/vtQuEtLCxtVmkigWW4nkGXkdY40BZjgUAc/8HPjH4b+NXhu78Q+HrTUtMbTNSbSdV0rVltjeWN4beK8hIns5JbW6trq1mV45EI7qyqykEA9boAKAP//S/swoAKAD9Pf0oA8g1nX73UbmURTy29mjssEELtEGRTgSSlCpkkfGeTgZwB3IBg6jp2k+MdJu/BvjK1OueFtcMFtfWNzPOkkMiTxzWd9Y3kMqXVleWV0iSRyRspUrkd8gHoXw8+Gvg74WaE/hzwVpTaZp817LqF2093cahfX9/KkcLXV9fXbyT3EqwQpGgJCRxoFVQOoB3dABQB//0/7MKACgA47jI7j1HpQB4vrGj3Wl3UqtFI1s0jNb3CqWjaNiSqswBCSIDgg49eRigCz4f0a51C9gkMTpZwSpLNO6lUby2DiKMn/WSSFQOOAMk44yAevnnn1/z7UAFABQB//U/swoAKACgA9ux6//AKu9AB/n/PpQAUAFABQB/9X+zCgAoAKACgAoAKACgAoA/9b+zCgAoAKACgAoAKACgAoA/9k="

/***/ },
/* 77 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(345)
	
	/* script */
	__vue_exports__ = __webpack_require__(279)
	
	/* template */
	var __vue_template__ = __webpack_require__(538)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 78 */,
/* 79 */,
/* 80 */,
/* 81 */,
/* 82 */,
/* 83 */,
/* 84 */,
/* 85 */,
/* 86 */,
/* 87 */,
/* 88 */,
/* 89 */,
/* 90 */,
/* 91 */,
/* 92 */,
/* 93 */,
/* 94 */,
/* 95 */,
/* 96 */,
/* 97 */,
/* 98 */,
/* 99 */,
/* 100 */,
/* 101 */,
/* 102 */,
/* 103 */,
/* 104 */,
/* 105 */,
/* 106 */,
/* 107 */,
/* 108 */,
/* 109 */,
/* 110 */,
/* 111 */,
/* 112 */,
/* 113 */,
/* 114 */,
/* 115 */,
/* 116 */,
/* 117 */,
/* 118 */,
/* 119 */,
/* 120 */,
/* 121 */,
/* 122 */,
/* 123 */,
/* 124 */,
/* 125 */,
/* 126 */,
/* 127 */,
/* 128 */,
/* 129 */,
/* 130 */,
/* 131 */,
/* 132 */,
/* 133 */,
/* 134 */,
/* 135 */,
/* 136 */,
/* 137 */,
/* 138 */,
/* 139 */,
/* 140 */,
/* 141 */,
/* 142 */,
/* 143 */,
/* 144 */,
/* 145 */,
/* 146 */,
/* 147 */,
/* 148 */,
/* 149 */,
/* 150 */,
/* 151 */,
/* 152 */,
/* 153 */,
/* 154 */,
/* 155 */,
/* 156 */,
/* 157 */,
/* 158 */,
/* 159 */,
/* 160 */,
/* 161 */,
/* 162 */,
/* 163 */,
/* 164 */,
/* 165 */,
/* 166 */,
/* 167 */,
/* 168 */,
/* 169 */,
/* 170 */,
/* 171 */,
/* 172 */,
/* 173 */,
/* 174 */,
/* 175 */,
/* 176 */,
/* 177 */,
/* 178 */,
/* 179 */,
/* 180 */,
/* 181 */,
/* 182 */,
/* 183 */,
/* 184 */,
/* 185 */,
/* 186 */,
/* 187 */,
/* 188 */,
/* 189 */,
/* 190 */,
/* 191 */,
/* 192 */,
/* 193 */,
/* 194 */,
/* 195 */,
/* 196 */,
/* 197 */,
/* 198 */,
/* 199 */,
/* 200 */,
/* 201 */,
/* 202 */,
/* 203 */,
/* 204 */,
/* 205 */,
/* 206 */,
/* 207 */,
/* 208 */,
/* 209 */,
/* 210 */,
/* 211 */,
/* 212 */,
/* 213 */,
/* 214 */,
/* 215 */,
/* 216 */,
/* 217 */,
/* 218 */,
/* 219 */,
/* 220 */,
/* 221 */,
/* 222 */,
/* 223 */,
/* 224 */,
/* 225 */,
/* 226 */,
/* 227 */,
/* 228 */,
/* 229 */,
/* 230 */,
/* 231 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(340)
	
	/* script */
	__vue_exports__ = __webpack_require__(263)
	
	/* template */
	var __vue_template__ = __webpack_require__(533)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 232 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(364)
	
	/* script */
	__vue_exports__ = __webpack_require__(267)
	
	/* template */
	var __vue_template__ = __webpack_require__(557)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 233 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(341)
	
	/* script */
	__vue_exports__ = __webpack_require__(269)
	
	/* template */
	var __vue_template__ = __webpack_require__(534)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 234 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(346)
	
	/* script */
	__vue_exports__ = __webpack_require__(273)
	
	/* template */
	var __vue_template__ = __webpack_require__(539)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 235 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(344)
	
	/* script */
	__vue_exports__ = __webpack_require__(276)
	
	/* template */
	var __vue_template__ = __webpack_require__(537)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 236 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(352)
	
	/* script */
	__vue_exports__ = __webpack_require__(277)
	
	/* template */
	var __vue_template__ = __webpack_require__(545)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 237 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(339)
	
	/* script */
	__vue_exports__ = __webpack_require__(278)
	
	/* template */
	var __vue_template__ = __webpack_require__(532)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 238 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(357)
	
	/* script */
	__vue_exports__ = __webpack_require__(283)
	
	/* template */
	var __vue_template__ = __webpack_require__(550)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 239 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(343)
	
	/* script */
	__vue_exports__ = __webpack_require__(284)
	
	/* template */
	var __vue_template__ = __webpack_require__(536)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 240 */,
/* 241 */,
/* 242 */,
/* 243 */,
/* 244 */,
/* 245 */,
/* 246 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _GroupList = __webpack_require__(517);
	
	Object.defineProperty(exports, 'GroupList', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_GroupList).default;
	  }
	});
	
	var _UserList = __webpack_require__(518);
	
	Object.defineProperty(exports, 'UserList', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_UserList).default;
	  }
	});
	
	var _GroupMessages = __webpack_require__(231);
	
	Object.defineProperty(exports, 'GroupMessages', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_GroupMessages).default;
	  }
	});
	
	var _UserMessages = __webpack_require__(232);
	
	Object.defineProperty(exports, 'UserMessages', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_UserMessages).default;
	  }
	});

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/***/ },
/* 247 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	exports.default = function (Vue, _ref) {
	  var store = _ref.store,
	      routes = _ref.routes;
	
	  store.registerModule('hub', _store2.default);
	  routes.push.apply(routes, [{
	    name: 'hub',
	    path: '/hub',
	    component: _Hub2.default,
	    children: [{ name: 'hub.group-create', path: 'groups/create', component: _GroupCreate2.default }, { name: 'hub.group-preview', path: 'groups/:group/preview', component: _GroupPreview2.default }, { name: 'hub.group', path: 'groups/:group', component: _GroupMessages2.default }, { name: 'hub.groups', path: 'groups', component: _GroupDirectory2.default }, { name: 'hub.user-preview', path: 'people/:user/preview', component: _UserPreview2.default }, { name: 'hub.users', path: 'people', component: _UserDirectory2.default }, { name: 'hub.user', path: 'people/:user', component: _UserMessages2.default }]
	  }, { path: '/', redirect: '/hub' }]);
	};
	
	var _Hub = __webpack_require__(514);
	
	var _Hub2 = _interopRequireDefault(_Hub);
	
	var _GroupCreate = __webpack_require__(511);
	
	var _GroupCreate2 = _interopRequireDefault(_GroupCreate);
	
	var _GroupDirectory = __webpack_require__(512);
	
	var _GroupDirectory2 = _interopRequireDefault(_GroupDirectory);
	
	var _GroupMessages = __webpack_require__(231);
	
	var _GroupMessages2 = _interopRequireDefault(_GroupMessages);
	
	var _GroupPreview = __webpack_require__(513);
	
	var _GroupPreview2 = _interopRequireDefault(_GroupPreview);
	
	var _UserDirectory = __webpack_require__(515);
	
	var _UserDirectory2 = _interopRequireDefault(_UserDirectory);
	
	var _UserMessages = __webpack_require__(232);
	
	var _UserMessages2 = _interopRequireDefault(_UserMessages);
	
	var _UserPreview = __webpack_require__(516);
	
	var _UserPreview2 = _interopRequireDefault(_UserPreview);
	
	var _store = __webpack_require__(249);
	
	var _store2 = _interopRequireDefault(_store);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/***/ },
/* 248 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _toConsumableArray2 = __webpack_require__(78);
	
	var _toConsumableArray3 = _interopRequireDefault(_toConsumableArray2);
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _defineProperty2 = __webpack_require__(34);
	
	var _defineProperty3 = _interopRequireDefault(_defineProperty2);
	
	var _getters, _mutations, _actions;
	
	var _isArray = __webpack_require__(4);
	
	var _isArray2 = _interopRequireDefault(_isArray);
	
	var _sortBy = __webpack_require__(47);
	
	var _sortBy2 = _interopRequireDefault(_sortBy);
	
	var _uniqBy = __webpack_require__(116);
	
	var _uniqBy2 = _interopRequireDefault(_uniqBy);
	
	var _vue = __webpack_require__(12);
	
	var _vue2 = _interopRequireDefault(_vue);
	
	var _util = __webpack_require__(3);
	
	var _meta = __webpack_require__(6);
	
	var _meta2 = __webpack_require__(13);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var bootedAt = Date.now();
	
	exports.default = {
	  state: {
	    groups: [],
	    groupMap: {}
	  },
	  getters: (_getters = {}, (0, _defineProperty3.default)(_getters, _meta2.getters.groups, function (state) {
	    return state.groups;
	  }), (0, _defineProperty3.default)(_getters, _meta2.getters.groupMap, function (state) {
	    return state.groupMap;
	  }), _getters),
	  mutations: (_mutations = {}, (0, _defineProperty3.default)(_mutations, _meta2.types.ADD_GROUP, function (state, payload) {
	    var groups = ((0, _isArray2.default)(payload) ? payload : [payload]).map(function (group) {
	      return (0, _extends3.default)({
	        messages: [],
	        messages_next_page: 1,
	        has_unread: false,
	        unread_count: 0
	      }, group);
	    });
	
	    (0, _util.pushIf)(state.groups, groups, state.groupMap);
	  }), (0, _defineProperty3.default)(_mutations, _meta2.types.SET_MESSAGE_PAGE_TO_GROUP, function (state, _ref) {
	    var groupId = _ref.groupId,
	        paginator = _ref.paginator;
	
	    if (!(groupId in state.groupMap)) return;
	
	    var index = state.groupMap[groupId];
	    state.groups[index].messages_next_page = paginator.current_page + 1;
	  }), (0, _defineProperty3.default)(_mutations, _meta2.types.ADD_MESSAGE_TO_GROUP, function (state, _ref2) {
	    var _group$messages;
	
	    var groupId = _ref2.groupId,
	        messages = _ref2.messages;
	
	    if (!(groupId in state.groupMap)) return;
	
	    var index = state.groupMap[groupId];
	    var group = state.groups[index];
	    (_group$messages = group.messages).push.apply(_group$messages, (0, _toConsumableArray3.default)(messages));
	    group.messages = (0, _sortBy2.default)((0, _uniqBy2.default)(group.messages, 'id'), 'id');
	    group.unread_count = group.messages.filter(function (message) {
	      return message.unread;
	    }).length;
	    group.has_unread = group.unread_count > 0;
	  }), (0, _defineProperty3.default)(_mutations, _meta2.types.READ_GROUP_MESSAGE, function (state, _ref3) {
	    var groupId = _ref3.groupId,
	        message = _ref3.message;
	
	    if (!(groupId in state.groupMap)) return;
	
	    var index = state.groupMap[groupId];
	    var group = state.groups[index];
	    var messageIndex = group.messages.indexOf(message);
	    var messageState = group.messages[messageIndex];
	    messageState.read_at = new Date().toISOString();
	    if (messageState.unread) {
	      messageState.unread_count -= 1;
	    }
	    messageState.unread = false;
	    group.has_unread = group.unread_count > 0;
	  }), (0, _defineProperty3.default)(_mutations, _meta2.types.STATUS_GROUP_MESSAGE, function (state, _ref4) {
	    var groupId = _ref4.groupId,
	        message = _ref4.message,
	        payload = _ref4.payload,
	        success = _ref4.success;
	
	    if (!(groupId in state.groupMap)) return;
	
	    var index = state.groupMap[groupId];
	    var messageIndex = state.groups[index].messages.indexOf(message);
	    if (success) {
	      state.groups[index].messages[messageIndex] = payload;
	    } else {
	      state.groups[index].messages[messageIndex].failed = true;
	      state.groups[index].messages[messageIndex].sending = false;
	    }
	  }), _mutations),
	  actions: (_actions = {}, (0, _defineProperty3.default)(_actions, _meta2.actions.getGroups, function (_ref5) {
	    var commit = _ref5.commit;
	    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	
	    return _vue2.default.http.get('me/groups', { params: params }).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta2.types.ADD_GROUP, result.data);
	      commit(_meta.types.ADD_GROUP, result.data);
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta2.actions.getMessagesFromGroup, function (_ref6, _ref7) {
	    var commit = _ref6.commit,
	        state = _ref6.state;
	    var groupId = _ref7.groupId,
	        params = _ref7.params;
	
	    var index = state.groupMap[groupId];
	    var group = state.groups[index];
	    var payload = {
	      params: (0, _extends3.default)({
	        timestamp: bootedAt,
	        page: group.messages_next_page
	      }, params)
	    };
	
	    return _vue2.default.http.get('groups/' + groupId + '/messages', payload).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta2.types.ADD_MESSAGE_TO_GROUP, { groupId: groupId, messages: result.data });
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta2.actions.onNewMessageToGroup, function (_ref8, _ref9) {
	    var commit = _ref8.commit;
	    var groupId = _ref9.groupId,
	        message = _ref9.message;
	
	    var senderId = groupId === undefined ? message.sender.id : groupId;
	
	    commit(_meta2.types.ADD_MESSAGE, { groupId: senderId, messages: [message] });
	  }), (0, _defineProperty3.default)(_actions, _meta2.actions.sendMessageToGroup, function (_ref10, _ref11) {
	    var commit = _ref10.commit,
	        rootState = _ref10.rootState;
	    var groupId = _ref11.groupId,
	        content = _ref11.content,
	        _ref11$params = _ref11.params,
	        params = _ref11$params === undefined ? {} : _ref11$params;
	
	    var message = { id: Date.now(), content: content, sending: true, sender: rootState.user.user };
	    commit(_meta2.types.ADD_MESSAGE_TO_GROUP, { groupId: groupId, messages: [message] });
	
	    return _vue2.default.http.post('groups/' + groupId + '/messages', (0, _extends3.default)({ content: content }, params)).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta2.types.STATUS_GROUP_MESSAGE, {
	        groupId: groupId,
	        message: message,
	        payload: result,
	        success: true
	      });
	
	      return result;
	    }).catch(function (response) {
	      commit(_meta2.types.STATUS_GROUP_MESSAGE, { groupId: groupId, message: message, success: false });
	
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta2.actions.sendMessageReadReceiptForGroup, function (_ref12, _ref13) {
	    var commit = _ref12.commit,
	        rootState = _ref12.rootState;
	    var groupId = _ref13.groupId,
	        message = _ref13.message;
	
	    if (message.sender_id === rootState.user.me.id) {
	      commit(_meta2.types.READ_GROUP_MESSAGE, { groupId: groupId, message: message });
	
	      return;
	    }
	
	    _vue2.default.http.put('groups/messages/' + message.id + '/read').then(function () {
	      return commit(_meta2.types.READ_GROUP_MESSAGE, { groupId: groupId, message: message });
	    }).catch(function (response) {
	      return response;
	    });
	  }), _actions)
	};

/***/ },
/* 249 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _group = __webpack_require__(248);
	
	var _group2 = _interopRequireDefault(_group);
	
	var _user = __webpack_require__(250);
	
	var _user2 = _interopRequireDefault(_user);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  state: (0, _extends3.default)({}, _group2.default.state, _user2.default.state),
	  getters: (0, _extends3.default)({}, _group2.default.getters, _user2.default.getters),
	  mutations: (0, _extends3.default)({}, _group2.default.mutations, _user2.default.mutations),
	  actions: (0, _extends3.default)({}, _group2.default.actions, _user2.default.actions)
	};

/***/ },
/* 250 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _toConsumableArray2 = __webpack_require__(78);
	
	var _toConsumableArray3 = _interopRequireDefault(_toConsumableArray2);
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _defineProperty2 = __webpack_require__(34);
	
	var _defineProperty3 = _interopRequireDefault(_defineProperty2);
	
	var _getters, _mutations, _actions;
	
	var _isArray = __webpack_require__(4);
	
	var _isArray2 = _interopRequireDefault(_isArray);
	
	var _uniqBy = __webpack_require__(116);
	
	var _uniqBy2 = _interopRequireDefault(_uniqBy);
	
	var _sortBy = __webpack_require__(47);
	
	var _sortBy2 = _interopRequireDefault(_sortBy);
	
	var _vue = __webpack_require__(12);
	
	var _vue2 = _interopRequireDefault(_vue);
	
	var _util = __webpack_require__(3);
	
	var _meta = __webpack_require__(13);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var bootedAt = Date.now();
	
	exports.default = {
	  state: {
	    users: [],
	    userMap: {}
	  },
	  getters: (_getters = {}, (0, _defineProperty3.default)(_getters, _meta.getters.users, function (state) {
	    return state.users;
	  }), (0, _defineProperty3.default)(_getters, _meta.getters.userMap, function (state) {
	    return state.userMap;
	  }), _getters),
	  mutations: (_mutations = {}, (0, _defineProperty3.default)(_mutations, _meta.types.ADD_USER, function (state, payload) {
	    var users = ((0, _isArray2.default)(payload) ? payload : [payload]).map(function (user) {
	      return (0, _extends3.default)({
	        messages: [],
	        messages_next_page: 1,
	        has_unread: false,
	        unread_count: 0
	      }, user);
	    });
	
	    (0, _util.pushIf)(state.users, users, state.userMap);
	  }), (0, _defineProperty3.default)(_mutations, _meta.types.SET_MESSAGE_PAGE_TO_USER, function (state, _ref) {
	    var userId = _ref.userId,
	        paginator = _ref.paginator;
	
	    if (!(userId in state.userMap)) return;
	
	    var index = state.userMap[userId];
	    state.users[index].messages_next_page = paginator.current_page + 1;
	  }), (0, _defineProperty3.default)(_mutations, _meta.types.ADD_MESSAGE, function (state, _ref2) {
	    var _user$messages;
	
	    var userId = _ref2.userId,
	        messages = _ref2.messages;
	
	    if (!(userId in state.userMap)) return;
	
	    var index = state.userMap[userId];
	    var user = state.users[index];
	
	    (_user$messages = user.messages).push.apply(_user$messages, (0, _toConsumableArray3.default)(messages));
	    user.messages = (0, _sortBy2.default)((0, _uniqBy2.default)(user.messages, 'id'), 'id');
	    user.unread_count = user.messages.filter(function (message) {
	      return message.unread;
	    }).length;
	    user.has_unread = user.unread_count > 0;
	  }), (0, _defineProperty3.default)(_mutations, _meta.types.READ_MESSAGE, function (state, _ref3) {
	    var userId = _ref3.userId,
	        message = _ref3.message;
	
	    if (!(userId in state.userMap)) return;
	
	    var index = state.userMap[userId];
	    var user = state.users[index];
	    var messageIndex = message.messages.indexOf(message);
	    var messageState = user.messages[messageIndex];
	
	    messageState.read_at = new Date().toISOString();
	    if (messageState.unread) {
	      user.unread_count -= 1;
	    }
	    messageState.unread = false;
	    user.has_unread = user.unread_count > 0;
	  }), (0, _defineProperty3.default)(_mutations, _meta.types.STATUS_MESSAGE, function (state, _ref4) {
	    var userId = _ref4.userId,
	        message = _ref4.message,
	        payload = _ref4.payload,
	        success = _ref4.success;
	
	    var index = state.userMap[userId];
	    var messageIndex = state.users[index].messages.indexOf(message);
	    if (success) {
	      state.users[index].messages.splice(messageIndex, 1, payload);
	    } else {
	      state.users[index].messages[messageIndex].failed = true;
	      state.users[index].messages[messageIndex].sending = false;
	    }
	  }), _mutations),
	  actions: (_actions = {}, (0, _defineProperty3.default)(_actions, _meta.actions.getMessagedUsers, function (_ref5) {
	    var commit = _ref5.commit;
	    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	
	    return _vue2.default.http.get('me/messages/users', { params: params }).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta.types.ADD_USER, result.data);
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta.actions.getMessagesFromUser, function (_ref6, _ref7) {
	    var commit = _ref6.commit,
	        state = _ref6.state;
	    var userId = _ref7.userId,
	        params = _ref7.params;
	
	    var index = state.userMap[userId];
	    var user = state.users[index];
	    var payload = {
	      params: (0, _extends3.default)({
	        timestamp: bootedAt,
	        page: user.messages_next_page
	      }, params)
	    };
	
	    return _vue2.default.http.get('me/messages/users/' + userId, payload).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta.types.ADD_MESSAGE, { userId: userId, messages: result.data });
	      commit(_meta.types.SET_MESSAGE_PAGE_TO_USER, { userId: userId, paginator: result._meta.pagination });
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta.actions.onNewMessageToUser, function (_ref8, _ref9) {
	    var commit = _ref8.commit;
	    var userId = _ref9.userId,
	        message = _ref9.message;
	
	    var senderId = userId === undefined ? message.sender.id : userId;
	
	    commit(_meta.types.ADD_MESSAGE, { userId: senderId, messages: [message] });
	  }), (0, _defineProperty3.default)(_actions, _meta.actions.sendMessageToUser, function (_ref10, _ref11) {
	    var commit = _ref10.commit,
	        rootState = _ref10.rootState;
	    var userId = _ref11.userId,
	        content = _ref11.content,
	        _ref11$params = _ref11.params,
	        params = _ref11$params === undefined ? {} : _ref11$params;
	
	    var message = { id: Date.now(), content: content, sending: true, sender: rootState.user.user };
	    commit(_meta.types.ADD_MESSAGE, { userId: userId, messages: [message] });
	
	    return _vue2.default.http.post('me/messages/users/' + userId, (0, _extends3.default)({ content: content }, params)).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta.types.STATUS_MESSAGE, { userId: userId, message: message, payload: result, success: true });
	    }).catch(function (response) {
	      commit(_meta.types.STATUS_MESSAGE, { userId: userId, message: message, success: false });
	
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta.actions.sendMessageReadReceipt, function (_ref12, _ref13) {
	    var commit = _ref12.commit,
	        rootState = _ref12.rootState;
	    var userId = _ref13.userId,
	        message = _ref13.message;
	
	    if (message.sender_id === rootState.user.user.id) {
	      commit(_meta.types.READ_MESSAGE, { userId: userId, message: message });
	
	      return;
	    }
	
	    _vue2.default.http.put('me/messages/' + message.id + '/read').then(function () {
	      return commit(_meta.types.READ_MESSAGE, { userId: userId, message: message });
	    }).catch(function (response) {
	      return response;
	    });
	  }), _actions)
	};

/***/ },
/* 251 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _Radio = __webpack_require__(527);
	
	Object.defineProperty(exports, 'InputRadio', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_Radio).default;
	  }
	});
	
	var _Text = __webpack_require__(528);
	
	Object.defineProperty(exports, 'InputText', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_Text).default;
	  }
	});
	
	var _Textarea = __webpack_require__(529);
	
	Object.defineProperty(exports, 'InputTextarea', {
	  enumerable: true,
	  get: function get() {
	    return _interopRequireDefault(_Textarea).default;
	  }
	});

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/***/ },
/* 252 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _appHub = __webpack_require__(247);
	
	var _appHub2 = _interopRequireDefault(_appHub);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  hub: _appHub2.default
	};

/***/ },
/* 253 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _vue = __webpack_require__(12);
	
	var _vue2 = _interopRequireDefault(_vue);
	
	var _vueRouter = __webpack_require__(240);
	
	var _vueRouter2 = _interopRequireDefault(_vueRouter);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	_vue2.default.use(_vueRouter2.default);
	
	exports.default = {
	  mode: 'history',
	  routes: [],
	  scrollBehavior: function scrollBehavior(to, from, savedPosition) {
	    if (savedPosition) {
	      return savedPosition;
	    }
	
	    var position = {};
	
	    if (to.hash) {
	      position.selector = to.hash;
	    }
	
	    if (to.matched.some(function (m) {
	      return m.meta.scrollToTop;
	    })) {
	      position.x = 0;
	      position.y = 0;
	    }
	
	    return position;
	  }
	};

/***/ },
/* 254 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	exports.default = plugin;
	
	var _debug = __webpack_require__(9);
	
	var _debug2 = _interopRequireDefault(_debug);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	function plugin(Vue) {
	  var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	
	  if (plugin.installed === true) return;
	  plugin.installed = true;
	
	  if (options.debug !== true) {
	    Object.defineProperty(Vue.prototype, '$debug', {
	      get: function get() {
	        return function () {};
	      }
	    });
	  } else {
	    (function () {
	      var logger = (0, _debug2.default)('app');
	      _debug2.default.enable('app');
	
	      Object.defineProperty(Vue.prototype, '$debug', {
	        get: function get() {
	          return logger;
	        }
	      });
	    })();
	  }
	}

/***/ },
/* 255 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	exports.default = install;
	
	var _laravelEcho = __webpack_require__(370);
	
	var _laravelEcho2 = _interopRequireDefault(_laravelEcho);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	function install(Vue, options) {
	  if (install.installed) return;
	
	  install.installed = true;
	
	  var echo = new _laravelEcho2.default(options);
	
	  echo.registerVueRequestInterceptor();
	
	  Object.defineProperty(Vue, 'echo', {
	    get: function get() {
	      return echo;
	    }
	  });
	  Object.defineProperty(Vue.prototype, '$echo', {
	    get: function get() {
	      return echo;
	    }
	  });
	}

/***/ },
/* 256 */
/***/ function(module, exports) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	exports.default = {
	  state: {
	    active: 'hub'
	  }
	};

/***/ },
/* 257 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _defineProperty2 = __webpack_require__(34);
	
	var _defineProperty3 = _interopRequireDefault(_defineProperty2);
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _getters, _mutations, _actions;
	
	var _map = __webpack_require__(471);
	
	var _map2 = _interopRequireDefault(_map);
	
	var _groupBy = __webpack_require__(466);
	
	var _groupBy2 = _interopRequireDefault(_groupBy);
	
	var _first = __webpack_require__(21);
	
	var _first2 = _interopRequireDefault(_first);
	
	var _vue = __webpack_require__(12);
	
	var _vue2 = _interopRequireDefault(_vue);
	
	var _meta = __webpack_require__(6);
	
	var _util = __webpack_require__(3);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var commitUsers = function commitUsers(result, commit) {
	  if ('user' in (0, _first2.default)(result.data)) {
	    commit(_meta.types.ADD_USER, (0, _map2.default)(result.data, function (person) {
	      return (0, _extends3.default)({ person: person }, person.user);
	    }));
	  }
	};
	
	exports.default = {
	  state: {
	    employees: [],
	    employeeMap: {},
	    groups: [],
	    groupMap: {},
	    students: [],
	    studentMap: {},
	    teachers: [],
	    teacherMap: {},
	    users: [],
	    userMap: {},
	    departments: [],
	    disciplines: []
	  },
	  getters: (_getters = {}, (0, _defineProperty3.default)(_getters, _meta.getters.employees, function (state) {
	    return state.employees;
	  }), (0, _defineProperty3.default)(_getters, _meta.getters.groups, function (state) {
	    return state.groups;
	  }), (0, _defineProperty3.default)(_getters, _meta.getters.students, function (state) {
	    return state.students;
	  }), (0, _defineProperty3.default)(_getters, _meta.getters.teachers, function (state) {
	    return state.teachers;
	  }), (0, _defineProperty3.default)(_getters, _meta.getters.users, function (state) {
	    return state.users;
	  }), _getters),
	  mutations: (_mutations = {}, (0, _defineProperty3.default)(_mutations, _meta.types.ADD_USER, function (state, users) {
	    (0, _util.pushIf)(state.users, users, state.userMap);
	  }), (0, _defineProperty3.default)(_mutations, _meta.types.ADD_STUDENT, function (state, students) {
	    (0, _util.pushIf)(state.students, students, state.studentMap);
	  }), (0, _defineProperty3.default)(_mutations, _meta.types.ADD_TEACHER, function (state, teachers) {
	    (0, _util.pushIf)(state.teachers, teachers, state.teacherMap);
	  }), (0, _defineProperty3.default)(_mutations, _meta.types.ADD_EMPLOYEE, function (state, employees) {
	    (0, _util.pushIf)(state.employees, employees, state.employeeMap);
	  }), (0, _defineProperty3.default)(_mutations, _meta.types.ADD_GROUP, function (state, groups) {
	    (0, _util.pushIf)(state.groups, groups, state.groupMap);
	  }), _mutations),
	  actions: (_actions = {}, (0, _defineProperty3.default)(_actions, _meta.actions.getStudents, function (_ref) {
	    var commit = _ref.commit;
	    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	
	    return _vue2.default.http.get('people/students', { params: params }).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta.types.ADD_STUDENT, result.data);
	      commitUsers(result, commit);
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta.actions.getEmployees, function (_ref2) {
	    var commit = _ref2.commit;
	    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	
	    return _vue2.default.http.get('people/employees', { params: params }).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta.types.ADD_EMPLOYEE, result.data);
	      commitUsers(result, commit);
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta.actions.getTeachers, function (_ref3) {
	    var commit = _ref3.commit;
	    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	
	    return _vue2.default.http.get('people/teachers', { params: params }).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta.types.ADD_TEACHER, result.data);
	      commitUsers(result, commit);
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta.actions.getGroups, function (_ref4) {
	    var commit = _ref4.commit;
	    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	
	    return _vue2.default.http.get('groups', { params: params }).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta.types.ADD_GROUP, result.data);
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  }), (0, _defineProperty3.default)(_actions, _meta.actions.getUsers, function (_ref5) {
	    var commit = _ref5.commit;
	    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	
	    return _vue2.default.http.get('people', { params: params }).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      var groups = (0, _groupBy2.default)(result.data, 'person_type');
	
	      commit(_meta.types.ADD_USER, result.data);
	
	      if ('student' in groups) commit(_meta.types.ADD_STUDENT, groups.student);
	      if ('employee' in groups) commit(_meta.types.ADD_EMPLOYEE, groups.employee);
	      if ('teacher' in groups) commit(_meta.types.ADD_TEACHER, groups.teacher);
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  }), _actions)
	};

/***/ },
/* 258 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _defineProperty2 = __webpack_require__(34);
	
	var _defineProperty3 = _interopRequireDefault(_defineProperty2);
	
	var _vue = __webpack_require__(12);
	
	var _vue2 = _interopRequireDefault(_vue);
	
	var _meta = __webpack_require__(6);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  state: {
	    user: window.Laravel.user || {}
	  },
	  getters: (0, _defineProperty3.default)({}, _meta.getters.user, function (state) {
	    return state.user;
	  }),
	  mutations: (0, _defineProperty3.default)({}, _meta.types.SET_USER, function (state, user) {
	    state.user = user;
	  }),
	  actions: (0, _defineProperty3.default)({}, _meta.actions.getUser, function (_ref) {
	    var commit = _ref.commit;
	
	    return _vue2.default.http.get('me').then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      commit(_meta.types.SET_USER, result);
	
	      return result;
	    }).catch(function (response) {
	      return response;
	    });
	  })
	};

/***/ },
/* 259 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _vue = __webpack_require__(12);
	
	var _vue2 = _interopRequireDefault(_vue);
	
	var _vuex = __webpack_require__(8);
	
	var _vuex2 = _interopRequireDefault(_vuex);
	
	var _app = __webpack_require__(256);
	
	var _app2 = _interopRequireDefault(_app);
	
	var _school = __webpack_require__(257);
	
	var _school2 = _interopRequireDefault(_school);
	
	var _user = __webpack_require__(258);
	
	var _user2 = _interopRequireDefault(_user);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	_vue2.default.use(_vuex2.default);
	
	exports.default = new _vuex2.default.Store({
	  modules: { app: _app2.default, school: _school2.default, user: _user2.default }
	});

/***/ },
/* 260 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _vuex = __webpack_require__(8);
	
	var _Navbar = __webpack_require__(238);
	
	var _Navbar2 = _interopRequireDefault(_Navbar);
	
	var _meta = __webpack_require__(6);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'App',
	  components: { NavBar: _Navbar2.default },
	  computed: (0, _extends3.default)({}, (0, _vuex.mapGetters)({ user: _meta.getters.user })),
	  methods: (0, _extends3.default)({}, (0, _vuex.mapActions)({ getUser: _meta.actions.getUser })),
	  created: function created() {
	    if (!('id' in this.user)) {
	      this.getUser();
	    } else {
	      this.$echo.private(this.user.channel);
	    }
	  },
	
	  watch: {
	    user: function user() {
	      this.$echo.private(this.user.channel);
	    }
	  }
	};

/***/ },
/* 261 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _Validator = __webpack_require__(242);
	
	var _Validator2 = _interopRequireDefault(_Validator);
	
	var _components = __webpack_require__(24);
	
	var _meta = __webpack_require__(13);
	
	var _meta2 = __webpack_require__(6);
	
	var _util = __webpack_require__(3);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'GroupCreate',
	  components: { ActivityBox: _components.ActivityBox },
	  data: function data() {
	    return {
	      group: {
	        name: '',
	        type: 'public',
	        description: ''
	      },
	      errors: {}
	    };
	  },
	
	  computed: {
	    groupTypes: function groupTypes() {
	      return {
	        public: 'Public',
	        private: 'Private'
	      };
	    }
	  },
	  methods: {
	    createGroup: function createGroup() {
	      var _this = this;
	
	      if (!this.validate()) {
	        return;
	      }
	
	      this.$refs.action.classList.add('disabled');
	      this.$http.post('groups', this.group).then(function (response) {
	        return response.json();
	      }).then(function (result) {
	        _this.$refs.action.classList.remove('disabled');
	        _this.$store.commit(_meta.types.ADD_GROUP, result);
	        _this.$store.commit(_meta2.types.ADD_GROUP, result);
	        _this.$router.push({ name: 'hub.group', params: { group: result.id } });
	
	        return result;
	      }).catch(function (response) {
	        _this.$refs.action.classList.remove('disabled');
	        if ((0, _util.isValidationException)(response)) {
	          response.json().then(function (result) {
	            return _this.$set(_this, 'errors', (0, _util.normalizeValidationErrors)(result.errors));
	          });
	        }
	
	        return response;
	      });
	    },
	    validate: function validate() {
	      var v = _Validator2.default.make(this.group, {
	        name: 'required|min:3|max:60',
	        type: 'required',
	        description: 'required'
	      });
	
	      if (v.fails()) {
	        this.$set(this, 'errors', (0, _util.normalizeValidationErrors)(v.getErrors()));
	
	        return false;
	      }
	
	      this.$set(this, 'errors', {});
	
	      return true;
	    }
	  }
	};

/***/ },
/* 262 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _throttle = __webpack_require__(73);
	
	var _throttle2 = _interopRequireDefault(_throttle);
	
	var _vuex = __webpack_require__(8);
	
	var _util = __webpack_require__(3);
	
	var _meta = __webpack_require__(6);
	
	var _Directory = __webpack_require__(237);
	
	var _Directory2 = _interopRequireDefault(_Directory);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'GroupDirectory',
	  components: { Directory: _Directory2.default },
	  computed: (0, _extends3.default)({}, (0, _vuex.mapGetters)({
	    groups: _meta.getters.groups
	  })),
	  data: function data() {
	    return { q: '', page: 0 };
	  },
	
	  methods: (0, _extends3.default)({
	    onClose: function onClose() {
	      window.history.back();
	    },
	    onGroupSelected: function onGroupSelected(group) {
	      var name = group.is_member === true ? 'hub.group' : 'hub.group-preview';
	
	      this.$router.push({ name: name, params: { group: group.id } });
	    },
	
	    onSearch: (0, _throttle2.default)(function onSearch(query) {
	      this.q = query;
	      this.page = 1;
	      this.getGroups({ q: query });
	    }, 500),
	    onInfinite: function onInfinite(_ref) {
	      var _this = this;
	
	      var done = _ref.done,
	          end = _ref.end,
	          error = _ref.error;
	
	      this.getGroups({ q: this.q, page: this.page + 1 }).then(_util.httpThen).then(function (result) {
	        _this.page = result._meta.pagination.current_page;
	
	        return result.data.length ? done() : end();
	      }).catch(function () {
	        return error();
	      });
	    }
	  }, (0, _vuex.mapActions)({
	    getGroups: _meta.actions.getGroups
	  }))
	};

/***/ },
/* 263 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _first = __webpack_require__(21);
	
	var _first2 = _interopRequireDefault(_first);
	
	var _each = __webpack_require__(31);
	
	var _each2 = _interopRequireDefault(_each);
	
	var _toInteger = __webpack_require__(48);
	
	var _toInteger2 = _interopRequireDefault(_toInteger);
	
	var _vuex = __webpack_require__(8);
	
	var _util = __webpack_require__(3);
	
	var _components = __webpack_require__(24);
	
	var _meta = __webpack_require__(13);
	
	var _MessagePane = __webpack_require__(233);
	
	var _MessagePane2 = _interopRequireDefault(_MessagePane);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'Group',
	  components: {
	    MessageBox: _components.MessageBox,
	    MessageList: _MessagePane2.default,
	    MessageEditor: _components.MessageEditor,
	    LoadingPlaceholder: _components.LoadingPlaceholder
	  },
	  computed: (0, _extends3.default)({
	    context: function context() {
	      var route = this.$route;
	      var groupMap = this.groupMap;
	      var groups = this.groups;
	
	      var id = (0, _toInteger2.default)(route.params.group);
	      var index = groupMap[id];
	      var group = groups[index];
	
	      return group;
	    }
	  }, (0, _vuex.mapGetters)({
	    groups: _meta.getters.groups,
	    groupMap: _meta.getters.groupMap
	  })),
	  created: function created() {
	    this.findGroup();
	  },
	  data: function data() {
	    return {
	      message: ''
	    };
	  },
	
	  methods: (0, _extends3.default)({
	    send: function send() {
	      this.sendMessage({ groupId: this.context.id, content: this.message });
	      this.message = '';
	      this.$refs.input.resize();
	      this.$refs.input.focus();
	    },
	    findGroup: function findGroup() {
	      var id = (0, _toInteger2.default)(this.$route.params.group);
	
	      if (!(id in this.groupMap)) {
	        this.getGroups({ q: id });
	      }
	    },
	    loadMore: function loadMore(loader) {
	      var _this = this;
	
	      this.getMessages({ groupId: this.context.id, params: {} }).then(_util.httpThen).then(function (result) {
	        var paginator = result._meta.pagination;
	
	        if (paginator.current_page < paginator.total_pages) {
	          var message = (0, _first2.default)(_this.context.messages);
	
	          if (message && message.unread === true) {
	            _this.loadMore(loader);
	            return;
	          }
	        }
	
	        if (paginator.current_page < paginator.total_pages) {
	          loader.done();
	        } else {
	          loader.end();
	        }
	      }).catch(function (response) {
	        return response;
	      });
	    },
	    markMessagesSeen: function markMessagesSeen() {
	      var _this2 = this;
	
	      window.setTimeout(function () {
	        var messages = _this2.context.messages.filter(function (message) {
	          return message.unread;
	        });
	        (0, _each2.default)(messages, function (message) {
	          return _this2.readMessage({ groupId: _this2.context.id, message: message });
	        });
	      }, 1000);
	    }
	  }, (0, _vuex.mapActions)({
	    getGroups: _meta.actions.getGroups,
	    getMessages: _meta.actions.getMessagesFromGroup,
	    readMessage: _meta.actions.sendMessageReadReceiptForGroup,
	    sendMessage: _meta.actions.sendMessageToGroup
	  })),
	  watch: {
	    $route: function $route() {
	      this.findGroup();
	    },
	    context: function context(group) {
	      if (!group.messages.length) {
	        this.loadMore();
	      }
	    }
	  }
	};

/***/ },
/* 264 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _vue = __webpack_require__(12);
	
	var _vue2 = _interopRequireDefault(_vue);
	
	var _throttle = __webpack_require__(73);
	
	var _throttle2 = _interopRequireDefault(_throttle);
	
	var _vueInfiniteLoading = __webpack_require__(230);
	
	var _vueInfiniteLoading2 = _interopRequireDefault(_vueInfiniteLoading);
	
	var _util = __webpack_require__(3);
	
	var _components = __webpack_require__(24);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'GroupPreview',
	  beforeRouteEnter: function beforeRouteEnter(to, from, next) {
	    _vue2.default.http.get('groups/' + to.params.group).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      next(function (vm) {
	        _vue2.default.set(vm, 'group', result);
	      });
	    }).catch(function () {});
	  },
	
	  components: { LoadingPlaceholder: _components.LoadingPlaceholder, ActivityBox: _components.ActivityBox, ItemCard: _components.PersonCard, InfiniteScroll: _vueInfiniteLoading2.default },
	  computed: {
	    title: function title() {
	      var group = this.group;
	
	      return group ? group.name : '';
	    },
	    subtitle: function subtitle() {
	      var group = this.group;
	
	      return group ? group.bio : '';
	    }
	  },
	  data: function data() {
	    return {
	      group: null,
	      ids: {},
	      members: [],
	      q: '',
	      page: 0
	    };
	  },
	
	  methods: {
	    close: function close() {
	      window.history.back();
	    },
	
	    search: (0, _throttle2.default)(function search() {
	      this.page = 0;
	      this.onInfinite();
	    }),
	    onInfinite: function onInfinite() {
	      var _this = this;
	
	      this.$http.get('groups/' + this.group.id + '/members', { params: { q: this.q, page: this.page + 1 } }).then(function (response) {
	        return response.json();
	      }).then(function (result) {
	        (0, _util.pushIf)(_this.members, result.data, _this.ids);
	        _this.page = result._meta.pagination.current_page;
	        if (_this.page < result._meta.pagination.total_pages) {
	          _this.$refs.infinite.$emit('$InfiniteLoading:loaded');
	        } else {
	          _this.$refs.infinite.$emit('$InfiniteLoading:complete');
	        }
	      }).catch(function () {
	        return _this.$refs.infinite.$emit('$InfiniteLoading:loaded');
	      });
	    }
	  }
	};

/***/ },
/* 265 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _perfectScrollbar = __webpack_require__(482);
	
	var _perfectScrollbar2 = _interopRequireDefault(_perfectScrollbar);
	
	var _vuex = __webpack_require__(8);
	
	var _components = __webpack_require__(246);
	
	var components = _interopRequireWildcard(_components);
	
	var _meta = __webpack_require__(13);
	
	var _meta2 = __webpack_require__(6);
	
	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'Hub',
	  components: (0, _extends3.default)({}, components),
	  beforeDestroy: function beforeDestroy() {
	    _perfectScrollbar2.default.destroy(this.$refs.sidebarLeft);
	  },
	
	  computed: (0, _extends3.default)({}, (0, _vuex.mapGetters)({ user: _meta2.getters.user })),
	  data: function data() {
	    return {
	      browseUsers: false
	    };
	  },
	
	  methods: (0, _extends3.default)({}, (0, _vuex.mapActions)({ onMessage: _meta.actions.onNewMessageToUser })),
	  mounted: function mounted() {
	    var _this = this;
	
	    this.$nextTick(function () {
	      _perfectScrollbar2.default.initialize(_this.$refs.sidebarLeft, {
	        suppressScrollX: true
	      });
	    });
	  },
	  created: function created() {
	    var _this2 = this;
	
	    this.$echo.private(this.user.channel).listen('NewMessage', function (message) {
	      return _this2.onMessage({ message: message });
	    });
	  }
	};

/***/ },
/* 266 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _vuex = __webpack_require__(8);
	
	var _throttle = __webpack_require__(73);
	
	var _throttle2 = _interopRequireDefault(_throttle);
	
	var _util = __webpack_require__(3);
	
	var _meta = __webpack_require__(6);
	
	var _Directory = __webpack_require__(237);
	
	var _Directory2 = _interopRequireDefault(_Directory);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'UserDirectory',
	  created: function created() {
	    this.getPeople({});
	  },
	
	  components: { Directory: _Directory2.default },
	  computed: (0, _extends3.default)({}, (0, _vuex.mapGetters)({
	    users: _meta.getters.users
	  })),
	  data: function data() {
	    return { q: '', page: 0 };
	  },
	
	  methods: (0, _extends3.default)({
	    onClose: function onClose() {
	      window.history.back();
	    },
	    onPersonSelected: function onPersonSelected(user) {
	      this.$router.push({ name: 'hub.user-preview', params: { user: user.id } });
	    },
	
	    onSearch: (0, _throttle2.default)(function onSearch(query) {
	      this.page = 1;
	      this.q = query;
	      this.getPeople({ q: query });
	    }, 500),
	    onInfinite: function onInfinite(_ref) {
	      var _this = this;
	
	      var done = _ref.done;
	
	      this.getPeople({ q: this.q, page: this.page + 1 }).then(_util.httpThen).then(function (result) {
	        _this.page = result._meta.pagination.current_page;
	
	        done();
	      }).catch(function () {
	        return done();
	      });
	    }
	  }, (0, _vuex.mapActions)({
	    getPeople: _meta.actions.getUsers
	  }))
	};

/***/ },
/* 267 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _first = __webpack_require__(21);
	
	var _first2 = _interopRequireDefault(_first);
	
	var _each = __webpack_require__(31);
	
	var _each2 = _interopRequireDefault(_each);
	
	var _toInteger = __webpack_require__(48);
	
	var _toInteger2 = _interopRequireDefault(_toInteger);
	
	var _vuex = __webpack_require__(8);
	
	var _components = __webpack_require__(24);
	
	var _util = __webpack_require__(3);
	
	var _meta = __webpack_require__(6);
	
	var _meta2 = __webpack_require__(13);
	
	var _MessagePane = __webpack_require__(233);
	
	var _MessagePane2 = _interopRequireDefault(_MessagePane);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'UserMessages',
	  components: {
	    MessageBox: _components.MessageBox,
	    MessageList: _MessagePane2.default,
	    MessageEditor: _components.MessageEditor,
	    LoadingPlaceholder: _components.LoadingPlaceholder
	  },
	  computed: (0, _extends3.default)({
	    context: function context() {
	      var _this = this;
	
	      var route = this.$route;
	      var userMap = this.userMap;
	      var users = this.users;
	
	      var id = (0, _toInteger2.default)(route.params.user);
	      var index = userMap[id];
	      var user = users[index];
	
	      if (!user) window.setTimeout(function () {
	        return _this.findUser();
	      }, 0);
	
	      return user;
	    }
	  }, (0, _vuex.mapGetters)({
	    users: _meta2.getters.users,
	    userMap: _meta2.getters.userMap
	  })),
	  data: function data() {
	    return {
	      message: '',
	      disabled: false,
	      loading: false,
	      allLoaded: false
	    };
	  },
	
	  methods: (0, _extends3.default)({
	    send: function send() {
	      var _this2 = this;
	
	      this.sendMessage({ userId: this.context.id, content: this.message });
	      this.$nextTick(function () {
	        _this2.$refs.list.$emit('scrollToLast');
	        _this2.$refs.input.resize();
	        _this2.$refs.input.focus();
	      });
	      this.message = '';
	    },
	    loadMore: function loadMore(loader) {
	      var _this3 = this;
	
	      this.getMessages({ userId: this.context.id, params: {} }).then(_util.httpThen).then(function (result) {
	        var paginator = result._meta.pagination;
	
	        if (paginator.current_page < paginator.total_pages) {
	          var message = (0, _first2.default)(_this3.context.messages);
	
	          if (message && message.unread === true) {
	            _this3.loadMore(loader);
	            return;
	          }
	        }
	
	        if (paginator.current_page < paginator.total_pages) {
	          loader.done();
	        } else {
	          loader.end();
	        }
	      }).catch(function () {
	        return loader.error();
	      });
	    },
	    markMessagesSeen: function markMessagesSeen() {
	      var _this4 = this;
	
	      window.setTimeout(function () {
	        var messages = _this4.context.messages.filter(function (message) {
	          return message.unread;
	        });
	        (0, _each2.default)(messages, function (message) {
	          return _this4.readMessage({ userId: _this4.context.id, message: message });
	        });
	      }, 1000);
	    },
	    findUser: function findUser() {
	      var _this5 = this;
	
	      if (!(this.$route.params.user in this.userMap)) {
	        this.findUsers({ id: this.$route.params.user }).then(_util.httpThen).then(function (result) {
	          _this5.$store.commit(_meta2.types.ADD_USER, result.data);
	        });
	      }
	    }
	  }, (0, _vuex.mapActions)({
	    findUsers: _meta.actions.getUsers,
	    readMessage: _meta2.actions.sendMessageReadReceipt,
	    sendMessage: _meta2.actions.sendMessageToUser,
	    getMessages: _meta2.actions.getMessagesFromUser
	  })),
	  watch: {
	    $route: 'findUser'
	  }
	};

/***/ },
/* 268 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _vue = __webpack_require__(12);
	
	var _vue2 = _interopRequireDefault(_vue);
	
	var _components = __webpack_require__(24);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'userPreview',
	  beforeRouteEnter: function beforeRouteEnter(to, from, next) {
	    _vue2.default.http.get('people/' + to.params.user).then(function (response) {
	      return response.json();
	    }).then(function (result) {
	      next(function (vm) {
	        _vue2.default.set(vm, 'user', result);
	      });
	    }).catch(function () {});
	  },
	
	  components: { LoadingPlaceholder: _components.LoadingPlaceholder, ActivityBox: _components.ActivityBox },
	  computed: {
	    title: function title() {
	      var user = this.user;
	
	      return user ? user.name : '';
	    },
	    subtitle: function subtitle() {
	      var user = this.user;
	
	      return user ? user.bio : '';
	    }
	  },
	  data: function data() {
	    return {
	      user: null
	    };
	  },
	
	  methods: {
	    close: function close() {
	      window.history.back();
	    }
	  }
	};

/***/ },
/* 269 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _moment = __webpack_require__(1);
	
	var _moment2 = _interopRequireDefault(_moment);
	
	var _last = __webpack_require__(469);
	
	var _last2 = _interopRequireDefault(_last);
	
	var _first = __webpack_require__(21);
	
	var _first2 = _interopRequireDefault(_first);
	
	var _Message = __webpack_require__(234);
	
	var _Message2 = _interopRequireDefault(_Message);
	
	var _PullToRefresh = __webpack_require__(525);
	
	var _PullToRefresh2 = _interopRequireDefault(_PullToRefresh);
	
	var _ContinuedMessage = __webpack_require__(519);
	
	var _ContinuedMessage2 = _interopRequireDefault(_ContinuedMessage);
	
	var _DateSeparator = __webpack_require__(520);
	
	var _DateSeparator2 = _interopRequireDefault(_DateSeparator);
	
	var _NewSeparator = __webpack_require__(521);
	
	var _NewSeparator2 = _interopRequireDefault(_NewSeparator);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	function getScrollParent(elm) {
	  if (elm.tagName === 'BODY') {
	    return window;
	  } else if (['scroll', 'auto'].indexOf(window.getComputedStyle(elm).overflowY) > -1) {
	    return elm;
	  }
	  return getScrollParent(elm.parentNode);
	}
	
	exports.default = {
	  props: {
	    messages: {
	      required: true
	    }
	  },
	  components: { Message: _Message2.default, ContinuedMessage: _ContinuedMessage2.default, DateSeparator: _DateSeparator2.default, NewSeparator: _NewSeparator2.default, InfiniteLoading: _PullToRefresh2.default },
	  computed: {
	    unread: function unread() {
	      var messages = this.messages;
	      var firstUnread = (0, _first2.default)(messages.filter(function (message) {
	        return message.unread;
	      }));
	
	      if (firstUnread) {
	        return { id: firstUnread.id, count: messages.length - messages.indexOf(firstUnread) };
	      }
	
	      return { id: undefined, count: 0 };
	    }
	  },
	  created: function created() {
	    var _this = this;
	
	    this.$on('scrollToLast', function () {
	      return _this.scrollInView((0, _last2.default)(_this.messages));
	    });
	    this.$on('scrollToFirst', function () {
	      return _this.scrollInView((0, _first2.default)(_this.messages));
	    });
	  },
	  mounted: function mounted() {
	    var _this2 = this;
	
	    this.scrollParent = getScrollParent(this.$el);
	    this.$nextTick(function () {
	      return _this2.$emit('scrollToLast');
	    });
	  },
	  data: function data() {
	    return {
	      scrollParent: null,
	      loading: false,
	      skipScroll: false,
	      hideLoadButton: false
	    };
	  },
	
	  methods: {
	    scrollInView: function scrollInView(message) {
	      this.skipScroll = false;
	      if (!message) return;
	
	      var element = document.getElementById('message-' + message.id);
	      element.scrollIntoView(true);
	    },
	    decorator: function decorator(message, index) {
	      var type = 'message';
	
	      if (message._type === 'image') {
	        type = message._type;
	      }
	
	      if (index < 1 || this.isDateChangingAt(message, index) || message.id === this.unread.id) {
	        return type;
	      }
	
	      var prevMessage = this.messages[index - 1];
	
	      if (message.sender.id === prevMessage.sender.id && (0, _moment2.default)(message.received_at).diff((0, _moment2.default)(prevMessage.received_at), 'minutes') < 2) {
	        return 'continued-' + type;
	      }
	
	      return type;
	    },
	    isDateChangingAt: function isDateChangingAt(message, index) {
	      if (index === 0) return true;
	
	      var prevMessage = this.messages[index - 1];
	
	      return !(0, _moment2.default)(message.received_at).isSame((0, _moment2.default)(prevMessage.received_at), 'day');
	    },
	    loadMore: function loadMore() {
	      var _this3 = this;
	
	      this.loading = true;
	      var toEnd = this.messages.length === 0;
	
	      var done = function done() {
	        _this3.loading = false;
	        if (toEnd) _this3.$nextTick(function () {
	          return _this3.$emit('scrollToLast');
	        });
	        if (_this3.$refs.infinite) {
	          _this3.$refs.infinite.$emit('$InfiniteLoading:loaded');
	        }
	
	        _this3.$nextTick(function () {
	          var sh = _this3.scrollParent.getBoundingClientRect().height;
	          if (sh >= _this3.$el.getBoundingClientRect().height) {
	            _this3.loadMore();
	          }
	        });
	      };
	      var end = function end() {
	        _this3.hideLoadButton = true;
	        if (toEnd) _this3.$nextTick(function () {
	          return _this3.$emit('scrollToLast');
	        });
	
	        if (_this3.$refs.infinite) {
	          _this3.$refs.infinite.$emit('$InfiniteLoading:complete');
	        }
	      };
	
	      this.$emit('load-more', { done: done, end: end, error: end });
	    }
	  },
	  watch: {
	    messages: function messages(n, o) {
	      var _this4 = this;
	
	      if (this.skipScroll) return;
	
	      this.skipScroll = true;
	      var el = this.$el.getBoundingClientRect();
	
	      var ty = this.scrollParent.scrollTop;
	      var by = el.height - ty;
	      var pre = (0, _first2.default)(n) === (0, _first2.default)(o);
	
	      this.$nextTick(function () {
	        var height = _this4.$el.getBoundingClientRect().height;
	        var sh = height - by;
	        _this4.skipScroll = false;
	        if (pre) {
	          _this4.scrollInView((0, _last2.default)(_this4.messages));
	        } else {
	          _this4.scrollParent.scrollTop = sh;
	        }
	      });
	    }
	  }
	};

/***/ },
/* 270 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _each = __webpack_require__(31);
	
	var _each2 = _interopRequireDefault(_each);
	
	var _sortBy = __webpack_require__(47);
	
	var _sortBy2 = _interopRequireDefault(_sortBy);
	
	var _first = __webpack_require__(21);
	
	var _first2 = _interopRequireDefault(_first);
	
	var _toInteger = __webpack_require__(48);
	
	var _toInteger2 = _interopRequireDefault(_toInteger);
	
	var _vuex = __webpack_require__(8);
	
	var _moment = __webpack_require__(1);
	
	var _moment2 = _interopRequireDefault(_moment);
	
	var _util = __webpack_require__(3);
	
	var _meta = __webpack_require__(13);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  created: function created() {
	    if (!this.groups.length) {
	      this.getAllGroups();
	    }
	  },
	
	  computed: (0, _extends3.default)({
	    sortedGroups: function sortedGroups() {
	      var groups = this.groups;
	
	      return (0, _sortBy2.default)(groups, function (group) {
	        var message = (0, _first2.default)(group.messages);
	        if (!message) return 0;
	
	        return -(0, _moment2.default)(message.received_at).valueOf();
	      });
	    },
	    activeId: function activeId() {
	      var route = this.$route;
	
	      if ('group' in route.params) {
	        return (0, _toInteger2.default)(route.params.group);
	      }
	
	      return -1;
	    }
	  }, (0, _vuex.mapGetters)({
	    groups: _meta.getters.groups
	  })),
	  data: function data() {
	    return {
	      joined: {}
	    };
	  },
	
	  methods: (0, _extends3.default)({
	    onGroupSelected: function onGroupSelected(group) {
	      this.$router.push({
	        name: 'hub.group',
	        params: { group: group.id }
	      });
	    },
	    onListBrowse: function onListBrowse() {
	      this.$router.push({ name: 'hub.groups' });
	    },
	    joinGroupChannels: function joinGroupChannels() {
	      var _this = this;
	
	      (0, _each2.default)(this.groups, function (group) {
	        if (_this.joined[group.id] !== true) {
	          _this.$echo.join(group.channel).listen('NewMessage', function (message) {
	            return _this.onMessage({ groupId: group.id, message: message });
	          });
	          _this.joined[group.id] = true;
	        }
	      });
	    },
	    getAllGroups: function getAllGroups() {
	      var _this2 = this;
	
	      return this.getGroups().then(_util.httpThen).then(function (result) {
	        var paginator = result._meta.pagination;
	
	        if (paginator.current_page < paginator.total_pages) {
	          setTimeout(function () {
	            return _this2.getAllGroups();
	          }, 0);
	        }
	      }).catch(function (response) {
	        return response;
	      });
	    }
	  }, (0, _vuex.mapActions)({
	    getGroups: _meta.actions.getGroups,
	    sendMessage: _meta.actions.sendMessageToGroup,
	    onMessage: _meta.actions.onNewMessageToGroup
	  })),
	  watch: {
	    groups: function groups() {
	      this.joinGroupChannels();
	    }
	  }
	};

/***/ },
/* 271 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _sortBy = __webpack_require__(47);
	
	var _sortBy2 = _interopRequireDefault(_sortBy);
	
	var _first = __webpack_require__(21);
	
	var _first2 = _interopRequireDefault(_first);
	
	var _toInteger = __webpack_require__(48);
	
	var _toInteger2 = _interopRequireDefault(_toInteger);
	
	var _vuex = __webpack_require__(8);
	
	var _moment = __webpack_require__(1);
	
	var _moment2 = _interopRequireDefault(_moment);
	
	var _util = __webpack_require__(3);
	
	var _meta = __webpack_require__(13);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  created: function created() {
	    if (!this.users.length) {
	      this.getRecentUsers();
	    }
	  },
	
	  computed: (0, _extends3.default)({
	    sortedUsers: function sortedUsers() {
	      var users = this.users;
	
	      return (0, _sortBy2.default)(users, function (user) {
	        var message = (0, _first2.default)(user.messages);
	        if (!message) return 0;
	
	        return -(0, _moment2.default)(message.received_at).valueOf();
	      });
	    },
	    activeId: function activeId() {
	      var route = this.$route;
	
	      if ('user' in route.params) {
	        return (0, _toInteger2.default)(route.params.user);
	      }
	
	      return -1;
	    }
	  }, (0, _vuex.mapGetters)({
	    users: _meta.getters.users
	  })),
	  methods: (0, _extends3.default)({
	    onListBrowse: function onListBrowse() {
	      this.$router.push({ name: 'hub.users' });
	    },
	    onUserSelected: function onUserSelected(user) {
	      this.$router.push({
	        name: 'hub.user',
	        params: { user: user.id }
	      });
	    },
	    getRecentUsers: function getRecentUsers() {
	      var _this = this;
	
	      this.getUsers().then(_util.httpThen).then(function (result) {
	        var paginator = result._meta.pagination;
	
	        if (paginator.current_page < Math.min(2, paginator.total_pages)) {
	          setTimeout(function () {
	            return _this.getRecentUsers();
	          });
	        }
	      }).catch(function (response) {
	        return response;
	      });
	    }
	  }, (0, _vuex.mapActions)({
	    getUsers: _meta.actions.getMessagedUsers
	  }))
	};

/***/ },
/* 272 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _Message = __webpack_require__(234);
	
	var _Message2 = _interopRequireDefault(_Message);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'ContinuedMessage',
	  props: (0, _extends3.default)({}, _Message2.default.props),
	  components: { Message: _Message2.default }
	};

/***/ },
/* 273 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _moment = __webpack_require__(1);
	
	var _moment2 = _interopRequireDefault(_moment);
	
	var _util = __webpack_require__(3);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  name: 'Message',
	  props: {
	    message: {
	      required: true
	    }
	  },
	  filters: {
	    time: function time(date) {
	      return (0, _moment2.default)(date).format('LT');
	    }
	  },
	  computed: {
	    content: function content() {
	      var message = this.message;
	
	      return (0, _util.nl2br)((0, _util.escapeHtml)(message.content));
	    }
	  },
	  methods: {
	    onSenderProfile: function onSenderProfile() {
	      this.$emit('open-sender', this.message);
	    }
	  }
	};

/***/ },
/* 274 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _moment = __webpack_require__(1);
	
	var _moment2 = _interopRequireDefault(_moment);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: {
	    date: {
	      require: true
	    },
	    unread: {
	      default: false
	    },
	    count: {
	      type: Number
	    }
	  },
	  filters: {
	    day: function day(date) {
	      return (0, _moment2.default)(date).format('D MMMM YYYY');
	    }
	  },
	  computed: {
	    text: function text() {
	      var count = this.count;
	
	      return count === 1 ? '1 New Message' : count + ' New Messages';
	    }
	  }
	};

/***/ },
/* 275 */
/***/ function(module, exports) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	exports.default = {
	  props: {
	    count: {
	      type: Number
	    }
	  },
	  computed: {
	    text: function text() {
	      var count = this.count;
	
	      return count === 1 ? '1 New Message' : count + ' New Messages';
	    }
	  }
	};

/***/ },
/* 276 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _jquery = __webpack_require__(94);
	
	var _jquery2 = _interopRequireDefault(_jquery);
	
	var _debounce = __webpack_require__(110);
	
	var _debounce2 = _interopRequireDefault(_debounce);
	
	var _each = __webpack_require__(31);
	
	var _each2 = _interopRequireDefault(_each);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: {
	    actions: {
	      type: Array,
	      default: function _default() {
	        return [];
	      }
	    }
	  },
	  computed: {
	    id: function id() {
	      return 'message-box-' + this._uid;
	    },
	    isEmpty: function isEmpty() {
	      var actions = this.actions;
	
	      return actions.length === 0;
	    },
	    isSpaceAvailable: function isSpaceAvailable() {
	      var canFit = this.canFit;
	
	      return canFit > 0;
	    },
	    maxIndex: function maxIndex() {
	      var actions = this.actions;
	
	      var index = void 0;
	      (0, _each2.default)(actions, function (action, id) {
	        if (index === undefined && action.collapseIfRoom === false) {
	          index = id;
	        }
	      });
	
	      return index === undefined ? actions.length : index;
	    },
	    otherActions: function otherActions() {
	      var actions = this.actions;
	      var canFit = Math.min(this.canFit, this.maxIndex);
	
	      if (canFit >= actions.length) {
	        return [];
	      }
	
	      return actions.slice(canFit).map(function (action, index) {
	        return { action: action, index: index };
	      });
	    },
	    collapsedActions: function collapsedActions() {
	      var actions = this.actions;
	      var canFit = Math.min(this.canFit, this.maxIndex);
	
	      if (canFit < 1) {
	        return [];
	      }
	
	      return actions.slice(0, canFit).map(function (action, index) {
	        return { action: action, index: index };
	      });
	    }
	  },
	  data: function data() {
	    return {
	      canFit: 0
	    };
	  },
	
	  methods: {
	    checkWidth: function checkWidth() {
	      var selector = (0, _jquery2.default)(this.$refs.dropdown);
	      var container = (0, _jquery2.default)(this.$el).parent();
	
	      var num = (container.width() - selector.outerWidth()) / selector.outerWidth();
	
	      this.canFit = parseInt(num, 10);
	    },
	    click: function click(event, action, index) {
	      this.$emit('option-click', event, action, index);
	    }
	  },
	  mounted: function mounted() {
	    var _this = this;
	
	    (0, _jquery2.default)(window).on('resize.action-menu', (0, _debounce2.default)(function () {
	      _this.checkWidth();
	    }, 500));
	    this.$nextTick(function () {
	      _this.checkWidth();
	    });
	  },
	  beforeDestroy: function beforeDestroy() {
	    (0, _jquery2.default)(window).off('resize.action-menu');
	  }
	};

/***/ },
/* 277 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _LayoutBox = __webpack_require__(77);
	
	var _LayoutBox2 = _interopRequireDefault(_LayoutBox);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: (0, _extends3.default)({
	    show: {
	      type: Boolean,
	      default: false
	    },
	    title: String,
	    subtitle: String,
	    enableTopbar: {
	      default: false,
	      type: Boolean
	    }
	  }, _LayoutBox2.default.props),
	  components: { LayoutBox: _LayoutBox2.default },
	  methods: {
	    onOptionClick: _LayoutBox2.default.methods.onOptionClick
	  }
	};

/***/ },
/* 278 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _sifter = __webpack_require__(499);
	
	var _sifter2 = _interopRequireDefault(_sifter);
	
	var _vueInfiniteLoading = __webpack_require__(230);
	
	var _vueInfiniteLoading2 = _interopRequireDefault(_vueInfiniteLoading);
	
	var _PersonCard = __webpack_require__(239);
	
	var _PersonCard2 = _interopRequireDefault(_PersonCard);
	
	var _ActivityBox = __webpack_require__(236);
	
	var _ActivityBox2 = _interopRequireDefault(_ActivityBox);
	
	var _util = __webpack_require__(3);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: (0, _extends3.default)({
	    items: {
	      required: true
	    }
	  }, (0, _util.mapObject)(_ActivityBox2.default.props, ['title', 'subtitle', 'actions'])),
	  components: { ActivityBox: _ActivityBox2.default, ItemCard: _PersonCard2.default, InfiniteScroll: _vueInfiniteLoading2.default },
	  computed: {
	    searchable: function searchable() {
	      var items = this.items;
	
	      return new _sifter2.default(items);
	    },
	    filtered: function filtered() {
	      var searchable = this.searchable;
	      var items = this.items;
	      var query = this.q;
	      var result = searchable.search(query, {
	        fields: ['name'],
	        sort_empty: [{ field: 'name', direction: 'asc' }]
	      });
	      return result.items.map(function (_ref) {
	        var id = _ref.id;
	        return items[id];
	      });
	    }
	  },
	  data: function data() {
	    return {
	      q: '',
	      resultMessage: ''
	    };
	  },
	
	  methods: {
	    onOptionClick: _ActivityBox2.default.methods.onOptionClick,
	    onInfinite: function onInfinite() {
	      var _this = this;
	
	      var end = function end() {
	        return _this.$refs.infinite.$emit('$InfiniteLoading:complete');
	      };
	      var done = function done() {
	        return _this.$refs.infinite.$emit('$InfiniteLoading:loaded');
	      };
	
	      this.$emit('load-more', {
	        done: done,
	        end: end,
	        error: end
	      });
	    }
	  }
	};

/***/ },
/* 279 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _util = __webpack_require__(3);
	
	var _ActionMenu = __webpack_require__(235);
	
	var _ActionMenu2 = _interopRequireDefault(_ActionMenu);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: (0, _extends3.default)({
	    disableFooter: {
	      default: false
	    }
	  }, _ActionMenu2.default.props),
	  components: { ActionMenu: _ActionMenu2.default },
	  computed: {
	    isFooterDisabled: function isFooterDisabled() {
	      var disableFooter = this.disableFooter;
	
	      return (0, _util.bool)(disableFooter);
	    }
	  },
	  methods: {
	    onOptionClick: function onOptionClick() {
	      for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
	        args[_key] = arguments[_key];
	      }
	
	      this.$emit.apply(this, ['option-click'].concat(args));
	    }
	  }
	};

/***/ },
/* 280 */
/***/ function(module, exports) {

	"use strict";

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	exports.default = {};

/***/ },
/* 281 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _LayoutBox = __webpack_require__(77);
	
	var _LayoutBox2 = _interopRequireDefault(_LayoutBox);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: (0, _extends3.default)({
	    type: {
	      type: String,
	      default: 'user'
	    },
	    title: String,
	    subtitle: String,
	    photo: String
	  }, _LayoutBox2.default.props),
	  components: { LayoutBox: _LayoutBox2.default },
	  computed: {
	    typeClass: function typeClass() {
	      var type = this.type;
	
	      switch (type) {
	        case 'user':
	          return 'photo-square';
	        default:
	          return 'photo-round';
	      }
	    }
	  }
	};

/***/ },
/* 282 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _autosize = __webpack_require__(245);
	
	var _autosize2 = _interopRequireDefault(_autosize);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: {
	    disabled: {
	      type: Boolean,
	      default: false
	    },
	    value: {
	      type: String,
	      required: true
	    }
	  },
	  methods: {
	    resize: function resize() {
	      var _this = this;
	
	      var event = window.document.createEvent('Event');
	      event.initEvent('autosize:destroy', false, true);
	      this.$refs.input.dispatchEvent(event);
	      this.$nextTick(function () {
	        (0, _autosize2.default)(_this.$refs.input);
	      });
	    },
	    focus: function focus() {
	      var _this2 = this;
	
	      setTimeout(function () {
	        return _this2.$refs.input.focus();
	      }, 0);
	    },
	    onInput: function onInput(event) {
	      this.$emit('input', event.target.value);
	    },
	    onEnter: function onEnter(event) {
	      if (event.shiftKey !== true) {
	        event.preventDefault();
	        this.$emit('send', event);
	      }
	    }
	  },
	  mounted: function mounted() {
	    var _this3 = this;
	
	    this.$nextTick(function () {
	      (0, _autosize2.default)(_this3.$refs.input);
	    });
	  }
	};

/***/ },
/* 283 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _extends2 = __webpack_require__(2);
	
	var _extends3 = _interopRequireDefault(_extends2);
	
	var _vuex = __webpack_require__(8);
	
	var _meta = __webpack_require__(6);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  computed: (0, _extends3.default)({
	    title: function title() {
	      return 'Name of the School';
	    },
	    name: function name() {
	      var user = this.user;
	
	      if ('name' in user) return user.name;
	
	      return '';
	    }
	  }, (0, _vuex.mapGetters)({ user: _meta.getters.user }))
	};

/***/ },
/* 284 */
/***/ function(module, exports) {

	"use strict";
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	exports.default = {
	  props: {
	    person: {
	      required: true
	    }
	  }
	};

/***/ },
/* 285 */
/***/ function(module, exports) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	
	var spinnerMapping = {
	  bubbles: 'loading-bubbles',
	  circles: 'loading-circles',
	  default: 'loading-default',
	  spiral: 'loading-spiral',
	  waveDots: 'loading-wave-dots'
	};
	
	function getScrollParent(elm) {
	  if (elm.tagName === 'BODY') {
	    return window;
	  } else if (['scroll', 'auto'].indexOf(window.getComputedStyle(elm).overflowY) > -1) {
	    return elm;
	  }
	  return getScrollParent(elm.parentNode);
	}
	
	function getCurrentDistance(elm) {
	  var scrollTop = isNaN(elm.scrollTop) ? elm.pageYOffset : elm.scrollTop;
	
	
	  return scrollTop;
	}
	
	exports.default = {
	  data: function data() {
	    return {
	      scrollParent: null,
	      scrollHandler: null,
	      isLoading: false,
	      isComplete: false,
	      isFirstLoad: true };
	  },
	
	  computed: {
	    spinnerType: function spinnerType() {
	      return spinnerMapping[this.spinner] || spinnerMapping.default;
	    }
	  },
	  props: {
	    distance: {
	      type: Number,
	      default: 0
	    },
	    onInfinite: Function,
	    spinner: String
	  },
	  mounted: function mounted() {
	    var _this = this;
	
	    this.scrollParent = getScrollParent(this.$el);
	
	    this.scrollHandler = function () {
	      var currentDistance = getCurrentDistance(_this.scrollParent);
	      if (!_this.isLoading && currentDistance <= _this.distance) {
	        _this.isLoading = true;
	        if (_this.onInfinite) {
	          _this.onInfinite.call();
	        }
	      }
	    };
	
	    setTimeout(this.scrollHandler, 1);
	    this.scrollParent.addEventListener('scroll', this.scrollHandler);
	
	    this.$on('$InfiniteLoading:loaded', function () {
	      _this.isLoading = false;
	      _this.isFirstLoad = false;
	    });
	    this.$on('$InfiniteLoading:complete', function () {
	      _this.isLoading = false;
	      _this.isComplete = true;
	      _this.scrollParent.removeEventListener('scroll', _this.scrollHandler);
	    });
	    this.$on('$InfiniteLoading:reset', function () {
	      _this.isLoading = false;
	      _this.isComplete = false;
	      _this.isFirstLoad = true;
	      _this.scrollParent.addEventListener('scroll', _this.scrollHandler);
	      setTimeout(_this.scrollHandler, 1);
	    });
	  },
	  destroyed: function destroyed() {
	    if (!this.isComplete) {
	      this.scrollParent.removeEventListener('scroll', this.scrollHandler);
	    }
	  }
	};

/***/ },
/* 286 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _util = __webpack_require__(3);
	
	exports.default = {
	  props: {
	    open: {
	      type: Boolean,
	      default: false
	    },
	    contentClass: String,
	    sidebarClass: String
	  },
	  computed: {
	    stateClass: function stateClass() {
	      var state = this.open;
	
	      return (0, _util.bool)(state) === true ? 'open' : undefined;
	    }
	  }
	};

/***/ },
/* 287 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _isArray = __webpack_require__(4);
	
	var _isArray2 = _interopRequireDefault(_isArray);
	
	var _isString = __webpack_require__(113);
	
	var _isString2 = _interopRequireDefault(_isString);
	
	var _input = __webpack_require__(50);
	
	var _input2 = _interopRequireDefault(_input);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: {
	    type: {
	      default: 'radio',
	      validator: function validator(value) {
	        return ['radio', 'checkbox'].indexOf(value) > -1;
	      }
	    },
	    stacked: Boolean,
	    options: {
	      type: Object,
	      required: true
	    }
	  },
	  mixins: [_input2.default],
	  computed: {
	    helpId: function helpId() {
	      return this.id + '-help-text';
	    },
	    localValue: function localValue() {
	      var value = this.value;
	
	      if ((0, _isArray2.default)(value)) {
	        return value;
	      }
	
	      if ((0, _isString2.default)(value) && value.length > 0) {
	        return [value];
	      }
	
	      return [];
	    }
	  },
	  methods: {
	    onInput: function onInput(event, option) {
	      if (this.type === 'radio') {
	        return this.$emit('input', option);
	      }
	
	      var value = this.value;
	      if (!(0, _isArray2.default)(value)) {
	        return this.$emit('input', [option]);
	      }
	
	      var index = value.indexOf(option);
	      if (index > -1) {
	        value.splice(index, 1);
	      } else {
	        value.push(option);
	      }
	
	      return this.$emit('input', value);
	    }
	  }
	};

/***/ },
/* 288 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _input = __webpack_require__(50);
	
	var _input2 = _interopRequireDefault(_input);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: {
	    type: {
	      type: String,
	      default: 'text'
	    }
	  },
	  mixins: [_input2.default],
	  computed: {
	    helpId: function helpId() {
	      return this.id + '-help-text';
	    }
	  }
	};

/***/ },
/* 289 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _input = __webpack_require__(50);
	
	var _input2 = _interopRequireDefault(_input);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = {
	  props: {
	    type: {
	      type: String,
	      default: 'noresize'
	    }
	  },
	  mixins: [_input2.default],
	  computed: {
	    helpId: function helpId() {
	      return this.id + '-help-text';
	    }
	  }
	};

/***/ },
/* 290 */,
/* 291 */,
/* 292 */,
/* 293 */,
/* 294 */,
/* 295 */,
/* 296 */,
/* 297 */,
/* 298 */,
/* 299 */,
/* 300 */,
/* 301 */,
/* 302 */,
/* 303 */,
/* 304 */,
/* 305 */,
/* 306 */,
/* 307 */,
/* 308 */,
/* 309 */,
/* 310 */,
/* 311 */,
/* 312 */,
/* 313 */,
/* 314 */,
/* 315 */,
/* 316 */,
/* 317 */,
/* 318 */,
/* 319 */,
/* 320 */,
/* 321 */,
/* 322 */,
/* 323 */,
/* 324 */,
/* 325 */,
/* 326 */,
/* 327 */,
/* 328 */,
/* 329 */,
/* 330 */,
/* 331 */,
/* 332 */,
/* 333 */,
/* 334 */,
/* 335 */,
/* 336 */,
/* 337 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 338 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 339 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 340 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 341 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 342 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 343 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 344 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 345 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 346 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 347 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 348 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 349 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 350 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 351 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 352 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 353 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 354 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 355 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 356 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 357 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 358 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 359 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 360 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 361 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 362 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 363 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 364 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 365 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 366 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 367 */,
/* 368 */,
/* 369 */,
/* 370 */,
/* 371 */,
/* 372 */,
/* 373 */,
/* 374 */,
/* 375 */,
/* 376 */,
/* 377 */,
/* 378 */,
/* 379 */,
/* 380 */,
/* 381 */,
/* 382 */,
/* 383 */,
/* 384 */,
/* 385 */,
/* 386 */,
/* 387 */,
/* 388 */,
/* 389 */,
/* 390 */,
/* 391 */,
/* 392 */,
/* 393 */,
/* 394 */,
/* 395 */,
/* 396 */,
/* 397 */,
/* 398 */,
/* 399 */,
/* 400 */,
/* 401 */,
/* 402 */,
/* 403 */,
/* 404 */,
/* 405 */,
/* 406 */,
/* 407 */,
/* 408 */,
/* 409 */,
/* 410 */,
/* 411 */,
/* 412 */,
/* 413 */,
/* 414 */,
/* 415 */,
/* 416 */,
/* 417 */,
/* 418 */,
/* 419 */,
/* 420 */,
/* 421 */,
/* 422 */,
/* 423 */,
/* 424 */,
/* 425 */,
/* 426 */,
/* 427 */,
/* 428 */,
/* 429 */,
/* 430 */,
/* 431 */,
/* 432 */,
/* 433 */,
/* 434 */,
/* 435 */,
/* 436 */,
/* 437 */,
/* 438 */,
/* 439 */,
/* 440 */,
/* 441 */,
/* 442 */,
/* 443 */,
/* 444 */,
/* 445 */,
/* 446 */,
/* 447 */,
/* 448 */,
/* 449 */,
/* 450 */,
/* 451 */,
/* 452 */,
/* 453 */,
/* 454 */,
/* 455 */,
/* 456 */,
/* 457 */,
/* 458 */,
/* 459 */,
/* 460 */,
/* 461 */,
/* 462 */,
/* 463 */,
/* 464 */,
/* 465 */,
/* 466 */,
/* 467 */,
/* 468 */,
/* 469 */,
/* 470 */,
/* 471 */,
/* 472 */,
/* 473 */,
/* 474 */,
/* 475 */,
/* 476 */,
/* 477 */,
/* 478 */,
/* 479 */
/***/ function(module, exports, __webpack_require__) {

	var map = {
		"./af": 117,
		"./af.js": 117,
		"./ar": 123,
		"./ar-dz": 118,
		"./ar-dz.js": 118,
		"./ar-ly": 119,
		"./ar-ly.js": 119,
		"./ar-ma": 120,
		"./ar-ma.js": 120,
		"./ar-sa": 121,
		"./ar-sa.js": 121,
		"./ar-tn": 122,
		"./ar-tn.js": 122,
		"./ar.js": 123,
		"./az": 124,
		"./az.js": 124,
		"./be": 125,
		"./be.js": 125,
		"./bg": 127,
		"./bg-x": 126,
		"./bg-x.js": 126,
		"./bg.js": 127,
		"./bn": 128,
		"./bn.js": 128,
		"./bo": 129,
		"./bo.js": 129,
		"./br": 130,
		"./br.js": 130,
		"./bs": 131,
		"./bs.js": 131,
		"./ca": 132,
		"./ca.js": 132,
		"./cs": 133,
		"./cs.js": 133,
		"./cv": 134,
		"./cv.js": 134,
		"./cy": 135,
		"./cy.js": 135,
		"./da": 136,
		"./da.js": 136,
		"./de": 138,
		"./de-at": 137,
		"./de-at.js": 137,
		"./de.js": 138,
		"./dv": 139,
		"./dv.js": 139,
		"./el": 140,
		"./el.js": 140,
		"./en-au": 141,
		"./en-au.js": 141,
		"./en-ca": 142,
		"./en-ca.js": 142,
		"./en-gb": 143,
		"./en-gb.js": 143,
		"./en-ie": 144,
		"./en-ie.js": 144,
		"./en-nz": 145,
		"./en-nz.js": 145,
		"./eo": 146,
		"./eo.js": 146,
		"./es": 148,
		"./es-do": 147,
		"./es-do.js": 147,
		"./es.js": 148,
		"./et": 149,
		"./et.js": 149,
		"./eu": 150,
		"./eu.js": 150,
		"./fa": 151,
		"./fa.js": 151,
		"./fi": 152,
		"./fi.js": 152,
		"./fo": 153,
		"./fo.js": 153,
		"./fr": 156,
		"./fr-ca": 154,
		"./fr-ca.js": 154,
		"./fr-ch": 155,
		"./fr-ch.js": 155,
		"./fr.js": 156,
		"./fy": 157,
		"./fy.js": 157,
		"./gd": 158,
		"./gd.js": 158,
		"./gl": 159,
		"./gl.js": 159,
		"./he": 160,
		"./he.js": 160,
		"./hi": 161,
		"./hi.js": 161,
		"./hr": 162,
		"./hr.js": 162,
		"./hu": 163,
		"./hu.js": 163,
		"./hy-am": 164,
		"./hy-am.js": 164,
		"./id": 165,
		"./id.js": 165,
		"./is": 166,
		"./is.js": 166,
		"./it": 167,
		"./it.js": 167,
		"./ja": 168,
		"./ja.js": 168,
		"./jv": 169,
		"./jv.js": 169,
		"./ka": 170,
		"./ka.js": 170,
		"./kk": 171,
		"./kk.js": 171,
		"./km": 172,
		"./km.js": 172,
		"./ko": 173,
		"./ko.js": 173,
		"./ky": 174,
		"./ky.js": 174,
		"./lb": 175,
		"./lb.js": 175,
		"./lo": 176,
		"./lo.js": 176,
		"./lt": 177,
		"./lt.js": 177,
		"./lv": 178,
		"./lv.js": 178,
		"./me": 179,
		"./me.js": 179,
		"./mi": 180,
		"./mi.js": 180,
		"./mk": 181,
		"./mk.js": 181,
		"./ml": 182,
		"./ml.js": 182,
		"./mr": 183,
		"./mr.js": 183,
		"./ms": 185,
		"./ms-my": 184,
		"./ms-my.js": 184,
		"./ms.js": 185,
		"./my": 186,
		"./my.js": 186,
		"./nb": 187,
		"./nb.js": 187,
		"./ne": 188,
		"./ne.js": 188,
		"./nl": 190,
		"./nl-be": 189,
		"./nl-be.js": 189,
		"./nl.js": 190,
		"./nn": 191,
		"./nn.js": 191,
		"./pa-in": 192,
		"./pa-in.js": 192,
		"./pl": 193,
		"./pl.js": 193,
		"./pt": 195,
		"./pt-br": 194,
		"./pt-br.js": 194,
		"./pt.js": 195,
		"./ro": 196,
		"./ro.js": 196,
		"./ru": 197,
		"./ru.js": 197,
		"./se": 198,
		"./se.js": 198,
		"./si": 199,
		"./si.js": 199,
		"./sk": 200,
		"./sk.js": 200,
		"./sl": 201,
		"./sl.js": 201,
		"./sq": 202,
		"./sq.js": 202,
		"./sr": 204,
		"./sr-cyrl": 203,
		"./sr-cyrl.js": 203,
		"./sr.js": 204,
		"./ss": 205,
		"./ss.js": 205,
		"./sv": 206,
		"./sv.js": 206,
		"./sw": 207,
		"./sw.js": 207,
		"./ta": 208,
		"./ta.js": 208,
		"./te": 209,
		"./te.js": 209,
		"./tet": 210,
		"./tet.js": 210,
		"./th": 211,
		"./th.js": 211,
		"./tl-ph": 212,
		"./tl-ph.js": 212,
		"./tlh": 213,
		"./tlh.js": 213,
		"./tr": 214,
		"./tr.js": 214,
		"./tzl": 215,
		"./tzl.js": 215,
		"./tzm": 217,
		"./tzm-latn": 216,
		"./tzm-latn.js": 216,
		"./tzm.js": 217,
		"./uk": 218,
		"./uk.js": 218,
		"./uz": 219,
		"./uz.js": 219,
		"./vi": 220,
		"./vi.js": 220,
		"./x-pseudo": 221,
		"./x-pseudo.js": 221,
		"./zh-cn": 222,
		"./zh-cn.js": 222,
		"./zh-hk": 223,
		"./zh-hk.js": 223,
		"./zh-tw": 224,
		"./zh-tw.js": 224
	};
	function webpackContext(req) {
		return __webpack_require__(webpackContextResolve(req));
	};
	function webpackContextResolve(req) {
		return map[req] || (function() { throw new Error("Cannot find module '" + req + "'.") }());
	};
	webpackContext.keys = function webpackContextKeys() {
		return Object.keys(map);
	};
	webpackContext.resolve = webpackContextResolve;
	module.exports = webpackContext;
	webpackContext.id = 479;


/***/ },
/* 480 */,
/* 481 */,
/* 482 */,
/* 483 */,
/* 484 */,
/* 485 */,
/* 486 */,
/* 487 */,
/* 488 */,
/* 489 */,
/* 490 */,
/* 491 */,
/* 492 */,
/* 493 */,
/* 494 */,
/* 495 */,
/* 496 */,
/* 497 */,
/* 498 */,
/* 499 */,
/* 500 */,
/* 501 */,
/* 502 */,
/* 503 */,
/* 504 */,
/* 505 */,
/* 506 */,
/* 507 */,
/* 508 */,
/* 509 */
/***/ function(module, exports) {

	module.exports = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNCIgaGVpZ2h0PSIxNCIgdmlld0JveD0iMCAwIDE0IDE0Ij4KICA8cG9seWdvbiBjbGFzcz0iYWN0aXZpdHktYm94LWNyb3NzIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHBvaW50cz0iMTkgNi40IDE3LjYgNSAxMiAxMC42IDYuNCA1IDUgNi40IDEwLjYgMTIgNSAxNy42IDYuNCAxOSAxMiAxMy40IDE3LjYgMTkgMTkgMTcuNiAxMy40IDEyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtNSAtNSkiIG9wYWNpdHk9Ii41NCIvPgo8L3N2Zz4K"

/***/ },
/* 510 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(350)
	
	/* script */
	__vue_exports__ = __webpack_require__(260)
	
	/* template */
	var __vue_template__ = __webpack_require__(543)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 511 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(351)
	
	/* script */
	__vue_exports__ = __webpack_require__(261)
	
	/* template */
	var __vue_template__ = __webpack_require__(544)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 512 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(365)
	
	/* script */
	__vue_exports__ = __webpack_require__(262)
	
	/* template */
	var __vue_template__ = __webpack_require__(558)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 513 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(349)
	
	/* script */
	__vue_exports__ = __webpack_require__(264)
	
	/* template */
	var __vue_template__ = __webpack_require__(542)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 514 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(362)
	
	/* script */
	__vue_exports__ = __webpack_require__(265)
	
	/* template */
	var __vue_template__ = __webpack_require__(555)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 515 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(358)
	
	/* script */
	__vue_exports__ = __webpack_require__(266)
	
	/* template */
	var __vue_template__ = __webpack_require__(551)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 516 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(353)
	
	/* script */
	__vue_exports__ = __webpack_require__(268)
	
	/* template */
	var __vue_template__ = __webpack_require__(546)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 517 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(363)
	
	/* script */
	__vue_exports__ = __webpack_require__(270)
	
	/* template */
	var __vue_template__ = __webpack_require__(556)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	__vue_options__._scopeId = "data-v-acb09552"
	
	module.exports = __vue_exports__


/***/ },
/* 518 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(342)
	
	/* script */
	__vue_exports__ = __webpack_require__(271)
	
	/* template */
	var __vue_template__ = __webpack_require__(535)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	__vue_options__._scopeId = "data-v-214f1b5f"
	
	module.exports = __vue_exports__


/***/ },
/* 519 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(361)
	
	/* script */
	__vue_exports__ = __webpack_require__(272)
	
	/* template */
	var __vue_template__ = __webpack_require__(554)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 520 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(347)
	
	/* script */
	__vue_exports__ = __webpack_require__(274)
	
	/* template */
	var __vue_template__ = __webpack_require__(540)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 521 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(360)
	
	/* script */
	__vue_exports__ = __webpack_require__(275)
	
	/* template */
	var __vue_template__ = __webpack_require__(553)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 522 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(356)
	
	/* script */
	__vue_exports__ = __webpack_require__(280)
	
	/* template */
	var __vue_template__ = __webpack_require__(549)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 523 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(366)
	
	/* script */
	__vue_exports__ = __webpack_require__(281)
	
	/* template */
	var __vue_template__ = __webpack_require__(559)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 524 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(348)
	
	/* script */
	__vue_exports__ = __webpack_require__(282)
	
	/* template */
	var __vue_template__ = __webpack_require__(541)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 525 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(337)
	
	/* script */
	__vue_exports__ = __webpack_require__(285)
	
	/* template */
	var __vue_template__ = __webpack_require__(530)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 526 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(359)
	
	/* script */
	__vue_exports__ = __webpack_require__(286)
	
	/* template */
	var __vue_template__ = __webpack_require__(552)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 527 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(354)
	
	/* script */
	__vue_exports__ = __webpack_require__(287)
	
	/* template */
	var __vue_template__ = __webpack_require__(547)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 528 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(355)
	
	/* script */
	__vue_exports__ = __webpack_require__(288)
	
	/* template */
	var __vue_template__ = __webpack_require__(548)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 529 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}
	
	/* styles */
	__webpack_require__(338)
	
	/* script */
	__vue_exports__ = __webpack_require__(289)
	
	/* template */
	var __vue_template__ = __webpack_require__(531)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns
	
	module.exports = __vue_exports__


/***/ },
/* 530 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (_vm.isLoading),
	      expression: "isLoading"
	    }],
	    staticClass: "pull-to-refresh-container"
	  }, [_vm._t("spinner", [_vm._h('i', {
	    class: _vm.spinnerType
	  })]), " ", _vm._h('div', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (!_vm.isLoading && _vm.isComplete && _vm.isFirstLoad),
	      expression: "!isLoading && isComplete && isFirstLoad"
	    }],
	    staticClass: "pull-to-refresh-status-prompt"
	  }, [_vm._t("no-results", ["No results :("])]), " ", _vm._h('div', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (!_vm.isLoading && _vm.isComplete && !_vm.isFirstLoad),
	      expression: "!isLoading && isComplete && !isFirstLoad"
	    }],
	    staticClass: "pull-to-refresh-status-prompt"
	  }, [_vm._t("no-more", ["No more data :)"])])])
	},staticRenderFns: []}

/***/ },
/* 531 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "form-group",
	    class: [_vm.feedbackState]
	  }, [(_vm.is(_vm.title)) ? _vm._h('label', {
	    staticClass: "form-control-label",
	    attrs: {
	      "for": _vm.id
	    }
	  }, [_vm._s(_vm.title)]) : _vm._e(), " ", _vm._h('textarea', {
	    staticClass: "form-control",
	    class: [_vm.type, _vm.formControlState],
	    attrs: {
	      "type": _vm.type,
	      "id": _vm.id,
	      "rows": "5",
	      "described-by": _vm.helpId,
	      "name": _vm.identifier
	    },
	    domProps: {
	      "value": _vm.value
	    },
	    on: {
	      "input": function($event) {
	        _vm.$emit('input', $event.target.value)
	      }
	    }
	  }), " ", (_vm.is(_vm.feedback)) ? _vm._h('div', {
	    staticClass: "form-control-feedback"
	  }, [_vm._s(_vm.feedback)]) : _vm._e(), " ", (_vm.is(_vm.subtitle)) ? _vm._h('small', {
	    staticClass: "form-text text-muted",
	    attrs: {
	      "id": _vm.helpId
	    }
	  }, [_vm._s(_vm.subtitle)]) : _vm._e()])
	},staticRenderFns: []}

/***/ },
/* 532 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('activity-box', _vm._b({
	    on: {
	      "close": function($event) {
	        _vm.$emit('close')
	      },
	      "option-click": _vm.onOptionClick
	    }
	  }, 'activity-box', {
	    title: _vm.title,
	    subtitle: _vm.subtitle,
	    show: true,
	    actions: _vm.actions,
	    disableFooter: true
	  }), [_vm._h('div', {
	    staticClass: "directory-header row"
	  }, [_vm._h('div', {
	    staticClass: "col-xs-12 col-lg-8 offset-lg-2 my-2"
	  }, [_vm._h('div', {
	    staticClass: "input-group input-group-lg"
	  }, [_vm._h('span', {
	    staticClass: "input-group-addon"
	  }, [_vm._h('i', {
	    staticClass: "fa fa-search"
	  })]), " ", _vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.q),
	      expression: "q"
	    }],
	    staticClass: "form-control",
	    attrs: {
	      "type": "search"
	    },
	    domProps: {
	      "value": _vm._s(_vm.q)
	    },
	    on: {
	      "keyup": function($event) {
	        _vm.$emit('search', _vm.q)
	      },
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.q = $event.target.value
	      }
	    }
	  })])])]), " ", _vm._h('div', {
	    staticClass: "row directory-results-container"
	  }, [_vm._h('div', {
	    staticClass: "col-xs-12 col-lg-8 offset-lg-2"
	  }, [_vm._h('div', {
	    staticClass: "row"
	  }, [_vm._h('div', {
	    staticClass: "col-xs-12 directory-results-description"
	  }, [_vm._s(_vm.resultMessage)])]), " ", _vm._h('div', {
	    staticClass: "row"
	  }, [_vm._l((_vm.filtered), function(item, index) {
	    return _vm._h('div', {
	      staticClass: "col-xs-12 col-md-6"
	    }, [_vm._h('item-card', {
	      attrs: {
	        "person": item
	      },
	      on: {
	        "open": function($event) {
	          _vm.$emit('item', item, index)
	        }
	      }
	    })])
	  }), " ", _vm._h('infinite-scroll', {
	    ref: "infinite",
	    staticClass: "col-xs-12",
	    attrs: {
	      "on-infinite": _vm.onInfinite,
	      "spinner": "waveDots"
	    }
	  })])])])])
	},staticRenderFns: []}

/***/ },
/* 533 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [(_vm.context) ? _vm._h('message-box', {
	    attrs: {
	      "title": _vm.context.name,
	      "subtitle": _vm.context.bio,
	      "photo": _vm.context.photo
	    }
	  }, [_vm._h('message-list', {
	    attrs: {
	      "messages": _vm.context.messages
	    },
	    on: {
	      "load-more": _vm.loadMore,
	      "seen": _vm.markMessagesSeen
	    }
	  }), " ", _vm._h('message-editor', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.message),
	      expression: "message"
	    }],
	    ref: "input",
	    slot: "footer",
	    domProps: {
	      "value": (_vm.message)
	    },
	    on: {
	      "send": _vm.send,
	      "focused": _vm.markMessagesSeen,
	      "input": function($event) {
	        _vm.message = $event
	      }
	    }
	  })]) : _vm._h('loading-placeholder'), " "])
	},staticRenderFns: []}

/***/ },
/* 534 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "message-list-container",
	    on: {
	      "click": function($event) {
	        $event.preventDefault();
	        $event.stopPropagation();
	        _vm.$emit('seen')
	      }
	    }
	  }, [_vm._h('infinite-loading', {
	    ref: "infinite",
	    attrs: {
	      "on-infinite": _vm.loadMore,
	      "distance": 0,
	      "spinner": "waveDots"
	    }
	  }), " ", _vm._l((_vm.messages), function(message, index) {
	    return (_vm.messages.length) ? _vm._h('div', {
	      key: "id",
	      staticClass: "message-list-item",
	      attrs: {
	        "id": ("message-" + (message.id))
	      }
	    }, [(_vm.isDateChangingAt(message, index)) ? _vm._h('date-separator', {
	      attrs: {
	        "date": message.received_at,
	        "unread": message.id === _vm.unread.id,
	        "count": _vm.unread.count
	      }
	    }) : [(message.id === _vm.unread.id) ? _vm._h('new-separator', {
	      attrs: {
	        "count": _vm.unread.count
	      }
	    }) : _vm._e()], " ", " ", _vm._h(_vm.decorator(message, index), {
	      tag: "div",
	      attrs: {
	        "message": message
	      }
	    })]) : _vm._e()
	  })])
	},staticRenderFns: []}

/***/ },
/* 535 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "user-list"
	  }, [_vm._h('div', {
	    staticClass: "user-list-container"
	  }, [_vm._l((_vm.sortedUsers), function(user, index) {
	    return _vm._h('div', {
	      staticClass: "user-list-item",
	      class: {
	        active: _vm.activeId === user.id
	      },
	      on: {
	        "click": function($event) {
	          $event.stopPropagation();
	          $event.preventDefault();
	          _vm.onUserSelected(user, index, $event)
	        }
	      }
	    }, [_vm._h('img', {
	      staticClass: "user-list-photo",
	      attrs: {
	        "src": user.photo
	      }
	    }), " ", _vm._h('div', {
	      staticClass: "user-list-name",
	      class: {
	        unread: user.has_unread
	      }
	    }, ["\n        " + _vm._s(user.name) + "\n      "])])
	  })])])
	},staticRenderFns: []}

/***/ },
/* 536 */
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "card person-card",
	    on: {
	      "click": function($event) {
	        $event.preventDefault();
	        _vm.$emit('open')
	      }
	    }
	  }, [_vm._h('div', {
	    staticClass: "card-block person-card-block"
	  }, [_vm._h('img', {
	    staticClass: "person-card-img",
	    attrs: {
	      "src": __webpack_require__(76),
	      "src": _vm.person.photo
	    }
	  }), " ", _vm._h('div', {
	    staticClass: "person-card-info-container"
	  }, [_vm._h('div', {
	    staticClass: "person-card-name"
	  }, [_vm._s(_vm.person.name)]), " ", _vm._h('div', {
	    staticClass: "person-card-meta-container"
	  }, [_vm._t("default", [_vm._h('div', {
	    staticClass: "person-card-bio"
	  }, [_vm._s(_vm.person.bio)])])])])])])
	},staticRenderFns: []}

/***/ },
/* 537 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return (!_vm.isEmpty) ? _vm._h('div', {
	    staticClass: "action-menu"
	  }, [(_vm.isSpaceAvailable) ? _vm._h('div', {
	    staticClass: "action-menu-actions"
	  }, [_vm._l((_vm.collapsedActions), function({
	    action,
	    index
	  }) {
	    return [_vm._t('action-menu-' + index, [_vm._h('a', {
	      staticClass: "action-menu-action",
	      attrs: {
	        "href": "#"
	      },
	      on: {
	        "click": function($event) {
	          $event.preventDefault();
	          _vm.click($event, action, index)
	        }
	      }
	    }, [_vm._h('i', {
	      staticClass: "fa fa-fw",
	      class: [("fa-" + (action.icon))]
	    })])])]
	  })]) : _vm._e(), " ", (_vm.otherActions.length) ? _vm._h('div', {
	    ref: "dropdown",
	    staticClass: "dropdown"
	  }, [_vm._h('button', {
	    staticClass: "action-menu-toggler",
	    attrs: {
	      "data-toggle": "dropdown",
	      "type": "button",
	      "id": _vm.id,
	      "aria-haspopup": "true",
	      "aria-expanded": "false"
	    }
	  }, [_vm._h('i', {
	    staticClass: "fa fa-fw fa-ellipsis-v"
	  })]), " ", _vm._h('div', {
	    staticClass: "dropdown-menu dropdown-menu-right",
	    attrs: {
	      "aria-labelledby": _vm.id
	    }
	  }, [_vm._l((_vm.otherActions), function({
	    action,
	    index
	  }) {
	    return [_vm._t('action-menu-' + index, [_vm._h('a', {
	      staticClass: "dropdown-item",
	      attrs: {
	        "href": "#"
	      },
	      on: {
	        "click": function($event) {
	          $event.preventDefault();
	          _vm.click($event, action, index)
	        }
	      }
	    }, [_vm._h('i', {
	      staticClass: "fa fa-fw",
	      class: [("fa-" + (action.icon))]
	    }), " " + _vm._s(action.name) + "\n        "])])]
	  })])]) : _vm._e()]) : _vm._e()
	},staticRenderFns: []}

/***/ },
/* 538 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "layout-box"
	  }, [_vm._h('div', {
	    staticClass: "layout-box-header"
	  }, [_vm._t("header", [_vm._t("context"), " ", _vm._h('div', {
	    staticClass: "layout-box-actions-container"
	  }, [_vm._t("actions", [_vm._h('action-menu', {
	    attrs: {
	      "actions": _vm.actions
	    },
	    on: {
	      "option-click": _vm.onOptionClick
	    }
	  })])])])]), " ", _vm._h('div', {
	    staticClass: "layout-box-body"
	  }, [_vm._t("default")]), " ", (!_vm.isFooterDisabled) ? _vm._h('div', {
	    staticClass: "layout-box-footer"
	  }, [_vm._t("footer")]) : _vm._e()])
	},staticRenderFns: []}

/***/ },
/* 539 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "message-container"
	  }, [_vm._t("sender-photo", [_vm._h('img', {
	    staticClass: "message-sender-photo",
	    class: [_vm.message.sender._type],
	    attrs: {
	      "src": "assets/people.jpg",
	      "src": _vm.message.sender.photo
	    },
	    on: {
	      "click": function($event) {
	        $event.stopPropagation();
	        $event.preventDefault();
	        _vm.onSenderProfile()
	      }
	    }
	  })]), " ", _vm._t("message", [_vm._h('div', {
	    staticClass: "message-box"
	  }, [_vm._h('div', {
	    staticClass: "message-meta"
	  }, [_vm._t("message-meta", [_vm._h('a', {
	    staticClass: "message-sender-name",
	    attrs: {
	      "href": "#"
	    },
	    on: {
	      "click": function($event) {
	        $event.stopPropagation();
	        $event.preventDefault();
	        _vm.onSenderProfile(_vm.message.sender)
	      }
	    }
	  }, [_vm._s(_vm.message.sender.name)]), "\n          ·\n          ", _vm._h('span', {
	    staticClass: "message-received-at"
	  }, [_vm._s(_vm._f("time")(_vm.message.received_at))])])]), " ", _vm._h('div', {
	    staticClass: "message-content"
	  }, [_vm._t("default", [_vm._h('span', {
	    domProps: {
	      "innerHTML": _vm._s(_vm.content)
	    }
	  })])])])])])
	},staticRenderFns: []}

/***/ },
/* 540 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "message-date-separator"
	  }, [_vm._h('hr'), " ", _vm._h('div', {
	    staticClass: "message-date-content",
	    class: {
	      'new-messages': _vm.unread
	    }
	  }, [_vm._s(_vm._f("day")(_vm.date)) + " ", (_vm.unread) ? _vm._h('span', ["·\n    " + _vm._s(_vm.text)]) : _vm._e()]), " ", _vm._h('hr')])
	},staticRenderFns: []}

/***/ },
/* 541 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "message-input-wrapper"
	  }, [_vm._h('textarea', {
	    ref: "input",
	    staticClass: "message-input",
	    attrs: {
	      "name": "message",
	      "placeholder": "Start discussing...",
	      "autofocus": "",
	      "disabled": _vm.disabled,
	      "rows": "1",
	      "autocomplete": "off",
	      "autocorrect": "off"
	    },
	    domProps: {
	      "value": _vm.value
	    },
	    on: {
	      "input": _vm.onInput,
	      "keydown": function($event) {
	        if ($event.keyCode !== 13) { return; }
	        _vm.onEnter($event)
	      },
	      "focus": function($event) {
	        _vm.$emit('focused')
	      }
	    }
	  })])
	},staticRenderFns: []}

/***/ },
/* 542 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return (_vm.group) ? _vm._h('activity-box', _vm._b({
	    on: {
	      "close": _vm.close
	    }
	  }, 'activity-box', {
	    title: _vm.title,
	    subtitle: _vm.subtitle,
	    show: true,
	    actions: [],
	    disableFooter: true
	  }), [_vm._h('div', {
	    staticClass: "container py-2"
	  }, [_vm._h('div', {
	    staticClass: "text-xs-center"
	  }, [_vm._h('img', {
	    staticClass: "group-preview-photo my-2",
	    attrs: {
	      "src": _vm.group.photo
	    }
	  }), " ", _vm._h('div', {
	    staticClass: "my-2"
	  }, [(!_vm.group.private) ? _vm._h('span', {
	    staticClass: "alert alert-info group-preview-tag"
	  }, ["Public Group"]) : _vm._h('span', {
	    staticClass: "alert alert-danger group-preview-tag"
	  }, ["Public Group"]), " "]), " ", _vm._h('h2', [_vm._s(_vm.group.name)]), " ", _vm._h('p', [_vm._h('small', {
	    staticClass: "text-muted"
	  }, [_vm._s(_vm.group.bio)])])]), " ", _vm._h('div', {
	    staticClass: "row"
	  }, [_vm._h('div', {
	    staticClass: "col-xs-12 col-lg-8 offset-lg-2 my-2"
	  }, [_vm._h('div', {
	    staticClass: "input-group input-group-lg"
	  }, [_vm._h('span', {
	    staticClass: "input-group-addon"
	  }, [_vm._h('i', {
	    staticClass: "fa fa-search"
	  })]), " ", _vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.q),
	      expression: "q"
	    }],
	    staticClass: "form-control",
	    attrs: {
	      "type": "search"
	    },
	    domProps: {
	      "value": _vm._s(_vm.q)
	    },
	    on: {
	      "keyup": _vm.search,
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.q = $event.target.value
	      }
	    }
	  })])]), " ", _vm._h('div', {
	    staticClass: "col-xs-12 col-lg-8 offset-lg-2 my-2"
	  }, [_vm._h('div', {
	    staticClass: "row"
	  }, [_vm._l((_vm.members), function(member, index) {
	    return _vm._h('div', {
	      staticClass: "col-xs-12 col-lg-6"
	    }, [_vm._h('item-card', {
	      attrs: {
	        "person": member
	      },
	      on: {
	        "open": function($event) {
	          _vm.openMemberProfile(member, index)
	        }
	      }
	    })])
	  }), " ", _vm._h('infinite-scroll', {
	    ref: "infinite",
	    staticClass: "col-xs-12",
	    attrs: {
	      "on-infinite": _vm.onInfinite
	    }
	  })])])])])]) : _vm._h('loading-placeholder')
	},staticRenderFns: []}

/***/ },
/* 543 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "app"
	  }, [_vm._h('nav-bar'), " ", _vm._h('router-view')])
	},staticRenderFns: []}

/***/ },
/* 544 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('activity-box', {
	    attrs: {
	      "title": "Add new group",
	      "subtitle": "Make group to coverse better.",
	      "enable-topbar": true,
	      "show": true
	    }
	  }, [_vm._h('template', {
	    slot: "topbar"
	  }, [_vm._h('a', {
	    ref: "action",
	    staticClass: "btn btn-primary",
	    attrs: {
	      "href": "#"
	    },
	    on: {
	      "click": function($event) {
	        $event.preventDefault();
	        $event.stopPropagation();
	        _vm.createGroup($event)
	      }
	    }
	  }, ["\n    Create Group\n  "])]), " ", _vm._h('div', {
	    staticClass: "container py-1"
	  }, [_vm._h('div', {
	    staticClass: "my-2 text-xs-center"
	  }), " ", _vm._h('div', {
	    staticClass: "row"
	  }, [_vm._h('div', {
	    staticClass: "col-xs-12 col-lg-8 offset-lg-2"
	  }, [_vm._h('input-text', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.group.name),
	      expression: "group.name"
	    }],
	    attrs: {
	      "title": "Name of the group",
	      "required": "",
	      "feedback": _vm.errors.name
	    },
	    domProps: {
	      "value": (_vm.group.name)
	    },
	    on: {
	      "input": function($event) {
	        _vm.group.name = $event
	      }
	    }
	  })]), " ", _vm._h('div', {
	    staticClass: "col-xs-6 col-lg-8 offset-lg-2"
	  }, [_vm._h('input-radio', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.group.type),
	      expression: "group.type"
	    }],
	    attrs: {
	      "title": "Group Type",
	      "required": "",
	      "options": _vm.groupTypes,
	      "feedback": _vm.errors.type
	    },
	    domProps: {
	      "value": (_vm.group.type)
	    },
	    on: {
	      "input": function($event) {
	        _vm.group.type = $event
	      }
	    }
	  })]), " ", _vm._h('div', {
	    staticClass: "col-xs-6 col-lg-8 offset-lg-2"
	  }, [_vm._h('input-textarea', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.group.description),
	      expression: "group.description"
	    }],
	    attrs: {
	      "title": "Description",
	      "feedback": _vm.errors.description
	    },
	    domProps: {
	      "value": (_vm.group.description)
	    },
	    on: {
	      "input": function($event) {
	        _vm.group.description = $event
	      }
	    }
	  })])])])])
	},staticRenderFns: []}

/***/ },
/* 545 */
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return (_vm.show) ? _vm._h('transition', {
	    attrs: {
	      "name": "activity-box",
	      "appear": ""
	    }
	  }, [_vm._h('layout-box', _vm._b({
	    on: {
	      "option-click": _vm.onOptionClick
	    }
	  }, 'layout-box', {
	    actions: _vm.actions,
	    disableFooter: _vm.disableFooter
	  }), [_vm._h('template', {
	    slot: "context"
	  }, [_vm._h('a', {
	    staticClass: "activity-box-dismiss",
	    attrs: {
	      "href": "#"
	    },
	    on: {
	      "click": function($event) {
	        $event.preventDefault();
	        $event.stopPropagation();
	        _vm.$emit('close')
	      }
	    }
	  }, [_vm._h('img', {
	    attrs: {
	      "src": __webpack_require__(509)
	    }
	  })]), " ", _vm._h('div', {
	    staticClass: "activity-box-title-container"
	  }, [_vm._h('div', {
	    staticClass: "activity-box-title"
	  }, [_vm._t("title", [_vm._s(_vm.title)])]), " ", _vm._h('div', {
	    staticClass: "activity-box-subtitle"
	  }, [_vm._t("subtitle", [_vm._s(_vm.subtitle)])])])]), " ", (_vm.enableTopbar) ? _vm._h('template', {
	    slot: "actions"
	  }, [_vm._t("topbar")]) : _vm._e(), " ", _vm._t("default")])]) : _vm._e()
	},staticRenderFns: []}

/***/ },
/* 546 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return (_vm.user) ? _vm._h('activity-box', _vm._b({
	    on: {
	      "close": _vm.close
	    }
	  }, 'activity-box', {
	    title: _vm.title,
	    subtitle: _vm.subtitle,
	    show: true,
	    actions: [],
	    disableFooter: true
	  }), [_vm._h('div', {
	    staticClass: "container py-2"
	  }, [_vm._h('div', {
	    staticClass: "text-xs-center"
	  }, [_vm._h('img', {
	    staticClass: "user-preview-photo my-2",
	    attrs: {
	      "src": _vm.user.photo
	    }
	  }), " ", _vm._h('h2', [_vm._s(_vm.user.name)]), " ", _vm._h('p', [_vm._h('small', {
	    staticClass: "text-muted"
	  }, [_vm._s(_vm.user.bio)])]), " ", _vm._h('div', {
	    staticClass: "my-2"
	  }, [_vm._h('router-link', {
	    staticClass: "btn btn-primary",
	    attrs: {
	      "to": {
	        name: 'hub.user',
	        params: {
	          user: _vm.user.id
	        }
	      }
	    }
	  }, ["Send Message\n        "])])])])]) : _vm._h('loading-placeholder')
	},staticRenderFns: []}

/***/ },
/* 547 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "form-group",
	    class: [_vm.feedbackState]
	  }, [(_vm.is(_vm.title)) ? _vm._h('label', {
	    staticClass: "form-control-label",
	    attrs: {
	      "for": _vm.id
	    }
	  }, [_vm._s(_vm.title)]) : _vm._e(), " ", _vm._h('div', {
	    staticClass: "input-group",
	    attrs: {
	      "id": _vm.id,
	      "described-by": _vm.helpId,
	      "role": "form"
	    }
	  }, [_vm._h('div', {
	    class: {
	      'c-inputs-stacked': _vm.stacked
	    }
	  }, [_vm._l((_vm.options), function(option, key) {
	    return _vm._h('label', {
	      key: key,
	      staticClass: "c-input input-radio"
	    }, [_vm._h('input', {
	      attrs: {
	        "name": _vm.identifier,
	        "type": _vm.type
	      },
	      domProps: {
	        "value": key
	      },
	      on: {
	        "click": function($event) {
	          $event.preventDefault();
	          $event.stopPropagation();
	          _vm.onInput($event, key)
	        }
	      }
	    }), " ", _vm._h('div', {
	      staticClass: "c-indicator",
	      class: {
	        checked: _vm.localValue.indexOf(key) > -1
	      }
	    }, [_vm._s(option)])])
	  })])]), " ", (_vm.is(_vm.feedback)) ? _vm._h('div', {
	    staticClass: "form-control-feedback"
	  }, [_vm._s(_vm.feedback)]) : _vm._e(), " ", (_vm.is(_vm.subtitle)) ? _vm._h('small', {
	    staticClass: "form-text text-muted",
	    attrs: {
	      "id": _vm.helpId
	    }
	  }, [_vm._s(_vm.subtitle)]) : _vm._e()])
	},staticRenderFns: []}

/***/ },
/* 548 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "form-group",
	    class: [_vm.feedbackState]
	  }, [(_vm.is(_vm.title)) ? _vm._h('label', {
	    staticClass: "form-control-label",
	    attrs: {
	      "for": _vm.id
	    }
	  }, [_vm._s(_vm.title)]) : _vm._e(), " ", _vm._h('input', {
	    staticClass: "form-control",
	    class: [_vm.formControlState],
	    attrs: {
	      "type": _vm.type,
	      "id": _vm.id,
	      "described-by": _vm.helpId,
	      "name": _vm.identifier
	    },
	    domProps: {
	      "value": _vm.value
	    },
	    on: {
	      "input": function($event) {
	        _vm.$emit('input', $event.target.value)
	      }
	    }
	  }), " ", (_vm.is(_vm.feedback)) ? _vm._h('div', {
	    staticClass: "form-control-feedback"
	  }, [_vm._s(_vm.feedback)]) : _vm._e(), " ", (_vm.is(_vm.subtitle)) ? _vm._h('small', {
	    staticClass: "form-text text-muted",
	    attrs: {
	      "id": _vm.helpId
	    }
	  }, [_vm._s(_vm.subtitle)]) : _vm._e()])
	},staticRenderFns: []}

/***/ },
/* 549 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._m(0)
	},staticRenderFns: [function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "loading-container"
	  }, [_vm._h('div', [_vm._h('div', {
	    staticClass: "state-loading"
	  }, [_vm._h('div', {
	    staticClass: "cord leftMove"
	  }, [_vm._h('div', {
	    staticClass: "ball"
	  })]), " ", _vm._h('div', {
	    staticClass: "cord"
	  }, [_vm._h('div', {
	    staticClass: "ball"
	  })]), " ", _vm._h('div', {
	    staticClass: "cord"
	  }, [_vm._h('div', {
	    staticClass: "ball"
	  })]), " ", _vm._h('div', {
	    staticClass: "cord"
	  }, [_vm._h('div', {
	    staticClass: "ball"
	  })]), " ", _vm._h('div', {
	    staticClass: "cord"
	  }, [_vm._h('div', {
	    staticClass: "ball"
	  })]), " ", _vm._h('div', {
	    staticClass: "cord"
	  }, [_vm._h('div', {
	    staticClass: "ball"
	  })]), " ", _vm._h('div', {
	    staticClass: "cord rightMove"
	  }, [_vm._h('div', {
	    staticClass: "ball",
	    attrs: {
	      "id": "first"
	    }
	  })]), " ", _vm._h('div', {
	    staticClass: "shadows"
	  }, [_vm._h('div', {
	    staticClass: "leftShadow"
	  }), " ", _vm._h('div'), " ", _vm._h('div'), " ", _vm._h('div'), " ", _vm._h('div'), " ", _vm._h('div'), " ", _vm._h('div', {
	    staticClass: "rightShadow"
	  })])])])])
	}]}

/***/ },
/* 550 */
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('nav', {
	    staticClass: "navbar navbar-fixed-top navbar-dark bg-primary"
	  }, [_vm._h('div', {
	    staticClass: "container navbar-container"
	  }, [_vm._m(0), " ", _vm._h('div', {
	    staticClass: "navbar-brand"
	  }, [_vm._s(_vm.title)]), " ", _vm._h('div', {
	    staticClass: "navbar-user"
	  }, [_vm._h('a', {
	    staticClass: "navbar-link text-white",
	    attrs: {
	      "role": "button",
	      "href": "#"
	    },
	    on: {
	      "click": function($event) {
	        $event.preventDefault();
	        $event.stopPropagation();
	        _vm.$emit('user')
	      }
	    }
	  }, [_vm._h('span', {
	    staticClass: "hidden-sm-down"
	  }, [_vm._s(_vm.name)]), " ", _vm._h('img', {
	    staticClass: "navbar-user-photo",
	    attrs: {
	      "width": "28",
	      "height": "28",
	      "src": __webpack_require__(76)
	    }
	  })])])])])
	},staticRenderFns: [function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "dropdown"
	  }, [_vm._h('button', {
	    staticClass: "navbar-toggler",
	    attrs: {
	      "data-toggle": "dropdown",
	      "type": "button",
	      "id": "navbar-toggler",
	      "aria-haspopup": "true",
	      "aria-expanded": "false"
	    }
	  }, [_vm._h('i', {
	    staticClass: "fa fa-fw fa-bars"
	  })]), " ", _vm._h('div', {
	    staticClass: "dropdown-menu",
	    attrs: {
	      "aria-labelledby": "navbar-toggler"
	    }
	  }, [_vm._h('a', {
	    staticClass: "dropdown-item",
	    attrs: {
	      "href": "#"
	    }
	  }, ["Action"]), " ", _vm._h('a', {
	    staticClass: "dropdown-item",
	    attrs: {
	      "href": "#"
	    }
	  }, ["Another action"]), " ", _vm._h('a', {
	    staticClass: "dropdown-item",
	    attrs: {
	      "href": "#"
	    }
	  }, ["Something else here"])])])
	}]}

/***/ },
/* 551 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('directory', _vm._b({
	    attrs: {
	      "title": "Campus Directory",
	      "subtitle": "You can message any member of the institute."
	    },
	    on: {
	      "load-more": _vm.onInfinite,
	      "close": _vm.onClose,
	      "search": _vm.onSearch,
	      "item": _vm.onPersonSelected
	    }
	  }, 'directory', {
	    items: _vm.users
	  }))
	},staticRenderFns: []}

/***/ },
/* 552 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "content-box"
	  }, [_vm._h('div', {
	    staticClass: "content-box-content",
	    class: [_vm.contentClass]
	  }, [_vm._t("default")]), " ", _vm._h('div', {
	    staticClass: "content-box-sidebar",
	    class: [_vm.stateClass, _vm.sidebarClass]
	  }, [_vm._t("sidebar")])])
	},staticRenderFns: []}

/***/ },
/* 553 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "new-message-separator"
	  }, [_vm._h('hr'), " ", _vm._h('div', {
	    staticClass: "new-message-content"
	  }, [_vm._s(_vm.text)]), " ", _vm._h('hr')])
	},staticRenderFns: []}

/***/ },
/* 554 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('message', {
	    staticClass: "continued",
	    attrs: {
	      "message": _vm.message
	    },
	    on: {
	      "open-sender": function($event) {
	        _vm.$emit('open-sender', _vm.message)
	      }
	    }
	  }, [_vm._h('div', {
	    slot: "sender-photo",
	    staticClass: "message-sender-photo-placeholder"
	  }), " ", _vm._h('template', {
	    slot: "message-meta"
	  })])
	},staticRenderFns: []}

/***/ },
/* 555 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "container hub-container"
	  }, [_vm._h('div', {
	    staticClass: "row hub-body"
	  }, [_vm._h('div', {
	    ref: "sidebarLeft",
	    staticClass: "col-xs-12 col-lg-2 hub-sidebar-left"
	  }, [_vm._h('div', {
	    staticClass: "btn-group my-1"
	  }, [_vm._h('a', {
	    staticClass: "btn btn-outline-secondary",
	    class: {
	      active: _vm.browseUsers
	    },
	    attrs: {
	      "href": "#"
	    },
	    on: {
	      "click": function($event) {
	        $event.stopPropagation();
	        $event.preventDefault();
	        _vm.browseUsers = true
	      }
	    }
	  }, ["Private"]), " ", _vm._h('a', {
	    staticClass: "btn btn-outline-secondary",
	    class: {
	      active: !_vm.browseUsers
	    },
	    attrs: {
	      "href": "#"
	    },
	    on: {
	      "click": function($event) {
	        $event.stopPropagation();
	        $event.preventDefault();
	        _vm.browseUsers = false
	      }
	    }
	  }, ["Groups"])]), " ", _vm._h('group-list', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (!_vm.browseUsers),
	      expression: "!browseUsers"
	    }]
	  }), " ", _vm._h('user-list', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (_vm.browseUsers),
	      expression: "browseUsers"
	    }]
	  })]), " ", _vm._h('div', {
	    staticClass: "col-xs-12 col-lg-10 hub-content"
	  }, [_vm._h('router-view')])])])
	},staticRenderFns: []}

/***/ },
/* 556 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "group-list"
	  }, [_vm._h('div', {
	    staticClass: "group-list-container"
	  }, [_vm._l((_vm.sortedGroups), function(group, index) {
	    return _vm._h('div', {
	      staticClass: "group-list-item",
	      class: {
	        active: _vm.activeId === group.id
	      },
	      on: {
	        "click": function($event) {
	          $event.stopPropagation();
	          $event.preventDefault();
	          _vm.onGroupSelected(group, index, $event)
	        }
	      }
	    }, [_vm._h('img', {
	      staticClass: "group-list-photo",
	      attrs: {
	        "src": group.photo
	      }
	    }), " ", _vm._h('div', {
	      staticClass: "group-list-name",
	      class: {
	        unread: group.has_unread
	      }
	    }, ["\n        " + _vm._s(group.name) + "\n      "])])
	  })])])
	},staticRenderFns: []}

/***/ },
/* 557 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [(_vm.context) ? _vm._h('message-box', {
	    attrs: {
	      "title": _vm.context.name,
	      "subtitle": _vm.context.bio,
	      "photo": _vm.context.photo
	    }
	  }, [_vm._h('message-list', {
	    ref: "list",
	    attrs: {
	      "messages": _vm.context.messages,
	      "loading": _vm.loading,
	      "all-loaded": _vm.allLoaded
	    },
	    on: {
	      "load-more": _vm.loadMore,
	      "seen": _vm.markMessagesSeen
	    }
	  }), " ", _vm._h('message-editor', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.message),
	      expression: "message"
	    }],
	    ref: "input",
	    slot: "footer",
	    attrs: {
	      "disabled": _vm.disabled
	    },
	    domProps: {
	      "value": (_vm.message)
	    },
	    on: {
	      "send": _vm.send,
	      "focused": _vm.markMessagesSeen,
	      "input": function($event) {
	        _vm.message = $event
	      }
	    }
	  })]) : _vm._h('loading-placeholder'), " "])
	},staticRenderFns: []}

/***/ },
/* 558 */
/***/ function(module, exports) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('directory', _vm._b({
	    attrs: {
	      "title": "Campus Groups",
	      "subtitle": "You can join any of these groups."
	    },
	    on: {
	      "close": _vm.onClose,
	      "search": _vm.onSearch,
	      "load-more": _vm.onInfinite,
	      "item": _vm.onGroupSelected
	    }
	  }, 'directory', {
	    items: _vm.groups
	  }))
	},staticRenderFns: []}

/***/ },
/* 559 */
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('layout-box', _vm._b({}, 'layout-box', {
	    actions: _vm.actions,
	    disableFooter: _vm.disableFooter
	  }), [_vm._h('template', {
	    slot: "context"
	  }, [_vm._h('img', {
	    staticClass: "message-box-photo",
	    class: [_vm.typeClass],
	    attrs: {
	      "src": __webpack_require__(76),
	      "src": _vm.photo
	    }
	  }), " ", _vm._h('div', {
	    staticClass: "message-box-title-container"
	  }, [_vm._h('div', {
	    staticClass: "message-box-title"
	  }, [_vm._t("title", [_vm._s(_vm.title)])]), " ", _vm._h('div', {
	    staticClass: "message-box-subtitle"
	  }, [_vm._t("subtitle", [_vm._s(_vm.subtitle)])])])]), " ", _vm._h('template', {
	    slot: "footer"
	  }, [_vm._t("footer")]), " ", _vm._t("default")])
	},staticRenderFns: []}

/***/ },
/* 560 */,
/* 561 */,
/* 562 */,
/* 563 */
/***/ function(module, exports) {

	/* (ignored) */

/***/ }
]);
//# sourceMappingURL=app.448325448057daa19229.js.map