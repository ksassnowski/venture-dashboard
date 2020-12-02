import Vue from "vue";

import WorkflowGraph from "@/Components/WorkflowGraph";
import JobTable from "@/Components/JobTable";

Vue.component("workflow-graph", WorkflowGraph);
Vue.component("job-table", JobTable);

new Vue({
    el: "#app",
});
