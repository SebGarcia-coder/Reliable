<script setup lang="ts">
import ClueBox from '../components/ClueBox.vue'
import Button from '../components/Button.vue'
import AnswerInput from '../components/AnswerInput.vue'
import Timer from '../components/Timer.vue'
import { useGameStore } from '@/stores/game';
import ResultBox from '../components/ResultBox.vue'
import ScoreBox from '@/components/ScoreBox.vue'

const gameStore = useGameStore();

const handleTimerEnd = () => {
  gameStore.revealAllClues();
};
</script>

<template>
  <div class="flex flex-col items-center justify-center min-h-screen space-y-6">
    <div class="absolute top-4 left-4">
      <ScoreBox>Score : {{ gameStore.currentPoints }}</ScoreBox>
    </div>
    <div class="absolute top-4 right-4">
      <Button
      v-if="gameStore.currentClueIndex < 3 && gameStore.remainingTime > 0"
      color="bg-custom-burgondy"
      hover="bg-custom-burgondy-hover"
      @click="gameStore.revealNextClue"
        >Indice suivant</Button
      >
    </div>
    <div class="flex flex-col space-y-2  max-w-[60%]">
      <Timer
      v-if="gameStore.remainingTime > 0"
      @timerEnd="handleTimerEnd"
      />
      <div class="flex">
        <ClueBox
          v-for="(clue, index) in gameStore.clues"
          :key="index"
          :text="clue.text"
          :visible="clue.visible"


        />
      </div>
      <div class="w-full">
        <ResultBox v-if="gameStore.remainingTime === 0"/>
      </div>
    </div>
    <AnswerInput
    placeholder="Entrez votre réponse ici"
    v-if="gameStore.remainingTime > 0"
    />
  </div>
</template>

