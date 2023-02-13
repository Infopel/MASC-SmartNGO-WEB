(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[29],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/orcamento_pde.vue?vue&type=script&lang=ts&":
/*!********************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/orcamento_pde.vue?vue&type=script&lang=ts& ***!
  \********************************************************************************************************************************************/
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
  props: ["route_api", "projects"],
  data() {
    return {
      isActiveLinhaEstrategico: true,
      isActiveProjectos: false,
      requestDataType: "linha-estrategica",
      selected_project: [],
      project: null,
      year: null,
      years: [],
      dataTable: [],
      dataGraph: [],
      handler: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
      isLoading: false,
      relFinProjectos: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
      colorPattern: ["#3366cc", "#d93025"],
    };
  },

  mounted() {
    this.ini_graph_load();
    this.selected_project = this.projects[0];
    this.onProjectSelect(event);
  },

  methods: {
    formatBudget(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    /**
     * Toggle -
     */
    selectData(dataSource) {
      if (dataSource == "isActiveLinhaEstrategico") {
        (this.colorPattern = ["#f3e000", "#3366cc", "#d93025"]),
          (this.isActiveProjectos = false);
        this.requestDataType = "linha-estrategica";
        this.onProjectSelect();
        return (this.isActiveLinhaEstrategico = true);
      } else {
        this.isActiveProjectos = true;
        this.requestDataType = "projects";
        this.colorPattern = ["#3366cc", "#d93025"];
        this.onProjectSelect();
        return (this.isActiveLinhaEstrategico = false);
      }
    },

    // On Porject is Selected
    async onProjectSelect(event) {
      if (this.selected_project.length !== 0) {
        this.isLoading = true;
        await axios__WEBPACK_IMPORTED_MODULE_1___default.a
          .get(
            "/reports/api/orcamento/pde/" +
              this.selected_project.identifier +
              "?type=" +
              this.requestDataType
          )
          .then((response) => {
            this.dataTable = response.data.dataTable;
            this.dataGraph = response.data.dataGraph;
            this.years = response.data.years;
            // this.project = this.selected_project;
            this.ini_graph_load();
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.isLoading = false;
          });
      }
    },

    async onProjectRepYear(event) {
      if (this.year !== null) {
        this.isLoading = true;
        await axios__WEBPACK_IMPORTED_MODULE_1___default.a
          .get(
            `/reports/api/orcamento/pde/${this.selected_project.identifier}?type=${this.requestDataType}&getByYear=1&year=${this.year}`
          )
          .then((response) => {
            this.dataTable = response.data.dataTable;
            this.dataGraph = response.data.dataGraph;
            this.years = response.data.years;
            // this.project = this.selected_project;
            this.ini_graph_load();
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.isLoading = false;
          });
      }
    },

    // Load data and ini graph
    ini_graph_load() {
      const options = {
        data: {
          json: this.dataGraph.data,
          type: "bar",
          keys: {
            x: this.dataGraph.dataGraph_x,
            value: this.dataGraph.dataGraph_x_value,
          },
        },
        color: {
          pattern: this.colorPattern,
        },
        axis: {
          x: {
            type: "category",
            x: ["key"],
          },
        },
        bar: {
          width: {
            ratio: 0.35, // this makes bar width 50% of length between ticks
          },
        },
        tooltip: {
          format: {
            value: function (value, ratio, id, index) {
              return value.toLocaleString("en") + " MZN";
            },
          },
        },
        transition: { duration: 1000 },
        legend: {
          show: false,
        },
      };
      this.relFinProjectos.$emit("init", options);
    },
  },
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/orcamento_pde.vue?vue&type=template&id=73a8d514&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/orcamento_pde.vue?vue&type=template&id=73a8d514&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "d-flex align-items-baseline p-3" }, [
        _c("div", { staticClass: "flex-grow-1 form-inline" }, [
          _c("div", {}, [
            _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
              _vm._v(
                "\n            Planos Estratégicos (" +
                  _vm._s(_vm.projects.length) +
                  ")\n          "
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
                staticClass: "border p-1",
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
                      return _vm.onProjectSelect($event)
                    },
                  ],
                },
              },
              [
                _c(
                  "option",
                  { attrs: { selected: "" }, domProps: { value: [] } },
                  [
                    _vm._v(
                      "\n              Selecione um plano estratégico\n            "
                    ),
                  ]
                ),
                _vm._v(" "),
                _vm._l(_vm.projects, function (project, key) {
                  return _c(
                    "option",
                    { key: key, domProps: { value: project } },
                    [
                      _vm._v(
                        "\n              " +
                          _vm._s(project.name) +
                          "\n            "
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
            _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
              _vm._v("Ano (Financeiro)"),
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
                staticClass: "border p-1",
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
                      _vm.year = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    },
                    function ($event) {
                      return _vm.onProjectRepYear($event)
                    },
                  ],
                },
              },
              [
                _c("option", { domProps: { value: null } }, [_vm._v("Anos")]),
                _vm._v(" "),
                _vm._l(_vm.years, function (_year, key) {
                  return _c(
                    "option",
                    { key: key, domProps: { value: _year } },
                    [
                      _vm._v(
                        "\n              " + _vm._s(_year) + "\n            "
                      ),
                    ]
                  )
                }),
              ],
              2
            ),
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
                {
                  staticClass: "btn btn-sm m-0",
                  class: {
                    "btn-success": _vm.isActiveLinhaEstrategico,
                    "btn-light": !_vm.isActiveLinhaEstrategico,
                  },
                  attrs: { href: "#" },
                  on: {
                    click: function ($event) {
                      return _vm.selectData("isActiveLinhaEstrategico")
                    },
                  },
                },
                [_vm._v("Por Linha Estratégica")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-sm m-0 border",
                  class: {
                    "btn-success": _vm.isActiveProjectos,
                    "btn-light": !_vm.isActiveProjectos,
                  },
                  on: {
                    click: function ($event) {
                      return _vm.selectData("isActiveProjectos")
                    },
                  },
                },
                [_vm._v("\n            Por Projectos\n          ")]
              ),
            ]
          ),
        ]),
      ]),
      _vm._v(" "),
      _c("hr", { staticClass: "mt-0 mb-0 mr-3 ml-3" }),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "bg-white border border-top-0 p-3" }, [
      _c("div", { staticClass: "d-flex align-items-baseline" }, [
        _c("div", { staticClass: "flex-grow-1" }, [
          _c("h5", { staticClass: "fw-600" }, [
            _vm._v("\n          Relatório Financeiro\n          "),
            _vm.selected_project !== []
              ? _c("span", { staticClass: "text-black-50" }, [
                  _vm._v("\n            -\n            "),
                  _c("a", { attrs: { href: "#" } }, [
                    _vm._v(_vm._s(_vm.selected_project.name || null)),
                  ]),
                ])
              : _vm._e(),
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
              _vm.selected_project != null
                ? _c(
                    "a",
                    {
                      staticClass: "btn btn-sm m-0 btn-dark",
                      attrs: {
                        href:
                          "/reports/api/export/report/" +
                          _vm.selected_project.identifier +
                          "?type=" +
                          _vm.requestDataType,
                      },
                    },
                    [
                      _c("i", { staticClass: "icon-file-excel" }),
                      _vm._v("\n            Excel\n          "),
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _c("button", { staticClass: "btn btn-sm m-0 btn-light border" }, [
                _vm._v("Imprimir"),
              ]),
            ]
          ),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "grath-data" }, [
        _c("div", { staticClass: "graf-title" }, [
          _c(
            "p",
            {
              staticStyle: {
                cursor: "default",
                color: "rgb(117, 117, 117)",
                "user-select": "none",
                "-webkit-font-smoothing": "antialiased",
                "font-size": "16px",
                "margin-top": "-8px",
              },
            },
            [
              _vm._v(
                "\n          Gráfico de Barras - Relatório de Orçamento\n        "
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
            },
            [
              _vm._v(
                "\n          " +
                  _vm._s(_vm.selected_project.name || null) +
                  "\n        "
              ),
            ]
          ),
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "grapth", staticStyle: { "min-height": "50vh" } },
          [
            _vm.isActiveProjectos
              ? [
                  _c("vue-c3", { attrs: { handler: _vm.relFinProjectos } }),
                  _vm._v(" "),
                  _vm._m(0),
                ]
              : _vm._e(),
            _vm._v(" "),
            _vm.isActiveLinhaEstrategico
              ? [
                  _c("vue-c3", { attrs: { handler: _vm.relFinProjectos } }),
                  _vm._v(" "),
                  _vm._m(1),
                ]
              : _vm._e(),
          ],
          2
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "table-responsive" },
          [
            _vm.isActiveProjectos
              ? [
                  _c(
                    "table",
                    {
                      staticClass:
                        "finances table table-sm table-stripeds border table-hover",
                    },
                    [
                      _vm._m(2),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        [
                          _vm._l(_vm.dataTable, function (project) {
                            return [
                              _c("tr", { key: project.id }, [
                                _c(
                                  "td",
                                  {
                                    staticClass:
                                      "fw-600 text-nowrap bg-light border-top",
                                    attrs: { colspan: "3" },
                                  },
                                  [
                                    _vm._v(
                                      "\n                    " +
                                        _vm._s(project.name) +
                                        "\n                  "
                                    ),
                                  ]
                                ),
                              ]),
                              _vm._v(" "),
                              project.childs.length > 0
                                ? _vm._l(project.childs, function (child) {
                                    return _c(
                                      "tr",
                                      {
                                        key: child.id,
                                        staticClass: "td-int-1 child",
                                      },
                                      [
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "td-int-1 child p-0 pr-2 pl-4 child",
                                          },
                                          [
                                            _c(
                                              "a",
                                              {
                                                staticClass: "link-option",
                                                attrs: { href: child.route },
                                              },
                                              [_vm._v(_vm._s(child.name))]
                                            ),
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "p-1 pr-2 pl-2 text-nowrap text-black",
                                          },
                                          [
                                            _vm._v(
                                              "\n                      " +
                                                _vm._s(
                                                  _vm.formatBudget(
                                                    child.orcamento_inicial
                                                  )
                                                ) +
                                                " MZN\n                    "
                                            ),
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "p-1 pr-2 pl-2 text-nowrap text-black",
                                          },
                                          [
                                            _vm._v(
                                              "\n                      " +
                                                _vm._s(
                                                  _vm.formatBudget(
                                                    child.orcamento_gasto
                                                  )
                                                ) +
                                                " MZN\n                    "
                                            ),
                                          ]
                                        ),
                                      ]
                                    )
                                  })
                                : _vm._e(),
                            ]
                          }),
                          _vm._v(" "),
                          _vm.dataTable.length == 0
                            ? [
                                _c("tr", [
                                  _c(
                                    "td",
                                    {
                                      staticClass: "text-center",
                                      attrs: { colspan: "3" },
                                    },
                                    [
                                      _vm._v(
                                        "\n                    " +
                                          _vm._s(_vm.__("lang.label_no_data")) +
                                          "\n                  "
                                      ),
                                    ]
                                  ),
                                ]),
                              ]
                            : _vm._e(),
                        ],
                        2
                      ),
                    ]
                  ),
                ]
              : _vm._e(),
            _vm._v(" "),
            _vm.isActiveLinhaEstrategico
              ? [
                  _c(
                    "table",
                    {
                      staticClass:
                        "finances table table-sm table-stripeds border table-hover",
                    },
                    [
                      _vm._m(3),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        [
                          _vm._l(_vm.dataTable, function (project) {
                            return [
                              _c("tr", { key: project.id }, [
                                _c(
                                  "td",
                                  {
                                    staticClass:
                                      "fw-600 text-nowrap bg-light border-top",
                                  },
                                  [
                                    _vm._v(
                                      "\n                    " +
                                        _vm._s(project.name) +
                                        "\n                  "
                                    ),
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass:
                                      "fw-600 text-nowrap bg-light border-top",
                                  },
                                  [
                                    _vm._v(
                                      "\n                    " +
                                        _vm._s(
                                          _vm.formatBudget(
                                            project.orcamento_inicial_sub_project
                                          )
                                        ) +
                                        "\n                    MZN\n                  "
                                    ),
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass:
                                      "fw-600 text-nowrap bg-light border-top",
                                  },
                                  [
                                    _vm._v(
                                      "\n                    " +
                                        _vm._s(
                                          _vm.formatBudget(
                                            project.orcamento_gasto_sub_project
                                          )
                                        ) +
                                        "\n                    MZN\n                  "
                                    ),
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass:
                                      "fw-600 text-nowrap bg-light border-top",
                                  },
                                  [
                                    _vm._v(
                                      "\n                    " +
                                        _vm._s(
                                          _vm.formatBudget(
                                            project.orcamento_inicial_sub_project -
                                              project.orcamento_gasto_sub_project
                                          )
                                        ) +
                                        "\n                    MZN\n                  "
                                    ),
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass:
                                      "fw-600 text-nowrap bg-light border-top",
                                  },
                                  [
                                    _vm._v(
                                      "\n                    " +
                                        _vm._s(
                                          _vm.formatBudget(
                                            (project.orcamento_gasto_sub_project /
                                              project.orcamento_inicial_sub_project) *
                                              100
                                          )
                                        ) +
                                        "\n                    %\n                  "
                                    ),
                                  ]
                                ),
                              ]),
                            ]
                          }),
                          _vm._v(" "),
                          _vm.dataTable.length == 0
                            ? [
                                _c("tr", [
                                  _c(
                                    "td",
                                    {
                                      staticClass: "text-center",
                                      attrs: { colspan: "5" },
                                    },
                                    [
                                      _vm._v(
                                        "\n                    " +
                                          _vm._s(_vm.__("lang.label_no_data")) +
                                          "\n                  "
                                      ),
                                    ]
                                  ),
                                ]),
                              ]
                            : _vm._e(),
                        ],
                        2
                      ),
                    ]
                  ),
                ]
              : _vm._e(),
          ],
          2
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
    return _c("div", { staticClass: "mt-3 mb-2" }, [
      _c("div", { staticClass: "d-flex" }, [
        _c(
          "div",
          {
            staticClass: "flex-grow-1 text-center p-2",
            attrs: { title: "Orçamento do Projecto" },
          },
          [
            _c("div", {
              staticClass: "m-2 w-25 mr-auto ml-auto",
              staticStyle: { "border-top": "3px solid #3366cc" },
            }),
            _vm._v(" "),
            _c("div", { staticClass: "c3-legend-item text-black-50 fw-500" }, [
              _vm._v(
                "\n                  Orçamento do Projecto\n                "
              ),
            ]),
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "flex-grow-1 text-center p-2",
            attrs: { title: "Valor Gasto" },
          },
          [
            _c("div", {
              staticClass: "m-2 w-25 mr-auto ml-auto",
              staticStyle: { "border-top": "3px solid #d93025" },
            }),
            _vm._v(" "),
            _c("div", { staticClass: "c3-legend-item text-black-50 fw-500" }, [
              _vm._v("\n                  Valor Gasto\n                "),
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
    return _c("div", { staticClass: "mt-3 mb-2" }, [
      _c("div", { staticClass: "d-flex" }, [
        _c(
          "div",
          {
            staticClass: "flex-grow-1 text-center p-2",
            attrs: { title: "Orçamento do Projecto" },
          },
          [
            _c("div", {
              staticClass: "m-2 w-25 mr-auto ml-auto",
              staticStyle: { "border-top": "3px solid #f3e000" },
            }),
            _vm._v(" "),
            _c("div", { staticClass: "c3-legend-item text-black-50 fw-500" }, [
              _vm._v("\n                  Orçamento Linha.E\n                "),
            ]),
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "flex-grow-1 text-center p-2",
            attrs: { title: "Orçamento do Projecto" },
          },
          [
            _c("div", {
              staticClass: "m-2 w-25 mr-auto ml-auto",
              staticStyle: { "border-top": "3px solid #3366cc" },
            }),
            _vm._v(" "),
            _c("div", { staticClass: "c3-legend-item text-black-50 fw-500" }, [
              _vm._v(
                "\n                  Orçamento de Projectos\n                "
              ),
            ]),
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "flex-grow-1 text-center p-2",
            attrs: { title: "Valor Gasto" },
          },
          [
            _c("div", {
              staticClass: "m-2 w-25 mr-auto ml-auto",
              staticStyle: { "border-top": "3px solid #d93025" },
            }),
            _vm._v(" "),
            _c("div", { staticClass: "c3-legend-item text-black-50 fw-500" }, [
              _vm._v(
                "\n                  Valor Gasto de Projectos\n                "
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
      _c("th", [_vm._v("Linha Estratégica/Projecto")]),
      _vm._v(" "),
      _c("th", [_vm._v("(+) Orçamento")]),
      _vm._v(" "),
      _c("th", [_vm._v("(-) Valor Gasto")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "table-active" }, [
      _c("th", [_vm._v("Linha Estratégica")]),
      _vm._v(" "),
      _c("th", [_vm._v("Orçamento")]),
      _vm._v(" "),
      _c("th", [_vm._v("Despesas Realizadas")]),
      _vm._v(" "),
      _c("th", [_vm._v("Saldo")]),
      _vm._v(" "),
      _c("th", [_vm._v("%")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/reports/orcamento_pde.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/views/reports/orcamento_pde.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _orcamento_pde_vue_vue_type_template_id_73a8d514_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./orcamento_pde.vue?vue&type=template&id=73a8d514&scoped=true& */ "./resources/js/components/views/reports/orcamento_pde.vue?vue&type=template&id=73a8d514&scoped=true&");
/* harmony import */ var _orcamento_pde_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./orcamento_pde.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/reports/orcamento_pde.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _orcamento_pde_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _orcamento_pde_vue_vue_type_template_id_73a8d514_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _orcamento_pde_vue_vue_type_template_id_73a8d514_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "73a8d514",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/reports/orcamento_pde.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/reports/orcamento_pde.vue?vue&type=script&lang=ts&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/views/reports/orcamento_pde.vue?vue&type=script&lang=ts& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_pde_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./orcamento_pde.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/orcamento_pde.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_pde_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/reports/orcamento_pde.vue?vue&type=template&id=73a8d514&scoped=true&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/orcamento_pde.vue?vue&type=template&id=73a8d514&scoped=true& ***!
  \************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_pde_vue_vue_type_template_id_73a8d514_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./orcamento_pde.vue?vue&type=template&id=73a8d514&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/orcamento_pde.vue?vue&type=template&id=73a8d514&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_pde_vue_vue_type_template_id_73a8d514_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_pde_vue_vue_type_template_id_73a8d514_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);