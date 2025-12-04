# LIVVRA - E-Commerce Website

## Overview
LIVVRA is a complete e-commerce website for Dr Tridosha Herbotech Pvt Ltd, built using pure PHP. The website features Ayurvedic and herbal health products with a premium gold and green color scheme matching the LIVVRA brand.

## Project Structure
```
├── includes/
│   ├── config.php       # Site configuration, products data, helper functions
│   ├── header.php       # Common header with navigation
│   └── footer.php       # Common footer
├── public/
│   ├── index.php        # Homepage with 12 sections
│   ├── products.php     # Product catalog with filtering
│   ├── product-detail.php # Individual product page
│   ├── cart.php         # Shopping cart
│   ├── about.php        # About Us page
│   ├── contact.php      # Contact page with Google Maps
│   ├── ajax/            # AJAX handlers for cart operations
│   └── assets/
│       ├── css/         # Stylesheets
│       │   ├── style.css     # Main styles
│       │   └── animations.css # Animation styles
│       ├── js/          # JavaScript files
│       │   └── main.js  # Main JavaScript
│       └── images/      # Images (logo, products, banners)
```

## Features
- **Stunning Animated Hero Section** with 3D effects and floating elements
- **12 Homepage Sections**: Hero, Categories, Featured Products, Benefits, About Preview, Testimonials, Video, Why Choose Us, Special Offers, Newsletter, Google Maps, Footer
- **Product Catalog** with category filtering
- **Shopping Cart** with session-based management
- **Responsive Design** for all devices
- **LIVVRA Branding** with gold (#C9A227) and green (#4A7C59) colors

## Company Information
- **Company**: Dr Tridosha Herbotech Pvt Ltd
- **Brand**: LIVVRA
- **Tagline**: Live Better Live Strong
- **Address**: Sco no 27, Second Floor, Phase 3, Model Town, Bathinda 151001
- **Email**: livvraindia@gmail.com

## Running the Server
The website runs on PHP's built-in development server on port 5000:
```bash
cd public && php -S 0.0.0.0:5000
```

## Product Categories
1. Skin Care
2. Gym Foods
3. Men's Health
4. Weight Management
5. Heart Care
6. Daily Wellness
7. Ayurvedic Juices
8. Blood Sugar & Chronic Care

## Recent Changes
- December 4, 2025: Initial website creation with all pages and features
