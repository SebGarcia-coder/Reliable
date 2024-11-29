<script setup lang="ts">
const emit = defineEmits(['update:modelValue']);

defineProps({
  modelValue: String,
  placeholder: {
    type: String,
    default: 'Votre réponse',
  },
});

const updateValue = (event: Event) => {
  const input = event.target as HTMLInputElement;
  emit('update:modelValue', input.value);
};
</script>

<template>
  <div class="w-96 h-12 rounded-lg bg-white flex items-center px-4">
    <input
      :value="modelValue"
      @input="updateValue"
      :placeholder="placeholder"
      class="w-full h-full bg-transparent border-none outline-none text-black"
      type="text"
      maxlength="100"
    />
  </div>
</template>
