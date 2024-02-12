## Todo App with Laravel, Vue.js, and Tailwind CSS

This project is a Todo application built using Laravel, Vue.js, and Tailwind CSS.

### Screenshot

![Todo App Screenshot](/docs/screenshots/todo-app-screenshot3.png)

### Features

- **Create Todo:** Users can add new todo items by typing in the input field and pressing enter.
- **Update Todo:** Users can edit existing todo items by clicking on them and modifying the text.
- **Delete Todo:** Users can remove todo items by clicking on the delete button next to each item.
- **Mark Todo as Completed:** Users can mark todo items as completed by clicking on the checkbox next to each item.
- **Filter Todos:** Users can filter todo items based on their completion status (All, Active, Completed).
- **Search Todos:** Users can search for specific todo items by typing in the search input field.
- **Register:** Users can register for an account to access the todo application.
- **Login:** Registered users can log in to their accounts to manage their todo lists.
- **Forget Password:** Users can request a password reset if they forget their password.

### Technologies Used

- **Laravel:** A PHP web application framework for building efficient and secure web applications.
- **Vue.js:** A progressive JavaScript framework for building user interfaces.
- **Tailwind CSS:** A utility-first CSS framework for building custom designs quickly and easily.

### Getting Started

To run this project locally, follow these steps:

1. Clone the repository:

   ```bash
   git clone https://github.com/github-1970/todo-app-laravel
   ```

2. Navigate to the project directory:

   ```bash
   cd todo-app-laravel
   ```

3. Install dependencies:

   ```bash
   composer install
   npm install
   ```

4. Compile assets:

   ```bash
   npm run dev
   ```

5. Start the development server:

   ```bash
   php artisan serve
   ```

6. Open your browser and visit `http://localhost:8000` to view the application.

### Authentication and Local Storage

- This application utilizes both database storage and local storage based on the user's authentication status.
- When a user is logged in, todo items are stored in the database to ensure data persistence and security.
- If a user is not logged in, todo items are stored in the local storage of the browser, providing a seamless experience without the need for authentication.

### Contributing

Contributions are welcome! If you'd like to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/my-feature`).
3. Make your changes and commit them (`git commit -am 'Add new feature'`).
4. Push your changes to your forked repository (`git push origin feature/my-feature`).
5. Create a new Pull Request.

### License

This project is licensed under the [MIT License](LICENSE). Feel free to use and modify the code as per your requirements.
