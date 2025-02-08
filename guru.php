<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px;
            text-align: center;
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 30px;
            color: #ffffff;
            text-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
            font-weight: 600;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard {
            display: flex;
            justify-content: space-around;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
            animation: slideIn 1.5s ease-in-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            width: 22%;
            text-align: center;
            backdrop-filter: blur(8px);
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s ease;
            animation: scaleIn 0.5s ease-in-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            background-color: rgba(255, 255, 255, 0.2);
        }

        .card h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #f5f5f5;
            font-weight: 600;
        }

        .card a {
            text-decoration: none;
            color: #333;
            background: #ffffff;
            padding: 12px 22px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .card a:hover {
            background: #e0e0e0;
            transform: translateY(-5px);
        }

        @media (max-width: 1200px) {
            .card {
                width: 30%;
            }
        }

        @media (max-width: 768px) {
            .card {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .card {
                width: 100%;
            }
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
        <h1>Dashboard</h1>

        <div class="dashboard">
            <div class="card">
                <h2>Manage Students</h2>
                <a href="kelola_siswa.php">Click</a>
            </div>

            <div class="card">
                <h2>Manage Subjects</h2>
                <a href="kelola_pelajaran.php">Click</a>
            </div>

            <div class="card">
                <h2>Manage Grades</h2>
                <a href="kelola_nilai.php">Click</a>
            </div>

            <div class="card">
                <h2>Manage Teachers</h2>
                <a href="kelola_guru.php">Click</a>
            </div>
        </div>
        <a href="logout.php" class="button">Logout</a>
    </div>
</body>

</html>
