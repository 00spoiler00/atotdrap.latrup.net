<template>

    <v-toolbar class="text-center" color="primary" title="Hotlaps del ATOTDRAP 00 Ps Hotlap BoP" height="36" :rounded="smAndUp" />

    <v-row class="ma-0 sm:ma-2">
        
        <v-col cols="12" sm="3">
            <ModelSelector v-model="track" modelName="track" multiple clearable chips hide-details label="Circuit" />
        </v-col>
        <v-col cols="12" sm="3">
            <ModelSelector v-model="driver" modelName="driver" multiple clearable chips hide-details label="Pilot" />
        </v-col>
        <v-col cols="12" sm="3">
            <ModelSelector v-model="car" modelName="car" multiple clearable chips hide-details label="Cotxe" />
        </v-col>
        <v-col cols="12" sm="3">
            <v-select v-model="mode" :items="modes" hide-details label="Mode" />
        </v-col>

        <v-col cols="12">
            <v-data-table
                :mobile-breakpoint="0"
                :headers="headers"
                :items="items"
                :items-per-page="20"
                :sort-by="sortBy">
                <!-- hide-default-footer
            disable-pagination -->
                <template v-slot:item="props">
                    <tr>
                        <td v-html="props.item.category"></td>
                        <td v-html="props.item.driver"></td>
                        <td v-html="props.item.track"></td>
                        <td v-html="props.item.car"></td>
                        <td>{{ useLaptimeTransformer(props.item.laptime).ms2human }}</td>
                        <td>{{ useDateTransformer(props.item.measured_at).hDate }}</td>
                    </tr>
                </template>
            </v-data-table>
        </v-col>

    </v-row>

</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useLaptimeTransformer } from '@/composables/useLaptimeTransformer';
import { useDateTransformer } from '@/composables/useDateTransformer';
import ModelSelector from '../Shared/ModelSelector.vue';
import { useDisplay } from 'vuetify';

const { smAndUp } = useDisplay();

const headers = [
    { title: 'Categoria', value: 'category' },
    { title: 'Pilot', value: 'driver' },
    { title: 'Circuit', value: 'track' },
    { title: 'Cotxe', value: 'car' },
    { title: 'Temps', value: 'laptime' },
    { title: 'Data', value: 'measured_at' },
];

const sortBy = ref([{ key: 'laptime', order: 'asc' }]);

const modes = [
    { title: 'Millor', value: 'best_driver' },
    { title: 'Incloure combos ', value: 'best_combo' },
    { title: 'Tots els registres', value: 'all' },
];
const mode = ref('best_driver');

const items = ref([]);
const track = ref([]);
const driver = ref([]);
const car = ref([]);
const url = computed(() => {
    const params = new URLSearchParams();
    if (track.value.length) params.append('track_id', track.value.join(','));
    if (driver.value.length) params.append('driver_id', driver.value.join(','));
    if (car.value.length) params.append('car_id', car.value.join(','));
    params.append('mode', mode.value);
    return '/api/hotlap?' + params.toString();
});
watch([url], () => fetchData());
const fetchData = () => {
    fetch(url.value)
        .then((response) => response.json())
        .then((data) => items.value = data)
        .catch((error) => console.error('Error fetching data:', error));
};
onMounted(() => fetchData());
</script>