<?php
use PHPUnit\Framework\TestCase;

class TestRecord extends TestCase {
    private $pdo;
    private $conn;

    protected function setUp(): void {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE user (email TEXT PRIMARY KEY, name TEXT, password TEXT)");
        $this->pdo->exec("CREATE TABLE sellor (email TEXT PRIMARY KEY, name TEXT, addres TEXT, country TEXT, password TEXT)");

        global $conn;
        $conn = $this->pdo;

        define('PHPUNIT_RUNNING', true); // Define the constant
    }

    protected function tearDown(): void {
        $this->pdo = null;
    }

    public function testNewRecordAddedSuccessfully() {
        $_POST['Name'] = 'New User';
        $_POST['Email'] = 'newuser@example.com';
        $_POST['Address'] = '123 New St';
        $_POST['Country'] = 'Newland';
        $_POST['Password'] = 'password';
        $_POST['Password_confirmation'] = 'password';
        $_POST['submit'] = true;

        ob_start();
        include dirname(__DIR__, 3) . '/sellor_sign_up.php';
        $output = ob_get_clean();

        $stmt = $this->pdo->query("SELECT COUNT(*) FROM sellor WHERE email = 'newuser@example.com'");
        $count = $stmt->fetchColumn();

        $this->assertEquals(1, $count);
        $this->assertStringContainsString("New record added successfully", $output);
    }
}
?>
