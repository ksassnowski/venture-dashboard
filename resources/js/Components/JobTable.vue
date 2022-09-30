<script type="text/ecmascript-6">
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
                expandable: job.failedAt !== null,
                columns: [
                    job.name,
                    job.finishedAt
                        ? moment(job.finishedAt).format("YYYY-MM-DD HH:mm")
                        : null,
                    job.failedAt
                        ? moment(job.failedAt).format("YYYY-MM-DD HH:mm")
                        : null,
                ],
                data: job,
                style: this.getStyleOfJob(job),
            }));
        },
    },

    methods: {
        getStyleOfJob(job) {
            if (job.finishedAt) {
                return 'bg-green-100';
            }

            if (job.failedAt) {
                return 'bg-red-100';
            }

            return null;
        }
    }
};
</script>

<template>
    <ExpandableTable :headers="headers" :items="items">
        <template v-slot:expanded="{ item }">
            <div class="pt-4 pb-2">
                <h3 class="text-base font-semibold tracking-tight text-gray-800 px-4 mb-2">
                    Exception
                </h3>

                <StackTrace :exception="item.exception" />
            </div>
        </template>
    </ExpandableTable>
</template>
