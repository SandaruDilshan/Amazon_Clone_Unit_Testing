<?php

use PHPUnit\Framework\TestCase;

include './item_handler.php';

class ItemHandlerTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        // Create a mock for the mysqli object, so we can inject it into ItemHandler
        $this->conn = $this->getMockBuilder('mysqli')
                           ->disableOriginalConstructor()
                           ->getMock();

        // Set up mock methods for mysqli
        $this->conn->method('prepare')
                   ->willReturn($this->getMockBuilder('mysqli_stmt')
                                     ->disableOriginalConstructor()
                                     ->getMock());
    }

    protected function tearDown(): void {
        $this->conn = null;
    }

    public function testAddItemSuccess() {
        // Simulating form data
        $itemCatogary = 'Electronics';
        $name = 'Test Item';
        $description = 'Test Description';
        $quantity = 5;
        $price = 99.99;
        $email = 'test@example.com';

        // Simulating file upload
        $file = [
            'name' => 'test.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__ . '/test.jpg', // This file should exist for testing
            'error' => 0,
            'size' => 500
        ];

        // Injecting the mock mysqli object into ItemHandler
        $itemHandler = new ItemHandler($this->conn);

        // Testing addItem method
        $result = $itemHandler->addItem($itemCatogary, $name, $description, $quantity, $price, $email, $file);

        // Asserting the result
        $this->assertEquals("Successfully Added.", $result);
    }

    public function testAddItemInvalidImageExtension() {
        // Simulating form data
        $itemCatogary = 'Electronics';
        $name = 'Test Item';
        $description = 'Test Description';
        $quantity = 5;
        $price = 99.99;
        $email = 'test@example.com';

        // Simulating file upload
        $file = [
            'name' => 'test.txt',
            'type' => 'text/plain',
            'tmp_name' => __DIR__ . '/test.txt', // This file should exist for testing
            'error' => 0,
            'size' => 500
        ];

        // Injecting the mock mysqli object into ItemHandler
        $itemHandler = new ItemHandler($this->conn);

        // Testing addItem method
        $result = $itemHandler->addItem($itemCatogary, $name, $description, $quantity, $price, $email, $file);

        // Asserting the result
        $this->assertEquals("Invalid image extension..!", $result);
    }

    public function testAddItemLargeImageFile() {
        // Simulating form data
        $itemCatogary = 'Electronics';
        $name = 'Test Item';
        $description = 'Test Description';
        $quantity = 5;
        $price = 99.99;
        $email = 'test@example.com';

        // Simulating file upload
        $file = [
            'name' => 'test.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__ . '/test.jpg', // This file should exist for testing
            'error' => 0,
            'size' => 2000000
        ];

        // Injecting the mock mysqli object into ItemHandler
        $itemHandler = new ItemHandler($this->conn);

        // Testing addItem method
        $result = $itemHandler->addItem($itemCatogary, $name, $description, $quantity, $price, $email, $file);

        // Asserting the result
        $this->assertEquals("Image file too large..!", $result);
    }
}
