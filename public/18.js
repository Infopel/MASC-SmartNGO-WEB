(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[18],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/issues/new.vue?vue&type=script&lang=ts&":
/*!*********************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/issues/new.vue?vue&type=script&lang=ts& ***!
  \*********************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);






































































































/* harmony default export */ __webpack_exports__["default"] = (vue__WEBPACK_IMPORTED_MODULE_0___default.a.extend({

    data() {
        return {
            editor_content: ''
        }
    },
}));


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/issues/new.vue?vue&type=template&id=0961e952&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/issues/new.vue?vue&type=template&id=0961e952&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
      "div",
      {
        staticClass: "mb-3 bg-light rounded border p-2 pt-0",
        staticStyle: { "font-size": "90%" },
      },
      [
        _c("div", { staticClass: "tabular" }, [
          _c("p", { staticClass: "col-md-8" }, [
            _c(
              "label",
              { staticClass: "float-left", attrs: { for: "issues_type" } },
              [
                _vm._v(_vm._s(_vm.__("lang.field_type"))),
                _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              ]
            ),
            _vm._v(" "),
            _vm._m(0),
          ]),
          _vm._v(" "),
          _vm._m(1),
          _vm._v(" "),
          _c(
            "p",
            { staticClass: "col-md-11 mt-2" },
            [
              _vm._m(2),
              _vm._v(" "),
              _c("vue-editor", {
                attrs: { name: "description" },
                model: {
                  value: _vm.editor_content,
                  callback: function ($$v) {
                    _vm.editor_content = $$v
                  },
                  expression: "editor_content",
                },
              }),
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "row mt-2" }, [
            _c("div", { staticClass: "col-md-6" }, [
              _c("div", { staticClass: "tabular" }, [
                _c("p", {}, [
                  _c(
                    "label",
                    {
                      staticClass: "float-left",
                      attrs: { for: "issues_type" },
                    },
                    [
                      _vm._v(_vm._s(_vm.__("lang.field_status"))),
                      _c("span", { staticClass: "text-danger" }, [
                        _vm._v(" *"),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _vm._m(3),
                ]),
                _vm._v(" "),
                _c("p", {}, [
                  _c(
                    "label",
                    {
                      staticClass: "float-left",
                      attrs: { for: "issues_type" },
                    },
                    [
                      _vm._v(_vm._s(_vm.__("lang.field_priority"))),
                      _c("span", { staticClass: "text-danger" }, [
                        _vm._v(" *"),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _vm._m(4),
                ]),
                _vm._v(" "),
                _c("p", {}, [
                  _c(
                    "label",
                    {
                      staticClass: "float-left",
                      attrs: { for: "issues_type" },
                    },
                    [_vm._v(_vm._s(_vm.__("lang.field_assigned_to")))]
                  ),
                  _vm._v(" "),
                  _vm._m(5),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _vm._m(6),
          ]),
        ]),
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
      "select",
      {
        staticClass: "p-1 border my_input w-50",
        attrs: { name: "issue[type]" },
      },
      [_c("option", { attrs: { value: "a" } }, [_vm._v("ABC")])]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "col-md-8" }, [
      _c("label", { staticClass: "float-left", attrs: { for: "name" } }, [
        _vm._v("Nome"),
        _c("span", { staticClass: "required" }, [_vm._v(" *")]),
      ]),
      _vm._v(" "),
      _c("input", {
        staticClass: "border",
        attrs: { size: "60", type: "text", value: "", name: "issue[name]" },
      }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "float-left", attrs: { for: "project_name" } },
      [
        _vm._v("Descrição"),
        _c("span", { staticClass: "required" }, [_vm._v(" *")]),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "select",
      {
        staticClass: "p-1 border my_input w-75",
        attrs: { name: "issue[status]" },
      },
      [_c("option", { attrs: { value: "1" } }, [_vm._v("OPtion 1")])]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "select",
      {
        staticClass: "p-1 border my_input w-75",
        attrs: { name: "issue[priority]" },
      },
      [_c("option", { attrs: { value: "1" } }, [_vm._v("OPtion 1")])]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "select",
      {
        staticClass: "p-1 border my_input w-75",
        attrs: { name: "issue[assigned_to]" },
      },
      [_c("option", { attrs: { value: "1" } }, [_vm._v("OPtion 1")])]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-5" }, [
      _c("div", { staticClass: "tabular" }, [
        _c("p", [
          _c(
            "label",
            { staticClass: "float-left", attrs: { for: "issues_parent" } },
            [
              _vm._v("Tarefa pai"),
              _c("span", { staticClass: "required" }, [_vm._v(" *")]),
            ]
          ),
          _vm._v(" "),
          _c(
            "select",
            {
              staticClass: "p-1 border my_input w-100",
              attrs: { name: "issue[parent_id]" },
            },
            [_c("option", { attrs: { value: "1" } }, [_vm._v("OPtion 1")])]
          ),
        ]),
        _vm._v(" "),
        _c("p"),
        _c("div", { staticClass: "d-md-flex" }, [
          _c("div", { staticClass: "date-tab input-group w-auto" }, [
            _c("div", {}, [
              _c("label", { staticClass: "float-left mr-3 mt-2" }, [
                _vm._v("Início:"),
              ]),
            ]),
            _vm._v(" "),
            _c("input", {
              staticClass: "my_input pickadate-year",
              attrs: { type: "text", name: "issue[start_date]" },
            }),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "d-flex" }, [
          _c("div", { staticClass: "date-tab input-group w-auto" }, [
            _c("div", {}, [
              _c("label", { staticClass: "float-left mr-3 mt-2" }, [
                _vm._v("Data prevista:"),
              ]),
            ]),
            _vm._v(" "),
            _c("input", {
              staticClass: "my_input pickadate-year",
              attrs: { type: "text", name: "issue[due_date]" },
            }),
          ]),
        ]),
        _vm._v(" "),
        _c("p"),
        _vm._v(" "),
        _c("p", [
          _c("label", { staticClass: "float-left", attrs: { for: "name" } }, [
            _vm._v("Tempo estimado"),
            _c("span", { staticClass: "required" }, [_vm._v(" *")]),
          ]),
          _vm._v(" "),
          _c("input", {
            staticClass: "border w-50",
            attrs: {
              size: "60",
              type: "text",
              value: "",
              name: "issue[time_tracking]",
            },
          }),
        ]),
        _vm._v(" "),
        _c("p", [
          _c(
            "label",
            { staticClass: "float-left", attrs: { for: "issue_done_ratio" } },
            [
              _vm._v("% Terminado"),
              _c("span", { staticClass: "required" }, [_vm._v(" *")]),
            ]
          ),
          _vm._v(" "),
          _c("select", { attrs: { name: "issue[done_ratio]" } }, [
            _c("option", { attrs: { selected: "selected", value: "0" } }, [
              _vm._v("0 %"),
            ]),
            _vm._v(" "),
            _c("option", { attrs: { value: "10" } }, [_vm._v("10 %")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "20" } }, [_vm._v("20 %")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "30" } }, [_vm._v("30 %")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "40" } }, [_vm._v("40 %")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "50" } }, [_vm._v("50 %")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "60" } }, [_vm._v("60 %")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "70" } }, [_vm._v("70 %")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "80" } }, [_vm._v("80 %")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "90" } }, [_vm._v("90 %")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "100" } }, [_vm._v("100 %")]),
          ]),
        ]),
      ]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/issues/new.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/views/issues/new.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _new_vue_vue_type_template_id_0961e952_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./new.vue?vue&type=template&id=0961e952&scoped=true& */ "./resources/js/components/views/issues/new.vue?vue&type=template&id=0961e952&scoped=true&");
/* harmony import */ var _new_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./new.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/issues/new.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _new_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _new_vue_vue_type_template_id_0961e952_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _new_vue_vue_type_template_id_0961e952_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "0961e952",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/issues/new.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/issues/new.vue?vue&type=script&lang=ts&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/views/issues/new.vue?vue&type=script&lang=ts& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_new_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./new.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/issues/new.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_new_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/issues/new.vue?vue&type=template&id=0961e952&scoped=true&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/views/issues/new.vue?vue&type=template&id=0961e952&scoped=true& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_new_vue_vue_type_template_id_0961e952_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./new.vue?vue&type=template&id=0961e952&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/issues/new.vue?vue&type=template&id=0961e952&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_new_vue_vue_type_template_id_0961e952_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_new_vue_vue_type_template_id_0961e952_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);