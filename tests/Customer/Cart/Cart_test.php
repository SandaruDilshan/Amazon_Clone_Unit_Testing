<?php

use PHPUnit\Framework\TestCase;

class Cart_test extends TestCase {
    private $pdo;

    protected function setUp(): void {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE customer (email TEXT PRIMARY KEY, name TEXT, password TEXT)");
        $this->pdo->exec("CREATE TABLE items (id INTEGER PRIMARY KEY, category TEXT, img TEXT, itemName TEXT, price TEXT)");
        $this->pdo->exec("CREATE TABLE cart (product_id INTEGER, customer_email TEXT, PRIMARY KEY(product_id, customer_email))");

        $this->pdo->exec("INSERT INTO customer (email, name, password) VALUES ('test@example.com', 'Test User', 'password')");
        $this->pdo->exec("INSERT INTO items (id, category, img, itemName, price) VALUES (1, 'electronics', 'image.jpg', 'Test Item', '10')");
        $this->pdo->exec("INSERT INTO cart (product_id, customer_email) VALUES (1, 'test@example.com')");

        
        global $conn;
        $conn = $this->pdo;
    }

    protected function tearDown(): void {
        $this->pdo = null;
    }

    public function testCartDisplay() {
        
        $_SESSION['customer_email'] = 'test@example.com';

        ob_start();
        include dirname(__DIR__, 3) . '/Cart.php'; 
        $output = ob_get_clean();

        
        $this->assertStringContainsString('Test Item', $output);
        $this->assertStringContainsString('image.jpg', $output);
        $this->assertStringContainsString('10$', $output);
        $this->assertStringContainsString('Proceed to checkout', $output);
    }
}
