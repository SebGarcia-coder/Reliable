<script setup lang="ts">
import { ref } from 'vue';
import ClueBox from '../components/ClueBox.vue';
import Button from '../components/Button.vue';
import AnswerInput from '../components/AnswerInput.vue';

const clues = ref([
  { text: 'Reine', visible: true },
  { text: 'Main', visible: false },
  { text: 'Atout', visible: false },
  { text: 'Trèfle', visible: false },
]);

const revealClue = () => {
  const nextClue = clues.value.find((clue) => !clue.visible);
  if (nextClue) {
    nextClue.visible = true;
  }
};
</script>

<template>
  <div class="flex flex-col items-center justify-center min-h-screen  space-y-6">
    <div class="absolute top-4 right-4">
      <Button color="bg-custom-burgondy" hover="bg-custom-burgondy-hover"  @click="revealClue">Indice</Button>
    </div>
    <div class="flex space-x-4">
      <ClueBox
        v-for="(clue, index) in clues"
        :key="index"
        :text="clue.text"
        :visible="clue.visible"
      />
    </div>
    <AnswerInput placeholder="Entrez votre réponse ici" />
  </div>
</template>

