<?php
include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $murid_id = $_POST['murid_id'];   
    $id_mapel = $_POST['id_mapel'];
    $uh = $_POST['uh'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];
 
    $query = "INSERT INTO nilai (murid_id, id_mapel, uh, uts, uas) 
              VALUES ('$murid_id', '$id_mapel', '$uh', '$uts', '$uas')"; 
 
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
    <title>Tambah Nilai</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #2c2c2c, #4d4d4d);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Roboto', sans-serif;
            color: #ffffff;
        }
        .container {
            max-width: 450px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        h1 { font-size: 2.5rem; margin-bottom: 20px; }
        form { width: 100%; }
        label { display: block; text-align: left; margin-bottom: 5px; }
        select, input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            background: #f4f9fc;
            transition: box-shadow 0.3s ease-in-out;
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
            transition: all 0.3s ease-in-out;
        }
        .button:hover { transform: translateY(-2px); }
        p { margin-top: 20px; font-size: 14px; }
        p a { color: #c7c7c7; text-decoration: none; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="POST">
             
            <label for="murid_id">Students Name:</label>
            <select name="murid_id" id="murid_id" required>
                <option value="">Option</option>
                <?php
                 
                $query_siswa = "SELECT murid_id, nama FROM murid";  
                $result_siswa = mysqli_query($koneksi, $query_siswa);
                while ($row_siswa = mysqli_fetch_assoc($result_siswa)) {
                    echo "<option value='{$row_siswa['murid_id']}'>{$row_siswa['nama']}</option>";
                }
                ?>
            </select>

            <label for="id_mapel">Subjects:</label>
            <select name="id_mapel" id="id_mapel" required>
                <option value="">Option</option>
                <?php
                 
                $query_mapel = "SELECT id, nama_mapel FROM mapel";
                $result_mapel = mysqli_query($koneksi, $query_mapel);
                while ($row_mapel = mysqli_fetch_assoc($result_mapel)) {
                    echo "<option value='{$row_mapel['id']}'>{$row_mapel['nama_mapel']}</option>";
                }
                ?>
            </select>
 
            <label for="uh">UH:</label>
            <input type="number" name="uh" id="uh" step="0.01" required>

            <label for="uts">UTS:</label>
            <input type="number" name="uts" id="uts" step="0.01" required>

            <label for="uas">UAS:</label>
            <input type="number" name="uas" id="uas" step="0.01" required>

            <button type="submit" class="button">ADD</button>
        </form>

        <p><a href="kelola_nilai.php">Back</a></p>
    </div>
</body>
</html>
