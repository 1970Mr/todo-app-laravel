<script setup>
import {defineEmits} from 'vue'

const emit = defineEmits(['todoList'])
const statusFilters = ['all', 'active', 'completed']

function filterTodo(filter) {
  emit('onFilter', filter)
}
</script>

<template>
  <div class="relative inline-block">
    <select
        class="block appearance-none bg-gray-100 border border-gray-200 text-gray-700 py-1 pl-2 pr-4 rounded-lg shadow-sm focus:outline-none focus:bg-white focus:border-none focus:ring-2 focus:ring-indigo-500"

        @change="filterTodo($event.target.value)"
    >
      <option
          v-for="(statusFilter, index) in statusFilters"
          :key="index"
          :value="statusFilter"
      >{{ statusFilter.toUpperCase() }}
      </option>
    </select>
  </div>
</template>
