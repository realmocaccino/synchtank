## Backend API

### Endpoints

| Method | Endpoint             | Description |
|--------|--------------------|-------------|
| GET    | `/api/tracks`       | List all tracks |
| POST   | `/api/tracks`       | Create a new track |
| PUT    | `/api/tracks/{id}`  | Update an existing track |

### Track Model

Tracks have the following fields:

| Field     | Type    | Required | Notes |
|-----------|---------|---------|-------|
| id        | int     | auto    | Auto-incremented |
| title     | string  | yes     | Track title |
| artist    | string  | yes     | Artist name |
| duration  | int     | yes     | In seconds |
| isrc      | string  | no      | Must match `XX-XXX-XX-XXXXX` (e.g., `US-ABC-23-00123`) |

### Validation Rules

- `title` and `artist` cannot be blank.
- `duration` must be a positive integer (0–5999 seconds) and input is `mm:ss` in the frontend.
- `isrc` must follow the pattern: `XX-XXX-XX-XXXXX`.