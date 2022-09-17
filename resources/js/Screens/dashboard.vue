<script type="text/ecmascript-6">
    import _ from 'lodash';
    import moment from 'moment';

    export default {
        components: {},


        /**
         * The component's data.
         */
        data() {
            return {
                stats: {
                    totalPending: '-',
                    totalNonStarted: '-',
                    failed: '-',
                    created: '-',
                    successful: '-',
                },
                workflows: [],
                ready: false,
                autoRefresh: true,
                loading: true,
                period: 'hour',
            };
        },


        /**
         * Prepare the component.
         */
        mounted() {
            document.title = "Venture - Dashboard";

            this.loadStats();
            this.loadWorkflows();

            this.refresh();
        },


        /**
         * Clean after the component is destroyed.
         */
        destroyed() {
            clearTimeout(this.timeout);
        },

        methods: {
            /**
             * Load the general stats.
             */
            loadStats() {
                return this.$http.get(VentureDashboard.basePath + '/api/stats?period=' + this.period)
                    .then(response => {
                        this.stats = response.data;
                        this.loading = false;
                    });
            },

            loadWorkflows() {
                return this.$http.get(VentureDashboard.basePath + '/api/workflows')
                    .then(response => {
                        this.workflows = response.data.data;
                        this.ready = true;
                    });
            },

            /**
             * Refresh the stats every period of time.
             */
            refresh() {
                this.timeout = setTimeout(async ()  => {

                    if (this.autoRefresh) {
                        await Promise.all([
                            this.loadStats(),
                            this.loadWorkflows(),
                        ]);
                    }

                    this.refresh();
                }, 5000);
            },

            getPercentage({ jobs: {total, processed, failed} }) {
                return Math.floor((processed + failed) / total * 100);
            }
        },

        computed: {
            nonStartedState() {
                if (!this.ready) {
                    return 'normal';
                }

                if (this.stats.totalNonStarted === this.stats.totalPending) {
                    return 'warning';
                }

                return 'normal';
            },

            failuresState() {
                if (!this.ready) {
                    return 'normal';
                }

                if (this.stats.failed === 0) {
                    return 'success';
                }

                if (this.stats.created === this.stats.failed) {
                    return 'danger';
                }

                return 'warning';
            }
        }
    }
</script>

<template>
    <main>
        <div>
            <label for="auto-refresh" class="inline-flex relative items-center cursor-pointer float-right">
                <input type="checkbox" value="" id="auto-refresh" class="sr-only peer" v-model="autoRefresh">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900">Auto-Refresh</span>
            </label>

            <h1 class="text-2xl text-gray-800 tracking-tight mb-3">
                Workflow Overview
            </h1>
        </div>

        <div class="grid grid-cols-5 gap-4 mb-5">
            <stats-card title="Total Pending Workflows" :loading="loading">{{ stats.totalPending }}</stats-card>
            <stats-card title="Non-Started Workflows" :loading="loading" :state="nonStartedState">{{ stats.totalNonStarted }}</stats-card>
            <stats-card :title="`Failures in the past ${this.period}`" :state="failuresState" :loading="loading">{{ stats.failed }}</stats-card>
            <stats-card :title="`Successes in the past ${this.period}`" :loading="loading">{{ stats.successful }}</stats-card>
            <stats-card :title="`New in the past ${this.period}`" :loading="loading">{{ stats.created }}</stats-card>
        </div>

        <div class="bg-white rounded-lg shadow pt-1 pb-2">

            <div v-if="!ready" class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
                <span>Loading...</span>
            </div>

            <div v-if="ready && workflows.length == 0" class="d-flex flex-column align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
                <span>There are no pending Workflows.</span>
            </div>

            <table v-if="ready && workflows.length > 0" class="w-full">
                <thead class="text-sm text-gray-600">
                <tr class="border-b border-gray-300">
                    <th class="text-left pl-6 pr-2 pt-2 pb-2 font-normal">ID</th>
                    <th class="text-left px-2 pt-2 pb-2 font-normal">Name</th>
                    <th class="text-left pl-2 pr-6 pt-2 pb-2 font-normal">Created at</th>
                    <th class="text-left pl-2 pr-6 pt-2 pb-2 font-normal">Progress</th>
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
                    <td class="pl-2 pr-6 py-2">{{ calendarDatetime(workflow.created_at) }}</td>
                    <td class="pl-2 pr-6 py-2">
                        <span
                            class="text-sm font-medium text-blue-700"
                            :class="{ 'text-gray-400': getPercentage(workflow) === 0 }">
                            {{ getPercentage(workflow) }}%
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </main>
</template>
