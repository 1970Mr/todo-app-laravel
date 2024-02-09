<template>
  <!-- Add todo item -->
  <div class="flex mb-4">
    <input
      @keydown.enter="addTodo"
      v-model="newTodo"
      type="text"
      placeholder="Add a new todo item"
      class="flex-1 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 ring-inset focus:ring-blue-500"
      autofocus
    />
    <button
      @click="addTodo"
      class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 ring-inset focus:ring-blue-500"
    >
      Add
    </button>
  </div>
</template>

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
