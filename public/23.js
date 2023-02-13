(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[23],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=script&lang=ts&":
/*!****************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=script&lang=ts& ***!
  \****************************************************************************************************************************************************/
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
        VueC3: (vue_c3__WEBPACK_IMPORTED_MODULE_2___default()),
    },
    props:[],

    mounted() {
        this.dataType = this.get_data_type ? "Genero" : "Faixa Etaria";
    },

    data (){
        return {
            dataType: null,
            isLoading: false,
        }
    },
    methods: {

    },
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=template&id=76eecb27&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=template&id=76eecb27&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "bg-white border p-3" }, [
    _c("div", { staticClass: "d-flex h-100" }, [
      _c("div", { staticClass: "flex-grow-1" }, [
        _c("div", { staticClass: "d-flex align-items-baseline" }, [
          _c("div", { staticClass: "flex-grow-1" }, [
            _c("h5", { staticClass: "fw-500 mb-0" }, [
              _vm._v("\n                        Beneficiários - "),
              _c("span", { staticClass: "text-black-50" }, [
                _vm._v(_vm._s(_vm.dataType)),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _vm._m(0),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "grath-data" }, [
          _vm._m(1),
          _vm._v(" "),
          _vm._m(2),
          _vm._v(" "),
          _c("div", { staticClass: "table-responsive" }, [
            _c(
              "table",
              {
                staticClass:
                  "finances border table table-sm table-striped table-hover",
              },
              [
                _vm._m(3),
                _vm._v(" "),
                _c("tbody", [
                  _c("tr", [
                    _c(
                      "td",
                      { staticClass: "text-center", attrs: { colspan: "4" } },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(_vm.__("lang.label_no_data")) +
                            "\n                                "
                        ),
                      ]
                    ),
                  ]),
                ]),
              ]
            ),
          ]),
        ]),
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "border-left pl-2 ml-3",
          staticStyle: { width: "250px" },
        },
        [
          _vm._m(4),
          _vm._v(" "),
          _c("div", { staticClass: "_filters" }, [
            _c("div", { staticClass: "border-bottom w-100" }, [
              _c(
                "div",
                {
                  staticClass:
                    "w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer",
                  attrs: {
                    id: "dropdownNotidications",
                    "data-toggle": "dropdown",
                    "aria-haspopup": "true",
                    "aria-expanded": "false",
                  },
                },
                [
                  _c("div", { staticClass: "flex-grow-1 text-muted" }, [
                    _vm._v("Periodo:"),
                  ]),
                  _vm._v(" "),
                  _c("div", {}, [
                    _vm._v(
                      "\n                            " +
                        _vm._s("Mensal") +
                        "\n                            "
                    ),
                    _c("i", { staticClass: "icon-arrow-down12" }),
                  ]),
                ]
              ),
              _vm._v(" "),
              _vm._m(5),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "border-bottom w-100" }, [
              _c(
                "div",
                {
                  staticClass:
                    "w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer",
                  attrs: {
                    id: "dropdownNotidications",
                    "data-toggle": "dropdown",
                    "aria-haspopup": "true",
                    "aria-expanded": "false",
                  },
                },
                [
                  _c("div", { staticClass: "flex-grow-1 text-muted" }, [
                    _vm._v("Ano:"),
                  ]),
                  _vm._v(" "),
                  _c("div", {}, [
                    _vm._v(
                      "\n                            " +
                        _vm._s(2020) +
                        "\n                            "
                    ),
                    _c("i", { staticClass: "icon-arrow-down12" }),
                  ]),
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass: "dropdown-menu border my-shadow",
                  attrs: { "aria-labelledby": "dropdownNotidications" },
                },
                [
                  _c(
                    "ul",
                    {
                      staticClass: "list-unstyled pb-0 mb-0",
                      staticStyle: {
                        "max-height": "300px",
                        "overflow-y": "auto",
                      },
                    },
                    [
                      _c(
                        "li",
                        { staticClass: "dropdown-item cursor-pointer" },
                        [_vm._v(_vm._s(2020))]
                      ),
                    ]
                  ),
                ]
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "border-bottom w-100" }, [
              _c(
                "div",
                {
                  staticClass:
                    "w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer",
                  attrs: {
                    id: "dropdownNotidications",
                    "data-toggle": "dropdown",
                    "aria-haspopup": "true",
                    "aria-expanded": "false",
                  },
                },
                [
                  _c("div", { staticClass: "flex-grow-1 text-muted" }, [
                    _vm._v("Data Inicial:"),
                  ]),
                  _vm._v(" "),
                  _c("div", {}, [
                    _vm._v(
                      "\n                            " +
                        _vm._s("mm/dd/yyyy") +
                        "\n                            "
                    ),
                    _c("i", { staticClass: "icon-arrow-down12" }),
                  ]),
                ]
              ),
              _vm._v(" "),
              _vm._m(6),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "border-bottom w-100" }, [
              _c(
                "div",
                {
                  staticClass:
                    "w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer",
                  attrs: {
                    id: "dropdownNotidications",
                    "data-toggle": "dropdown",
                    "aria-haspopup": "true",
                    "aria-expanded": "false",
                  },
                },
                [
                  _c("div", { staticClass: "flex-grow-1 text-muted" }, [
                    _vm._v("Data Final:"),
                  ]),
                  _vm._v(" "),
                  _c("div", {}, [
                    _vm._v(
                      "\n                            " +
                        _vm._s("mm/dd/yyyy") +
                        "\n                            "
                    ),
                    _c("i", { staticClass: "icon-arrow-down12" }),
                  ]),
                ]
              ),
              _vm._v(" "),
              _vm._m(7),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "m-3" }),
          _vm._v(" "),
          _vm._m(8),
          _vm._v(" "),
          _c("div", { staticClass: "_advanced_filters" }, [
            _c(
              "label",
              {
                staticClass: "form-check-inline pl-1 mb-0 pb-0",
                attrs: { for: "show_genero" },
              },
              [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.dataType,
                      expression: "dataType",
                    },
                  ],
                  attrs: {
                    type: "radio",
                    name: "get_data_type",
                    id: "show_genero",
                    value: "genero",
                    checked: "checked",
                  },
                  domProps: { checked: _vm._q(_vm.dataType, "genero") },
                  on: {
                    change: function ($event) {
                      _vm.dataType = "genero"
                    },
                  },
                }),
                _vm._v(" "),
                _c("span", { staticClass: "pl-1" }, [
                  _vm._v("Mostrar dados por genero"),
                ]),
              ]
            ),
            _vm._v(" "),
            _c(
              "label",
              {
                staticClass: "form-check-inline pl-1 mb-0 pb-0",
                attrs: { for: "show_faixa_etaria" },
              },
              [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.dataType,
                      expression: "dataType",
                    },
                  ],
                  attrs: {
                    type: "radio",
                    name: "get_data_type",
                    id: "show_faixa_etaria",
                    value: "faixa-etaria",
                  },
                  domProps: { checked: _vm._q(_vm.dataType, "faixa-etaria") },
                  on: {
                    change: function ($event) {
                      _vm.dataType = "faixa-etaria"
                    },
                  },
                }),
                _vm._v(" "),
                _c("span", { staticClass: "pl-1" }, [
                  _vm._v("Mostrar dados por faixa etaria"),
                ]),
              ]
            ),
          ]),
        ]
      ),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", {}, [
      _c(
        "div",
        {
          staticClass: "btn-group btn-group-sm",
          attrs: { role: "group", "aria-label": "..." },
        },
        [
          _c(
            "a",
            {
              staticClass: "btn btn-sm m-0 btn-secondary",
              attrs: { href: "#" },
            },
            [
              _c("i", { staticClass: "icon-file-excel" }),
              _vm._v(
                "\n                            Excel\n                        "
              ),
            ]
          ),
          _vm._v(" "),
          _c("button", { staticClass: "btn btn-sm m-0 btn-light border" }, [
            _vm._v(
              "\n                            Imprimir\n                        "
            ),
          ]),
        ]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "graf-title" }, [
      _c(
        "p",
        {
          staticStyle: {
            cursor: "default",
            color: "rgb(117, 117, 117)",
            "user-select": "none",
            "-webkit-font-smoothing": "antialiased",
            "font-size": "12px",
          },
        },
        [
          _vm._v(
            "\n                        Gráfico de Barras - Relatório de Beneficiários\n                    "
          ),
        ]
      ),
      _vm._v(" "),
      _c(
        "p",
        {
          staticClass: "ng-scope ng-binding",
          staticStyle: {
            "margin-top": "-18px",
            color: "rgb(189, 189, 189)",
            cursor: "default",
            "user-select": "none",
            "-webkit-font-smoothing": "antialiased",
            "font-size": "14px",
          },
          attrs: { "ng-controller": "orc_pdeController" },
        },
        [
          _vm._v(
            "\n                        Plano Estratégico ?\n                    "
          ),
        ]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "grapth", staticStyle: { "min-height": "50vh" } },
      [_c("div", { attrs: { id: "relFinProjectos" } })]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "table-active" }, [
      _c("th", { staticClass: "fw-600" }, [_vm._v("PDE/Projecto")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Homens")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Mulheres")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Total")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "h5",
      { staticClass: "border-bottom btn w-100 text-left fw-600 pl-1" },
      [_c("i", { staticClass: "icon-arrow-up5" }), _vm._v("FILTROS")]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "dropdown-menu border my-shadow",
        attrs: { "aria-labelledby": "dropdownNotidications" },
      },
      [
        _c(
          "ul",
          {
            staticClass: "list-unstyled pb-0 mb-0",
            staticStyle: { "max-height": "300px", "overflow-y": "auto" },
          },
          [
            _c("li", { staticClass: "dropdown-item cursor-pointer" }, [
              _vm._v("Mensal"),
            ]),
            _vm._v(" "),
            _c("li", { staticClass: "dropdown-item cursor-pointer" }, [
              _vm._v("Semestral"),
            ]),
            _vm._v(" "),
            _c("li", { staticClass: "dropdown-item cursor-pointer" }, [
              _vm._v("Anual"),
            ]),
          ]
        ),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "dropdown-menu border my-shadow p-2",
        attrs: { "aria-labelledby": "dropdownNotidications" },
      },
      [_c("input", { staticClass: "form-control", attrs: { type: "date" } })]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "dropdown-menu border my-shadow p-2",
        attrs: { "aria-labelledby": "dropdownNotidications" },
      },
      [_c("input", { staticClass: "form-control", attrs: { type: "date" } })]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "h5",
      { staticClass: "border-bottom btn w-100 text-left fw-600 pl-1" },
      [_c("i", { staticClass: "icon-arrow-up5" }), _vm._v("FILTROS AVANCADOS")]
    )
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/reports/beneficiarios_project.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/views/reports/beneficiarios_project.vue ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _beneficiarios_project_vue_vue_type_template_id_76eecb27_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./beneficiarios_project.vue?vue&type=template&id=76eecb27&scoped=true& */ "./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=template&id=76eecb27&scoped=true&");
/* harmony import */ var _beneficiarios_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./beneficiarios_project.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _beneficiarios_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _beneficiarios_project_vue_vue_type_template_id_76eecb27_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _beneficiarios_project_vue_vue_type_template_id_76eecb27_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "76eecb27",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/reports/beneficiarios_project.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=script&lang=ts&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=script&lang=ts& ***!
  \**************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_beneficiarios_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./beneficiarios_project.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_beneficiarios_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=template&id=76eecb27&scoped=true&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=template&id=76eecb27&scoped=true& ***!
  \********************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_beneficiarios_project_vue_vue_type_template_id_76eecb27_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./beneficiarios_project.vue?vue&type=template&id=76eecb27&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/beneficiarios_project.vue?vue&type=template&id=76eecb27&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_beneficiarios_project_vue_vue_type_template_id_76eecb27_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_beneficiarios_project_vue_vue_type_template_id_76eecb27_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);