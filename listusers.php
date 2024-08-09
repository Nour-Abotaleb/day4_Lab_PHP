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
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h2>Registered Users</h2>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>Country</th>
            <th>Gender</th>
            <th>Skills</th>
            <th>Username</th>
            <th>Department</th>
            <th>Image</th>
            <th>Options</th>
        </tr>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo ($user['first_name']); ?></td>
                    <td><?php echo ($user['last_name']); ?></td>
                    <td><?php echo ($user['address']); ?></td>
                    <td><?php echo ($user['country']); ?></td>
                    <td><?php echo ($user['gender']); ?></td>
                    <td><?php echo ($user['skills']); ?></td>
                    <td><?php echo ($user['username']); ?></td>
                    <td><?php echo ($user['department']); ?></td>
                    <td>
                        <?php if ($user['image_path']): ?>
                            <img src="<?php echo ($user['image_path']); ?>" alt="User Image">
                        <?php else: ?>
                            No image
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="GET" action="update-form.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button style="background-color:  #66df66; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; " type="submit">Update</button>
                        </form>
                        <form method="POST" action="delete_user.php" style="display:inline;">
                            <input  type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button style="background-color: #e27d7d; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px; "  type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10">No users found.</td>
            </tr>
        <?php endif; ?>
    </table>
      
</body>
</html>
