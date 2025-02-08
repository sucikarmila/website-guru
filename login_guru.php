<?php
session_start();
include("koneksi.php");

$admin_username = "bu wiyana";
$admin_password_hashed = password_hash("1234", PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === $admin_username && password_verify($password, $admin_password_hashed)) {
        $_SESSION['user_type'] = 'admin';
        $_SESSION['username'] = $username;
        header('Location: guru.php');
        exit;
    } else {
        $error = 'Incorrect username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login guru</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #2c2c2c, #4d4d4d);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            color: #ffffff;
            overflow: hidden;
        }

        .container {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #ffffff;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        }

        form {
            width: 100%;
        }

        label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin-bottom: 5px;
            color: #ffffff;
        }

        .input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            background: #f4f9fc;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out, border 0.3s ease-in-out;
        }

        .input:focus {
            outline: none;
            border: 2px solid #8e8e8e;
            box-shadow: 0 0 8px rgba(95, 99, 102, 0.7);
        }

        .button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #717171, #4d4d4d);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .button:hover {
            background: linear-gradient(135deg, #4d4d4d, #717171);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
        }

        .message.success {
            color: #00ffcc;
        }

        .message.error {
            color: #ff8080;
        }

        p {
            margin-top: 20px;
            color: #ffffff;
            font-size: 14px;
        }

        p a {
            color: #c7c7c7;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            color: #a6a6a6;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Teacher</h1>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="input" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="input" required>

            <button type="submit" name="login" class="button">Log in</button>
        </form>

        <?php if (isset($error)) { echo '<p class="message error">' . $error . '</p>'; } ?>
    </div>
</body>
</html>
