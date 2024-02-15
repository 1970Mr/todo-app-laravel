class TodoLocalStorage {
  async get(filteredData, page = 1, perPage = 5) {
    const todos = this._getTodos();

    // Apply filters
    let filteredTodos = todos;
    if (filteredData.filter === 'active') {
      filteredTodos = filteredTodos.filter(todo => !todo.completed);
    } else if (filteredData.filter === 'completed') {
      filteredTodos = filteredTodos.filter(todo => todo.completed);
    }

    // Apply search
    if (filteredData.search) {
      const searchTerm = filteredData.search.toLowerCase();
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
    const newTodo = { id: this._generateUniqueId(), text: data.text, completed: data.completed };
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
    const updatedTodo = { id: data.id, text: data.text, completed: data.completed };
    const updatedTodos = todos.map(todo => (todo.id === data.id ? updatedTodo : todo));
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(data);
  }

  _generateUniqueId() {
    return Date.now().toString(36) + Math.random().toString(36).substring(2, 12).padStart(12, 0);
  }

  _getTodos() {
    let todos = localStorage.getItem('todos');
    return todos ? JSON.parse(todos) : [];
  }
}

export default TodoLocalStorage;
