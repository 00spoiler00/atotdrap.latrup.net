<template>

    <v-card v-if="race">

        <v-toolbar class="text-center" color="primary" title="Detall de la cursa" height="36"/>

        <v-card-text>

            <!-- Header info-->
            <v-row dense>

                <v-col cols="12" sm="9">
                    <v-text-field variant="solo-filled" readonly label="Nom" v-model="race.name" />
                </v-col>

                <v-col cols="12" sm="3">
                    <v-text-field variant="solo-filled" readonly label="Data" v-model="startsAt" />
                </v-col>

                <!-- Enroll-->
                <v-col cols="12" align="center" justify="center">
                    <v-btn block color="primary" @click="openOnBlank('https://pitskill.io/event/' + race.event_id)" prepend-icon="mdi-account-plus">
                        Apuntar-se
                    </v-btn>
                </v-col>

                <v-col cols="12">
                    <v-progress-linear
                        color="primary"
                        v-model="race.registers"
                        :max="50"
                        :height="24" rounded-bar striped>
                        {{ race.registers }} registrats
                    </v-progress-linear>
                </v-col>
            </v-row>

            <v-row v-for="server in race.servers" :key="server.name">
                <v-col cols="12">
                    Servers
                </v-col>

                <v-col cols="12" sm="8">
                    <v-text-field variant="solo-filled" readonly label="Server" v-model="server.name" />
                </v-col>

                <v-col cols="12" sm="4">
                    <v-text-field variant="solo-filled" readonly label="Split" v-model="server.split" />
                </v-col>

                <v-col cols="12">
                    <v-progress-linear
                        color="primary"
                        v-model="server.sof"
                        :max="4000"
                        :height="24" rounded-bar striped>
                        {{ server.sof }} SoF
                    </v-progress-linear>
                </v-col>

                <v-col cols="12">
                    Inscripcions
                </v-col>

                <v-col cols="12">
                    <v-row>
                        <v-col cols="12" sm="3" v-for="enroll in server.enrolls" :key="enroll.driver_id">
                            <DriverChip :id="enroll.driver_id" :name="enroll.driver_name" :avatar="enroll.driver_avatar" size="x-large" />
                        </v-col>
                    </v-row>
                </v-col>

            </v-row>
        </v-card-text>

        <TrackDetail :id="race.track_id" />

    </v-card>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue';
import { useRoute } from 'vue-router'
// import { useDateTransformer } from '../../composables/useDateTransformer';
import moment from 'moment';
import TrackDetail from '@/components/Pages/TrackDetail.vue';
import ModelCard from '@/components/Shared/ModelCard.vue';
import DriverChip from '../Shared/DriverChip.vue';

const route = useRoute()
const race = ref(null);

// TODO: Move to useDateTransformer 
const startsAt = computed(() => moment(race?.value?.starts_at).format('DD/MM HH:mm'));

onMounted(() => {
    fetch(`/api/race/${route.params.id}`)
        .then(response => response.json())
        .then(data => race.value = data);
})

const openOnBlank = (url) => window.open(url, '_blank')


</script>