(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[25],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=script&lang=ts&":
/*!******************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=script&lang=ts& ***!
  \******************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_c3__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-c3 */ "./node_modules/vue-c3/dist/vue-c3.umd.js");
/* harmony import */ var vue_c3__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_c3__WEBPACK_IMPORTED_MODULE_2__);



























































































































/* harmony default export */ __webpack_exports__["default"] = ({
    components: {
        VueC3: (vue_c3__WEBPACK_IMPORTED_MODULE_2___default())
    },
    props: ["programs"],
    data() {
        return {
            selected_project: [],
            project: null,
            year: null,
            isLoading: false
        };
    },

    mounted() {},

    methods: {}
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=template&id=3d56faf2&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=template&id=3d56faf2&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "mb-0" }, [
    _c("div", { staticClass: "bg-white border border-bottom-0" }, [
      _c("div", { staticClass: "align-items-baseline p-3" }, [
        _c("div", { staticClass: "form-inline align-items-end" }, [
          _c("div", { staticClass: "w-25" }, [
            _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
              _vm._v(
                "\n                        Linhas Estratégicas " +
                  _vm._s(_vm.programs.length) +
                  "\n                    "
              ),
            ]),
            _vm._v(" "),
            _c(
              "select",
              {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.selected_project,
                    expression: "selected_project",
                  },
                ],
                staticClass: "border p-1 w-100 mb-2",
                attrs: { name: "" },
                on: {
                  change: [
                    function ($event) {
                      var $$selectedVal = Array.prototype.filter
                        .call($event.target.options, function (o) {
                          return o.selected
                        })
                        .map(function (o) {
                          var val = "_value" in o ? o._value : o.value
                          return val
                        })
                      _vm.selected_project = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    },
                    function ($event) {
                      return _vm.onProgramSelect($event)
                    },
                  ],
                },
              },
              [
                _c(
                  "option",
                  { attrs: { selected: "" }, domProps: { value: [] } },
                  [_vm._v("Selecione uma linha estratégica")]
                ),
                _vm._v(" "),
                _vm._l(_vm.projects, function (project, key) {
                  return _c(
                    "option",
                    { key: key, domProps: { value: project } },
                    [
                      _vm._v(
                        "\n                            " +
                          _vm._s(project.name) +
                          "\n                        "
                      ),
                    ]
                  )
                }),
              ],
              2
            ),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "ml-2" }, [
            _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [_vm._v("Ano")]),
            _vm._v(" "),
            _c(
              "select",
              {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.year,
                    expression: "year",
                  },
                ],
                staticClass: "border pl-2 pr-2 p-1 mb-2",
                attrs: { name: "" },
                on: {
                  change: function ($event) {
                    var $$selectedVal = Array.prototype.filter
                      .call($event.target.options, function (o) {
                        return o.selected
                      })
                      .map(function (o) {
                        var val = "_value" in o ? o._value : o.value
                        return val
                      })
                    _vm.year = $event.target.multiple
                      ? $$selectedVal
                      : $$selectedVal[0]
                  },
                },
              },
              [
                _c("option", { domProps: { value: null } }, [_vm._v("Ano")]),
                _vm._v(" "),
                _c("option", { domProps: { value: 2020 } }, [_vm._v("2020")]),
              ]
            ),
          ]),
          _vm._v(" "),
          _vm._m(0),
          _vm._v(" "),
          _vm._m(1),
          _vm._v(" "),
          _vm._m(2),
        ]),
      ]),
      _vm._v(" "),
      _c("hr", { staticClass: "mt-0 mb-0 mr-3 ml-3" }),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "bg-white border border-top-0 p-3" }, [
      _vm._m(3),
      _vm._v(" "),
      _c("div", { staticClass: "table-responsive" }, [
        _c(
          "table",
          {
            staticClass:
              "finances table table-sm table-stripeds border table-hover",
          },
          [
            _vm._m(4),
            _vm._v(" "),
            _c(
              "tbody",
              [
                [
                  _c("tr", [
                    _c(
                      "td",
                      { staticClass: "text-center", attrs: { colspan: "9" } },
                      [
                        _vm._v(
                          "\n                                " +
                            _vm._s(_vm.__("lang.label_no_data")) +
                            "\n                            "
                        ),
                      ]
                    ),
                  ]),
                ],
              ],
              2
            ),
          ]
        ),
      ]),
    ]),
    _vm._v(" "),
    _vm.isLoading
      ? _c("div", { attrs: { id: "loading-indicator" } }, [
          _c("i", { staticClass: "icon-spinner spinner" }),
          _vm._v(" "),
          _c("span", [_vm._v("Carregando...")]),
        ])
      : _vm._e(),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ml-2" }, [
      _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
        _vm._v("Data de Inicio"),
      ]),
      _vm._v(" "),
      _c("input", {
        staticClass: "border pl-2 p-1 mb-2",
        staticStyle: { "font-size": "90%" },
        attrs: { type: "date" },
      }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ml-2" }, [
      _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
        _vm._v("Data de Fim"),
      ]),
      _vm._v(" "),
      _c("input", {
        staticClass: "border pl-2 p-1 mr-2 mb-2",
        staticStyle: { "font-size": "90%" },
        attrs: { type: "date" },
      }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "mr-2 mb-2" }, [
      _c(
        "button",
        { staticClass: "btn pt-1 pb-1 btn-success rounded-0 fw-600 shadow-sm" },
        [_vm._v("\n                        Pesquisar\n                    ")]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "d-flex align-items-baseline" }, [
      _c("div", { staticClass: "flex-grow-1" }, [
        _c("h5", { staticClass: "fw-600" }, [
          _vm._v("Relatório Orçamento PDE"),
        ]),
      ]),
      _vm._v(" "),
      _c("div", {}, [
        _c(
          "div",
          {
            staticClass: "btn-group btn-group-sm",
            attrs: { role: "group", "aria-label": "..." },
          },
          [
            _c(
              "a",
              { staticClass: "btn btn-sm m-0 btn-dark", attrs: { href: "#" } },
              [
                _c("i", { staticClass: "icon-file-excel" }),
                _vm._v("\n                        Excel\n                    "),
              ]
            ),
            _vm._v(" "),
            _c("button", { staticClass: "btn btn-sm m-0 btn-light border" }, [
              _vm._v(
                "\n                        Imprimir\n                    "
              ),
            ]),
          ]
        ),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "table-active" }, [
      _c("th", [_vm._v("Tipo")]),
      _vm._v(" "),
      _c("th", [_vm._v("Designação")]),
      _vm._v(" "),
      _c("th", [_vm._v("Orçamento")]),
      _vm._v(" "),
      _c("th", [_vm._v("Valor gasto (total)")]),
      _vm._v(" "),
      _c("th", [_vm._v("Percentual")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/reports/data_orcamento_projects.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/views/reports/data_orcamento_projects.vue ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _data_orcamento_projects_vue_vue_type_template_id_3d56faf2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./data_orcamento_projects.vue?vue&type=template&id=3d56faf2&scoped=true& */ "./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=template&id=3d56faf2&scoped=true&");
/* harmony import */ var _data_orcamento_projects_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./data_orcamento_projects.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _data_orcamento_projects_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _data_orcamento_projects_vue_vue_type_template_id_3d56faf2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _data_orcamento_projects_vue_vue_type_template_id_3d56faf2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "3d56faf2",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/reports/data_orcamento_projects.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=script&lang=ts&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=script&lang=ts& ***!
  \****************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_data_orcamento_projects_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./data_orcamento_projects.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_data_orcamento_projects_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=template&id=3d56faf2&scoped=true&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=template&id=3d56faf2&scoped=true& ***!
  \**********************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_data_orcamento_projects_vue_vue_type_template_id_3d56faf2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./data_orcamento_projects.vue?vue&type=template&id=3d56faf2&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/data_orcamento_projects.vue?vue&type=template&id=3d56faf2&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_data_orcamento_projects_vue_vue_type_template_id_3d56faf2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_data_orcamento_projects_vue_vue_type_template_id_3d56faf2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);