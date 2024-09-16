<template>
    <v-card v-if="race">
        <v-toolbar class="text-center" color="primary" title="Detall de la cursa" height="36" />
        <v-card-text>
            <!-- Header info -->
            <v-row dense>
                <v-col cols="12" sm="9">
                    <v-text-field variant="solo-filled" readonly label="Nom" v-model="race.name" />
                </v-col>

                <v-col cols="12" sm="3">
                    <v-text-field variant="solo-filled" readonly label="Data" v-model="startsAt" />
                </v-col>

                <!-- Enroll -->
                <v-col cols="12" align="center" justify="center">
                    <v-btn block color="primary" @click="openOnBlank('https://pitskill.io/event/' + race.event_id)" prepend-icon="mdi-account-plus">
                        Apuntar-se
                    </v-btn>
                </v-col>

            </v-row>

            <v-template v-if="race.platform == 'pitskill'">
                <!-- Entries -->
                <v-toolbar height="36" class="my-6">
                    <v-toolbar-title>Inscrits</v-toolbar-title>
                </v-toolbar>

                <v-progress-linear
                    color="primary"
                    v-model="race.registers"
                    :max="50"
                    :height="24" rounded-bar striped>
                    {{ race.registers }} registrats
                </v-progress-linear>

                <v-data-table :headers="entriesHeaders" :items="entries" dense item-key="userId" :loading="entriesLoading" :sort-by="sortBy">
                    <template v-slot:item.userId='{ item }'>
                        <v-btn @click="openOnBlank(`https://pitskill.io/driver-license/${item.userId}`)" icon="mdi-magnify" />
                    </template>
                    <template v-slot:item.driver='{ item }'>
                        {{ item.name }} {{ item.surname }}
                    </template>
                    <template v-slot:item.license='{ item }'>
                        <PitskillLicense :pitskill="item.pitskill" :pitrep="item.pitrep" />
                    </template>
                </v-data-table>
            </v-template>

            <!-- Track Component -->
            <Track :id="race.track_id" />
        </v-card-text>
    </v-card>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import moment from 'moment'
import Track from '@/components/Pages/Track.vue'
import PitskillLicense from '@/components/Shared/PitskillLicense.vue'
import axios from 'axios'

const route = useRoute()
const race = ref(null)
const entries = ref([])
const sortBy = ref([{ key: 'pitskill', order: 'desc' }]);
const entriesLoading = ref(false)

const startsAt = computed(() => moment(race.value?.starts_at).format('DD/MM HH:mm'))

const entriesHeaders = [
    { title: '', key: 'userId' },
    { title: 'Pilot', key: 'driver' },
    { title: 'Llicència', key: 'license' },
    { title: 'PitSkill', key: 'pitskill' },
    { title: 'PitRep', key: 'pitrep' }
]

const getDriverList = (userId) => axios.get(`https://api.pitskill.io/api/pitskill/getdriverinfo?id=${userId}`)
const getEventInfo = (eventId) => axios.get(`https://api.pitskill.io/api/events/${eventId}`)

const fetchEventAndDrivers = async (eventId) => {
    try {
        entriesLoading.value = true
        const eventResponse = await getEventInfo(eventId)
        const driverIds = eventResponse
            .data
            .payload
            .event_vehicle_registration
            .flatMap(vehicle => vehicle.event_registrations.map(registration => registration.user_id))

        const promises = driverIds.map(async (userId) => {
            try {
                const response = await getDriverList(userId)
                const name = response.data.payload.sigma_user_data.profile_data.first_name || 'N/A'
                const surname = response.data.payload.sigma_user_data.profile_data.last_name || 'N/A'
                const pitskill = response.data.payload.tpc_driver_data.currentPitSkill || 'N/A'
                const pitrep = response.data.payload.tpc_driver_data.currentPitRep || 'N/A'
                return { userId, name, surname, pitskill, pitrep }
            } catch (error) {
                return { userId, name: 'Error', surname: 'Error', pitskill: 'Error', pitrep: 'Error' }
            }
        })

        entries.value = await Promise.all(promises)
    } catch (err) {
        console.error(err)
    } finally {
        entriesLoading.value = false
    }
}

onMounted(() => {
    fetch(`/api/race/${route.params.id}`)
        .then(response => response.json())
        .then(data => {
            race.value = data
            fetchEventAndDrivers(race.value.event_id)
        })
})

const openOnBlank = (url) => window.open(url, '_blank')
</script>