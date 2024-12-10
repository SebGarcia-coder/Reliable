<script setup lang="ts">
import { useRouter } from 'vue-router';
import Button from '@/components/Button.vue';

const router = useRouter();
const goToNextpage = () => {
  router.push('/rules-2'); // Navigate to the demo screen
};
</script>


<template>
  <div class="flex flex-col items-center justify-center min-h-screen text-white">
    <p class="text-center md:text-4xl text-xl md:my-9 my-6">Vous allez répondre à deux séries de trois questions</p>
    <Button color="bg-custom-green" hover="bg-custom-green-hover" @click="goToNextpage">Suivant</Button>
  </div>
</template>
