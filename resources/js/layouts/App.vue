<template>
    <v-app dark>
        <v-main>
            <TopBar />

            <v-progress-linear
                v-if="isLoading"
                color="accent"
                height="2"
                indeterminate />

            <v-tabs
                v-model="tab"
                align-tabs="center">
                <v-tab>
                    <v-icon class="mr-2">mdi-file-document</v-icon>
                    <span class="d-none d-sm-inline">Registres</span>
                </v-tab>
                <v-tab>
                    <v-icon class="mr-2">mdi-trophy</v-icon>
                    <span class="d-none d-sm-inline">Tops</span>
                </v-tab>
                <v-tab>
                    <v-icon class="mr-2">mdi-chart-bar</v-icon>
                    <span class="d-none d-sm-inline">Ranking</span>
                </v-tab>
                <v-tab>
                    <v-icon class="mr-2">mdi-speedometer</v-icon>
                    <span class="d-none d-sm-inline">HotLaps</span>
                </v-tab>
            </v-tabs>

            <v-tabs-window v-model="tab">
                <v-tabs-window-item>
                    <Races />
                </v-tabs-window-item>

                <v-tabs-window-item>
                    <Movements />
                </v-tabs-window-item>

                <v-tabs-window-item>
                    <Drivers />
                </v-tabs-window-item>

                <v-tabs-window-item>
                    <Hotlaps />
                </v-tabs-window-item>
            </v-tabs-window>
        </v-main>
    </v-app>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useLoaderStore } from '../stores/loader';
import TopBar from '../components/TopBar.vue';
import Races from '../components/Races.vue';
import Drivers from '../components/Drivers.vue';
import Movements from '../components/Movements.vue';
import Hotlaps from '../components/Hotlaps.vue';

const tab = ref(null);
const loaderStore = useLoaderStore();
const isLoading = computed(() => loaderStore.isLoading);
</script>
