import './stimulus_bootstrap.js';
import { createApp, ref } from 'vue';
import Wedstrijden from './vue/Wedstrijden.vue';

createApp(Wedstrijden).mount('#vue-app');

const vueStatusElement = document.querySelector('#vue-status');

if (vueStatusElement) {
	createApp({
		setup() {
			const showDetails = ref(false);

			return { showDetails };
		},
		template: `
			<div class="vue-status-panel">
				<span class="vue-status-dot" aria-hidden="true"></span>
				<span>Vue is actief</span>
				<button type="button" @click="showDetails = !showDetails">
					{{ showDetails ? 'Verberg details' : 'Toon details' }}
				</button>
				<small v-if="showDetails">Deze melding wordt reactief bijgewerkt door Vue.</small>
			</div>
		`,
	}).mount(vueStatusElement);
}
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
