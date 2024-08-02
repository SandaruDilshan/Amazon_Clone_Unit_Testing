<?php
    use PHPUnit\Framework\TestCase;

    class TestEmail extends TestCase {
        private $pdo;

        protected function setUp(): void {
            $this->pdo = new PDO('sqlite::memory:');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("CREATE TABLE customer (email TEXT PRIMARY KEY, name TEXT, password TEXT)");

            $stmt = $this->pdo->prepare("INSERT INTO customer (email, name, password) VALUES (?, ?, ?)");
            $stmt->execute(['test@example.com', 'Test User', password_hash('password', PASSWORD_BCRYPT)]);
        }

        protected function tearDown(): void {
            $this->pdo = null;
        }

        public function testEmailDoesNotExist() {
            $_POST['email'] = 'nonexistent@example.com';
            $_POST['password'] = 'password';
            $_POST['submit'] = true;

            ob_start();
            include dirname(__DIR__, 3) . '/sign_in.php';
            $output = ob_get_clean();

            $this->assertStringContainsString("Email does not exist.", $output);
        }  
    }
?>
