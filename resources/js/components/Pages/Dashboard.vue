<template>
    <v-card v-if="dashboard">

        <v-toolbar height="48" color="primary" title="Resum" elevation="10">

            <v-btn-toggle v-model="limit" size="small" rounded density="compact" divided mandatory class="mr-2">
                <v-btn :value="v" v-for="v in [1, 3, 5, 10]" :key="v" v-text="v" :variant="limit == v ? 'elevated' : 'plain'" color="primary" />
            </v-btn-toggle>
        </v-toolbar>


        <v-row class="ma-0 sm:ma-2">
            <v-col cols="12" md="6">
                <DashboardCard :data="dashboard.races" />
            </v-col>
            <v-col cols="12" md="6">
                <DashboardCard :data="dashboard.hotlaps" />
            </v-col>
        </v-row>

        <v-toolbar height="48">
            <v-toolbar-title text="PitSkill" />
        </v-toolbar>

        <v-row class="ma-0 sm:ma-2">

            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.pitskill.pitskill.ranking" />
            </v-col>

            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.pitskill.pitrep.ranking" />
            </v-col>


            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.pitskill.pitskill.earners" />
            </v-col>

            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.pitskill.pitrep.earners" />
            </v-col>

        </v-row>

        <v-toolbar height="48">
            <v-toolbar-title text="Low Fuel Motorsport" />
        </v-toolbar>

        <v-row class="ma-0 sm:ma-2">

            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.lfm.elo.ranking" />
            </v-col>

            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.lfm.sr.ranking" />
            </v-col>


            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.lfm.elo.earners" />
            </v-col>

            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.lfm.sr.earners" />
            </v-col>

        </v-row>


        <v-toolbar height="48">
            <v-toolbar-title text="RaceRoom" />
        </v-toolbar>

        <v-row class="ma-0 sm:ma-2">

            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.raceroom.rating.ranking" />
            </v-col>

            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.raceroom.reputation.ranking" />
            </v-col>


            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.raceroom.rating.earners" />
            </v-col>

            <v-col cols="12" sm="6" lg="3">
                <DashboardCard :data="dashboard.raceroom.reputation.earners" />
            </v-col>

        </v-row>


    </v-card>

</template>

<script setup>

import { useLoaderStore } from '@/stores/loader'
const loaderStore = useLoaderStore()

import { ref, onMounted, onUnmounted, watch } from 'vue'
import DashboardCard from '../Shared/DashboardCard.vue'

const dashboard = ref(false)
const savedLimit = localStorage.getItem('limit') || 3
const limit = ref(parseInt(savedLimit))
var refreshThread

const updateDashboard = () => {
    loaderStore.add()
    fetch(`/api/dashboard?limit=${limit.value}`)
        .then(response => response.json())
        .then(data => dashboard.value = data)
        .catch(error => console.error('Error fetching data:', error))
        .finally(() => {
            loaderStore.remove()
            refreshThread = setTimeout(() => updateDashboard(), 10000)
        })
}

watch(limit, (newValue) => {
    localStorage.setItem('limit', newValue)
    clearTimeout(refreshThread)
    updateDashboard()
});

onMounted(() => updateDashboard())
onUnmounted(() => clearTimeout(refreshThread))

</script>