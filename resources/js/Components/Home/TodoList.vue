<script setup>
import AddTodo from "@/Components/Home/AddTodo.vue"
import DeleteModal from "@/Components/DeleteModal.vue";
import FilterTodo from "@/Components/Home/FilterTodo.vue"
import {ref, watch} from "vue"
import route from 'ziggy-js'
import TodoProvider from '@/Helpers/TodoProvider'
import {usePage} from "@inertiajs/vue3";
import draggable from 'vuedraggable'

const todos = ref([])
const selectedTodoItem = ref(null)
const statusFilter = ref('all')
const searchItem = ref(null)
const csrfToken = ref('')
const todoProvider = ref('')
const todosInfo = ref('')
const currentPage = ref(1)
const user = ref({})
const runFetch = ref()
const isDragging = ref(false);

user.value = usePage().props?.auth?.user
csrfToken.value = usePage().props?.csrf_token;
todoProvider.value = TodoProvider.createTodoProvider(user.value?.id)

watch([currentPage, statusFilter, searchItem, runFetch], async () => {
    await fetchTodos()
  },
  {immediate: true}
)

async function fetchTodos() {
  todosInfo.value = await todoProvider.value.get(currentPage.value, 5, statusFilter.value, searchItem.value)
  todos.value = todosInfo.value.data
}

async function onDraggable(data) {
  isDragging.value = true;
  const todo = data['moved']['element']
  await todoProvider.value.updatePosition(todo, todos.value)
  await fetchTodos()
  isDragging.value = false;
}

const paginateHandler = (page) => {
  currentPage.value = page
};

function addItem(data) {
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
  statusFilter.value = filter
}

async function changeStatus(todoItem) {
  todoItem.status = !todoItem.status
  await todoProvider.value.update(todoItem)
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

  <AddTodo @add-item="addItem"/>

  <!-- Todo list -->
  <draggable
    class="space-y-4"
    v-model="todos"
    group="people"
    :disabled="isDragging"
    :class="{ 'draggable-disabled': isDragging }"
    @start="drag=true"
    @end="drag=false"
    item-key="id"
    @change="onDraggable"
  >
    <!-- Single todo item -->
    <template #item="{element}">
      <div
        :id="element.id"
        @dblclick="changeStatus(element)"
      >
        <div class="flex items-center justify-between" v-if="element.inEdit">
          <input
            class="bg-white rounded-l-lg px-4 py-2 w-full focus:outline-none"
            v-model="element.text"
            @keydown.enter.prevent="onUpdate(element)"
            @dblclick.stop
          >
          <button
            class="text-green-600 bg-white bg-opacity-50 p-2 hover:text-green-500"
            @click="onUpdate(element)"
          >
            <i class="bx bx-edit"></i>
          </button>
          <button
            class="text-red-500 bg-white bg-opacity-50 p-2 hover:text-red-700 rounded-r-lg"
            @click="onCancel(element)"
          >
            <i class="bx bx-x-circle"></i>
          </button>
        </div>

        <div class="flex items-center justify-between bg-white bg-opacity-50 rounded-lg px-4 py-2" v-if="!element.inEdit">
          <span
            class="flex-1 text-gray-800 break-all select-none"
            :class="element.status ? 'line-through' : ''"
          >
            <span @dblclick.stop="onEdit(element)">{{ element.text }}</span>
          </span>
          <div class="flex space-x-2">
            <!-- Edit icon -->
            <button class="text-blue-500 hover:text-blue-700" title="Edit" @click="onEdit(element)">
              <i class="bx bx-edit-alt"></i>
            </button>
            <!-- Delete icon -->
            <button
              class="text-red-500 hover:text-red-700"
              title="Delete"
              @click="openDeleteModal(element)"
            >
              <i class="bx bx-trash"></i>
            </button>
            <!-- completed/Uncompleted button -->
            <button
              class="text-green-500 hover:text-green-700"
              :title="element.status ? 'uncompleted' : 'completed'"
              @click="changeStatus(element)"
            >
              <i class="bx bx-check completed-icon" v-if="!element.status"></i>
              <i class="bx bx-check-double completed-icon" v-if="element.status"></i>
            </button>
          </div>
        </div>
      </div>
    </template>
  </draggable>

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
