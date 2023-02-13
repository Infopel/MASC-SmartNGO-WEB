(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[30],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/orcamento_project.vue?vue&type=script&lang=ts&":
/*!************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/orcamento_project.vue?vue&type=script&lang=ts& ***!
  \************************************************************************************************************************************************/
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
    props: ["route_api", "projects"],

    mounted() {
        this.ini_graph_load([]);
        this.project = this.projects[0];
        this.onProjectSelect();
    },

    data() {
        return {
            handler: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            relFinProject: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            project: [],
            timeType: [
                {
                    name: "Anual",
                    key: 1
                },
                {
                    name: "Semestral",
                    key: 2
                },
                {
                    name: "Mensal",
                    key: "01"
                }
            ],
            year: new Date().getFullYear(),
            start_date: null,
            end_date: null,
            isLoading: false,
            dataTable: null
        };
    },

    methods: {
        formatBudget(value) {
            let val = (value / 1).toFixed(2).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        async onProjectSelect() {
            if (this.project.length !== 0) {
                this.isLoading = true;
                await axios__WEBPACK_IMPORTED_MODULE_1___default.a
                    .get(
                        "/reports/api/budget/project/" + this.project.identifier
                    )
                    .then(response => {
                        this.dataTable = response.data.dataTable;
                        this.ini_graph_load(response.data.dataGraph);
                    })
                    .catch(error => {
                        console.error({ Request: error });
                        this.ini_graph_load([]);
                        this.dataTable = [];
                        alert(
                            `Sinceras Desculpas! \nOcorreu um erro enquanto carregavamos os dados...\n${error}`
                        );
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },
        async ini_graph_load(data) {
            const options = {
                data: {
                    json: data,
                    type: "bar",
                    keys: {
                        x: "project",
                        value: ["Orçamento Inicial", "Valor Gasto"]
                    }
                },
                color: {
                    pattern: ["#3366cc", "#d93025"]
                },
                axis: {
                    x: {
                        type: "category",
                        x: ["key"]
                    }
                },
                bar: {
                    width: {
                        ratio: 0.35 // this makes bar width 50% of length between ticks
                    }
                },
                tooltip: {
                    format: {
                        value: function(value, ratio, id, index) {
                            return value.toLocaleString("en") + " MZN";
                        }
                    }
                },
                transition: { duration: 1000 },
                legend: {
                    show: false
                }
            };
            this.relFinProject.$emit("init", options);
        },

        async filter(year, start_date, end_date) {
            if (this.project.length !== 0) {
                this.isLoading = true;
                await axios__WEBPACK_IMPORTED_MODULE_1___default.a
                    .get(
                        `/reports/api/budget/project/${this.project.identifier}?year=${year}&start_date=${start_date}&end_date=${end_date}`
                    )
                    .then(response => {
                        // let type = "bar";
                        this.dataTable = response.data.dataTable;
                        this.ini_graph_load(response.data.dataGraph);
                    })
                    .catch(error => {
                        console.error({ Request: error });
                        this.ini_graph_load([]);
                        this.dataTable = [];
                        alert(
                            `Sinceras Desculpas! \nOcorreu um erro enquanto carregavamos os dados...\n${error}`
                        );
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        }
    }
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/orcamento_project.vue?vue&type=template&id=5d9045c4&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/orcamento_project.vue?vue&type=template&id=5d9045c4& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
        _c("div", {}, [
          _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
            _vm._v(
              "\n                    Projectos (" +
                _vm._s(_vm.projects.length) +
                ")\n                "
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
                  value: _vm.project,
                  expression: "project",
                },
              ],
              staticClass: "border mt-1 p-1 w-100",
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
                    _vm.project = $event.target.multiple
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
                [_vm._v("Selecione um plano estratégico")]
              ),
              _vm._v(" "),
              _vm._l(_vm.projects, function (project, key) {
                return _c(
                  "option",
                  { key: key, domProps: { value: project } },
                  [
                    _vm._v(
                      "\n                        " +
                        _vm._s(project.name) +
                        "\n                    "
                    ),
                  ]
                )
              }),
            ],
            2
          ),
          _vm._v(" "),
          _c("hr", { staticClass: "mt-1 mb-2" }),
        ]),
        _vm._v(" "),
        _vm._m(0),
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
                  "font-size": "12px",
                },
              },
              [
                _vm._v(
                  "\n                        Gráfico de Barras - Orçamento do Projecto\n                    "
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
                  "\n                        " +
                    _vm._s(_vm.project.name || null) +
                    "\n                    "
                ),
              ]
            ),
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "grapth", staticStyle: { "min-height": "50vh" } },
            [
              _c("vue-c3", { attrs: { handler: _vm.relFinProject } }),
              _vm._v(" "),
              _vm._m(1),
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "table-responsive" }, [
            _c(
              "table",
              { staticClass: "finances border table table-sm table-hover" },
              [
                _vm._m(2),
                _vm._v(" "),
                _c(
                  "tbody",
                  [
                    _vm.dataTable !== null && !_vm.isLoading
                      ? [
                          _c("tr", [
                            _c(
                              "td",
                              { staticClass: "table-active text-body pl-2" },
                              [
                                _vm._v(
                                  "\n                                        Orçamento do Projecto\n                                    "
                                ),
                              ]
                            ),
                            _vm._v(" "),
                            _c("td", [
                              _vm._v(
                                "\n                                        " +
                                  _vm._s(
                                    _vm.dataTable
                                      ? _vm.formatBudget(
                                          _vm.dataTable.orcamento_inicial
                                        )
                                      : 0.0
                                  ) +
                                  "\n                                        MZN\n                                    "
                              ),
                            ]),
                          ]),
                          _vm._v(" "),
                          _c("tr", [
                            _c(
                              "td",
                              { staticClass: "table-active text-body pl-2" },
                              [
                                _vm._v(
                                  "\n                                        Valor Gasto\n                                    "
                                ),
                              ]
                            ),
                            _vm._v(" "),
                            _c("td", [
                              _vm._v(
                                "\n                                        " +
                                  _vm._s(
                                    _vm.dataTable
                                      ? _vm.formatBudget(
                                          _vm.dataTable.orcamento_gasto
                                        )
                                      : 0.0
                                  ) +
                                  "\n                                        MZN\n                                    "
                              ),
                            ]),
                          ]),
                          _vm._v(" "),
                          _vm._m(3),
                        ]
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.dataTable == null && !_vm.isLoading
                      ? _c("tr", [
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              attrs: { colspan: "2" },
                            },
                            [
                              _vm._v(
                                "\n                                    " +
                                  _vm._s(_vm.__("lang.label_no_data")) +
                                  "\n                                "
                              ),
                            ]
                          ),
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.isLoading
                      ? _c("tr", [
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              attrs: { colspan: "2" },
                            },
                            [
                              _vm._v(
                                "\n                                    " +
                                  _vm._s("Carregando...") +
                                  "\n                                "
                              ),
                            ]
                          ),
                        ])
                      : _vm._e(),
                  ],
                  2
                ),
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
                    _vm._v("Ano:"),
                  ]),
                  _vm._v(" "),
                  _c("div", {}, [
                    _vm._v(
                      "\n                            " +
                        _vm._s(_vm.year) +
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
                    _vm._v(
                      "\n                            Data Inicial:\n                        "
                    ),
                  ]),
                  _vm._v(" "),
                  _c("div", {}, [
                    _vm._v(
                      "\n                            " +
                        _vm._s(_vm.start_date || "mm/dd/yyyy") +
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
                  staticClass: "dropdown-menu border my-shadow p-2",
                  attrs: { "aria-labelledby": "dropdownNotidications" },
                },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.start_date,
                        expression: "start_date",
                      },
                    ],
                    staticClass: "form-control",
                    attrs: { type: "date" },
                    domProps: { value: _vm.start_date },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.start_date = $event.target.value
                      },
                    },
                  }),
                  _vm._v(" "),
                  _c(
                    "li",
                    {
                      staticClass:
                        "dropdown-item cursor-pointer text-center rounded bg-light mt-1",
                    },
                    [
                      _vm._v(
                        "\n                            Fechar\n                        "
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
                    _vm._v(
                      "\n                            Data Final:\n                        "
                    ),
                  ]),
                  _vm._v(" "),
                  _c("div", {}, [
                    _vm._v(
                      "\n                            " +
                        _vm._s(_vm.end_date || "mm/dd/yyyy") +
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
                  staticClass: "dropdown-menu border my-shadow p-2",
                  attrs: { "aria-labelledby": "dropdownNotidications" },
                },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.end_date,
                        expression: "end_date",
                      },
                    ],
                    staticClass: "form-control",
                    attrs: { type: "date" },
                    domProps: { value: _vm.end_date },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.end_date = $event.target.value
                      },
                    },
                  }),
                  _vm._v(" "),
                  _c(
                    "li",
                    {
                      staticClass:
                        "dropdown-item cursor-pointer text-center rounded bg-light mt-1",
                    },
                    [
                      _vm._v(
                        "\n                            Fechar\n                        "
                      ),
                    ]
                  ),
                ]
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "w-100 mt-2" }, [
              _c(
                "button",
                {
                  staticClass:
                    "w-100 rounded btn btn-dark border fw-700 btn-sm p-1 shadow-sm",
                  on: {
                    click: function ($event) {
                      return _vm.filter(_vm.year, _vm.start_date, _vm.end_date)
                    },
                  },
                },
                [
                  _vm._v(
                    "\n                        Submeter\n                    "
                  ),
                ]
              ),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "m-3" }),
          _vm._v(" "),
          _vm._m(6),
          _vm._v(" "),
          _vm._m(7),
        ]
      ),
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
    return _c("div", { staticClass: "d-flex align-items-baseline" }, [
      _c("div", { staticClass: "flex-grow-1" }, [
        _c("h5", { staticClass: "fw-500 mb-0" }, [
          _vm._v(
            "\n                        Orçamento do Projecto\n                    "
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
              staticStyle: { "border-top": "3px solid #3366cc" },
            }),
            _vm._v(" "),
            _c("div", { staticClass: "c3-legend-item text-black-50 fw-500" }, [
              _vm._v(
                "\n                                    Orçamento do Projecto\n                                "
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
                "\n                                    Valor Gasto\n                                "
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
      _c("th", { staticClass: "fw-600" }, [_vm._v("Descrição")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Valor (MZN)")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { staticClass: "table-active text-body pl-2" }, [
        _vm._v(
          "\n                                        % Execucao\n                                    "
        ),
      ]),
      _vm._v(" "),
      _c("td", [_vm._v("0 %")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "h5",
      { staticClass: "border-bottom btn w-100 text-left fw-600 pl-1" },
      [
        _c("i", { staticClass: "icon-arrow-up5" }),
        _vm._v("FILTROS\n            "),
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
              _vm._v(
                "\n                                2020\n                            "
              ),
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
      "h5",
      { staticClass: "border-bottom btn w-100 text-left fw-600 pl-1" },
      [
        _c("i", { staticClass: "icon-arrow-up5" }),
        _vm._v("FILTROS AVANCADOS\n            "),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "_advanced_filters" }, [
      _c("small", { staticClass: "pl-1 text-center text-muted" }, [
        _vm._v("Upcoming release"),
      ]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/reports/orcamento_project.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/views/reports/orcamento_project.vue ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _orcamento_project_vue_vue_type_template_id_5d9045c4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./orcamento_project.vue?vue&type=template&id=5d9045c4& */ "./resources/js/components/views/reports/orcamento_project.vue?vue&type=template&id=5d9045c4&");
/* harmony import */ var _orcamento_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./orcamento_project.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/reports/orcamento_project.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _orcamento_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _orcamento_project_vue_vue_type_template_id_5d9045c4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _orcamento_project_vue_vue_type_template_id_5d9045c4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/reports/orcamento_project.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/reports/orcamento_project.vue?vue&type=script&lang=ts&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/views/reports/orcamento_project.vue?vue&type=script&lang=ts& ***!
  \**********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./orcamento_project.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/orcamento_project.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/reports/orcamento_project.vue?vue&type=template&id=5d9045c4&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/orcamento_project.vue?vue&type=template&id=5d9045c4& ***!
  \****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_project_vue_vue_type_template_id_5d9045c4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./orcamento_project.vue?vue&type=template&id=5d9045c4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/orcamento_project.vue?vue&type=template&id=5d9045c4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_project_vue_vue_type_template_id_5d9045c4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_orcamento_project_vue_vue_type_template_id_5d9045c4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);