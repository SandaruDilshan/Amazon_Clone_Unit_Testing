<?php
    use PHPUnit\Framework\TestCase;
    class TestRecordAdd extends TestCase {
        private $pdo;

        protected function setUp(): void {
            $this->pdo = new PDO('sqlite::memory:');   // PDO -> PHP Data Objects
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("CREATE TABLE customer (email TEXT PRIMARY KEY, name TEXT, password TEXT)");
        }

        protected function tearDown(): void {
            $this->pdo = null;
        }

        public function testNewRecordAddedSuccessfully() {
            $_POST['email'] = 'newuser@example.com';
            $_POST['name'] = 'New User';
            $_POST['password'] = 'password';
            $_POST['password_confirmation'] = 'password';
            $_POST['submit'] = true;

            ob_start();
            include dirname(__DIR__ ,3) . '/sign_up.php';
            $output = ob_get_clean();

            $stmt = $this->pdo->query("SELECT COUNT(*) FROM customer WHERE email = 'newuser@example.com'");
            $count = $stmt->fetchColumn();

            $this->assertEquals(1, $count);
            $this->assertStringContainsString("New record added successfully.", $output);
        }
    }
?>