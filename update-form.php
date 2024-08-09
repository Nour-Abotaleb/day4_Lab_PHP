<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
        $department = $_POST['department'];
        $image_path = ''; 

        if ($id) {
           
            $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, address = ?, country = ?, gender = ?, skills = ?, username = ?, department = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$first_name, $last_name, $address, $country, $gender, $skills, $username, $department, $image_path, $id]);
            echo "User updated successfully.";
        }

        header("Location: listusers.php");
        exit();
    } else {
       
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>
    <h2><?php echo isset($user) ? "Update User" : "Register New User"; ?></h2>
    <form method="post" action="listusers.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ''; ?>">
        <label>First Name: <input type="text" name="first_name" value="<?php echo isset($user['first_name']) ? $user['first_name'] : ''; ?>"></label><br>
        <label>Last Name: <input type="text" name="last_name" value="<?php echo isset($user['last_name']) ? $user['last_name'] : ''; ?>"></label><br>
        <label>Address: <input type="text" name="address" value="<?php echo isset($user['address']) ? $user['address'] : ''; ?>"></label><br>
        <label>Country: <input type="text" name="country" value="<?php echo isset($user['country']) ? $user['country'] : ''; ?>"></label><br>
        <label>Gender: 
            <select name="gender">
                <option value="Male" <?php echo (isset($user['gender']) && $user['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo (isset($user['gender']) && $user['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>
        </label><br>
        <label>Skills: 
            <input type="checkbox" name="skills[]" value="PHP" <?php echo (isset($user['skills']) && strpos($user['skills'], 'PHP') !== false) ? 'checked' : ''; ?>> PHP
            <input type="checkbox" name="skills[]" value="MySQL" <?php echo (isset($user['skills']) && strpos($user['skills'], 'JavaScript') !== false) ? 'checked' : ''; ?>> JavaScript
           
        </label><br>
        <label>Username: <input type="text" name="username" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>"></label><br>
        <label>Department: <input type="text" name="department" value="<?php echo isset($user['department']) ? $user['department'] : ''; ?>"></label><br>
        <label>Image: <input type="file" name="image"></label><br>
        <input type="submit" value="<?php echo isset($user) ? 'Update' : 'Register'; ?>">
    </form>
</body>
</html>
