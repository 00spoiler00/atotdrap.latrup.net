<template>
    <div v-if="track">

        <v-row>
            <v-col cols="12" md="6">
                <v-row>
                    <v-col cols="12" sm="2" md="12">
                        <v-text-field variant="solo-filled" readonly label="Nom" v-model="track.name" />
                    </v-col>

                    <v-col cols="12" sm="2" md="2">
                        <v-text-field variant="solo-filled" readonly label="Any" v-model="track.track_year" />
                    </v-col>

                    <v-col cols="12" sm="2" md="2">
                        <v-text-field variant="solo-filled" readonly label="País" v-model="track.country" />
                    </v-col>

                    <v-col cols="12" sm="2" md="2">
                        <v-text-field variant="solo-filled" readonly label="Corbes" v-model="track.corners" />
                    </v-col>

                    <v-col cols="12" sm="2" md="2">
                        <v-text-field variant="solo-filled" readonly label="Longitud" v-model="track.length" />
                    </v-col>

                    <v-col cols="12" sm="2" md="2">
                        <v-text-field variant="solo-filled" readonly label="Dificultat" v-model="track.difficulty" />
                    </v-col>

                    <v-col cols="12" sm="2" md="2">
                        <v-text-field variant="solo-filled" readonly label="Posicions" v-model="track.max_entries" />
                    </v-col>

                    <v-col cols="12" sm="2" md="6">
                        <v-text-field variant="solo-filled" readonly label="Ciutat" v-model="track.city" />
                    </v-col>

                    <v-col cols="12" sm="2" md="6">
                        <v-text-field variant="solo-filled" readonly label="Guia del circuit" v-model="track.track_guide" />
                    </v-col>

                </v-row>
            </v-col>

            <v-col cols="12" sm="6">
                <v-img :src="'https://cdn.pitskill.io/public/TrackPhoto-' + track.thumbnail" class="rounded-md" />
            </v-col>

        </v-row>
    </div>


</template>

<script setup>
import { onMounted, ref } from 'vue';
const track = ref(null);

// Define the id as a prop
const props = defineProps({
    id: {
        type: Number,
        required: true
    }
});

const fetchData = () => {
    fetch(`/api/track/${props.id}`)
        .then(response => response.json())
        .then(data => track.value = data);
}

onMounted(() => fetchData())

</script>