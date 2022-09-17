<script type="text/ecmascript-6">
export default {
    /**
     * The component's data.
     */
    data() {
        return {
            workflow: null,
            autoRefresh: false,
        };
    },

    /**
     * Prepare the component.
     */
    async mounted() {
        document.title = "Venture Dashboard - Workflows";

        await this.loadWorkflow();

        this.autoRefresh = ! this.workflow.isFinished;

        this.refresh();
    },

    destroyed() {
        clearTimeout(this.timeout);
    },

    methods: {
        /**
         * Load the monitored tags.
         */
        loadWorkflow() {
            return this.$http.get(`${VentureDashboard.basePath}/api/workflows/${this.$route.params.id}`)
                .then(({ data: { data: workflow } }) => {
                    this.workflow = workflow;
                });
        },

        /**
         * Load the workers stats.
         */
        loadJobs() {
            return this.$http.get(`${VentureDashboard.basePath}/api/workflows/${this.$route.params.id}/jobs`)
                .then(({ data: { data: workflow } }) => {
                    this.workflow = { ...this.workflow, ...workflow };
                });
        },

        /**
         * Refresh the stats every period of time.
         */
        refresh() {
            this.timeout = setTimeout(async ()  => {

                if (this.autoRefresh) {
                    await this.loadJobs();

                    if (this.workflow.isFinished) {
                        this.autoRefresh = false;
                    }
                }

                this.refresh();
            }, 2000);
        },
    }
}
</script>

<template>
    <div>
        <div class="container">
            <label for="auto-refresh" class="inline-flex relative items-center cursor-pointer float-right">
                <input type="checkbox" value="" id="auto-refresh" class="sr-only peer" :disabled="!workflow" v-model="autoRefresh">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Auto-Refresh</span>
            </label>

            <h1 class="text-2xl text-gray-900 mb-2">
                Workflow #{{ $route.params.id }}
            </h1>
        </div>

        <div v-if="workflow == null" class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
    <!--        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="icon spin mr-2 fill-text-color">-->
    <!--            <path d="M12 10a2 2 0 0 1-3.41 1.41A2 2 0 0 1 10 8V0a9.97 9.97 0 0 1 10 10h-8zm7.9 1.41A10 10 0 1 1 8.59.1v2.03a8 8 0 1 0 9.29 9.29h2.02zm-4.07 0a6 6 0 1 1-7.25-7.25v2.1a3.99 3.99 0 0 0-1.4 6.57 4 4 0 0 0 6.56-1.42h2.1z"></path>-->
    <!--        </svg>-->
            <span>Loading...</span>
        </div>

        <div v-if="workflow" class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <h2 class="text-xl text-gray-900 mb-2">
                <b>Name:</b> {{ workflow.name  }}
            </h2>

            <section class="bg-white bg-opacity-25 rounded-lg shadow mb-6" style="height: 450px">
                    <workflow-mermaid-graph
                        :id="workflow.id"
                        :definition="workflow.definition"
                        :relations="workflow.relations"
                        :status="workflow.status"
                    />
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
