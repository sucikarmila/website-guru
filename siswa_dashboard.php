<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_siswa.php");
    exit;
}

$username = $_SESSION['username'];

include("koneksi.php");

$query = "
    SELECT nilai.murid_id, murid.nama AS nama_siswa, mapel.nama_mapel, nilai.uh, nilai.uts, nilai.uas, 
           (nilai.uh + nilai.uts + nilai.uas) / 3 AS rata_rata
    FROM nilai
    JOIN murid ON nilai.murid_id = murid.murid_id
    JOIN mapel ON nilai.id_mapel = mapel.id
    WHERE murid.nama = '$username'";  
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
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
            min-height: 100vh;
            font-family: 'Roboto', sans-serif;
            color: #ffffff;
            overflow: hidden;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 90%;
            max-width: 800px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(255, 255, 255, 0.2);
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        th {
            background: rgba(255, 255, 255, 0.2);
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: black;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .button:hover {
            background: grey;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to my website, <?php echo htmlspecialchars($username); ?>!</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Subjects</th>
                    <th>UH</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Average</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['nama_mapel']}</td>
                                <td>{$row['uh']}</td>
                                <td>{$row['uts']}</td>
                                <td>{$row['uas']}</td>
                                <td>" . number_format($row['rata_rata'], 2) . "</td>
                            </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data nilai untuk Anda.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="logout.php" class="button">Logout</a>
    </div>
</body>
</html>
