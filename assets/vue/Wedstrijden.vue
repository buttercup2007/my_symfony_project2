<script setup>
import {onMounted, ref} from 'vue'

const wedstrijden = ref([]);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
    try {
        const response = await fetch('/api/wedstrijden');

        if (!response.ok) {
            throw new Error('Api kon niet worden geladen');
        }
        wedstrijden.value = await response.json();
    } catch (err) {
        error.value = err.message;
    } finally {
        loading.value = false;
    }
});

</script>

<template>
    <div>
        <h1>Wedstrijden</h1>

        <p v-if="loading">Laden...</p>

        <p v-if="error">{{ error }}</p>

        <div v-else>
            <p> Aantal wedstrijden: {{ wedstrijden.length }}</p>
        
        <table>
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Sport</th>
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="wedstrijd in wedstrijden" :key="wedstrijd.datum
                 + wedstrijd.team1 + wedstrijd.team2">

                    <td>{{ wedstrijd.datum }}</td>
                    <td>{{ wedstrijd.tijd }}</td>
                    <td>{{ wedstrijd.sport}}</td>
                    <td>{{ wedstrijd.team1 }}</td>
                    <td>{{ wedstrijd.team2 }}</td>
                    <td>{{ wedstrijd.score1}} - {{  wedstrijd.score2 }} </td>
                    
                </tr>
            </tbody>
        </table>
        </div>

    </div>
</template>