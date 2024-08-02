<?php
    use PHPUnit\Framework\TestCase;
    class TestEmail extends TestCase {
        private $pdo;

        protected function setUp(): void {
            $this->pdo = new PDO('sqlite::memory:');   // PDO -> PHP Data Objects
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("CREATE TABLE customer (email TEXT PRIMARY KEY, name TEXT, password TEXT)");
        }

        protected function tearDown(): void {
            $this->pdo = null;
        }

        public function testEmailAlreadyExists() {
            $this->pdo->exec("INSERT INTO customer (email, name, password) VALUES ('test@example.com', 'Test User', 'password')");
            
            $_POST['email'] = 'test@example.com';
            $_POST['name'] = 'Test Use';
            $_POST['password'] = 'password';
            $_POST['password_confirmation'] = 'password2';
            $_POST['submit'] = true;

            ob_start();
            include dirname(__DIR__, 3) . '/sign_up.php';
            $output = ob_get_clean();

            $this->assertStringContainsString("Email already exists.", $output);
        }
    }
?>