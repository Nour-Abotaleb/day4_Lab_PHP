<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Registration Form</h2>
    <form action="done.php" method="post" enctype="multipart/form-data">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        <br><br>
        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>
        <br><br>
        <label for="country">Country:</label>
        <select id="country" name="country" required>
            <option value="">Select Country</option>
            <option value="Egypt">Egypt</option>
            <option value="Canada">Canada</option>
            <option value="Am">America</option>
        </select>
        <br><br>
        <label>Gender:</label>
        <input type="radio" id="male" name="gender" value="Male" required>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="Female" required>
        <label for="female">Female</label>
        <br><br>
        <label>Skills:</label>
        <input type="checkbox" id="php" name="skills[]" value="PHP">
        <label for="php">PHP</label>
        <input type="checkbox" id="mysql" name="skills[]" value="MySQL">
        <label for="mysql">MySQL</label>
        <input type="checkbox" id="j2se" name="skills[]" value="J2SE">
        <label for="j2se">J2SE</label>
        <input type="checkbox" id="postgresql" name="skills[]" value="PostgreSQL">
        <label for="postgresql">PostgreSQL</label>
        <br><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <label for="image">Profile Image:</label>
        <input type="file" id="image" name="image" required>
        <br><br>
        <input class="submit" type="submit" value="Submit">
        <input class="reset" type="reset" value="Reset">
    </form>
</body>
</html>

<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "user_registration");

$dsn = 'mysql:dbname='.DB_DATABASE.';host='.DB_HOST.';port=3307;';

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);

    $id = '';
    $first_name = '';
    $last_name = '';
    $address = '';
    $country = '';
    $gender = '';
    $skills = '';
    $username = '';
    $department = '';
    $is_update = false;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $first_name = $_GET['first_name'];
        $last_name = $_GET['last_name'];
        $address = $_GET['address'];
        $country = $_GET['country'];
        $gender = $_GET['gender'];
        $skills = $_GET['skills'];
        $username = $_GET['username'];
        $is_update = true;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $address = $_POST['address'];
            $country = $_POST['country'];
            $gender = $_POST['gender'];
            $skills = isset($_POST['skills']) ? implode("-", $_POST['skills']) : '';
            $username = $_POST['username'];
            $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $_POST['existing_password'];

            if ($is_update) {
         
                $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, address = ?, country = ?, gender = ?, skills = ?, username = ?, password = ? WHERE id = ?");
                $stmt->execute([$first_name, $last_name, $address, $country, $gender, $skills, $username, $password, $id]);
            } else {
      
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
            }

            header("Location: user.php");
            exit();
        }
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
