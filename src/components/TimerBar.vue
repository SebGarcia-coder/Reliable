<script setup lang="ts">
import { onMounted, onUnmounted } from 'vue'
import { useGameStore } from '@/stores/game'

const gameStore = useGameStore()

const totalTime = 90

const emit = defineEmits(['timerEnd'])

let timerInterval: ReturnType<typeof setInterval> | null = null

const startTimer = () => {
  timerInterval = setInterval(() => {
    if (gameStore.remainingTime > 0) {
      gameStore.remainingTime--
    } else {
      if (timerInterval !== null) {
        emit('timerEnd')
        clearInterval(timerInterval)
    }}
  }, 1000)
}

onUnmounted(() => {
  if (timerInterval) clearInterval(timerInterval)
})

onMounted(startTimer)
</script>

<template>

    <div class=" h-5 bg-gray-300 rounded-full w-40 relative">
      <div
        class="h-full bg-custom-dark-green rounded-full w-40"
        :style="{ width: `${((totalTime - gameStore.remainingTime) / totalTime) * 100}%` }"
      >
        <div class="text-white absolute -top-0.5 right-14">
          {{ gameStore.currentPoints }} {{ gameStore.currentPoints === 1 ? 'point' : 'points' }}
        </div>
      </div>
    </div>

</template>
