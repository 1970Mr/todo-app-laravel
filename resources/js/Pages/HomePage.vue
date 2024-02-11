<script setup>
import TodoList from '@/Components/Home/TodoList.vue';

defineProps([
  'todoList'
])
</script>

<template>
  <TodoList :todoList="todoList" />
</template>
