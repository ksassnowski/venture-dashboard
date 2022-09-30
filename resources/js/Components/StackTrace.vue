<script type="text/ecmascript-6">
export default {
    name: "StackTrace",

    props: {
        exception: {
            type: String,
            required: true,
        },
    },

    computed: {
        lines() {
            return this.exception.split("\n");
        },
    },
};
</script>

<template>
    <div class="text-gray-800 text-sm">
        <div
            v-for="(line, i) in lines"
            :key="i"
            class="transition duration-150 hover:bg-gray-100 py-2 px-4"
            :class="{ 'border-t border-gray-400': i > 0 }"
        >
            <span class="whitespace-pre-wrap">{{ line }}</span>
        </div>
    </div>
</template>
