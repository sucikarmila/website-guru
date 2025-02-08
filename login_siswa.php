<?php
include("koneksi.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM registrasi WHERE username = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: siswa_dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }

    $stmt->close();
}
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="form-box">
        <h2>Students</h2>
        <form method="POST">
            <div class="input-box">
                <input type="text" name="username" id="username" required>
                <label for="username">Username</label>
                <span class="icon"><ion-icon name="person"></ion-icon></span>
            </div>
            
            <div class="input-box">
                
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
            </div>

            <button type="submit" class="button">Login</button>
        </form>

        <?php if (isset($error)) { echo '<p class="message error">' . $error . '</p>'; } ?>

        <div class="login-register">
            <p>Don't you have account? <a href="registrasi.php">register</a></p>
        </div>
    </div>
</div>
</body>
</html>
