<?php

use PHPUnit\Framework\TestCase;
function fetchItemsByCategory($conn, $category) {
    $category = mysqli_real_escape_string($conn, $category);  
    $sql = "SELECT * FROM `items` WHERE `category` = '$category'";
    return mysqli_query($conn, $sql);
}

class Fetch_items extends TestCase {
    private $pdo;

    protected function setUp(): void {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE items (id INTEGER PRIMARY KEY, category TEXT, img TEXT, itemName TEXT, price TEXT)");

        $stmt = $this->pdo->prepare("INSERT INTO items (category, img, itemName, price) VALUES (?, ?, ?, ?)");
        $stmt->execute(['electronics', 'image.jpg', 'Test Item', '$10.00']);
    }

    protected function tearDown(): void {
        $this->pdo = null;
    }


    public function testFetchItemsByCategory() {
        $conn = new mysqli('localhost', 'root', '', 'test_amazon'); // Replace with your test DB connection details
        $category = 'electronics';

        // Mock the fetchItemsByCategory function to use the SQLite memory database
        $result = fetchItemsByCategory($conn, $category);

        $this->assertNotFalse($result);
        $this->assertEquals(1, $result->num_rows);

        $item = $result->fetch_assoc();
        $this->assertEquals('electronics', $item['category']);
        $this->assertEquals('image.jpg', $item['img']);
        $this->assertEquals('Test Item', $item['itemName']);
        $this->assertEquals('$10.00', $item['price']);
    }
}
