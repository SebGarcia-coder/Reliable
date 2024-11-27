<script setup lang="ts">
import { onMounted, onUnmounted } from 'vue'
import { useGameStore } from '@/stores/game'

const gameStore = useGameStore()

const totalTime = 30

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
  <div class="flex items-center justify-end">
    <div class="w-20 h-5 bg-gray-300 rounded-full w-56 relative">
      <div
        class="h-full bg-custom-dark-green rounded-full w-56"
        :style="{ width: `${((totalTime - gameStore.remainingTime) / totalTime) * 100}%` }"
      >
        <div class="text-white absolute -top-0.5 right-24">
          {{ gameStore.currentPoints }} {{ gameStore.currentPoints === 1 ? 'point' : 'points' }}
        </div>
      </div>
    </div>
  </div>
</template>
