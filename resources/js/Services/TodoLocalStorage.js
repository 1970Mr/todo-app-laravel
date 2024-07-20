import TodoOrder from "@/Helpers/TodoOrder.js";

class TodoLocalStorage {
  async get(page = 1, perPage = 5, statusFilter = null, search = null) {
    const todos = this._getTodos();

    // Apply filters
    let filteredTodos = todos;
    if (statusFilter === 'active') {
      filteredTodos = filteredTodos.filter(todo => !todo.completed);
    } else if (search === 'completed') {
      filteredTodos = filteredTodos.filter(todo => todo.completed);
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
    const lastOrder = todos.length > 0 ? todos[0]?.order : 0
    const newTodo = { id: this._generateUniqueId(), text: data.text, completed: data.completed, order: lastOrder + 1 };
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
    const updatedTodo = { id: data.id, text: data.text, completed: data.completed, order: data.order };
    const updatedTodos = todos.map(todo => (todo.id === data.id ? updatedTodo : todo));
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(data);
  }

  async changeOrder(todo, todos) {
    const newOrder = TodoOrder.newOrder(todo, todos)
    const allTodos = await this._getTodos();
    const updatedTodos = allTodos.map(item => {
      if (item.id === todo.id) item.order = newOrder
      if (item.order >= newOrder && item.id !== todo.id) item.order++
      return item
    })
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(newOrder);
  }

  _generateUniqueId() {
    return Date.now().toString(36) + Math.random().toString(36).substring(2, 12).padStart(12, 0);
  }

  _getTodos() {
    let todos = localStorage.getItem('todos');
    todos = todos ? JSON.parse(todos) : [];
    todos.sort((a, b) => a.order - b.order).reverse()
    return todos
  }
}

export default TodoLocalStorage;
