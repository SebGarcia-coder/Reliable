<script setup lang="ts">
import AnswerBox from './AnswerBox.vue';
import Button from './Button.vue';
// import { ref } from 'vue';
// import axios from 'axios';
import { useGameStore } from '@/stores/game';

const gameStore = useGameStore();

</script>

<template>
  <form @submit.prevent="gameStore.submitAnswer" class="flex flex-col items-center">
    <AnswerBox v-model="gameStore.userAnswer" placeholder="Entrez votre réponse ici"  />
    <Button v-if="gameStore.remainingTime > 0 && !gameStore.answerSubmitted"
      color="bg-custom-green"
      hover="bg-custom-green-hover"
      type="submit"
      class="mt-6"
    >
      Répondre
  </Button>
  </form>
</template>


