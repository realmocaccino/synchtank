# Synchtank - Manage your music collection

![Synchtank screenshot](https://luizgustavomartins.com/download/synchtank.png)

Synchtank is a small web application to manage music tracks. The app allows you to list, create, and edit tracks. It consists of:

- **Backend:** REST API built with Symfony 6
- **Frontend:** Vue 3 application using Tailwind CSS

## Docker Installation

#### Prerequisites

*   Docker
    
*   Docker Compose
    

#### Installation Steps

1. git clone git@github.com:realmocaccino/synchtank.git

2. cd synchtank
    
3. docker-compose up -d --build

## Manual Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL/PostgreSQL (8.0/13+)
- Node.js 16+ and npm

### Clone the Repository
git clone git@github.com:realmocaccino/synchtank.git

### Set Up Backend

```bash
# Navigate to backend directory
cd backend

# Install PHP dependencies
composer install

# Create environment file
cp .env .env.local

# Edit .env.local with your database credentials
DATABASE_URL="mysql://username:password@127.0.0.1:3306/database_name"

# Create database
php bin/console doctrine:database:create

# Run migrations
php bin/console doctrine:migrations:migrate

# Start Symfony server
symfony serve
```

### Set Up Frontend

```bash
# Open a new terminal
cd frontend

# Install Node dependencies
npm install

# Start development server
npm run dev
```