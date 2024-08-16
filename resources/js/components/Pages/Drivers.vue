<template>
    <v-card flat>
        <v-data-table
            :mobile-breakpoint="0"
            :headers="headers"
            :items="items"
            :items-per-page="999"
            hide-default-footer
            :sort-by="sortBy"
            density="compact">
            <template v-slot:item="props">
                <tr>
                    <td>
                        <ModelButton model="driver" :id="props.item.id" />
                    </td>
                    <td v-html="props.item.name"></td>
                    <td>
                        <DriverLicense :pitskill="props.item.pitskill" :pitrep="props.item.pitrep" />
                    </td>
                    <td class="text-primary" v-html="props.item.pitrep"></td>
                    <td class="text-blue-400" v-html="props.item.pitskill"></td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useLoaderStore } from '@/stores/loader';
import DriverLicense from '@/components/Shared/DriverLicense.vue';
import ModelButton from '../Shared/ModelButton.vue';
const loaderStore = useLoaderStore();

const headers = [
    { title: '', key: '' },
    { title: 'Pilot' },
    { title: 'Llicència' },
    { title: 'PitRep', key: 'pitrep' },
    { title: 'PitSkill', key: 'pitskill' },
];

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