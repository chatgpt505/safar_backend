# Safar Backend

A comprehensive Laravel backend application with authentication, authorization, and API documentation built with MongoDB and Laravel Sanctum.

## 🚀 Features

### Authentication & Authorization
- **User Registration & Login**: Secure user authentication with email/password
- **Role-Based Access Control**: Three user roles (user, moderator, admin)
- **Token-Based Authentication**: Laravel Sanctum for API authentication
- **Account Management**: Profile updates, password changes, account status
- **Session Management**: Web-based session authentication

### API Features
- **RESTful API**: Complete CRUD operations for user management
- **Swagger Documentation**: Interactive API documentation with Swagger UI
- **Bearer Token Authentication**: Secure API access with JWT-like tokens
- **Input Validation**: Comprehensive request validation
- **Error Handling**: Standardized error responses

### Web Dashboard
- **Modern UI**: Beautiful dashboard built with Tailwind CSS
- **Responsive Design**: Works on desktop and mobile devices
- **Role-Based Views**: Different interfaces for different user roles
- **Real-time Statistics**: Dashboard with user statistics
- **User Management**: Admin panel for managing users

### Database
- **MongoDB Integration**: NoSQL database with Laravel MongoDB package
- **User Management**: Complete user CRUD operations
- **Data Seeding**: Pre-populated with demo users

## 🛠️ Technology Stack

- **Backend Framework**: Laravel 11
- **Database**: MongoDB
- **Authentication**: Laravel Sanctum
- **API Documentation**: Swagger UI (L5-Swagger)
- **Frontend**: Blade templates with Tailwind CSS
- **Icons**: Font Awesome
- **Package Manager**: Composer

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- MongoDB (running locally or remotely)
- Node.js (for frontend assets if needed)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd safar_backend
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure MongoDB connection in `.env`**
   ```env
   DB_CONNECTION=mongodb
   DB_HOST=127.0.0.1
   DB_PORT=27017
   DB_DATABASE=safar_backend
   DB_USERNAME=
   DB_PASSWORD=
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## 👥 Default Users

The system comes with pre-created demo users:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@safar.com | admin123 |
| User | user@safar.com | user123 |
| Moderator | moderator@safar.com | moderator123 |

## 🌐 Access Points

### Web Interface
- **Main Application**: http://localhost:8000
- **Login Page**: http://localhost:8000/login
- **Dashboard**: http://localhost:8000/dashboard (requires authentication)
- **API Documentation**: http://localhost:8000/api/documentation

### API Endpoints
- **Base URL**: http://localhost:8000/api
- **Authentication**: Bearer token required for protected endpoints

## 📚 API Documentation

### Authentication Endpoints

#### Register User
```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "+1234567890",
    "role": "user"
}
```

#### Login User
```http
POST /api/login
Content-Type: application/json

{
    "email": "admin@safar.com",
    "password": "admin123"
}
```

#### Get Profile
```http
GET /api/profile
Authorization: Bearer {token}
```

### Admin Endpoints (Admin Role Required)

#### Get All Users
```http
GET /api/admin/users
Authorization: Bearer {admin_token}
```

#### Create User
```http
POST /api/admin/users
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "name": "New User",
    "email": "newuser@example.com",
    "password": "password123",
    "role": "user",
    "is_active": true
}
```

#### Update User
```http
PUT /api/admin/users/{id}
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "name": "Updated Name",
    "role": "moderator",
    "is_active": false
}
```

#### Delete User
```http
DELETE /api/admin/users/{id}
Authorization: Bearer {admin_token}
```

## 🔐 Security Features

- **Password Hashing**: Bcrypt password hashing
- **Token Authentication**: Secure API token management
- **Role-Based Authorization**: Middleware-based access control
- **Input Validation**: Comprehensive request validation
- **CSRF Protection**: Built-in CSRF protection for web forms
- **Session Security**: Secure session management

## 🎨 Web Dashboard Features

### User Dashboard
- Welcome message with user information
- Statistics cards showing user counts
- Quick action buttons for common tasks
- Role-based navigation

### Admin Dashboard
- Advanced statistics and analytics
- Recent user activity
- User management interface
- System overview

### Profile Management
- View and edit personal information
- Change password functionality
- Account status display
- Member since information

## 📁 Project Structure

```
safar_backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php      # API authentication
│   │   │   ├── AdminController.php     # Admin API endpoints
│   │   │   ├── DashboardController.php # Web dashboard
│   │   │   └── WebAuthController.php   # Web authentication
│   │   └── Middleware/
│   │       └── CheckRole.php           # Role-based authorization
│   └── Models/
│       └── User.php                    # User model with MongoDB
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Main layout
│       ├── auth/
│       │   ├── login.blade.php         # Login form
│       │   ├── register.blade.php      # Registration form
│       │   └── change-password.blade.php
│       └── dashboard/
│           ├── index.blade.php         # Main dashboard
│           ├── profile.blade.php       # User profile
│           └── settings.blade.php      # Settings page
├── routes/
│   ├── api.php                         # API routes
│   └── web.php                         # Web routes
├── database/
│   └── seeders/
│       └── AdminUserSeeder.php         # Demo user seeder
└── config/
    ├── database.php                    # MongoDB configuration
    └── l5-swagger.php                  # Swagger configuration
```

## 🔧 Configuration

### MongoDB Configuration
The application is configured to use MongoDB as the primary database. Make sure MongoDB is running and accessible.

### Swagger Configuration
API documentation is automatically generated from controller annotations. To regenerate documentation:
```bash
php artisan l5-swagger:generate
```

### Environment Variables
Key environment variables to configure:
- `APP_KEY`: Laravel application key
- `DB_HOST`: MongoDB host
- `DB_PORT`: MongoDB port
- `DB_DATABASE`: Database name
- `DB_USERNAME`: MongoDB username (if authentication enabled)
- `DB_PASSWORD`: MongoDB password (if authentication enabled)

## 🧪 Testing

### API Testing
You can test the API endpoints using:
- **Swagger UI**: http://localhost:8000/api/documentation
- **Postman**: Import the API endpoints
- **cURL**: Use the provided examples

### Web Testing
- Access the web interface at http://localhost:8000
- Use the demo credentials to test different user roles
- Test the dashboard functionality

## 📝 API Response Format

All API responses follow a standardized format:

### Success Response
```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        // Response data
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error description",
    "errors": {
        // Validation errors (if applicable)
    }
}
```

## 🔄 Database Migrations

The application includes migrations for:
- Personal access tokens (Laravel Sanctum)
- User management
- Role-based access control

Run migrations with:
```bash
php artisan migrate
```

## 🌱 Database Seeding

Seed the database with demo data:
```bash
php artisan db:seed
```

This creates:
- Admin user
- Regular user
- Moderator user

## 🚀 Deployment

### Production Considerations
1. **Environment**: Set `APP_ENV=production`
2. **Debug**: Set `APP_DEBUG=false`
3. **Database**: Configure production MongoDB connection
4. **Security**: Use strong passwords and secure tokens
5. **SSL**: Enable HTTPS for production

### Server Requirements
- PHP 8.2+
- MongoDB 4.4+
- Web server (Apache/Nginx)
- Composer

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License.

## 🆘 Support

For support and questions:
- Check the API documentation at `/api/documentation`
- Review the code comments and annotations
- Create an issue in the repository

## 🔄 Updates

To update the application:
1. Pull the latest changes
2. Run `composer install`
3. Run `php artisan migrate` (if new migrations exist)
4. Clear caches: `php artisan config:clear && php artisan cache:clear`

---

**Safar Backend** - A modern, secure, and scalable Laravel application with MongoDB and comprehensive API documentation.
