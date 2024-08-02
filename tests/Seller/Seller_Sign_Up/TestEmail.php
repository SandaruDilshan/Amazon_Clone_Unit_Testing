<?php
use PHPUnit\Framework\TestCase;

class TestEmail extends TestCase {
    private $pdo;
    private $conn;

    protected function setUp(): void {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE user (email TEXT PRIMARY KEY, name TEXT, password TEXT)");
        $this->pdo->exec("CREATE TABLE sellor (email TEXT PRIMARY KEY, name TEXT, addres TEXT, country TEXT, password TEXT)");

        // Replace $conn with PDO instance
        global $conn;
        $conn = $this->pdo;
    }

    protected function tearDown(): void {
        $this->pdo = null;
    }

    public function testEmailAlreadyExists() {
        $this->pdo->exec("INSERT INTO user (email, name, password) VALUES ('test@example.com', 'Test User', 'password')");

        $_POST['Name'] = 'Test User';
        $_POST['Email'] = 'test@example.com';
        $_POST['Address'] = '123 Test St';
        $_POST['Country'] = 'Testland';
        $_POST['Password'] = 'password';
        $_POST['Password_confirmation'] = 'password';
        $_POST['submit'] = true;

        ob_start();
        include dirname(__DIR__, 3) . '/sellor_sign_up.php';
        $output = ob_get_clean();

        $this->assertStringContainsString("Email already exists.", $output);
    }

}
?>
