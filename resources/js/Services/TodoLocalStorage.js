class TodoLocalStorage {
  static getTodos() {
    const todos = localStorage.getItem('todos');
    const data = todos ? JSON.parse(todos) : [];
    return { data, status: 200}
  }

  static store(data) {
    const todos = this.getTodos();
    const newTodo = { ...data, id: this._generateUniqueId() };
    todos.unshift(newTodo);
    localStorage.setItem('todos', JSON.stringify(todos));
    return Promise.resolve({ data: newTodo, status: 201 });
  }

  static destroy(id) {
    const todos = this.getTodos();
    const updatedTodos = todos.filter(todo => todo.id !== id);
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve({ status: 204 });
  }

  static update(data) {
    const todos = this.getTodos();
    const updatedTodos = todos.map(todo => (todo.id === data.id ? data : todo));
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve({ data, status: 200 });
  }

  _generateUniqueId() {
    return Date.now().toString(36) + Math.random().toString(36).substring(2, 12).padStart(12, 0);
  }
}

export default TodoLocalStorage;
