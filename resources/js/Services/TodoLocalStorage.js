import PositionHandler from "@/Helpers/PositionHandler.js";

class TodoLocalStorage {
  async get(page = 1, perPage = 5, statusFilter = null, search = null) {
    const todos = this._getTodos();

    // Apply filters
    let filteredTodos = todos;
    if (statusFilter === 'active') {
      filteredTodos = filteredTodos.filter(todo => !todo.status);
    } else if (statusFilter === 'completed') {
      filteredTodos = filteredTodos.filter(todo => todo.status);
    }

    // Apply search
    if (search) {
      const searchTerm = search.toLowerCase();
      filteredTodos = filteredTodos.filter(todo => todo.text.toLowerCase().includes(searchTerm));
    }

    // Calculate pagination
    const startIndex = (page - 1) * perPage;
    const endIndex = startIndex + perPage;
    const paginatedTodos = filteredTodos.slice(startIndex, endIndex);

    // Simulate response structure similar to Laravel pagination
    const totalPages = Math.ceil(filteredTodos.length / perPage);
    const currentPage = page;
    const from = startIndex + 1;
    const to = Math.min(endIndex, filteredTodos.length);
    const total = filteredTodos.length;

    return Promise.resolve({
      current_page: currentPage,
      data: paginatedTodos,
      from,
      to,
      per_page: perPage,
      total,
      total_pages: totalPages,
    });
  }


  async store(data) {
    const todos = await this._getTodos();
    const lastPosition = todos.length > 0 ? todos[0]?.position : 0
    const newTodo = { id: this._generateUniqueId(), text: data.text, status: 0, position: lastPosition + 1 };
    todos.unshift(newTodo);
    localStorage.setItem('todos', JSON.stringify(todos));
    return Promise.resolve(newTodo);
  }

  async destroy(id) {
    const todos = await this._getTodos();
    const updatedTodos = todos.filter(todo => todo.id !== id);
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(true);
  }

  async update(data) {
    const todos = await this._getTodos();
    const updatedTodo = { id: data.id, text: data.text, status: Number(data.status), position: data.position };
    const updatedTodos = todos.map(todo => (todo.id === data.id ? updatedTodo : todo));
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(data);
  }

  async updatePosition(todo, todos) {
    const newPosition = PositionHandler.newPosition(todo, todos)
    const allTodos = await this._getTodos();
    const updatedTodos = allTodos.map(item => {
      if (item.id === todo.id) item.position = newPosition
      if (item.position >= newPosition && item.id !== todo.id) item.position++
      return item
    })
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(newPosition);
  }

  _generateUniqueId() {
    return Date.now().toString(36) + Math.random().toString(36).substring(2, 12).padStart(12, 0);
  }

  _getTodos() {
    let todos = localStorage.getItem('todos');
    todos = todos ? JSON.parse(todos) : [];
    todos.sort((a, b) => a.position - b.position).reverse()
    return todos
  }
}

export default TodoLocalStorage;
