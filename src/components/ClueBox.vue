<script setup lang="ts">


defineProps({
  text: String,
  visible: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <div>
    <div
      v-if="visible"
      class="flex items-center justify-center w-56 h-56 bg-custom-green-cluebox rounded-lg shadow-lg text-center text-white text-2xl ml-6 p-2"
    >
      {{ text }}
    </div>
  </div>
</template>
