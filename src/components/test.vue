<template>
  <div class="relative flex space-x-4">
    <div class="absolute -top-7 left-4">
      <Timer />
    </div>
    <ClueBox />
  </div>

  <div class="relative flex space-x-4">
    <ClueBox />
    <div class="absolute -top-7 left-4">
      <Timer />
    </div>
    <ClueBox />
  </div>
</template>

<script>
function isPrimeNumber(number) {
  for (let i = 2; i <= Math.sqrt(number); i++) {
    if (number % i === 0) {
      return false
    }
  }
  return true
}
</script>
