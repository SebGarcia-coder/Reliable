<script setup lang="ts">
import { ref,  } from 'vue'
import ClueBox from '../components/ClueBox.vue'
import Button from '../components/Button.vue'
import AnswerInput from '../components/AnswerInput.vue'
import Timer from '../components/Timer.vue'

const clues = ref([
  { text: 'Reine', visible: true },
  { text: 'Main', visible: false },
  { text: 'Atout', visible: false },
  { text: 'Trèfle', visible: false },
])

const totalTime = 60
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
    <div>
      <div class="absolute top-8 left-8">
        <Timer
          :totalTime="totalTime"
          :pointsPerClue="pointsPerClue"
          :currentClueIndex="currentClueIndex"
          @timerEnd="handleTimerEnd"
        />
      </div>
      <div class="relative flex space-x-4">
      <ClueBox
        v-for="(clue, index) in clues"
        :key="index"
        :text="clue.text"
        :visible="clue.visible"
      />
    </div>
    </div>

    <AnswerInput placeholder="Entrez votre réponse ici" />
  </div>
</template>
