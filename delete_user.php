<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "user_registration");

$dsn = 'mysql:dbname='.DB_DATABASE.';host='.DB_HOST.';port=3307;';

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        echo "User deleted successfully.";
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
