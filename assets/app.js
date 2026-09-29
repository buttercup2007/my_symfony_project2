import { createApp } from 'vue'

import Wedstrijden from './vue/Wedstrijden.vue'
import VueStatus from './vue/VueStatus.vue'

document.addEventListener('DOMContentLoaded', () => {

    console.log('DOM IS GELADEN')

    const vueAppElement = document.querySelector('#vue-app')

    console.log('VUE-APP ELEMENT:', vueAppElement)

    if (vueAppElement) {
        createApp(Wedstrijden).mount(vueAppElement)

        console.log('WEDSTRIJDEN IS GEMOUNT')
    }

    const vueStatusElement = document.querySelector('#vue-status')

    console.log('VUE-STATUS ELEMENT:', vueStatusElement)

    if (vueStatusElement) {
        createApp(VueStatus).mount(vueStatusElement)

        console.log('VUE STATUS IS GEMOUNT')
    }
})