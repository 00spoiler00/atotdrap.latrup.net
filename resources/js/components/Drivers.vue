<template>
    <v-card flat>
        <v-card-title>
            <v-text-field v-model="driversSearch" label="Cerca pilots" append-icon="mdi-magnify" single-line hide-details></v-text-field>
        </v-card-title>
        <v-data-table :mobile-breakpoint="0" :headers="driverHeaders" :items="filteredDrivers" disable-pagination :hide-default-footer="true">
            <template v-slot:item="props">
                <tr>
                    <td>
                        <v-avatar size="36" my-1>
                            <v-img :src='props.item.Image' />
                        </v-avatar>
                    </td>
                    <td>
                        <a :href="'https://pitskill.io/driver-license/' + props.item['Driver Id']" target="_blank">
                            {{ props.item['Driver Name'] }}
                        </a>
                    </td>
                    <td>
                        <div v-if="getLicence(props.item) === 'Provisional'" class="h-8 w-28 font-bold rounded-xl border-2 bg-red-800 border-yellow-400 text-center py-1">Provisional</div>
                        <div v-else-if="getLicence(props.item) === 'Bronze'" class="h-8 w-28 font-bold rounded-xl border-2 bg-red-800 border-red-800 text-center py-1">Bronze</div>
                        <div v-else-if="getLicence(props.item) === 'Silver'" class="h-8 w-28 font-bold rounded-xl border-2 border-gray-400 bg-gray-400  text-center py-1 text-black">Silver</div>
                        <div v-else-if="getLicence(props.item) === 'Platinum'" class="h-8 w-28 font-bold rounded-xl border-2 border-white bg-white text-center py-1 text-black">Platinum</div>
                        <div v-else-if="getLicence(props.item) === 'Elite'" class="h-8 w-28 font-bold rounded-xl border-2 border-yellow-400 text-center py-1 text-yellow-400">Elite</div>
                        <div v-else class="h-8 w-28 font-bold rounded-xl border-2 border-yellow-400 text-center py-1 text-yellow-400">????</div>
                    </td>
                    <td>
                        <v-btn icon @click="openDialog('PitRep', props.item.Stats.PitRep)">
                            <v-icon color="secondary">mdi-chart-line</v-icon>
                        </v-btn>
                        <span>{{ props.item.PitRep }}</span>
                    </td>
                    <td>
                        <v-btn icon @click="openDialog('PitSkill', props.item.Stats.PitSkill)">
                            <v-icon color="primary">mdi-chart-line</v-icon>
                        </v-btn>
                        <span>{{ props.item.PitSkill }}</span>
                    </td>
                </tr>
            </template>
        </v-data-table>

    </v-card>
</template>

<script>
export default {
    name: 'Drivers',
    data: () => ({
        driversSearch: '',
        driverHeaders: [
            { text: '', align: 'start', sortable: false, value: 'Image' },
            { text: 'Pilot', value: 'Driver Name' },
            { text: 'Llicència', value: 'Licence' },
            { text: 'PitRep', value: 'PitRep' },
            { text: 'PitSkill', value: 'PitSkill' },
        ],

        drivers: [],

        dialogData: null,
        dialogMode: null,
        isDialogOpen: false,

    }),
    computed: {

        filteredDrivers() {
            return this.drivers.filter(driver => {
                const searchTerm = this.driversSearch.toLowerCase()
                return Object.values(driver).some(value =>
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
                .then(data => this.drivers = data.drivers.data)
                .catch(error => console.error('Error fetching data:', error))
        },

        getLicence(item) {
            const pitrep = item.PitRep
            const pitskill = item.PitSkill

            if (pitrep >= 20 && pitskill >= 3500) return 'Elite'
            if (pitrep >= 15 && pitskill >= 2750) return 'Platinum'
            if (pitrep >= 10 && pitskill >= 1900) return 'Silver'
            return (pitrep > 5) ? 'Bronze' : 'Provisional'
        },

        openDialog(mode, data) {
            this.dialogData = data
            this.dialogMode = mode
            this.isDialogOpen = true
        },

    },

}
</script>