<script setup lang="ts">
import AnswerBox from './AnswerBox.vue';
import Button from './Button.vue';

import { ref } from 'vue';

const userAnswer = ref('');
const submitAnswer = () => {
  console.log(`User Answer: ${userAnswer.value}`);
};
</script>

<template>
  <form @submit.prevent="submitAnswer" class="flex flex-col items-center">
    <AnswerBox v-model="userAnswer" placeholder="Entrez votre réponse ici" />
    <Button
      color="bg-custom-green"
      hover="bg-custom-green-hover"
      type="submit"
      class="mt-4"
    >
      Répondre
  </Button>
  </form>
</template>
