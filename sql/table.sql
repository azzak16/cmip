SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS sales_orders;
CREATE TABLE sales_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    karat_id INT NOT NULL,
    production_code VARCHAR(50) UNIQUE,
    order_number VARCHAR(50) UNIQUE,
    order_date DATE,
    payment_terms VARCHAR(255) NULL,
    delivery_plan VARCHAR(255) NULL,
    manager_production VARCHAR(100) NULL,
    ppic VARCHAR(100) NULL,
    head_sales VARCHAR(100) NULL,
    order_recipient VARCHAR(100) NULL,
    notes TEXT NULL,
    status VARCHAR(50) NULL,
    deleted_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(NO_ID),
    FOREIGN KEY (karat_id) REFERENCES karat(NO_ID)
);

DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(100) UNIQUE NULL,
    color VARCHAR(100) NULL,
    type VARCHAR(100) NULL,
    karat_id INT NOT NULL,
    qty INT DEFAULT 0,
    min_qty INT DEFAULT 0,
    notes TEXT NULL,
    status VARCHAR(50) NULL,
    deleted_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (karat_id) REFERENCES karat(NO_ID)
);

DROP TABLE IF EXISTS sales_order_items;
CREATE TABLE sales_order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sales_order_id INT NOT NULL,
    product_id INT NULL,
    product_desc VARCHAR(50) NULL,
    ukuran_pcs VARCHAR(50) NULL,
    panjang_pcs VARCHAR(50) NULL,
    gram_pcs DECIMAL(10,2) DEFAULT 0,
    batu_pcs VARCHAR(50) NULL,
    tok_pcs VARCHAR(50) NULL,
    color VARCHAR(50) NULL,
    karat VARCHAR(10) NULL,
    pcs INT DEFAULT 0,
    pairs INT DEFAULT 0,
    gram DECIMAL(10,2) DEFAULT 0,
    notes TEXT NULL,
    status VARCHAR(50) NULL,
    deleted_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sales_order_id) REFERENCES sales_orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE `sales_order_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `sales_order_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `sales_order_id` (`sales_order_id`),
  CONSTRAINT `sales_order_images_ibfk_1` FOREIGN KEY (`sales_order_id`) REFERENCES `sales_orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;