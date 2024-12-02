<script setup lang="ts">
import { useGameStore } from '@/stores/game'
import { computed } from 'vue'

const gameStore = useGameStore()

const timeOut = computed(() => (gameStore.remainingTime === 0 ? 'Temps écoulé !' : ''))
</script>
<template>
  <div class="rounded-lg bg-custom-green flex items-center px-4">
    <div v-if="gameStore.answerValidation.message">
      {{ gameStore.answerValidation.message }} <br />
    </div>
    <span v-else-if="timeOut && gameStore.answerSubmitted === false">{{ timeOut }}</span>
    <div v-else>le grand validateur réfléchit...</div>
  </div>
</template>
