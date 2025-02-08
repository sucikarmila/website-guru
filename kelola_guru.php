<?php
include("koneksi.php");

if (isset($_GET['hapus']) && filter_var($_GET['hapus'], FILTER_VALIDATE_INT)) {
    $guru_id = $_GET['hapus'];

    $query = "DELETE FROM guru WHERE guru_id = ?";
    $stmt = mysqli_prepare($koneksi, $query);

    mysqli_stmt_bind_param($stmt, "i", $guru_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: kelola_guru.php?success=Teacher data successfully deleted");
        exit;
    } else {
        $error_message = "Failed to delete teacher data: " . mysqli_error($koneksi);
        header("Location: kelola_guru.php?error=" . urlencode($error_message));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>guru</title>
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
</head>

<body>
    <div class="container">
        <h2>Teacher List</h2>
        <a class="button" href="tambah_guru.php">Add</a>

        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>TEACHER NAME</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM guru";
                $result = mysqli_query($koneksi, $query);
                $no = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama']}</td>
                            <td class='action-buttons'>
                                <a class='edit' href='edit_guru.php?id={$row['guru_id']}'>Edit</a>
                                <a class='delete' href='kelola_guru.php?hapus={$row['guru_id']}' onclick='return confirm(\"Are you sure you want to delete this data?\")'>Delete</a>
                            </td>
                        </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
        <a class="button" href="guru.php">Back</a>
    </div>
</body>

</html>
