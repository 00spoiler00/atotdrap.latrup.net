<template>
    <v-card flat>

        <v-toolbar class="text-center" color="primary" title="Ranking de pilots" height="36">
            <v-btn-toggle v-if="xs" v-model="mode" size="small" variant="text" rounded density="compact" divided mandatory>
                <v-btn :value="v" v-for="v in ['PS', 'LFM']" :key="v" v-text="v" />
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
                <tr class="text-center">
                    <td class="text-left">
                        <DriverChip :id="props.item.id" :name="props.item.name" :avatar="props.item.avatar" />
                    </td>
                    <template v-if="xs === false || mode == 'PS'">
                        <td>
                            <PitskillLicense :pitskill="props.item.pitskill" :pitrep="props.item.pitrep" />
                        </td>
                        <td>
                            <v-chip color="primary">
                                <span class="font-bold">
                                    {{ props.item.pitskill }}
                                </span>
                            </v-chip>
                        </td>
                        <td>
                            <v-chip color="secondary">
                                <span class="font-bold">
                                    {{ props.item.pitrep }}
                                </span>
                            </v-chip>
                        </td>
                    </template>
                    <template v-if="xs === false || mode == 'LFM'">
                        <td>
                            <LfmLicense :license="props.item.lfm_license" :srLicense="props.item.lfm_sr_license" />
                        </td>
                        <td>
                            <v-chip color="primary">
                                <span class="font-bold">
                                    {{ props.item.elo }}
                                </span>
                            </v-chip>
                        </td>
                        <td>
                            <v-chip color="secondary">
                                <span class="font-bold">
                                    {{ props.item.sr }}
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
import { ref, onMounted, computed, watch } from 'vue';
import PitskillLicense from '@/components/Shared/PitskillLicense.vue';
import LfmLicense from '../Shared/LfmLicense.vue';

import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();

import { useDisplay } from 'vuetify';
import DriverChip from '../Shared/DriverChip.vue';
const { xs } = useDisplay();

const headers = computed(() => {
    if(xs.value === false){
        return [
            { title: 'Pilot' },
            { title: 'Llicència' },
            { title: 'PS', key: 'pitskill', align: 'center' },
            { title: 'PR', key: 'pitrep', align: 'center' },
            { title: 'LFMLic', align: 'center' },
            { title: 'ELO', key: 'elo', align: 'center' },
            { title: 'SR', key: 'sr', align: 'center' },
        ]
    }else if(mode.value == 'PS'){
        return [
            { title: 'Pilot' },
            { title: 'Llicència' },
            { title: 'PS', key: 'pitskill', align: 'center' },
            { title: 'PR', key: 'pitrep', align: 'center' },
        ]
        
    }else if(mode.value == 'LFM'){
        return [
            { title: 'Pilot' },
            { title: 'Llicència' },
            { title: 'ELO', key: 'elo', align: 'center' },
            { title: 'SR', key: 'sr', align: 'center' },
        ]
    }
})

const items = ref([]);
const sortBy = ref([{ key: 'pitskill', order: 'desc' }]);
const mode = ref('PS');

watch(() => mode.value, (v) => {
    sortBy.value = v === 'PS'
        ? [{ key: 'pitskill', order: 'desc' }]
        : [{ key: 'elo', order: 'desc' }]
})

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