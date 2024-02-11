class TodoLocalStorage {
  static get() {
    let todos = localStorage.getItem('todos');
    todos = todos ? JSON.parse(todos) : []
    return Promise.resolve(todos);
  }

  static async store(data) {
    const todos = await this.get();
    const newTodo = { id: this._generateUniqueId(), text: data.text, completed: data.completed };
    todos.unshift(newTodo);
    localStorage.setItem('todos', JSON.stringify(todos));
    return Promise.resolve(newTodo);
  }

  static async destroy(id) {
    const todos = await this.get();
    const updatedTodos = todos.filter(todo => todo.id !== id);
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(true);
  }

  static async update(data) {
    const todos = await this.get();
    const updatedTodo = { id: data.id, text: data.text, completed: data.completed };
    const updatedTodos = todos.map(todo => (todo.id === data.id ? updatedTodo : todo));
    localStorage.setItem('todos', JSON.stringify(updatedTodos));
    return Promise.resolve(data);
  }

  static _generateUniqueId() {
    return Date.now().toString(36) + Math.random().toString(36).substring(2, 12).padStart(12, 0);
  }
}

export default TodoLocalStorage;
