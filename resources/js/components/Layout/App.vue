<template>
    <v-app dark>
        <TopBar />

        <v-navigation-drawer expand-on-hover permanent rail>
            <v-list density="compact" nav>
                <v-list-item 
                    v-for="route in routes" 
                    :key="route.path" 
                    :prepend-icon="route.icon" 
                    :title="route.title" 
                    :to="route.path" 
                />
            </v-list>
        </v-navigation-drawer>

        <!-- <v-main class="overflow-y-auto h-[calc(100vh-64px)] mt-[64px]"> -->
        <v-main>
            <RouterView />
        </v-main>
    </v-app>
</template>

<script setup>
import { computed, ref } from 'vue';
import TopBar from '@/components/Layout/TopBar.vue';

import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();
const isLoading = computed(() => loaderStore.isLoading);

import { useDisplay } from 'vuetify'
// const display = ref(useDisplay())
const drawer = ref(false);
const routes = [
    { title: 'Dashboard', path: '/', icon: 'mdi-view-dashboard' },
    { title: 'Races', path: '/race', icon: 'mdi-flag-checkered' },
    { title: 'Drivers', path: '/driver', icon: 'mdi-account' },
    { title: 'Statistics', path: '/statistics', icon: 'mdi-chart-bar' },
    { title: 'Change Log', path: '/changelog', icon: 'mdi-history' },
]

</script>
