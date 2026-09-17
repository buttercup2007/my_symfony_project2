<script setup>
import {onMounted, ref} from 'vue'

const wedstrijden = ref([]);
const loading = ref(true);
const error = ref(null);
const overzicht = ref([])
const startDatum = ref('')
const eindDatum = ref('')
const weekendOffset = ref(0);

async function laadWeekend(offset) {
    loading.value = true;
    error.value = null;

    try {
        const response = await fetch(`/api/weekend-overzicht?weekend=${offset}`);

        if (!response.ok) {
            throw new Error('Weekend overzicht kon niet worden geladen')
        }

        const data = await response.json()

        overzicht.value = data.overzicht
        startDatum.value = data.startDatum
        eindDatum.value = data.eindDatum
        weekendOffset.value = offset

    } catch (err) {
        error.value = err.message
    } finally {
        loading.value = false
    }
}

onMounted(async () => {
    try {
        const response = await fetch('/api/wedstrijden')

        if (!response.ok) {
            throw new Error('API kon niet worden geladen')
        }

        const data = await response.json()
        wedstrijden.value = data.wedstrijden

        const overzichtResponse = await fetch('/api/weekend-overzicht')

        if (!overzichtResponse.ok) {
            throw new Error('Weekend overzicht kon niet worden geladen')
        }

        const overzichtData = await overzichtResponse.json()

        overzicht.value = overzichtData.overzicht
        startDatum.value = overzichtData.startDatum
        eindDatum.value = overzichtData.eindDatum

    } catch (err) {
        error.value = err.message
    } finally {
        loading.value = false
    }
})

</script>

<template>

    <div class="weekend-navigation">
        <button @click="laadWeekend(weekendOffset - 1)">Vorige weekend</button>

        <span>{{ startDatum }} t/m {{ eindDatum }}</span>

        <button @click="laadWeekend(weekendOffset + 1)">Volgende weekend</button>
    </div>
    <div>

        <div v-if="overzicht.length">
            <h2>Weekendoverzicht</h2>

            <p>{{ startDatum }} t/m {{ eindDatum }}</p>

            <table>
                <thead>
                    <tr>
                        <th>Sport</th>
                        <th>Aantal wedstrijden</th>
                        <th>Ontbrekende uitslagen</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="sport in overzicht" :key="sport.sport">

                        <td>{{ sport.sport }}</td>
                        <td>{{ sport.aantal_Wedstrijden }}</td>
                        <td>{{ sport.aantal_ontbrekend }}</td>
                        </tr>
                    </tbody>
            </table>

        </div>
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