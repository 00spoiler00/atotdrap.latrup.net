<template>
    <v-card v-if="dashboard">

        <v-toolbar height="48" color="primary" title="Resum" elevation="10">

            <v-btn-toggle v-model="limit" size="small" variant="text" rounded density="compact" mandatory>
                <v-btn :value="v" v-for="v in [1, 3, 5, 10]" :key="v">
                    <v-icon v-text="v" />
                </v-btn>
            </v-btn-toggle>
        </v-toolbar>


        <v-toolbar height="48">
            <v-toolbar-title text="Pitskill IO" />
        </v-toolbar>

        <v-card>

            <v-row class="ma-0 sm:ma-2">
                <v-col cols="12" md="4">
                    <DashboardCard :data="dashboard.pitskill.races" />
                </v-col>
                <v-col cols="12" md="4">
                    <DashboardCard :data="dashboard.pitskill.pitskill.ranking" />
                </v-col>

                <v-col cols="12" md="4">
                    <DashboardCard :data="dashboard.pitskill.pitrep.ranking" />
                </v-col>
            </v-row>

            <v-toolbar height="24">
                <v-toolbar-title text="Setmanals" />
            </v-toolbar>

            <v-row class="ma-0 sm:ma-2">

                <v-col cols="12" md="4">
                    <DashboardCard :data="dashboard.pitskill.hotlaps" />
                </v-col>

                <v-col cols="12" md="4">
                    <DashboardCard :data="dashboard.pitskill.pitskill.earners" />
                </v-col>

                <v-col cols="12" md="4">
                    <DashboardCard :data="dashboard.pitskill.pitrep.earners" />
                </v-col>

            </v-row>

        </v-card>

        <v-toolbar height="48">
            <v-toolbar-title text="Low Fuel Motorsport" />
        </v-toolbar>

        <v-card>
            <v-row>
                <v-col cols="12" sm="6">
                    <v-card flat subtitle="PitSkill ranking">
                        <v-list>
                            <v-list-item rounded="shaped" v-for="i in 3" :key="i">
                                <v-list-item-title>TODO</v-list-item-title>
                                <v-list-item-subtitle>2234</v-list-item-subtitle>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-col>

                <v-col cols="12" sm="6">
                    <v-card flat subtitle="PitRep ranking">
                        <v-list>
                            <v-list-item rounded="shaped" v-for="i in 3" :key="i">
                                <v-list-item-title>TODO</v-list-item-title>
                                <v-list-item-subtitle>2345</v-list-item-subtitle>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-col>

            </v-row>
        </v-card>


    </v-card>

</template>

<script setup>

import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();

import { useDisplay } from 'vuetify';
const display = useDisplay();

import { ref, onMounted, onUnmounted, watch } from 'vue';
import DashboardCard from '../Shared/DashboardCard.vue';

const dashboard = ref(false);
const limit = ref(3);
var refreshThread

const updateDashboard = () => {
    loaderStore.add();
    fetch(`/api/dashboard?limit=${limit.value}`)
        .then(response => response.json())
        .then(data => dashboard.value = data)
        .catch(error => console.error('Error fetching data:', error))
        .finally(() => {
            loaderStore.remove()
            refreshThread = setTimeout(() => updateDashboard(), 10000);
        });
};

watch(limit, () => {
    clearTimeout(refreshThread);
    updateDashboard()
})

onMounted(() => updateDashboard());
onUnmounted(() => clearTimeout(refreshThread));

</script>