<template>
    <v-card flat>

        <v-toolbar class="text-center" color="primary" title="Ranking de pilots" height="36">

            <v-btn-toggle v-if="xs" v-model="mode" size="small" rounded density="compact" divided mandatory class="mr-2">
                <v-btn :value="v" v-for="v in ['PS', 'LFM']" :key="v" v-text="v" :variant="mode == v ? 'elevated' : 'plain'" color="primary" />
            </v-btn-toggle>

        </v-toolbar>

        <v-data-table
            :headers="headers"
            :items="items"
            :items-per-page="999"
            :sort-by="sortBy"
            hide-default-footer
            density="comfortable">
            <template v-slot:item="props">
                <tr>
                    <td class="text-left">
                        <DriverChip :id="props.item.id" :name="props.item.name" :avatar="props.item.avatar" />
                    </td>
                    <template v-if="xs === false || mode == 'PS'">
                        <td class="text-center">
                            <PitskillLicense :pitskill="props.item.pitskill" :pitrep="props.item.pitrep" />
                        </td>
                        <td class="text-center">
                            <v-chip color="primary">
                                <span class="font-bold">
                                    {{ props.item.pitskill }}
                                </span>
                            </v-chip>
                        </td>
                        <td class="text-center">
                            <v-chip color="secondary">
                                <span class="font-bold">
                                    {{ props.item.pitrep }}
                                </span>
                            </v-chip>
                        </td>
                    </template>
                    <template v-if="xs === false || mode == 'LFM'">
                        <td class="text-center">
                            <LfmLicense :license="props.item.lfm_license" :srLicense="props.item.lfm_sr_license" />
                        </td>
                        <td class="text-center">
                            <v-chip color="primary">
                                <span class="font-bold">
                                    {{ props.item.elo }}
                                </span>
                            </v-chip>
                        </td>
                        <td class="text-center">
                            <v-chip color="secondary">
                                <span class="font-bold">
                                    {{ props.item.sr }}
                                </span>
                            </v-chip>
                        </td>
                    </template>
                    <template v-if="xs === false || mode == 'RR'">
                        <td class="text-center">
                            <v-chip color="primary">
                                <span class="font-bold">
                                    {{ props.item.raceroom_rating }}
                                </span>
                            </v-chip>
                        </td>
                        <td class="text-center">
                            <v-chip color="secondary">
                                <span class="font-bold">
                                    {{ props.item.raceroom_reputation }}
                                </span>
                            </v-chip>
                        </td>
                    </template>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import PitskillLicense from '@/components/Shared/PitskillLicense.vue';
import LfmLicense from '../Shared/LfmLicense.vue';

import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();

import { useDisplay } from 'vuetify';
import DriverChip from '../Shared/DriverChip.vue';
const { xs } = useDisplay();

const headers = computed(() => {
    if (xs.value === false) {
        return [
            { title: 'Pilot' },
            { title: 'Llicència' },
            { title: 'PS', key: 'pitskill', align: 'center' },
            { title: 'PR', key: 'pitrep', align: 'center' },
            { title: 'Llicència' },
            { title: 'ELO', key: 'elo', align: 'center' },
            { title: 'SR', key: 'sr', align: 'center' },
            { title: 'RRat', key: 'raceroom_rating', align: 'center' },
            { title: 'RRep', key: 'raceroom_reputation', align: 'center' },
        ]
    } else if (mode.value == 'PS') {
        return [
            { title: 'Pilot' },
            { title: 'Llicència' },
            { title: 'PS', key: 'pitskill', align: 'center' },
            { title: 'PR', key: 'pitrep', align: 'center' },
        ]

    } else if (mode.value == 'LFM') {
        return [
            { title: 'Pilot' },
            { title: 'Llicència' },
            { title: 'ELO', key: 'elo', align: 'center' },
            { title: 'SR', key: 'sr', align: 'center' },
        ]
    } else if (mode.value == 'RR') {
        return [
            { title: 'Pilot' },
            { title: 'Llicència' },
            { title: 'RRat', key: 'raceroom_rating', align: 'center' },
            { title: 'RRep', key: 'raceroom_reputation', align: 'center' },
        ]
    }
})

const items = ref([]);
const sortBy = ref([{ key: 'pitskill', order: 'desc' }]);
const savedMode = localStorage.getItem('driversMode') || 'PS';
const mode = ref(savedMode)

watch(() => mode.value, (v) => {
    localStorage.setItem('driversMode', v)

    // make this a switch with PS, LFM, RR
    switch (v) {
        case 'PS':
            sortBy.value = [{ key: 'pitskill', order: 'desc' }]
            break;
        case 'LFM':
            sortBy.value = [{ key: 'elo', order: 'desc' }]
            break;
        case 'RR':
            sortBy.value = [{ key: 'raceroom_rating', order: 'desc' }]
            break;
    }
})

var refreshThread = null;
const fetchDrivers = () => {
    loaderStore.add();
    fetch('/api/driver')
        .then((response) => response.json())
        .then((data) => items.value = data)
        .catch((error) => console.error('Error fetching data:', error))
        .finally(() => {
            loaderStore.remove()
            refreshThread = setTimeout(() => fetchDrivers(), 60000);
        });
};

onMounted(() => fetchDrivers());
onUnmounted(() => clearTimeout(refreshThread));


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