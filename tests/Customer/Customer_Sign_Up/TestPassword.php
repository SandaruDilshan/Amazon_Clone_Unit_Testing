<?php
    use PHPUnit\Framework\TestCase;
    class TestPassword extends TestCase {
        private $pdo;

        protected function setUp(): void {
            $this->pdo = new PDO('sqlite::memory:');   // PDO -> PHP Data Objects
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("CREATE TABLE customer (email TEXT PRIMARY KEY, name TEXT, password TEXT)");
        }

        protected function tearDown(): void {
            $this->pdo = null;
        }
        public function testPasswordsDontMatch() {
            $_POST['email'] = 'test@example.com';
            $_POST['name'] = 'Test User';
            $_POST['password'] = 'password1';
            $_POST['password_confirmation'] = 'password1';
            $_POST['submit'] = true;

            ob_start();
            include dirname(__DIR__, 3) . '/sign_up.php';
            $output = ob_get_clean();

            $this->assertStringContainsString("Your passwords don't match..!", $output);
        }
    }
?>