<template>
  <TodoList :todoList="todoList" />
</template>

<script setup>
import TodoList from '@/Components/Home/TodoList.vue';

defineProps([
    'todoList'
])
</script>

<style>

</style>
