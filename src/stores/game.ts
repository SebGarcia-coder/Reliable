import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useGameStore = defineStore('game', () => {
  // State
  const remainingTime = ref(60); // Timer in seconds
  const clues = ref([
    { text: '+ de 10 000 €', visible: true },
    { text: 'Un animal de compagnie', visible: false },
    { text: '+ de 200 cigarettes', visible: false },
    { text: '+ de 10L de whisky', visible: false },
  ])
  const pointsPerClue = ref([5, 3, 2, 1]); // Points for each clue
  const currentClueIndex = ref(0); // Index of the current clue
  const score = ref(0); // Total score for the game
  const answer = ref(''); // The correct answer for the game

  const answerValidation = ref({
    isValid: null as boolean | null,
    message: '',
  });

  // Getters
  const currentPoints = computed(() => pointsPerClue.value[currentClueIndex.value]);

  // Actions
  const revealNextClue = () => {
    if (currentClueIndex.value < clues.value.length - 1) {
      clues.value[currentClueIndex.value + 1].visible = true;
      currentClueIndex.value++;
    }
  };

  const addPointsForCurrentClue = () => {
    score.value += currentPoints.value;
  };

  const resetGame = () => {
    remainingTime.value = 90;
    score.value = 0;
    currentClueIndex.value = 0;
    clues.value.forEach((clue, index) => {
      clue.visible = index === 0;
    });
  };

  const revealAllClues = () => {
    clues.value.forEach((clue) => (clue.visible = true));
  };


  return {
    remainingTime,
    clues,
    pointsPerClue,
    currentClueIndex,
    score,
    answer,
    currentPoints,
    answerValidation,
    revealNextClue,
    addPointsForCurrentClue,
    resetGame,
    revealAllClues,
  };
});
