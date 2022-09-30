<script type="text/ecmascript-6">
export default {
    name: "ExpandableTable",

    props: {
        headers: {
            type: Array,
            required: true,
        },

        items: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            expanded: null,
        };
    },

    methods: {
        toggleExpand(i) {
            if (this.expanded === i) {
                this.expanded = null;
            } else {
                this.expanded = i;
            }
        },
    },
};
</script>

<template>
    <table class="w-full">
        <thead>
        <tr class="border-b border-gray-300">
            <th
                v-for="header in headers"
                :key="header.text"
                class="py-4 px-4 text-xs text-gray-600 font-semibold"
                :class="{
                        'text-left': header.align === 'left',
                        'text-right': header.align === 'right',
                        'text-center': header.align === 'center',
                    }"
            >
                {{ header.text }}
            </th>
        </tr>
        </thead>

        <tbody>
        <template v-for="(item, i) in items">
            <tr
                class="transition duration-150 hover:bg-gray-100 border-b border-gray-200"
                :class="[item.style]"
                @click="() => item.expandable && toggleExpand(i)"
                :key="i"
            >
                <td
                    v-for="(column, j) in item.columns"
                    :key="`item_${i}_column_${j}`"
                    class="py-4 px-4 text-sm text-gray-800 cursor-pointer"
                    :class="{
                            'text-left': headers[j].align === 'left',
                            'text-right': headers[j].align === 'right',
                            'text-center': headers[j].align === 'center',
                        }"
                >
                    {{ column }}
                </td>
            </tr>

            <tr v-if="item.expandable && expanded === i">
                <td :colspan="item.columns.length">
                    <slot name="expanded" :item="item.data"></slot>
                </td>
            </tr>
        </template>
        </tbody>
    </table>
</template>
