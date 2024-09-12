<template>
    <v-card
        class="mx-auto text-center"
        :color="color"
        dark>
        <v-card-text>
            <v-sheet color="rgba(0, 0, 0, .12)">
                <v-sparkline
                    :model-value="inRangeValues"
                    color="rgba(255, 255, 255, .7)"
                    padding="12"
                    stroke-linecap="round"
                    height="200"
                    smooth>
                    <!-- <template v-slot:label="item">
                        {{ item.value }}
                    </template> -->
                </v-sparkline>
            </v-sheet>
        </v-card-text>

        <v-card-text>
            <div class="text-h6 font-weight-thin">
                {{ type }}
            </div>
        </v-card-text>

        <v-divider />

        <v-card-actions class="justify-center">

            <v-btn-toggle v-model="range" size="small" variant="text" rounded density="compact" divided mandatory>
                <v-btn value="week">
                    Setmana
                </v-btn>

                <v-btn value="month">
                    Mes
                </v-btn>

                <v-btn value="year">
                    Any
                </v-btn>

                <v-btn value="all">
                    Tots
                </v-btn>
            </v-btn-toggle>

        </v-card-actions>
    </v-card>
</template>

<script setup>

import { computed, ref } from 'vue';

// Define the props (v-model for values, type as enum of piskill|PitRep)
const props = defineProps({
    value: {
        type: Array,
        required: true,
    },
    type: {
        type: String,
        required: true,
        validator: (value) => ['PitSkill', 'PitRep', 'ELO', 'SR'].includes(value),
    },
});

// Define the computed property to get the correct color
const color = computed(() => {
    return ['PitSkill', 'ELO'].includes(props.type) ? 'primary' : 'secondary';
});

// Define the range to be shown var
const range = ref('month');

// Create a computed that filters the values based on the range
const inRangeValues = computed(() => {
    
    // No data
    if(props.value.length === 0) {
        return [0, 0];
    }

    // Single data
    if(props.value.length === 1) {
        return [
            props.value[0].value,
            props.value[0].value,
        ]
    }

    const inRange = props
        .value
        .filter((item) => {
            const date = new Date(item.measured_at);
            const now = new Date();
            switch (range.value) {
                case 'week':
                    return date > new Date(now.setDate(now.getDate() - 7));
                case 'month':
                    return date > new Date(now.setMonth(now.getMonth() - 1));
                case 'year':
                    return date > new Date(now.setFullYear(now.getFullYear() - 1));
                default:
                    return true;
            }
        });

    if(inRange.length === 0) {
        // return last value of props.value
        return [
            props.value[props.value.length - 1].value,
            props.value[props.value.length - 1].value,
        ]
    } else if(inRange.length === 1) {
        return [
            inRange[0].value,
            inRange[0].value,
        ]
    } else{
        return inRange.map((item) => item.value)
    }

});

</script>