<?php
require "config.php"; // Konfigurasi koneksi database

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $level = "user"; // Default level
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Semua field wajib diisi.";
    } else {
        // Periksa apakah username atau email sudah terdaftar
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username atau email sudah terdaftar.";
        } else {
            // Enkripsi password dengan SHA-256
            $hashed_password = hash('sha256', $password);

            // Masukkan data ke database
            $stmt = $conn->prepare("INSERT INTO users (username, email, level, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $level, $hashed_password);

            if ($stmt->execute()) {
                header("Location: index.php"); // Redirect ke halaman login setelah registrasi berhasil
                exit;
            } else {
                $error = "Terjadi kesalahan saat menyimpan data.";
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Registrasi Akun</title>
    <link
      crossorigin="anonymous"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      rel="stylesheet"
    />
    <style>
      body {
        background-color: grey;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
      }
      .card {
        border-radius: 15px;
        width: 70em;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }
      .btn-primary {
        background-color: #0056ff;
        border: none;
      }
      .btn-primary:hover {
        background-color: #0041cc;
      }
    </style>
  </head>
  <body>
    <div class="card p-4" style="max-width: 400px">
      <div class="text-center">
        <img
          alt="Icon"
          height="50"
          src="USER/IMG/logo-kabupaten-sragen.jpg"
          width="50"
        />
        <h2 class="fw-bold">Registrasi Akun</h2>
        <p class="text-muted">Silahkan Registrasi Akun baru</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      <?php endif; ?>

      <form action="" method="POST">
        <div class="mb-3">
          <label class="form-label" for="username">Username</label>
          <input
            class="form-control"
            id="username"
            name="username"
            placeholder="Masukkan Username"
            type="text"
          />
        </div>

        <div class="mb-3">
          <label class="form-label" for="email">E-mail</label>
          <input
            class="form-control"
            id="email"
            name="email"
            placeholder="Masukkan Email"
            type="email"
          />
        </div>

        <div class="mb-3">
          <label class="form-label" for="password">Password</label>
          <input
            class="form-control"
            id="password"
            name="password"
            placeholder="Masukkan Password"
            type="password"
          />
        </div>

        <div class="d-grid">
          <button class="btn btn-primary" type="submit">Sign Up</button>
        </div>
      </form>
    </div>
  </body>
</html>
