<template>

    <v-card v-if="enrollment" class="elevation-10">
        <v-card-title>
            Inscripció
        </v-card-title>

        <v-card-text>
            <v-row>
                <v-col cols="12" md="6">
                    <v-row>
                        <v-col cols="12" sm="2" md="4">
                            <v-text-field variant="solo-filled" readonly label="Pilot" v-model="enrollment.driver.name" />
                        </v-col>
                        <v-col cols="12" sm="2" md="4">
                            <v-text-field variant="solo-filled" readonly label="Cotxe" v-model="enrollment.car" />
                        </v-col>
                        <v-col cols="12" sm="2" md="4">
                            <v-text-field variant="solo-filled" readonly label="Server" v-model="enrollment.server_name" />
                        </v-col>
                        <v-col cols="12" sm="2" md="4">
                            <v-text-field variant="solo-filled" readonly label="SoF" v-model="enrollment.sof" />
                        </v-col>
                        <v-col cols="12" sm="2" md="4">
                            <v-text-field variant="solo-filled" readonly label="Split" v-model="enrollment.split" />
                        </v-col>
                    </v-row>
                </v-col>

                <v-col cols="12" sm="6">
                    <v-avatar size="16">
                        <v-img :src="enrollment.driver.avatar_url" />
                    </v-avatar>
                </v-col>
            </v-row>

        </v-card-text>

    </v-card>

</template>

<script setup>
import { onMounted, ref } from 'vue';
const enrollment = ref(null);

// Define the id as a prop
const props = defineProps({
    id: {
        type: Number,
        required: true
    }
});

const fetchData = () => {
    fetch(`/api/enrollment/${props.id}`)
        .then(response => response.json())
        .then(data => enrollment.value = data);
}

onMounted(() => fetchData())

</script>