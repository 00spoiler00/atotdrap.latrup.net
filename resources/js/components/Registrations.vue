<template>
    <v-card flat>
        <v-card-title>
            <v-text-field v-model="registrationsSearch" label="Cerca registres" append-icon="mdi-magnify" single-line hide-details></v-text-field>
        </v-card-title>
        <v-data-table :mobile-breakpoint="0" :headers="registrationHeaders" :items="filteredRegistrations" class="mt-5" disable-pagination :hide-default-footer="true" dense>
            <template v-slot:item="props">
                <tr class="whitespace-nowrap">
                    <td>
                        <v-progress-circular
                            class="mr-2"
                            :value="getInterest(props.item['Upcoming Event']) * (100 / 10)"
                            :rotate="0"
                            :size="32"
                            :width="4"
                            color="primary">
                            {{ getInterest(props.item['Upcoming Event']) }}
                        </v-progress-circular>

                        <!-- Actions-->
                        <v-btn small icon @click="openDialog('Server', props.item.Server)">
                            <v-icon color="primary">mdi-connection</v-icon>
                        </v-btn>

                        <v-btn
                            small
                            :href="'https://pitskill.io/event/' + props.item['Enroll Link']"
                            target="_blank"
                            icon>
                            <v-icon color="primary">mdi-account-plus</v-icon>
                        </v-btn>

                        <v-btn v-if="props.item['Broadcasted']" small icon @click="openDialog('Emissions', props.item['Broadcasted'])">
                            <v-icon color="primary">mdi-video</v-icon>
                        </v-btn>

                    </td>

                    <td>{{ props.item.Driver }}</td>
                    <td>
                        <div v-text="timeUntil(props.item['On Date'])"></div>
                        <div v-text="props.item['On Date']" class="text-xs"></div>
                    </td>
                    <td>{{ props.item['Upcoming Event'] }}</td>
                    <td>{{ Math.round(parseFloat(props.item['Server SoF']) * 10) / 10 }} ({{ props.item.Registration }})</td>
                    <td>{{ props.item.Car }}</td>
                    <td>
                        <v-btn small icon @click="openDialog('Circuit Image', props.item['Circuit Image'])">
                            <v-icon color="primary">mdi-image</v-icon>
                        </v-btn>
                        {{ props.item.Track }}
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import moment from 'moment'
export default {
    name: 'Registrations',
    data: () => ({
        registrationsSearch: '',
        registrationHeaders: [
            { text: '', value: '', align: 'center' },
            { text: 'Pilot', value: 'Driver' },
            { text: 'Data', value: 'On Date' },
            { text: 'Esdevenimment', value: 'Upcoming Event' },
            { text: 'SoF (#)', value: 'Server SoF' },
            { text: 'Cotxe', value: 'Car' },
            { text: 'Circuit', value: 'Track' },
        ],
        registrations: [],
        dialogData: null,
        dialogMode: null,
        isDialogOpen: false,
    }),
    computed: {

        filteredRegistrations() {
            return this.registrations.filter(registration => {
                const searchTerm = this.registrationsSearch.toLowerCase()
                return Object.values(registration).some(value =>
                    value.toString().toLowerCase().includes(searchTerm)
                )
            })
        },

    },

    created() {
        this.fetchData()
    },

    methods: {

        fetchData() {

            fetch('/data.json')
                .then(response => response.json())
                .then(data => {
                    this.registrations = data.registrations.data
                })
                .catch(error => console.error('Error fetching data:', error))
        },

        getInterest(upcomingEvent) {
            const eventCount = this.registrations.filter(reg => reg['Upcoming Event'] === upcomingEvent).length
            return Math.min(10, eventCount)
        },

        timeUntil(dateString) {
            return moment(dateString, "DD/MM/YY HH:mm").fromNow()
        },

        openDialog(mode, data) {
            this.dialogData = data
            this.dialogMode = mode
            this.isDialogOpen = true
        },
    },

}
</script>