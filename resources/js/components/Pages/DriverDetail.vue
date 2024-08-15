<template>

    <v-card v-if="driver">
        <v-card-title>
            Detall del pilot
        </v-card-title>

        <!-- <a
                            :href="'https://pitskill.io/driver-license/' + props.item['Driver Id']"
                            target="_blank">
                            {{ props.item['Driver Name'] }}
                        </a> -->


        <v-card-text>
            <v-row>
                <v-col cols="12" sm="6" md="4">
                    <v-text-field variant="solo-filled" readonly label="Nom" v-model="driver.name" />
                </v-col>
            </v-row>
        </v-card-text>

    </v-card>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useDateTransformer } from '@/composables/useDateTransformer';

import { useRoute } from 'vue-router'
const route = useRoute()

const driver = ref(null);

const fetchData = () => {
    fetch(`/api/driver/${route.params.id}`)
        .then(response => response.json())
        .then(data => driver.value = data);
}

// const startsAt = useDateTransformer(driver.value?.starts_at).readableHour

onMounted(() => fetchData())


</script>