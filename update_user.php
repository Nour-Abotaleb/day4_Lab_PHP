<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "user_registration");

$dsn = 'mysql:dbname='.DB_DATABASE.';host='.DB_HOST.';port=3307;';

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        $gender = $_POST['gender'];
        $skills = isset($_POST['skills']) ? implode("-", $_POST['skills']) : '';
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, address = ?, country = ?, gender = ?, skills = ?, username = ?, password = ? WHERE id = ?");
        $stmt->execute([$first_name, $last_name, $address, $country, $gender, $skills, $username, $password, $id]);

        echo "User updated successfully.";
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
