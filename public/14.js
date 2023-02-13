(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[14],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/budget.vue?vue&type=script&lang=ts&":
/*!***************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/dashboard/budget.vue?vue&type=script&lang=ts& ***!
  \***************************************************************************************************************************************/
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
        this.initDashboard(),
        this.getProjects()
    },
    data () {
        return {
            handler: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            BudgetG_1: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            BudgetG_2: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            BudgetG_3: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            BudgetG_4: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            BudgetG_1_loading: true,
            BudgetG_2_loading: true,
            BudgetG_3_loading: true,
            BudgetG_4_loading: true,
            dashboard_endpoint: '/api/dashboard',

            projects_endpoind: '/api/projects',
            projects: [],
            selectedProject: null,

            projectBudget_endpoind: '/api/projects/id/',
            projectBudget: [],
            subProjectBudget: [],
            subProjectBudget_column_data: []
        }
    },
    mounted () {
        this.initBudgetG_1(),
        this.initBudgetG_2(null)
        this.initBudgetG_3(null)
        this.initBudgetG_4(null)
    },
    methods:{
        async initDashboard(){
            axios__WEBPACK_IMPORTED_MODULE_1___default()(this.dashboard_endpoint)
            .then(response=>{

            })
            .catch(error =>{
                console.log("----- Error on Loading data -------");
                console.log(error);
            })
        },

        async getProjects(){
            axios__WEBPACK_IMPORTED_MODULE_1___default()(this.projects_endpoind)
                .then(response=>{
                    this.projects = response.data.projects;
                })
                .catch(error =>{
                    console.log(" ----- Error detected on loading data -----")
                    console.log(error)
                })
        },

        async getProjectsBuget(project_id){
            axios__WEBPACK_IMPORTED_MODULE_1___default()(this.projectBudget_endpoind+project_id)
                .then(response=>{
                    this.projectBudget = response.data.projectBugdet;
                    this.initBudgetG_2(this.projectBudget);
                    this.BudgetG_2_loading = false
                })
                .catch(error =>{
                    console.log(" ----- Error detected on loading data -----")
                    console.log(error)
                })
        },

        onSelectProj(event){
            this.getProjectsBuget(this.selectedProject.id);
        },

        async initBudgetG_1(){
            const options = {
                padding: {
                    right: -150,
                    left: 100,
                },
                data: {
                    columns: [
                        // ['Orcamento', 3985],
                        ['Valor Gasto', 2785],
                    ],
                    type: 'gauge',
                    labels: false
                },
                color: {
                    pattern: ['#89b53c', '#FF2D62']
                },
                gauge: {
                    // label: {
                    //     format: function(value, ratio) {
                    //         return value + " MZN";
                    //     },
                    //     show: false // to turn off the min/max labels.
                    // },
                    min: 0, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
                    max: 3985, // 100 is default
                    // units: ' ',
                    width: 35 // for adjusting arc thickness
                },
                size: {
                    height: 200
                },
                tooltip: {
                    format: {
                        value: function (value, ratio, id, index) {
                            return value.toLocaleString('en')+" MZN";
                        }
                    }
                }
            }
            this.BudgetG_1_loading = false
            this.BudgetG_1.$emit('init', options)

        },
        async initBudgetG_2(projectBudget){
            if(this.projectBudget.childsBudget){
                this.subProjectBudget_column_data = [];
                projectBudget.childsBudget.forEach(project => {
                    this.subProjectBudget_column_data[project.name] = project.budget;
                })
            }
            console.log(this.subProjectBudget_column_data)
            const options = {
                data:{
                    json: this.subProjectBudget_column_data,
                    type:'pie',
                    labels: true
                },
                color: {
                    pattern: ['#f84004', '#f7b925','#00cd99', '#008b69','#5252f7', '#008b69', '#98df8a', '#d62728', '#ff9896', '#9467bd', '#c5b0d5', '#8c564b', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#c7c7c7', '#bcbd22', '#dbdb8d', '#17becf', '#9edae5']
                },
                pie:{

                },
                tooltip: {
                    format: {
                        value: function (value, ratio, id, index) {
                            return value.toLocaleString('en')+" MZN";
                        }
                    }
                },
                transition: {
                    duration: 100
                }
            }
            this.BudgetG_2.$emit('init', options)
        },
        async initBudgetG_3(projectBudget = null){

            const options = {
                data:{
                    columns:[
                        ['x', 'Actividades Fechadas', 'Actividades Abertas', 'Actividades Em progresso','Actividades Resolvidas'],
                        ['Act. Status', 78, 58, 48, 78],
                    ],
                    x: 'x',
                    labels: true,
                    type: "bar",
                    legend:{
                        show: false
                    }
                },
                color: {
                    pattern: ['#5252f7', '#f84004', '#f7b925', '#00cd99', '#008b69', '#008b69', '#98df8a', '#d62728', '#ff9896', '#9467bd', '#c5b0d5', '#8c564b', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#c7c7c7', '#bcbd22', '#dbdb8d', '#17becf', '#9edae5']
                },
                bar: {
                    width: {
                        ratio: .55
                    },
                },
                axis: {
                    rotated: true,
                    x: {
                        type: 'category',
                        tick: {
                            multiline: true
                        }
                    }
                },
                tooltip:{
                    format: function (value, ratio, id, index){
                        return value.toLocaleString('en')+" MZN";
                    }
                }
            }
            this.BudgetG_3.$emit('init', options);
            this.BudgetG_3_loading = false
        },

        async initBudgetG_4(projectBudget= null){
            const options = {
                data:{
                    type: 'bar',
                    columns:[
                        ['Orçamento', 698, 1684, 4987,6987],
                        ['Valor Gasto', 385, 487, 564,5687],
                    ],
                    legend:{
                        show: false
                    }
                },
                color: {
                    pattern: ['#5252f7 ', '#00cd99', '#f7b925']
                    // pattern: ['#F44336 ', '#f7b925', '#f7b925']
                },
                bar:{
                    width:{
                        ratio: .28
                    },
                    // space: 0.25
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: ['08 Dezembro 2019', '10 Dezembro 2019', '11 Dezembro 2019', '12 Dezembro 2019', '13 Dezembro 2019', '14 Dezembro 2019'],
                        padding: {
                            left: -0.33,
                            right: -0.33,
                        },
                        tick:{
                            multiline: true
                        },
                        show: true,
                    },
                    y: {
                        show: true
                    }
                },
                tooltip: {
                    format: {
                        value: function (value, ratio, id, index) {
                            return value.toLocaleString('en')+" MZN";
                        }
                    }
                },
                transition: {
                    duration: 100
                }
            }
            this.BudgetG_4.$emit('init', options);
            this.BudgetG_4_loading = false
        }
    },
}));



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/budget.vue?vue&type=template&id=1ac687a8&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/dashboard/budget.vue?vue&type=template&id=1ac687a8&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "col-md-12 mt-1 p-1" }, [
      _c("div", { staticClass: "mb-3 p-2 bg-white" }, [
        _c("div", { staticClass: "d-flex" }, [
          _c("div", { staticClass: "flex-grow-1 p-1" }, [
            _c("h5", { staticClass: "mb-0" }, [_vm._v("Projecto:")]),
            _vm._v(" "),
            _vm.selectedProject
              ? _c("span", [_vm._v(_vm._s(_vm.selectedProject.name))])
              : _vm._e(),
            _vm._v(" "),
            !_vm.selectedProject
              ? _c("span", [_vm._v("Select a project...")])
              : _vm._e(),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "p-1 col-md-3" }, [
            _c(
              "select",
              {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.selectedProject,
                    expression: "selectedProject",
                  },
                ],
                staticClass: "form-control",
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
                      _vm.selectedProject = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    },
                    function ($event) {
                      return _vm.onSelectProj($event)
                    },
                  ],
                },
              },
              [
                _c("option", [_vm._v("Select a project...")]),
                _vm._v(" "),
                _vm._l(_vm.projects, function (project) {
                  return _c(
                    "option",
                    {
                      key: project.id,
                      attrs: { project: project.name },
                      domProps: { value: project },
                    },
                    [_vm._v(_vm._s(project.name))]
                  )
                }),
              ],
              2
            ),
          ]),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-12 col-lg-12" }, [
          _c("div", { staticClass: "row mb-3" }, [
            _c("div", { staticClass: "col-md-6 mb-3" }, [
              _c("div", { staticClass: "card-block p-3" }, [
                _vm._m(0),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _vm._m(1),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("vue-c3", { attrs: { handler: _vm.BudgetG_1 } }),
                      _vm._v(" "),
                      _vm.BudgetG_1_loading
                        ? _c(
                            "div",
                            {
                              staticClass: "col-md-12",
                              attrs: { id: "grafGenero" },
                            },
                            [_vm._m(2)]
                          )
                        : _vm._e(),
                    ],
                    1
                  ),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _vm._m(3),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-3 mb-3" }, [
              _c("div", { staticClass: "card-block bg-white p-3" }, [
                _vm._m(4),
                _vm._v(" "),
                _c(
                  "div",
                  {},
                  [_c("vue-c3", { attrs: { handler: _vm.BudgetG_2 } })],
                  1
                ),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-3 mb-3" }, [
              _c("div", { staticClass: "card-block bg-white p-3" }, [
                _vm._m(5),
                _vm._v(" "),
                _c(
                  "div",
                  {},
                  [_c("vue-c3", { attrs: { handler: _vm.BudgetG_2 } })],
                  1
                ),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-6 mb-3" }, [
              _c("div", { staticClass: "card-block bg-white p-3" }, [
                _vm._m(6),
                _vm._v(" "),
                _c("div", { staticClass: "table-responsive" }, [
                  _c("table", { staticClass: "table table-sm nowrap" }, [
                    _vm._m(7),
                    _vm._v(" "),
                    _vm.projectBudget.childsBudget
                      ? _c(
                          "tbody",
                          [
                            _vm._l(
                              _vm.projectBudget.childsBudget,
                              function (project) {
                                return _c(
                                  "tr",
                                  {
                                    key: project,
                                    staticClass: "text-uppercase",
                                  },
                                  [
                                    _c("td", [_vm._v(_vm._s(project.name))]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _vm._v("25,000.00"),
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _vm._v("15,000.00"),
                                    ]),
                                  ]
                                )
                              }
                            ),
                            _vm._v(" "),
                            !_vm.projectBudget.childsBudget
                              ? _c(
                                  "tr",
                                  { staticClass: "text-center text-black-50" },
                                  [
                                    _c("td", { attrs: { colspan: "3" } }, [
                                      _vm._v("Select a project..."),
                                    ]),
                                  ]
                                )
                              : _vm._e(),
                          ],
                          2
                        )
                      : _vm._e(),
                  ]),
                ]),
              ]),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-12" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-5 mb-3" }, [
              _c("div", { staticClass: "card-block bg-white p-3" }, [
                _vm._m(8),
                _vm._v(" "),
                _c(
                  "div",
                  {},
                  [_c("vue-c3", { attrs: { handler: _vm.BudgetG_3 } })],
                  1
                ),
                _vm._v(" "),
                _vm.BudgetG_3_loading
                  ? _c("div", { attrs: { id: "grafGenero" } }, [_vm._m(9)])
                  : _vm._e(),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-7 mb-3" }, [
              _c("div", { staticClass: "card-block bg-white p-3" }, [
                _vm._m(10),
                _vm._v(" "),
                _c(
                  "div",
                  {},
                  [_c("vue-c3", { attrs: { handler: _vm.BudgetG_4 } })],
                  1
                ),
                _vm._v(" "),
                _vm.BudgetG_4_loading
                  ? _c("div", { attrs: { id: "grafGenero" } }, [_vm._m(11)])
                  : _vm._e(),
              ]),
            ]),
          ]),
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
    return _c(
      "div",
      { staticClass: "title-card pt-2 pl-2 rounded bg-light mb-2 d-flex" },
      [
        _c("h6", { staticClass: "flex-grow-1" }, [
          _c("span", [_vm._v("Orçamento")]),
        ]),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-4 border-lg border-right" }, [
      _c("div", { staticClass: "p-0 pt-3 border-bottom" }, [
        _c("div", { staticClass: "content-group m-0" }, [
          _c("i", {
            staticClass: "icon-coins position-center ",
            staticStyle: { "font-size": "24px", color: "#2D96FF" },
          }),
          _vm._v(" "),
          _c("h4", { staticClass: "text-semibold no-margin" }, [
            _c("small", [_vm._v("MZN")]),
            _vm._v(" 5,689\n                                            "),
          ]),
          _vm._v(" "),
          _c("span", { staticClass: "text-muted " }, [_vm._v("Orçamento")]),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "p-0 pt-3" }, [
        _c("div", { staticClass: "content-group m-0" }, [
          _c("i", {
            staticClass: "icon-coins position-center",
            staticStyle: { "font-size": "24px", color: "#ff2d62" },
          }),
          _vm._v(" "),
          _c("h4", { staticClass: "text-semibold no-margin" }, [
            _c("small", [_vm._v("MZN")]),
            _vm._v(" 5,689\n                                            "),
          ]),
          _vm._v(" "),
          _c("span", { staticClass: "text-muted " }, [_vm._v("Valor Gasto")]),
        ]),
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
        staticClass: "col-12 m-auto text-center",
        attrs: { "ng-if": "loading;" },
      },
      [
        _c(
          "div",
          {
            staticClass: "spinner-grow text-warning",
            attrs: { role: "status" },
          },
          [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "spinner-grow text-success",
            attrs: { role: "status" },
          },
          [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "spinner-grow text-danger",
            attrs: { role: "status" },
          },
          [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "spinner-grow", attrs: { role: "status" } }, [
          _c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")]),
        ]),
        _vm._v(" "),
        _c("div", {}, [
          _vm._v(
            "\n                                                Loading...\n                                            "
          ),
        ]),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-6 mb-3" }, [
      _c("div", { staticClass: "card-block p-3" }, [
        _c(
          "div",
          { staticClass: "title-card pt-2 pl-2 rounded bg-light mb-2 d-flex" },
          [
            _c("h6", { staticClass: "flex-grow-1" }, [
              _c("span", [_vm._v("Project Perfomance")]),
            ]),
          ]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "row m-auto h-75 text-center" }, [
          _c("div", { staticClass: "col-6 mb-2 mb-lg-0  border-right" }, [
            _c("div", { staticClass: "card-block  p-0 pt-3 border-bottom" }, [
              _c("div", { staticClass: "content-group m-0" }, [
                _c("i", {
                  staticClass: "icon-coins position-center text-slate",
                  staticStyle: { "font-size": "24px" },
                }),
                _vm._v(" "),
                _c(
                  "h4",
                  {
                    staticClass: "text-semibold no-margin",
                    staticStyle: { "white-space": "normal" },
                  },
                  [
                    _c("small", [_vm._v("MZN")]),
                    _vm._v(
                      " 5,689\n                                                "
                    ),
                    _c(
                      "small",
                      { staticClass: "text-success text-size-base" },
                      [_vm._v("(+16.2%)")]
                    ),
                  ]
                ),
                _vm._v(" "),
                _c("span", { staticClass: "text-muted " }, [
                  _vm._v("Orçamento Previsto"),
                ]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-6 mb-2 mb-lg-0 " }, [
            _c("div", { staticClass: "card-block  p-0 pt-3 border-bottom" }, [
              _c("div", { staticClass: "content-group m-0" }, [
                _c("i", {
                  staticClass: "icon-coins position-center text-slate",
                  staticStyle: { "font-size": "24px" },
                }),
                _vm._v(" "),
                _c(
                  "h4",
                  {
                    staticClass: "text-semibold no-margin",
                    staticStyle: { "white-space": "normal" },
                  },
                  [
                    _c("small", [_vm._v("MZN")]),
                    _vm._v(
                      " 5,689\n                                            "
                    ),
                  ]
                ),
                _vm._v(" "),
                _c("span", { staticClass: "text-muted " }, [
                  _vm._v("Orçamento Realizado"),
                ]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-6 mb-2 mb-lg-0 border-right mt-2" }, [
            _c("div", { staticClass: "card-block  p-0 pt-3" }, [
              _c("div", { staticClass: "content-group m-0" }, [
                _c("i", {
                  staticClass: "icon-coins position-center text-slate",
                  staticStyle: { "font-size": "24px" },
                }),
                _vm._v(" "),
                _c("h4", { staticClass: "text-semibold no-margin" }, [
                  _c("small", [_vm._v("MZN")]),
                  _vm._v(
                    " 5,689\n                                                "
                  ),
                  _c("small", { staticClass: "text-danger text-size-base" }, [
                    _vm._v("(-6.2%)"),
                  ]),
                ]),
                _vm._v(" "),
                _c("span", { staticClass: "text-muted " }, [
                  _vm._v("Valor Gasto Previsto"),
                ]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-6 mb-2 mb-lg-0 mt-2" }, [
            _c("div", { staticClass: "card-block  p-0 pt-3" }, [
              _c("div", { staticClass: "content-group m-0" }, [
                _c("i", {
                  staticClass: "icon-coins position-center text-slate",
                  staticStyle: { "font-size": "24px" },
                }),
                _vm._v(" "),
                _c("h4", { staticClass: "text-semibold no-margin" }, [
                  _c("small", [_vm._v("MZN")]),
                  _vm._v(
                    " 5,689\n                                            "
                  ),
                ]),
                _vm._v(" "),
                _c("span", { staticClass: "text-muted " }, [
                  _vm._v("Valor Gasto Realizado"),
                ]),
              ]),
            ]),
          ]),
        ]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "title-card pt-2 pl-2 rounded bg-light mb-2 d-flex" },
      [
        _c("h6", { staticClass: "flex-grow-1" }, [
          _c("span", [_vm._v("% Contribuicao de Sub-Projectos")]),
        ]),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "title-card pt-2 pl-2 rounded bg-light mb-2 d-flex" },
      [
        _c("h6", { staticClass: "flex-grow-1" }, [
          _c("i", { staticClass: "icon-coin-dollar" }),
          _vm._v(" "),
          _c("span", [_vm._v("Contribuicao de Sub-Projectos")]),
        ]),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "title-card pt-2 pl-2 rounded bg-light mb-2 d-flex" },
      [
        _c("h6", { staticClass: "flex-grow-1" }, [
          _c("i", { staticClass: "icon-list-ordered" }),
          _vm._v(" "),
          _c("span", [_vm._v("Orçamento de Sub-Projectos")]),
        ]),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "bg-slate" }, [
      _c("th", [_vm._v("Project")]),
      _vm._v(" "),
      _c("th", { staticClass: "text-right" }, [_vm._v("Orçamento")]),
      _vm._v(" "),
      _c("th", { staticClass: "text-right" }, [_vm._v("Valor Gasto")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "title-card pt-2 pl-2 rounded bg-light mb-2 d-flex" },
      [
        _c("h6", { staticClass: "flex-grow-1" }, [
          _c("i", { staticClass: "icon-coin-dollar" }),
          _vm._v(" "),
          _c("span", [_vm._v("Relatorio de Actividades")]),
        ]),
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
        staticClass: "col-6 col-lg-7 m-auto text-center",
        attrs: { "ng-if": "loading;" },
      },
      [
        _c(
          "div",
          {
            staticClass: "spinner-grow text-warning",
            attrs: { role: "status" },
          },
          [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "spinner-grow text-success",
            attrs: { role: "status" },
          },
          [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "spinner-grow text-danger",
            attrs: { role: "status" },
          },
          [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "spinner-grow", attrs: { role: "status" } }, [
          _c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")]),
        ]),
        _vm._v(" "),
        _c("div", {}, [
          _vm._v(
            "\n                                        Loading...\n                                    "
          ),
        ]),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "title-card pt-2 pl-2 rounded bg-light mb-2 d-flex" },
      [
        _c("h6", { staticClass: "flex-grow-1" }, [
          _c("i", { staticClass: "icon-coin-dollar" }),
          _vm._v(" "),
          _c("span", [_vm._v("Orçamento de Sub-Projectos")]),
        ]),
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
        staticClass: "col-6 col-lg-7 m-auto text-center",
        attrs: { "ng-if": "loading;" },
      },
      [
        _c(
          "div",
          {
            staticClass: "spinner-grow text-warning",
            attrs: { role: "status" },
          },
          [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "spinner-grow text-success",
            attrs: { role: "status" },
          },
          [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "spinner-grow text-danger",
            attrs: { role: "status" },
          },
          [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "spinner-grow", attrs: { role: "status" } }, [
          _c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")]),
        ]),
        _vm._v(" "),
        _c("div", {}, [
          _vm._v(
            "\n                                        Loading...\n                                    "
          ),
        ]),
      ]
    )
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/dashboard/budget.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/views/dashboard/budget.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _budget_vue_vue_type_template_id_1ac687a8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./budget.vue?vue&type=template&id=1ac687a8&scoped=true& */ "./resources/js/components/views/dashboard/budget.vue?vue&type=template&id=1ac687a8&scoped=true&");
/* harmony import */ var _budget_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./budget.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/dashboard/budget.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _budget_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _budget_vue_vue_type_template_id_1ac687a8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _budget_vue_vue_type_template_id_1ac687a8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "1ac687a8",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/dashboard/budget.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/dashboard/budget.vue?vue&type=script&lang=ts&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/views/dashboard/budget.vue?vue&type=script&lang=ts& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_budget_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./budget.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/budget.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_budget_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/dashboard/budget.vue?vue&type=template&id=1ac687a8&scoped=true&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/views/dashboard/budget.vue?vue&type=template&id=1ac687a8&scoped=true& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_budget_vue_vue_type_template_id_1ac687a8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./budget.vue?vue&type=template&id=1ac687a8&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/budget.vue?vue&type=template&id=1ac687a8&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_budget_vue_vue_type_template_id_1ac687a8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_budget_vue_vue_type_template_id_1ac687a8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);