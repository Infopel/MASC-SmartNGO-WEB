import "./bootstrap";

window.Vue = require("vue");
Vue.prototype.__ = str => _.get(window.i18n, str);

// import VueEditor from './components/editor.vue';
Vue.component("VueEditor", () => import("./components/editor.vue"));

Vue.component("dashboard", () =>
    import("./components/views/dashboard/index.vue")
);
Vue.component("dashboard_budget", () =>
    import("./components/views/dashboard/budget.vue")
);
Vue.component("dashboard_reports", () =>
    import("./components/views/dashboard/reports.vue")
);
Vue.component("dashboard_graphs", () =>
    import("./components/views/dashboard/graphs.vue")
);
// var dashboard_config = require('./components/views/dashboard/index.vue').default;
/** Modulo orcamento **/
import orcamento from "./components/views/finance/index.vue";

/**
 * Componentes para custom_fields
 */
Vue.component("customFields", () =>
    import("./components/views/custom_fields/index.vue")
);
/**
 * Projects
 */
Vue.component("gantt", () => import("./components/views/gantt/index.vue"));
Vue.component("addUsers", () => import("./components/add_users.vue"));

Vue.component("programForm", () =>
    import("./components/views/programs/form.vue")
);
Vue.component("projectForm", () =>
    import("./components/views/projects/form.vue")
);

// Vue.component('projectMembers', () => import('./components/views/projects/members.vue'))
Vue.component("calendar", () =>
    import("./components/views/calendar/index.vue")
);

Vue.component("issues-form", () => import("./components/views/issues/new.vue"));

Vue.component("report-orcamento-pde", () =>
    import("./components/views/reports/orcamento_pde.vue")
);
Vue.component("report-orcamento-project", () =>
    import("./components/views/reports/orcamento_project.vue")
);
Vue.component("atividade-provincia", () =>
    import("./components/views/reports/atividades_provincia.vue")
);
Vue.component("actividades-pde", () =>
    import("./components/views/reports/actividades_pde.vue")
);
Vue.component("actividades-project", () =>
    import("./components/views/reports/actividades_project.vue")
);
Vue.component("beneficiarios-pde", () =>
    import("./components/views/reports/beneficiarios_pde.vue")
);
Vue.component("beneficiarios-project", () =>
    import("./components/views/reports/beneficiarios_project.vue")
);
Vue.component("actividade-approvements", () =>
    import("./components/views/reports/actividade_approvements.vue")
);
Vue.component("solicitacao-fundos", () =>
    import("./components/views/reports/solicitacao_fundos.vue")
);
Vue.component("data-orcamento-pde", () =>
    import("./components/views/reports/data_orcamento_pde.vue")
);
Vue.component("data-orcamento-projects", () =>
    import("./components/views/reports/data_orcamento_projects.vue")
);
Vue.component("execucao-orcamental", () =>
    import("./components/views/reports/execucao_orcamental.vue")
);
Vue.component("previsao-orcamental", () =>
    import("./components/views/reports/previsao_orcamental.vue")
);
Vue.component("general-issues-report", () =>
    import("./components/views/reports/general_issues_report.vue")
);
Vue.component("general-issues-report-project", () =>
    import("./components/views/reports/general_issues_report_project.vue")
);
Vue.component("general-indicators-report", () =>
    import("./components/views/reports/general_indicators_report.vue")
);
// import projectForm from './components/views/projects/form.vue';
import pdeForm from "./components/views/pde/form.vue";
import projectMembers from "./components/views/projects/members.vue";

const app = new Vue({
    el: "#app",
    components: {
        orcamento,
        pdeForm,
        projectMembers
    }
});
