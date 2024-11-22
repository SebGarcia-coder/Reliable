<script setup lang="ts">
import AnswerBox from './AnswerBox.vue';
import Button from './Button.vue';
import { ref } from 'vue';
import axios from 'axios';
import { useGameStore } from '@/stores/game';

const gameStore = useGameStore();

const userAnswer = ref('');

// const props = defineProps<{
//   clues: {
//     text: string;
//     visible: boolean;
//   }[];
// }>();

// TODO : quand les questions seront dans la bdd, n'envoyer que l'id de la question.

let clueString = ''

if (gameStore.clues) {
  for (const clue of gameStore.clues) {
    clueString += clue.text + ', ';
  }
}

const submitAnswer = async () => {
  gameStore.remainingTime = 0
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/validate-answer', {
      userAnswer: userAnswer.value,
      clues: clueString,
    });
    const { isValid, validatorMessage } = response.data as { isValid: boolean, validatorMessage: string };

    gameStore.answerValidation.isValid = isValid;
    gameStore.answerValidation.message = validatorMessage;

    if(isValid) {
      gameStore.addPointsForCurrentClue();
    }


  } catch (error) {
    console.error('Error validating answer:', error);
    alert('There was an error. Please try again.');
  }
};

</script>

<template>
  <form @submit.prevent="submitAnswer" class="flex flex-col items-center justify-end">
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


