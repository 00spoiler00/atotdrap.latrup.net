<template>
    <v-template v-if="item">

        <!-- Card Version -->
        <v-card v-if="type == 'card'"
            :color="computedColor"
            :to="computedRoute"
            :prepend-avatar="computedAvatar"
            :title="computedTitle"
            :subtitle="computedSubtitle" />

        <!-- Button version -->
        <v-btn v-if="type == 'button'" :to="computedRoute" :color="computedColor">
            <v-icon class="mr-2">{{ item.icon }}</v-icon>
            {{ computedTitle }}
            <v-tooltip :text="computedSubtitle" location="bottom" activator="parent" />
        </v-btn>

        <!-- Icon version -->
        <v-btn v-if="type == 'icon'" :to="computedRoute" :color="computedColor" icon density="compact">
            <v-icon size="sm">{{ item.icon }}</v-icon>
            <v-tooltip :text="computedTitle" location="bottom" activator="parent" />
        </v-btn>

        <!-- Text version -->
        <v-btn v-if="type == 'text'" :to="computedRoute" :color="computedColor" text density="compact" variant="plain">
            {{ computedTitle }}
        </v-btn>

    </v-template>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';

const item = ref(null);
const props = defineProps({
    type: { type: String, default: 'card', validator: (value) => ['card', 'button', 'icon', 'text'].includes(value) },
    model: { type: String, required: true },
    id: { type: Number, required: true },
    color: { type: String },
    route: { type: String },
    avatar: { type: String },
    title: { type: String },
    subtitle: { type: String },
});

const computedColor = computed(() => props.color ?? item.value?.color ?? 'primary');
const computedRoute = computed(() => props.route ?? item.value?.route ?? '');
const computedAvatar = computed(() => props.avatar ?? item.value?.avatar ?? '');
const computedTitle = computed(() => props.title ?? item.value?.title ?? '');
const computedSubtitle = computed(() => props.subtitle ?? item.value?.subtitle ?? '');

const computedApiUrl = computed(() => `/api/generic/card/${props.model}/${props.id}`);

onMounted(() => {
    fetch(computedApiUrl.value)
        .then(response => response.json())
        .then(data => item.value = data);
})

</script>