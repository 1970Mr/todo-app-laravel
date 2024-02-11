class TodoLocalStorage {
  static get() {
    const todos = localStorage.getItem('todos');
    return Promise.resolve(JSON.parse(todos));
  }

  static store(data) {
    const todos = this.get();
    const newTodo = { ...data, id: this._generateUniqueId() };
    todos.unshift(newTodo);
    localStorage.setItem('todos', JSON.stringify(todos));
    return Promise.resolve(newTodo);
  }

  static destroy(id) {
    const todos = this.get();
    const updatedTodos = todos.filter(todo => todo.id !== id);
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(true);
  }

  static update(data) {
    const todos = this.get();
    const updatedTodos = todos.map(todo => (todo.id === data.id ? data : todo));
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(data);
  }

  _generateUniqueId() {
    return Date.now().toString(36) + Math.random().toString(36).substring(2, 12).padStart(12, 0);
  }
}

export default TodoLocalStorage;
