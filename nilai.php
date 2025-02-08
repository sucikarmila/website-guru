<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2 class="school">School.id</h2>
        <nav class="navigation">
            <a href="guru1.php">Teacher</a>
            <a href="siswa.php">Students</a>
            <a href="mapel.php">Study</a>
            <a href="nilai.php">Mark</a>
            <a href="logout.php" class="logout">Logout</a>
        </nav>
    </header>
    <div class="container">
        <div class="form-wrapper">
            <form action="" method="POST">
                <label for="murid_id">Nama:</label>
                <select name="murid_id" id="murid_id" required>
                    <option value="">Opsi</option>
                    <?php while ($row_siswa = mysqli_fetch_assoc($result_siswa)) : ?>
                        <option value="<?= $row_siswa['murid_id'] ?>"><?= $row_siswa['nama'] ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="id_mapel">Mapel:</label>
                <select name="id_mapel" id="id_mapel" required>
                    <option value="">Opsi</option>
                    <?php while ($row_mapel = mysqli_fetch_assoc($result_mapel)) : ?>
                        <option value="<?= $row_mapel['id'] ?>"><?= $row_mapel['nama_mapel'] ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="uh">Nilai UH:</label>
                <input type="number" name="uh" id="uh" step="0.01" required>

                <label for="uts">Nilai UTS:</label>
                <input type="number" name="uts" id="uts" step="0.01" required>

                <label for="uas">Nilai UAS:</label>
                <input type="number" name="uas" id="uas" step="0.01" required>

                <button type="submit" name="create">Enter</button>
            </form>
        </div>
        
        <div class="table-wrapper">
            <?php 
            $mapel_result = mysqli_query($koneksi, "SELECT * FROM mapel");
            while ($mapel = mysqli_fetch_assoc($mapel_result)) : 
                $id_mapel = $mapel['id'];
            ?>
                <h3 class="mapel-title"><?= $mapel['nama_mapel'] ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>UH</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Rata-rata</th>
                            <th>Predikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT nilai.murid_id, murid.nama AS nama_siswa, nilai.uh, nilai.uts, nilai.uas, 
                                (nilai.uh + nilai.uts + nilai.uas) / 3 AS rata_rata
                                FROM nilai
                                JOIN murid ON nilai.murid_id = murid.murid_id
                                WHERE nilai.id_mapel = ?";
                        $stmt = mysqli_prepare($koneksi, $query);
                        mysqli_stmt_bind_param($stmt, "i", $id_mapel);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) :
                            $rata_rata = number_format($row['rata_rata'], 2);
                            $predikat = ($row['rata_rata'] >= 85) ? "A" : (($row['rata_rata'] >= 70) ? "B" : (($row['rata_rata'] >= 60) ? "C" : (($row['rata_rata'] >= 50) ? "D" : "Tidak Lulus")));
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_siswa'] ?></td>
                                <td><?= $row['uh'] ?></td>
                                <td><?= $row['uts'] ?></td>
                                <td><?= $row['uas'] ?></td>
                                <td><?= $rata_rata ?></td>
                                <td><?= $predikat ?></td>
                                <td>
                                    <a href="edit_nilai.php?murid_id=<?= $row['murid_id'] ?>&mapel=<?= $id_mapel ?>">Edit</a>
                                    <a href="nilai.php?hapus=<?= $row['murid_id'] ?>&mapel=<?= $id_mapel ?>" onclick="return confirm('Hapus nilai ini?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
