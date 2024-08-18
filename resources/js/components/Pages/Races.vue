<template>
    <v-card flat>
        
        <v-toolbar class="text-center" color="primary" title="Properes curses" height="36"/>

        <v-data-table
            :headers="headers"
            :items="items"
            disable-pagination
            :hide-default-footer="true"
            density="compact">
            <template v-slot:item="props">
                <tr class="whitespace-nowrap">

                    <td>
                        <RouterLink :to="{ name: 'Race', params: { id: props.item.id } }" class="text-primary">
                            {{ props.item.name }}
                        </RouterLink>
                    </td>
                    <td v-text="useDateTransformer(props.item.starts_at).fromNow"></td>
                    <td>
                        {{ props.item.drivers.length }}/{{ props.item.registers }}
                    </td>

                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, onMounted } from 'vue';

import { useDateTransformer } from '@/composables/useDateTransformer';

import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();

const headers = [
    { title: 'Cursa', key: 'name', },
    { title: 'Quan', key: 'starts_at', value: 'starts_at' },
    { title: 'Pilots', key: 'drivers', value: v => v.length },
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


onMounted(() => fetchData());

</script>