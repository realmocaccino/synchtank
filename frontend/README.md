# Vue.js Application

A modern Vue 3 frontend for managing tracks, built with Vite, Pinia, and Tailwind CSS. It communicates with a Symfony REST API for CRUD operations on tracks.

## Access URLs

If using Docker: http://localhost:5173

If installed manually: http://localhost:3000/

## Project Structure

| Path | Description |
|------|-------------|
| `src/components/` | Vue components |
| `src/components/TrackForm.vue` | Form for adding/editing tracks |
| `src/components/TrackList.vue` | List display of tracks |
| `src/stores/` | Pinia stores (state management) |
| `src/services/` | API services (axios wrapper, API endpoints) |
| `src/utils/` | Helper functions |
| `src/utils/formatting.js` | Data formatting utilities |
| `src/utils/validators.js` | Input validation functions |
| `src/views/` | Page components / Views |
| `src/App.vue` | Root Vue component |