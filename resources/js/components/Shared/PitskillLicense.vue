<template>
    <div :class="licenseClass">
        {{ licenseString }}
    </div>
</template>

<script setup>
import { computed } from 'vue';


import { useDisplay } from 'vuetify'
const display = useDisplay()

// Add a prop for the driver
const props = defineProps(['pitskill', 'pitrep']);

const license = computed(() => {
    const pitrep = props.pitrep;
    const pitskill = props.pitskill;

    if (pitrep >= 20 && pitskill >= 4500) return 'Elite';
    if (pitrep >= 20 && pitskill >= 3500) return 'Pro';
    if (pitrep >= 15 && pitskill >= 3000) return 'Veteran';
    if (pitrep >= 15 && pitskill >= 2500) return 'Platinum';
    if (pitrep >= 10 && pitskill >= 2000) return 'Silver';
    if (pitrep >= 10 && pitskill >= 1750) return 'Steel';
    if (pitrep >= 5 && pitskill >= 1500) return 'Bronze';
    if (pitrep >= 5 && pitskill >= 1000) return 'Copper';
    if (pitrep >= 5 && pitskill >= 0) return 'Copper';
    return 'PROVISIONAL';
});

const licenseString = computed(() => display.name.value === 'xs' ? license.value[0] : license.value);

// create a computed property for the classes based on the license
const licenseClass = computed(() => {
    const licenseColors = {
        Elite: 'bg-black-400 text-white border-yellow-400 ',
        Pro: 'bg-white-400 text-black border-yellow-400',
        Veteran: 'bg-white-400 text-black border-white',
        Platinum: 'bg-gray-300 text-black border-gray-300 ',
        Silver: 'bg-gray-300 text-black border-gray-300',
        Steel: 'bg-gray-300 text-black border-gray-300',
        Bronze: 'bg-red-800 text-white border-red-800',
        Copper: 'bg-red-800 text-white border-red-800',
        AM: 'bg-red-800 text-white border-red-800',
        PROVISIONAL: 'bg-red-800 text-white border-yellow-400',
    };

    // If the breakpoint is mobile, return w-10, otherwise return w-24
    const baseClasses = display.name.value === 'xs' ? 'w-10' : 'w-24';

    return `h-8 font-bold rounded-xl border-1 pt-[6px] text-center ${baseClasses} ${licenseColors[license.value]}`
});


</script>