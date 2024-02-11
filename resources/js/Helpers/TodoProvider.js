import TodoApi from '@/Apis/TodoApi';
import TodoLocalStorage from '@/Services/TodoLocalStorage';

class TodoProvider {
  static createTodoProvider(loggedIn) {
    return loggedIn ? new TodoApi() : new TodoLocalStorage();
  }
}

export default TodoProvider
