<template>
    <v-card flat>

        <v-data-table
            :mobile-breakpoint="0"
            :headers="headers"
            :items="filteredItems"
            class="mt-5"
            disable-pagination
            :hide-default-footer="true"
            dense>
            <template v-slot:item="props">
                <tr class="whitespace-nowrap">
                    <td>
                        <!-- Actions-->
                        <v-btn small icon :href="'https://pitskill.io/event/' + props.item.event_id" target="_blank">
                            <v-icon color="primary">mdi-account-plus</v-icon>
                        </v-btn>
                        <v-btn small icon :to="'/race/' + props.item.id">
                            <v-icon color="primary">mdi-information</v-icon>
                        </v-btn>
                    </td>
                    <td>
                        <v-btn color="primary" variant="text">
                            {{ props.item.drivers.length }}
                            <v-menu activator="parent">
                                <v-list>
                                    <v-list-item v-for="(item, index) in props.item.drivers" :key="index" :value="index" :prepend-avatar="item.avatar_url">
                                        <v-list-item-title>{{ item.name }}</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-btn>

                    </td>
                    <td v-html="momentToDate(props.item.starts_at)"></td>
                    <td v-html="props.item.name"></td>
                    <td v-html="timeUntil(props.item.starts_at)"></td>
                    <td v-html="props.item.registers"></td>
                    <td v-html="props.item.track_name"></td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import moment from 'moment';
import RaceDetailDialog from './RaceDetail.vue';

import { useLoaderStore } from '../stores/loader';
const loaderStore = useLoaderStore();

const search = ref('');
const headers = [
    { align: 'center' },
    { title: 'Pilots', key: 'drivers', value: v => v.length },
    { title: 'Quan', key: 'starts_at', value: 'starts_at' },
    { title: 'Cursa', key: 'name', },
    {},
    { title: 'Registres', key: 'registers' },
    { title: 'Circuit', key: 'track_name' },
];

const items = ref([]);

const fetchData = () => {
    loaderStore.add();
    fetch('/api/race/upcoming')
        .then((response) => response.json())
        .then((data) => items.value = data)
        .catch((error) => console.error('Error fetching data:', error))
        .finally(() => {
            loaderStore.remove()
            setTimeout(fetchData, 20000);
        });
};

const filteredItems = computed(() => {
    const searchTerm = search.value.toLowerCase();
    return items.value.filter((race) =>
        Object.values(race).some((value) =>
            value.toString().toLowerCase().includes(searchTerm)
        )
    );
});

const timeUntil = (ts) => {
    return moment.unix(ts).fromNow();
};

const momentToDate = (ts) => {
    return moment.unix(ts).format('DD/MM HH:mm');
};

onMounted(() => fetchData());

</script>