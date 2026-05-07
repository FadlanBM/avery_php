-- Database Schema for Avery Restaurant Management System
-- Generated from DBML (Corrected Version)

-- 1. Table: role
CREATE TABLE IF NOT EXISTS role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Table: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    status BOOLEAN NOT NULL DEFAULT TRUE,
    remamber VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_role_id_role FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- 3. Table: restaurant_menu_categories
CREATE TABLE IF NOT EXISTS restaurant_menu_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_by INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_restaurant_menu_categories_created_by_users FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- 4. Table: restaurant_menu
CREATE TABLE IF NOT EXISTS restaurant_menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    created_by INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    stock INT NOT NULL,
    is_available BOOLEAN NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_restaurant_menu_category_id FOREIGN KEY (category_id) REFERENCES restaurant_menu_categories(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_users_id_restaurant_menu FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- 5. Table: assets
CREATE TABLE IF NOT EXISTS assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(255) NOT NULL,
    file_size_kb INT NOT NULL,
    is_public BOOLEAN NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 6. Table: restaurant_menu_assets
CREATE TABLE IF NOT EXISTS restaurant_menu_assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_menu_id INT NOT NULL,
    assets_id INT NOT NULL,
    CONSTRAINT fk_restaurant_menu_assets_restaurant_menu_id FOREIGN KEY (restaurant_menu_id) REFERENCES restaurant_menu(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_restaurant_menu_assets_assets_id_assets FOREIGN KEY (assets_id) REFERENCES assets(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- 7. Table: restaurant_table_area
CREATE TABLE IF NOT EXISTS restaurant_table_area (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_by INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_restaurant_table_area_created_by_users FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- 8. Table: restaurant_table
CREATE TABLE IF NOT EXISTS restaurant_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_table_area_id INT NOT NULL,
    created_by INT NOT NULL,
    identity_code VARCHAR(255) NOT NULL,
    nomor_meja VARCHAR(255) NOT NULL,
    kapasitas INT NOT NULL,
    active BOOLEAN NOT NULL,
    is_use BOOLEAN NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_restaurant_table_area_id FOREIGN KEY (restaurant_table_area_id) REFERENCES restaurant_table_area(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_restaurant_table_created_by_users FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- 9. Table: payment_method
CREATE TABLE IF NOT EXISTS payment_method (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_by INT NOT NULL,
    is_active BOOLEAN NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_payment_method_created_by_users FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- 10. Table: transaction
CREATE TABLE IF NOT EXISTS transaction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NOT NULL,
    restaurant_table_id INT NOT NULL,
    payment_method_id INT NOT NULL,
    status VARCHAR(255) NOT NULL,
    transaction_date DATE NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    tax_amount DECIMAL(12,2) NOT NULL,
    status_pembayaran VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_transaction_staff_id_users FOREIGN KEY (staff_id) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_restaurant_table_id_transaction FOREIGN KEY (restaurant_table_id) REFERENCES restaurant_table(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_payment_method_id_transaction FOREIGN KEY (payment_method_id) REFERENCES payment_method(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- 11. Table: restaurant_setting
CREATE TABLE IF NOT EXISTS restaurant_setting (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    photo_profile_restorant INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_restaurant_setting_photo_profile_assets FOREIGN KEY (photo_profile_restorant) REFERENCES assets(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- 12. Table: restaurant_open_setting
CREATE TABLE IF NOT EXISTS restaurant_open_setting (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_setting_id INT NOT NULL,
    day VARCHAR(255) NOT NULL,
    is_open VARCHAR(255) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_restaurant_setting_id_restaurant_open_setting FOREIGN KEY (restaurant_setting_id) REFERENCES restaurant_setting(id) ON DELETE NO ACTION ON UPDATE NO ACTION
);
