<script setup lang="ts">
import { useRouter } from 'vue-router';
import Button from '@/components/Button.vue';

const router = useRouter();
const goToNextpage = () => {
  router.push('/rules-1'); // Navigate to the demo screen
};
</script>


<template>
  <div class="flex flex-col items-center justify-center min-h-screen text-white">
    <p class="text-center text-4xl  my-9">Bienvenue dans Reliable <br/> un jeu où il faut savoir créer des liens</p>
    <Button color="bg-custom-green" hover="bg-custom-green-hover" @click="goToNextpage">Suivant</Button>
  </div>
</template>

