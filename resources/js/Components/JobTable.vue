<template>
    <expandable-table :headers="headers" :items="items">
        <template v-slot:expanded="{ item }">
            <div class="pt-4 pb-2">
                <h3
                    class="text-base font-semibold tracking-tight text-gray-800 px-4 mb-2"
                >
                    Exception
                </h3>

                <stack-trace :exception="item.exception" />
            </div>
        </template>
    </expandable-table>
</template>

<script>

import moment from 'moment';
import ExpandableTable from "@/Components/ExpandableTable";
import StackTrace from "@/Components/StackTrace";

export default {
    name: "JobTable",

    components: {
        StackTrace,
        ExpandableTable,
    },

    props: {
        jobs: {
            type: Array,
            required: true,
        },
    },

    computed: {
        headers() {
            return [
                { text: "Name", align: "left" },
                { text: "Finished At", align: "right" },
                { text: "Failed At", align: "right" },
            ];
        },

        items() {
            return this.jobs.map((job) => ({
                expandable: job.failed_at !== null,
                columns: [
                    job.name,
                    job.finished_at
                        ? moment(job.finished_at).format("YYYY-MM-DD HH:mm")
                        : null,
                    job.failed_at
                        ? moment(job.failed_at).format("YYYY-MM-DD HH:mm")
                        : null,
                ],
                data: job,
            }));
        },
    },
};
</script>
