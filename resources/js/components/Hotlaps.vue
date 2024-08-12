<template>
    <v-card flat>
        <v-card-title>
            <small>Hotlaps del <i><b>ATOTDRAP 00 Ps Hotlap BoP</b></i></small>
        </v-card-title>

        <v-card-title>
            <v-row>
                <v-col cols="12" sm="6">
                    <v-select v-model="track" :items="tracks" label="Circuit" hide-details />
                </v-col>
                <v-col cols="12" sm="6">
                    <v-select v-model="categoriesSelected" :items="categories" label="Categoria" hide-details multiple />
                </v-col>
            </v-row>
        </v-card-title>

        <v-data-table
            :mobile-breakpoint="0"
            :headers="headers"
            :items="filteredItems"
            disable-pagination
            hide-default-footer
            :items-per-page="100"
            :sort-by="sortBy">
            <template v-slot:item="props">
                <tr>
                    <td v-html="props.item.car_category"></td>
                    <td v-html="props.item.driver"></td>
                    <td v-html="formatLaptime(props.item.laptime)"></td>
                    <td v-html="props.item.car"></td>
                    <td v-html="props.item.measured_at"></td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const headers = [
    { title: 'Categoria', value: 'car_category' },
    { title: 'Pilot', value: 'driver' },
    { title: 'Temps', value: 'laptime' },
    { title: 'Cotxe', value: 'car' },
    { title: 'Data', value: 'measured_at' },
];

const sortBy = ref([{ key: 'laptime', order: 'asc' }]);

const items = ref([]);
const tracks = ref([]);
const categories = ref(['GT2', 'GT3', 'GT4', 'GTC', 'TCX']);
const categoriesSelected = ref(['GT2', 'GT3', 'GT4', 'GTC', 'TCX']);
const track = ref(null);

const fetchData = () => {
    fetch('/api/hotlap')
        .then((response) => response.json())
        .then((data) => {
            items.value = data;
            const allTracks = items.value.map(i => i.track);
            tracks.value = [...new Set(allTracks)];
            track.value = track.value ?? items.value[0].track;
        })
        .catch((error) => console.error('Error fetching data:', error));
};

const filteredItems = computed(() => {
    return items
        .value
        .filter(i => i.track === track.value)
    // .filter((item) => categoriesSelected.value.includes(item.Category));
});

const formatLaptime = (ms) => {
    const minutes = Math.floor(ms / 60000);
    const seconds = ((ms % 60000) / 1000).toFixed(3);
    return `${minutes}:${seconds.padStart(6, '0')}`;
};

onMounted(() => fetchData());
</script>