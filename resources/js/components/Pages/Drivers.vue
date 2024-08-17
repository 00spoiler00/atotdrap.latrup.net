<template>
    <v-card flat>
        <v-card-title class="text-center">Pilots</v-card-title>
        <v-data-table
            :headers="headers"
            :items="items"
            :items-per-page="999"
            hide-default-footer
            :sort-by="sortBy"
            density="compact">
            <template v-slot:item="props">
                <tr>
                    <td>
                        <RouterLink :to="{ name: 'Driver', params: { id: props.item.id } }" class="text-primary">
                            {{ props.item.name }}
                        </RouterLink>
                    </td>
                    <td>
                        <DriverLicense :pitskill="props.item.pitskill" :pitrep="props.item.pitrep" />
                    </td>
                    <td class="text-red-400" v-html="props.item.pitrep"></td>
                    <td class="text-blue-400" v-html="props.item.pitskill"></td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useLoaderStore } from '@/stores/loader';
import DriverLicense from '@/components/Shared/DriverLicense.vue';
import ModelButton from '../Shared/ModelButton.vue';
const loaderStore = useLoaderStore();

const headers = [
    { title: 'Pilot' },
    { title: 'Llicència' },
    { title: 'PitSkill', key: 'pitskill' }, 
    { title: 'PitRep', key: 'pitrep' }, 
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

<!-- <style>
  .v-table > .v-table__wrapper > table > tbody > tr > td,
  .v-table > .v-table__wrapper > table > tbody > tr > th,
  .v-table > .v-table__wrapper > table > thead > tr > td,
  .v-table > .v-table__wrapper > table > thead > tr > th,
  .v-table > .v-table__wrapper > table > tfoot > tr > td,
  .v-table > .v-table__wrapper > table > tfoot > tr > th {
    padding: 0 4px;
  }
</style> -->