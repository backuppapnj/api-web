# Core Models

<cite>
**Referenced Files in This Document**
- [Panggilan.php](file://app/Models/Panggilan.php)
- [RealisasiAnggaran.php](file://app/Models/RealisasiAnggaran.php)
- [LhkpnReport.php](file://app/Models/LhkpnReport.php)
- [PaguAnggaran.php](file://app/Models/PaguAnggaran.php)
- [PanggilanEcourt.php](file://app/Models/PanggilanEcourt.php)
- [AgendaPimpinan.php](file://app/Models/AgendaPimpinan.php)
- [LraReport.php](file://app/Models/LraReport.php)
- [Sakip.php](file://app/Models/Sakip.php)
- [AsetBmn.php](file://app/Models/AsetBmn.php)
- [Inovasi.php](file://app/Models/Inovasi.php)
- [SkInovasi.php](file://app/Models/SkInovasi.php)
- [InovasiController.php](file://app/Http/Controllers/InovasiController.php)
- [SkInovasiController.php](file://app/Http/Controllers/SkInovasiController.php)
- [create_panggilan_ghaib_table.php](file://database/migrations/2026_01_21_000001_create_panggilan_ghaib_table.php)
- [create_realisasi_anggaran_table.php](file://database/migrations/2026_02_10_000000_create_realisasi_anggaran_table.php)
- [update_realisasi_anggaran_add_month.php](file://database/migrations/2026_02_10_000001_update_realisasi_anggaran_add_month.php)
- [create_pagu_anggaran_table.php](file://database/migrations/2026_02_10_000002_create_pagu_anggaran_table.php)
- [create_lhkpn_reports_table.php](file://database/migrations/2026_02_02_162040_create_lhkpn_reports_table.php)
- [update_lhkpn_reports_add_links.php](file://database/migrations/2026_02_10_000003_update_lhkpn_reports_add_links.php)
- [rename_spt_to_lhkasn.php](file://database/migrations/2026_02_10_000004_rename_spt_to_lhkasn.php)
- [create_inovasi_table.php](file://database/migrations/2026_04_08_000001_create_inovasi_table.php)
- [create_sk_inovasi_table.php](file://database/migrations/2026_04_08_011152_create_sk_inovasi_table.php)
</cite>

## Update Summary
**Changes Made**
- Added new innovation management models section covering Inovasi and SkInovasi
- Updated project structure diagram to include new models
- Added detailed documentation for innovation management functionality
- Updated architecture overview to include innovation models
- Enhanced dependency analysis with new model relationships

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
This document describes the core data models that represent primary business entities in the system. It focuses on:
- Panggilan (primary case management for absent parties)
- RealisasiAnggaran (budget execution tracking)
- LhkpnReport (asset declarations)
- **Inovasi and SkInovasi (innovation management system)**
- Supporting models such as PaguAnggaran, PanggilanEcourt, AgendaPimpinan, LraReport, Sakip, and AsetBmn

For each model, we document field definitions, data types, validation rules, business logic, Eloquent relationships, scopes and query builders, lifecycle hooks, attribute casting, serialization patterns, polymorphic relationships, shared behaviors, common queries, data transformations, and performance considerations.

## Project Structure
The models are located under app/Models and correspond to Laravel migration files under database/migrations. Each migration defines the database schema and indexes for the respective model. The addition of innovation management models expands the system's capabilities for tracking and managing organizational innovations.

```mermaid
graph TB
subgraph "Core Models"
P["Panggilan"]
RA["RealisasiAnggaran"]
PA["PaguAnggaran"]
LR["LhkpnReport"]
PE["PanggilanEcourt"]
AP["AgendaPimpinan"]
LRA["LraReport"]
SK["Sakip"]
AB["AsetBmn"]
IN["Inovasi"]
SIN["SkInovasi"]
end
subgraph "Migrations"
MP["create_panggilan_ghaib_table.php"]
MRA["create_realisasi_anggaran_table.php"]
MRA2["update_realisasi_anggaran_add_month.php"]
MPA["create_pagu_anggaran_table.php"]
MLR["create_lhkpn_reports_table.php"]
MLR2["update_lhkpn_reports_add_links.php"]
MLR3["rename_spt_to_lhkasn.php"]
MIN["create_inovasi_table.php"]
MSIN["create_sk_inovasi_table.php"]
end
P --- MP
RA --- MRA
RA --- MRA2
PA --- MPA
LR --- MLR
LR --- MLR2
LR --- MLR3
IN --- MIN
SIN --- MSIN
PE --- MP
AP --- MP
LRA --- MP
SK --- MP
AB --- MP
```

**Diagram sources**
- [Panggilan.php:1-55](file://app/Models/Panggilan.php#L1-L55)
- [RealisasiAnggaran.php:1-46](file://app/Models/RealisasiAnggaran.php#L1-L46)
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [LhkpnReport.php:1-28](file://app/Models/LhkpnReport.php#L1-L28)
- [PanggilanEcourt.php:1-33](file://app/Models/PanggilanEcourt.php#L1-L33)
- [AgendaPimpinan.php:1-35](file://app/Models/AgendaPimpinan.php#L1-L35)
- [LraReport.php:1-24](file://app/Models/LraReport.php#L1-L24)
- [Sakip.php:1-24](file://app/Models/Sakip.php#L1-L24)
- [AsetBmn.php:1-21](file://app/Models/AsetBmn.php#L1-L21)
- [Inovasi.php:1-25](file://app/Models/Inovasi.php#L1-L25)
- [SkInovasi.php:1-40](file://app/Models/SkInovasi.php#L1-L40)
- [create_panggilan_ghaib_table.php:1-42](file://database/migrations/2026_01_21_000001_create_panggilan_ghaib_table.php#L1-L42)
- [create_realisasi_anggaran_table.php:1-36](file://database/migrations/2026_02_10_000000_create_realisasi_anggaran_table.php#L1-L36)
- [update_realisasi_anggaran_add_month.php:1-30](file://database/migrations/2026_02_10_000001_update_realisasi_anggaran_add_month.php#L1-L30)
- [create_pagu_anggaran_table.php:1-33](file://database/migrations/2026_02_10_000002_create_pagu_anggaran_table.php#L1-L33)
- [create_lhkpn_reports_table.php:1-36](file://database/migrations/2026_02_02_162040_create_lhkpn_reports_table.php#L1-L36)
- [update_lhkpn_reports_add_links.php:1-30](file://database/migrations/2026_02_10_000003_update_lhkpn_reports_add_links.php#L1-L30)
- [rename_spt_to_lhkasn.php:1-31](file://database/migrations/2026_02_10_000004_rename_spt_to_lhkasn.php#L1-L31)
- [create_inovasi_table.php:1-30](file://database/migrations/2026_04_08_000001_create_inovasi_table.php#L1-L30)
- [create_sk_inovasi_table.php:1-34](file://database/migrations/2026_04_08_011152_create_sk_inovasi_table.php#L1-L34)

**Section sources**
- [Panggilan.php:1-55](file://app/Models/Panggilan.php#L1-L55)
- [RealisasiAnggaran.php:1-46](file://app/Models/RealisasiAnggaran.php#L1-L46)
- [LhkpnReport.php:1-28](file://app/Models/LhkpnReport.php#L1-L28)
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [PanggilanEcourt.php:1-33](file://app/Models/PanggilanEcourt.php#L1-L33)
- [AgendaPimpinan.php:1-35](file://app/Models/AgendaPimpinan.php#L1-L35)
- [LraReport.php:1-24](file://app/Models/LraReport.php#L1-L24)
- [Sakip.php:1-24](file://app/Models/Sakip.php#L1-L24)
- [AsetBmn.php:1-21](file://app/Models/AsetBmn.php#L1-L21)
- [Inovasi.php:1-25](file://app/Models/Inovasi.php#L1-L25)
- [SkInovasi.php:1-40](file://app/Models/SkInovasi.php#L1-L40)
- [create_panggilan_ghaib_table.php:1-42](file://database/migrations/2026_01_21_000001_create_panggilan_ghaib_table.php#L1-L42)
- [create_realisasi_anggaran_table.php:1-36](file://database/migrations/2026_02_10_000000_create_realisasi_anggaran_table.php#L1-L36)
- [update_realisasi_anggaran_add_month.php:1-30](file://database/migrations/2026_02_10_000001_update_realisasi_anggaran_add_month.php#L1-L30)
- [create_pagu_anggaran_table.php:1-33](file://database/migrations/2026_02_10_000002_create_pagu_anggaran_table.php#L1-L33)
- [create_lhkpn_reports_table.php:1-36](file://database/migrations/2026_02_02_162040_create_lhkpn_reports_table.php#L1-L36)
- [update_lhkpn_reports_add_links.php:1-30](file://database/migrations/2026_02_10_000003_update_lhkpn_reports_add_links.php#L1-L30)
- [rename_spt_to_lhkasn.php:1-31](file://database/migrations/2026_02_10_000004_rename_spt_to_lhkasn.php#L1-L31)
- [create_inovasi_table.php:1-30](file://database/migrations/2026_04_08_000001_create_inovasi_table.php#L1-L30)
- [create_sk_inovasi_table.php:1-34](file://database/migrations/2026_04_08_011152_create_sk_inovasi_table.php#L1-L34)

## Core Components
This section summarizes the primary models and their roles in the system.

- Panggilan: Case management for absent parties with multiple call dates, court session date, and optional documents.
- RealisasiAnggaran: Tracks budget execution per DIPA, category, month, and year, linked to PaguAnggaran via composite keys.
- PaguAnggaran: Master budget records per DIPA and category per year with unique constraint.
- LhkpnReport: Asset declaration records with links to supporting documents and report types.
- **Inovasi: Innovation tracking system for recording and categorizing organizational innovations with document links and ordering.**
- **SkInovasi: Innovation directive management for storing official directives (SK) related to innovation programs with active status tracking.**
- Supporting models: PanggilanEcourt, AgendaPimpinan, LraReport, Sakip, AsetBmn for related administrative and reporting needs.

**Section sources**
- [Panggilan.php:1-55](file://app/Models/Panggilan.php#L1-L55)
- [RealisasiAnggaran.php:1-46](file://app/Models/RealisasiAnggaran.php#L1-L46)
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [LhkpnReport.php:1-28](file://app/Models/LhkpnReport.php#L1-L28)
- [PanggilanEcourt.php:1-33](file://app/Models/PanggilanEcourt.php#L1-L33)
- [AgendaPimpinan.php:1-35](file://app/Models/AgendaPimpinan.php#L1-L35)
- [LraReport.php:1-24](file://app/Models/LraReport.php#L1-L24)
- [Sakip.php:1-24](file://app/Models/Sakip.php#L1-L24)
- [AsetBmn.php:1-21](file://app/Models/AsetBmn.php#L1-L21)
- [Inovasi.php:1-25](file://app/Models/Inovasi.php#L1-L25)
- [SkInovasi.php:1-40](file://app/Models/SkInovasi.php#L1-L40)

## Architecture Overview
The models form a cohesive domain layer with explicit relationships and constraints. RealisasiAnggaran references PaguAnggaran through a composite foreign key relationship, ensuring budget tracking aligns with master budgets. LhkpnReport supports multiple document links and standardized report types. Inovasi and SkInovasi provide innovation management capabilities with distinct purposes - tracking individual innovations and managing official directives. Panggilan and related models capture procedural and administrative events.

```mermaid
classDiagram
class PaguAnggaran {
+string dipa
+string kategori
+decimal jumlah_pagu
+year tahun
}
class RealisasiAnggaran {
+string dipa
+string kategori
+integer bulan
+decimal pagu
+decimal realisasi
+decimal sisa
+decimal persentase
+year tahun
+string keterangan
+string link_dokumen
+paguMaster()
}
class Inovasi {
+string nama_inovasi
+text deskripsi
+string kategori
+string link_dokumen
+integer urutan
}
class SkInovasi {
+integer tahun
+string nomor_sk
+string tentang
+string file_path
+string file_url
+boolean is_active
+active()
+byTahun()
+latestYear()
}
class LhkpnReport {
+string nip
+string nama
+string jabatan
+year tahun
+enum jenis_laporan
+date tanggal_lapor
+string link_tanda_terima
+string link_pengumuman
+string link_spt
+string link_dokumen_pendukung
}
PaguAnggaran "1" <-- "many" RealisasiAnggaran : "belongsTo via dipa + kategori + tahun"
note for PaguAnggaran "Unique constraint on (dipa, kategori, tahun)"
```

**Diagram sources**
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [RealisasiAnggaran.php:1-46](file://app/Models/RealisasiAnggaran.php#L1-L46)
- [Inovasi.php:1-25](file://app/Models/Inovasi.php#L1-L25)
- [SkInovasi.php:1-40](file://app/Models/SkInovasi.php#L1-L40)
- [create_pagu_anggaran_table.php:1-33](file://database/migrations/2026_02_10_000002_create_pagu_anggaran_table.php#L1-L33)
- [create_realisasi_anggaran_table.php:1-36](file://database/migrations/2026_02_10_000000_create_realisasi_anggaran_table.php#L1-L36)
- [update_realisasi_anggaran_add_month.php:1-30](file://database/migrations/2026_02_10_000001_update_realisasi_anggaran_add_month.php#L1-L30)
- [create_inovasi_table.php:1-30](file://database/migrations/2026_04_08_000001_create_inovasi_table.php#L1-L30)
- [create_sk_inovasi_table.php:1-34](file://database/migrations/2026_04_08_011152_create_sk_inovasi_table.php#L1-L34)

## Detailed Component Analysis

### Panggilan (Case Management)
- Purpose: Manage absent-party case data including multiple call dates, court session date, and procedural links.
- Table: panggilan_ghaib
- Fillable fields: year, case number, name, origin address, call dates, session date, PIP, letter link, and remarks.
- Attribute casting: call dates and session date as date; timestamps as datetime.
- Computed accessors: normalized date outputs for call dates and session date.
- Indexes: year and case number indexed for fast filtering.
- Validation rules: enforced at controller level; typical constraints include non-empty case number, valid date ranges, and optional links.
- Business logic: supports case tracking across multiple stages; optional fields accommodate missing data.
- Lifecycle hooks: none defined; rely on timestamps managed by Eloquent.
- Serialization: defaults to array; accessors ensure consistent date formatting.
- Relationships: no foreign keys in current model; can be extended to link to related entities (e.g., case metadata).
- Polymorphic relationships: not used here; can be introduced later for shared behaviors.
- Common queries:
  - Filter by year and case number.
  - Sort by session date or latest update.
- Data transformations: date accessor normalization ensures consistent output format.
- Performance considerations: index on case number and year improves search performance.

**Section sources**
- [Panggilan.php:1-55](file://app/Models/Panggilan.php#L1-L55)
- [create_panggilan_ghaib_table.php:1-42](file://database/migrations/2026_01_21_000001_create_panggilan_ghaib_table.php#L1-L42)

### RealisasiAnggaran (Budget Execution Tracking)
- Purpose: Track monthly budget execution against master pagu per DIPA and category.
- Table: realisasi_anggaran
- Fillable fields: DIPA, category, month, pagu, realisasi, sisa, persentase, tahun, keterangan, link_dokumen.
- Attribute casting: numeric fields as floats; year and month as integers.
- Relationship: belongsTo PaguAnggaran via composite keys (dipa, kategori, tahun).
- Validation rules: ensure numeric values are non-negative; month within 1–12; unique combination per period.
- Business logic: computes remaining balance and percentage based on pagu and realisasi.
- Lifecycle hooks: none defined; calculations can be centralized in accessors or observers.
- Serialization: defaults to array; numeric casts ensure consistent representation.
- Polymorphic relationships: not used; belongsTo relationship is straightforward.
- Common queries:
  - Monthly summary per DIPA and category.
  - Yearly totals grouped by category.
  - Trend analysis across months.
- Data transformations: numeric casting ensures precision; computed fields can be exposed via accessors.
- Performance considerations: index on dipa and additional composite indexes on (dipa, tahun, kategori) can improve join performance.

**Section sources**
- [RealisasiAnggaran.php:1-46](file://app/Models/RealisasiAnggaran.php#L1-L46)
- [create_realisasi_anggaran_table.php:1-36](file://database/migrations/2026_02_10_000000_create_realisasi_anggaran_table.php#L1-L36)
- [update_realisasi_anggaran_add_month.php:1-30](file://database/migrations/2026_02_10_000001_update_realisasi_anggaran_add_month.php#L1-L30)
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [create_pagu_anggaran_table.php:1-33](file://database/migrations/2026_02_10_000002_create_pagu_anggaran_table.php#L1-L33)

### PaguAnggaran (Master Budget)
- Purpose: Store approved budget amounts per DIPA, category, and year.
- Table: pagu_anggaran
- Fillable fields: DIPA, category, jumlah_pagu, tahun.
- Attribute casting: jumlah_pagu as decimal with 2 decimals; tahun as integer.
- Mutators/accessors: jumlah_pagu stored as string to prevent overflow; returned as float for calculations.
- Unique constraint: (dipa, kategori, tahun) ensures single budget per category per year per DIPA.
- Validation rules: non-empty DIPA and category; positive jumlah_pagu; unique constraint enforced at persistence layer.
- Business logic: serves as the authoritative budget source for RealisasiAnggaran.
- Lifecycle hooks: none defined; integrity ensured via schema and mutator.
- Serialization: numeric fields serialized as numbers; string storage avoids precision loss.
- Polymorphic relationships: not used; standalone master record.
- Common queries:
  - Lookup pagu by DIPA and category for a given year.
  - Cross-year comparison per DIPA and category.
- Data transformations: mutator/accessor pair ensures safe numeric handling.
- Performance considerations: unique index on (dipa, kategori, tahun) supports fast lookups.

**Section sources**
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [create_pagu_anggaran_table.php:1-33](file://database/migrations/2026_02_10_000002_create_pagu_anggaran_table.php#L1-L33)

### LhkpnReport (Asset Declarations)
- Purpose: Record asset declaration reports with supporting document links.
- Table: lhkpn_reports
- Fillable fields: NIP, name, position, tahun, jenis_laporan, tanggal_lapor, and multiple document links.
- Attribute casting: tahun as integer; tanggal_lapor as date.
- Enum type: jenis_laporan restricted to predefined values; migration updates enum to standardize report types.
- Validation rules: enforce enum membership; ensure valid dates and optional URLs.
- Business logic: tracks submission date and maintains links to official receipts, announcements, and supporting documents.
- Lifecycle hooks: none defined; relies on timestamps.
- Serialization: defaults to array; enum values persisted as strings.
- Polymorphic relationships: not used; straightforward record model.
- Common queries:
  - List submissions per year and report type.
  - Search by NIP and report type.
- Data transformations: enum normalization ensures consistent values across migrations.
- Performance considerations: index on NIP improves lookup performance.

**Section sources**
- [LhkpnReport.php:1-28](file://app/Models/LhkpnReport.php#L1-L28)
- [create_lhkpn_reports_table.php:1-36](file://database/migrations/2026_02_02_162040_create_lhkpn_reports_table.php#L1-L36)
- [update_lhkpn_reports_add_links.php:1-30](file://database/migrations/2026_02_10_000003_update_lhkpn_reports_add_links.php#L1-L30)
- [rename_spt_to_lhkasn.php:1-31](file://database/migrations/2026_02_10_000004_rename_spt_to_lhkasn.php#L1-L31)

### Innovation Management Models

#### Inovasi (Innovation Tracking)
- Purpose: Record and manage organizational innovations with categorization, documentation, and ordering.
- Table: inovasi
- Fillable fields: nama_inovasi, deskripsi, kategori, link_dokumen, urutan.
- Attribute casting: urutan as integer; timestamps as datetime.
- Unique constraints: combination of nama_inovasi and kategori prevents duplicate innovations within the same category.
- Indexes: kategori indexed for fast filtering; unique composite index on (nama_inovasi, kategori).
- Validation rules: nama_inovasi required and max 255 chars; deskripsi required; kategori required and max 100 chars; urutan nullable integer >= 0; link_dokumen nullable URL up to 500 chars.
- Business logic: supports innovation categorization and ordering; handles document uploads for innovation details.
- Lifecycle hooks: none defined; relies on timestamps managed by Eloquent.
- Serialization: defaults to array; integer casting ensures proper numeric representation.
- Polymorphic relationships: not used; standalone innovation record.
- Common queries:
  - Filter by category: `$inovasi = Inovasi::where('kategori', $kategori)->get();`
  - Get ordered innovations: `$inovasi = Inovasi::orderBy('urutan')->orderBy('nama_inovasi')->get();`
  - Find duplicates: `$exists = Inovasi::where(['nama_inovasi' => $name, 'kategori' => $category])->first();`
- Data transformations: integer casting for urutan ensures consistent numeric handling.
- Performance considerations: unique index on (nama_inovasi, kategori) prevents duplicates; kategori index speeds up filtering.

**Section sources**
- [Inovasi.php:1-25](file://app/Models/Inovasi.php#L1-L25)
- [InovasiController.php:1-204](file://app/Http/Controllers/InovasiController.php#L1-L204)
- [create_inovasi_table.php:1-30](file://database/migrations/2026_04_08_000001_create_inovasi_table.php#L1-L30)

#### SkInovasi (Innovation Directive Management)
- Purpose: Manage official directives (SK) related to innovation programs with active status tracking and file management.
- Table: sk_inovasi
- Fillable fields: tahun, nomor_sk, tentang, file_path, file_url, is_active.
- Attribute casting: tahun as integer; is_active as boolean.
- Query scopes: active(), byTahun(), latestYear() for filtering and ordering.
- Validation rules: tahun required integer between 2000-2100; nomor_sk required up to 255 chars; tentang required; file_url optional URL; is_active boolean.
- Business logic: manages innovation directives with active status; supports both file uploads and external URLs.
- Lifecycle hooks: none defined; relies on timestamps managed by Eloquent.
- Serialization: defaults to array; boolean casting ensures proper boolean representation.
- Polymorphic relationships: not used; standalone directive record.
- Common queries:
  - Get active directives: `$directives = SkInovasi::active()->get();`
  - Filter by year: `$directives = SkInovasi::byTahun(2024)->get();`
  - Get latest year: `$latest = SkInovasi::latestYear()->first();`
- Data transformations: boolean casting for is_active ensures consistent boolean handling.
- Performance considerations: no specific indexes defined; consider adding indexes on tahun and is_active for frequent queries.

**Section sources**
- [SkInovasi.php:1-40](file://app/Models/SkInovasi.php#L1-L40)
- [SkInovasiController.php:1-162](file://app/Http/Controllers/SkInovasiController.php#L1-L162)
- [create_sk_inovasi_table.php:1-34](file://database/migrations/2026_04_08_011152_create_sk_inovasi_table.php#L1-L34)

### Supporting Models

#### PanggilanEcourt
- Purpose: Extended absent-party call tracking with additional call stage.
- Fields: similar to Panggilan with an extra call date and consistent casting.
- Indexes: none defined; consider adding indexes for frequent filters.

**Section sources**
- [PanggilanEcourt.php:1-33](file://app/Models/PanggilanEcourt.php#L1-L33)

#### AgendaPimpinan
- Purpose: Executive agenda entries with date-cast field.
- Indexes: none defined; consider adding index on date for range queries.

**Section sources**
- [AgendaPimpinan.php:1-35](file://app/Models/AgendaPimpinan.php#L1-L35)

#### LraReport
- Purpose: Reporting module entries with file and cover URLs.
- Indexes: none defined; consider adding indexes on year and type for filtering.

**Section sources**
- [LraReport.php:1-24](file://app/Models/LraReport.php#L1-L24)

#### Sakip
- Purpose: Strategic, Results, and Implementation Plan documents.
- Indexes: none defined; consider adding indexes on year and document type.

**Section sources**
- [Sakip.php:1-24](file://app/Models/Sakip.php#L1-L24)

#### AsetBmn
- Purpose: State assets inventory reports.
- Indexes: none defined; consider adding indexes on year and report type.

**Section sources**
- [AsetBmn.php:1-21](file://app/Models/AsetBmn.php#L1-L21)

## Dependency Analysis
The following diagram illustrates the primary dependency between RealisasiAnggaran and PaguAnggaran, along with the enum normalization for LhkpnReport and the new innovation management models.

```mermaid
graph LR
PA["PaguAnggaran"] --> RA["RealisasiAnggaran"]
LR["LhkpnReport"] --> LR2["Enum Normalization<br/>rename_spt_to_lhkasn"]
IN["Inovasi"] --> INCONT["InovasiController"]
SIN["SkInovasi"] --> SINCONT["SkInovasiController"]
```

**Diagram sources**
- [RealisasiAnggaran.php:1-46](file://app/Models/RealisasiAnggaran.php#L1-L46)
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [rename_spt_to_lhkasn.php:1-31](file://database/migrations/2026_02_10_000004_rename_spt_to_lhkasn.php#L1-L31)
- [Inovasi.php:1-25](file://app/Models/Inovasi.php#L1-L25)
- [SkInovasi.php:1-40](file://app/Models/SkInovasi.php#L1-L40)
- [InovasiController.php:1-204](file://app/Http/Controllers/InovasiController.php#L1-L204)
- [SkInovasiController.php:1-162](file://app/Http/Controllers/SkInovasiController.php#L1-L162)

**Section sources**
- [RealisasiAnggaran.php:1-46](file://app/Models/RealisasiAnggaran.php#L1-L46)
- [PaguAnggaran.php:1-30](file://app/Models/PaguAnggaran.php#L1-L30)
- [rename_spt_to_lhkasn.php:1-31](file://database/migrations/2026_02_10_000004_rename_spt_to_lhkasn.php#L1-L31)
- [Inovasi.php:1-25](file://app/Models/Inovasi.php#L1-L25)
- [SkInovasi.php:1-40](file://app/Models/SkInovasi.php#L1-L40)
- [InovasiController.php:1-204](file://app/Http/Controllers/InovasiController.php#L1-L204)
- [SkInovasiController.php:1-162](file://app/Http/Controllers/SkInovasiController.php#L1-L162)

## Performance Considerations
- Indexing strategy:
  - Panggilan: index on year and case number to accelerate filtering and sorting.
  - RealisasiAnggaran: index on DIPA; consider composite index on (dipa, tahun, kategori) to optimize joins.
  - LhkpnReport: index on NIP for efficient lookups.
  - **Inovasi: unique index on (nama_inovasi, kategori) prevents duplicates; kategori index speeds up filtering.**
  - **SkInovasi: consider adding indexes on tahun and is_active for frequent queries.**
- Numeric precision:
  - PaguAnggaran jumlah_pagu stored as string with accessor returning float prevents overflow while maintaining precision.
  - RealisasiAnggaran numeric fields cast to float for arithmetic operations.
  - **Inovasi urutan cast to integer ensures proper ordering.**
- Query patterns:
  - Prefer filtered queries with indexed columns.
  - Use select only required columns to reduce payload size.
  - Batch reads for trend analysis to minimize round trips.
  - **Utilize query scopes for complex filtering patterns (e.g., SkInovasi::active()).**
- Storage considerations:
  - Text fields for document links; ensure URLs are validated and sanitized at ingestion.
  - **File uploads handled through controller logic with proper validation and storage management.**

## Troubleshooting Guide
- Date casting anomalies:
  - Verify date accessor normalization for consistent output across models.
- Enum value mismatches:
  - Confirm enum normalization migration executed; ensure application logic aligns with standardized values.
- Foreign key mismatch:
  - Ensure composite keys (dipa, kategori, tahun) match between RealisasiAnggaran and PaguAnggaran.
- Numeric precision errors:
  - Validate numeric casts and ensure consistent handling of decimals across models.
- **Innovation model issues:**
  - **Verify unique constraint on (nama_inovasi, kategori) prevents duplicate entries.**
  - **Check query scopes are properly applied (active, byTahun, latestYear).**
  - **Ensure file upload validation and storage paths are correctly configured.**
- **File upload problems:**
  - **Verify storage disk configuration for public file access.**
  - **Check file size limits and MIME type validation.**
  - **Ensure proper cleanup of old files during updates.**

**Section sources**
- [Panggilan.php:35-53](file://app/Models/Panggilan.php#L35-L53)
- [rename_spt_to_lhkasn.php:1-31](file://database/migrations/2026_02_10_000004_rename_spt_to_lhkasn.php#L1-L31)
- [RealisasiAnggaran.php:37-44](file://app/Models/RealisasiAnggaran.php#L37-L44)
- [PaguAnggaran.php:16-28](file://app/Models/PaguAnggaran.php#L16-L28)
- [Inovasi.php:19-23](file://app/Models/Inovasi.php#L19-L23)
- [SkInovasi.php:20-28](file://app/Models/SkInovasi.php#L20-L28)
- [InovasiController.php:77-95](file://app/Http/Controllers/InovasiController.php#L77-L95)
- [SkInovasiController.php:48-84](file://app/Http/Controllers/SkInovasiController.php#L48-L84)

## Conclusion
The core models define a robust domain layer for case management, budget execution, asset declarations, and **innovation management**. Clear relationships, casting, and schema constraints enable reliable data operations. The addition of Inovasi and SkInovasi models enhances the system's capability to track and manage organizational innovations alongside official directives. Extending indexes and adopting consistent validation patterns will further enhance performance and maintainability across all models.