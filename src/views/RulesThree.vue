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
    <p class="text-center md:text-4xl text-xl w-3/5 md:my-9 my-6">Dans cette deuxième série, vous devez trouver le 4ème élément qui termine la séquence. </p>
    <p class="text-center md:text-4xl text-xl w-3/5 mx-auto md:my-9 my-6">Si vous trouvez dès le premier élément, vous remportez 5 points, au deuxième seulement 3 points et au troisième 2 points.</p>
    <Button color="bg-custom-green" hover="bg-custom-green-hover" @click="goToNextpage" class="my-9">Suivant</Button>
  </div>
</template>
