<template>

    <v-card v-if="race">

        <v-card-title>
            Detall de la cursa
        </v-card-title>

        <v-card-text>

            <!-- Header info-->
            <v-row>

                <v-col cols="12" md="4">
                    <v-text-field variant="solo-filled" readonly label="Nom" v-model="race.name" />
                </v-col>

                <v-col cols="12" md="4">
                    <v-text-field variant="solo-filled" readonly label="Data" v-model="startsAt" />
                </v-col>

                <v-col cols="12" md="4">
                    <v-progress-linear
                        color="primary"
                        v-model="race.registers"
                        :max="50"
                        :height="54" rounded-bar striped>
                        {{ race.registers }} registrats
                    </v-progress-linear>
                </v-col>
            </v-row>


            <v-row v-for="server in race.servers" :key="server.name">
                <v-col cols="12">
                    Servers
                </v-col>

                <v-col cols="12" md="6">
                    <v-text-field variant="solo-filled" readonly label="Server" v-model="server.name" />
                </v-col>

                <v-col cols="12" md="2">
                    <v-text-field variant="solo-filled" readonly label="Split" v-model="server.split" />
                </v-col>

                <v-col cols="12" md="4">
                    <v-progress-linear
                        color="primary"
                        v-model="server.sof"
                        :max="4000"
                        :height="54" rounded-bar striped>
                        {{ server.sof }} SoF
                    </v-progress-linear>
                </v-col>

                <v-col cols="12">
                    Inscripcions
                </v-col>

                <v-col cols="12">
                    <v-row>
                        <v-col cols="12" md="3" v-for="enroll in server.enrolls" :key="enroll.driver.id">
                            <v-card color="primary" :to="'/driver/' + enroll.driver.id" :prepend-avatar="enroll.driver.avatar_url" :title="enroll.driver.name" :subtitle="enroll.car" />
                        </v-col>
                    </v-row>
                </v-col>

            </v-row>

            <v-row>

                <v-col cols="12">
                    Circuit
                </v-col>

                <v-col cols="12">
                    <TrackDetail :id="race.track_id" />
                </v-col>

            </v-row>

        </v-card-text>

    </v-card>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router'
import { useDateTransformer } from '../composables/useDateTransformer';
import TrackDetail from './TrackDetail.vue';

const route = useRoute()
const race = ref(null);

const fetchData = () => {
    fetch(`/api/race/${route.params.id}`)
        .then(response => response.json())
        .then(data => {
            race.value = data
            console.log(data)
        });
}

const startsAt = useDateTransformer(race.value?.starts_at).readableHour
const registersBarLength = computed(() => race.value?.registers * (100 / 50))
const computeSofBarLength = (v) => Math.floor(v * (100 / 3000))

onMounted(() => fetchData())


</script>