<template>
    <v-app dark>
        <v-main>
            <TopBar />

            <v-progress-linear
                v-if="isLoading"
                color="accent"
                height="2"
                indeterminate />

            <RouterView />

        </v-main>
    </v-app>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useLoaderStore } from '../stores/loader';
import TopBar from '../components/TopBar.vue';

const loaderStore = useLoaderStore();
const isLoading = computed(() => loaderStore.isLoading);
</script>
