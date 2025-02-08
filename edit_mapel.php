<?php
include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama_mapel = $_POST['nama_mapel'];

    $query = "UPDATE mapel SET nama_mapel = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    if ($stmt === false) {
        echo "Error preparing statement: " . mysqli_error($koneksi);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "si", $nama_mapel, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: kelola_pelajaran.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM mapel WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    if ($stmt === false) {
        echo "Error preparing statement: " . mysqli_error($koneksi);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $mapel = mysqli_fetch_assoc($result);

    if (!$mapel) {
        echo "Subject not found.";
        exit;
    }
    mysqli_free_result($result);
} else {
    header("Location: kelola_pelajaran.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit mata pelajaran</title>
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
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $mapel['id']; ?>">
            <label for="nama_mapel">Name:</label>
            <input type="text" id="nama_mapel" name="nama_mapel" class="input" value="<?php echo htmlspecialchars($mapel['nama_mapel']); ?>" required>
            <button type="submit" name="edit" class="button">Update</button>
        </form>

        <p><a href="kelola_pelajaran.php">Back</a></p>
    </div>
</body>

</html>
