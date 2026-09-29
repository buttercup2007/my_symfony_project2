<script setup>

import { computed, onMounted, ref, watch } from 'vue'
console.log('WEDSTRIJDEN.VUE IS GELADEN')

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

const datums = computed(() => {
    const uniekeDatums = wedstrijden.value.map(
        wedstrijd => wedstrijd.datum
    )

    return ['Alle', ...new Set(uniekeDatums)]
})

const gefilterdeWedstrijden = computed(() => {
    return wedstrijden.value.filter(wedstrijd => {
        const sportKomtOvereen =
            gekozenSport.value === 'Alle' ||
            wedstrijd.sport === gekozenSport.value

        const datumKomtOvereen =
            gekozenDatum.value === 'Alle' ||
            wedstrijd.datum === gekozenDatum.value

        return sportKomtOvereen && datumKomtOvereen
    })
})

const totaalWedstrijden = computed(() =>
    overzicht.value.reduce((totaal, item) => totaal + Number(item.aantal_wedstrijden), 0)
)

const totaalOntbrekend = computed(() =>
    overzicht.value.reduce((totaal, item) => totaal + Number(item.aantal_ontbrekend), 0)
)

async function laadWeekend(offset) {
    loading.value = true
    error.value = null

    try {
        const sportParam =
            gekozenSport.value && gekozenSport.value !== 'Alle'
                ? `&sport=${encodeURIComponent(gekozenSport.value)}`
                : ''

        const overzichtResponse = await fetch(
            `/api/weekend-overzicht?weekend=${offset}${sportParam}`
        )

        if (!overzichtResponse.ok) {
            throw new Error('Weekend overzicht kon niet worden geladen')
        }

        const overzichtData = await overzichtResponse.json()

        const wedstrijdenResponse = await fetch(
            `/api/weekend-wedstrijden?weekend=${offset}${sportParam}`
        )

        if (!wedstrijdenResponse.ok) {
            throw new Error('Weekend wedstrijden konden niet worden geladen')
        }

        const wedstrijdenData = await wedstrijdenResponse.json()

        console.log('OVERZICHT:', overzichtData)
console.log('WEDSTRIJDATA:', wedstrijdenData)
console.log('EERSTE WEDSTRIJD:', wedstrijdenData.wedstrijden[0])

const wedstrijdenMetScore = wedstrijdenData.wedstrijden.filter(
    wedstrijd =>
        wedstrijd.score1 !== null &&
        wedstrijd.score2 !== null
)

console.log('WEDSTRIJDEN MET SCORE:', wedstrijdenMetScore.length)
console.log('EERSTE WEDSTRIJD MET SCORE:', wedstrijdenMetScore[0])

        overzicht.value = overzichtData.overzicht
        wedstrijden.value = wedstrijdenData.wedstrijden

        startDatum.value = wedstrijdenData.startDatum
        eindDatum.value = wedstrijdenData.eindDatum

        weekendOffset.value = offset

        gekozenDatum.value = 'Alle'

    } catch (err) {
        console.error('FOUT:', err)
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

function openWedstrijd(wedstrijd) {
    const url =
        `/wedstrijd/${encodeURIComponent(wedstrijd.compnummer)}/${encodeURIComponent(wedstrijd.wedstrijdnummer)}`

    window.location.href = url
}

onMounted(() => {
    laadWeekend(-4)
})
</script>

<template>

    <div>

        <nav class="weekend-navigation" aria-label="Weekend navigatie">

            <button
                class="weekend-arrow"
                @click="laadWeekend(weekendOffset - 1)"
            >
                <span aria-hidden="true">&larr;</span> Vorig weekend
            </button>

            <div class="weekend-date-group">
                <p class="weekend-date">
                    {{ startDatum }} <span>t/m</span> {{ eindDatum }}
                </p>

                <button
                    class="weekend-current"
                    @click="laadWeekend(0)"
                >
                    Huidig weekend
                </button>
            </div>

            <button
                class="weekend-arrow"
                @click="laadWeekend(weekendOffset + 1)"
            >
                Volgend weekend <span aria-hidden="true">&rarr;</span>
            </button>

        </nav>

        <p v-if="loading">
            Laden...
        </p>

        <p v-if="error">
            {{ error }}
        </p>

        <div v-if="!loading && !error">

            <!-- Snelkoppelingen -->

            <section class="summary" aria-label="Weekend samenvatting">

                <a
                    :href="`/weekend?weekend=${weekendOffset}`"
                    class="summary-card summary-card-link"
                >
                    <span class="card-label">Wedstrijden</span>
                    <strong>{{ totaalWedstrijden }}</strong>
                    <span class="card-action">Bekijk weekend overzicht &rarr;</span>
                </a>

                <a
                    href="/ontbrekende-uitslagen"
                    class="summary-card summary-card-link"
                >
                    <span class="card-label">Ontbrekende uitslagen</span>
                    <strong>{{ totaalOntbrekend }}</strong>
                    <span class="card-action">Bekijk ontbrekende uitslagen &rarr;</span>
                </a>

            </section>

            <!-- Filters -->

            <div class="sport-filter-form vue-filter-form">

                <div class="filter-field">
                    <label for="weekend-sport-filter">
                        Sport
                    </label>

                    <select
                        id="weekend-sport-filter"
                        v-model="gekozenSport"
                    >
                        <option
                            v-for="sport in sporten"
                            :key="sport"
                            :value="sport"
                        >
                            {{ sport === 'Alle'
                                ? 'Alle sporten'
                                : sport
                            }}
                        </option>
                    </select>
                </div>

                <div class="filter-field">
                    <label for="weekend-date-filter">
                        Datum
                    </label>

                    <select
                        id="weekend-date-filter"
                        v-model="gekozenDatum"
                    >
                        <option
                            v-for="datum in datums"
                            :key="datum"
                            :value="datum"
                        >
                            {{ datum === 'Alle'
                                ? 'Alle dagen'
                                : datum
                            }}
                        </option>
                    </select>
                </div>

            </div>

            <!-- Weekendoverzicht -->

            <section v-if="overzicht.length" class="content-section">

                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Overzicht</p>
                        <h2>Weekendoverzicht</h2>
                    </div>
                    <span class="live-label">{{ startDatum }} t/m {{ eindDatum }}</span>
                </div>

                <div class="table-wrap">
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
                                v-for="item in overzicht"
                                :key="item.sport"
                            >
                                <td class="strong-cell">
                                    {{ item.sport }}
                                </td>

                                <td>
                                    {{ item.aantal_wedstrijden }}
                                </td>

                                <td>
                                    {{ item.aantal_ontbrekend }}
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>

            </section>

            <!-- Wedstrijden -->

            <section class="content-section">

                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Uitslagen</p>
                        <h2>Wedstrijden</h2>
                    </div>
                    <span class="live-label">{{ gefilterdeWedstrijden.length }} wedstrijden</span>
                </div>

                <div class="table-wrap">
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
                                    wedstrijd.compnummer +
                                    '-' +
                                    wedstrijd.wedstrijdnummer
                                "
                                @click="openWedstrijd(wedstrijd)"
                                class="wedstrijd-row"
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

                                <td class="score-cell">
                                    {{ wedstrijd.score1 ?? '-' }}
                                    :
                                    {{ wedstrijd.score2 ?? '-' }}
                                </td>

                            </tr>

                            <tr v-if="gefilterdeWedstrijden.length === 0">
                                <td colspan="6" class="empty">
                                    Geen wedstrijden gevonden.
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>

            </section>

        </div>

    </div>

</template>

<style scoped>
.wedstrijd-row {
    cursor: pointer;
}

.wedstrijd-row:hover {
    background-color: #f2f2f2;
}

.summary {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}
</style>