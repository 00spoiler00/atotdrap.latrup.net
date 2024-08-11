<template>
    <v-card flat>
        <v-data-table
            :mobile-breakpoint="0"
            :headers="driverHeaders"
            :items="drivers"
            :items-per-page="999"
            hide-default-footer>
            <template v-slot:item="props">
                <tr>
                    <td>
                        <v-avatar size="36" my-1>
                            <v-img :src="props.item.Image" />
                        </v-avatar>
                    </td>
                    <td>
                        <a
                            :href="'https://pitskill.io/driver-license/' + props.item['Driver Id']"
                            target="_blank">
                            {{ props.item['Driver Name'] }}
                        </a>
                    </td>
                    <td>
                        <DriverLicense :driver="props.item" />
                    </td>
                    <td>
                        <v-btn icon @click="openDialog('PitRep', props.item.Stats.PitRep)">
                            <v-icon color="secondary">mdi-chart-line</v-icon>
                        </v-btn>
                        <span>{{ props.item.PitRep }}</span>
                    </td>
                    <td>
                        <v-btn
                            icon
                            @click="openDialog('PitSkill', props.item.Stats.PitSkill)">
                            <v-icon color="primary">mdi-chart-line</v-icon>
                        </v-btn>
                        <span>{{ props.item.PitSkill }}</span>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, onMounted } from 'vue';

import { useLoaderStore } from '../stores/loader';
import DriverLicense from './DriverLicense.vue';
const loaderStore = useLoaderStore();

const driverHeaders = [
    { title: '', align: 'start', sortable: false, value: 'Image' },
    { title: 'Pilot', key: 'Driver Name' },
    { title: 'Llicència', key: 'Licence' },
    { title: 'PitRep', key: 'PitRep' },
    { title: 'PitSkill', key: 'PitSkill' },
];

const drivers = ref([]);

const fetchDrivers = () => {
    loaderStore.add();
    fetch('/data.json')
        .then((response) => response.json())
        .then((data) => (drivers.value = data.drivers.data))
        .catch((error) => console.error('Error fetching data:', error))
        .finally(() => {
            loaderStore.remove()
            setTimeout(() => fetchDrivers(), 10000);
        });
};

onMounted(() => fetchDrivers());

</script>