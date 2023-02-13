(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[20],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividades_project.vue?vue&type=script&lang=ts&":
/*!**************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/actividades_project.vue?vue&type=script&lang=ts& ***!
  \**************************************************************************************************************************************************/
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
    props: ["projects_pde"],
    data() {
        return {
            selected_project: [],
            projectPDE: [],
            projects: [],
            project: null,
            start_date: null,
            end_date: null,
            year: new Date().getFullYear(),
            isLoading: false,
            reportsData: []
        };
    },

    mounted() {},

    methods: {
        // On Porject is Selected
        async onProjectParent(event) {
            if (this.projectPDE.length !== 0) {
                this.isLoading = true;
                await axios__WEBPACK_IMPORTED_MODULE_1___default.a
                    .get(
                        `/web/api/reports/activity/pde/${this.projectPDE.identifier}/projects`
                    )
                    .then(response => {
                        this.projects = response.data.projects;
                        //this.reportsData = response.data.projects;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },

        async onProjectSelect(event) {
            if (this.projects.length !== 0) {
                this.isLoading = true;
                await axios__WEBPACK_IMPORTED_MODULE_1___default.a
                    .get(
                        `/web/api/reports/activity/pde/${this.selected_project.identifier}/activity`
                    )
                    .then(response => {
                        this.reportsData = response.data.projects;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },

        async getDataByDate(setFilter = false) {
            this.isLoading = true;

            return await axios__WEBPACK_IMPORTED_MODULE_1___default.a
                .get(
                `/web/api/reports/activity/pde/${this.selected_project.identifier}/activityByDate?setFilter=${setFilter}&start_date=${this.start_date}&end_date=${this.end_date}`
                )
                .then(response => {
                    this.reportsData = response.data.projects;
                })
                .catch(error => {
                    alert("Encontramos um error ao requisatar os dados do servidor.");
                    this.isError = true;
                    console.error({
                        status: "Error",
                        message: "Encontramos um error ao requisatar os dados do servidor",
                        errorLog: error
                    });
                })
                .finally(() => {
                    this.isLoading = false;
            });
        },

        async getExportExcel(setFilter = false) {
            this.isLoading = true;
            return await axios__WEBPACK_IMPORTED_MODULE_1___default.a
                .get(
                `/web/api/reports/activity/pde/${this.selected_project.identifier}/activity/export?start_date=${this.start_date}&end_date=${this.end_date}`
                )
                .catch(error => {
                    //alert("Encontramos um error ao exportar o Ficheiro Excel.");
                    this.isError = true;
                    console.error({
                        status: "Error",
                        message: "Encontramos um error ao exportar o Ficheiro Excel",
                        errorLog: error
                    });
                })
                .finally(() => {
                    this.isLoading = false;
            });
        }
    }
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividades_project.vue?vue&type=template&id=9fece54e&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/actividades_project.vue?vue&type=template&id=9fece54e&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
          _c("div", { staticClass: "w-25 mb-2" }, [
            _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
              _vm._v(
                "\n                        Linhas Estratégicas (" +
                  _vm._s(_vm.projects_pde.length) +
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
                    value: _vm.projectPDE,
                    expression: "projectPDE",
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
                      _vm.projectPDE = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    },
                    function ($event) {
                      return _vm.onProjectParent($event)
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
                _vm._l(_vm.projects_pde, function (project, key) {
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
          _vm.projectPDE.length !== 0
            ? _c("div", { staticClass: "w-25 ml-2 mb-2" }, [
                _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
                  _vm._v(
                    "\n                        Projectos (" +
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
                      [_vm._v("Selecione um projecto")]
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
              ])
            : _vm._e(),
          _vm._v(" "),
          _c("div", { staticClass: "ml-2 mb-2" }, [
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
                staticClass: "border pl-2 pr-2 p-1",
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
          _c("div", { staticClass: "ml-2 mb-2" }, [
            _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
              _vm._v("Data de Inicio"),
            ]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.start_date,
                  expression: "start_date",
                },
              ],
              staticClass: "border pl-2 p-1",
              staticStyle: { "font-size": "90%" },
              attrs: { type: "date", name: "start_date" },
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
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "ml-2 mr-2 mb-2" }, [
            _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
              _vm._v("Data de Fim"),
            ]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.end_date,
                  expression: "end_date",
                },
              ],
              staticClass: "border pl-2 p-1",
              staticStyle: { "font-size": "90%" },
              attrs: { type: "date", name: "end_date" },
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
                    return _vm.getDataByDate(_vm.project !== null)
                  },
                },
              },
              [
                _vm._v(
                  "\n                        Pesquisar\n                    "
                ),
              ]
            ),
          ]),
        ]),
      ]),
      _vm._v(" "),
      _c("hr", { staticClass: "mt-0 mb-0 mr-3 ml-3" }),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "bg-white border border-top-0 p-3" }, [
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
                "button",
                {
                  staticClass:
                    "btn pt-1 pb-1 btn-success rounded-0 fw-600 shadow-sm",
                  on: {
                    click: function ($event) {
                      return _vm.getExportExcel(_vm.project !== null)
                    },
                  },
                },
                [
                  _vm._v(
                    "\n                        Folege\n                    "
                  ),
                ]
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "btn btn-sm m-0 btn-dark",
                  attrs: {
                    href:
                      "/web/api/reports/activity/pde/" +
                      this.selected_project.identifier +
                      "/activity/export?start_date=" +
                      this.start_date +
                      "&end_date=" +
                      this.end_date,
                  },
                },
                [
                  _c("i", { staticClass: "icon-file-excel" }),
                  _vm._v(
                    "\n                        Excel\n                    "
                  ),
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
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "table-responsive" }, [
        _c(
          "table",
          { staticClass: "table table-sm table-stripeds border table-hover" },
          [
            _vm._m(1),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.reportsData, function (issue, key) {
                  return [
                    _c("tr", { key: key }, [
                      _c(
                        "td",
                        { staticClass: "p-2 pl-2 pr-2 text-capitalize" },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(issue.subject) +
                              "\n                            "
                          ),
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticClass: "p-2 pl-2 pr-2 text-capitalize" },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(issue.start_date) +
                              "\n                            "
                          ),
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticClass: "p-2 pl-2 pr-2 text-capitalize" },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(issue.due_date) +
                              "\n                            "
                          ),
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          issue.indicators[0] != null
                            ? [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      issue.indicators[0].indicator_field.name
                                    ) +
                                    "\n                                "
                                ),
                              ]
                            : _vm._e(),
                        ],
                        2
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticClass: "p-2 pl-2 pr-2 text-capitalize" },
                        [
                          issue.indicators[0] != null
                            ? [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      issue.indicators[0].indicator_field
                                        .indicator_issue_values.meta_type
                                    ) +
                                    "\n                                "
                                ),
                              ]
                            : _vm._e(),
                        ],
                        2
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticClass: "p-2 pl-2 pr-2 text-capitalize" },
                        [
                          issue.indicators[0] != null
                            ? [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      issue.indicators[0].indicator_field
                                        .indicator_issue_values.meta
                                    ) +
                                    "\n                                "
                                ),
                              ]
                            : _vm._e(),
                        ],
                        2
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticClass: "p-2 pl-2 pr-2 text-capitalize" },
                        [
                          issue.indicators[0] != null
                            ? [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      issue.indicators[0].indicator_field
                                        .indicator_issue_values.base_ref
                                    ) +
                                    "\n                                "
                                ),
                              ]
                            : _vm._e(),
                        ],
                        2
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticClass: "p-2 pl-2 pr-2 text-capitalize" },
                        [
                          issue.indicators[0] != null
                            ? [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      issue.indicators[0].indicator_field
                                        .indicator_issue_values.base_ref
                                    ) +
                                    "\n                                "
                                ),
                              ]
                            : _vm._e(),
                        ],
                        2
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticClass: "p-2 pl-2 pr-2 text-capitalize" },
                        [
                          issue.indicators[0] != null
                            ? [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      issue.indicators[0].indicator_field
                                        .indicator_issue_values.base_ref
                                    ) +
                                    "\n                                "
                                ),
                              ]
                            : _vm._e(),
                        ],
                        2
                      ),
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
                            attrs: { colspan: "8" },
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(_vm.__("lang.label_no_data")) +
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
      _c("h5", { staticClass: "fw-600" }, [_vm._v("Actividades por Projecto")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "table-active" }, [
      _c("th", [_vm._v("Designação")]),
      _vm._v(" "),
      _c("th", [_vm._v("Data Inicio")]),
      _vm._v(" "),
      _c("th", [_vm._v("Data Termino")]),
      _vm._v(" "),
      _c("th", [_vm._v("Indicador")]),
      _vm._v(" "),
      _c("th", [_vm._v("Tipo de meta")]),
      _vm._v(" "),
      _c("th", [_vm._v("Meta")]),
      _vm._v(" "),
      _c("th", [_vm._v("Base de Referencia")]),
      _vm._v(" "),
      _c("th", [_vm._v("Realizado (total)")]),
      _vm._v(" "),
      _c("th", [_vm._v("Percentual")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/reports/actividades_project.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/views/reports/actividades_project.vue ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _actividades_project_vue_vue_type_template_id_9fece54e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./actividades_project.vue?vue&type=template&id=9fece54e&scoped=true& */ "./resources/js/components/views/reports/actividades_project.vue?vue&type=template&id=9fece54e&scoped=true&");
/* harmony import */ var _actividades_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./actividades_project.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/reports/actividades_project.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _actividades_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _actividades_project_vue_vue_type_template_id_9fece54e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _actividades_project_vue_vue_type_template_id_9fece54e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "9fece54e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/reports/actividades_project.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/reports/actividades_project.vue?vue&type=script&lang=ts&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/actividades_project.vue?vue&type=script&lang=ts& ***!
  \************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_actividades_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./actividades_project.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividades_project.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_actividades_project_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/reports/actividades_project.vue?vue&type=template&id=9fece54e&scoped=true&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/actividades_project.vue?vue&type=template&id=9fece54e&scoped=true& ***!
  \******************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_actividades_project_vue_vue_type_template_id_9fece54e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./actividades_project.vue?vue&type=template&id=9fece54e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividades_project.vue?vue&type=template&id=9fece54e&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_actividades_project_vue_vue_type_template_id_9fece54e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_actividades_project_vue_vue_type_template_id_9fece54e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);