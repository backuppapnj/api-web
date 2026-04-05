# Itsbat Nikah CRUD Operations

<cite>
**Referenced Files in This Document**
- [ItsbatNikahController.php](file://app/Http/Controllers/ItsbatNikahController.php)
- [ItsbatNikah.php](file://app/Models/ItsbatNikah.php)
- [2026_01_21_000003_create_itsbat_nikah_table.php](file://database/migrations/2026_01_21_000003_create_itsbat_nikah_table.php)
- [web.php](file://routes/web.php)
- [ApiKeyMiddleware.php](file://app/Http/Middleware/ApiKeyMiddleware.php)
- [GoogleDriveService.php](file://app/Services/GoogleDriveService.php)
- [ItsbatSeeder.php](file://database/seeders/ItsbatSeeder.php)
- [data_itsbat.json](file://database/seeders/data_itsbat.json)
- [joomla-itsbat-integration.html](file://docs/joomla-itsbat-integration.html)
</cite>

## Table of Contents
1. [Introduction](#introduction)
2. [API Endpoints Overview](#api-endpoints-overview)
3. [Authentication and Security](#authentication-and-security)
4. [Core Data Model](#core-data-model)
5. [CRUD Operations](#crud-operations)
6. [Search and Filtering](#search-and-filtering)
7. [File Upload Management](#file-upload-management)
8. [Request/Response Schemas](#requestresponse-schemas)
9. [Validation Rules](#validation-rules)
10. [Practical Examples](#practical-examples)
11. [Error Handling](#error-handling)
12. [Performance Considerations](#performance-considerations)
13. [Troubleshooting Guide](#troubleshooting-guide)
14. [Conclusion](#conclusion)

## Introduction

The Itsbat Nikah module provides comprehensive CRUD operations for managing marriage certificate records within the legal system. This API enables authorized clients to create, read, update, and delete marriage certificate records while maintaining document attachments and processing metadata.

The system integrates with Google Drive for document storage and provides robust validation, authentication, and search capabilities. The API follows RESTful principles and returns standardized JSON responses for all operations.

## API Endpoints Overview

The Itsbat Nikah API exposes the following endpoints:

### Public Endpoints (No Authentication Required)
- `GET /api/itsbat` - Retrieve paginated list of marriage certificates
- `GET /api/itsbat/{id}` - Retrieve specific marriage certificate by ID

### Protected Endpoints (Requires API Key)
- `POST /api/itsbat` - Create new marriage certificate record
- `PUT /api/itsbat/{id}` - Update existing marriage certificate record
- `POST /api/itsbat/{id}` - Alternative update endpoint for marriage certificate record
- `DELETE /api/itsbat/{id}` - Delete marriage certificate record

**Section sources**
- [web.php:20-22](file://routes/web.php#L20-L22)
- [web.php:87-90](file://routes/web.php#L87-L90)

## Authentication and Security

### API Key Authentication

All protected endpoints require a valid API key passed in the `X-API-Key` header:

```
Authorization: Bearer YOUR_API_KEY_HERE
```

### Security Implementation

The API implements several security measures:

1. **API Key Validation**: Middleware validates API keys using timing-safe comparison
2. **Rate Limiting**: 100 requests per minute for all endpoints
3. **Input Validation**: Comprehensive server-side validation for all requests
4. **File Upload Security**: MIME type validation and size restrictions
5. **Error Handling**: Generic error messages to prevent information disclosure

### API Key Middleware Details

The middleware performs:
- Environment variable validation for API key configuration
- Timing-safe comparison using `hash_equals()` to prevent timing attacks
- Randomized delays to mitigate brute force attacks
- Proper HTTP status codes (401 Unauthorized, 500 Server Configuration Error)

**Section sources**
- [ApiKeyMiddleware.php:14-39](file://app/Http/Middleware/ApiKeyMiddleware.php#L14-L39)

## Core Data Model

The Itsbat Nikah model defines the marriage certificate record structure:

### Database Schema

| Field | Type | Description | Constraints |
|-------|------|-------------|-------------|
| `id` | BIGINT | Auto-incrementing primary key | Primary Key |
| `nomor_perkara` | VARCHAR | Marriage certificate number | Unique, Required |
| `pemohon_1` | VARCHAR | Bride's name | Nullable |
| `pemohon_2` | VARCHAR | Groom's name | Nullable |
| `tanggal_pengumuman` | DATE | Announcement date | Nullable |
| `tanggal_sidang` | DATE | Court hearing date | Nullable |
| `link_detail` | TEXT | Document link | Nullable |
| `tahun_perkara` | YEAR | Case year | Nullable |
| `created_at` | TIMESTAMP | Record creation timestamp | Automatic |
| `updated_at` | TIMESTAMP | Record update timestamp | Automatic |

### Model Configuration

The model uses the `itsbat_nikah` table and includes:
- Fillable attributes for mass assignment protection
- Date casting for proper serialization
- Database indexes for performance optimization

**Section sources**
- [ItsbatNikah.php:9-24](file://app/Models/ItsbatNikah.php#L9-L24)
- [2026_01_21_000003_create_itsbat_nikah_table.php:13-28](file://database/migrations/2026_01_21_000003_create_itsbat_nikah_table.php#L13-L28)

## CRUD Operations

### Create Operation (POST /api/itsbat)

Creates a new marriage certificate record with the following requirements:

**Required Fields:**
- `nomor_perkara` - Unique marriage certificate number
- `pemohon_1` - Bride's name
- `tanggal_sidang` - Court hearing date (YYYY-MM-DD format)
- `tahun_perkara` - Case year (integer)

**Optional Fields:**
- `pemohon_2` - Groom's name
- `tanggal_pengumuman` - Announcement date
- `file_upload` - Document attachment (PDF, DOC, DOCX, JPG, JPEG, PNG)

### Update Operation (PUT /api/itsbat/{id})

Updates an existing marriage certificate record. Uses the same field requirements as create operation.

**Important**: The unique constraint applies to the marriage certificate number, excluding the current record during updates.

### Delete Operation (DELETE /api/itsbat/{id})

Removes a marriage certificate record permanently. Returns success message upon completion.

**Section sources**
- [ItsbatNikahController.php:45-117](file://app/Http/Controllers/ItsbatNikahController.php#L45-L117)
- [ItsbatNikahController.php:130-208](file://app/Http/Controllers/ItsbatNikahController.php#L130-L208)
- [ItsbatNikahController.php:210-224](file://app/Http/Controllers/ItsbatNikahController.php#L210-L224)

## Search and Filtering

### GET /api/itsbat

Provides paginated search results with filtering capabilities:

**Query Parameters:**
- `tahun` - Filter by case year
- `q` - Search by marriage certificate number or names
- `limit` - Number of records per page (default: 10)

**Response Format:**
```json
{
  "success": true,
  "data": [...],
  "current_page": 1,
  "last_page": 5,
  "per_page": 10,
  "total": 45
}
```

**Default Sorting:** Results are sorted by court hearing date (newest first)

**Section sources**
- [ItsbatNikahController.php:10-43](file://app/Http/Controllers/ItsbatNikahController.php#L10-L43)
- [joomla-itsbat-integration.html:254-256](file://docs/joomla-itsbat-integration.html#L254-L256)

## File Upload Management

### Document Attachment Support

The system supports document uploads with automatic storage management:

**Supported File Types:**
- PDF documents
- Microsoft Word documents (DOC, DOCX)
- Image files (JPG, JPEG, PNG)

**File Size Limits:** Maximum 5MB per file

### Storage Strategy

The system implements a two-tier storage approach:

1. **Primary Storage**: Google Drive integration
   - Automatic folder organization by date (YYYY-MM-DD)
   - Publicly accessible links
   - Permission management

2. **Fallback Storage**: Local filesystem backup
   - Automatic fallback when Google Drive is unavailable
   - Secure file naming with timestamp prefixes
   - Accessible via `/uploads/itsbat/` path

### Google Drive Integration Features

- Automatic daily folder creation
- File permission management
- Error handling and fallback mechanisms
- Public link generation for document access

**Section sources**
- [ItsbatNikahController.php:64-108](file://app/Http/Controllers/ItsbatNikahController.php#L64-L108)
- [GoogleDriveService.php:38-82](file://app/Services/GoogleDriveService.php#L38-L82)

## Request/Response Schemas

### Create Request Schema

**Required Fields:**
```json
{
  "nomor_perkara": "string",
  "pemohon_1": "string",
  "tanggal_sidang": "date",
  "tahun_perkara": "integer"
}
```

**Optional Fields:**
```json
{
  "pemohon_2": "string",
  "tanggal_pengumuman": "date",
  "file_upload": "file"
}
```

### Update Request Schema

Same as create request with additional validation for unique marriage certificate number exclusion.

### Response Schema

**Success Response:**
```json
{
  "success": true,
  "data": {
    "id": "integer",
    "nomor_perkara": "string",
    "pemohon_1": "string",
    "pemohon_2": "string",
    "tanggal_pengumuman": "date",
    "tanggal_sidang": "date",
    "link_detail": "string",
    "tahun_perkara": "integer",
    "created_at": "timestamp",
    "updated_at": "timestamp"
  },
  "message": "string"
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "string"
}
```

**Section sources**
- [ItsbatNikahController.php:47-53](file://app/Http/Controllers/ItsbatNikahController.php#L47-L53)
- [ItsbatNikahController.php:138-143](file://app/Http/Controllers/ItsbatNikahController.php#L138-L143)

## Validation Rules

### Field Validation Rules

| Field | Validation Rule | Description |
|-------|----------------|-------------|
| `nomor_perkara` | `required|unique:itsbat_nikah,nomor_perkara` | Unique marriage certificate number |
| `pemohon_1` | `required` | Required bride name |
| `pemohon_2` | `nullable` | Optional groom name |
| `tanggal_sidang` | `required|date` | Required court hearing date |
| `tanggal_pengumuman` | `nullable|date` | Optional announcement date |
| `tahun_perkara` | `required|integer` | Required case year |
| `file_upload` | `nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120` | Document upload validation |

### Date Format Requirements

- **Format**: YYYY-MM-DD
- **Validation**: ISO 8601 compliant dates
- **Null Handling**: Empty strings converted to null values

### File Upload Validation

- **MIME Types**: pdf, doc, docx, jpg, jpeg, png
- **Size Limit**: 5MB maximum
- **Optional**: Can be omitted for text-only records

**Section sources**
- [ItsbatNikahController.php:47-53](file://app/Http/Controllers/ItsbatNikahController.php#L47-L53)
- [ItsbatNikahController.php:138-143](file://app/Http/Controllers/ItsbatNikahController.php#L138-L143)

## Practical Examples

### Successful Creation Request

**Request:**
```bash
curl -X POST https://api.example.com/api/itsbat \
  -H "X-API-Key: YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "nomor_perkara": "1/Pdt.P/2025/PA.Pnj",
    "pemohon_1": "Masroni Wijaya Bin Juraid",
    "pemohon_2": "Merlin Sela Binti Petrus Toala",
    "tanggal_pengumuman": "2025-01-03",
    "tanggal_sidang": "2025-01-22",
    "tahun_perkara": 2025
  }'
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nomor_perkara": "1/Pdt.P/2025/PA.Pnj",
    "pemohon_1": "Masroni Wijaya Bin Juraid",
    "pemohon_2": "Merlin Sela Binti Petrus Toala",
    "tanggal_pengumuman": "2025-01-03",
    "tanggal_sidang": "2025-01-22",
    "link_detail": null,
    "tahun_perkara": 2025,
    "created_at": "2025-01-24T10:30:00.000000Z",
    "updated_at": "2025-01-24T10:30:00.000000Z"
  },
  "message": "Data Itsbat Nikah berhasil ditambahkan"
}
```

### Document Upload Example

**Request with File:**
```bash
curl -X POST https://api.example.com/api/itsbat \
  -H "X-API-Key: YOUR_API_KEY" \
  -F "nomor_perkara=1/Pdt.P/2025/PA.Pnj" \
  -F "pemohon_1=Masroni Wijaya Bin Juraid" \
  -F "pemohon_2=Merlin Sela Binti Petrus Toala" \
  -F "tanggal_sidang=2025-01-22" \
  -F "tahun_perkara=2025" \
  -F "file_upload=@/path/to/document.pdf"
```

**Response with Document Link:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nomor_perkara": "1/Pdt.P/2025/PA.Pnj",
    "pemohon_1": "Masroni Wijaya Bin Juraid",
    "pemohon_2": "Merlin Sela Binti Petrus Toala",
    "tanggal_pengumuman": "2025-01-03",
    "tanggal_sidang": "2025-01-22",
    "link_detail": "https://drive.google.com/file/d/FILE_ID/view?usp=drive_link",
    "tahun_perkara": 2025,
    "created_at": "2025-01-24T10:30:00.000000Z",
    "updated_at": "2025-01-24T10:30:00.000000Z"
  },
  "message": "Data Itsbat Nikah berhasil ditambahkan"
}
```

### Search and Pagination Example

**Request:**
```bash
curl "https://api.example.com/api/itsbat?tahun=2025&limit=25"
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nomor_perkara": "1/Pdt.P/2025/PA.Pnj",
      "pemohon_1": "Masroni Wijaya Bin Juraid",
      "pemohon_2": "Merlin Sela Binti Petrus Toala",
      "tanggal_pengumuman": "2025-01-03",
      "tanggal_sidang": "2025-01-22",
      "link_detail": "https://drive.google.com/file/d/FILE_ID/view?usp=drive_link",
      "tahun_perkara": 2025
    }
  ],
  "current_page": 1,
  "last_page": 1,
  "per_page": 25,
  "total": 1
}
```

### Validation Error Response

**Request with Invalid Data:**
```bash
curl -X POST https://api.example.com/api/itsbat \
  -H "X-API-Key: YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "nomor_perkara": "",
    "pemohon_1": "",
    "tanggal_sidang": "invalid-date"
  }'
```

**Response:**
```json
{
  "success": false,
  "message": "Validation failed"
}
```

**Section sources**
- [ItsbatNikahController.php:45-117](file://app/Http/Controllers/ItsbatNikahController.php#L45-L117)
- [ItsbatNikahController.php:10-43](file://app/Http/Controllers/ItsbatNikahController.php#L10-L43)

## Error Handling

### Common Error Responses

| Error Type | HTTP Status | Response Format | Description |
|------------|-------------|----------------|-------------|
| Authentication Error | 401 | `{"success": false, "message": "Unauthorized"}` | Invalid or missing API key |
| Server Configuration | 500 | `{"success": false, "message": "Server configuration error"}` | API key not configured |
| Not Found | 404 | `{"success": false, "message": "Data not found"}` | Record does not exist |
| Validation Error | 422 | `{"success": false, "message": "Validation failed"}` | Invalid input data |
| Internal Error | 500 | `{"success": false, "message": "Gagal upload file (Drive & Local)"}` | File upload failure |

### Error Prevention Strategies

1. **Input Sanitization**: Empty strings automatically converted to null values
2. **Unique Constraints**: Proper validation for marriage certificate numbers
3. **File Validation**: MIME type and size verification
4. **Graceful Degradation**: Automatic fallback to local storage when Google Drive fails

**Section sources**
- [ItsbatNikahController.php:134-136](file://app/Http/Controllers/ItsbatNikahController.php#L134-L136)
- [ApiKeyMiddleware.php:20-25](file://app/Http/Middleware/ApiKeyMiddleware.php#L20-L25)

## Performance Considerations

### Database Optimization

The migration includes strategic indexes for improved query performance:
- Index on `tahun_perkara` for year-based filtering
- Index on `pemohon_1` for bride name searches
- Index on `pemohon_2` for groom name searches

### Pagination Strategy

- Default page size: 10 records
- Configurable via `limit` parameter
- Efficient database pagination with `paginate()` method

### File Storage Performance

- Google Drive integration for scalable document storage
- Automatic fallback to local storage for reliability
- Optimized file naming and organization

### Rate Limiting

- 100 requests per minute across all endpoints
- Prevents abuse and ensures fair resource distribution
- Configured at route level middleware

**Section sources**
- [2026_01_21_000003_create_itsbat_nikah_table.php:24-27](file://database/migrations/2026_01_21_000003_create_itsbat_nikah_table.php#L24-L27)
- [web.php:14](file://routes/web.php#L14)

## Troubleshooting Guide

### Common Issues and Solutions

#### API Key Authentication Problems
**Issue**: Getting 401 Unauthorized responses
**Solution**: 
- Verify API key is set in `.env` file
- Ensure `X-API-Key` header is included in requests
- Check for proper API key configuration

#### File Upload Failures
**Issue**: Documents not uploading to Google Drive
**Solution**:
- Verify Google Drive credentials are configured
- Check network connectivity to Google services
- Confirm file size and type meet requirements
- Review fallback mechanism to local storage

#### Database Connection Issues
**Issue**: Server configuration errors
**Solution**:
- Verify database connection settings
- Check migration status
- Ensure proper database permissions

#### Search Performance Issues
**Issue**: Slow search responses
**Solution**:
- Use appropriate filters (`tahun`, `q`)
- Adjust pagination limits
- Consider indexing optimization

### Debug Information

The system logs detailed information for troubleshooting:
- File upload success/failure events
- API key validation attempts
- Database query performance metrics
- Error stack traces for development

**Section sources**
- [GoogleDriveService.php:75-79](file://app/Services/GoogleDriveService.php#L75-L79)
- [ItsbatNikahController.php:75-84](file://app/Http/Controllers/ItsbatNikahController.php#L75-L84)

## Conclusion

The Itsbat Nikah CRUD API provides a comprehensive solution for managing marriage certificate records with robust security, validation, and document management capabilities. The system's dual-storage approach ensures reliability, while the standardized JSON responses and comprehensive error handling make integration straightforward for client applications.

Key strengths include:
- Secure API key authentication with timing-safe comparisons
- Comprehensive input validation and error handling
- Flexible search and filtering capabilities
- Reliable document storage with automatic fallback
- Scalable pagination and performance optimization

The API is designed to support both automated systems and manual data entry workflows, making it suitable for integration with various legal and administrative systems.