<script setup lang="ts">
import { onMounted, onUnmounted, watch } from 'vue'
import { useGameStore } from '@/stores/game'

const gameStore = useGameStore()

const totalTime = 90

const emit = defineEmits(['timerEnd'])

let timerInterval: ReturnType<typeof setInterval> | null = null

const startTimer = () => {
  if (timerInterval) return

  timerInterval = setInterval(() => {
    if (gameStore.remainingTime > 0) {
      gameStore.remainingTime--
    } else {
      if (timerInterval !== null) {
        emit('timerEnd')
        clearInterval(timerInterval)
      }
    }
  }, 1000)
}

const stopTimer = () => {
  if (timerInterval) {
    clearInterval(timerInterval);
    timerInterval = null;
  }
};

watch(
  () => gameStore.demoMode,
  (newDemoMode) => {
    if (newDemoMode) {
      stopTimer();
    } else {
      startTimer();
    }
  }
);

onMounted(() => {
  if (!gameStore.demoMode) startTimer() // Start timer if not in demo mode
})

onUnmounted(() => {
  if (timerInterval) clearInterval(timerInterval)
})
</script>

<template>
  <div class="h-5 bg-gray-300 rounded-full md:w-40 w-28 relative">
    <div
      class="h-full bg-custom-dark-green rounded-full md:w-40 w-28"
      :style="{ width: `${((totalTime - gameStore.remainingTime) / totalTime) * 100}%` }"
    >
      <div class="text-white absolute md:-top-[0.5px] md:right-14  top-0.5 right-8 md:text-sm text-xs">
        {{ gameStore.currentPoints }} {{ gameStore.currentPoints === 1 ? 'point' : 'points' }}
      </div>
    </div>
  </div>
</template>
