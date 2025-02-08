<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai</title>
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
            max-width: 1000px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #ffffff;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .button,
        .add,
        .back-link {
            text-decoration: none;
            background: linear-gradient(135deg, #717171, #4d4d4d);
            color: #ffffff;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            width: 100%;
            margin: 10px 0;
            display: inline-block;
            transition: background 0.3s ease-in-out;
            text-align: center;
        }

        .button:hover,
        .add:hover,
        .back-link:hover {
            background: linear-gradient(135deg, #4d4d4d, #717171);
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #2e3f57;
        }

        th {
            background: #1a2c43;
            color: white;
        }

        tr:nth-child(even) {
            background: #3a4b63;
        }

        tr:hover {
            background: #2c3e50;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            margin-right: 5px;
            transition: all 0.3s ease;
        }

        .edit {
            background: #3e5c7e;
            color: white;
        }

        .edit:hover {
            background: #2a4d7a;
        }

        .delete {
            background: #e74c3c;
            color: white;
        }

        .delete:hover {
            background: #c0392b;
        }

        @media (max-width: 768px) {
            .search-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-box {
                width: 100%;
                margin-bottom: 10px;
            }
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
<body>
    <div class="container">

        <h2>Scores List</h2>

        <a class="add" href="tambah_nilai.php">Add</a>

        <?php
        include("koneksi.php");
 
        $mapelQuery = "SELECT * FROM mapel";
        $mapelResult = mysqli_query($koneksi, $mapelQuery);

        while ($mapel = mysqli_fetch_assoc($mapelResult)) {
            $mapelId = $mapel['id'];
            echo "<h2>{$mapel['nama_mapel']}</h2>";
            echo "<table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student Name</th>
                            <th>UH</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Average</th>
                            <th>Grade</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";
 
            $query = "SELECT nilai.murid_id, murid.nama AS nama_siswa, nilai.uh, nilai.uts, nilai.uas, 
                             (nilai.uh + nilai.uts + nilai.uas) / 3 AS rata_rata
                      FROM nilai
                      JOIN murid ON nilai.murid_id = murid.murid_id
                      WHERE nilai.id_mapel = '$mapelId'";
            $result = mysqli_query($koneksi, $query);
            $no = 1;

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $grade = "Failing"; 
                    if ($row['rata_rata'] >= 85) {
                        $grade = "A";
                    } elseif ($row['rata_rata'] >= 70) {
                        $grade = "B";
                    } elseif ($row['rata_rata'] >= 60) {
                        $grade = "C";
                    } elseif ($row['rata_rata'] >= 50) {
                        $grade = "D";
                    }

                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama_siswa']}</td>
                            <td>{$row['uh']}</td>
                            <td>{$row['uts']}</td>
                            <td>{$row['uas']}</td>
                            <td>" . number_format($row['rata_rata'], 2) . "</td>
                            <td>{$grade}</td>
                            <td class='action-buttons'>
                                <a class='edit' href='edit_nilai.php?id={$row['murid_id']}'>Edit</a>
                                <a class='delete' href='hapus_nilai.php?hapus={$row['murid_id']}'>Delete</a>
                            </td>
                        </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='8' style='text-align:center;'>No data found</td></tr>";
            }
            echo "</tbody></table>";
        }
        ?>

        <a class="back-link" href="guru.php">Back</a>
    </div>
</body>
</html>
