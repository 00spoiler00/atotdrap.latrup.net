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
            :hide-default-footer="true">
            <template v-slot:item="props">
                <tr>
                    <td v-html="props.item['Category']"></td>
                    <td v-html="props.item['Driver']"></td>
                    <td v-html="formatLaptime(props.item['Laptime'])"></td>
                    <td v-html="props.item['CarModel']"></td>
                    <td v-html="props.item['Date']"></td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const headers = [
    { text: 'Categoria', value: 'Category' },
    { text: 'Pilot', value: 'Driver' },
    { text: 'Temps', value: 'Laptime' },
    { text: 'Cotxe', value: 'CarModel' },
    { text: 'Data', value: 'Date' },
];

const sortBy = ref({ key: 'Laptime', order: 'desc' });

const items = ref([]);
const tracks = ref([]);
const categories = ref(['GT2', 'GT3', 'GT4', 'GTC', 'TCX']);
const categoriesSelected = ref(['GT2', 'GT3', 'GT4', 'GTC', 'TCX']);
const track = ref(null);

const fetchData = () => {
    fetch('/hotlaps.json')
        .then((response) => response.json())
        .then((data) => {
            items.value = data;
            tracks.value = Object.keys(data).map((track) => ({
                text: track
                    .toLowerCase()
                    .split('_')
                    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(''),
                value: track,
            }));

            track.value = track.value ?? getMostRecentUpdatedHotlapTrack(data);
        })
        .catch((error) => console.error('Error fetching data:', error));
};

const filteredItems = computed(() => {
    return items.value[track.value] ?? [];
});

const formatLaptime = (ms) => {
    const minutes = Math.floor(ms / 60000);
    const seconds = ((ms % 60000) / 1000).toFixed(3);
    return `${minutes}:${seconds.padStart(6, '0')}`;
};

const getMostRecentUpdatedHotlapTrack = (data) => {
    let mostRecentTrack = null;
    let mostRecentDate = null;

    for (const [track, laps] of Object.entries(data)) {
        laps.forEach((lap) => {
            const lapDate = new Date(lap.Date);
            if (!mostRecentDate || lapDate > mostRecentDate) {
                mostRecentDate = lapDate;
                mostRecentTrack = track;
            }
        });
    }

    return mostRecentTrack;
};

onMounted(() => fetchData());
</script>