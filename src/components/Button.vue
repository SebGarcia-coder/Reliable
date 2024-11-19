<script setup lang="ts">
import { computed } from 'vue';

const { color, hover } = defineProps({
  color: {
    type: String,
    default: 'custom-green',
  },

  hover: {
    type: String,
    default: 'custom-green-hover'
  },
})

const buttonClass = computed(() => `${color} hover:${hover} text-white rounded-lg px-4 py-2` )
</script>

<template>
  <button :class="buttonClass">
    <slot></slot>
  </button>
</template>

<style></style>
