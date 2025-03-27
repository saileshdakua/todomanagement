# todomanagement
Laravel 12 Task Management App
🔧 Features
- Laravel 12 + Bootstrap UI
- Custom authentication (no Breeze, Jetstream, or UI scaffolding)
- Token-based authentication via middleware
- Login using email or username
- Password validation: must include uppercase, lowercase, special character, number, and min 6 characters
- SweetAlert for notifications
- Error messages shown below respective fields
- Dashboard with:
- Add Task button
- Task list (title, description, status, start & due dates)
- Task CRUD (create, edit, delete)
- Status badge: Pending (yellow), In Progress (blue), Completed (green)
- View task with "Enter Timesheet" button
- Blade templates
- Protected routes using custom `TokenAuthMiddleware`
⚙️ Installation
1. Clone the Repository
git clone https://github.com/your-username/your-repo.git
cd your-repo

2. Install Dependencies
composer install
3. Setup Environment File
cp .env.example .env
php artisan key:generate

4. Configure `.env`
Update database credentials

5. Run Migrations
php artisan migrate

6. Serve the App
php artisan serve
🧪 Authentication Rules
- Username must be unique
- Password must include:
- At least one uppercase
- At least one lowercase
- At least one special character
- At least one number
- Minimum 6 characters
- Login via username or email
📁 Folder Structure Overview
- app/Http/Controllers/AuthController.php – Handles register, login, logout, dashboard
- app/Http/Controllers/TaskController.php – Task CRUD and view
- app/Http/Middleware/TokenAuthMiddleware.php – Checks user token for route protection
- resources/views/auth/ – Login and Register forms
- resources/views/dashboard.blade.php – Main dashboard with task list
- resources/views/tasks/ – Create, Edit, View blades
- 
📌 Routes Overview (web.php)
| Route              | Method | Description              |
|-------------------|--------|--------------------------|
| /register         | GET/POST | User Registration       |
| /login            | GET/POST | User Login              |
| /dashboard        | GET    | User Dashboard (tasks)  |
| /tasks            | GET    | Task List               |
| /tasks/create     | GET    | Task Create Form        |
| /tasks            | POST   | Store Task              |
| /tasks/{id}/edit  | GET    | Edit Task               |
| /tasks/{id}       | PUT    | Update Task             |
| /tasks/{id}       | DELETE | Delete Task             |
| /tasks/{id}/view  | GET    | View Task + Timesheet   |
| /logout           | POST   | Logout                  |

📝 Timesheet Feature
Each task view includes a button "Enter Timesheet", which can be expanded later to track time logs per task.

🧑‍💻 Author
- Name: Sailesh Dakua
- GitHub: [https://github.com/saileshdakua](https://github.com/saileshdakua/todomanagement)
- 
📄 License
This project is open-source and free to use under the MIT license.
