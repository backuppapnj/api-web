# Realisasi Anggaran Model

<cite>
**Referenced Files in This Document**
- [RealisasiAnggaran.php](file://app/Models/RealisasiAnggaran.php)
- [PaguAnggaran.php](file://app/Models/PaguAnggaran.php)
- [RealisasiAnggaranController.php](file://app/Http/Controllers/RealisasiAnggaranController.php)
- [PaguAnggaranController.php](file://app/Http/Controllers/PaguAnggaranController.php)
- [2026_02_10_000000_create_realisasi_anggaran_table.php](file://database/migrations/2026_02_10_000000_create_realisasi_anggaran_table.php)
- [2026_02_10_000001_update_realisasi_anggaran_add_month.php](file://database/migrations/2026_02_10_000001_update_realisasi_anggaran_add_month.php)
- [2026_02_10_000002_create_pagu_anggaran_table.php](file://database/migrations/2026_02_10_000002_create_pagu_anggaran_table.php)
- [AnggaranSeeder.php](file://database/seeders/AnggaranSeeder.php)
- [Realisasi Anggaran 2025 - Sheet1.csv](file://docs/Realisasi Anggaran 2025 - Sheet1.csv)
- [Anggaran Belanja 2024 - 2024.csv](file://docs/Anggaran Belanja 2024 - 2024.csv)
</cite>

## Table of Contents
1. [Introduction](#introduction)
2. [Project Structure](#project-structure)
3. [Core Components](#core-components)
4. [Architecture Overview](#architecture-overview)
5. [Detailed Component Analysis](#detailed-component-analysis)
6. [Dependency Analysis](#dependency-analysis)
7. [Performance Considerations](#performance-considerations)
8. [Troubleshooting Guide](#troubleshooting-guide)
9. [Conclusion](#conclusion)

## Introduction

The Realisasi Anggaran model serves as the cornerstone of monthly budget execution tracking within the financial management system. This model maintains detailed records of budget allocations, actual expenditures, and performance metrics across different organizational units (DIPA), expense categories, and time periods. The system integrates seamlessly with the pagu_anggaran master table to ensure real-time budget validation and reporting accuracy.

The model's primary function is to track monthly budget realization percentages, maintain accurate amount tracking, and provide comprehensive category-based allocations for financial reporting and budget monitoring workflows. It serves as the bridge between budget planning and execution, enabling stakeholders to monitor spending patterns, identify potential overexpenditures, and make informed financial decisions.

## Project Structure

The Realisasi Anggaran system follows a well-organized Laravel application structure with clear separation of concerns:

```mermaid
graph TB
subgraph "Model Layer"
RA[RealisasiAnggaran Model]
PA[PaguAnggaran Model]
end
subgraph "Controller Layer"
RAC[RealisasiAnggaranController]
PAC[PaguAnggaranController]
end
subgraph "Database Layer"
RAM[realisasi_anggaran Table]
PAM[pagu_anggaran Table]
MIG[migration files]
end
subgraph "Data Layer"
CSV[CSV Data Files]
SEED[AnggaranSeeder]
end
RA --> PA
RAC --> RA
PAC --> PA
RA --> RAM
PA --> PAM
SEED --> CSV
SEED --> RA
SEED --> PA
MIG --> RAM
MIG --> PAM
```

**Diagram sources**
- [RealisasiAnggaran.php:1-46](file://app/Models/RealisasiAnggaran.php#L1-L46)
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [RealisasiAnggaranController.php:1-154](file://app/Http/Controllers/RealisasiAnggaranController.php#L1-L154)

**Section sources**
- [RealisasiAnggaran.php:1-46](file://app/Models/RealisasiAnggaran.php#L1-L46)
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [RealisasiAnggaranController.php:1-154](file://app/Http/Controllers/RealisasiAnggaranController.php#L1-L154)

## Core Components

### RealisasiAnggaran Model

The RealisasiAnggaran model extends Laravel's Eloquent ORM to provide sophisticated budget tracking capabilities. The model implements several key features:

**Primary Fields:**
- `dipa`: Identifies the organizational unit (DIPA 01, DIPA 04)
- `kategori`: Expense category (Belanja Barang, Belanja Modal, POSBAKUM, etc.)
- `bulan`: Month identifier (1-12) for temporal tracking
- `tahun`: Year for fiscal period identification
- `pagu`: Budget allocation amount
- `realisasi`: Actual expenditure amount
- `sisa`: Remaining budget balance
- `persentase`: Percentage completion calculation
- `keterangan`: Additional remarks or notes
- `link_dokumen`: Document attachment link

**Relationship Management:**
The model establishes a crucial relationship with the PaguAnggaran master table through a belongsTo relationship that ensures budget values remain synchronized with the latest master data.

**Data Type Casting:**
The model implements precise data type casting for financial calculations:
- Currency values cast to float for mathematical operations
- Integer casting for year and month fields
- Decimal precision maintained for monetary amounts

**Section sources**
- [RealisasiAnggaran.php:9-45](file://app/Models/RealisasiAnggaran.php#L9-L45)

### PaguAnggaran Model

The PaguAnggaran model serves as the master budget configuration table, providing centralized budget management:

**Unique Constraints:**
- Composite unique key on (dipa, kategori, tahun) ensures single budget per category per fiscal year
- Prevents duplicate budget entries for the same organizational unit and category combination

**Data Validation:**
- String-based storage for large monetary values to prevent overflow
- Float accessor for convenient mathematical operations
- Decimal casting with 2-decimal precision for currency representation

**Section sources**
- [PaguAnggaran.php:7-29](file://app/Models/PaguAnggaran.php#L7-L29)

## Architecture Overview

The Realisasi Anggaran system implements a robust three-tier architecture that separates concerns while maintaining data integrity:

```mermaid
sequenceDiagram
participant Client as "Client Application"
participant Controller as "RealisasiAnggaranController"
participant Model as "RealisasiAnggaran Model"
participant Master as "PaguAnggaran Model"
participant Database as "Database Layer"
Client->>Controller : GET /api/realisasi-anggaran
Controller->>Model : Query with filters
Model->>Database : SELECT realisasi_anggaran.*
Database-->>Model : Base data records
Model->>Master : paguMaster() relationship
Master->>Database : JOIN pagu_anggaran
Database-->>Model : Latest master values
Model-->>Controller : Combined data
Controller->>Controller : applyMasterPagu()
Controller-->>Client : JSON response with updated values
Note over Client,Database : Real-time budget synchronization
```

**Diagram sources**
- [RealisasiAnggaranController.php:11-53](file://app/Http/Controllers/RealisasiAnggaranController.php#L11-L53)
- [RealisasiAnggaran.php:17-22](file://app/Models/RealisasiAnggaran.php#L17-L22)

The architecture ensures that all budget calculations are performed against the most recent master data, providing accurate and up-to-date financial reporting capabilities.

**Section sources**
- [RealisasiAnggaranController.php:11-53](file://app/Http/Controllers/RealisasiAnggaranController.php#L11-L53)
- [RealisasiAnggaran.php:17-22](file://app/Models/RealisasiAnggaran.php#L17-L22)

## Detailed Component Analysis

### Database Schema Design

The database schema implements a normalized approach to budget tracking with careful consideration for scalability and performance:

```mermaid
erDiagram
realisasi_anggaran {
bigint id PK
string dipa
string kategori
integer bulan
decimal pagu
decimal realisasi
decimal sisa
decimal persentase
smallint tahun
text keterangan
string link_dokumen
timestamp created_at
timestamp updated_at
}
pagu_anggaran {
bigint id PK
string dipa
string kategori
decimal jumlah_pagu
smallint tahun
timestamp created_at
timestamp updated_at
}
realisasi_anggaran }o--|| pagu_anggaran : "budget_reference"
```

**Diagram sources**
- [2026_02_10_000000_create_realisasi_anggaran_table.php:14-25](file://database/migrations/2026_02_10_000000_create_realisasi_anggaran_table.php#L14-L25)
- [2026_02_10_000002_create_pagu_anggaran_table.php:14-22](file://database/migrations/2026_02_10_000002_create_pagu_anggaran_table.php#L14-L22)

### Data Import and Processing Workflow

The system implements automated data ingestion through CSV parsing and seeding mechanisms:

```mermaid
flowchart TD
Start([CSV File Processing]) --> DetectDIPA["Detect DIPA Section<br/>DIPA 01 / DIPA 04"]
DetectDIPA --> ExtractPagu["Extract Pagu Values<br/>Parse Money Strings"]
ExtractPagu --> SetupCategories["Setup Category Arrays<br/>Belanja Pegawai, Barang, Modal"]
SetupCategories --> ReadMonthly["Read Monthly Data<br/>12 Months Processing"]
ReadMonthly --> ParseAmounts["Parse Money Amounts<br/>Remove Currency Formatting"]
ParseAmounts --> CreateRecords["Create Realisasi Records<br/>With Calculated Values"]
CreateRecords --> ValidateData["Validate Non-Zero Records<br/>Historical vs Current"]
ValidateData --> End([Complete Processing])
ReadMonthly --> |Loop| ReadMonthly
CreateRecords --> |Loop| CreateRecords
```

**Diagram sources**
- [AnggaranSeeder.php:37-118](file://database/seeders/AnggaranSeeder.php#L37-L118)

The seeding process handles complex CSV parsing with support for various currency formats, category detection, and automatic record creation with calculated percentage values.

**Section sources**
- [AnggaranSeeder.php:37-118](file://database/seeders/AnggaranSeeder.php#L37-L118)

### Controller Implementation Details

The RealisasiAnggaranController provides comprehensive CRUD operations with advanced filtering and validation:

**Query Filtering Capabilities:**
- Temporal filtering by year and month
- Organizational unit filtering by DIPA
- Category-based searching
- Pagination support with configurable page sizes

**Validation Rules:**
- Required field validation for essential budget data
- Numeric validation for monetary amounts
- Range validation for month values (0-12)
- File upload validation with MIME type restrictions

**Section sources**
- [RealisasiAnggaranController.php:11-53](file://app/Http/Controllers/RealisasiAnggaranController.php#L11-L53)
- [RealisasiAnggaranController.php:55-120](file://app/Http/Controllers/RealisasiAnggaranController.php#L55-L120)

### Financial Calculation Engine

The system implements sophisticated financial calculations with built-in error handling:

```mermaid
flowchart TD
Input([Budget Input]) --> ValidateInput["Validate Input Data<br/>Required Fields & Types"]
ValidateInput --> FetchMaster["Fetch Master Pagu<br/>Latest Budget Value"]
FetchMaster --> CalculateSisa["Calculate Remaining Balance<br/>sisa = pagu - realisasi"]
CalculateSisa --> CalculatePersen["Calculate Percentage<br/>persentase = (realisasi/pagu) * 100"]
CalculatePersen --> ApplyMaster["Apply Master Values<br/>Override with Latest Data"]
ApplyMaster --> StoreData["Store Calculated Values<br/>Persist to Database"]
StoreData --> Output([Financial Report Ready])
ValidateInput --> |Invalid| Error([Validation Error])
FetchMaster --> |Not Found| UseStored["Use Stored Pagu Value"]
UseStored --> CalculateSisa
```

**Diagram sources**
- [RealisasiAnggaranController.php:73-84](file://app/Http/Controllers/RealisasiAnggaranController.php#L73-L84)
- [RealisasiAnggaranController.php:143-152](file://app/Http/Controllers/RealisasiAnggaranController.php#L143-L152)

The calculation engine ensures mathematical accuracy while providing fallback mechanisms for edge cases such as zero budget scenarios.

**Section sources**
- [RealisasiAnggaranController.php:73-84](file://app/Http/Controllers/RealisasiAnggaranController.php#L73-L84)
- [RealisasiAnggaranController.php:143-152](file://app/Http/Controllers/RealisasiAnggaranController.php#L143-L152)

## Dependency Analysis

The Realisasi Anggaran system exhibits well-managed dependencies with clear separation of concerns:

```mermaid
graph LR
subgraph "External Dependencies"
ELOQUENT[Eloquent ORM]
VALIDATION[Validation Rules]
FILEUPLOAD[File Upload Handling]
end
subgraph "Internal Dependencies"
RA_MODEL[RealisasiAnggaran Model]
PA_MODEL[PaguAnggaran Model]
RA_CONTROLLER[RealisasiAnggaran Controller]
PA_CONTROLLER[PaguAnggaran Controller]
SEEDER[Anggaran Seeder]
end
subgraph "Database Dependencies"
RA_TABLE[realisasi_anggaran Table]
PA_TABLE[pagu_anggaran Table]
MIGRATION[migration files]
end
ELOQUENT --> RA_MODEL
ELOQUENT --> PA_MODEL
VALIDATION --> RA_CONTROLLER
VALIDATION --> PA_CONTROLLER
FILEUPLOAD --> RA_CONTROLLER
RA_MODEL --> PA_MODEL
RA_CONTROLLER --> RA_MODEL
PA_CONTROLLER --> PA_MODEL
SEEDER --> RA_MODEL
SEEDER --> PA_MODEL
RA_MODEL --> RA_TABLE
PA_MODEL --> PA_TABLE
RA_CONTROLLER --> MIGRATION
PA_CONTROLLER --> MIGRATION
```

**Diagram sources**
- [RealisasiAnggaran.php:5-7](file://app/Models/RealisasiAnggaran.php#L5-L7)
- [PaguAnggaran.php:5](file://app/Models/PaguAnggaran.php#L5)

The dependency graph reveals a clean architecture where models encapsulate business logic, controllers handle HTTP requests, and seeders manage data initialization. The system avoids circular dependencies while maintaining loose coupling between components.

**Section sources**
- [RealisasiAnggaran.php:5-7](file://app/Models/RealisasiAnggaran.php#L5-L7)
- [PaguAnggaran.php:5](file://app/Models/PaguAnggaran.php#L5)

## Performance Considerations

The Realisasi Anggaran system incorporates several performance optimization strategies:

**Database Indexing Strategy:**
- Primary table indexes on frequently queried columns (dipa, kategori, tahun)
- Composite unique constraints for data integrity
- Efficient JOIN operations between realisasi_anggaran and pagu_anggaran tables

**Memory Management:**
- Decimal precision optimized for currency calculations (20,2)
- Efficient pagination implementation to handle large datasets
- Lazy loading of relationship data to minimize memory footprint

**Calculation Efficiency:**
- Pre-computed percentage values stored for quick retrieval
- Batch processing capabilities for bulk data operations
- Optimized query patterns to reduce database round trips

**Section sources**
- [2026_02_10_000000_create_realisasi_anggaran_table.php:16-24](file://database/migrations/2026_02_10_000000_create_realisasi_anggaran_table.php#L16-L24)
- [2026_02_10_000002_create_pagu_anggaran_table.php:16-21](file://database/migrations/2026_02_10_000002_create_pagu_anggaran_table.php#L16-L21)

## Troubleshooting Guide

### Common Issues and Solutions

**Budget Synchronization Problems:**
- **Issue**: Outdated budget values in reports
- **Solution**: Verify master pagu table updates and check relationship implementation
- **Prevention**: Regular maintenance of master budget data

**Data Import Failures:**
- **Issue**: CSV parsing errors during seeding
- **Solution**: Validate CSV format and currency string consistency
- **Prevention**: Implement pre-validation of source data formats

**Calculation Accuracy Issues:**
- **Issue**: Incorrect percentage calculations
- **Solution**: Verify decimal precision handling and division by zero protection
- **Prevention**: Implement comprehensive unit testing for financial calculations

**Performance Degradation:**
- **Issue**: Slow query performance on large datasets
- **Solution**: Review database indexing and optimize query patterns
- **Prevention**: Monitor query execution plans and implement caching strategies

**Section sources**
- [RealisasiAnggaranController.php:143-152](file://app/Http/Controllers/RealisasiAnggaranController.php#L143-L152)
- [AnggaranSeeder.php:123-128](file://database/seeders/AnggaranSeeder.php#L123-L128)

## Conclusion

The Realisasi Anggaran model represents a sophisticated solution for monthly budget execution tracking within the financial management ecosystem. Its robust architecture, comprehensive data validation, and seamless integration with master budget tables provide reliable foundation for financial reporting and budget monitoring workflows.

The system's strength lies in its ability to maintain real-time synchronization between budget allocations and actual expenditures while providing flexible querying capabilities for diverse analytical needs. The implementation demonstrates best practices in database design, controller architecture, and data processing workflows.

Future enhancements could include advanced reporting dashboards, automated budget alert systems, and expanded integration capabilities with external financial systems. The current implementation provides an excellent foundation for these extensions while maintaining system stability and performance.