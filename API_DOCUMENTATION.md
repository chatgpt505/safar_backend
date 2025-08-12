# Safar Backend API Documentation

## Overview
This API provides authentication and authorization functionality for the Safar Backend application. It uses Laravel Sanctum for API token authentication and MongoDB as the database.

## Base URL
```
http://localhost:8000/api
```

## Authentication
The API uses Bearer token authentication. Include the token in the Authorization header:
```
Authorization: Bearer {your_token}
```

## Response Format
All API responses follow this format:
```json
{
    "success": true/false,
    "message": "Response message",
    "data": {
        // Response data
    }
}
```

## Public Endpoints

### 1. Register User
**POST** `/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "+1234567890",
    "role": "user"
}
```

**Response:**
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": "user_id",
            "name": "John Doe",
            "email": "john@example.com",
            "role": "user",
            "phone": "+1234567890",
            "is_active": true
        },
        "token": "1|token_string",
        "token_type": "Bearer"
    }
}
```

### 2. Login User
**POST** `/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": "user_id",
            "name": "John Doe",
            "email": "john@example.com",
            "role": "user"
        },
        "token": "1|token_string",
        "token_type": "Bearer"
    }
}
```

## Protected Endpoints (Authentication Required)

### 3. Logout User
**POST** `/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Successfully logged out"
}
```

### 4. Get User Profile
**GET** `/profile`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": "user_id",
            "name": "John Doe",
            "email": "john@example.com",
            "role": "user",
            "phone": "+1234567890",
            "is_active": true
        }
    }
}
```

### 5. Update User Profile
**PUT** `/profile`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "name": "John Updated",
    "phone": "+0987654321"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Profile updated successfully",
    "data": {
        "user": {
            "id": "user_id",
            "name": "John Updated",
            "email": "john@example.com",
            "phone": "+0987654321"
        }
    }
}
```

### 6. Change Password
**POST** `/change-password`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "current_password": "oldpassword",
    "new_password": "newpassword123",
    "new_password_confirmation": "newpassword123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Password changed successfully"
}
```

### 7. Refresh Token
**POST** `/refresh-token`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Token refreshed successfully",
    "data": {
        "token": "2|new_token_string",
        "token_type": "Bearer"
    }
}
```

## Admin Endpoints (Admin Role Required)

### 8. Get All Users
**GET** `/admin/users`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "users": {
            "current_page": 1,
            "data": [
                {
                    "id": "user_id",
                    "name": "John Doe",
                    "email": "john@example.com",
                    "role": "user",
                    "is_active": true
                }
            ],
            "per_page": 15,
            "total": 1
        }
    }
}
```

### 9. Get User by ID
**GET** `/admin/users/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": "user_id",
            "name": "John Doe",
            "email": "john@example.com",
            "role": "user",
            "is_active": true
        }
    }
}
```

### 10. Create User
**POST** `/admin/users`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Request Body:**
```json
{
    "name": "New User",
    "email": "newuser@example.com",
    "password": "password123",
    "phone": "+1234567890",
    "role": "user",
    "is_active": true
}
```

**Response:**
```json
{
    "success": true,
    "message": "User created successfully",
    "data": {
        "user": {
            "id": "new_user_id",
            "name": "New User",
            "email": "newuser@example.com",
            "role": "user",
            "is_active": true
        }
    }
}
```

### 11. Update User
**PUT** `/admin/users/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Request Body:**
```json
{
    "name": "Updated Name",
    "role": "moderator",
    "is_active": false
}
```

**Response:**
```json
{
    "success": true,
    "message": "User updated successfully",
    "data": {
        "user": {
            "id": "user_id",
            "name": "Updated Name",
            "role": "moderator",
            "is_active": false
        }
    }
}
```

### 12. Delete User
**DELETE** `/admin/users/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Response:**
```json
{
    "success": true,
    "message": "User deleted successfully"
}
```

### 13. Toggle User Status
**PATCH** `/admin/users/{id}/toggle-status`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Response:**
```json
{
    "success": true,
    "message": "User status updated successfully",
    "data": {
        "user": {
            "id": "user_id",
            "is_active": false
        }
    }
}
```

### 14. Reset User Password
**POST** `/admin/users/{id}/reset-password`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Request Body:**
```json
{
    "new_password": "newpassword123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "User password reset successfully"
}
```

### 15. Get Users by Role
**GET** `/admin/users/role/{role}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "users": {
            "current_page": 1,
            "data": [
                {
                    "id": "user_id",
                    "name": "Admin User",
                    "email": "admin@example.com",
                    "role": "admin"
                }
            ],
            "per_page": 15,
            "total": 1
        }
    }
}
```

## Moderator Endpoints (Moderator or Admin Role Required)

### 16. Moderator Dashboard
**GET** `/moderator/dashboard`

**Headers:**
```
Authorization: Bearer {moderator_token}
```

**Response:**
```json
{
    "success": true,
    "message": "Moderator dashboard accessed successfully"
}
```

## User Endpoints (Any Authenticated User)

### 17. User Dashboard
**GET** `/user/dashboard`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "User dashboard accessed successfully"
}
```

## Test Endpoint

### 18. API Test
**GET** `/test`

**Response:**
```json
{
    "success": true,
    "message": "API is working correctly",
    "timestamp": "2024-01-01T00:00:00.000000Z"
}
```

## Error Responses

### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

### Unauthorized (401)
```json
{
    "success": false,
    "message": "Unauthorized"
}
```

### Forbidden (403)
```json
{
    "success": false,
    "message": "Insufficient permissions"
}
```

### Not Found (404)
```json
{
    "success": false,
    "message": "User not found"
}
```

## User Roles

1. **user** - Basic user with limited access
2. **moderator** - Moderator with elevated permissions
3. **admin** - Administrator with full access

## Default Users (Created by Seeder)

1. **Admin User**
   - Email: admin@safar.com
   - Password: admin123
   - Role: admin

2. **Test User**
   - Email: user@safar.com
   - Password: user123
   - Role: user

3. **Moderator User**
   - Email: moderator@safar.com
   - Password: moderator123
   - Role: moderator

## Setup Instructions

1. Install dependencies:
   ```bash
   composer install
   ```

2. Configure MongoDB connection in `.env`:
   ```
   DB_CONNECTION=mongodb
   DB_HOST=127.0.0.1
   DB_PORT=27017
   DB_DATABASE=safar_backend
   DB_USERNAME=
   DB_PASSWORD=
   ```

3. Run migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. Start the server:
   ```bash
   php artisan serve
   ```

## Security Features

- Password hashing using Laravel's built-in hashing
- Token-based authentication with Laravel Sanctum
- Role-based authorization middleware
- Account activation/deactivation
- Token refresh functionality
- Input validation and sanitization
- Protection against self-deletion for admins
