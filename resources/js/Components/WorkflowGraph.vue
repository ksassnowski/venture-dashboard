<script type="text/ecmascript-6">
import mermaid from 'mermaid';
import {definitionToMermaid, relationsToMermaid, statusToMermaid} from '../utils/mermaid';

export default {
    props: ['id', 'definition', 'relations', 'status'],

    data() {
        return {}
    },

    methods: {
        render() {
            this.$refs.graph.removeAttribute('data-processed');
            this.$refs.graph.innerHTML = this.graph;
            mermaid.init(this.$refs.graph);
        }
    },

    computed: {
        graph() {
            return `graph TD
                ${definitionToMermaid(this.definition)}
                ${relationsToMermaid(this.relations)}
                ${statusToMermaid(this.status)}`;
        }
    },

    mounted() {
        this.render();
    },

    updated() {
        this.render();
    }
}
</script>

<template>
    <div class="w-full h-full graph" ref="graph">
        {{ graph }}
    </div>
</template>
