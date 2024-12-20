<script setup lang="ts">
import { ref, onMounted} from 'vue';

const emit = defineEmits(['update:modelValue']);

defineProps({
  modelValue: String,
  placeholder: {
    type: String,
    default: 'Votre réponse',
  },
});

const inputBox = ref<HTMLInputElement | null>(null);

const updateValue = (event: Event) => {
  const input = event.target as HTMLInputElement;
  const sanitizedInput = input.value.replace(/[^\p{L}\p{N} ]/gu, '');
  emit('update:modelValue', sanitizedInput);
};

onMounted(() => {
  if (inputBox.value) {
    inputBox.value.focus();
  }
});
</script>

<template>
  <div class="md:w-96 w-80 md:h-24 h-16 rounded-lg bg-white flex items-center px-4">
    <input
      ref="inputBox"
      :value="modelValue"
      @input="updateValue"
      :placeholder="placeholder"
      class="bg-transparent border-none outline-none text-black w-full overflow-x-auto "
      type="text"
      maxlength="100"
    />
  </div>
</template>
