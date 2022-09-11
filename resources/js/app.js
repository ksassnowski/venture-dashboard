import Vue from "vue";
import Routes from './routes';
import VueRouter from 'vue-router';
import Base from './base';

import WorkflowGraph from "@/Components/WorkflowGraph";
import WorkflowMermaidGraph from "@/Components/WorkflowMermaidGraph";
import JobTable from "@/Components/JobTable";
import axios from "axios";

Vue.component("workflow-graph", WorkflowGraph);
Vue.component("workflow-mermaid-graph", WorkflowMermaidGraph);
Vue.component("job-table", JobTable);

/*
 * Packages
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.prototype.$http = axios.create();

/*
 * Globals
 */

window.VentureDashboard.basePath = '/' + window.VentureDashboard.path;

let routerBasePath = window.VentureDashboard.basePath + '/';

if (window.VentureDashboard.path === '' || window.VentureDashboard.path === '/') {
    routerBasePath = '/';
    window.VentureDashboard.basePath = '';
}

Vue.mixin(Base);

/*
 * Router
 */

Vue.use(VueRouter);

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: routerBasePath,
});

/*
 * App
 */

new Vue({
    el: "#app",
    router,
});
