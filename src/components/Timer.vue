<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';


const props = defineProps({
  totalTime: {
    type: Number,
    default: 60,
  },
  pointsPerClue: {
    type: Array,
    default: () => [5, 3, 2, 1],
  },
  currentClueIndex: {
    type: Number,
    default: 0,
  },
});

const emit = defineEmits(['nextClue']);

const remainingTime = ref(props.totalTime);
const currentPoints = computed(() => props.pointsPerClue[props.currentClueIndex]);

let timerInterval: NodeJS.Timer | null = null;


const startTimer = () => {
  timerInterval = setInterval(() => {
    if (remainingTime.value > 0) {
      remainingTime.value--;
    } else {
      clearInterval(timerInterval as NodeJS.Timeout);
    }
  }, 1000);
};


onUnmounted(() => {
  if (timerInterval) clearInterval(timerInterval as NodeJS.Timeout);
});


onMounted(startTimer);

</script>

<template>
  <div>
    <div class="flex items-center space-x-2">
      <div class="w-20 h-5 bg-gray-300 rounded-full relative">
        <div
          class="h-full bg-custom-dark-green rounded-full"
          :style="{ width: `${((totalTime - remainingTime) / totalTime) * 100}%` }"

        ></div>
      </div>
      <span class="absolute inset-0 flex items-center justify-center text-white ">
        {{ currentPoints }} points
      </span>
    </div>
  </div>
</template>

