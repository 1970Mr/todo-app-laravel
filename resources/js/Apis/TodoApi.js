import route from 'ziggy-js';

class TodoApi {
  static async get() {
    try {
      const response = await axios.get(route('todo.get'));
      return response.data;
    } catch (error) {
      console.error('Error getting todos:', error);
      return false
    }
  }

  static async store(data) {
    try {
      const response = await axios.post(route('todo.store'), data);
      return response.data;
    } catch (error) {
      console.error('Error adding todo:', error);
      return false
    }
  }

  static async destroy(id) {
    try {
      await axios.delete(route('todo.destroy', { todo: id }));
      return true;
    } catch (error) {
      console.error('Error deleting todo:', error);
      return false
    }
  }

  static async update(data) {
    try {
      const response = await axios.put(route('todo.update', { todo: data.id }), data);
      return response.data;
    } catch (error) {
      console.error('Error updating todo:', error);
      return false
    }
  }
}

export default TodoApi;
