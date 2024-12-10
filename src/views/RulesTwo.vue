<script setup lang="ts">
import { useRouter } from 'vue-router';
import Button from '@/components/Button.vue';
import { useGameStore } from '@/stores/game';

const gameStore = useGameStore()

const router = useRouter();

const handleExplainClick = () => {
  gameStore.demoMode = true;
  router.push('/demo'); // Navigate to the demo screen
};

const handlePlayClick = () => {
  gameStore.demoMode = false;
  router.push('/demo'); // Navigate to the demo screen
};
</script>


<template>
  <div class="flex flex-col items-center justify-center min-h-screen text-white">
    <p class="text-center md:text-4xl text-xl w-3/5 my-9">Dans la première série, vous devez trouver le plus vite possible le lien entre 4 éléments. </p>
    <p class="text-center md:text-4xl  text-xl w-3/5 mx-auto md:my-9 my-6">Si vous trouvez dès le premier élément, vous remportez 5 points, au deuxième seulement 3 points, au troisième 2 points et au quatrième 1 point.</p>
    <div class="flex justify-between w-4/5">
      <Button color="bg-custom-green" hover="bg-custom-green-hover" @click="handleExplainClick" class="my-9">Expliquez moi</Button>
      <Button color="bg-custom-burgondy" hover="bg-custom-burgondy-hover" @click="handlePlayClick" class="my-9">Jouer </Button>
    </div>

  </div>
</template>
