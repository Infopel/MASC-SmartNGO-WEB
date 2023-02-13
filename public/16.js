(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[16],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/index.vue?vue&type=script&lang=ts&":
/*!**************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/dashboard/index.vue?vue&type=script&lang=ts& ***!
  \**************************************************************************************************************************************/
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
    VueC3: (vue_c3__WEBPACK_IMPORTED_MODULE_2___default()),
  },
  created() {
    this.initDashboard();
    this.isLoading = true;
  },
  data() {
    return {
      my_tasks: 0,
      assigned_tasks: 0,
      contribution_margin: 0,
      handler: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
      taskCompletion: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
      taskOverview: [],
      tasksToReport: [],
      recent_activities: [],
      assignedTasks: [],
      issuesToApprove: [],
      unapprovedBudgetRequest: [],
      myBudgetRequestProcesses: [],
      dashboard_endpoint: "/web/api/dashboard",
      isLoading: false,
      isLoadingData: false,
    };
  },
  mounted() {
    this.isLoading = true;
    const options = {
      data: {
        url: "/web/api/dashboard/datagraph",
        mimeType: "json",
        type: "donut",
        colors: {
          "Em Curso": "#f3e144",
          Planificadas: "#2d96ff",
          Concluídas: "#00cb96",
        },
        labels: false,
        // keys: {
        //     value: ['Abertas', 'Fechadas']
        // }
      },
      grid: {
        y: {
          show: false,
        },
      },
      transition: { duration: 1000 },
      legend: {
        show: false,
      },
    };
    this.handler.$emit("init", options);
    this.isLoading = false;
  },

  methods: {
    async initDashboard() {
      this.isLoadingData = true;
      await axios__WEBPACK_IMPORTED_MODULE_1___default()(this.dashboard_endpoint)
        .then((response) => {
          this.taskOverview = response.data.taskOverview;

          this.my_tasks = response.data.my_tasks;
          this.assigned_tasks = response.data.assigned_tasks;
          this.contribution_margin = response.data.contribution_margin;

          this.recent_activities = response.data.recent_activities;

          this.tasksToReport = response.data.tasksToReport;
          console.log(this.tasksToReport);

          this.assignedTasks = response.data.assignedTasks;
          this.issuesToApprove = response.data.issuesToApprove;


          this.myBudgetRequestProcesses = response.data.myBudgetRequestProcesses;
          this.isLoadingData = false;
        })
        .catch((error) => {
          this.isLoadingData = false;
          console.error("----- Error while loading dashboard data --------\n");
          console.error(error);
        });
    },

    async initDashboard_2() {},
  },

}));


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/index.vue?vue&type=template&id=12c347bb&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/dashboard/index.vue?vue&type=template&id=12c347bb&scoped=true& ***!
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
  return _c("div", { staticClass: "row m-1 ml-lg-5 mr-lg-5" }, [
    _c("div", { staticClass: "col-12 containers mt-1 p-1" }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-8 col-lg-9" }, [
          _c("div", { staticClass: "row mb-3 text-center" }, [
            _c("div", { staticClass: "col-md-3 mb-2 mb-lg-0" }, [
              _c("div", { staticClass: "bg-white border rounded shadow-sm" }, [
                _c("div", { staticClass: "mt-4 mb-4" }, [
                  _c("h3", { staticClass: "text-semibold no-margin" }, [
                    _vm._v(
                      "\n                  " +
                        _vm._s(_vm.my_tasks) +
                        "\n                "
                    ),
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "text-muted" }, [
                    _vm._v("Minhas Actividades"),
                  ]),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-3 mb-2 mb-lg-0" }, [
              _c("div", { staticClass: "bg-white border rounded shadow-sm" }, [
                _c("div", { staticClass: "mt-4 mb-4" }, [
                  _c("h3", { staticClass: "text-semibold no-margin" }, [
                    _vm._v(
                      "\n                  " +
                        _vm._s(_vm.assigned_tasks) +
                        "\n                "
                    ),
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "text-muted" }, [
                    _vm._v("Actividades por reportar"),
                  ]),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-3 mb-2 mb-lg-0" }, [
              _c("div", { staticClass: "bg-white border rounded shadow-sm" }, [
                _c("div", { staticClass: "mt-4 mb-4" }, [
                  _c("h3", { staticClass: "text-semibold no-margin" }, [
                    _vm._v(
                      "\n                  " +
                        _vm._s(_vm.issuesToApprove.length) +
                        "\n                "
                    ),
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "text-muted" }, [
                    _vm._v("Fundos por Aprovar"),
                  ]),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-3 mb-2 mb-lg-0" }, [
              _c("div", { staticClass: "bg-white border rounded shadow-sm" }, [
                _c("div", { staticClass: "mt-4 mb-4" }, [
                  _c("h3", { staticClass: "text-semibold no-margin" }, [
                    _vm._v(
                      "\n                  " + _vm._s(0) + "\n                "
                    ),
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "text-muted" }, [
                    _vm._v("Act. Por Validar o report"),
                  ]),
                ]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-12 mb-3" }, [
              _c(
                "div",
                {
                  staticClass: "card-block shadow-sm border bg-white p-3",
                  staticStyle: { "min-height": "380px" },
                },
                [
                  _vm._m(0),
                  _vm._v(" "),
                  _vm._m(1),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "tab-content",
                      attrs: { id: "nav-tabContent" },
                    },
                    [
                      _c(
                        "div",
                        {
                          staticClass: "tab-pane fade show active",
                          attrs: {
                            id: "nav-Aprovadas",
                            role: "tabpanel",
                            "aria-labelledby": "nav-Solic-Aprovadas",
                          },
                        },
                        [
                          _c("div", { staticClass: "table-responsive" }, [
                            _c("div", { staticClass: "table-responsive" }, [
                              _c(
                                "table",
                                {
                                  staticClass: "table table-sm",
                                  staticStyle: { "font-size": "93%" },
                                },
                                [
                                  _vm._m(2),
                                  _vm._v(" "),
                                  _c(
                                    "tbody",
                                    [
                                      _vm.issuesToApprove
                                        ? _vm._l(
                                            _vm.issuesToApprove,
                                            function (issue, key) {
                                              return _c("tr", { key: key }, [
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-nowrap",
                                                    attrs: {
                                                      title:
                                                        "Solicitado em/(a)",
                                                    },
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                " +
                                                        _vm._s(issue._time) +
                                                        "\n                              "
                                                    ),
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-nowrap",
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                " +
                                                        _vm._s(
                                                          issue.request_by
                                                            .firstname +
                                                            " " +
                                                            issue.request_by
                                                              .lastname
                                                        ) +
                                                        "\n                              "
                                                    ),
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c("td", [
                                                  _c(
                                                    "a",
                                                    {
                                                      attrs: {
                                                        href:
                                                          issue.solicitacao
                                                            .project.route +
                                                          "/orcamento/new/solicitacao-fundos/requisicao/" +
                                                          issue.num_requisicao,
                                                      },
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                  " +
                                                          _vm._s(
                                                            issue.solicitacao
                                                              .objectivo
                                                          ) +
                                                          "\n                                "
                                                      ),
                                                    ]
                                                  ),
                                                ]),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-nowrap",
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                " +
                                                        _vm._s(
                                                          issue.flow_description
                                                        ) +
                                                        "\n                              "
                                                    ),
                                                  ]
                                                ),
                                              ])
                                            }
                                          )
                                        : _vm._e(),
                                      _vm._v(" "),
                                      _vm.issuesToApprove.length === 0
                                        ? _c("tr", [
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "p-1 text-center bg-light",
                                                attrs: { colspan: "5" },
                                              },
                                              [
                                                _vm._v(
                                                  "\n                              " +
                                                    _vm._s(
                                                      _vm.__(
                                                        "lang.label_no_data"
                                                      )
                                                    ) +
                                                    "\n                            "
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
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "tab-pane fade",
                          attrs: {
                            id: "nav-Reporvadas",
                            role: "tabpanel",
                            "aria-labelledby": "nav-Solic-Reporvadas",
                          },
                        },
                        [
                          _c("div", { staticClass: "table-responsive" }, [
                            _c(
                              "table",
                              {
                                staticClass: "table table-sm",
                                staticStyle: { "font-size": "93%" },
                              },
                              [
                                _vm._m(3),
                                _vm._v(" "),
                                _vm.myBudgetRequestProcesses
                                  ? _vm._l(
                                      _vm.myBudgetRequestProcesses,
                                      function (request, key) {
                                        return _c("tr", { key: key }, [
                                          _c(
                                            "td",
                                            {
                                              attrs: {
                                                title: "Solicitado em/(a)",
                                              },
                                            },
                                            [
                                              !request.is_approved &&
                                              !request.is_rejected
                                                ? _c(
                                                    "span",
                                                    {
                                                      staticClass:
                                                        "badge rounded-0 p-1 bg-warning border-0 text-black-50",
                                                    },
                                                    [_vm._v("Pendente")]
                                                  )
                                                : _vm._e(),
                                              _vm._v(" "),
                                              !request.is_approved &&
                                              request.is_rejected
                                                ? _c(
                                                    "span",
                                                    {
                                                      staticClass:
                                                        "badge rounded-0 p-1 badge-danger",
                                                    },
                                                    [_vm._v("Reprovado")]
                                                  )
                                                : _vm._e(),
                                              _vm._v(" "),
                                              request.is_approved &&
                                              !request.is_rejected
                                                ? _c(
                                                    "span",
                                                    {
                                                      staticClass:
                                                        "badge rounded-0 p-1 badge-success",
                                                    },
                                                    [_vm._v("Aprovado")]
                                                  )
                                                : _vm._e(),
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-nowrap",
                                              attrs: {
                                                title:
                                                  "Referencia da requisição",
                                              },
                                            },
                                            [
                                              _c(
                                                "a",
                                                {
                                                  attrs: {
                                                    href: "" + request.route,
                                                  },
                                                },
                                                [
                                                  _vm._v(
                                                    "\n                                " +
                                                      _vm._s(
                                                        request.num_requisicao
                                                      ) +
                                                      "\n                              "
                                                  ),
                                                ]
                                              ),
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-nowrap",
                                              attrs: { title: "Projecto" },
                                            },
                                            [
                                              _c(
                                                "a",
                                                {
                                                  attrs: {
                                                    href:
                                                      "" +
                                                      request.solicitacao
                                                        .project.route,
                                                  },
                                                },
                                                [
                                                  _vm._v(
                                                    "\n                                " +
                                                      _vm._s(
                                                        request.solicitacao
                                                          .project.name
                                                      ) +
                                                      "\n                              "
                                                  ),
                                                ]
                                              ),
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "td",
                                            {
                                              attrs: {
                                                title: "Data de requisição",
                                              },
                                            },
                                            [
                                              _vm._v(
                                                "\n                              " +
                                                  _vm._s(request.created_on) +
                                                  "\n                            "
                                              ),
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "td",
                                            {
                                              staticClass:
                                                "text-wrap text-truncate width-400",
                                              attrs: { title: "Objectivo" },
                                            },
                                            [
                                              _vm._v(
                                                "\n                            " +
                                                  _vm._s(
                                                    request.solicitacao
                                                      .objectivo
                                                  ) +
                                                  "\n                            "
                                              ),
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "td",
                                            {
                                              attrs: {
                                                title:
                                                  "Fase actual de aprovação",
                                              },
                                            },
                                            [
                                              _vm._v(
                                                "\n                              " +
                                                  _vm._s(
                                                    request.flow_description
                                                  ) +
                                                  "\n                            "
                                              ),
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "td",
                                            {
                                              staticClass: "link-option",
                                              attrs: {
                                                title:
                                                  "Categoria do usuario a aprovar",
                                              },
                                            },
                                            [
                                              _vm._v(
                                                "\n                              " +
                                                  _vm._s(
                                                    request.validator_category
                                                  ) +
                                                  "\n                            "
                                              ),
                                            ]
                                          ),
                                        ])
                                      }
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                _vm.myBudgetRequestProcesses.length === 0
                                  ? _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass:
                                            "p-1 text-center bg-light",
                                          attrs: { colspan: "7" },
                                        },
                                        [
                                          _vm._v(
                                            "\n                            " +
                                              _vm._s(
                                                _vm.__("lang.label_no_data") ||
                                                  "Nenhuma informação disponível"
                                              ) +
                                              "\n                          "
                                          ),
                                        ]
                                      ),
                                    ])
                                  : _vm._e(),
                              ],
                              2
                            ),
                          ]),
                        ]
                      ),
                    ]
                  ),
                ]
              ),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-4 col-lg-3 mb-3 pl-2 pr-0" }, [
          _c("div", { staticClass: "card-block shadow-sm p-3 h-auto" }, [
            _vm._m(4),
            _vm._v(" "),
            _c(
              "div",
              {},
              [_c("vue-c3", { attrs: { handler: _vm.handler } })],
              1
            ),
            _vm._v(" "),
            _vm.taskOverview
              ? _c("div", { staticClass: "d-flex" }, [
                  _c("div", { staticClass: "flex-grow-1 text-center p-2" }, [
                    _c("div", {
                      staticClass: "m-2 w-25 mr-auto ml-auto",
                      staticStyle: { "border-top": "3px solid #2d96ff" },
                    }),
                    _vm._v(" "),
                    _c("h3", { staticClass: "mb-0" }, [
                      _vm._v(_vm._s(_vm.taskOverview.opened)),
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "c3-legend-item text-black-50 fw-500" },
                      [_vm._v("\n                Planificadas\n              ")]
                    ),
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "flex-grow-1 text-center p-2" }, [
                    _c("div", {
                      staticClass: "m-2 w-25 mr-auto ml-auto",
                      staticStyle: { "border-top": "3px solid #f3e144" },
                    }),
                    _vm._v(" "),
                    _c("h3", { staticClass: "mb-0" }, [
                      _vm._v(_vm._s(_vm.taskOverview.in_progress)),
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "c3-legend-item text-black-50 fw-500" },
                      [_vm._v("\n                Em Curso\n              ")]
                    ),
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "flex-grow-1 text-center p-2" }, [
                    _c("div", {
                      staticClass: "m-2 w-25 mr-auto ml-auto",
                      staticStyle: { "border-top": "3px solid #00cb96" },
                    }),
                    _vm._v(" "),
                    _c("h3", { staticClass: "mb-0" }, [
                      _vm._v(_vm._s(_vm.taskOverview.closed)),
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "c3-legend-item text-black-50 fw-500" },
                      [_vm._v("\n                Concluídas\n              ")]
                    ),
                  ]),
                ])
              : _vm._e(),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mb-4" }, [
          _vm._m(5),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-12 mb-3" }, [
            _c(
              "div",
              {
                staticClass: "card-block shadow-sm p-3",
                staticStyle: { "min-height": "380px" },
              },
              [
                _vm._m(6),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "table-responsive" },
                  [
                    _c(
                      "table",
                      {
                        staticClass:
                          "table table-sm table-hover table-striped border datatable-show-all",
                      },
                      [
                        _vm._m(7),
                        _vm._v(" "),
                        _c(
                          "tbody",
                          [
                            _vm.tasksToReport.length > 0
                              ? _vm._l(
                                  _vm.tasksToReport,
                                  function (report, key) {
                                    return _c("tr", { key: key }, [
                                      _c(
                                        "td",
                                        {
                                          staticClass:
                                            "justify-content-center align-content-center d-flex",
                                        },
                                        [
                                          _c(
                                            "a",
                                            {
                                              staticClass:
                                                "btn btn-sm m-0 btn-light my_shadow border link-option",
                                              attrs: {
                                                href: report.issue.route,
                                              },
                                            },
                                            [_vm._v("Aprovar")]
                                          ),
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticStyle: {
                                            "max-width": "220px",
                                            "white-space": "nowrap",
                                            overflow: "hidden",
                                            "text-overflow": "ellipsis",
                                          },
                                          attrs: { title: report.time_entrie },
                                        },
                                        [
                                          _vm._v(
                                            "\n                          " +
                                              _vm._s(
                                                report.issue.project.name
                                              ) +
                                              "\n                        "
                                          ),
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticStyle: {
                                            "max-width": "220px",
                                            "white-space": "nowrap",
                                            overflow: "hidden",
                                            "text-overflow": "ellipsis",
                                          },
                                        },
                                        [
                                          _vm._v(
                                            "\n                          " +
                                              _vm._s(report.issue.subject) +
                                              "\n                        "
                                          ),
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c("td", [
                                        _vm._v(
                                          "\n                          " +
                                            _vm._s(
                                              report.request_by.full_name
                                            ) +
                                            "\n                        "
                                        ),
                                      ]),
                                      _vm._v(" "),
                                      _c("td", [
                                        _vm._v(
                                          "\n                          " +
                                            _vm._s(report.issue.start_date) +
                                            "\n                        "
                                        ),
                                      ]),
                                      _vm._v(" "),
                                      _c("td", [
                                        _vm._v(
                                          "\n                          " +
                                            _vm._s(report.issue.due_date) +
                                            "\n                        "
                                        ),
                                      ]),
                                    ])
                                  }
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.tasksToReport.length == 0
                              ? _c("tr", [
                                  _c(
                                    "td",
                                    {
                                      staticClass:
                                        "p-1 text-center border-bottom cursor-default",
                                      attrs: { colspan: "8" },
                                    },
                                    [
                                      _vm._v(
                                        "\n                      " +
                                          _vm._s(
                                            _vm.__("lang.label_no_data") ||
                                              "Nenhuma informação disponível"
                                          ) +
                                          "\n                    "
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
                    _vm._v(" "),
                    _vm.isLoading
                      ? [_c("center", [_vm._v("Carregando...")])]
                      : _vm._e(),
                  ],
                  2
                ),
              ]
            ),
          ]),
        ]),
      ]),
    ]),
    _vm._v(" "),
    _vm.isLoadingData
      ? _c("div", { attrs: { id: "loading-indicator" } }, [
          _c("i", { staticClass: "icon-spinner spinner" }),
          _vm._v(" "),
          _c("span", [_vm._v("Carregando dados...")]),
        ])
      : _vm._e(),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "title-card bg-light p-2 mb-1 rounded" }, [
      _c("div", {}, [
        _c("h6", { staticClass: "mb-0" }, [
          _c(
            "a",
            {
              staticClass: "text-slate-800",
              attrs: { href: "#BudgetRequest" },
            },
            [
              _c("i", { staticClass: "icon-stack3 text-slate-400" }),
              _vm._v(" "),
              _c("span", { staticClass: "text-slate-800" }, [
                _vm._v("Solicitação de Fundos"),
              ]),
            ]
          ),
        ]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("nav", [
      _c(
        "div",
        {
          staticClass: "nav nav-tabs pb-0 mb-1",
          attrs: { id: "nav-tab", role: "tablist" },
        },
        [
          _c(
            "a",
            {
              staticClass: "nav-item nav-link link-option active",
              attrs: {
                id: "nav-Solic-Aprovadas",
                "data-toggle": "tab",
                href: "#nav-Aprovadas",
                role: "tab",
                "aria-controls": "nav-Aprovadas",
                "aria-selected": "true",
              },
            },
            [_vm._v("Por Aprovar")]
          ),
          _vm._v(" "),
          _c(
            "a",
            {
              staticClass: "nav-item nav-link link-option",
              attrs: {
                id: "nav-Solic-Reporvadas",
                "data-toggle": "tab",
                href: "#nav-Reporvadas",
                role: "tab",
                "aria-controls": "nav-Reporvadas",
                "aria-selected": "true",
              },
            },
            [_vm._v("Minhas solicitações")]
          ),
        ]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "bg-red-500 bg-slate-800" }, [
      _c(
        "th",
        {
          staticClass: "text-center text-nowrap",
          attrs: { title: "Solicitado em/(a)" },
        },
        [
          _c("i", { staticClass: "icon-calendar2" }),
          _vm._v("Data\n                          "),
        ]
      ),
      _vm._v(" "),
      _c("th", { staticClass: "text-center text-nowrap" }, [
        _c("i", { staticClass: "icon-user" }),
        _vm._v("Solic. Por"),
      ]),
      _vm._v(" "),
      _c("th", [_vm._v("Objectivo")]),
      _vm._v(" "),
      _c("th", [_vm._v("Cat. Aprovação")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "bg-slate-700" }, [
      _c("th", [_vm._v("Estado")]),
      _vm._v(" "),
      _c("th", [_vm._v("#Ref Requisição")]),
      _vm._v(" "),
      _c("th", [_vm._v("Projecto")]),
      _vm._v(" "),
      _c("th", { staticClass: "text-nowrap" }, [_vm._v("Data de requisição")]),
      _vm._v(" "),
      _c("th", [_vm._v("Objectivo")]),
      _vm._v(" "),
      _c("th", { staticClass: "text-nowrap" }, [
        _vm._v("Fase aprovação actual"),
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "text-nowrap" }, [_vm._v("User p/ validar")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "title-card border-bottom" }, [
      _c("h6", [
        _c("a", { staticClass: "text-slate-800", attrs: { href: "#" } }, [
          _c("span", [_vm._v("Visão geral de tarefas")]),
        ]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "mb-2 ml-3 text-black-50" }, [
      _c("h4", [_vm._v("Aprovação do Plano de Actividades")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "title-card bg-light p-2 mb-1 rounded" }, [
      _c("div", {}, [
        _c("h6", { staticClass: "mb-0" }, [
          _c(
            "a",
            { staticClass: "text-slate-800", attrs: { href: "#ReportIssues" } },
            [
              _c("i", { staticClass: "icon-stack3 text-slate-400" }),
              _vm._v(" "),
              _c("span", [_vm._v("Actividades por validar ")]),
            ]
          ),
        ]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "bg-slate-700" }, [
      _c("th", { staticClass: "text-center" }, [_vm._v("-")]),
      _vm._v(" "),
      _c("th", [_vm._v("Projecto")]),
      _vm._v(" "),
      _c("th", [_vm._v("Actividade")]),
      _vm._v(" "),
      _c("th", [_vm._v("Alocado Por")]),
      _vm._v(" "),
      _c("th", [_vm._v("Data de cadastro")]),
      _vm._v(" "),
      _c("th", [_vm._v("Deadline")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/dashboard/index.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/views/dashboard/index.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_vue_vue_type_template_id_12c347bb_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=12c347bb&scoped=true& */ "./resources/js/components/views/dashboard/index.vue?vue&type=template&id=12c347bb&scoped=true&");
/* harmony import */ var _index_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/dashboard/index.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _index_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _index_vue_vue_type_template_id_12c347bb_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _index_vue_vue_type_template_id_12c347bb_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "12c347bb",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/dashboard/index.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/dashboard/index.vue?vue&type=script&lang=ts&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/views/dashboard/index.vue?vue&type=script&lang=ts& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./index.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/index.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/dashboard/index.vue?vue&type=template&id=12c347bb&scoped=true&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/views/dashboard/index.vue?vue&type=template&id=12c347bb&scoped=true& ***!
  \******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_12c347bb_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./index.vue?vue&type=template&id=12c347bb&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/index.vue?vue&type=template&id=12c347bb&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_12c347bb_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_12c347bb_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);