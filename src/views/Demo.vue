<script setup lang="ts">
import { ref } from 'vue'
import ClueBox from '../components/ClueBox.vue'
import Button from '../components/Button.vue'
import AnswerInput from '../components/AnswerInput.vue'
import Timer from '../components/Timer.vue'

const clues = ref([
  { text: '+ de 10 000 €', visible: true },
  { text: 'Un animal de compagnie', visible: false },
  { text: '+ de 200 cigarettes', visible: false },
  { text: '+ de 10L de whisky', visible: false },
])

const pointsPerClue = [5, 3, 2, 1]
const currentClueIndex = ref(0)

const revealClue = () => {
  if (currentClueIndex.value < clues.value.length - 1) {
    clues.value[currentClueIndex.value + 1].visible = true
    currentClueIndex.value++
  }
}

const handleTimerEnd = () => {
  console.log('Time is up! Game over!')
}
</script>

<template>
  <div class="flex flex-col items-center justify-center min-h-screen space-y-6">
    <div class="absolute top-4 right-4">
      <Button color="bg-custom-burgondy" hover="bg-custom-burgondy-hover" @click="revealClue"
        >Indice suivant</Button
      >
    </div>
    <div class="flex flex-col space-y-2">
      <Timer
      :pointsPerClue="pointsPerClue"
      :currentClueIndex="currentClueIndex"
      @timerEnd="handleTimerEnd"
      />
      <div class="flex">
        <ClueBox
          v-for="(clue, index) in clues"
          :key="index"
          :text="clue.text"
          :visible="clue.visible"


        />
      </div>
    </div>
    <AnswerInput
    placeholder="Entrez votre réponse ici"
    :clues="clues" />
  </div>
</template>

