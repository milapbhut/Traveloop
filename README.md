# Traveloop PHP/MySQL

Traveloop is a PHP travel planning application built from the supplied PDF requirements and wireframe image. It includes login/signup, dashboard, trip creation, trip list, itinerary builder, itinerary view, city and activity search, budget breakdown, packing checklist, public sharing, profile settings, trip notes, admin analytics, and expense invoice pages.

## Run Locally With XAMPP PHP

```powershell
C:\xampp\php\php.exe -S 127.0.0.1:8080 -t public public/index.php
```

Open:

```text
http://127.0.0.1:8080
```

The app shows demo data if MySQL is not connected.

## MySQL Setup

Start MySQL from XAMPP, then import the schema and seed data:

```powershell
C:\xampp\mysql\bin\mysql.exe -u root < database\schema.sql
C:\xampp\mysql\bin\mysql.exe -u root traveloop < database\seed.sql
```

Default database settings are in `config/database.php` and match a standard XAMPP MySQL install:

```text
host: 127.0.0.1
port: 3306
database: traveloop
user: root
password: empty
```

## Project Structure

```text
app/
  Controllers/PageController.php
  Core/Database.php
  Core/Router.php
  Core/View.php
  Models/TravelRepository.php
  Views/
config/database.php
database/schema.sql
database/seed.sql
public/index.php
public/assets/
```

Use `public/` as the web root in Apache, or run the PHP built-in server command above.
