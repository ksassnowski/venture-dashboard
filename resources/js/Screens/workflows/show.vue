<script type="text/ecmascript-6">
export default {
    /**
     * The component's data.
     */
    data() {
        return {
            workflow: null,
            graph: null,
            table: null,
        };
    },

    /**
     * Prepare the component.
     */
    mounted() {
        document.title = "Venture Dashboard - Workflows";

        this.loadWorkflow();

        const container = document.getElementById('mermaid');
        console.log(container);
    },

    methods: {
        /**
         * Load the monitored tags.
         */
        loadWorkflow() {
            this.$http.get(VentureDashboard.basePath + '/api/workflows/' + this.$route.params.id)
                .then(response => {
                    this.workflow = response.data.workflow;
                    this.graph = response.data.graph;
                    this.table = response.data.table;
                });
        },
    }
}
</script>

<template>
    <div>
        <h1 class="text-2xl text-gray-900 mb-2">
            Workflow #{{ $route.params.id }}
        </h1>

        <div v-if="workflow == null" class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
    <!--        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="icon spin mr-2 fill-text-color">-->
    <!--            <path d="M12 10a2 2 0 0 1-3.41 1.41A2 2 0 0 1 10 8V0a9.97 9.97 0 0 1 10 10h-8zm7.9 1.41A10 10 0 1 1 8.59.1v2.03a8 8 0 1 0 9.29 9.29h2.02zm-4.07 0a6 6 0 1 1-7.25-7.25v2.1a3.99 3.99 0 0 0-1.4 6.57 4 4 0 0 0 6.56-1.42h2.1z"></path>-->
    <!--        </svg>-->
            <span>Loading...</span>
        </div>

        <div v-if="workflow" class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <section class="bg-white bg-opacity-25 rounded-lg shadow mb-6" style="height: 450px">
                <workflow-graph :graph="graph"></workflow-graph>
            </section>

            <section>
                <h2 class="text-xl text-gray-900 mb-2">Jobs</h2>

                <div class="bg-white rounded-lg shadow">
                    <job-table :jobs="workflow.jobs"></job-table>
                </div>
            </section>
        </div>
    </div>
</template>
