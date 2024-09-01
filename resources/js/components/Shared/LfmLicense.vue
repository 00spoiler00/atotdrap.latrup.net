<template>
    <div class="flex items-center whitespace-nowrap">
        <div :class="srClass">
            {{ srString }}
        </div>
        <div :class="eloColors">
            {{ licenseString }}
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

import { useDisplay } from 'vuetify'
const display = useDisplay()

// Add a prop for the driver
const props = defineProps(['license', 'srLicense']);

const licenseString = computed(() => display.name.value === 'xs' ? (props.license?.length > 0 ? props.license[0] : '') : props.license);
const srString = computed(() => display.name.value === 'xs' ? (props.srLicense?.length > 0 ? props.license[0] : '') : props.srLicense);

// create a computed property for the classes based on the license

const srClass = computed(() => {
    const srColors = {
        F: 'bg-red-600 border-red-600',
        E3: 'bg-gray-600 border-gray-600',
        E2: 'bg-gray-600 border-gray-600',
        E1: 'bg-gray-600 border-gray-600',
        D3: 'bg-orange-600 border-orange-600',
        D2: 'bg-orange-600 border-orange-600',
        D1: 'bg-orange-600 border-orange-600',
        C3: 'bg-gray-400 border-gray-400',
        C2: 'bg-gray-400 border-gray-400',
        C1: 'bg-gray-400 border-gray-400',
        B3: 'bg-yellow-400 border-yellow-400',
        B2: 'bg-yellow-400 border-yellow-400',
        B1: 'bg-yellow-400 border-yellow-400',
        A3: 'bg-purple-600 border-purple-600',
        A2: 'bg-purple-600 border-purple-600',
        A1: 'bg-purple-600 border-purple-600',
        S: 'bg-green-600 border-green-600',
    };

    const baseClasses = display.name.value === 'xs' ? 'w-12' : 'w-10';

    return `rounded-l  text-center ${baseClasses} ${srColors[props.srLicense]}`;
});

const eloColors = computed(() => {
    const licenseColors = {
        ROOKIE: 'bg-red-600 border-red-600',
        IRON: 'bg-gray-600 border-gray-600',
        'IRON+': 'bg-gray-600 border-gray-600',
        BRONZE: 'bg-orange-400 border-orange-400',
        'BRONZE+': 'bg-orange-400 border-orange-400',
        SILVER: 'bg-gray-400 border-gray-400',
        'SILVER+': 'bg-gray-400 border-gray-400',
        GOLD: 'bg-yellow-400 border-yellow-400',
        'GOLD+': 'bg-yellow-400 border-yellow-400',
        PLATINUM: 'bg-black border-black text-white',
        DIAMOND: 'bg-blue-600 border-blue-600',
        LEGEND: 'bg-purple-800 border-purple-800',
        ALIEN: 'bg-green-600 border-green-600',
    };

    const baseClasses = display.name.value === 'xs' ? 'w-10' : 'w-20';

    return `rounded-r px-2 text-center ${baseClasses} ${licenseColors[props.license]}`;
});


</script>