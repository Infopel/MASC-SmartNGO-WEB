(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[13],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/add_users.vue?vue&type=script&lang=ts&":
/*!**************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/add_users.vue?vue&type=script&lang=ts& ***!
  \**************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
















































/* harmony default export */ __webpack_exports__["default"] = (vue__WEBPACK_IMPORTED_MODULE_0___default.a.extend({
    props:[
        'usersEndpoint',
        'actionendpoint'
    ],
    computed: {
        computedActionEndPoint: function() {
        }
    },
    data() {
        return {
            loading: true,
            users: [],
            user_ids: {},
            errors: [],
            actionEndPoint: this.actionendpoint
        }
    },
    methods: {

        async loadModalUsers(){
            this.loading = true,
            this.users = [],
            axios__WEBPACK_IMPORTED_MODULE_1___default()(this.usersEndpoint || '/api/user')
            .then(response=>{
                this.users = response.data;
                this.loading = false;
            })
            .catch(error =>{
                console.log("----- Error on Load dataDashboard --------");
                console.log(error);
            })
        },

        submit(){
            axios__WEBPACK_IMPORTED_MODULE_1___default.a.post(this.actionEndPoint, {
                user_ids: this.user_ids
            }).
            then(response=>{
                console.log(response)
            })
            .catch(error=>{
                console.log(error)
            })
        }
    },
}));


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/add_users.vue?vue&type=template&id=4504a22f&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/add_users.vue?vue&type=template&id=4504a22f&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "a",
      {
        staticClass: "text-success",
        attrs: {
          href: "#",
          "data-toggle": "modal",
          "data-target": "#usersModal",
        },
        on: {
          click: function ($event) {
            return _vm.loadModalUsers()
          },
        },
      },
      [
        _c("i", { staticClass: "icon-plus2" }),
        _vm._v(" "),
        _c("span", [_vm._v(_vm._s(_vm.__("lang.label_user_new")))]),
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade text-capitalize",
        attrs: {
          id: "usersModal",
          tabindex: "-1",
          role: "dialog",
          "aria-labelledby": "usersModalCenter",
          "aria-hidden": "true",
        },
      },
      [
        _c(
          "div",
          {
            staticClass: "modal-dialog modal-lg modal-dialog-centered",
            attrs: { role: "document" },
          },
          [
            _c("div", { staticClass: "modal-content" }, [
              _c(
                "form",
                {
                  attrs: { method: "POST" },
                  on: {
                    submit: function ($event) {
                      $event.preventDefault()
                      return _vm.submit.apply(null, arguments)
                    },
                  },
                },
                [
                  _c("div", { staticClass: "modal-header p-2 pl-4 pr-4" }, [
                    _c(
                      "h5",
                      {
                        staticClass: "modal-title uppercase",
                        attrs: { id: "exampleModalCenterTitle" },
                      },
                      [_vm._v(_vm._s(_vm.__("lang.label_user_new")))]
                    ),
                    _vm._v(" "),
                    _vm._m(0),
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "modal-body" }, [
                    _vm.loading
                      ? _c("div", { staticClass: "bg-light p-2" }, [
                          _vm._v(
                            "\n                            Caregando Dados...\n                        "
                          ),
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.loading
                      ? _c("div", { staticClass: "bg-light p-2" }, [
                          _c("div", { staticClass: "users" }, [
                            _c(
                              "div",
                              { staticClass: "objects-selection" },
                              _vm._l(_vm.users, function (user, key) {
                                return _c(
                                  "label",
                                  { key: key, staticClass: "mb-0" },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.user_ids[user.id],
                                          expression: "user_ids[user.id]",
                                        },
                                      ],
                                      attrs: {
                                        type: "checkbox",
                                        name: "user_ids[]",
                                      },
                                      domProps: {
                                        checked: Array.isArray(
                                          _vm.user_ids[user.id]
                                        )
                                          ? _vm._i(
                                              _vm.user_ids[user.id],
                                              null
                                            ) > -1
                                          : _vm.user_ids[user.id],
                                      },
                                      on: {
                                        change: function ($event) {
                                          var $$a = _vm.user_ids[user.id],
                                            $$el = $event.target,
                                            $$c = $$el.checked ? true : false
                                          if (Array.isArray($$a)) {
                                            var $$v = null,
                                              $$i = _vm._i($$a, $$v)
                                            if ($$el.checked) {
                                              $$i < 0 &&
                                                _vm.$set(
                                                  _vm.user_ids,
                                                  user.id,
                                                  $$a.concat([$$v])
                                                )
                                            } else {
                                              $$i > -1 &&
                                                _vm.$set(
                                                  _vm.user_ids,
                                                  user.id,
                                                  $$a
                                                    .slice(0, $$i)
                                                    .concat($$a.slice($$i + 1))
                                                )
                                            }
                                          } else {
                                            _vm.$set(_vm.user_ids, user.id, $$c)
                                          }
                                        },
                                      },
                                    }),
                                    _vm._v(
                                      " " +
                                        _vm._s(user.full_name) +
                                        "\n                                    "
                                    ),
                                  ]
                                )
                              }),
                              0
                            ),
                          ]),
                        ])
                      : _vm._e(),
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "modal-footer p-1" }, [
                    _c("button", { attrs: { type: "submit" } }, [
                      _vm._v(_vm._s(_vm.__("lang.button_add"))),
                    ]),
                    _vm._v(" "),
                    _c(
                      "button",
                      { attrs: { type: "button", "data-dismiss": "modal" } },
                      [_vm._v(_vm._s(_vm.__("lang.button_cancel")))]
                    ),
                  ]),
                ]
              ),
            ]),
          ]
        ),
      ]
    ),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "close",
        attrs: {
          type: "button",
          "data-dismiss": "modal",
          "aria-label": "Close",
        },
      },
      [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
    )
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/add_users.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/add_users.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _add_users_vue_vue_type_template_id_4504a22f_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./add_users.vue?vue&type=template&id=4504a22f&scoped=true& */ "./resources/js/components/add_users.vue?vue&type=template&id=4504a22f&scoped=true&");
/* harmony import */ var _add_users_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./add_users.vue?vue&type=script&lang=ts& */ "./resources/js/components/add_users.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _add_users_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _add_users_vue_vue_type_template_id_4504a22f_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _add_users_vue_vue_type_template_id_4504a22f_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "4504a22f",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/add_users.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/add_users.vue?vue&type=script&lang=ts&":
/*!************************************************************************!*\
  !*** ./resources/js/components/add_users.vue?vue&type=script&lang=ts& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_add_users_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib??vue-loader-options!./add_users.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/add_users.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_add_users_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/add_users.vue?vue&type=template&id=4504a22f&scoped=true&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/add_users.vue?vue&type=template&id=4504a22f&scoped=true& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_add_users_vue_vue_type_template_id_4504a22f_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./add_users.vue?vue&type=template&id=4504a22f&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/add_users.vue?vue&type=template&id=4504a22f&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_add_users_vue_vue_type_template_id_4504a22f_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_add_users_vue_vue_type_template_id_4504a22f_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);