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
                        <ModelButton model="race" :id="props.item.id" />
                    </td>
                    <td>
                        {{ props.item.drivers.length }}/{{props.item.registers}}
                    </td>
                    <td v-text="useDateTransformer(props.item.starts_at).fromNow"></td>
                    <td v-text="props.item.name"></td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import moment from 'moment';

import { useDateTransformer } from '@/composables/useDateTransformer';

import { useLoaderStore } from '@/stores/loader';
import ModelButton from '../Shared/ModelButton.vue';
const loaderStore = useLoaderStore();

const headers = [
    { align: 'center' },
    { title: 'Pilots', key: 'drivers', value: v => v.length },
    { title: 'Quan', key: 'starts_at', value: 'starts_at' },
    { title: 'Cursa', key: 'name', },
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