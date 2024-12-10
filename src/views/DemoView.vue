<script setup lang="ts">
import ClueBox from '../components/ClueBox.vue'
import Button from '../components/Button.vue'
import AnswerInput from '../components/AnswerInput.vue'
import Timer from '../components/TimerBar.vue'
import { useGameStore } from '@/stores/game'
import ResultBox from '../components/ResultBox.vue'
import ScoreBox from '@/components/ScoreBox.vue'
import DemoModal from '@/components/DemoModal.vue'
import { computed, onMounted } from 'vue'
import { QuestionType } from '@/enums/game'
import { useRouter } from 'vue-router'

const gameStore = useGameStore()
const router = useRouter()

const TIME_IS_UP = 'Temps écoulé'

const questionType = computed(() => {
  if (gameStore.currentQuestionNumber < 3) {
    return QuestionType.COMMON
  } else {
    return QuestionType.SEQUENCE
  }
})

const showClueButton = computed(() => {
  return (
    gameStore.currentClueIndex < 3 &&
    gameStore.remainingTime > 0 &&
    gameStore.answerSubmitted === false
  )
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
    router.push('/rules-3')
  } else if (gameStore.currentQuestionNumber === 6) {
    router.push('/summary')
  } else {
    gameStore.getRandomQuestion(questionType.value, gameStore.usedQuestionIds)
  }
}

onMounted(() => {
  gameStore.getRandomQuestion(questionType.value, gameStore.usedQuestionIds)
})
</script>

<template>
  <div class="flex justify-between p-5 md:-mb-32 mb-32 h-24 text-sm md:text-lg">
    <div class="">
      <ScoreBox>Score : {{ gameStore.score }}</ScoreBox>
    </div>
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
  <div class="flex flex-col items-center md:justify-center min-h-screen ">
    <div class="flex flex-col space-y-2 max-w-[90%] md:max-w-3xl mb-6 ">
      <div v-if="!gameStore.demoMode" class="flex items-center md:justify-end justify-center" >
        <Timer v-if="gameStore.answerSubmitted === false && !gameStore.demoMode" @timerEnd="handleTimerEnd" />
        <div v-else class="h-5 relative"></div>
      </div>
      <!-- TODO : mettre un display grid pour les cluebox -->
      <div class="flex flex-wrap md:justify-between justify-between gap-2 md:gap-6 md:h-[150px] h-auto ">
        <ClueBox v-for="(clue, index) in gameStore.clues" :key="index" :text="clue.text" />
      </div>
    </div>
    <div class="max-w-[90%] md:max-w-3xl h-16 md:h-24 mb-6" >
        <ResultBox v-if="gameStore.remainingTime === 0 || gameStore.answerSubmitted === true" />
        <AnswerInput v-else placeholder="Entrez votre réponse ici" />
    </div>
    <Button
      v-if="gameStore.showNextQuestionButton"
      color="bg-custom-green"
      hover="bg-custom-green-hover"
      @click="handleButtonClick"
      class="text-lg"
      >{{ gameStore.currentQuestionNumber === 6 ? 'Voir le score' : 'Question suivante' }}</Button
    >
    <div v-else class="h-6 w-12 invisible"></div>

  </div>
  <DemoModal
    v-if="gameStore.demoMode"
    :step="gameStore.currentDemoStep"
    @nextStep="gameStore.proceedToNextDemoStep"
    @exitDemo="gameStore.exitDemoMode"
  />
</template>
