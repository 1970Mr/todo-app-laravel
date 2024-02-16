import route from 'ziggy-js';
import TodoOrder from "@/Helpers/TodoOrder.js";

class TodoApi {
  async get(filteredData, page = 1, perPage = 5) {
    try {
      const response = await axios.get(route('todo.get'), {params: {page, perPage, filteredData}});
      return response.data;
    } catch (error) {
      console.error('Error getting todos:', error);
      return false
    }
  }

  async store(data) {
    try {
      const response = await axios.post(route('todo.store'), data);
      return response.data;
    } catch (error) {
      console.error('Error adding todo:', error);
      return false
    }
  }

  async destroy(id) {
    try {
      await axios.delete(route('todo.destroy', { todo: id }));
      return true;
    } catch (error) {
      console.error('Error deleting todo:', error);
      return false
    }
  }

  async update(data) {
    try {
      const response = await axios.put(route('todo.update', { todo: data.id }), data);
      return response.data;
    } catch (error) {
      console.error('Error updating todo:', error);
      return false
    }
  }

  async changeOrder(todo, todos) {
    try {
      const newOrder = TodoOrder.newOrder(todo, todos)
      await axios.put(route('todo.order', {todo: todo.id}), {newOrder})
      return newOrder;
    } catch (error) {
      console.error('Error changing todos order:', error);
      return false
    }
  }
}

export default TodoApi;
