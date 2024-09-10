# MenuScanOrder

## Project Overview
MenuScanOrder is an online ordering system designed for restaurants and cafes to streamline the ordering process and reduce labor costs. Customers can scan a QR code placed on their table to view the menu and place orders, while staff can manage orders through the platform.

## Tech Stack
- **Framework**: CodeIgniter 4
- **Frontend**: Bootstrap
- **QR Code Generation**: QRCode.js
- **Database**: MySQL

## Features
1. User login functionality (supports Google login)
2. Admin interface for managing user subscriptions (create, list, edit, archive)
3. Responsive design for desktop and mobile views
4. QR code generation allowing customers to scan and access menus to place orders
5. Backend order management, enabling staff to mark orders as completed

## How to Run the Project
1. Clone this repository to your local machine:
    ```bash
    git clone https://github.com/err0rre/MenuScanOrder.git
    ```
2. Install dependencies:
    ```bash
    composer install
    ```
3. Configure the `.env` file:
    Copy `.env.example` to `.env` and configure your local environment settings such as database connection.

4. Run the project:
    ```bash
    php spark serve
    ```

5. Open `http://localhost:8080` in your browser to see the locally running application.

## CodeIgniter 4 Framework Information
This project is built on the **CodeIgniter 4** framework, which is a fast, secure, and lightweight PHP framework. For more information on the framework, visit the [official CodeIgniter documentation](https://codeigniter.com/docs).

### Important Change with index.php
`index.php` has been moved to the `public` folder for better security. Ensure your web server points to the `public` folder instead of the project root.

## Server Requirements
This project requires **PHP 8.1** or higher with the following extensions:
- intl
- mbstring
- json (enabled by default)
- mysqlnd (for MySQL)
- libcurl (for HTTP\CURLRequest)

## Acknowledgements
Special thanks to the University of Queensland for their support. Additionally, the following tools were used:
- CodeIgniter
- QRCode.js
- ChatGPT (for assistance in generating content for homepage)
- Grammarly (for grammar checking)
