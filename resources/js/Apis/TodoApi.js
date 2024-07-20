import route from 'ziggy-js';
import PositionHandler from "@/Helpers/PositionHandler.js";
import {console} from "vuedraggable/src/util/console.js";

class TodoApi {
  async get(page = 1, perPage = 5, statusFilter = null, search = null) {
    try {
      const response = await axios.get(route('todos.get'), {params: {page, perPage, statusFilter, search}});
      return response.data;
    } catch (error) {
      console.error('Error getting todos:', error);
      return false
    }
  }

  async store(data) {
    try {
      const response = await axios.post(route('todos.store'), data);
      return response.data;
    } catch (error) {
      console.error('Error adding todo:', error);
      return false
    }
  }

  async destroy(id) {
    try {
      await axios.delete(route('todos.destroy', { todo: id }));
      return true;
    } catch (error) {
      console.error('Error deleting todo:', error);
      return false
    }
  }

  async update(data) {
    try {
      const response = await axios.put(route('todos.update', { todo: data.id }), data);
      return response.data;
    } catch (error) {
      console.error('Error updating todo:', error);
      return false
    }
  }

  async updatePosition(todo, todos) {
    try {
      const newPosition = PositionHandler.newPosition(todo, todos)
      await axios.put(route('todos.update-position', {todo: todo.id}), {newPosition})
      return newPosition;
    } catch (error) {
      console.error('Error changing todos position:', error);
      return false
    }
  }
}

export default TodoApi;
