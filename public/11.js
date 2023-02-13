(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[11],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['report-data'],
  data: function data() {
    return {
      _reportData: this.reportData || [],
      year: new Date().getFullYear(),
      start_date: null,
      due_date: null,
      end_date: null,
      plano_estrategico: this.reportData.planosEstrategicos[0].identifier || ''
    };
  },
  mounted: function mounted() {},
  methods: {
    formatBudget: function formatBudget(value) {
      var currency = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "MZN";

      if (value === undefined | NaN) {}

      var val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " ".concat(currency);
    },
    getReportDataByYear: function getReportDataByYear() {// return report filter by year

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=template&id=3e5b7452&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=template&id=3e5b7452& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "bg-white border p-3" }, [
      _c("div", { staticClass: "d-flex align-items-baseline" }, [
        _vm._m(0),
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
                {
                  staticClass: "btn btn-sm m-0 btn-success",
                  attrs: { href: "" },
                },
                [
                  _c("i", { staticClass: "icon-file-excel" }),
                  _vm._v("\n            Export Excel\n          "),
                ]
              ),
            ]
          ),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "bg-white mt-2" }, [
        _c("div", { staticClass: "align-items-baseline" }, [
          _c("div", { staticClass: "form-inline align-items-end" }, [
            _c("div", { staticClass: "mr-2" }, [
              _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
                _vm._v("Plano Estratégico"),
              ]),
              _vm._v(" "),
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.plano_estrategico,
                      expression: "plano_estrategico",
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
                      _vm.plano_estrategico = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    },
                  },
                },
                [
                  _vm._l(
                    _vm.reportData.planosEstrategicos,
                    function (plano, key) {
                      return [
                        _c(
                          "option",
                          { key: key, domProps: { value: plano.identifier } },
                          [_vm._v(_vm._s(plano.name))]
                        ),
                      ]
                    }
                  ),
                ],
                2
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "mr-2" }, [
              _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
                _vm._v("Ano"),
              ]),
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
            _c("div", { staticClass: "mr-2 mb-2" }, [
              _c(
                "button",
                {
                  staticClass:
                    "btn pt-1 pb-1 btn-success rounded-0 fw-600 shadow-sm",
                  on: {
                    click: function ($event) {
                      return _vm.filterReportDate(
                        _vm.year,
                        _vm.start_date,
                        _vm.end_date
                      )
                    },
                  },
                },
                [
                  _vm._v(
                    "\n                          Pesquisar\n                      "
                  ),
                ]
              ),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _c("hr", { staticClass: "mt-0 mb-0" }),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "table-responsive" }, [
        _c(
          "table",
          {
            staticClass:
              "table table-sm table-striped table-bordered table-hover cursor-pointer",
            staticStyle: { "font-size": "92%" },
          },
          [
            _vm._m(1),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.reportData.projects, function (project, key) {
                  return [
                    _c("tr", { key: key }, [
                      _c("td", [_vm._v(_vm._s(++key))]),
                      _vm._v(" "),
                      _c("td", [
                        _c("a", { attrs: { href: project.route } }, [
                          _vm._v(_vm._s(project.name)),
                        ]),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-nowrap" }, [
                        _vm._v(
                          _vm._s(_vm.formatBudget(project.orcamento_inicial))
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-nowrap" }, [
                        _vm._v(
                          _vm._s(
                            _vm.formatBudget(project.issues_valor_prev, "MZN")
                          )
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-nowrap" }, [
                        _vm._v(
                          _vm._s(
                            _vm.formatBudget(
                              project.orcamento_inicial -
                                project.issues_valor_prev,
                              "MZN"
                            )
                          )
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(project.start_date))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(project.due_date))]),
                    ]),
                  ]
                }),
                _vm._v(" "),
                _c(
                  "tr",
                  { staticClass: "bg-success", attrs: { colspan: "2" } },
                  [
                    _c("td", [_vm._v("#")]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right fw-600",
                        attrs: { colspan: "1" },
                      },
                      [_vm._v("Total")]
                    ),
                    _vm._v(" "),
                    _c("td", { staticClass: "fw-600 text-nowrap" }, [
                      _vm._v(
                        _vm._s(
                          _vm.formatBudget(
                            _vm.reportData.total_orcamento_inicial
                          )
                        )
                      ),
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "fw-600 text-nowrap" }, [
                      _vm._v(
                        _vm._s(
                          _vm.formatBudget(_vm.reportData.total_orcamento_gasto)
                        )
                      ),
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "fw-600 text-nowrap" }, [
                      _vm._v(_vm._s("NaN MZN")),
                    ]),
                    _vm._v(" "),
                    _c("td", [_vm._v("-")]),
                    _vm._v(" "),
                    _c("td", [_vm._v("-")]),
                  ]
                ),
              ],
              2
            ),
          ]
        ),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "d-flex align-items-baseline mt-3 mr-1" }, [
        _c("div", { staticClass: "flex-grow-1" }),
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
                {
                  staticClass: "btn btn-sm m-0 btn-success",
                  attrs: { href: "" },
                },
                [
                  _c("i", { staticClass: "icon-file-excel" }),
                  _vm._v("\n            Export Excel\n          "),
                ]
              ),
            ]
          ),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "flex-grow-1" }, [
      _c("h5", { staticClass: "fw-600 text-muted" }, [
        _vm._v("\n          RELATÓRIO DE PREVISÃO ORÇAMENTAL\n        "),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { attrs: { colspan: "2" } }),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center bg-success", attrs: { colspan: "3" } },
          [_vm._v("Orçamento Previsto 2021")]
        ),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { colspan: "2" } }, [
          _vm._v("Prazo de Execução do Projecto"),
        ]),
      ]),
      _vm._v(" "),
      _c("th", [_vm._v("#")]),
      _vm._v(" "),
      _c("th", [_vm._v("Projecto/Programa")]),
      _vm._v(" "),
      _c("th", { staticClass: "text-nowrap" }, [
        _vm._v("1) Orçamento Anual 2021"),
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "text-nowrap" }, [
        _vm._v("2) Despesas Previstas 2021"),
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "text-nowrap" }, [
        _vm._v("Saldo Orçamental (1-2 Prev)"),
      ]),
      _vm._v(" "),
      _c("th", [_vm._v("Inicio")]),
      _vm._v(" "),
      _c("th", [_vm._v("Fim")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/reports/previsao_orcamental.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/views/reports/previsao_orcamental.vue ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _previsao_orcamental_vue_vue_type_template_id_3e5b7452___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./previsao_orcamental.vue?vue&type=template&id=3e5b7452& */ "./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=template&id=3e5b7452&");
/* harmony import */ var _previsao_orcamental_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./previsao_orcamental.vue?vue&type=script&lang=js& */ "./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _previsao_orcamental_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _previsao_orcamental_vue_vue_type_template_id_3e5b7452___WEBPACK_IMPORTED_MODULE_0__["render"],
  _previsao_orcamental_vue_vue_type_template_id_3e5b7452___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/reports/previsao_orcamental.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_previsao_orcamental_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./previsao_orcamental.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_previsao_orcamental_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=template&id=3e5b7452&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=template&id=3e5b7452& ***!
  \******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_previsao_orcamental_vue_vue_type_template_id_3e5b7452___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./previsao_orcamental.vue?vue&type=template&id=3e5b7452& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/previsao_orcamental.vue?vue&type=template&id=3e5b7452&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_previsao_orcamental_vue_vue_type_template_id_3e5b7452___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_previsao_orcamental_vue_vue_type_template_id_3e5b7452___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);