# Blog
This is Blog APi using Laravel and MySQL, this API simplifies blog management, featuring user authentication, post management, and a following system.
# Blog API

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Database](#database)
- [Contributing](#contributing)

## Features

### Post Management

- **Create Posts:** Easily add new blog posts with details like title, category and body.
- **Edit Posts:** Modify post content and details as needed.
- **Delete Posts:** Remove blog posts.
- **List All Posts:** View a complete list of published blog posts.

### User Management

- **User Authentication:** Secure access with JWT (JSON Web Tokens) authentication.
- **User Roles:** Implement user roles, including admin and user roles.

### Comments

- **Add Comments:** Allow users to comment on blog posts.
- **Edit Comments:** Modify comments.
- **Delete Comments:** Remove comments.
- **List Comments:** View comments associated with blog posts.

#### Replies

- **Add Replies:** Enable users to reply to comments.
- **Edit Replies:** Modify reply content.
- **Delete Replies:** Remove replies.
- **List Replies:** View replies associated with comments.
 
- ### Reply Replies

- **Add Reply Replies:** Allow users to reply to replies.
- **Edit Reply Replies:** Modify reply reply content.
- **Delete Reply Replies:** Remove reply replies.
- **List Reply Replies:** View reply replies associated with replies.

### Categories (Admin)

- **Create Categories:** Admins can create new blog categories.
- **Update Categories:** Admins can modify category details.
- **Delete Categories:** Admins can remove categories when needed.
- **List Categories:** Admins can view a list of existing categories.

### Likes

- **Like Posts:** Allow users to like and unlike posts.
- **Like Comments:** Allow users to like and unlike comments.
- **Like Replies:** Allow users to like and unlike replies.
- **Like Reply Replies:** Allow users to like and unlike reply replies.

#### Following System

- **Follow Authors:** Implement a following system, allowing users to follow and unfollow their favorite users.
- **Block Feature:** Allow users to block and unblock others.
- **Block Feature (Admin):** Allow admins to block and unblock users.

## Installation

To get started with the Blog API, follow these steps:
1. **Clone the Repository:**
git clone https://github.com/your-username/blog-api.git
2. **Navigate to the Project Directory:**
cd blog-api
3. **Install Dependencies:**
composer install
4. **Create a `.env` File:**
Create a copy of the `.env.example` file and name it `.env`. Update the database connection settings and other environment variables as needed.
5. **Generate Application Key:**
php artisan key:generate
6. **Run Database Migrations:**
php artisan migrate 
7. **Start the Development Server:**
php artisan serve
8. **Access the API:**
The API should now be running at `http://localhost:8000`. You can explore the API endpoints and start using the Blog API.
9. **Documentation:**
For detailed API documentation and usage instructions, please refer to the provided [documentation](https://documenter.getpostman.com/view/29356608/2s9YJZ5QqM).

## Database

The Blog API uses MySQL as its underlying database system. You can configure the database connection by updating the `.env` file with your database credentials.

Click the image below to view the database schema:

<a href="https://drive.google.com/file/d/1qdlT6pL1LUwXXo56P5QBCttgqJlXvmEJ/view" target="_blank">
    Database Schema
</a>

## Contributing

Contributions to the Blog API are welcome and encouraged. To contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix: `git checkout -b feature-name`.
3. Make your changes and commit them: `git commit -m 'Add some feature'`.
4. Push to the branch: `git push origin feature-name`.
5. Create a pull request.

Please ensure that your code follows the project's coding standards and practices. Also, make sure to update any relevant documentation and tests.

