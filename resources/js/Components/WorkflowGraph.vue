<template>
    <div class="w-full h-full" ref="graph"></div>
</template>

<script>
import cytoscape from "cytoscape";

export default {
    name: "WorkflowGraph",

    props: {
        graph: {
            type: Object,
            required: true,
        },
    },

    computed: {
        elements() {
            return Object.keys(this.graph).reduce((elems, key) => {
                const vertex = this.graph[key];

                elems.push({
                    data: {
                        id: key,
                        label: vertex.name,
                        failedAt: vertex.failed_at,
                        finishedAt: vertex.finished_at,
                        createdAt: vertex.created_at,
                        exception: vertex.exception,
                    },
                });

                vertex.edges.forEach((edge) => {
                    elems.push({
                        data: {
                            source: key,
                            target: edge,
                        },
                    });
                });

                return elems;
            }, []);
        },
    },

    methods: {
        nodeBackgroundColor(elem) {
            if (elem.data("failedAt") !== null) {
                return "rgb(245, 101, 101)";
            }

            if (elem.data("finishedAt") !== null) {
                return "rgb(72, 187, 120)";
            }

            return "#999";
        },
    },

    mounted() {
        const cy = cytoscape({
            container: this.$refs.graph,

            elements: this.elements,

            style: [
                {
                    selector: "node",
                    style: {
                        "background-color": this.nodeBackgroundColor,
                        label: "data(label)",
                        "text-wrap": "wrap",
                        "text-max-width": "170px",
                        "text-margin-y": "-12px",
                    },
                },

                {
                    selector: "edge",
                    style: {
                        width: 2,
                        "line-color": "#ccc",
                        "target-arrow-color": "#ccc",
                        "target-arrow-shape": "triangle",
                        "curve-style": "bezier",
                    },
                },
            ],

            layout: {
                name: "breadthfirst",
                grid: true,
                directed: true,
                maximal: true,
                spacingFactor: 2.25,
            },
        });
    },
};
</script>
