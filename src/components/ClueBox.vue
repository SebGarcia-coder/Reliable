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

    <div
      class=" flex items-center justify-center w-32 md:w-40 md:h-full h-24 bg-custom-green-cluebox rounded-lg shadow-lg text-center text-white md:text-2xl text-[1.25rem] md:break-keep break-words p-2"
    >
      {{ text }}
    </div>

</template>
