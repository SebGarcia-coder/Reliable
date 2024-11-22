<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  pointsPerClue: {
    type: Array,
    default: () => [5, 3, 2, 1],
  },
  currentClueIndex: {
    type: Number,
    default: 0,
  },
})

const totalTime = 60

const emit = defineEmits(['nextClue'])

const remainingTime = ref(totalTime)
const currentPoints = computed(() => props.pointsPerClue[props.currentClueIndex])

let timerInterval: ReturnType<typeof setInterval> | null = null

const startTimer = () => {
  timerInterval = setInterval(() => {
    if (remainingTime.value > 0) {
      remainingTime.value--
    } else {
      clearInterval(timerInterval as ReturnType<typeof setInterval>)
    }
  }, 1000)
}

onUnmounted(() => {
  if (timerInterval) clearInterval(timerInterval as ReturnType<typeof setInterval>)
})

onMounted(startTimer)
</script>

<template>
  <div class="flex items-center justify-end">
    <div class="w-20 h-5 bg-gray-300 rounded-full w-56 relative">
      <div
        class="h-full bg-custom-dark-green rounded-full w-56 "
        :style="{ width: `${((totalTime - remainingTime) / totalTime) * 100}%` }"
      >
        <div class="text-white absolute -top-1 right-24
        ">
          {{ currentPoints }} {{ currentPoints === 1 ? 'point' : 'points' }}
        </div>
      </div>
    </div>
  </div>
</template>
