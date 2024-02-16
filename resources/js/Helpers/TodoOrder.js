class TodoOrder {
  static newOrder(todo, todos) {
    const index = todos.findIndex((item) => item.id === todo['id'])
    const previousItem = todos[index - 1];
    const oneBeforeLast = todos[1];
    let newOrder = (previousItem) ? previousItem.order : oneBeforeLast.order + 1
    newOrder = todo.order === newOrder ? newOrder - 1 : newOrder
    return newOrder
  }
}

export default TodoOrder
