<template>

    <v-card v-if="driver" class="ma-4">

        <v-toolbar height="48">
            <v-toolbar-title :text="driver.name" />
        </v-toolbar>

        <v-img
            color="surface-variant"
            height="200"
            :src="driver.avatar"
            cover>

        </v-img>

        <v-card-text>
            <v-row dense>

                <v-col cols="12" sm="4">
                    <v-text-field variant="solo-filled" readonly label="Nom" v-model="driver.first_name" />
                </v-col>

                <v-col cols="12" sm="4">
                    <v-text-field variant="solo-filled" readonly label="Cognom" v-model="driver.last_name" />
                </v-col>

                <v-col cols="12" sm="4">
                    <v-text-field variant="solo-filled" readonly label="Nick" v-model="driver.nickname" />
                </v-col>

            </v-row>
        </v-card-text>

        <v-toolbar height="36">
            <v-toolbar-title>PitSkill IO</v-toolbar-title>
        </v-toolbar>

        <v-card-text>
            <v-row dense>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Id" v-model="driver.pitskill_id" />
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Ranking" v-model="driver.pitskill_ranking" />
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="PitSkill" v-model="driver.pitskill" />
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="PitRep" v-model="driver.pitrep" />
                </v-col>
                <v-col cols="12" sm="2">
                    <v-text-field variant="solo-filled" readonly label="Participacions" v-model="driver.pitskill_enrollments" />
                </v-col>
                <v-col cols="12" sm="2" align="center" justify="center">
                    <v-btn block color="primary" @click="openOnBlank('https://pitskill.io/driver-license/' + driver.pitskill_id)" prepend-icon="mdi-magnify">
                        Perfil
                    </v-btn>
                </v-col>
                <v-col cols="12" sm="6">
                    <Graph :value="driver.pitskill_graph" type="PitSkill" />
                </v-col>
                <v-col cols="12" sm="6">
                    <Graph :value="driver.pitrep_graph" type="PitRep" />
                </v-col>
            </v-row>
        </v-card-text>

        <v-toolbar height="36">
            <v-toolbar-title>LowFuelMotorsport</v-toolbar-title>
        </v-toolbar>

        <v-row>
            <v-col cols="12">
                Aviat...
            </v-col>
        </v-row>


        <v-toolbar height="36">
            <v-toolbar-title>Hotlaps</v-toolbar-title>
        </v-toolbar>

        <v-table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Pilot</th>
                    <th>Temps</th>
                    <th>Cotxe</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in driver.hotlaps" :key="item.id">
                    <td>{{ item.car_category }}</td>
                    <td>{{ item.driver }}</td>
                    <td>{{ useLaptimeTransformer(item.laptime).ms2human }}</td>
                    <td>{{ item.car }}</td>
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