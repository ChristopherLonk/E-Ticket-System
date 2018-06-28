DATABASE
1. Start your MYSQL Service
FIRST WAY
    1. Create a Database ticket.
            CREATE DATABASE ticket;
    2. create a user ticket with the password 2QJtitPkuRY3fz7s
SECOND WAY
    1. look at the file .env and edit the
    DB_DATABASE= <Your Database>
    DB_USERNAME= <Your User>
    DB_PASSWORD= <Your Password>

PROJECT RUNNABLE
1. Download a Web Project and unzip in the web root
2. Open the cmd and navigate to the Project
3. <cmd> composer update <cmd>
4. <cmd> php artisan migrate:fresh <cmd>    // MYSQL DUMP
4. <cmd> php artisan db:seed <cmd>          // Insert a Admin Account
5. <cmd> php artisan serve <cmd>
6. Open your browser and go to http://localhost:8000

Login
email: admin@admin.com
password: adminadmin

Create a new account and give him all admin rules
login with a new Account and delete the Admin Account (Backdoor)
