<script type="text/ecmascript-6">
    import moment from 'moment';

    export default {
        /**
         * The component's data.
         */
        data() {
            return {
                ready: false,
                workflows: [],
            };
        },


        /**
         * Prepare the component.
         */
        mounted() {
            document.title = "Venture Dashboard - Workflows : Running";

            this.loadWorkflows();
        },


        methods: {
            /**
             * Load the monitored tags.
             */
            loadWorkflows() {
                this.ready = false;

                this.$http.get(VentureDashboard.basePath + '/api/workflows')
                    .then(response => {
                        this.workflows = response.data.data;

                        this.ready = true;
                    });
            },
        }
    }
</script>

<template>
    <main>
        <h1 class="text-2xl text-gray-800 tracking-tight mb-3">
            Current Workflows
        </h1>

        <div class="bg-white rounded-lg shadow pt-1 pb-2">

            <div v-if="!ready" class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
                <span>Loading...</span>
            </div>

            <div v-if="ready && workflows.length == 0" class="d-flex flex-column align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
                <span>You're not monitoring any workflows.</span>
            </div>

            <table v-if="ready && workflows.length > 0" class="w-full">
                <thead class="text-sm text-gray-600">
                <tr class="border-b border-gray-300">
                    <th class="text-left pl-6 pr-2 pt-2 pb-2 font-normal">ID</th>
                    <th class="text-left px-2 pt-2 pb-2 font-normal">Name</th>
                    <th class="text-left px-2 pt-2 pb-2 font-normal text-right">Progress</th>
                    <th class="text-left pl-2 pr-6 pt-2 pb-2 font-normal">Started at</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="workflow in workflows" class="text-sm transition duration-300 hover:bg-gray-100 cursor-pointer text-gray-800">
                    <td class="pl-6 pr-2 py-2">{{ workflow.id }}</td>
                    <td class="px-2 py-2">
                        <router-link :to="{ name: 'workflows.show', params: { id: workflow.id }}" href="#" class="text-laravel">
                            {{ workflow.name }} #{{ workflow.id }}
                        </router-link>
                    </td>
                    <td class="px-2 py-2 text-right">
                        {{ (workflow.jobs_processed / workflow.job_count) * 100 }} %
                    </td>
                    <td class="pl-2 pr-6 py-2">{{ formatDatetime(workflow.created_at) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </main>
</template>
