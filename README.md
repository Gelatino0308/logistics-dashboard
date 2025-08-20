# PROX

PROX is an AI-Powered Proximity Alert System designed for warehouse deliveries. It provides real-time distance calculations and proximity alerts to help logistics managers monitor delivery locations relative to warehouse positions, ensuring efficient delivery operations and enhanced security monitoring.

## Features

### Proximity Analysis
- Interactive map interface with click-to-set delivery locations
- Real-time distance calculation between warehouse and delivery points
- Customizable alert radius settings (100m, 250m, 500m)
- Visual proximity indicators with color-coded alerts
- Coordinate input validation and error handling

### Dashboard Interface
- Proximity check form with intuitive controls
- Live map visualization with warehouse and delivery markers
- Results display with success/error status indicators
- Alert history and logging system

### Alert Management
- Automated proximity status detection
- Alert logging with timestamp and location data

## Technologies Used

### Backend
- **Laravel 12** 
- **PHP 8.2** 
- **MySQL 8.0** 

### Frontend
- **Blade Templates** 
- **JavaScript (ES6+)**
- **Tailwind CSS v4**
- **BladeWind UI Components**
- **Blade-ui-kit Icons**
- **Leaflet.js** 
- **OpenStreetMap**

### Development Environment
- **Composer** 
- **Node.js & NPM** 
- **XAMPP** 

## Setup Steps

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL 8.0 or higher
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Gelatino0308/logistics-dashboard
   cd logistics-dashboard
   ```
2. **Install PHP dependencies**
   ```bash
   composer install
   ```
3. **Install Node.js dependencies**
   ```bash
   npm install
   ```
4. **Environment setup**
   ```bash
   cp .env.example .env
   ```
5. **Configure your .env file**
   ```bash
   APP_NAME=PROX
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=prox_db
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
6. **Generate application key**
   ```bash
   php artisan key:generate
   ```

7. **Create database**
- Create a MySQL database named prox_db
- Update your .env file with the correct database credentials

8. Run database migrations
   ```bash
   php artisan migrate:fresh
   ```
9. Create storage symlink
   ```bash
   php artisan storage:link
   ```
10. Compile frontend assets
   ```bash
   npm run build
   ```
11. Start the development server
   ```bash
   php artisan serve
   ```
12. Access the application
   ```bash
   Open your browser and visit http://localhost:8000
   ```

### API Integration
This project utilizes a Flask-based proximity calculation API that has been deployed on Render. The API handles the mathematical calculations for distance measurements and proximity analysis.

- **API Repository**: https://github.com/Gelatino0308/flask-proximity-api.

- **Deployed Service**: The Flask API is hosted on Render (https://flask-proximity-api-53t9.onrender.com/check_proximity) and provides real-time proximity calculations. 

- **Integration**: The Laravel application communicates with this external API to perform distance calculations between warehouse and delivery coordinates.