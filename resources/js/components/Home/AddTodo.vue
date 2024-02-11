<script setup>
import {ref, defineEmits} from "vue";
import TodoApi from "@/Apis/TodoApi.js";

const emit = defineEmits(['addTodo'])
const newTodo = ref('')

async function addTodo() {
  if (!newTodo.value.trim()) return
  const data = {text: newTodo.value, completed: false}
  const response = await TodoApi.store(data)
  if (!response?.status) return
  emit('addTodo', response.data)
  newTodo.value = ''
}
</script>

<template>
  <!-- Add todo item -->
  <div class="flex mb-4">
    <input
      @keydown.enter="addTodo"
      v-model="newTodo"
      type="text"
      placeholder="Add a new todo item"
      class="flex-1 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
      autofocus
    />
    <button
      @click="addTodo"
      class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg focus:outline-none focus:ring-2 ring-inset focus:ring-indigo-400"
    >
      Add
    </button>
  </div>
</template>
