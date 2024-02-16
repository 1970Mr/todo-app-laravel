class TodoOrder {
  static newOrder(todo, todos) {
    const index = todos.findIndex((item) => item.id === todo['id'])
    const previousItem = todos[index - 1];
    const secondItem = todos[1];
    const lastItem = todos[todos.length - 1];
    let newOrder = (previousItem) ? previousItem.order : secondItem.order + 1
    newOrder = (newOrder === lastItem.order) ? newOrder - 1 : newOrder
    return newOrder
  }
}

export default TodoOrder
