<script setup>
import AddTodo from "@/Components/Home/AddTodo.vue"
import DeleteModal from "@/Components/DeleteModal.vue";
import FilterTodo from "@/Components/Home/FilterTodo.vue"
import {onBeforeMount, onBeforeUnmount, ref, watch} from "vue"
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
const todosInfo = ref('')
const currentPage = ref(1)
const user = ref({})
const filteredData = ref({})
const runFetch = ref()

user.value = usePage().props?.auth?.user
csrfToken.value = usePage().props?.csrf_token;
todoProvider.value = TodoProvider.createTodoProvider(user.value?.id)

watch([currentPage, filteredData, runFetch], async () => {
  todosInfo.value = await todoProvider.value.get(filteredData.value, currentPage.value)
  todos.value = todosInfo.value.data
},
  { immediate: true }
)

watch([filterOption, searchItem],  () => {
    filteredData.value = {
      'filter': filterOption.value,
      'search': searchItem.value
    }
  }
)

const paginateHandler = (page) => {
  currentPage.value = page
};

function addTodo(data) {
  todos.value.unshift(data)
  runFetch.value = new Date()
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
  runFetch.value = new Date()
}

async function onUpdate(todoItem) {
  todoItem.text = todoItem.text.trim()
  const response = await todoProvider.value.update(todoItem)
  if (!response) return
  todoItem.inEdit = false
  runFetch.value = new Date()
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

async function changeStatus(todoItem) {
  todoItem.completed = !todoItem.completed
  await todoProvider.value.update(todoItem)
  runFetch.value = new Date()
}
</script>

<template>
    <!--  Login and Register  -->
    <div class="flex mb-4" v-if="!user?.id">
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
    <div class="flex mb-4" v-if="user?.id">
      <form :action="route('logout')" method="POST">
        <button type="submit" class="text-white hover:text-gray-200 flex items-center bg-opacity-25 bg-white bg-blur rounded-lg p-3">
          <i class="bx bx-log-out mr-1"></i>
          <span>Logout</span>
        </button>
        <input type="hidden" name="_token" :value="csrfToken">
        <div v-if="$page.props?.flash?.expired_message" class="text-red-900 mt-1 mb-2 text-sm">
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
        v-for="(todoItem, index) in todos"
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

  <div class="flex justify-center mt-5" v-if="todosInfo.total > todosInfo.per_page">
    <vue-awesome-paginate
      :total-items="todosInfo.total"
      :items-per-page="todosInfo.per_page"
      :max-pages-shown="3"
      v-model="currentPage"
      :on-click="paginateHandler"
    >
      <template #prev-button>
        <i class="bx bx-chevron-left text-[1.3rem] font-bold"></i>
      </template>

      <template #next-button>
        <i class="bx bx-chevron-right text-[1.3rem] font-bold"></i>
      </template>
    </vue-awesome-paginate>
  </div>

  <DeleteModal
    v-if="selectedTodoItem"
    :message="'Are you sure you want to delete this todo item?'"
    @confirm="onDelete"
    @close-delete-modal="closeDeleteModal"/>

</template>

<style>
.completed-icon {
  margin-right: -0.5rem;
}

.pagination-container {
  border-radius: 22px;
  overflow: hidden;
}
.paginate-buttons {
  width: 33px;
  height: 33px;
  cursor: pointer;
  border: none;
  border-inline: 1px solid theme('colors.indigo.400')
}
.paginate-buttons {
  @apply bg-indigo-600 text-white flex items-center justify-center
}
.active-page {
  @apply bg-indigo-400 text-white
}
.paginate-buttons:hover {
  @apply bg-indigo-800
}
.active-page:hover {
  @apply bg-indigo-400
}
.back-button {
  border-inline-start: none;
}
.next-button {
  border-inline-end: none;
}
.back-button svg {
  transform: rotate(180deg);
}

.back-button:active,
.next-button:active {
  @apply bg-indigo-800
}
</style>
