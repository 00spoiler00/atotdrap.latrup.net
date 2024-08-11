<template>

    <v-dialog activator="parent" max-width="800" eager>
        <template v-slot:default="{ isActive }">
            <v-card v-if="race?.value">
                <v-card-title>
                    Detall de la cursa
                </v-card-title>

                <v-card-text class="overflow-y-auto" style="max-height: 80dvh;">
                    Name: {{ race.name }}
                    Enroll: {{ race.enroll }}
                    Start: {{ race.start }}
                    Drivers: {{ race.drivers }}
                    Track: {{ race.track.name }}
                    <v-img :src="'https://cdn.pitskill.io/public/TrackPhoto-' + race.track.image" />
                </v-card-text>

                <template v-slot:actions>
                    <v-btn class="ml-auto" text="Close" @click="isActive.value = false" />
                </template>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
});

const race = ref(null);

onMounted(() => {
    fetch(`/api/race/${props.id}`)
        .then(response => response.json())
        .then(data => {
            console.log(data)
            // race.value = data
        });
});

</script>