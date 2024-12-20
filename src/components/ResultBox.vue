<script setup lang="ts">
import { useGameStore } from '@/stores/game'
import { computed } from 'vue'
import '../resultbox.css'

const gameStore = useGameStore()

const timeOut = computed(() => (gameStore.remainingTime === 0 ? 'Temps écoulé !' : ''))
</script>
<template>
  <div class="resultbox rounded-lg bg-custom-green flex items-start px-4 overflow-scroll h-16 md:h-24 leading-4 text-xs md:text-base">
    <div class="m-auto" v-if="gameStore.answerValidation.message">
      {{ gameStore.answerValidation.message }} <br />
    </div>
    <div class="m-auto" v-else-if="timeOut && gameStore.answerSubmitted === false">{{ timeOut }}</div>
    <div class="m-auto" v-else>le grand validateur réfléchit...</div>
  </div>
</template>
