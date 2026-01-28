# DoctorPatient REST API Documentation

## Overview

This document describes the REST API endpoints for the DoctorPatient application. All API routes are prefixed with `/api` and return JSON responses.

## Authentication

The API uses **Laravel Sanctum** for token-based authentication.

### Login

**Endpoint:** `POST /api/login`

**Request:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Response (200):**
```json
{
  "token": "1|abcdefghijklmnopqrstuvwxyz...",
  "user": {
    "id": 1,
    "name": "User Name",
    "email": "user@example.com",
    "role": "admin",
    "photo_url": "http://...",
    "email_verified_at": "2024-01-01T00:00:00.000000Z",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  }
}
```

### Using the Token

Include the token in the `Authorization` header for protected endpoints:

```
Authorization: Bearer {token}
```

## Public Endpoints

### Cabinets

#### List Cabinets
**Endpoint:** `GET /api/cabinets`

**Query Parameters:**
- `per_page` (optional): Number of items per page (default: 15)
- `page` (optional): Page number (default: 1)
- `search` (optional): Search in name and location
- `doctor_id` (optional): Filter by doctor ID
- `sort` (optional): Sort field (e.g., `name`, `created_at`)
- `direction` (optional): Sort direction (`asc` or `desc`)

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "Speciality": "Cardiology Clinic",
      "location": "123 Medical Center...",
      "image_url": "http://...",
      "link": "http://localhost:8000/api/cabinets/1",
      "promo_url": "http://localhost:8000/cabinets/1"
    }
  ],
  "links": {...},
  "meta": {
    "current_page": 1,
    "total": 10,
    "per_page": 15,
    ...
  }
}
```

#### Show Cabinet
**Endpoint:** `GET /api/cabinets/{id}`

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "name": "Cardiology Clinic",
    "location": "123 Medical Center, New York, NY 10001",
    "doctor_id": 2,
    "doctor": {
      "id": 2,
      "name": "Dr. John Smith",
      "email": "doctor@example.com"
    },
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  }
}
```

## Protected Endpoints

All endpoints below require authentication via `Authorization: Bearer {token}`.

### User Profile

**Endpoint:** `GET /api/user`

Returns the authenticated user's profile.

### Appointments

#### List Appointments
**Endpoint:** `GET /api/appointments`

**Query Parameters:**
- `per_page` (optional): Number of items per page
- `status` (optional): Filter by status (`scheduled`, `completed`, `cancelled`)
- `patient_id` (optional): Filter by patient ID
- `cabinet_id` (optional): Filter by cabinet ID
- `date_from` (optional): Filter from date
- `date_to` (optional): Filter to date
- `sort` (optional): Sort field (default: `datetime`)
- `direction` (optional): Sort direction (default: `asc`)

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "status": "scheduled",
      "datetime": "2024-01-15T10:00:00.000000Z",
      "patient": {
        "id": 3,
        "name": "Patient Name",
        "email": "patient@example.com",
        "role": "patient",
        ...
      },
      "cabinet": {
        "id": 1,
        "name": "Cardiology Clinic",
        ...
      },
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

#### Create Appointment
**Endpoint:** `POST /api/appointments`

**Request:**
```json
{
  "datetime": "2024-01-15T10:00:00",
  "status": "scheduled",
  "cabinet_id": 1,
  "patient_id": 3
}
```

Note: If `patient_id` is not provided, the authenticated user's ID is used.

**Response (201):**
```json
{
  "data": {
    "id": 5,
    "status": "scheduled",
    "datetime": "2024-01-15T10:00:00.000000Z",
    ...
  }
}
```

#### Show Appointment
**Endpoint:** `GET /api/appointments/{id}`

#### Update Appointment
**Endpoint:** `PUT /api/appointments/{id}`

**Request:**
```json
{
  "datetime": "2024-01-15T14:00:00",
  "status": "completed"
}
```

#### Delete Appointment
**Endpoint:** `DELETE /api/appointments/{id}`

**Response (204):** No content

## Admin Endpoints

Requires `role:admin` authorization.

### Users Management

#### List Users
**Endpoint:** `GET /api/admin/users`

**Query Parameters:**
- `per_page`, `page`, `search`, `role`, `sort`, `direction`

#### Create User
**Endpoint:** `POST /api/admin/users`

**Request:**
```json
{
  "name": "New User",
  "email": "newuser@example.com",
  "password": "password123",
  "role": "patient"
}
```

Roles: `admin`, `doctor`, `patient`

#### Show User
**Endpoint:** `GET /api/admin/users/{id}`

#### Update User
**Endpoint:** `PUT /api/admin/users/{id}`

**Request:**
```json
{
  "name": "Updated Name",
  "email": "updated@example.com"
}
```

#### Delete User
**Endpoint:** `DELETE /api/admin/users/{id}`

### Admin - Appointments Management

Same as regular appointment endpoints but prefixed with `/api/admin/appointments`.

### Admin - Cabinets Management

#### List Cabinets
**Endpoint:** `GET /api/admin/cabinets`

#### Create Cabinet
**Endpoint:** `POST /api/admin/cabinets`

**Request:**
```json
{
  "name": "New Clinic Name (min 10 chars)",
  "location": "Full address with minimum 10 characters",
  "doctor_id": 2
}
```

#### Show Cabinet
**Endpoint:** `GET /api/admin/cabinets/{id}`

#### Update Cabinet
**Endpoint:** `PUT /api/admin/cabinets/{id}`

#### Delete Cabinet
**Endpoint:** `DELETE /api/admin/cabinets/{id}`

## Doctor Endpoints

Requires `role:doctor` authorization.

### Doctor - Appointments

**Endpoints:**
- `GET /api/doctor/appointments` - List appointments (filtered by doctor's cabinets)
- `GET /api/doctor/appointments/{id}` - Show appointment
- `PUT /api/doctor/appointments/{id}` - Update appointment

### Doctor - Patients

**Endpoints:**
- `GET /api/doctor/patients` - List patients (read-only)
- `GET /api/doctor/patients/{id}` - Show patient details (read-only)

## HTTP Status Codes

| Code | Description |
|------|-------------|
| 200  | OK - Request successful |
| 201  | Created - Resource created successfully |
| 204  | No Content - Resource deleted successfully |
| 400  | Bad Request - Invalid request data |
| 401  | Unauthorized - Authentication required or failed |
| 403  | Forbidden - Insufficient permissions |
| 404  | Not Found - Resource not found |
| 422  | Unprocessable Entity - Validation errors |

## Validation Errors

When validation fails (422), the response includes detailed error messages:

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": [
      "The email field is required."
    ],
    "password": [
      "The password must be at least 8 characters."
    ]
  }
}
```

## Pagination Response Structure

All paginated responses follow this structure:

```json
{
  "data": [...],
  "links": {
    "first": "http://localhost:8000/api/resource?page=1",
    "last": "http://localhost:8000/api/resource?page=5",
    "prev": null,
    "next": "http://localhost:8000/api/resource?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "path": "http://localhost:8000/api/resource",
    "per_page": 15,
    "to": 15,
    "total": 73
  }
}
```

## Examples

### Example 1: Login and Create Appointment

```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"patient@example.com","password":"password"}'

# Response includes token
# {"token":"1|abc...","user":{...}}

# Create appointment
curl -X POST http://localhost:8000/api/appointments \
  -H "Authorization: Bearer 1|abc..." \
  -H "Content-Type: application/json" \
  -d '{"datetime":"2024-01-15T10:00:00","status":"scheduled","cabinet_id":1}'
```

### Example 2: Admin Creates User

```bash
curl -X POST http://localhost:8000/api/admin/users \
  -H "Authorization: Bearer {admin-token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name":"New Doctor",
    "email":"newdoctor@example.com",
    "password":"securepassword",
    "role":"doctor"
  }'
```

### Example 3: Search and Filter

```bash
# Search cabinets
curl "http://localhost:8000/api/cabinets?search=cardio&per_page=5"

# Filter appointments by status
curl -H "Authorization: Bearer {token}" \
  "http://localhost:8000/api/appointments?status=scheduled&sort=datetime&direction=asc"
```

## Security Notes

1. **Always use HTTPS in production**
2. **Store tokens securely** - Never expose tokens in client-side code
3. **Token expiration** - Tokens don't expire by default; configure as needed
4. **Rate limiting** - Consider implementing rate limiting for public endpoints
5. **CORS** - Configure CORS settings in `config/cors.php` for frontend applications

## Testing

Use the provided test seeder to populate sample data:

```bash
php artisan db:seed --class=TestDataSeeder
```

This creates:
- 1 admin user (admin@example.com)
- 2 doctors (doctor1@example.com, doctor2@example.com)
- 2 patients (patient1@example.com, patient2@example.com)
- 2 cabinets
- 3 appointments

All passwords are: `password`
