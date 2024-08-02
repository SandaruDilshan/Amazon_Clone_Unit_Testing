<?php
    use PHPUnit\Framework\TestCase;

    class TestPassword extends TestCase {
        private $pdo;

        protected function setUp(): void {
            $this->pdo = new PDO('sqlite::memory:');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("CREATE TABLE customer (email TEXT PRIMARY KEY, name TEXT, password TEXT)");

            // Insert a test user
            $stmt = $this->pdo->prepare("INSERT INTO customer (email, name, password) VALUES (?, ?, ?)");
            $stmt->execute(['test@example.com', 'Test User', password_hash('password', PASSWORD_BCRYPT)]);
        }

        protected function tearDown(): void {
            $this->pdo = null;
        }
        public function testIncorrectPassword() {
            $_POST['email'] = 'test@example.com';
            $_POST['password'] = 'wrongpassword';
            $_POST['submit'] = true;

            ob_start();
            include dirname(__DIR__, 3) . '/sign_in.php';
            $output = ob_get_clean();

            $this->assertStringContainsString("Email does not exist.", $output); // Adjust this if you have a different message for wrong passwords.
        }
    }
?>
