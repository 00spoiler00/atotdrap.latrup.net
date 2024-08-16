<template>
    <v-btn :to="link" density="compact" color="primary" icon >
        <v-icon size="sm">mdi-magnify</v-icon>
    </v-btn>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['model', 'id']);
const link = computed(() => props.model + '/' + props.id)

</script>