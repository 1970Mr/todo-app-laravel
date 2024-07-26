## Todo App with Laravel, Vue.js, and Tailwind CSS

This project is a Todo application built using Laravel, Vue.js, and Tailwind CSS.

### Screenshots

![Todo App Screenshot](/docs/screenshots/todo-app-screenshot3.png)

![Todo App Screenshot](/docs/screenshots/todo-app-screenshot6.png)

![Todo App Screenshot](/docs/screenshots/todo-app-screenshot7.png)

### Features

- **Create Todo:** Users can add new todo items by typing in the input field and pressing enter.
- **Update Todo:** Users can edit existing todo items by clicking on them and modifying the text.
- **Delete Todo:** Users can remove todo items by clicking on the delete button next to each item.
- **Mark Todo as Completed:** Users can mark todo items as completed by clicking on the checkbox next to each item.
- **Drag and Drop:** Todo items can be reordered by dragging and dropping them to a new position. Changes in order are saved automatically.
- **Filter Todos:** Users can filter todo items based on their completion status (All, Active, Completed).
- **Search Todos:** Users can search for specific todo items by typing in the search input field.
- **Register:** Users can register for an account to access the todo application.
- **Login:** Registered users can log in to their accounts to manage their todo lists.
- **Forget Password:** Users can request a password reset if they forget their password.
- **Pagination:** Todo items are paginated to improve user experience and performance.

### Technologies Used

- **Laravel:** A PHP web application framework for building efficient and secure web applications.
- **Vue.js:** A progressive JavaScript framework for building user interfaces.
- **Tailwind CSS:** A utility-first CSS framework for building custom designs quickly and easily.
- **MySQL:** A relational database for storing todo items.

### Getting Started

To run this project locally, follow these steps:

1. Clone the repository:

   ```bash
   git clone https://github.com/1970Mr/todo-app-laravel
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

4. Copy the `.env.example` file and create a new `.env` file:

   ```bash
   cp .env.example .env
   ```

5. Generate an application key:

   ```bash
   php artisan key:generate
   ```

6. Configure the database connection in the `.env` file:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

7. Run database migrations:

   ```bash
   php artisan migrate
   ```

8. Compile assets:

   ```bash
   npm run dev
   ```

9. Start the development server:

   ```bash
   php artisan serve
   ```

10. Open your browser and visit `http://localhost:8000` to view the application.

### Authentication and Local Storage

- This application utilizes both database storage and local storage based on the user's authentication status.
- When a user is logged in, todo items are stored in the database to ensure data persistence and security.
- If a user is not logged in, todo items are stored in the local storage of the browser, providing a seamless experience without the need for authentication.

### MongoDB Version

If you are interested in the MongoDB version of this project, you can check out the MongoDB branch [here](https://github.com/1970Mr/todo-app-laravel/tree/mongodb).

### Contributing

Contributions are welcome! If you'd like to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/my-feature`).
3. Make your changes and commit them (`git commit -am 'Add new feature'`).
4. Push your changes to your forked repository (`git push origin feature/my-feature`).
5. Create a new Pull Request.

### License

This project is licensed under the [MIT License](LICENSE). Feel free to use and modify the code as per your requirements.
