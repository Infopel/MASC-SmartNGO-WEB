(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[21],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/atividades_provincia.vue?vue&type=script&lang=ts&":
/*!***************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/atividades_provincia.vue?vue&type=script&lang=ts& ***!
  \***************************************************************************************************************************************************/
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







































































































































































































/* harmony default export */ __webpack_exports__["default"] = (vue__WEBPACK_IMPORTED_MODULE_0___default.a.extend({
    components: {
        VueC3: (vue_c3__WEBPACK_IMPORTED_MODULE_2___default())
    },
    props: [
        'issues'
    ],

    mounted() {
        this.processQueries();
    },

    data (){
        return {
            handler: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            relAtividadeProvincia: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            year: null,
            start_date: null,
            end_date: null,
            isLoading: false,
        }
    },
    methods: {
        async processQueries(){
            this.isLoading = true;
            await axios__WEBPACK_IMPORTED_MODULE_1___default.a.get('/reports/api/actividades/provincia')
                .then(response =>{
                    this.generate_graph(response.data)
                })
                .catch(error =>{
                    console.error(error)
                })
                .finally(()=>{
                    this.isLoading = false;
                })
        },

        generate_graph(data){
            const options = {
                data: {
                    json: data,
                    type: 'bar',
                    keys: {
                        x: 'provincia',
                        value: ['Aciviades']
                    },
                },
                color: {
                    pattern: ['#3366cc']
                },
                axis:{
                    x: {
                        type: 'category',
                        x:['key'],
                    },
                    y: {
                        tick: {
                            // format: d3.format(),
                            format: function (d) {
                                return (parseInt(d) == d) ? d : null;
                            }
                        }
                    }
                },
                bar: {
                    width: {
                        ratio: 0.35 // this makes bar width 50% of length between ticks
                    }
                },
                tooltip: {},
                y: {
                    min: 0,
                    padding: {top: 0, bottom: 0}
                },
                transition: { duration: 1000 },
                legend: {
                    show: false
                }
            }
            this.relAtividadeProvincia.$emit('init', options)
        }
    },
}));


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/atividades_provincia.vue?vue&type=template&id=15274854&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/atividades_provincia.vue?vue&type=template&id=15274854&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "grath-data" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "grapth", staticStyle: { "min-height": "50vh" } },
            [
              _c("vue-c3", { attrs: { handler: _vm.relAtividadeProvincia } }),
              _vm._v(" "),
              _vm._m(2),
            ],
            1
          ),
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
          _vm._m(3),
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
              _vm._m(4),
            ]),
            _vm._v(" "),
            _vm._m(5),
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
                    _vm._v("Data Final:"),
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
            _vm._m(6),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "m-3" }),
          _vm._v(" "),
          _vm._m(7),
          _vm._v(" "),
          _vm._m(8),
        ]
      ),
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "mt-2", attrs: { id: "table-content-container" } },
      [
        _c("div", { staticClass: "table-responsive" }, [
          _c(
            "table",
            {
              staticClass:
                "border finances table table-sm table-striped table-hover",
              staticStyle: { "font-size": "95%" },
            },
            [
              _vm._m(9),
              _vm._v(" "),
              _c(
                "tbody",
                [
                  _vm._l(_vm.issues, function (issue, key) {
                    return [
                      _c("tr", { key: key }, [
                        _c(
                          "td",
                          {
                            staticClass: "fw-400",
                            attrs: { title: "Actividade: " + issue.subject },
                          },
                          [
                            _c(
                              "a",
                              {
                                staticClass: "link-option",
                                attrs: { href: issue.route },
                              },
                              [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(issue.subject) +
                                    "\n                                "
                                ),
                              ]
                            ),
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "fw-400",
                            attrs: { title: "Projecto" },
                          },
                          [
                            _c(
                              "a",
                              {
                                staticClass: "link-option",
                                attrs: { href: issue.project.route },
                              },
                              [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(issue.project.name || null) +
                                    "\n                                "
                                ),
                              ]
                            ),
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "p-0 pl-2 pr-2 text-nowrap fw-500",
                            attrs: { title: "Província" },
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(issue.provincia.value || "undefined") +
                                "\n                            "
                            ),
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "fw-400",
                            attrs: { title: "Indicador" },
                          },
                          [
                            _vm._l(
                              issue.indicators,
                              function (indicador, key_2) {
                                return [
                                  _c("li", { key: key_2 }, [
                                    _vm._v(
                                      "\n                                        " +
                                        _vm._s(indicador.indicator_field.name) +
                                        "\n                                    "
                                    ),
                                  ]),
                                ]
                              }
                            ),
                          ],
                          2
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "p-0 pl-2 pr-2 text-nowrap fw-500",
                            attrs: { title: "Meta" },
                          },
                          [
                            _vm._l(
                              issue.indicators,
                              function (indicador, key_3) {
                                return [
                                  _c("li", { key: key_3 }, [
                                    _vm._v(
                                      "\n                                        " +
                                        _vm._s(
                                          indicador.indicator_field
                                            .indicator_issue_values.meta
                                        ) +
                                        "\n                                    "
                                    ),
                                  ]),
                                ]
                              }
                            ),
                          ],
                          2
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "p-0 pl-2 pr-2 text-nowrap fw-500",
                            attrs: { title: "Realizado" },
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(0) +
                                "\n                            "
                            ),
                          ]
                        ),
                      ]),
                    ]
                  }),
                ],
                2
              ),
            ]
          ),
        ]),
      ]
    ),
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
            "\n                        Atividades por Pronvícias\n                    "
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
            "\n                        Gráfico de Barras - Projectos vs Actividades\n                    "
          ),
        ]
      ),
      _vm._v(" "),
      _c("p", {
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
      }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "mt-3 mb-2 d-none" }, [
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
              _vm._v("Orçamento do Projecto"),
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
              _vm._v("Valor Gasto"),
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
    return _c("div", { staticClass: "border-bottom w-100" }, [
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
              "\n                            2020\n                            "
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
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "w-100 mt-2" }, [
      _c(
        "button",
        {
          staticClass:
            "w-100 rounded btn btn-dark border fw-700 btn-sm p-1 shadow-sm",
        },
        [_vm._v("Submeter")]
      ),
    ])
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
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "table-active" }, [
      _c("th", { staticClass: "fw-600" }, [_vm._v("Actividade")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Projecto")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Província")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Indicador")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Meta")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Realizado")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/reports/atividades_provincia.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/views/reports/atividades_provincia.vue ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _atividades_provincia_vue_vue_type_template_id_15274854_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./atividades_provincia.vue?vue&type=template&id=15274854&scoped=true& */ "./resources/js/components/views/reports/atividades_provincia.vue?vue&type=template&id=15274854&scoped=true&");
/* harmony import */ var _atividades_provincia_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./atividades_provincia.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/reports/atividades_provincia.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _atividades_provincia_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _atividades_provincia_vue_vue_type_template_id_15274854_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _atividades_provincia_vue_vue_type_template_id_15274854_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "15274854",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/reports/atividades_provincia.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/reports/atividades_provincia.vue?vue&type=script&lang=ts&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/atividades_provincia.vue?vue&type=script&lang=ts& ***!
  \*************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_atividades_provincia_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./atividades_provincia.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/atividades_provincia.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_atividades_provincia_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/reports/atividades_provincia.vue?vue&type=template&id=15274854&scoped=true&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/atividades_provincia.vue?vue&type=template&id=15274854&scoped=true& ***!
  \*******************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_atividades_provincia_vue_vue_type_template_id_15274854_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./atividades_provincia.vue?vue&type=template&id=15274854&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/atividades_provincia.vue?vue&type=template&id=15274854&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_atividades_provincia_vue_vue_type_template_id_15274854_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_atividades_provincia_vue_vue_type_template_id_15274854_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);