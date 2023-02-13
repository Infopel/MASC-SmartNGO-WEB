(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[8],{

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\ncircle[data-v-56befc93] {\n  stroke: black;\n  stroke-width: 1px;\n  fill: white !important;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=script&lang=ts&":
/*!******************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=script&lang=ts& ***!
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
  props: ["projects_pde"],

  mounted() {
    this.loadDataApi();
    this.getDataAprovementFlow();
  },

  beforeUpdate() {},

  data() {
    return {
      handler: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
      issueApprovements: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
      approvementFlows: [],
      year: new Date().getFullYear(),
      approvement_status: 'validated',
      start_date: null,
      end_date: null,
      isLoading: false,
      isApprovementFlowLoading: false,
      isError: false,
      projectPDE: [],
      project: null,
      projects: [],
      exportRoute: "export/actividades/approvement-flow/"
    };
  },

  methods: {
    /**
     * Limpar Filtros
     */
    limparFiltros() {
      this.start_date = null;
      this.end_date = null;
      this.approvement_status = 'validated';

      this.getDataAprovementFlow(this.project !== null)
    },

    formatBudget(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    async loadDataApi() {
      this.isLoading = true;
      await axios__WEBPACK_IMPORTED_MODULE_1___default.a
        .get("/reports/api/actividades/solicitacao/aprovacao")
        .then(response => {
          this.generateChart(response.data);
        })
        .catch(error => {
          console.error(error);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    async onProjectParent() {
      this.isLoading = true;
      await axios__WEBPACK_IMPORTED_MODULE_1___default.a
        .get(
          `/web/api/reports/activity/pde/${this.projectPDE.identifier}/projects`
        )
        .then(response => {
          this.projects = response.data.projects;
        })
        .catch(error => {
          alert(
            `Ocorreu um erro ao caregar os projetos 'filhos' da linha estratégica`
          );
          console.error({
            status: "Request failed",
            message:
              "Ocorreu um erro ao caregar os projetos 'filhos' da linha estratégica",
            error: error.message
          });
        })
        .then(() => {
          this.isLoading = false;
        });
    },
    async generateChart(data) {
      const options = {
        data: {
          json: data,
          type: "area",
          keys: {
            x: "mes",
            value: ["value"]
          }
        },
        point: {
          r: 0 // default is 2.5
        },
        axis: {
          x: {
            padding: {
              left: -0.47,
              right: -0.4
            },
            type: "category"
          }
        }
      };
      this.issueApprovements.$emit("init", options);
    },

    async getDataAprovementFlow(setFilter = false) {
      this.isApprovementFlowLoading = true;
      this.isLoading = true;
      let project_identifier = null;
      if (this.project !== null && setFilter) {
        project_identifier = this.project.identifier;
      }
      if (this.project == null && setFilter) {
        alert(
          "Status: Query Params Error\nMessage: Por favor selecione um projecto!"
        );
        this.isLoading = false;
        this.isApprovementFlowLoading = false;
        return;
      }

      return await axios__WEBPACK_IMPORTED_MODULE_1___default.a
        .get(
          `/web/api/reports/actividades/approvement-flow?setFilter=${setFilter}&project=${project_identifier}&year=${this.year}&start_date=${this.start_date}&end_date=${this.end_date}&status=${this.approvement_status}`
        )
        .then(response => {
          this.approvementFlows = response.data.approvementFlow;
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
          this.isApprovementFlowLoading = false;
          this.isLoading = false;
        });
    },

    async exportExcel() {
      this.isApprovementFlowLoading = true;
      let project_identifier = null;
      if (this.project !== null) {
        project_identifier = this.project.identifier;
      }
      if (this.project == null) {
        alert(
          "Status: Query Params Error\nMessage: Por favor selecione um projecto!"
        );
        this.isLoading = false;
        this.isApprovementFlowLoading = false;
        return;
      }

      window.location.href = `/web/api/reports/export/actividades/approvement-flow?setFilter=${true}&project=${project_identifier}&year=${
        this.year
      }&start_date=${this.start_date}&end_date=${this.end_date}`;

      this.isLoading = false;
      this.isApprovementFlowLoading = false;
    }
  }
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=template&id=56befc93&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=template&id=56befc93&scoped=true& ***!
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
  return _c("div", {}, [
    _c("div", { staticClass: "bg-white border p-3" }, [
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
              [_c("vue-c3", { attrs: { handler: _vm.issueApprovements } })],
              1
            ),
            _vm._v(" "),
            _c("div", { staticClass: "p-2 bg-light small" }, [
              _vm._v(
                "Este relatório apresenta dados da relação entre o número as atividades que passaram pelo processo de solicitação durante o mês."
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "table-responsive d-none" }, [
              _c(
                "table",
                {
                  staticClass:
                    "finances border table table-sm table-striped table-hover",
                },
                [
                  _vm._m(2),
                  _vm._v(" "),
                  _c("tbody", [
                    _c("tr", [
                      _c(
                        "td",
                        { staticClass: "text-center", attrs: { colspan: "4" } },
                        [_vm._v(_vm._s(_vm.__("lang.label_no_data")))]
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
            staticClass: "border-left pl-2 ml-3 d-none",
            staticStyle: { width: "250px" },
          },
          [
            _vm._m(3),
            _vm._v(" "),
            _c("div", { staticClass: "_filters d-none" }, [
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
                        "\n                " +
                          _vm._s(_vm.year) +
                          "\n                "
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
                        "\n                " +
                          _vm._s(_vm.start_date || "mm/dd/yyyy") +
                          "\n                "
                      ),
                      _c("i", { staticClass: "icon-arrow-down12" }),
                    ]),
                  ]
                ),
                _vm._v(" "),
                _vm._m(4),
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
                        "\n                " +
                          _vm._s(_vm.end_date || "mm/dd/yyyy") +
                          "\n                "
                      ),
                      _c("i", { staticClass: "icon-arrow-down12" }),
                    ]),
                  ]
                ),
                _vm._v(" "),
                _vm._m(5),
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
                        return _vm.getDataAprovementFlow(true)
                      },
                    },
                  },
                  [_vm._v("Submeter")]
                ),
              ]),
            ]),
          ]
        ),
      ]),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "mt-2 border bg-white p-3" }, [
      _c("div", { staticClass: "d-flex mb-2 border-bottom pb-2" }, [
        _c("div", { staticClass: "flex-grow-1" }, [
          _c("div", { staticClass: "align-items-baseline" }, [
            _c("div", { staticClass: "form-inline align-items-end" }, [
              _c("div", { staticClass: "w-25 mb-2 mr-2" }, [
                _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
                  _vm._v(
                    "Linhas Estratégicas (" +
                      _vm._s(_vm.projects_pde.length) +
                      ")"
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
                        [_vm._v(_vm._s(project.name))]
                      )
                    }),
                  ],
                  2
                ),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "w-50 mb-2" }, [
                _c("h6", { staticClass: "fw-600 m-0 text-muted" }, [
                  _vm._v("Projectos (" + _vm._s(_vm.projects.length) + ")"),
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
                          _vm.project = $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        },
                        function ($event) {
                          return _vm.getDataAprovementFlow(true)
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
                        [_vm._v(_vm._s(project.name))]
                      )
                    }),
                  ],
                  2
                ),
              ]),
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "mt-2 form-inline align-items-end",
                staticStyle: { "font-size": "95%" },
              },
              [
                _c("div", { staticClass: "mb-2 mr-2" }, [
                  _c("div", { staticClass: "flex-grow-1 text-muted" }, [
                    _vm._v("Estado da ultima aprovação"),
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-inline" }, [
                    _c("div", { staticClass: "input-group" }, [
                      _c("div", { staticClass: "pt-1 pl-2 pr-2" }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.approvement_status,
                              expression: "approvement_status",
                            },
                          ],
                          attrs: {
                            type: "radio",
                            id: "_approvement_status_pending",
                            value: "pending",
                            name: "_approvement_status",
                            "aria-label":
                              "Radio button for following text input",
                          },
                          domProps: {
                            checked: _vm._q(_vm.approvement_status, "pending"),
                          },
                          on: {
                            change: [
                              function ($event) {
                                _vm.approvement_status = "pending"
                              },
                              function ($event) {
                                return _vm.getDataAprovementFlow(
                                  _vm.project !== null
                                )
                              },
                            ],
                          },
                        }),
                      ]),
                      _vm._v(" "),
                      _c(
                        "label",
                        { attrs: { for: "_approvement_status_pending" } },
                        [_vm._v("Pendente")]
                      ),
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "input-group" }, [
                      _c("div", { staticClass: "pt-1 pl-2 pr-2" }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.approvement_status,
                              expression: "approvement_status",
                            },
                          ],
                          attrs: {
                            type: "radio",
                            id: "_approvement_status_valid",
                            value: "validated",
                            name: "_approvement_status",
                            "aria-label":
                              "Radio button for following text input",
                          },
                          domProps: {
                            checked: _vm._q(
                              _vm.approvement_status,
                              "validated"
                            ),
                          },
                          on: {
                            change: [
                              function ($event) {
                                _vm.approvement_status = "validated"
                              },
                              function ($event) {
                                return _vm.getDataAprovementFlow(
                                  _vm.project !== null
                                )
                              },
                            ],
                          },
                        }),
                      ]),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "text-success",
                          attrs: { for: "_approvement_status_valid" },
                        },
                        [_vm._v("Aprovado")]
                      ),
                    ]),
                  ]),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "mb-2 mr-2 ml-2" }, [
                  _c("div", { staticClass: "flex-grow-1 text-muted" }, [
                    _vm._v("Data Inicial:"),
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
                    staticClass: "form-control form-control-sm",
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
                _c("div", { staticClass: "mb-2 mr-2 ml-2" }, [
                  _c("div", { staticClass: "flex-grow-1 text-muted" }, [
                    _vm._v("Data Final:"),
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
                    staticClass: "form-control form-control-sm",
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
                _c("div", { staticClass: "mb-2 mr-2 ml-2" }, [
                  _c("div", { staticClass: "flex-grow-1 text-muted" }, [
                    _vm._v("Acção"),
                  ]),
                  _vm._v(" "),
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
                          staticClass: "btn btn-sm m-0 btn-success border",
                          on: {
                            click: function ($event) {
                              return _vm.getDataAprovementFlow(
                                _vm.project !== null
                              )
                            },
                          },
                        },
                        [
                          _c("i", { staticClass: "icon-search4 text-white" }),
                          _vm._v(
                            "\n                  Filtrar\n                "
                          ),
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-sm m-0 btn-light border",
                          on: {
                            click: function ($event) {
                              return _vm.limparFiltros()
                            },
                          },
                        },
                        [
                          _c("i", { staticClass: "icon-reset" }),
                          _vm._v(
                            "\n                  Limpar Filtro\n                "
                          ),
                        ]
                      ),
                    ]
                  ),
                ]),
              ]
            ),
          ]),
        ]),
        _vm._v(" "),
        _c("div", {}, [
          _c("div", { staticClass: "d-flex align-items-baseline" }, [
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
                      staticClass: "btn btn-sm m-0 btn-light border",
                      on: {
                        click: function ($event) {
                          return _vm.exportExcel()
                        },
                      },
                    },
                    [
                      _c("i", { staticClass: "icon-file-excel text-success" }),
                      _vm._v("\n                Excel\n              "),
                    ]
                  ),
                ]
              ),
            ]),
          ]),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "table-responsive" }, [
        _c(
          "table",
          {
            staticClass: "table border table-sm table-striped table-hover",
            staticStyle: { "font-size": "95%" },
          },
          [
            _c("thead", { staticClass: "table-active" }, [
              _c("th", [_vm._v("Cod. Requisicao")]),
              _vm._v(" "),
              _c("th", [_vm._v("Objectivo")]),
              _vm._v(" "),
              _c("th", [_vm._v("Data")]),
              _vm._v(" "),
              _c("th", [_vm._v("Orçamento")]),
              _vm._v(" "),
              _c("th", [_vm._v("Província")]),
              _vm._v(" "),
              _c("th", { staticClass: "text-nowrap" }, [
                _vm._v("Solicitado por"),
              ]),
              _vm._v(" "),
              _c("th", { staticClass: "text-nowrap" }, [_vm._v("Aprovação")]),
              _vm._v(" "),
              _vm.approvement_status !== "pending"
                ? _c("th", { staticClass: "text-nowrap" }, [
                    _vm._v("Categoria"),
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.approvement_status === "pending"
                ? _c("th", { staticClass: "text-nowrap" }, [
                    _vm._v("Por Validar"),
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.approvement_status === "pending"
                ? _c("th", { staticClass: "text-nowrap" }, [
                    _vm._v("Categoria"),
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c("th", { staticClass: "text-nowrap" }, [_vm._v("Estado")]),
              _vm._v(" "),
              _vm.approvement_status === "validated"
                ? _c("th", { staticClass: "text-nowrap" }, [_vm._v("Por")])
                : _vm._e(),
              _vm._v(" "),
              _vm.approvement_status === "validated"
                ? _c("th", { staticClass: "text-nowrap" }, [
                    _vm._v("Data aprovação"),
                  ])
                : _vm._e(),
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm.isApprovementFlowLoading ? [_vm._m(6)] : _vm._e(),
                _vm._v(" "),
                _vm.approvementFlows.length > 0
                  ? [
                      _vm._l(_vm.approvementFlows, function (approvement, key) {
                        return [
                          _c("tr", { key: key }, [
                            _c(
                              "td",
                              {
                                staticClass: "pl-2 p-1 pr-2",
                                attrs: { title: approvement.objectivo },
                              },
                              [
                                _c(
                                  "a",
                                  {
                                    attrs: {
                                      href:
                                        "/projects/" +
                                        approvement.project.identifier +
                                        "/orcamento/new/solicitacao-fundos/requisicao/" +
                                        approvement.num_requisicao,
                                    },
                                  },
                                  [_vm._v(_vm._s(approvement.num_requisicao))]
                                ),
                              ]
                            ),
                            _vm._v(" "),
                            _c("td", { staticClass: "pl-2 p-1 pr-2" }, [
                              _vm._v(_vm._s(approvement.objectivo)),
                            ]),
                            _vm._v(" "),
                            _c(
                              "td",
                              { staticClass: "pl-2 p-1 pr-2 text-nowrap" },
                              [_vm._v(_vm._s(approvement.created_on))]
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              { staticClass: "pl-2 p-1 pr-2 text-nowrap" },
                              [
                                _vm._v(
                                  _vm._s(
                                    _vm.formatBudget(approvement.valor_estimado)
                                  ) + " MZN"
                                ),
                              ]
                            ),
                            _vm._v(" "),
                            _c("td", { staticClass: "pl-2 p-1 pr-2" }, [
                              _vm._v(_vm._s(approvement.local)),
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "pl-2 p-1 pr-2" }, [
                              _vm._v(
                                _vm._s(
                                  approvement.request_by.firstname +
                                    " " +
                                    approvement.request_by.lastname
                                )
                              ),
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "pl-2 p-1 pr-2" }, [
                              _vm._v(
                                _vm._s(
                                  approvement.latest_aprovement.flow_description
                                )
                              ),
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "pl-2 p-1 pr-2" }, [
                              _c(
                                "button",
                                { staticClass: "btn btn-link p-0 text-nowrap" },
                                [
                                  _vm._v(
                                    "\n                    " +
                                      _vm._s(
                                        approvement.latest_aprovement.user
                                          .firstname +
                                          " " +
                                          approvement.latest_aprovement.user
                                            .lastname
                                      ) +
                                      "\n                  "
                                  ),
                                ]
                              ),
                            ]),
                            _vm._v(" "),
                            !approvement.latest_aprovement.is_approved
                              ? _c("td", { staticClass: "pl-2 p-1 pr-2" }, [
                                  _vm._v(
                                    "\n                  " +
                                      _vm._s(
                                        approvement.latest_aprovement
                                          .validator_category
                                      ) +
                                      "\n                "
                                  ),
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            approvement.latest_aprovement.is_approved
                              ? _c("td", [
                                  _c(
                                    "small",
                                    { staticClass: "bg-success p-1 rounded" },
                                    [_vm._v("Aprovado")]
                                  ),
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            !approvement.latest_aprovement.is_approved
                              ? _c("td", [
                                  _c(
                                    "small",
                                    { staticClass: "bg-danger p-1 rounded" },
                                    [_vm._v("Pendente")]
                                  ),
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.approvement_status === "validated"
                              ? _c("td", { staticClass: "pl-2 p-1 pr-2" }, [
                                  _vm._v(
                                    "\n                  " +
                                      _vm._s(
                                        approvement.latest_aprovement
                                          .is_approved
                                          ? approvement.latest_aprovement
                                              .approved_by.firstname +
                                              " " +
                                              approvement.latest_aprovement
                                                .approved_by.lastname
                                          : null
                                      ) +
                                      "\n                "
                                  ),
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            approvement.latest_aprovement.is_approved &&
                            _vm.approvement_status === "validated"
                              ? _c("td", { staticClass: "pl-2 p-1 pr-2" }, [
                                  _vm._v(
                                    _vm._s(
                                      approvement.latest_aprovement.approved_on
                                    )
                                  ),
                                ])
                              : _vm._e(),
                          ]),
                        ]
                      }),
                    ]
                  : _vm._e(),
                _vm._v(" "),
                _vm.approvementFlows.length === 0 &&
                !_vm.isApprovementFlowLoading
                  ? [
                      _c("tr", [
                        _c(
                          "td",
                          {
                            staticClass: "pl-2 p-1 pr-2 text-center fw-600",
                            attrs: { colspan: "10" },
                          },
                          [_vm._v(_vm._s("Nenhuma informação disponível"))]
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
    return _c("div", { staticClass: "d-flex align-items-baseline" }, [
      _c("div", { staticClass: "flex-grow-1" }, [
        _c("h5", { staticClass: "fw-500 mb-0" }, [
          _vm._v("Actividades vs Solicitação de Fundos"),
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
                _vm._v("\n                Excel\n              "),
              ]
            ),
            _vm._v(" "),
            _c("button", { staticClass: "btn btn-sm m-0 btn-light border" }, [
              _vm._v("Imprimir"),
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
            "\n              Relatório de Actividades Solicidatas -\n              "
          ),
          _c("i", [_vm._v("Aprovação de Fundos")]),
        ]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "table-active" }, [
      _c("th", { staticClass: "fw-600" }, [_vm._v("Projecto")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Actividade")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Criado em")]),
      _vm._v(" "),
      _c("th", { staticClass: "fw-600" }, [_vm._v("Aprovado em")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "h5",
      { staticClass: "border-bottom btn w-100 text-left fw-600 pl-1" },
      [_c("i", { staticClass: "icon-arrow-up5" }), _vm._v("FILTROS\n        ")]
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
      [
        _c(
          "li",
          {
            staticClass:
              "dropdown-item cursor-pointer text-center rounded bg-light mt-1",
          },
          [_vm._v("Fechar")]
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
      [
        _c(
          "li",
          {
            staticClass:
              "dropdown-item cursor-pointer text-center rounded bg-light mt-1",
          },
          [_vm._v("Fechar")]
        ),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c(
        "td",
        { staticClass: "text-center fw-600", attrs: { colspan: "10" } },
        [
          _c("i", { staticClass: "icon-spinner spinner" }),
          _vm._v(" Carregando dados...\n              "),
        ]
      ),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/reports/actividade_approvements.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/views/reports/actividade_approvements.vue ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _actividade_approvements_vue_vue_type_template_id_56befc93_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./actividade_approvements.vue?vue&type=template&id=56befc93&scoped=true& */ "./resources/js/components/views/reports/actividade_approvements.vue?vue&type=template&id=56befc93&scoped=true&");
/* harmony import */ var _actividade_approvements_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./actividade_approvements.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/reports/actividade_approvements.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _actividade_approvements_vue_vue_type_style_index_0_id_56befc93_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css& */ "./resources/js/components/views/reports/actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _actividade_approvements_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _actividade_approvements_vue_vue_type_template_id_56befc93_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _actividade_approvements_vue_vue_type_template_id_56befc93_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "56befc93",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/reports/actividade_approvements.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/reports/actividade_approvements.vue?vue&type=script&lang=ts&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/actividade_approvements.vue?vue&type=script&lang=ts& ***!
  \****************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./actividade_approvements.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/reports/actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css&":
/*!************************************************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css& ***!
  \************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_style_index_0_id_56befc93_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=style&index=0&id=56befc93&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_style_index_0_id_56befc93_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_style_index_0_id_56befc93_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_style_index_0_id_56befc93_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_style_index_0_id_56befc93_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/views/reports/actividade_approvements.vue?vue&type=template&id=56befc93&scoped=true&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/views/reports/actividade_approvements.vue?vue&type=template&id=56befc93&scoped=true& ***!
  \**********************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_template_id_56befc93_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./actividade_approvements.vue?vue&type=template&id=56befc93&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/reports/actividade_approvements.vue?vue&type=template&id=56befc93&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_template_id_56befc93_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_actividade_approvements_vue_vue_type_template_id_56befc93_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);