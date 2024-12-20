<script setup lang="ts">
import Button from '@/components/Button.vue';
import { useGameStore } from '@/stores/game';

defineProps({
  text: String,
  score: Number
});
const gameStore = useGameStore();
</script>

<template>
  <div class="flex flex-col items-center justify-center min-h-screen text-white p-8">
    <p class="text-center md:text-4xl text-xl md:my-9 my-6">{{text}}</p>
    <p v-if="score" class="text-center md:text-4xl text-xl md:my-9 my-6" > Votre score est de {{ score }}</p>
    <Button v-if="gameStore.currentGameStep===5" color="bg-custom-green" hover="bg-custom-green-hover" @click="$emit('reset')">Rejouer</Button>

    <Button v-else color="bg-custom-green" hover="bg-custom-green-hover" @click="$emit('nextStep')">Suivant</Button>
  </div>
</template>
