<template>
    <v-card flat>

        <v-data-table
            :mobile-breakpoint="0"
            :headers="headers"
            :items="items"
            class="mt-5"
            disable-pagination
            :hide-default-footer="true"
            density="compact">
            <template v-slot:item="props">
                <tr class="whitespace-nowrap">
                    <td>
                        <!-- Actions-->
                        <v-btn density="compact" :href="'https://pitskill.io/event/' + props.item.event_id" target="_blank" variant="text" icon>
                            <v-icon size="sm" color="primary">mdi-account-plus</v-icon>
                        </v-btn>
                    </td>
                    <td>
                        <v-btn color="primary" density="compact" size="small" :color="props.item.drivers.length > 2 ? 'danger' :  (props.item.drivers.length > 1 ? 'warning' : 'primary') ">
                            {{ props.item.drivers.length }}
                            <v-menu activator="parent">
                                <v-list>
                                    <v-list-item v-for="(item, index) in props.item.drivers" :key="index" :value="index" :prepend-avatar="item.avatar_url" :to="'/driver/' + item.id">
                                        <v-list-item-title>{{ item.name }}</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-btn>

                    </td>
                    <td v-html="momentToDate(props.item.starts_at)"></td>
                    <td v-html="timeUntil(props.item.starts_at)"></td>
                    <td>
                        <v-btn :to="'race/' + props.item.id" text density="compact" color="primary" variant="plain">
                            {{ props.item.name }}
                        </v-btn>
                    </td>
                    <td>
                        <v-btn :to="'track/' + props.item.track_id" text density="compact" color="primary" variant="plain">
                            {{ props.item.track_name }}
                        </v-btn>
                    </td>
                    <td v-html="props.item.registers"></td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import moment from 'moment';

import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();

const search = ref('');
const headers = [
    { align: 'center' },
    { title: 'Pilots', key: 'drivers', value: v => v.length },
    { title: 'Quan', key: 'starts_at', value: 'starts_at' },
    {},
    { title: 'Cursa', key: 'name', },
    { title: 'Circuit', key: 'track_name' },
    { title: 'Registres', key: 'registers' },
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

const timeUntil = (ts) => {
    return moment.unix(ts).fromNow();
};

const momentToDate = (ts) => {
    return moment.unix(ts).format('DD/MM HH:mm');
};

onMounted(() => fetchData());

</script>