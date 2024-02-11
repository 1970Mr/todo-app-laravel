<template>
  <div
    id="delete-modal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
    @click="emit('closeDeleteModal')"
  >
    <div class="bg-white p-6 rounded-lg max-w-md" @click.stop="">
      <p class="text-lg text-gray-800 mb-4">
        {{ props.message }}
      </p>
      <div class="flex justify-end">
        <button
          @click="emit('confirm')"
          @keydown.enter.prevent="emit('confirm')"
          ref="confirmBtn"
          class="bg-red-500 text-white px-4 py-2 rounded-md mr-2 hover:bg-red-600"
        >
          Delete
        </button>
        <button
          @click="emit('closeDeleteModal')"
          class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import {defineProps, defineEmits, ref, onMounted, onUnmounted} from "vue"

const props = defineProps(['message'])
const emit = defineEmits(['confirm', 'closeDeleteModal'])
const confirmBtn = ref(null)

onMounted(() => {
  document.body.appendChild(document.getElementById('delete-modal'));
  confirmBtn.value.focus();
});

onUnmounted(() => {
  const modal = document.getElementById('delete-modal');
  if (modal) modal.remove();
});
</script>
