
# Project Blueprint

## Overview

This project is a full-stack web application for managing "Surat Berharga Pembangunan" (SBP) and "Petugas" (Officers). It is built with Laravel and is designed to be developed within the Firebase Studio (formerly Project IDX) environment.

## Implemented Features

### Style and Design

*   **Framework**: Bootstrap 5 (via CoreUI)
*   **Layout**: A consistent layout with a sidebar for navigation, a header, and a main content area.
*   **Views**: Blade templates for all views.
*   **UI Components**:
    *   **Dashboard**: A central dashboard with summary information.
    *   **Tables**: Styled tables for displaying data.
    *   **Forms**: Styled forms for data input.
    *   **Modals**: Modals for adding, editing, and deleting data.
    *   **Pagination**: Pagination links for navigating through large datasets.

### Features

*   **SBP Management**:
    *   Create, Read, Update, and Delete (CRUD) operations for SBP data.
    *   Data is stored in a `sbp` table in the database.
    *   The `SbpController` handles all SBP-related requests.
    *   Views for creating, editing, and displaying SBP data.
    *   **Nomor SBP Formatting**: The `nomor_sbp` is automatically formatted as `SBP-{input_number}/KBC.0102/{year}` before being stored in the database. The input form only accepts integers.
*   **Petugas Management**:
    *   CRUD operations for Petugas data.
    *   Data is stored in a `petugas` table in the database.
    *   The `PetugasController` handles all Petugas-related requests.
    *   Views for creating, editing, and displaying Petugas data.
    *   **Modal Form**: A modal form is used to add new Petugas data.
*   **Database Explorer**:
    *   A simple database explorer to view the tables in the database.
    *   The `DatabaseController` handles requests for the database explorer.

## Current Task: SBP Number Formatting

### Plan

1.  **Modify `resources/views/input-sbp.blade.php`**:
    *   Change the input type for "Nomor SBP" from `text` to `number`.
2.  **Modify `app/Http/Controllers/SbpController.php`**:
    *   In the `store` and `update` methods:
        *   Validate that `nomor_sbp` is an integer.
        *   Format the `nomor_sbp` string as `SBP-{input_number}/KBC.0102/{year}`.
        *   Validate the uniqueness of the formatted `nomor_sbp` string.
        *   Save the formatted `nomor_sbp` to the database.
    *   **FIX**: In the `edit` method, corrected the regular expression in `preg_match` to properly escape forward slashes, resolving the "Unknown modifier 'K'" error.
3.  **Modify `resources/views/edit-sbp.blade.php`**:
    *   Extract the integer part of the `nomor_sbp` and display it in the form for editing.

