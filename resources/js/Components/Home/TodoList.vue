<script setup>
import AddTodo from "@/Components/Home/AddTodo.vue"
import DeleteModal from "@/Components/DeleteModal.vue";
import FilterTodo from "@/Components/Home/FilterTodo.vue"
import {onMounted, ref} from "vue"
import route from 'ziggy-js'
import TodoProvider from '@/Helpers/TodoProvider'
import {usePage} from "@inertiajs/vue3";

const todos = ref([])
const itemRefs = ref(null)
const selectedTodoItem = ref(null)
const filterOption = ref('all')
const searchItem = ref('')
const csrfToken = ref('')
const todoProvider = ref('')

onMounted(async () => {
  const user = usePage().props?.auth?.user
  todoProvider.value = TodoProvider.createTodoProvider(user)
  todos.value = await todoProvider.value.get()
  csrfToken.value = usePage().props?.csrf_token;
})

function addTodo(data) {
  todos.value.unshift(data)
}

function openDeleteModal(todoItem) {
  selectedTodoItem.value = todoItem
}

function closeDeleteModal() {
  selectedTodoItem.value = null
}

async function onDelete() {
  const response = await todoProvider.value.destroy(selectedTodoItem.value.id)
  if (!response) return
  todos.value = todos.value.filter(
    (item) => item.id !== selectedTodoItem.value.id
  )
  closeDeleteModal()
}

async function onUpdate(todoItem) {
  todoItem.text = todoItem.text.trim()
  const response = await todoProvider.value.update(todoItem)
  if (!response) return
  todoItem.inEdit = false
}

function onEdit(todoItem) {
  todoItem.inEdit = true
  todoItem.fomerText = todoItem.text
}

function onCancel(todoItem) {
  todoItem.inEdit = false
  todoItem.text = todoItem.fomerText
}

function doFilter(filter) {
  filterOption.value = filter
}

function filteredTodo() {
  const searchedTodo = searchTodo()

  if (filterOption.value === 'all')
    return searchedTodo
  if (filterOption.value === 'active')
    return searchedTodo.filter(item => !item.completed)
  if (filterOption.value === 'completed')
    return searchedTodo.filter(item => item.completed)
}

function searchTodo() {
  const searchRegex = new RegExp(searchItem.value, 'i');
  return searchItem.value !== '' ? todos.value.filter(item => searchRegex.test(item.text)) : todos.value
}

async function changeStatus(todoItem) {
  todoItem.completed = !todoItem.completed
  await todoProvider.value.update(todoItem)
}
</script>

<template>
    <!--  Login and Register  -->
    <div class="flex mb-4" v-if="!$page.props?.auth?.user">
      <a :href="route('login')" class="text-white hover:text-gray-200 mr-5 flex items-center bg-opacity-25 bg-white bg-blur rounded-lg p-3">
        <i class="bx bx-log-in mr-1"></i>
        <span>Login</span>
      </a>
      <a :href="route('register')" class="text-white hover:text-gray-200 flex items-center bg-opacity-25 bg-white bg-blur rounded-lg p-3">
      <i class="bx bx-user-plus text-[1.18rem] mr-1"></i>
        <span>Register</span>
      </a>
    </div>

    <!--  Logout  -->
    <div class="flex mb-4" v-if="$page.props?.auth?.user">
      <form :action="route('logout')" method="POST">
        <button type="submit" class="text-white hover:text-gray-200 flex items-center bg-opacity-25 bg-white bg-blur rounded-lg p-3">
          <i class="bx bx-log-out mr-1"></i>
          <span>Logout</span>
        </button>
        <input type="hidden" name="_token" :value="csrfToken">
        <div v-if="$page.props.flash.expired_message" class="text-red-900 mt-1 mb-2 text-sm">
          {{ $page.props.flash.expired_message }}
        </div>
      </form>
    </div>

    <!--  Search  -->
    <div class="flex items-center justify-between mb-4">
      <div class="relative">
        <i class="bx bx-search text-xl text-gray-300 absolute left-1 top-[.43rem]"></i>
        <input
          v-model="searchItem"
          type="text"
          placeholder="Search items..."
          class="flex-1 rounded-lg pr-2 pl-6 py-1 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
        />
      </div>

      <FilterTodo @on-filter="doFilter"/>
    </div>

    <AddTodo @add-todo="addTodo"/>

    <!-- Todo list -->
    <div class="space-y-4">
      <!-- Single todo item -->
      <div
        v-for="(todoItem, index) in filteredTodo()"
        :key="index"
        :id="todoItem.id"
        ref="itemRefs"
        @dblclick="changeStatus(todoItem)"
      >
        <div class="flex items-center justify-between" v-if="todoItem.inEdit">
          <input
            class="bg-white rounded-l-lg px-4 py-2 w-full focus:outline-none"
            v-model="todoItem.text"
            @keydown.enter.prevent="onUpdate(todoItem)"
          >
          <button
            class="text-green-600 bg-white bg-opacity-50 p-2 hover:text-green-500"
            @click="onUpdate(todoItem)"
          >
            <i class="bx bx-edit"></i>
          </button>
          <button
            class="text-red-500 bg-white bg-opacity-50 p-2 hover:text-red-700 rounded-r-lg"
            @click="onCancel(todoItem)"
          >
            <i class="bx bx-x-circle"></i>
          </button>
        </div>

        <div class="flex items-center justify-between bg-white bg-opacity-50 rounded-lg px-4 py-2" v-if="!todoItem.inEdit">
          <span
            class="flex-1 text-gray-800 break-all select-none"
            :class="todoItem.completed ? 'line-through' : ''"
          >
            <span @dblclick.stop="onEdit(todoItem)">{{ todoItem.text }}</span>
          </span>
          <div class="flex space-x-2">
            <!-- Edit icon -->
            <button class="text-blue-500 hover:text-blue-700" title="Edit" @click="onEdit(todoItem)">
              <i class="bx bx-edit-alt"></i>
            </button>
            <!-- Delete icon -->
            <button
              class="text-red-500 hover:text-red-700"
              title="Delete"
              @click="openDeleteModal(todoItem)"
            >
              <i class="bx bx-trash"></i>
            </button>
            <!-- completed/Uncompleted button -->
            <button
              class="text-green-500 hover:text-green-700"
              title="completed"
              @click="changeStatus(todoItem)"
            >
              <i class="bx bx-check completed-icon" v-if="!todoItem.completed"></i>
              <i class="bx bx-check-double completed-icon" v-if="todoItem.completed"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

  <DeleteModal
    v-if="selectedTodoItem"
    :message="'Are you sure you want to delete this todo item?'"
    @confirm="onDelete"
    @close-delete-modal="closeDeleteModal"/>

</template>

<style scoped>
.completed-icon {
  margin-right: -0.5rem;
}
</style>
