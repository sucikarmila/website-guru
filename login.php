<?php
include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $errors[] = "Username cannot be empty.";
    }

    if (empty($password)) {
        $errors[] = "Password cannot be empty.";
    }

    if (empty($errors)) {
        
        $sql = "SELECT username, password FROM registrasi WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $dbUsername, $dbPassword);
                mysqli_stmt_fetch($stmt);

                
                if (password_verify($password, $dbPassword)) {
                    echo "Login successful!";
                } else {
                    $errors[] = "Incorrect password.";
                }
            } else {
                $errors[] = "Username not found.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = "System error occurred.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilihan Login</title>
    <style>
         
        body {
            background: linear-gradient(135deg, #2c2c2c, #4d4d4d);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            font-family: 'Roboto', sans-serif;
        }

        
        .container {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            background: hsla(0, 11.30%, 72.20%, 0.10);
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
            text-shadow: 0 4px 10px rgba(255, 255, 255, 0.4);
        }
 
        .options {
            display: flex;
            justify-content: space-evenly;
            margin-bottom: 30px;
        }

        .btn {
            width: 45%;
            padding: 15px;
            background-color: #666;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.6);
        }

        .btn.selected {
            background-color: #555;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.6);
        }
 
        .masuk-btn {
            width: 100%;
            padding: 15px;
            background-color: #666;
            border: none;
            border-radius: 8px;
            font-size: 1.2rem;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .masuk-btn:hover {
            background-color: #555;
            transform: scale(1.05);
        }

        
        ul {
            margin-top: 10px;
            color: #ff3d00;
            list-style: none;
            padding-left: 0;
        }

        ul li {
            margin-bottom: 8px;
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
        <h1>Login As</h1>
        <div class="options">
            <button id="siswa" class="btn">Student</button>
            <button id="guru" class="btn">Teacher</button>
        </div>
        <button id="masukBtn" class="btn masuk-btn">Login</button>
        <ul id="errorMessages"></ul>
    </div>

    <script>
        document.getElementById('masukBtn').addEventListener('click', function () {
            let selectedOption = '';

            if (document.getElementById('siswa').classList.contains('selected')) {
                selectedOption = 'login_siswa.php';
            } else if (document.getElementById('guru').classList.contains('selected')) {
                selectedOption = 'login_guru.php';
            }

            if (selectedOption) {
                window.location.href = selectedOption;
            } else {
                showErrorMessage('Please select a user type first!');
            }
        });

        document.getElementById('siswa').addEventListener('click', function () {
            toggleSelection('siswa');
        });

        document.getElementById('guru').addEventListener('click', function () {
            toggleSelection('guru');
        });

        function toggleSelection(option) {
            if (option === 'siswa') {
                document.getElementById('siswa').classList.add('selected');
                document.getElementById('guru').classList.remove('selected');
            } else if (option === 'guru') {
                document.getElementById('guru').classList.add('selected');
                document.getElementById('siswa').classList.remove('selected');
            }
        }

        function showErrorMessage(message) {
            const errorMessages = document.getElementById('errorMessages');
            const li = document.createElement('li');
            li.textContent = message;
            errorMessages.appendChild(li);
        }
    </script>
</body>

</html>
