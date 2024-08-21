<template>
    <v-card v-if="track">

        <v-toolbar class="text-center" color="primary" :title="track.name" height="36" />

        <v-img
            color="surface-variant"
            height="200"
            :src="track.avatar"
            cover />

        <v-card-text>
            <v-row dense>

                <v-col cols="3">
                    <v-text-field variant="solo-filled" readonly label="Any" v-model="track.track_year" />
                </v-col>

                <v-col cols="3">
                    <v-text-field variant="solo-filled" readonly label="País" v-model="track.country" />
                </v-col>

                <v-col cols="3">
                    <v-text-field variant="solo-filled" readonly label="Corbes" v-model="track.corners" />
                </v-col>

                <v-col cols="3">
                    <v-text-field variant="solo-filled" readonly label="Longitud" v-model="track.length" />
                </v-col>

                <v-col cols="3">
                    <v-text-field variant="solo-filled" readonly label="Dificultat" v-model="track.difficulty" />
                </v-col>

                <v-col cols="3">
                    <v-text-field variant="solo-filled" readonly label="Posicions" v-model="track.max_entries" />
                </v-col>

                <v-col cols="6">
                    <v-text-field variant="solo-filled" readonly label="Ciutat" v-model="track.city" />
                </v-col>

                <v-col cols="12" v-if="track.track_guide">
                    <v-text-field variant="solo-filled" readonly label="Guia del circuit" v-model="track.track_guide" append-icon="mdi-open-in-new" @click:append="openOnBlank(track.track_guide)" />
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
                    <th>Pilot</th>
                    <th>Temps</th>
                    <th>Cotxe</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in track.hotlaps" :key="item.id">
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
import { onMounted, ref, defineProps } from 'vue';
import { useDateTransformer } from '@/composables/useDateTransformer';
import { useLaptimeTransformer } from '@/composables/useLaptimeTransformer';

import { useRoute } from 'vue-router'
const route = useRoute()

// Define the props (id, required)
const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})


const track = ref(null);
const fetchData = () => {
    fetch(`/api/track/${props.id}`)
        .then(response => response.json())
        .then(data => track.value = data);
}

onMounted(() => fetchData())
const openOnBlank = (url) => window.open(url, '_blank')


</script>