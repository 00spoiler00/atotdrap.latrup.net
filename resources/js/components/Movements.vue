<template>
    <v-container class="mt-4">
        <v-row>

            <v-col cols="12" sm="6" md="4">
                <v-card flat>
                    <v-card-title>Promocions</v-card-title>
                    <v-card-subtitle>Noves llicències</v-card-subtitle>
                    <v-col v-for="dId in changes.Promotions" :key="dId" cols="12">
                        <v-card color="warning">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-certificate</v-icon>
                                <v-spacer></v-spacer>
                                <div class="text-white" v-html="drivers.find(d => d['Driver Id'] == dId)['Driver Name']"></div>
                            </v-card-title>
                        </v-card>
                    </v-col>
                </v-card>
            </v-col>


            <v-col cols="12" sm="6" md="4">
                <v-card flat>
                    <v-card-title>PitRep</v-card-title>
                    <v-card-subtitle>Pujant</v-card-subtitle>
                    <v-col v-for="(value, key) in changes.PitRepIncreases" :key="key" cols="12">
                        <v-card color="success">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-arrow-up-bold</v-icon>
                                {{ Math.round(parseFloat(value) * 100) / 100 }}
                                <v-spacer></v-spacer>
                                {{ drivers.find(d => d['Driver Id'] == key)['Driver Name'] }}
                            </v-card-title>
                        </v-card>
                    </v-col>
                    <v-card-subtitle>Baixant</v-card-subtitle>
                    <v-col v-for="(value, key) in changes.PitRepDecreases" :key="key" cols="12">
                        <v-card color="error">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-arrow-down-bold</v-icon>
                                {{ Math.round(parseFloat(value) * 100) / 100 }}
                                <v-spacer></v-spacer>
                                {{ drivers.find(d => d['Driver Id'] == key)['Driver Name'] }}
                            </v-card-title>
                        </v-card>
                    </v-col>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" md="4">
                <v-card flat>
                    <v-card-title>PitSkill</v-card-title>
                    <v-card-subtitle>Pujant</v-card-subtitle>
                    <v-col v-for="(value, key) in changes.PitSkillIncreases" :key="key" cols="12">
                        <v-card color="success">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-arrow-up-bold</v-icon>
                                {{ Math.round(parseFloat(value) * 10) / 10 }}
                                <v-spacer></v-spacer>
                                {{ drivers.find(d => d['Driver Id'] == key)['Driver Name'] }}
                            </v-card-title>
                        </v-card>
                    </v-col>

                    <v-card-subtitle>Baixant</v-card-subtitle>
                    <v-col v-for="(value, key) in changes.PitSkillDecreases" :key="key" cols="12">
                        <v-card color="error">
                            <v-card-title class="flex">
                                <v-icon left color="white">mdi-arrow-down-bold</v-icon>
                                {{ Math.round(parseFloat(value) * 10) / 10 }}
                                <v-spacer></v-spacer>
                                {{ drivers.find(d => d['Driver Id'] == key)['Driver Name'] }}
                            </v-card-title>
                        </v-card>
                    </v-col>
                </v-card>
            </v-col>

        </v-row>


    </v-container>
</template>

<script>
export default {
    name: 'Movements',
    data: () => ({
        drivers: [],
        changes: {
            PitRepIncreases: {},
            PitRepDecreases: {},
            PitSkillIncreases: {},
            PitSkillDecreases: {},
        },
    }),

    created() {
        this.fetchData()
    },

    methods: {

        fetchData() {
            fetch('/data.json')
                .then(response => response.json())
                .then(data => {
                    this.drivers = data.drivers.data
                    this.changes = data.changes
                })
                .catch(error => console.error('Error fetching data:', error))
        },

    },

}
</script>