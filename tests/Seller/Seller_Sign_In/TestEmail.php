<?php
use PHPUnit\Framework\TestCase;

class TestEmail extends TestCase {
    private $pdo;
    private $conn;

    protected function setUp(): void {
        // Set up the in-memory SQLite database
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE sellor (email TEXT PRIMARY KEY, password TEXT)");

        // Set global connection variable
        global $conn;
        $conn = $this->pdo;
    }

    protected function tearDown(): void {
        // Clean up after each test
        $this->pdo = null;
    }


    public function testEmailNotFound() {
        // Simulate POST request
        $_POST['Email'] = 'nonexistent@example.com';
        $_POST['Password'] = 'password';
        $_POST['submit'] = true;

        // Start output buffering
        ob_start();
        include dirname(__DIR__, 3) . '/sellor_login.php';
        $output = ob_get_clean();

        // Check the output for the error message
        $this->assertStringContainsString("You haven't account yet.. Create account.", $output);
    }
}
?>
