<?php
include("koneksi.php");

if (isset($_GET['id'])) {
    $murid_id = $_GET['id'];
    $query = "SELECT * FROM nilai WHERE murid_id = $murid_id";
    $result = mysqli_query($koneksi, $query);
    $nilai = mysqli_fetch_assoc($result);

    if (!$nilai) {
        echo "Data not found!";
        exit;
    }
} else {
    header("Location: kelola_nilai.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $murid_id = $_POST['murid_id'];  
    $id_mapel = $_POST['id_mapel'];  
    $uh = $_POST['uh']; 
    $uts = $_POST['uts'];  
    $uas = $_POST['uas'];  

    $query = "UPDATE nilai SET 
              id_mapel = '$id_mapel', 
              uh = '$uh', 
              uts = '$uts', 
              uas = '$uas' 
              WHERE murid_id = $murid_id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: kelola_nilai.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Grade</title>
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
        <h1>Edit Grade</h1>
        <form action="" method="POST">
            <input type="hidden" name="murid_id" value="<?php echo $nilai['murid_id']; ?>">

            <label for="id_mapel">Subject:</label>
            <select name="id_mapel" id="id_mapel" class="input" required>
                <option value="">Select Subject</option>
                <?php
                $query_mapel = "SELECT id, nama_mapel FROM mapel";  // Ensure the mapel table name is correct
                $result_mapel = mysqli_query($koneksi, $query_mapel);
                while ($row_mapel = mysqli_fetch_assoc($result_mapel)) {
                    $selected = $row_mapel['id'] == $nilai['id_mapel'] ? 'selected' : '';
                    echo "<option value='{$row_mapel['id']}' $selected>{$row_mapel['nama_mapel']}</option>";
                }
                ?>
            </select>

            <label for="uh">UH Grade:</label>
            <input type="number" name="uh" id="uh" class="input" value="<?php echo $nilai['uh']; ?>" step="0.01" required>

            <label for="uts">UTS Grade:</label>
            <input type="number" name="uts" id="uts" class="input" value="<?php echo $nilai['uts']; ?>" step="0.01" required>

            <label for="uas">UAS Grade:</label>
            <input type="number" name="uas" id="uas" class="input" value="<?php echo $nilai['uas']; ?>" step="0.01" required>

            <button type="submit" class="button">Update</button>
        </form>

        <p><a href="kelola_nilai.php">Back</a></p>
    </div>
</body>
</html>
