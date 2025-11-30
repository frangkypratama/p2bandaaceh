# Blueprint: P2 Banda Aceh

## Project Overview

This project is a full-stack web application for P2 Banda Aceh, built using the Laravel framework. The goal is to create a modern, robust, and scalable application with a consistent and professional user interface using the CoreUI library.

## Implemented Features & Design

This section documents all the features and design choices implemented in the application, from the initial version to the current one.

### Version 1.0: Initial Setup

#### Core Features

*   **Version Control Integration:**
    *   Initialized a local Git repository.
    *   Connected the project to a private GitHub repository: `frangkypratama/p2bandaaceh`.
*   **Automated Development Workflow:**
    *   Established an automated workflow where Gemini (the AI assistant) handles all Git commands (`git add`, `git commit`, `git push`) after making code changes.
*   **Documentation:**
    *   Created and maintain a `blueprint.md` file to track project progress, features, and design decisions.

## Current Task: Integrate CoreUI Library

*   **Goal:** Replace the default frontend styling with the CoreUI library to build a modern and consistent user interface.
*   **Plan:**
    *   [ ] Install the `@coreui/coreui` npm package and its dependencies.
    *   [ ] Configure Vite to compile CoreUI's Sass and JavaScript assets.
    *   [ ] Create a main Blade layout (`layouts/app.blade.php`) with the CoreUI structure (sidebar, header, footer).
    *   [ ] Update the welcome page to use the new CoreUI layout and display sample components.
