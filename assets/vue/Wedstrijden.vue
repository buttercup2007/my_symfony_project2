<script setup>
import { computed, onMounted, ref, watch } from 'vue'

const wedstrijden = ref([])
const loading = ref(true)
const error = ref(null)

const overzicht = ref([])
const startDatum = ref('')
const eindDatum = ref('')
const weekendOffset = ref(0)

const gekozenSport = ref('Alle')
const gekozenDatum = ref('Alle')

const sporten = computed(() => {
    const uniekeSporten = wedstrijden.value.map(
        wedstrijd => wedstrijd.sport
    )

    return ['Alle', ...new Set(uniekeSporten)]
})

const gefilterdeWedstrijden = computed(() => {
    if (gekozenSport.value === 'Alle') {
        return wedstrijden.value
    }

    return wedstrijden.value.filter(
        wedstrijd => wedstrijd.sport === gekozenSport.value
    )
})

const datums = computed(() => {
    const uniekeDatums = wedstrijden.value.map(
        wedstrijd => wedstrijd.datum
    )

    return ['Alle', ...new Set(uniekeDatums)]
})

async function laadWeekend(offset) {
    loading.value = true
    error.value = null

    try {
        const sportParam = gekozenSport.value && gekozenSport.value !== 'Alle'
            ? `&sport=${encodeURIComponent(gekozenSport.value)}`
            : ''

        const overzichtResponse = await fetch(
            `/api/weekend-overzicht?weekend=${offset}${sportParam}`
        )

        if (!overzichtResponse.ok) {
            throw new Error(
                'Weekend overzicht kon niet worden geladen'
            )
        }

        const overzichtData = await overzichtResponse.json()

        const wedstrijdenResponse = await fetch(
            `/api/weekend-wedstrijden?weekend=${offset}${sportParam}`
        )

        if (!wedstrijdenResponse.ok) {
            throw new Error(
                'Weekend wedstrijden konden niet worden geladen'
            )
        }

        const wedstrijdenData = await wedstrijdenResponse.json()

        overzicht.value = overzichtData.overzicht
        wedstrijden.value = wedstrijdenData.wedstrijden

        startDatum.value = overzichtData.startDatum
        eindDatum.value = overzichtData.eindDatum

        weekendOffset.value = offset

    } catch (err) {
        error.value = err.message
    } finally {
        loading.value = false
    }
}

watch(
    gekozenSport,
    () => {
        laadWeekend(weekendOffset.value)
    }
)

onMounted(() => {
    laadWeekend(0)
})
</script>


<template>

    <div>

        <div class="weekend-navigation">

            <button
                @click="laadWeekend(weekendOffset - 1)"
            >
                Vorig weekend
            </button>

            <span>
                {{ startDatum }} t/m {{ eindDatum }}
            </span>

            <button
                @click="laadWeekend(weekendOffset + 1)"
            >
                Volgend weekend
            </button>

        </div>

        <p v-if="loading">
            Laden...
        </p>

        <p v-if="error">
            {{ error }}
        </p>

<label for="sport">
    Filter op sport:
</label>

<select id="sport" v-model="gekozenSport">
    <option
        v-for="sport in sporten"
        :key="sport"
        :value="sport"
    >
        {{ sport }}
    </option>
</select>

<label for="datum">
    Filter op datum:
</label>

<select id="datum" v-model="gekozenDatum">
    <option
        v-for="datum in datums"
        :key="datum"
        :value="datum"
    >
        {{ datum }}
    </option>
</select>

        <div v-if="!loading && !error">

            <div v-if="overzicht.length">

                <h2>Weekendoverzicht</h2>

                <p>
                    {{ startDatum }} t/m {{ eindDatum }}
                </p>


                <table>

                    <thead>
                        <tr>
                            <th>Sport</th>
                            <th>Aantal wedstrijden</th>
                            <th>Ontbrekende uitslagen</th>
                        </tr>
                    </thead>


                    <tbody>

                        <tr
                            v-for="sport in overzicht"
                            :key="sport.sport"
                        >

                            <td>
                                {{ sport.sport }}
                            </td>

                            <td>
                                {{ sport.aantal_Wedstrijden }}
                            </td>

                            <td>
                                {{ sport.aantal_ontbrekend }}
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

            <h1>Wedstrijden</h1>

            <div class="sport-filter">

                <label for="sport">
                    Filter op sport:
                </label>

                <select
                    id="sport"
                    v-model="gekozenSport"
                >

                    <option
                        v-for="sport in sporten"
                        :key="sport"
                        :value="sport"
                    >
                        {{ sport }}
                    </option>

                </select>

            </div>

            <p>
                Aantal wedstrijden:
                {{ gefilterdeWedstrijden.length }}
            </p>

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

                    <tr
                        v-for="wedstrijd in gefilterdeWedstrijden"
                        :key="
                            wedstrijd.datum +
                            wedstrijd.team1 +
                            wedstrijd.team2
                        "
                    >

                        <td>
                            {{ wedstrijd.datum }}
                        </td>

                        <td>
                            {{ wedstrijd.tijd }}
                        </td>

                        <td>
                            {{ wedstrijd.sport }}
                        </td>

                        <td>
                            {{ wedstrijd.team1 }}
                        </td>

                        <td>
                            {{ wedstrijd.team2 }}
                        </td>

                        <td>
                            {{ wedstrijd.score1 }}
                            -
                            {{ wedstrijd.score2 }}
                        </td>

                    </tr>

                </tbody>

            </table>

            <p v-if="gefilterdeWedstrijden.length === 0">
                Geen wedstrijden gevonden voor deze sport.
            </p>

        </div>

    </div>

</template>