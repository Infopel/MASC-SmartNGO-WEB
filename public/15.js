(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[15],{

/***/ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/graphs.vue?vue&type=script&lang=ts&":
/*!***************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/dashboard/graphs.vue?vue&type=script&lang=ts& ***!
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
        VueC3: (vue_c3__WEBPACK_IMPORTED_MODULE_2___default())
    },
    created() {
        this.initDashboard()
    },
    data () {
        return {
            handler: new vue__WEBPACK_IMPORTED_MODULE_0___default.a(),
            dashboard_endpoint: '/api/dashboard',
        }
    },
    mounted () {

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
    },
}));


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/graphs.vue?vue&type=template&id=b678b468&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/dashboard/graphs.vue?vue&type=template&id=b678b468&scoped=true& ***!
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
  return _vm._m(0)
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row m-1 ml-lg-5 mr-lg-5" }, [
      _c("div", { staticClass: "col-12 containers mt-1 p-1" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-8 col-lg-9" }, [
            _c("div", { staticClass: "row mb-3" }, [
              _c("div", { staticClass: "col-md-4 mb-3" }, [
                _c("div", { staticClass: "card-block p-3" }, [
                  _c("div", { staticClass: "title-card border-bottom" }, [
                    _c("h6", [
                      _c(
                        "a",
                        { staticClass: "text-slate-800", attrs: { href: "" } },
                        [_c("span", [_vm._v("Tasks Overview")])]
                      ),
                    ]),
                  ]),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-8 mb-3" }, [
                _c("div", { staticClass: "card-block p-3" }, [
                  _c(
                    "div",
                    { staticClass: "title-card border-bottom mb-2 d-flex" },
                    [
                      _c("h6", { staticClass: "flex-grow-1" }, [
                        _c(
                          "a",
                          {
                            staticClass: "text-slate-800",
                            attrs: { href: "" },
                          },
                          [
                            _c("i", {
                              staticClass: "icon-star-full2 text-orange-300",
                            }),
                            _vm._v(" "),
                            _c("span", [_vm._v("Tarefas Observadas")]),
                          ]
                        ),
                      ]),
                      _vm._v(" "),
                      _c("div", {}, [
                        _c(
                          "a",
                          {
                            staticClass:
                              "text-slate-800 btn btn-sm bg-warning border-0",
                            attrs: { href: "" },
                          },
                          [_c("span", [_vm._v("Todas Tarefas")])]
                        ),
                      ]),
                    ]
                  ),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-4 mb-3" }, [
                _c("div", { staticClass: "card-block bg-white p-3" }, [
                  _c("div", { staticClass: "title-card border-bottom" }, [
                    _c("div", {}, [
                      _c("h6", [
                        _c(
                          "a",
                          {
                            staticClass: "text-slate-800",
                            attrs: { href: "" },
                          },
                          [
                            _c("i", { staticClass: "icon-stack3" }),
                            _vm._v(" "),
                            _c("span", [_vm._v("Team member progress")]),
                          ]
                        ),
                      ]),
                    ]),
                  ]),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-8 mb-3" }, [
                _c("div", { staticClass: "card-block bg-white p-3" }, [
                  _c("div", { staticClass: "title-card border-bottom" }, [
                    _c("div", {}, [
                      _c("h6", [
                        _c(
                          "a",
                          {
                            staticClass: "text-slate-800",
                            attrs: { href: "" },
                          },
                          [
                            _c("i", { staticClass: "icon-stack3" }),
                            _vm._v(" "),
                            _c("span", [_vm._v("Hot Tasks")]),
                          ]
                        ),
                      ]),
                    ]),
                  ]),
                ]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4 col-lg-3 mb-3" }, [
            _c("div", { staticClass: "card-block p-3" }, [
              _c("div", { staticClass: "title-card border-bottom" }, [
                _c("h6", [
                  _c(
                    "a",
                    { staticClass: "text-slate-800", attrs: { href: "" } },
                    [
                      _c("i", { staticClass: "icon-history" }),
                      _vm._v(" "),
                      _c("span", [_vm._v("Actividades recentes")]),
                    ]
                  ),
                ]),
              ]),
            ]),
          ]),
        ]),
      ]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/views/dashboard/graphs.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/views/dashboard/graphs.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _graphs_vue_vue_type_template_id_b678b468_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./graphs.vue?vue&type=template&id=b678b468&scoped=true& */ "./resources/js/components/views/dashboard/graphs.vue?vue&type=template&id=b678b468&scoped=true&");
/* harmony import */ var _graphs_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./graphs.vue?vue&type=script&lang=ts& */ "./resources/js/components/views/dashboard/graphs.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _graphs_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_1__["default"],
  _graphs_vue_vue_type_template_id_b678b468_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _graphs_vue_vue_type_template_id_b678b468_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "b678b468",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/dashboard/graphs.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/dashboard/graphs.vue?vue&type=script&lang=ts&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/views/dashboard/graphs.vue?vue&type=script&lang=ts& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_index_js_vue_loader_options_graphs_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib??vue-loader-options!./graphs.vue?vue&type=script&lang=ts& */ "./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/graphs.vue?vue&type=script&lang=ts&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_loader_lib_index_js_vue_loader_options_graphs_vue_vue_type_script_lang_ts___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/dashboard/graphs.vue?vue&type=template&id=b678b468&scoped=true&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/views/dashboard/graphs.vue?vue&type=template&id=b678b468&scoped=true& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_graphs_vue_vue_type_template_id_b678b468_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./graphs.vue?vue&type=template&id=b678b468&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/dashboard/graphs.vue?vue&type=template&id=b678b468&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_graphs_vue_vue_type_template_id_b678b468_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_graphs_vue_vue_type_template_id_b678b468_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);