# Backend API

## Endpoints

| Method | Endpoint             | Description |
|--------|--------------------|-------------|
| GET    | `/api/tracks`       | List all tracks |
| POST   | `/api/tracks`       | Create a new track |
| PUT    | `/api/tracks/{id}`  | Update an existing track |

## Request Examples

```bash
# Request 1
curl -X GET "http://localhost:8000/api/tracks" \
     -H "Accept: application/json"

# Response
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "title": "Song A",
      "artist": "Artist X",
      "duration": 210,
      "isrc": "US-ABC-23-00123",
      "createdAt": "2026-03-04T18:00:00+00:00",
      "updatedAt": "2026-03-04T18:10:00+00:00"
    }
  ]
}
# End of Response

# Request 2
curl -X POST "http://localhost:8000/api/tracks" \
     -H "Accept: application/json" \
     -H "Content-Type: application/json" \
     -d '{
           "title": "New Song",
           "artist": "Artist Y",
           "duration": 180,
           "isrc": "US-DEF-23-00234"
         }'

# Response
{
  "status": "success",
  "message": "Track created successfully",
  "data": {
    "id": 2,
    "title": "New Song",
    "artist": "Artist Y",
    "duration": 180,
    "isrc": "US-DEF-23-00234",
    "createdAt": "2026-03-04T18:15:00+00:00",
    "updatedAt": "2026-03-04T18:15:00+00:00"
  }
}
# End of Response
```

## Validation Rules

- `title` and `artist` cannot be blank.
- `duration` must be a positive integer (0–5999 seconds) and input is `mm:ss` in the frontend.
- `isrc` must follow the pattern: `XX-XXX-XX-XXXXX`.

## Track Model

Tracks have the following fields:

| Field     | Type    | Required | Notes |
|-----------|---------|---------|-------|
| id        | int     | auto    | Auto-incremented |
| title     | string  | yes     | Track title |
| artist    | string  | yes     | Artist name |
| duration  | int     | yes     | In seconds |
| isrc      | string  | no      | Must match `XX-XXX-XX-XXXXX` (e.g., `US-ABC-23-00123`) |