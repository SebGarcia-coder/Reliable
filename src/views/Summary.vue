<script setup lang="ts">
import { useRouter } from 'vue-router';
import Button from '@/components/Button.vue';
import { useGameStore } from '@/stores/game';

const router = useRouter();
const gameStore = useGameStore();
const goToHomepage = () => {
  router.push('/rules-1'); // Navigate to the demo screen
};
</script>


<template>

  <div class="flex flex-col items-center justify-center min-h-screen text-white">
    <p class="text-center text-4xl w-3/5 my-9">Bravo vous avez terminé </p>
    <p class="text-center text-4xl w-3/5 mx-auto my-9">votre score est de {{ gameStore.score }}.</p>
    <Button color="bg-custom-green" hover="bg-custom-green-hover" @click="goToHomepage" class="my-9">Suivant</Button>
  </div>
</template>
