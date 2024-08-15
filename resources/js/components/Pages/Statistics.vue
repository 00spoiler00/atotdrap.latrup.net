<template>
    <v-container class="mt-4">
        <v-row>

            <!-- Promos-->
            <v-col cols="12" sm="6" md="4">
                <v-card flat>
                    <v-card-title>Promocions</v-card-title>
                    <v-card-subtitle>Noves llicències</v-card-subtitle>
                    <v-col v-for="dId in changes.value.Promotions" :key="dId" cols="12">
                        <v-card color="warning">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-certificate</v-icon>
                                <v-spacer></v-spacer>
                                <div class="text-white" v-html="getDriverName(dId)"></div>
                            </v-card-title>
                        </v-card>
                    </v-col>
                </v-card>
            </v-col>

            <!-- Rep -->
            <v-col cols="12" sm="6" md="4">
                <v-card flat>
                    <v-card-title>PitRep</v-card-title>
                    <v-card-subtitle>Pujant</v-card-subtitle>
                    <v-col v-for="(value, key) in changes.value.PitRepIncreases" :key="key" cols="12">
                        <v-card color="success">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-arrow-up-bold</v-icon>
                                {{ formatValue(value) }}
                                <v-spacer></v-spacer>
                                {{ getDriverName(key) }}
                            </v-card-title>
                        </v-card>
                    </v-col>
                    <v-card-subtitle>Baixant</v-card-subtitle>
                    <v-col v-for="(value, key) in changes.value.PitRepDecreases" :key="key" cols="12">
                        <v-card color="error">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-arrow-down-bold</v-icon>
                                {{ formatValue(value) }}
                                <v-spacer></v-spacer>
                                {{ getDriverName(key) }}
                            </v-card-title>
                        </v-card>
                    </v-col>
                </v-card>
            </v-col>

            <!-- Skill -->
            <v-col cols="12" sm="6" md="4">
                <v-card flat>
                    <v-card-title>PitSkill</v-card-title>
                    <v-card-subtitle>Pujant</v-card-subtitle>
                    <v-col v-for="(value, key) in changes.value.PitSkillIncreases" :key="key" cols="12">
                        <v-card color="success">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-arrow-up-bold</v-icon>
                                {{ formatValue(value, 1) }}
                                <v-spacer></v-spacer>
                                {{ getDriverName(key) }}
                            </v-card-title>
                        </v-card>
                    </v-col>

                    <v-card-subtitle>Baixant</v-card-subtitle>
                    <v-col v-for="(value, key) in changes.value.PitSkillDecreases" :key="key" cols="12">
                        <v-card color="error">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-arrow-down-bold</v-icon>
                                {{ formatValue(value, 1) }}
                                <v-spacer></v-spacer>
                                {{ getDriverName(key) }}
                            </v-card-title>
                        </v-card>
                    </v-col>

                </v-card>
            </v-col>

        </v-row>
    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const pitRepIncreases = ref([]);
const pitRepDecreases = ref([]);
const pitSkillIncreases = ref([]);
const pitSkillDecreases = ref([]);
const promotions = ref([]);

const fetchData = () => {
    fetch('/api/movements')
        .then((response) => response.json())
        .then((data) => {
            pitRepIncreases = data.pitRepIncreases;
            pitRepDecreases = data.pitRepDecreases;
            pitSkillIncreases = data.pitSkillIncreases;
            pitSkillDecreases = data.pitSkillDecreases;
            promotions = data.promotions;
        })
        .catch((error) => console.error('Error fetching data:', error));
};

const formatValue = (value, decimals = 2) => {
    return Math.round(parseFloat(value) * Math.pow(10, decimals)) / Math.pow(10, decimals);
};

onMounted(() => fetchData());
</script>
