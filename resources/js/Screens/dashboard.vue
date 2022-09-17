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
                stats: {},
                workflows: [],
                ready: false,
                autoRefresh: true,
            };
        },


        /**
         * Prepare the component.
         */
        mounted() {
            document.title = "Venture - Dashboard";

            // this.refreshStatsPeriodically();
        },


        /**
         * Clean after the component is destroyed.
         */
        destroyed() {
            clearTimeout(this.timeout);
        },


        computed: {

        },


        methods: {
            /**
             * Load the general stats.
             */
            loadStats() {
                return this.$http.get(VentureDashboard.basePath + '/api/stats') // TODO
                    .then(response => {
                        this.stats = response.data;
                    });
            },

            /**
             * Refresh the stats every period of time.
             */
            refresh() {
                this.timeout = setTimeout(async ()  => {

                    if (this.autoRefresh) {
                        await this.loadWorkflows();
                    }

                    this.refresh();
                }, 5000);
            },

            /**
             *  Count processes for the given supervisor.
             */
            countProcesses(processes) {
                return _.chain(processes).values().sum().value().toLocaleString()
            },


            /**
             *
             * @returns {string}
             */
            humanTime(time) {
                return moment.duration(time, "seconds").humanize().replace(/^(.)|\s+(.)/g, function ($1) {
                    return $1.toUpperCase();
                });
            },


            /**
             * Determine the unit for the given timeframe.
             */
            determinePeriod(minutes) {
                return moment.duration(moment().diff(moment().subtract(minutes, "minutes"))).humanize().replace(/^An?/i, '');
            }
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
                Overview
            </h1>
        </div>

    </main>
</template>
