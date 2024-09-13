<template>
    <v-card flat>

        <v-toolbar class="text-center" color="primary" title="Medalles de circuits" height="36" />

        <div class="text-center my-4">
            Temps referència a <a href="https://www.accreplay.com/" target="_blank">ACCreplay</a>
            <v-divider vertical />
            <span class="mx-4 text-yellow">Or < 1.015%</span>
            <v-divider vertical />
            <span class="mx-4 text-grey">Plata: < 1.025% </span>
            <v-divider vertical />
            <span class="mx-4 text-orange">Bronze: < 1.035%</span>
        </div>

                <v-table>
                    <tbody>
                        <tr v-for="item in items" :key="item.driver.id">
                            <td>
                                <DriverChip :id="item.driver.id" :name="item.driver.name" :avatar="item.driver.avatar" />
                            </td>
                            <td>
                                {{ item.total }}
                            </td>
                            <td v-for="result in item.medals">
                                <v-tooltip v-if="result.medal != 'none'" :text="result.tooltip">
                                    <template v-slot:activator="{ props }">
                                        <v-btn v-bind="props" icon variant="text" density="compact">
                                            <v-icon v-if="result.medal == 'bronze'" color="orange">mdi-medal</v-icon>
                                            <v-icon v-else-if="result.medal == 'silver'" color="grey">mdi-medal</v-icon>
                                            <v-icon v-else-if="result.medal == 'gold'" color="yellow">mdi-medal</v-icon>
                                        </v-btn>
                                    </template>
                                </v-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
    </v-card>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();

import DriverChip from '../Shared/DriverChip.vue';

const items = ref([]);

var refreshThread = null;
const fetchMedals = () => {
    loaderStore.add();
    fetch('/api/trackMedals')
        .then((response) => response.json())
        .then((data) => items.value = data)
        .catch((error) => console.error('Error fetching data:', error))
        .finally(() => {
            loaderStore.remove()
            refreshThread = setTimeout(() => fetchMedals(), 60000);
        });
};

onMounted(() => fetchMedals());
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
