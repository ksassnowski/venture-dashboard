<template>
    <div class="w-full h-full" ref="graph">{{ graph }}</div>
</template>

<script type="text/ecmascript-6">
import mermaid from 'mermaid';
import { definitionToMermaid, relationsToMermaid, statusToMermaid } from '../utils/mermaid';

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
            const styles = {
                pending: 'stroke-dasharray: 5 5',
                finished: 'fill:green',
                processing: 'fill:yellow',
                failed: 'fill:red',
            };

            console.log(this.definition, this.relations, this.status);

            const markdown = `graph TD
                ${definitionToMermaid(this.definition)}
                ${relationsToMermaid(this.relations)}
                ${statusToMermaid(this.status, styles)}`;

            console.log('graph', markdown);
            return markdown;
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

<style>

</style>
