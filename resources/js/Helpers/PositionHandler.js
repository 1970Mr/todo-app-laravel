class PositionHandler {
  static newPosition(todo, todos) {
    const index = todos.findIndex((item) => item.id === todo['id'])
    const previousItem = todos[index - 1];
    const secondItem = todos[1];
    const lastItem = todos[todos.length - 1];
    let newPosition = (previousItem) ? previousItem.position : secondItem.position + 1
    // Check if it is the last item
    newPosition = (newPosition === lastItem.position) ? newPosition - 1 : newPosition
    return newPosition
  }
}

export default PositionHandler
