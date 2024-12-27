<?php
session_start();
require "../config.php"; // Pastikan Anda menghubungkan ke database
if (isset($_SESSION)){
    if ($_SESSION['level']!='admin'){
        header('Location: ../index.php');
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $level = 'admin'; // Level untuk admin baru

    // Hash password menggunakan SHA256
    $hashed_password = hash('sha256', $password);

    // Cek apakah username atau email sudah ada
    $check_query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username atau email sudah terdaftar.";
    } else {
        // Jika tidak ada, masukkan data ke dalam tabel users
        $insert_query = "INSERT INTO users (username, password, email, level) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $level);

        if ($stmt->execute()) {
            $success_message = "Admin baru berhasil didaftarkan.";
        } else {
            $error_message = "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Wisata Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #343a40;
            padding-top: 20px;
            transition: 0.3s;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #f8f9fa;
            display: block;
        }
        .sidebar button a:hover {
            background-color: rgb(255, 117, 117);
        }
        .sidebar a:hover {
            background-color: #575d63;
        }
        .main-content {
            margin-left: 0;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .open-btn {
            font-size: 20px;
            cursor: pointer;
            background-color: #343a40;
            color: white;
            padding: 10px 15px;
            border: none;
        }
        .close-btn {
            font-size: 20px;
            cursor: pointer;
            background-color: #343a40;
            color: white;
            padding: 10px 15px;
            border: none;
            display: block;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <button class="close-btn" onclick="toggleSidebar()"><i class="fas fa-undo"></i></button>
        <a href="index.php">Dashboard</a>
        <a href="../USER/index.php">Home</a>
        <a href="index.php">Manage Wisata</a>
        <a href="registeradmin.php">Register Admin</a>
        <button class="logout"><a href="../logout.php" style="color: white; text-decoration: none;">Logout</a></button>
    </div>

    <div class="main-content" id="main-content">
        <button class="open-btn" onclick="toggleSidebar()"><i class="fas fa-bars icon"></i> Menu Admin </button>
        
        <div id="dashboard">
            <h2>Dashboard</h2>
            <p>Selamat datang di Panel Admin, Gunakan sidebar untuk mengakses fitur fiturnya</p>
        </div>

        <div id="register-admin">
            <h2>Register New Admin</h2>
 <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger mt-3"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success mt-3"><?= htmlspecialchars($success_message) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            var mainContent = document.getElementById("main-content");
            if (sidebar.style.left === "-250px") {
                sidebar.style.left = "0";
                mainContent.style.marginLeft = "250px";
            } else {
                sidebar.style.left = "-250px";
                mainContent.style.marginLeft = "0";
            }
        }
    </script>
</body>
</html>