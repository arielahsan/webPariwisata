<?php
//login adalah index.php
session_start();
require "config.php"; // Konfigurasi koneksi database

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Ambil input dari form
    $username = $_POST['credential'];
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong.";
    } else {
        // Query untuk mengambil password dan level berdasarkan username
        $stmt = $conn->prepare("SELECT password, level FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $level);
            $stmt->fetch();

            // Bandingkan password yang diinput dengan hash di database
            if (hash('sha256', $password) === $hashed_password) {
                // Set session untuk username dan level
                $_SESSION['username'] = $username;
                $_SESSION['level'] = $level;

                // Redirect berdasarkan level akses
                if (isset($_SESSION)){
                  if ($_SESSION['level'] === 'admin') {
                    header("Location:ADMIN");
                } else {
                    header("Location:USER");
                }
                exit;
                }
                
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Username tidak ditemukan.";
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
    <title>Login Page</title>
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
        width:70em;
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
        <h2 class="fw-bold">Login</h2>
        <p class="text-muted">Silahkan Login dengan akun anda</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      <?php endif; ?>

      <form action="" method="POST">
        <div class="mb-3">
          <label class="form-label" for="credential"> Username</label>
          <input
            class="form-control"
            id="credential"
            name="credential"
            placeholder="Enter your credential"
            type="text"
          />
        </div>
        <div class="mb-3">
          <label class="form-label" for="password"> Password </label>
          <input
            class="form-control"
            id="password"
            name="password"
            placeholder="Enter your password"
            type="password"
          />
        </div>
        <div class="d-grid">
          <button class="btn btn-primary" type="submit">Sign in</button>
        </div>
        <h6>Belum punya akun ? silahkan <a href="registrasi.php">registrasi</a></h6>
      </form>
    </div>
  </body>
</html>
