<script setup lang="ts">

defineProps({
  step: {
    type: Number,
    required: true,
  },
});

const messages = [
  "Cliquez sur le bouton en haut à droite pour faire apparaitre les differents indices.",
  "Votre score est indiqué en haut à gauche.",
  "Saisissez votre réponse dans la boite en dessous des indices et cliquer sur Répondre ou appuyer sur Entrée.",
  "Plus vous dévoilez d'indices moins vous gagnez de points.",
  "Attention vous n'avez droit qu'à une seule réponse par question.",
  "Vous avez 90 secondes pour répondre.",
  "Le compte à rebours commence quand vous cliquer sur Commencer.",



];
</script>

<template>
  <div class="fixed inset-x-0 md:top-0 top-16 flex items-center justify-center">
    <div class="bg-white md:p-6 p-3 rounded-lg shadow-lg max-w-md md:w-full w-1/2 ">
      <p class="text-black md:text-lg text-sm mb-4">{{ messages[step] }}</p>
      <div class="flex justify-end space-x-2">
        <button
          v-if="step < messages.length - 1"
          @click="$emit('nextStep')"
          class="px-4 py-2 bg-green-500 text-white rounded-lg md:text-lg text-sm"
        >
          Suivant
        </button>
        <button
          v-if="step === messages.length - 1"
          @click="$emit('exitDemo')"
          class="px-4 py-2 bg-red-500 text-white rounded-lg md:text-lg text-sm"
        >
          Commencer le jeu
        </button>
      </div>
    </div>
  </div>
</template>
