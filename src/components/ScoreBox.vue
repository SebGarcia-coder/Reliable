<script setup lang="ts">
import { useGameStore } from '@/stores/game';

const gameStore = useGameStore();
</script>
<template>
  <div class=" h-12 rounded-lg bg-custom-dark-green px-4 flex items-center text-white">
    <slot></slot>
  </div>
</template>
