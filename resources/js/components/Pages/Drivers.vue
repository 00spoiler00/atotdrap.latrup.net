<template>
    <v-card flat>

        <v-toolbar class="text-center" color="primary" title="Ranking de pilots" height="36"/>

        <v-data-table
            :headers="headers"
            :items="items"
            :items-per-page="999"
            hide-default-footer
            :sort-by="sortBy"
            density="comfortable"
            >
            <template v-slot:item="props">
                <tr class="text-center">
                    <td class="text-left">
                        <!-- <v-avatar size="36">
                            <v-img :src="props.item.avatar" class="relative">
                                <div class="absolute inset-0 bg-gradient-to-l from-black to-transparent opacity-60"></div>
                            </v-img>
                        </v-avatar>
                        <RouterLink :to="{ name: 'Driver', params: { id: props.item.id } }" class=" relative right-2 top-2">
                                {{ props.item.name }}
                        </RouterLink> -->

                        <DriverChip :id="props.item.id" :name="props.item.name" :avatar="props.item.avatar" />

                    </td>
                    <td>
                        <DriverLicense :pitskill="props.item.pitskill" :pitrep="props.item.pitrep" />
                    </td>
                    <td>
                        <v-chip color="primary" >
                            <span class="font-bold">
                                {{ props.item.pitskill }}
                            </span>
                        </v-chip>
                    </td>
                    <td>
                        <v-chip color="secondary" >
                            <span class="font-bold">
                                {{ props.item.pitrep }}
                            </span>
                        </v-chip>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import DriverLicense from '@/components/Shared/DriverLicense.vue';

import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();

import { useDisplay } from 'vuetify';
import DriverChip from '../Shared/DriverChip.vue';
const display = useDisplay();

const headers = [
    { title: 'Pilot' },
    { title: 'Llicència', align: 'center' },
    { title: 'PS', key: 'pitskill', align: 'center' },
    { title: 'PR', key: 'pitrep', align: 'center' },
]

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