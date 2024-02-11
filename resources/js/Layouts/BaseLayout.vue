<script setup>
const props = defineProps(['title'])

</script>

<template>
  <div
    class="max-w-md w-full p-6 bg-white bg-opacity-20 backdrop-blur-md rounded-lg"
  >
    <h1 class="text-2xl font-bold mb-4 text-center text-white" v-if="$page.props?.title">{{ props.title }}</h1>
    <slot/>
  </div>
</template>
