<template>
    <v-card flat>
        <v-data-table
            :mobile-breakpoint="0"
            :headers="headers"
            :items="items"
            :items-per-page="999"
            hide-default-footer
            :sort-by="sortBy">
            <template v-slot:item="props">
                <tr>
                    <td>
                        <v-avatar size="36" my-1>
                            <v-img :src="props.item.avatar" />
                        </v-avatar>
                    </td>
                    <td>
                        <v-btn :to="'driver/' + props.item.id" text density="compact" color="primary" variant="plain">
                            {{ props.item.name }}
                        </v-btn>
                    </td>
                    <td>
                        <DriverLicense :pitskill="props.item.pitskill" :pitrep="props.item.pitrep" />
                    </td>
                    <td>
                        <v-btn icon @click="openDialog('PitRep', props.item.pitrep)">
                            <v-icon color="secondary">mdi-chart-line</v-icon>
                        </v-btn>
                        <span>{{ props.item.pitrep }}</span>
                    </td>
                    <td>
                        <v-btn
                            icon
                            @click="openDialog('PitSkill', props.item.Stats.pitskill)">
                            <v-icon color="primary">mdi-chart-line</v-icon>
                        </v-btn>
                        <span>{{ props.item.pitskill }}</span>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useLoaderStore } from '@/stores/loader';
import DriverLicense from '@/components/Shared/DriverLicense.vue';
import ModelCard from '@/components/Shared/ModelCard.vue';
const loaderStore = useLoaderStore();

const headers = [
    { title: '', align: 'start', sortable: false, value: 'avatar_url' },
    { title: 'Pilot', key: 'name' },
    { title: 'Llicència', key: 'license' },
    { title: 'PitRep', key: 'pitrep' },
    { title: 'PitSkill', key: 'pitskill' },
];

const items = ref([]);
const sortBy = ref([{ key: 'pitskill', order: 'desc' }]);

const fetchDrivers = () => {
    loaderStore.add();
    fetch('/api/driver')
        .then((response) => response.json())
        .then((data) => items.value = data)
        .catch((error) => console.error('Error fetching data:', error))
        .finally(() => {
            loaderStore.remove()
            setTimeout(() => fetchDrivers(), 10000);
        });
};

onMounted(() => fetchDrivers());

</script>