<script type="text/ecmascript-6">
    import moment from 'moment';

    export default {
        /**
         * The component's data.
         */
        data() {
            return {
                ready: false,
                loading: true,
                workflows: [],
            };
        },


        /**
         * Prepare the component.
         */
        mounted() {
            document.title = "Venture Dashboard - Workflows : Finished";

            this.loadWorkflows();
        },


        methods: {
            /**
             * Load the monitored tags.
             */
            loadWorkflows() {
                this.loading = true;

                this.$http.get(VentureDashboard.basePath + '/api/workflows/finished')
                    .then(response => {
                        this.workflows = response.data.data;

                        this.ready = true;
                        this.loading = false;
                    });
            },
        }
    }
</script>

<template>
    <main>
        <div>
            <div class="float-right">
                <button
                    type="button"
                    :disabled="loading"
                    v-on:click="loadWorkflows"
                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800"
                >
                    <svg v-if="loading" class="inline mr-2 w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>

                    Refresh
                </button>
            </div>

            <h1 class="text-2xl text-gray-800 tracking-tight mb-3">
                Finished Workflows
            </h1>
        </div>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
<!--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="icon spin mr-2 fill-text-color">-->
<!--                <path d="M12 10a2 2 0 0 1-3.41 1.41A2 2 0 0 1 10 8V0a9.97 9.97 0 0 1 10 10h-8zm7.9 1.41A10 10 0 1 1 8.59.1v2.03a8 8 0 1 0 9.29 9.29h2.02zm-4.07 0a6 6 0 1 1-7.25-7.25v2.1a3.99 3.99 0 0 0-1.4 6.57 4 4 0 0 0 6.56-1.42h2.1z"></path>-->
<!--            </svg>-->
            <span>Loading...</span>
        </div>

        <div v-if="ready && workflows.length == 0" class="d-flex flex-column align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <span>There are no finished workflows.</span>
        </div>

        <div class="bg-white rounded-lg shadow pt-1 pb-2">
            <table v-if="ready && workflows.length > 0" class="w-full">
                <thead class="text-sm text-gray-600">
                <tr class="border-b border-gray-300">
                    <th class="text-left pl-6 pr-2 pt-2 pb-2 font-normal">ID</th>
                    <th class="text-left px-2 pt-2 pb-2 font-normal">Name</th>
                    <th class="text-left pl-2 pr-6 pt-2 pb-2 font-normal">Started at</th>
                    <th class="text-left pl-2 pr-6 pt-2 pb-2 font-normal">Finished at</th>
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
                    <td class="pl-2 pr-6 py-2">{{ formatDatetime(workflow.created_at) }}</td>
                    <td class="pl-2 pr-6 py-2">{{ formatDatetime(workflow.finished_at) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </main>
</template>
