<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "user_registration");

$dsn = 'mysql:dbname='.DB_DATABASE.';host='.DB_HOST.';port=3307;';

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        $gender = $_POST['gender'];
        $skills = isset($_POST['skills']) ? implode("-", $_POST['skills']) : '';
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $department = 'OpenSource';

        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_path = 'uploads/' . basename($_FILES['image']['name']);
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                echo "Sorry, there was an error uploading your file.";
                exit();
            }
        }

        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, address, country, gender, skills, username, password, department, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$first_name, $last_name, $address, $country, $gender, $skills, $username, $password, $department, $image_path]);

        echo "<p>Registration successful!</p>";
        echo "<p><a href='login.php'>Go to Login</a></p>";
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
