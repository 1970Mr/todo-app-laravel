import route from 'ziggy-js'

class TodoApi
{
  static store(data)
  {
    return axios.post(route('todo.store'), data)
      .then(response => response)
      .catch(error => {
        console.error('Error adding todo:');
        return false
      });
  }

  static destroy(id)
  {
    return axios.delete( route('todo.destroy', {todo: id}) )
      .then(response => response)
      .catch(error => {
        console.error('Error deleting todo:');
        return false
      });
  }
}

export default TodoApi
