import axios from 'axios';
import route from 'ziggy-js';
import {usePage} from "@inertiajs/vue3";

class TodoApi {
  addUserIdToRequest(data) {
    const token = usePage().props?.auth?.token
    const userId = usePage().props?.auth?.user?.id;
    return { ...data, userId, token };
  }

  async get() {
    try {
      const response = await axios.get(route('todo.get'), { params: this.addUserIdToRequest() });
      return response.data;
    } catch (error) {
      console.error('Error getting todos:', error);
      return false;
    }
  }

  async store(data) {
    try {
      const response = await axios.post(route('todo.store'), this.addUserIdToRequest(data));
      return response.data;
    } catch (error) {
      console.error('Error adding todo:', error);
      return false;
    }
  }

  async destroy(id) {
    try {
      await axios.delete(route('todo.destroy', { todo: id }), { params: this.addUserIdToRequest() });
      return true;
    } catch (error) {
      console.error('Error deleting todo:', error);
      return false;
    }
  }

  async update(data) {
    try {
      const response = await axios.put(route('todo.update', { todo: data.id }), this.addUserIdToRequest(data));
      return response.data;
    } catch (error) {
      console.error('Error updating todo:', error);
      return false;
    }
  }
}

export default TodoApi;
