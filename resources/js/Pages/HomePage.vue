<template>
  <TodoList :todoList="todoList" />
</template>

<script setup>
import TodoList from '@/components/Home/TodoList.vue';

defineProps([
    'todoList'
])
</script>

<style>

</style>
