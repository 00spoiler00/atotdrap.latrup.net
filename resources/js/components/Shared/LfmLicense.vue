<template>
    <div :class="licenseClass">
        {{ licenseString }}
    </div>
    <div :class="srClass">
        {{ srString }}
    </div>
</template>

<script setup>
import { computed } from 'vue';

import { useDisplay } from 'vuetify'
const display = useDisplay()

// Add a prop for the driver
const props = defineProps(['license', 'sr']);

const licenseString = computed(() => display.name.value === 'xs' ? props.license.value[0] : props.license.value);
const srString = computed(() => display.name.value === 'xs' ? sr.value[0] : sr.value);

// create a computed property for the classes based on the license
const licenseClass = computed(() => {
    const licenseColors = {
        ROOKIE: 'bg-red-800 border-red-800',
        IRON: 'bg-gray-400 border-gray-400',
        'IRON+': 'bg-gray-400 border-gray-400',
        BRONZE: 'bg-red-800 border-red-800',
        'BRONZE+': 'bg-red-800 border-red-800',
        SILVER: 'border-gray-800 bg-gray-800 text-black',
        'SILVER+': 'border-gray-800 bg-gray-800 text-black',
        GOLD: 'border-white bg-white text-black',
        PLATINUM: 'border-white bg-white text-black',
        DIAMOND: 'border-white bg-white text-black',
        LEGEND: 'border-white bg-white text-black',
        ALIEN: 'bg-yellow-400 border-yellow-400',
    };

    // If the breakpoint is mobile, return w-10, otherwise return w-24
    const baseClasses = display.name.value === 'xs' ? 'w-10' : 'w-24';

    return `h-8 font-bold rounded-xl border-1 pt-[6px] text-center ${baseClasses} ${licenseColors[license.value]}`
});

const srClass = computed(() => {
    const srColors = {

        F: 'bg-red-800 border-red-800',
        E3: 'bg-gray-400 border-gray-400',
        E2: 'bg-gray-400 border-gray-400',
        E1: 'bg-gray-400 border-gray-400',
        D3: 'bg-orange-800 border-orange-800',
        D2: 'bg-orange-800 border-orange-800',
        D1: 'bg-orange-800 border-orange-800',
        C3: 'bg-gray-800 border-gray-800',
        C2: 'bg-gray-800 border-gray-800',
        C1: 'bg-gray-800 border-gray-800',
        B3: 'bg-yellow-800 border-yellow-800',
        B2: 'bg-yellow-800 border-yellow-800',
        B1: 'bg-yellow-800 border-yellow-800',
        A3: 'bg-purple-800 border-purple-800',
        A2: 'bg-purple-800 border-purple-800',
        A1: 'bg-purple-800 border-purple-800',
        S: 'bg-green-800 border-green-800',
    };

    // If the breakpoint is mobile, return w-10, otherwise return w-24
    const baseClasses = display.name.value === 'xs' ? 'w-10' : 'w-24';

    return `h-8 font-bold rounded-xl border-1 pt-[6px] text-center ${baseClasses} ${srColors[sr.value]}`
});


</script>