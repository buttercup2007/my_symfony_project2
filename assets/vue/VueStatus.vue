<script setup>
import { ref } from 'vue'

const showDetails = ref(false)
</script>

<template>
  <div class="vue-status-panel">
    <span class="vue-status-dot" aria-hidden="true"></span>

    <span>Vue is actief</span>

    <button type="button" @click="showDetails = !showDetails">
        {{ showDetails ? 'Verberg details' : 'Toon details' }}
    </button>

    <small v-if="showDetails">
        Deze melding wordt reactief bijgewerkt door Vue
    </small>
  </div>
</template>