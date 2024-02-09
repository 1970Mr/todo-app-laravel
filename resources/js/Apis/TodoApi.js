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
}

export default TodoApi
