<script type="text/ecmascript-6">
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
            document.title = "Venture Dashboard - Workflows : Failed";

            this.loadWorkflows();
        },


        methods: {
            /**
             * Load the monitored tags.
             */
            loadWorkflows() {
                this.ready = false;

                this.$http.get(VentureDashboard.basePath + '/api/workflows/failed')
                    .then(response => {
                        this.workflows = response.data;

                        this.ready = true;
                    });
            },
        }
    }
</script>

<template>
    <main>
        <h1 class="text-2xl text-gray-800 tracking-tight mb-3">
            Failed Workflows
        </h1>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <!--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="icon spin mr-2 fill-text-color">-->
            <!--                <path d="M12 10a2 2 0 0 1-3.41 1.41A2 2 0 0 1 10 8V0a9.97 9.97 0 0 1 10 10h-8zm7.9 1.41A10 10 0 1 1 8.59.1v2.03a8 8 0 1 0 9.29 9.29h2.02zm-4.07 0a6 6 0 1 1-7.25-7.25v2.1a3.99 3.99 0 0 0-1.4 6.57 4 4 0 0 0 6.56-1.42h2.1z"></path>-->
            <!--            </svg>-->
            <span>Loading...</span>
        </div>

        <div v-if="ready && workflows.length == 0" class="d-flex flex-column align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <span>There are no failed workflows.</span>
        </div>


        <div class="bg-white rounded-lg shadow pt-1 pb-2">
            <table v-if="ready && workflows.length > 0" class="w-full">
                <thead class="text-sm text-gray-600">
                <tr class="border-b border-gray-300">
                    <th class="text-left pl-6 pr-2 pt-2 pb-2 font-normal">ID</th>
                    <th class="text-left px-2 pt-2 pb-2 font-normal">Name</th>
                    <th class="text-left px-2 pt-2 pb-2 font-normal text-right">Failures</th>
                    <th class="text-left pl-2 pr-6 pt-2 pb-2 font-normal">Started at</th>
                    <th class="text-left pl-2 pr-6 pt-2 pb-2 font-normal">Last failure at</th>
                </tr>
                </thead>

                <tbody>
                <tr
                    v-for="workflow in workflows"
                    class="text-sm transition duration-300 hover:bg-gray-100 cursor-pointer text-gray-800"
                >
                    <td class="pl-6 pr-2 py-2">{{ workflow.id }}</td>
                    <td class="px-2 py-2">
                        <router-link :to="{ name: 'workflows.show', params: { id: workflow.id }}" href="#" class="text-laravel">
                            {{ workflow.name }} #{{ workflow.id }}
                        </router-link>
                    </td>
                    <td class="px-2 py-2 text-right">
                        {{ workflow.jobs_failed }}
                    </td>
                    <td class="pl-2 pr-6 py-2">{{ formatDatetime(workflow.created_at) }}</td>
                    <td class="pl-2 pr-6 py-2">
                        <blockquote>workflow.jobs->whereNotNull('failed_at')->sortByDesc('failed_at')->first()->failed_at->format('Y-m-d H:i')</blockquote>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </main>
</template>
