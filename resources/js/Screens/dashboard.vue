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
             * Load the workers stats.
             */
            loadWorkflows() {
                return this.$http.get(VentureDashboard.basePath + '/api/workflows')
                    .then(response => {
                        this.workflows = response.data;
                    });
            },

            /**
             * Refresh the stats every period of time.
             */
            refreshStatsPeriodically() {
                Promise.all([
                    this.loadWorkflows(),
                ]).then(() => {
                    this.ready = true;

                    this.timeout = setTimeout(() => {
                        this.refreshStatsPeriodically(false);
                    }, 5000);
                });
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
        <h1 class="text-2xl text-gray-800 tracking-tight mb-3">
            Overview
        </h1>

    </main>
</template>
