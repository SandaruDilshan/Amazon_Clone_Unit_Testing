<?php
use PHPUnit\Framework\TestCase;

class Login_success extends TestCase {
    private $pdo;
    private $conn;

    protected function setUp(): void {
        
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE sellor (email TEXT PRIMARY KEY, password TEXT)");

        global $conn;
        $conn = $this->pdo;
    }

    protected function tearDown(): void {
       
        $this->pdo = null;
    }

    public function testSuccessfulLogin() {
        
        $this->pdo->exec("INSERT INTO sellor (email, password) VALUES ('test@example.com', '" . password_hash('password', PASSWORD_BCRYPT) . "')");

        
        $_POST['Email'] = 'test@example.com';
        $_POST['Password'] = 'password';
        $_POST['submit'] = true;

        ob_start();
        include dirname(__DIR__, 3) . '/sellor_login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString("Login successful.", $output);
    }
}
?>
