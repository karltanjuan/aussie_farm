Kangaroo Farm Project

This is a sample Laravel project for managing a Kangaroo farm as a pet. It allows you to add, edit, and delete Kangaroos from the farm.

Installation

To run this project locally, follow these steps:

1. Open a terminal and run composer update at the root level of the project.
2. Create a database named aussie_farm and configure the database credentials in the .env file.
3. Run php artisan migrate to create the necessary database tables, or import the aussie_farm.sql file located at the root of the project.
4. Run php artisan optimize:clear to clear the application cache.
5. Run php artisan serve to start the local development server.
6. Open http://localhost:8000 in your web browser to access the application.

Usage

Once the application is installed and running, you can use the following features:

* View a list of all Kangaroos on the farm.
* Add a new Kangaroo to the farm.
* Edit an existing Kangaroo's details.
* Delete a Kangaroo from the farm.

Credits

This project was created by Karl Angelo Tanjuan. It uses the following technologies:

Laravel PHP Framework
Bootstrap CSS Framework
jQuery JavaScript Library
Axios JavaScript Library
DevExpress JavaScript Library