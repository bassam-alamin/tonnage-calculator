#  Edible Oil Tonnage Calculator

A simple Laravel web application that calculates the tonnage (MT) of edible oil based on user-submitted volume, density, and temperature using a Volume Correction Factor (VCF) from a lookup table.

---

## Features

- Input form for Volume (litres), Density (kg/m³), and Temperature (°C)
- Dynamically retrieves VCF from the vcftable
- Calculates Tonnage (MT) using the formula:  
  Tonnage = (Volume × Density × VCF) / 1000
- Stores each calculation in the oil_tonnages table
- Displays calculated tonnage, VCF used, and a summary
- Searchable and paginated history of past calculations
- Bootstrap styling
- Form validation with descriptive error messages

---

## Installation Instructions

### 1. Database Setup

- create MySQL database
- Create a table called table60b (This is where the query from  vcftable.sql will insert the vcf values )
    - Run the following command on PHPMyAdmin or DBeaver
 ```bash
      CREATE TABLE `table60b` (
    `id` INT PRIMARY KEY,
    `density` INT NOT NULL,
    `temperature` INT NOT NULL,
    `vcf` DECIMAL(6,4) NOT NULL,
    `class` VARCHAR(50),        
    `vcf2` DECIMAL(6,4)          
);
```

- Import the vcftable.sql file on the database

### 2. Clone and Setup Project
```bash
git clone https://github.com/yourusername/oil-tonnage-calculator.git
cd oil-tonnage-calculator
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

```

<img width="1897" height="976" alt="image" src="https://github.com/user-attachments/assets/ecb30d51-1001-4a52-864d-5177ec845e64" />


