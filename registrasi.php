<?php
include("koneksi.php");

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $nama = trim($_POST['nama']);

    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong.";
    }

    if (empty($username)) {
        $errors[] = "Username tidak boleh kosong.";
    }

    if (empty($password)) {
        $errors[] = "Password tidak boleh kosong.";
    }

    if (empty($errors)) {
         
        $cek_user = mysqli_prepare($koneksi, "SELECT id_siswa FROM registrasi WHERE username = ?");
        mysqli_stmt_bind_param($cek_user, "s", $username);
        mysqli_stmt_execute($cek_user);
        mysqli_stmt_store_result($cek_user);

        if (mysqli_stmt_num_rows($cek_user) > 0) {
            $errors[] = "Username sudah digunakan, silakan pilih username lain.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            
            $sql = "INSERT INTO registrasi (nama, username, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sss", $nama, $username, $hashedPassword);
                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login_siswa.php';</script>";
                    exit();
                } else {
                    $errors[] = "Terjadi kesalahan saat registrasi.";
                }
                mysqli_stmt_close($stmt);
            } else {
                $errors[] = "Terjadi kesalahan pada sistem.";
            }
        }
        mysqli_stmt_close($cek_user);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Siswa</title>
    <link rel="stylesheet" href="style.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="form-box">
        <h2>Register</h2>
        <form method="POST">
            <div class="input-box">
                <input type="text" name="nama" id="nama" required value="<?php echo htmlspecialchars($nama ?? ''); ?>">
                <label for="nama">Nama</label>
                <span class="icon"><ion-icon name="person"></ion-icon></span>
            </div>

            <div class="input-box">
                <input type="text" name="username" id="username" required value="<?php echo htmlspecialchars($username ?? ''); ?>">
                <label for="username">Username</label>
                <span class="icon"><ion-icon name="person"></ion-icon></span>
            </div>

            <div class="input-box">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
            </div>

            <button type="submit" class="button">Register</button>
        </form>

        <?php
        if (!empty($errors)) {
            echo '<div class="message error">';
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo '</div>';
        }
        ?>

        <div class="login-register">
            <p>Do you have account? <a href="login_siswa.php">Login</a></p>
        </div>
    </div>
</div>
</body>
</html>
