CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_summary TEXT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
