<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700" v-bind="$attrs">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
