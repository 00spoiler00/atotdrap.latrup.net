import { defineStore } from 'pinia'

export const useLoaderStore = defineStore('loader', {
    state: () => ({ count: 0 }),

    actions: {
        add() {
            this.count++
        },
        remove() {
            this.count--
        },
    },

    getters: {
        isLoading: (state) => state.count > 0,
    },

})