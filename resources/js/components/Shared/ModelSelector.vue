<template>
    <v-autocomplete :items="items" v-model="internalValue" v-bind="$attrs" @update:modelValue="emitValue" />
</template>

<script setup>
import { onMounted, ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
    modelValue: {
        required: true
    },
    modelName: {
        type: String,
        required: true
    },
})
const internalValue = ref(props.modelValue.value);
const emit = defineEmits(['update:modelValue']);
const emitValue = (event) => {
    console.log(event)
    emit('update:modelValue', event)
}

const items = ref([]);
const fetchData = () => {
    fetch('/api/selector/' + props.modelName)
        .then(response => response.json())
        .then(data => items.value = data);
}
onMounted(() => fetchData())

</script>