import { createApp } from 'vue'
import Wedstrijden from './vue/Wedstrijden.vue'
import VueStatus from './vue/VueStatus.vue'

const vueAppElement = document.querySelector('#vue-app')

if (vueAppElement) {
    createApp(Wedstrijden).mount(vueAppElement)
}

const vueStatusElement = document.querySelector('#vue-status')

if (vueStatusElement) {
    createApp(VueStatus).mount(vueStatusElement)
}