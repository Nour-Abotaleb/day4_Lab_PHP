<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        h2 {
            text-align: center;
        }

        form {
            background-color: #fff;
            box-shadow: 2px 2px 5px 1px #888;
            padding: 30px;
            width: 350px;
            height: auto;
            margin: auto;
            border-radius: 10px;
        }

        input {
            padding: 7px 60px;
            outline: none;
            margin-top: 10px;
        }

        .submit {
            border: none;
            outline: none;
            font-size: 16px;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            background-color: #66df66;
        }
            </style>
</head>
<body>
    <h2>Login</h2>
    <form action="session_login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <input class="submit" type="submit" value="Login">
    </form>
</body>
</html>
