<script setup lang="ts">
import ClueBox from '../components/ClueBox.vue'
import Button from '../components/Button.vue'
import AnswerInput from '../components/AnswerInput.vue'
import Timer from '../components/TimerBar.vue'
import { useGameStore } from '@/stores/game'
import ResultBox from '../components/ResultBox.vue'
import ScoreBox from '@/components/ScoreBox.vue'
import { computed, onMounted } from 'vue'
import { QuestionType } from '@/enums/game'
import { useRouter } from 'vue-router';

const gameStore = useGameStore()
const router = useRouter();

const TIME_IS_UP = "Temps écoulé"

const questionType = computed(() => {
  if (gameStore.currentQuestionNumber < 3 ) {
    return QuestionType.COMMON
  } else {
    return QuestionType.SEQUENCE
  }
})

const showClueButton = computed(() => {
  return gameStore.currentClueIndex < 3 && gameStore.remainingTime > 0 && gameStore.answerSubmitted === false
})

const handleTimerEnd = () => {
  if (gameStore.currentClueIndex < gameStore.clues.length - 1) {
  }

  gameStore.revealAllClues(gameStore.currentQuestionId)
  gameStore.answerSubmitted = true
  gameStore.userAnswer = ''
  gameStore.answerValidation.message = TIME_IS_UP
  gameStore.submitAnswer()
}

const handleButtonClick = () => {
  if (gameStore.currentQuestionNumber === 3) {
    router.push('/rules-3');
  } else if (gameStore.currentQuestionNumber === 6) {
    router.push('/summary');
  } else {
    gameStore.getRandomQuestion(questionType.value, gameStore.usedQuestionIds);
  }
};

onMounted(() => {
  gameStore.getRandomQuestion(questionType.value, gameStore.usedQuestionIds)
})
</script>

<template>
  <div class="flex justify-between p-5 -mb-24 md:-mb-24">
    <div class="">
      <ScoreBox>Score : {{ gameStore.score }}</ScoreBox>
    </div>
    Question {{ gameStore.currentQuestionNumber }}/3
    <div>
      <Button
        v-if="showClueButton"
        color="bg-custom-burgondy"
        hover="bg-custom-burgondy-hover"
        @click="
          gameStore.revealNextClue(gameStore.currentQuestionId, gameStore.currentClueIndex + 1)
        "
        >Indice suivant</Button
      >
    </div>
  </div>
  <div class="flex flex-col items-center justify-center min-h-screen space-y-6 overflow-hidden">
    <div class="flex flex-col space-y-2 max-w-[80%] md:max-w-3xl">
      <div class="flex items-center justify-end">
        <Timer v-if="gameStore.answerSubmitted === false" @timerEnd="handleTimerEnd" />
      </div>
      <!-- TODO : mettre un display grid pour les cluebox -->
      <div class="flex justify-between gap-6 flex-wrap h-40 items-center transition-opacity duration-500 ease-in-out">
        <ClueBox
          v-for="(clue, index) in gameStore.clues"
          :key="index"
          :text="clue.text"
        />
      </div>
      <div class="space-y-6 items-center flex flex-col">
        <ResultBox v-if="gameStore.remainingTime === 0 || gameStore.answerSubmitted === true" class="mt-4 h-20" />
        <Button
          v-if="gameStore.showNextQuestionButton"
          color="bg-custom-green"
          hover="bg-custom-green-hover"
          @click="handleButtonClick"
          >{{ gameStore.currentQuestionNumber === 6 ? 'Voir le score' : 'Question suivante' }}</Button
        >
      </div>
    </div>
    <AnswerInput
      placeholder="Entrez votre réponse ici"
      v-if="gameStore.remainingTime > 0 && gameStore.answerSubmitted === false"
      class="mt-4 h-24"
    />
  </div>
</template>
