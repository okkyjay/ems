# Employee Management System

### EMS Components

- Create Admin
- Admin Login
- Employee Registration
- Delete Employee Information
- Update Employee Information
- List Employee in a paginated view
- View individual Employee details including Salary
- Assign leave to Employee
- Employee Login
- Chat
- Notification
- Todo


Write	a	process	that	imports	the	contents	of	a	JSON-file	cleanly	and	consistently	to	a	database.Preferably	this	is	done	as	a	background	job	in	Laravel.	Docker	use is encouraged(but	not	required)

### How to run 
- At the root level of the project files, run `composer install` to install the project dependencies
- At the root level of the project files, run `cp .env.example .env` to create env file
- At the root level of the project files, run `php artisan key:generate` to generate application key
- At the root level of the project files, run `php artisan migrate` to migrate the database tables
- At the root level of the project files, run `php artisan serve` to serve the project
- At the root level of the project files, run `php artisan queue:work` 
- Application will run on http://localhost:8080 
