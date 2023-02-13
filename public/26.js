(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[26],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/general_indicators_report.vue?vue&type=script&lang=ts&":
/*!********************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/general_indicators_report.vue?vue&type=script&lang=ts& ***!
  \********************************************************************************************************************************************************/
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
    props: ["projects"],
    data() {
        return {
            selected_project: [],
            selected_project_pilar: [],
            selected_projectos: [],
            project: null,
            project_pilar: null,
            year: null,
            pilares: [],
            projectos: [],
            reportsData: [],
            viewSize: 90,


            isLoading: false,
            requestError: false
        };
    },

    mounted() {},

    methods: {
        /**
         * On Project Select
         */
        async onProjectPilarSelect(event){
            if(this.selected_project_pilar.length !== 0){

                this.isLoading = true;
                this.requestError = false;

                await axios__WEBPACK_IMPORTED_MODULE_1___default.a
                    .get(
                        `/web/api/reports/general_issues/${this.selected_project_pilar.identifier}`
                    )
                    .then(response => {
                        this.projectos = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() =>{
                    this.isLoading = false;
                })
            }
        },
        // On Porject is Selected
        async onProjectSelect(event) {
            if (this.selected_project.length !== 0) {
                this.isLoading = true;
                await axios__WEBPACK_IMPORTED_MODULE_1___default.a
                    .get(
                        `/web/api/projects/${this.selected_project.identifier}?type=programs`
                    )
                    .then(response => {
                        this.pilares = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },

        async onProject(event) {
            if (this.selected_projectos.length !== 0) {
                this.isLoading = true;
                this.requestError = false;
                await axios__WEBPACK_IMPORTED_MODULE_1___default.a
                    .get(`/web/api/reports/general_indicators_report/${this.selected_projectos.identifier}`)
                    .then(response => {
                        this.reportsData = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                        this.isLoading = false;
                        this.requestError = true;
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });

            }
        }


    }
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/general_indicators_report.vue?vue&type=template&id=2022284c&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/general_indicators_report.vue?vue&type=template&id=2022284c&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
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
                "\n                        Planos Estratégicos (" +
                  _vm._s(_vm.projects.length) +
                  ")\n                    "
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
                staticClass: "border p-1 w-100",
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
                  [_vm._v("Selecione um plano estratégico")]
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
            _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
              _vm._v(
                "\n                        Pilares (" +
                  _vm._s(_vm.pilares.length) +
                  ")\n                    "
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
                    value: _vm.selected_project_pilar,
                    expression: "selected_project_pilar",
                  },
                ],
                staticClass: "border p-1 w-100",
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
                      _vm.selected_project_pilar = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    },
                    function ($event) {
                      return _vm.onProjectPilarSelect($event)
                    },
                  ],
                },
              },
              [
                _c(
                  "option",
                  { attrs: { selected: "" }, domProps: { value: [] } },
                  [_vm._v("Selecione um Pilar")]
                ),
                _vm._v(" "),
                _vm._l(_vm.pilares, function (pilar, key) {
                  return _c(
                    "option",
                    { key: key, domProps: { value: pilar } },
                    [
                      _vm._v(
                        "\n                            " +
                          _vm._s(pilar.name) +
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
            _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
              _vm._v(
                "\n                        Projectos (" +
                  _vm._s(_vm.projectos.length) +
                  ")\n                    "
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
                    value: _vm.selected_projectos,
                    expression: "selected_projectos",
                  },
                ],
                staticClass: "border p-1 w-100",
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
                      _vm.selected_projectos = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    },
                    function ($event) {
                      return _vm.onProject($event)
                    },
                  ],
                },
              },
              [
                _c(
                  "option",
                  { attrs: { selected: "" }, domProps: { value: [] } },
                  [_vm._v("Selecione um projecto")]
                ),
                _vm._v(" "),
                _vm._l(_vm.projectos, function (projecto, key) {
                  return _c(
                    "option",
                    { key: key, domProps: { value: projecto } },
                    [
                      _vm._v(
                        "\n                            " +
                          _vm._s(projecto.name) +
                          "\n                        "
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
        _c("div", {
          staticClass: "mt-2 form-inline align-items-end",
          staticStyle: { "font-size": "95%" },
        }),
      ]),
      _vm._v(" "),
      _c("hr", { staticClass: "mt-0 mb-0 mr-3 ml-3" }),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "bg-white border border-top-0 p-3" }, [
      _c("div", { staticClass: "d-flex align-items-baseline" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "d-flex align-items" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "mt-1 mr-2", staticStyle: { "font-size": "95%" } },
            [
              _c("label", { staticClass: "mb-0", attrs: { for: "" } }, [
                _vm._v("Tamanho: " + _vm._s(_vm.viewSize) + " %"),
              ]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.viewSize,
                    expression: "viewSize",
                  },
                ],
                staticClass: "align-middle",
                staticStyle: { width: "100px" },
                attrs: {
                  type: "range",
                  name: "range",
                  id: "table-font-size",
                  min: 50,
                },
                domProps: { value: _vm.viewSize },
                on: {
                  __r: function ($event) {
                    _vm.viewSize = $event.target.value
                  },
                },
              }),
            ]
          ),
          _vm._v(" "),
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
                  attrs: {
                    href:
                      "/reports/api/exportGI/report/project/" +
                      this.selected_projectos.identifier +
                      "?type=" +
                      _vm.requestDataType,
                  },
                },
                [
                  _c("i", { staticClass: "icon-file-excel" }),
                  _vm._v(
                    "\n                    Export Excel\n                    "
                  ),
                ]
              ),
            ]
          ),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "table-responsive mt-2" }, [
        _c(
          "table",
          {
            staticClass:
              "table table-sm table-striped table-hover table-bordered",
            style: "font-size:" + _vm.viewSize + "%",
          },
          [
            _c("thead", { staticClass: "table-activez" }, [
              _c("tr", [
                _c("th", { attrs: { colspan: "2" } }, [_vm._v("Pilar:")]),
                _vm._v(" "),
                _vm.selected_project_pilar.name
                  ? _c("th", { attrs: { colspan: "17" } }, [
                      _c(
                        "a",
                        { attrs: { href: _vm.selected_project_pilar.route } },
                        [_vm._v(_vm._s(_vm.selected_project_pilar.name))]
                      ),
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.selected_project_pilar.length === 0
                  ? _c("th", { attrs: { colspan: "17" } }, [
                      _vm._v(
                        "\n                            Selecione um projecto e um prilar\n                        "
                      ),
                    ])
                  : _vm._e(),
              ]),
              _vm._v(" "),
              _c("tr", [
                _c("th", { attrs: { colspan: "2" } }, [
                  _vm._v("OBJECTIVO ESTRATÉGICO:"),
                ]),
                _vm._v(" "),
                _vm.selected_project_pilar.name
                  ? _c("th", { attrs: { colspan: "17" } }, [
                      _vm._v(
                        "\n                            " +
                          _vm._s(_vm.selected_projectos.identifier) +
                          "\n                        "
                      ),
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.selected_project_pilar.length === 0
                  ? _c("th", { attrs: { colspan: "17" } }, [
                      _vm._v(
                        "\n                            Selecione um projecto e um prilar\n                        "
                      ),
                    ])
                  : _vm._e(),
              ]),
              _vm._v(" "),
              _c("tr", [
                _c("th", { attrs: { colspan: "2" } }, [_vm._v("RESULTADO:")]),
                _vm._v(" "),
                _vm.selected_project_pilar.name
                  ? _c("th", { attrs: { colspan: "17" } }, [
                      _vm._v(
                        "\n                            " +
                          _vm._s(_vm.selected_project_pilar.resultado) +
                          "\n                        "
                      ),
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.selected_project_pilar.length === 0
                  ? _c("th", { attrs: { colspan: "17" } }, [
                      _vm._v(
                        "\n                            Selecione um projecto e um prilar\n                        "
                      ),
                    ])
                  : _vm._e(),
              ]),
              _vm._v(" "),
              _vm._m(2),
              _vm._v(" "),
              _vm._m(3),
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.reportsData, function (data, key) {
                  return [
                    _c("tr", { key: key }, [
                      _c(
                        "td",
                        { staticClass: "p-2 pl-2 pr-2 text-capitalize" },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(++key) +
                              "\n                            "
                          ),
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "p-2 pl-2 pr-2",
                          staticStyle: { "min-width": "180px" },
                        },
                        [
                          _c("a", { attrs: { href: "#" } }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(
                                  data.result ? data.result.subject : null
                                ) +
                                "\n                                "
                            ),
                          ]),
                        ]
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _c("a", { attrs: { href: data.issue.route } }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(data.issue.subject) +
                              "\n                                "
                          ),
                        ]),
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "p-2 pl-2 pr-2",
                          staticStyle: { "min-width": "180px" },
                        },
                        [
                          _c(
                            "ul",
                            [
                              _vm._l(
                                data.indicadores,
                                function (indicador, key) {
                                  return [
                                    _c("li", { key: key }, [
                                      _vm._v(
                                        "\n                                            " +
                                          _vm._s(
                                            indicador.indicator_field.name
                                          ) +
                                          "\n                                        "
                                      ),
                                    ]),
                                  ]
                                }
                              ),
                            ],
                            2
                          ),
                        ]
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _c(
                          "ul",
                          [
                            _vm._l(data.indicadores, function (indicador, key) {
                              return [
                                _c("li", { key: key }, [
                                  _vm._v(
                                    "\n                                            " +
                                      _vm._s(
                                        indicador.indicator_field
                                          .indicator_issue_values.meta || 0
                                      ) +
                                      "\n                                        "
                                  ),
                                ]),
                              ]
                            }),
                          ],
                          2
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _c(
                          "ul",
                          [
                            _vm._l(data.indicadores, function (indicador, key) {
                              return [
                                _c("li", { key: key }, [
                                  _vm._v(
                                    "\n                                            " +
                                      _vm._s(
                                        indicador.indicator_field
                                          .indicator_issue_values.m_trim_01 || 0
                                      ) +
                                      "\n                                        "
                                  ),
                                ]),
                              ]
                            }),
                          ],
                          2
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _c(
                          "ul",
                          [
                            _vm._l(data.indicadores, function (indicador, key) {
                              return [
                                _c("li", { key: key }, [
                                  _vm._v(
                                    "\n                                            " +
                                      _vm._s(
                                        indicador.indicator_field
                                          .indicator_issue_values.m_trim_02 || 0
                                      ) +
                                      "\n                                        "
                                  ),
                                ]),
                              ]
                            }),
                          ],
                          2
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _c(
                          "ul",
                          [
                            _vm._l(data.indicadores, function (indicador, key) {
                              return [
                                _c("li", { key: key }, [
                                  _vm._v(
                                    "\n                                            " +
                                      _vm._s(
                                        indicador.indicator_field
                                          .indicator_issue_values.m_trim_03 || 0
                                      ) +
                                      "\n                                        "
                                  ),
                                ]),
                              ]
                            }),
                          ],
                          2
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _c(
                          "ul",
                          [
                            _vm._l(data.indicadores, function (indicador, key) {
                              return [
                                _c("li", { key: key }, [
                                  _vm._v(
                                    "\n                                            " +
                                      _vm._s(
                                        indicador.indicator_field
                                          .indicator_issue_values.m_trim_04 || 0
                                      ) +
                                      "\n                                        "
                                  ),
                                ]),
                              ]
                            }),
                          ],
                          2
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _vm._v(
                          "\n                                " +
                            _vm._s(data.meta_realizada) +
                            "\n                            "
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _vm._v(
                          "\n                                " +
                            _vm._s(data.grao_realizacao) +
                            "\n                            "
                        ),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2 text-nowrap" }, [
                        _c("a", { attrs: { href: data.project.route } }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(data.project.name) +
                              "\n                                "
                          ),
                        ]),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _c("a", { attrs: { href: data.issue.route } }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(data.issue.start_date) +
                              "\n                                "
                          ),
                        ]),
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                        _c("a", { attrs: { href: data.issue.route } }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(data.issue.due_date) +
                              "\n                                "
                          ),
                        ]),
                      ]),
                      _vm._v(" "),
                      data.issue.assigned_to
                        ? _c("td", { staticClass: "p-2 pl-2 pr-2" }, [
                            _c("a", { attrs: { href: data.issue.route } }, [
                              _vm._v(
                                "\n                                    " +
                                  _vm._s(
                                    data.issue.assigned_to.full_name || 0
                                  ) +
                                  "\n                                "
                              ),
                            ]),
                          ])
                        : _vm._e(),
                    ]),
                  ]
                }),
                _vm._v(" "),
                _vm.reportsData.length == 0
                  ? [
                      _c("tr", [
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            attrs: { colspan: "19" },
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s("Nenhuma informação disponível") +
                                "\n                            "
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
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "mt-2 mb-2" }, [
        _c(
          "div",
          { staticClass: "form-group", staticStyle: { "font-size": "95%" } },
          [
            _c("label", { attrs: { for: "" } }, [
              _vm._v("Tamanho: " + _vm._s(_vm.viewSize) + " %"),
            ]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.viewSize,
                  expression: "viewSize",
                },
              ],
              staticClass: "align-middle",
              staticStyle: { width: "100px" },
              attrs: {
                type: "range",
                name: "range",
                id: "table-font-size",
                min: 50,
              },
              domProps: { value: _vm.viewSize },
              on: {
                __r: function ($event) {
                  _vm.viewSize = $event.target.value
                },
              },
            }),
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
    return _c("div", { staticClass: "flex-grow-1" }, [
      _c("h5", { staticClass: "fw-600" }, [
        _vm._v("Relatório geral de realização"),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "btn-group btn-group-sm d-none",
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
          _vm._v("\n                        Imprimir\n                    "),
        ]),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", { staticClass: "bg-slate-700" }, [
      _c("th", { staticClass: "text-nowrap", attrs: { rowspan: "2" } }, [
        _vm._v("Nº Ordem"),
      ]),
      _vm._v(" "),
      _c("th", { attrs: { rowspan: "2" } }, [_vm._v("Resultado (Output)")]),
      _vm._v(" "),
      _c("th", { staticClass: "text-nowrap", attrs: { rowspan: "2" } }, [
        _vm._v("Actividade (Grande Actividade)"),
      ]),
      _vm._v(" "),
      _c("th", { attrs: { rowspan: "2" } }, [_vm._v("Indicador")]),
      _vm._v(" "),
      _c("th", { staticClass: "text-nowrap", attrs: { rowspan: "2" } }, [
        _vm._v("Meta Anual"),
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "text-nowrap", attrs: { colspan: "4" } }, [
        _vm._v("Meta Trimestral"),
      ]),
      _vm._v(" "),
      _c("th", { attrs: { rowspan: "2" } }, [_vm._v("Meta Realizada")]),
      _vm._v(" "),
      _c("th", { attrs: { rowspan: "2" } }, [_vm._v("Grau de Realização (%)")]),
      _vm._v(" "),
      _c("th", { attrs: { rowspan: "2" } }, [_vm._v("Projecto Responsável")]),
      _vm._v(" "),
      _c("th", { attrs: { rowspan: "2" } }, [_vm._v("Data de Inicio")]),
      _vm._v(" "),
      _c("th", { attrs: { rowspan: "2" } }, [_vm._v("Data de Fim")]),
      _vm._v(" "),
      _c("th", { attrs: { rowspan: "2" } }, [_vm._v("Responsável")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", [_vm._v("I")]),
      _vm._v(" "),
      _c("th", [_vm._v("II")]),
      _vm._v(" "),
      _c("th", [_vm._v("III")]),
      _vm._v(" "),
      _c("th", [_vm._v("IV")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/reports/general_indicators_report.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/views/reports/general_indicators_report.vue ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _general_indicators_report_vue_vue_type_template_id_2022284c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./general_indicators_report.vue?vue&type=template&id=2022284c&scoped=true& */ "./resources/js/components/views/reports/general_indicators_report.vue?vue&type=template&id=2022284c&scoped=true&");
/* harmony import */ var _general_indicators_report_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./general_indicators_report.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/reports/general_indicators_report.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _general_indicators_report_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _general_indicators_report_vue_vue_type_template_id_2022284c_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _general_indicators_report_vue_vue_type_template_id_2022284c_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "2022284c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/reports/general_indicators_report.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/reports/general_indicators_report.vue?vue&type=script&lang=ts&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/general_indicators_report.vue?vue&type=script&lang=ts& ***!
  \******************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_general_indicators_report_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./general_indicators_report.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/general_indicators_report.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_general_indicators_report_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/reports/general_indicators_report.vue?vue&type=template&id=2022284c&scoped=true&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/general_indicators_report.vue?vue&type=template&id=2022284c&scoped=true& ***!
  \************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_general_indicators_report_vue_vue_type_template_id_2022284c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./general_indicators_report.vue?vue&type=template&id=2022284c&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/general_indicators_report.vue?vue&type=template&id=2022284c&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_general_indicators_report_vue_vue_type_template_id_2022284c_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_general_indicators_report_vue_vue_type_template_id_2022284c_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);