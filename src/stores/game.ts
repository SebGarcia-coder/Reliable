import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useGameStore = defineStore('game', () => {
  const remainingTime = ref(60)
  const clues = ref<{ text: string; visible: boolean }[]>([])
  const pointsPerClue = ref([5, 3, 2, 1])
  const currentClueIndex = ref(0)
  const score = ref(0)
  const answerSubmitted = ref(false)
  const currentQuestionId = ref<number | null>(null)
  const userAnswer = ref('')
  const answerValidation = ref({
    isValid: null as boolean | null,
    message: '',
  })

  const currentPoints = computed(() => pointsPerClue.value[currentClueIndex.value])

  const addPointsForCurrentClue = () => {
    score.value += currentPoints.value
  }

  const resetGame = () => {
    remainingTime.value = 90
    score.value = 0
    currentClueIndex.value = 0
    clues.value.forEach((clue, index) => {
      clue.visible = index === 0
    })
  }

  const revealAllClues = async (id: number | null) => {
    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/questions/${id}`, {})

      const { allClues } = response.data
      const allCluesTodisplay: { text: string; visible: boolean }[] = []

      allClues.map((clue: string) => {
        return allCluesTodisplay.push({ text: clue, visible: true })
      })

      clues.value = allCluesTodisplay
    } catch (error) {
      console.error('Error fetching question:', error)
      alert('There was an error. Please try again.')
    }
  }

  const getRandomQuestion = async (type: string) => {
    remainingTime.value = 30
    clues.value = []
    currentClueIndex.value = 0
    currentQuestionId.value = null
    userAnswer.value = ''
    answerValidation.value = { isValid: false, message: '' }
    answerSubmitted.value = false
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/questions/random', {
        params: {
          type: type,
        },
      })
      const { questionId, firstClue } = response.data as { questionId: number; firstClue: string }

      currentQuestionId.value = questionId

      clues.value.push({ text: firstClue, visible: true })
    } catch (error) {
      console.error('Error fetching question:', error)
      alert('There was an error. Please try again.')
    }
  }

  const revealNextClue = async (id: number | null, index: number) => {
    try {
      const response = await axios.get(
        `http://127.0.0.1:8000/api/questions/${id}/clue/${index}`,
        {},
      )

      const { clue } = response.data as { clue: string }
      clues.value.push({ text: clue, visible: true })
    } catch (error) {
      console.error('Error fetching question:', error)
      alert('There was an error. Please try again.')
    }
    clues.value[currentClueIndex.value + 1].visible = true
    currentClueIndex.value++
  }

  const submitAnswer = async () => {
    answerSubmitted.value = true
    try {
      const response = await axios.post('http://127.0.0.1:8000/api/validate-answer', {
        userAnswer: userAnswer.value,
        questionId: currentQuestionId.value,
        currentPoints: currentPoints.value,
      })
      const { isValid, validatorMessage } = response.data as {
        isValid: boolean
        validatorMessage: string
      }

      answerValidation.value.isValid = isValid
      answerValidation.value.message = validatorMessage

      revealAllClues(currentQuestionId.value)
      if (isValid) {
        addPointsForCurrentClue()
      }
      clues.value = []
    } catch (error) {
      console.error('Error validating answer:', error)
      alert('There was an error. Please try again.')
    }
  }

  return {
    remainingTime,
    clues,
    pointsPerClue,
    currentClueIndex,
    score,
    currentPoints,
    answerValidation,
    currentQuestionId,
    answerSubmitted,
    userAnswer,
    revealNextClue,
    addPointsForCurrentClue,
    resetGame,
    revealAllClues,
    getRandomQuestion,
    submitAnswer,
  }
})
