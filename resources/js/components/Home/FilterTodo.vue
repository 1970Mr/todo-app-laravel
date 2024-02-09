<template>
  <div class="relative inline-block">
    <select
        class="block appearance-none bg-gray-100 border border-gray-200 text-gray-700 py-1 pl-2 pr-4 rounded-lg shadow-sm focus:outline-none focus:bg-white focus:border-gray-500"
        @change="filterTodo($event.target.value)"
    >
      <option
          v-for="(filterOption, index) in filterOptions"
          :key="index"
          :value="filterOption"
      >{{ filterOption.toUpperCase() }}
      </option>
    </select>
    <div class="absolute right-0 top-[.6rem] flex items-center px-1 pointer-events-none">
      <i class="bx bx-chevron-down"></i>
    </div>
  </div>
</template>

<script setup>
import {defineEmits} from 'vue'

const emit = defineEmits(['todoList'])
const filterOptions = ['all', 'active', 'completed']

function filterTodo(filter) {
  emit('onFilter', filter)
}
</script>