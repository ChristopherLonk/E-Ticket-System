# Table of contents
- [Requirement](#requirement)
- [Installation](#installation)
  - [Installation the Project](#install-the-project)
  - [MySQL / MariaDB](#mysql--mariadb)
    - [First way](#first-way)
    - [Second way](#second-way)
      - [Editor](#editor)
      - [Database](#database)
  - [Terminal](#terminal)
    - [Navigate to Project](#navigate-to-project)
    - [For Developer](#for-developer)
    - [For Live Server](#for-live-server)
    - [Check the Project with PhpUnit](#check-the-project-with-phpunit)
- [Guide](#guide)
    - [No User Authenticate](#no-user-authenticate)
      - [Login View](#login-view)
      - [Behind the Authenticate](#behind-the-authenticate)
    - [Authenticate as Admin](#authenticate-as-admin)
      - [Navigation bar from Admin](#navigation-bar-from-admin)
      - [User View](#user-view)
      - [New User](#new-user)
      - [Edit User](#edit-user)
      - [Delete User](#delete-user)
    - [Authenticate as Team leader](#authenticate-as-team-leader)
      - [Navigation bar from Team leader](#navigation-bar-from-team-leader)
      - [Create View](#create-view)
      - [New Project](#new-project)
      - [Edit Project](#edit-project)
      - [Delete Project](#delete-project)
      - [New Sprint](#new-sprint)
      - [Edit Sprint](#edit-sprint)
      - [Delete Sprint](#delete-sprint)
      - [New Ticket](#new-ticket)
      - [Edit Ticket](#edit-ticket)
      - [Delete Ticket](#delete-ticket)
      - [Dashboard View](#dashboard-view)
      - [Kanban View](#kanban-view)
      - [Details View](#details-view)
      - [Scrum View](#scrum-view)
      - [Dashboard Scrum Details View](#dashboard-scrum-details-view)
    - [Authenticate as User](#authenticate-as-user)
      - [Dashboard](#dashboard)




# Requirement
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/de/) / [MariaDB](https://mariadb.org/)
- [Apache](https://httpd.apache.org/) / [Nginx](https://www.nginx.com/)
- [Xdebug](https://xdebug.org/)

# Installation
## Install the Project        
- Copied the Project in your Web root Directory.
- Open the Terminal and Navigate to the Project.
  - `composer install`
  - `cp .env.example .env`


## ENV
- Open the File .env with a Editor and look at the entries.
- `DB_DATABASE= [Your Database]`
- `DB_USERNAME= [Your User]`
- `DB_PASSWORD= [Your Password]`

## Terminal
### Navigate to Project
  - sh install.sh
This shell script create a database, user and privileges from the .env file.
After the creation run migrate:fresh db:seed and the unit test.

### For Developer
- `php artisan serve`
- Open your Browser and go to [localhost:8000](http://localhost:8000)

### For Live Server
- Follow the [Instruction](https://laravel.com/docs/5.6#web-server-configuration) on Server Configuration for Apache or Nginx


## Check the Project with PhpUnit
- `vendor/bin/phpunit`
- you only see points this is correct and you can start.

![phpunit](public/pic/phpunit_terminal.png "phpunit")


# Guide
This user Guide is for all users who want to get a new Ticket System for Scrum and Kanban.

## No User Authenticate
In the Pictures is a Navigation bar. You can navigate to Home and Login Site.

![no auth user](public/pic/nav_no_auth.png "no auth user")

### Login View
In the Form give it email and Password input fields submit the Form to check the authenticated.

![login](public/pic/login.png "login")

If your email and a Password correct then can you work with the Ticket System.

### Behind the Authenticate
The Logout button is in the Drop-down menu from your User name.

![logout](public/pic/nav_logout_button.png "logout")


## Authenticate as Admin
### Navigation bar from Admin
In the Pictures is a Navigation bar. You can navigate to User or you have a drop down menu with the Logout button.

![admin navigation](public/pic/nav_admin.png "admin navigation")

### User View
In the User page see you all Users with their Roles. You have three Buttons to New, Edit or Delete Users.

![user view](public/pic/admin_user.png "user view")

### New User
By new User give it four Input Fields and one Select field. In the select field give you the Role (User, Team leader or Admin) from the new User.

![new user](public/pic/admin_new_user.png "new user")

### Edit User
The form edit user is for update a User.

![edit user](public/pic/admin_edit_user.png "edit user")

### Delete User
If you click on delete button is open a Modal „Are you Sure” you can click on yes to delete a user or close and a Modal is close.

![delete user](public/pic/admin_delete_user.png "delete user")

## Authenticate as Team leader
### Navigation bar from Team leader
In the Pictures is a Navigation bar. You can navigate to Dashboard, New or you have a drop down menu with the Logout button.

![teamleader navigation](public/pic/nav_teamleader.png "teamleader navigation")

### Create View
In the Page see you the new navigation bar with three buttons Project, Sprint and Ticket. You can show all Projects, Sprint and Tickets under this right tab.

![teamleader project](public/pic/teamleader_project.png "teamleader project")

![teamleader sprint](public/pic/teamleader_sprint.png "teamleader sprint")

![teamleader ticket](public/pic/teamleader_ticket.png "teamleader ticket")

### New Project
By new Project can you create a new Project with the name and methods (Scrum or Kanban).

![teamleader create project](public/pic/teamleader_create_project.png "teamleader create project")

### Edit Project
In the Page Edit Project can you Update the Project.

![teamleader edit project](public/pic/teamleader_edit_project.png "teamleader edit project")

### Delete Project
If you click on delete button is open a Modal „Are you Sure” you can click on yes to delete a Project or close and a Modal is close.

![teamleader delete project](public/pic/teamleader_delete_project.png "teamleader delete project")

Do not worry it will not be deleted there will be a flags in the database law.

### New Sprint
By the Page New Sprint can you create a new Sprint with a name and a time span and over a Select field can you select a Project.

![teamleader create sprint](public/pic/teamleader_create_sprint.png "teamleader create sprint")

### Edit Sprint
In the View can you update the sprint.

![teamleader edit sprint](public/pic/teamleader_edit_sprint.png "teamleader edit sprint")

### Delete Sprint
If you click on delete button is open a Modal „Are you Sure” you can click on yes to delete a Sprint or close and a Modal is close.

![teamleader delete sprint](public/pic/teamleader_delete_sprint.png "teamleader delete sprint")

Do not worry it will not be deleted there will be a flags in the database law.

### New Ticket
You can create a Ticket on the Page with name and description over a Select field can you select the Project.

![teamleader create ticket](public/pic/teamleader_create_ticket.png "teamleader create ticket")

### Edit Ticket
By The Page Edit Ticket have you more Option you can Status, Priority and Story Point select. Is the Project Scrum can you select the Sprint.

![teamleader edit ticket](public/pic/teamleader_edit_ticket.png "teamleader edit ticket")

### Delete Ticket
If you click on delete button is open a Modal „Are you Sure” you can click on yes to delete a Ticket or close and a Modal is close.

![teamleader delete ticket](public/pic/teamleader_delete_ticket.png "teamleader delete ticket")

Do not worry it will not be deleted there will be a flags in the database law.

### Dashboard View
On this Picture can you select a project if the Project Kanban can you see the Story’s from the Project or it is Scrum then select a Sprint and you see the Tickets.

![teamleader dashboard project](public/pic/teamleader_dashboard_project.png "teamleader dashboard project")
![teamleader dashboard sprint](public/pic/teamleader_dashboard_sprint.png "teamleader dashboard sprint")

### Kanban View
This Project is Kanban and you can see the Tickets from this Project.

![teamleader dashboard kanban](public/pic/teamleader_dashboard_kanban.png "teamleader dashboard kanban")

### Details View
On this view can you see the Details from the Ticket.

![teamleader dashboard kanban details](public/pic/teamleader_dashboard_kanban_details.png "teamleader dashboard kanban details")

### Scrum View
On this View is a Project and a Sprint Selected you can see the Tickets.

![teamleader dashboard scrum](public/pic/teamleader_dashboard_scrum.png "teamleader dashboard scrum")

### Dashboard Scrum Details View
This view is show all Ticket and Details from a Sprint.

![teamleader dashboard scrum details](public/pic/teamleader_dashboard_scrum_details.png "teamleader dashboard scrum details")

## Authenticate as User
### Dashboard
The View is like a Team leader Dashboard you have a new select field with status.

![user dashboard status](public/pic/user_dashboard_status.png "user dashboard status")
