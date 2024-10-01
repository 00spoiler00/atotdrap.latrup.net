<template>

    <v-card v-if="driver">

        <v-toolbar class="text-center" color="primary" :title="'Detall de ' + driver.name" height="36" />

        <v-card-text>

            <v-row>
                <v-col cols="12" sm="6">

                    <v-row dense>

                        <v-col cols="12">
                            <v-text-field variant="solo-filled" readonly label="Nom" v-model="driver.first_name" />
                        </v-col>

                        <v-col cols="12">
                            <v-text-field variant="solo-filled" readonly label="Cognom" v-model="driver.last_name" />
                        </v-col>

                        <v-col cols="12">
                            <v-text-field variant="solo-filled" readonly label="Nick" v-model="driver.nickname" />
                        </v-col>

                    </v-row>
                </v-col>


                <v-col cols="12" sm="6" align="center">
                    <v-avatar size="256">
                        <v-img
                            color="surface-variant"
                            :src="driver.avatar"
                            cover />
                    </v-avatar>
                </v-col>
            </v-row>
        </v-card-text>

        <v-toolbar height="36">
            <v-toolbar-title>PitSkill IO</v-toolbar-title>
        </v-toolbar>

        <v-card-text>
            <v-row dense>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Id" v-model="driver.pitskill.id" append-icon="mdi-magnify" @click:append="openOnBlank('https://pitskill.io/driver-license/' + driver.pitskill.id)" />
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Ranking" v-model="driver.pitskill.ranking" />
                </v-col>
                <v-col cols="12" sm="3">
                    <v-text-field variant="solo-filled" readonly label="PitSkill" v-model="driver.pitskill.pitskill" />
                </v-col>
                <v-col cols="12" sm="3">
                    <v-text-field variant="solo-filled" readonly label="PitRep" v-model="driver.pitskill.pitrep" />
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Participacions" v-model="driver.pitskill.enrollments" />
                </v-col>
                <v-col cols="12" sm="6">
                    <Graph :value="driver.pitskill.pitskill_graph" type="PitSkill" />
                </v-col>
                <v-col cols="12" sm="6">
                    <Graph :value="driver.pitskill.pitrep_graph" type="PitRep" />
                </v-col>
            </v-row>
        </v-card-text>

        <v-toolbar height="36" v-if="driver.lfm.id">
            <v-toolbar-title>LowFuelMotorsport</v-toolbar-title>
        </v-toolbar>

        <v-card-text v-if="driver.lfm.id">
            <v-row dense>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Id" v-model="driver.lfm.id" append-icon="mdi-magnify" @click:append="openOnBlank('https://lowfuelmotorsport.com/profile/' + driver.lfm.id)" />
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Ranking" v-model="driver.lfm.ranking" />
                </v-col>
                <v-col cols="12" sm="3">
                    <v-text-field variant="solo-filled" readonly label="ELO" v-model="driver.lfm.elo" />
                </v-col>
                <v-col cols="12" sm="3">
                    <v-text-field variant="solo-filled" readonly label="SR" v-model="driver.lfm.sr" />
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Participacions" v-model="driver.lfm.enrollments" />
                </v-col>
                <v-col cols="12" sm="6">
                    <Graph :value="driver.lfm.elo_graph" type="ELO" />
                </v-col>
                <v-col cols="12" sm="6">
                    <Graph :value="driver.lfm.sr_graph" type="SR" />
                </v-col>
            </v-row>
        </v-card-text>

        <v-toolbar height="36" v-if="driver.raceroom.id">
            <v-toolbar-title>RaceRoom</v-toolbar-title>
        </v-toolbar>

        <v-card-text v-if="driver.raceroom.id">
            <v-row dense>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Id" v-model="driver.raceroom.id" />
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Ranking" v-model="driver.raceroom.ranking" />
                </v-col>
                <v-col cols="12" sm="3">
                    <v-text-field variant="solo-filled" readonly label="ELO" v-model="driver.raceroom.rating" />
                </v-col>
                <v-col cols="12" sm="3">
                    <v-text-field variant="solo-filled" readonly label="SR" v-model="driver.raceroom.reputation" />
                </v-col>
                <v-col cols="12" sm="6">
                    <Graph :value="driver.raceroom.rating_graph" type="RRating" />
                </v-col>
                <v-col cols="12" sm="6">
                    <Graph :value="driver.raceroom.reputation_graph" type="RReputaion" />
                </v-col>
            </v-row>
        </v-card-text>

        <v-toolbar height="36">
            <v-toolbar-title>Hotlaps</v-toolbar-title>
        </v-toolbar>

        <v-table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Circuit</th>
                    <th>Temps</th>
                    <th>Cotxe</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in driver.hotlaps" :key="item.id">
                    <td>{{ item.category }}</td>
                    <td>{{ item.track }}</td>
                    <td>{{ item.car }}</td>
                    <td>{{ useLaptimeTransformer(item.laptime).ms2human }}</td>
                    <td>{{ useDateTransformer(item.measured_at).hDate }}</td>
                </tr>
            </tbody>
        </v-table>
    </v-card>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useDateTransformer } from '@/composables/useDateTransformer';
import { useLaptimeTransformer } from '@/composables/useLaptimeTransformer';


import { useRoute } from 'vue-router'
import Graph from '../Shared/Graph.vue';
const route = useRoute()


const driver = ref(null);
const fetchData = () => {
    fetch(`/api/driver/${route.params.id}`)
        .then(response => response.json())
        .then(data => driver.value = data);
}
const openOnBlank = (url) => window.open(url, '_blank')

onMounted(() => fetchData())

</script>