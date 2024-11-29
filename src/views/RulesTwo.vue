<script setup lang="ts">
import { useRouter } from 'vue-router';
import Button from '@/components/Button.vue';

const router = useRouter();
const goToNextpage = () => {
  router.push('/demo'); // Navigate to the demo screen
};
</script>


<template>
  <div class="flex flex-col items-center justify-center min-h-screen text-white">
    <p class="text-center text-4xl w-3/5 my-9">Dans la première série, vous devez trouver le plus vite possible le lien entre 4 éléments. </p>
    <p class="text-center text-4xl w-3/5 mx-auto my-9">Si vous trouvez dès le premier élément, vous remportez 5 points, au deuxième seulement 3 points, au troisième 2 points et au quatrième 1 point.</p>
    <Button color="bg-custom-green" hover="bg-custom-green-hover" @click="goToNextpage" class="my-9">Suivant</Button>
  </div>
</template>
