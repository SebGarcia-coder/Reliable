<script setup lang="ts">
import { useGameStore } from '@/stores/game';

const gameStore = useGameStore();
</script>
<template>
  <div class=" h-12 rounded-lg bg-custom-green flex items-center px-4">
    <span v-if="gameStore.answerValidation.message">{{ gameStore.answerValidation.message }}</span>
    <div v-else>le grand validateur réfléchit...</div>
  </div>
</template>
