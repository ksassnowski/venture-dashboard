<script type="text/ecmascript-6">
export default {
    data() {
        return {
            ready: false,
            workflows: [],
            autoRefresh: true,
        };
    },

    mounted() {
        document.title = "Venture Dashboard - Workflows : Running";

        this.loadWorkflows();
        this.refresh();
    },

    destroyed() {
        clearTimeout(this.timeout);
    },

    methods: {
        loadWorkflows() {
            return this.$http.get(VentureDashboard.basePath + '/api/workflows')
                .then(response => {
                    this.workflows = response.data.data;

                    this.ready = true;
                });
        },

        refresh() {
            this.timeout = setTimeout(async ()  => {

                if (this.autoRefresh) {
                    await this.loadWorkflows();
                }

                this.refresh();
            }, 5000);
        },
    }
}
</script>

<template>
    <main>
        <div>
            <label for="auto-refresh" class="inline-flex relative items-center cursor-pointer float-right">
                <input type="checkbox" value="" id="auto-refresh" class="sr-only peer" v-model="autoRefresh">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Auto-Refresh</span>
            </label>

            <h1 class="text-2xl text-gray-800 tracking-tight mb-3">
                Current Workflows
            </h1>
        </div>

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
