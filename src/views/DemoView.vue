<script setup lang="ts">
import ClueBox from '../components/ClueBox.vue'
import Button from '../components/Button.vue'
import AnswerInput from '../components/AnswerInput.vue'
import Timer from '../components/TimerBar.vue'
import { useGameStore } from '@/stores/game'
import ResultBox from '../components/ResultBox.vue'
import ScoreBox from '@/components/ScoreBox.vue'
import { onMounted } from 'vue'

const gameStore = useGameStore()

const handleTimerEnd = () => {
  if (gameStore.currentClueIndex < gameStore.clues.length - 1) {
  }

  gameStore.revealAllClues(gameStore.currentQuestionId)
  gameStore.answerSubmitted = true
  gameStore.userAnswer = ''
  gameStore.answerValidation.message = 'Temps écoulé !'
  gameStore.submitAnswer()
}

onMounted(() => {
  gameStore.getRandomQuestion('common')
})
</script>

<template>
  <div class="flex justify-between p-5 -mb-20 md:-mb-24">
    <div class="">
      <ScoreBox>Score : {{ gameStore.score }}</ScoreBox>
    </div>
    <div class="">
      <Button
        v-if="gameStore.currentClueIndex < 3 && gameStore.remainingTime > 0 && gameStore.answerSubmitted === false"
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
    <div class="flex flex-col space-y-2 max-w-[80%] md:max-w-3xl md: ">
      <div class="flex items-center justify-end">
        <Timer v-if="gameStore.answerSubmitted === false" @timerEnd="handleTimerEnd" />
      </div>
      <!-- TODO : mettre un display grid pour les cluebox -->
      <div class="flex justify-between gap-6 flex-wrap transition-opacity duration-500 ease-in-out">
        <ClueBox
          v-for="(clue, index) in gameStore.clues"
          :key="index"
          :text="clue.text"
          :visible="clue.visible"
        />
      </div>
      <div class="space-y-6 items-center flex flex-col">
        <ResultBox v-if="gameStore.remainingTime === 0 || gameStore.answerSubmitted === true" />
        <Button
          v-if="gameStore.remainingTime === 0 || gameStore.answerSubmitted === true"
          color="bg-custom-green"
          hover="bg-custom-green-hover"
          @click="gameStore.getRandomQuestion('common')"
          >Question suivante</Button
        >
      </div>
    </div>
    <AnswerInput
      placeholder="Entrez votre réponse ici"
      v-if="gameStore.remainingTime > 0 && gameStore.answerSubmitted === false"
    />
  </div>
</template>
