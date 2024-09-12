<template>
    <v-autocomplete v-if="props.autocomplete" :items="items" v-model="internalValue" v-bind="$attrs" @update:modelValue="emitValue" />
    <v-select v-else :items="items" v-model="internalValue" v-bind="$attrs" @update:modelValue="emitValue" />
</template>

<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    modelValue: {
        required: true
    },
    modelName: {
        type: String,
        required: true
    },
    autocomplete: {
        type: Boolean,
        default: true
    }
})
const internalValue = ref(props.modelValue.value);
const emit = defineEmits(['update:modelValue']);
const emitValue = (event) => emit('update:modelValue', event)
const items = ref([]);
const fetchData = () => {
    fetch('/api/selector/' + props.modelName)
        .then(response => response.json())
        .then(data => items.value = data);
}
onMounted(() => fetchData())

</script>