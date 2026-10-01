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

const wedstrijdenPerDatum = computed(() => {
    const groepen = new Map()

    for (const wedstrijd of gefilterdeWedstrijden.value) {
        if (!groepen.has(wedstrijd.datum)) {
            groepen.set(wedstrijd.datum, [])
        }

        groepen.get(wedstrijd.datum).push(wedstrijd)
    }

    return [...groepen.entries()]
        .sort(([datumA], [datumB]) => datumA.localeCompare(datumB))
        .map(([datum, wedstrijdenOpDatum]) => ({
            datum,
            wedstrijden: wedstrijdenOpDatum
        }))
})

function formatDatum(datum) {
    return new Date(datum).toLocaleDateString('nl-NL', {
        weekday: 'long',
        day: 'numeric',
        month: 'long'
    })
}

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
    laadWeekend(0)
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

            <section class="summary" aria-label="Weekend samenvatting">

                <div class="summary-card">
                    <span class="card-label">Wedstrijden</span>
                    <strong>{{ totaalWedstrijden }}</strong>
                </div>

                <a
                    href="/ontbrekende-uitslagen"
                    class="summary-card summary-card-link"
                >
                    <span class="card-label">Ontbrekende uitslagen</span>
                    <strong>{{ totaalOntbrekend }}</strong>
                    <span class="card-action">Bekijk ontbrekende uitslagen &rarr;</span>
                </a>

            </section>

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
                                <th>Tijd</th>
                                <th>Sport</th>
                                <th>Team 1</th>
                                <th>Team 2</th>
                                <th>Score</th>
                            </tr>

                        </thead>

                        <template v-for="groep in wedstrijdenPerDatum" :key="groep.datum">
                            <tbody class="datum-groep">

                                <tr class="datum-rij">
                                    <td colspan="5">
                                        {{ formatDatum(groep.datum) }}
                                    </td>
                                </tr>

                                <tr
                                    v-for="wedstrijd in groep.wedstrijden"
                                    :key="
                                        wedstrijd.compnummer +
                                        '-' +
                                        wedstrijd.wedstrijdnummer
                                    "
                                    @click="openWedstrijd(wedstrijd)"
                                    class="wedstrijd-row"
                                >

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

                            </tbody>
                        </template>

                        <tbody v-if="gefilterdeWedstrijden.length === 0">
                            <tr>
                                <td colspan="5" class="empty">
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

.datum-rij td {
    background: var(--wash, #f2f6fa);
    color: var(--muted, #667085);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    white-space: nowrap;
}
</style>