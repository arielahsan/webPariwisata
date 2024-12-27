<?php

// woi ini murni backend gak ada tampilan disini

// kalau bukan admin kick
if (isset($_SESSION)){
    if ($_SESSION['level']!='admin'){
        header('Location: ../index.php');
        exit;
    }
}

session_start();
require "../config.php"; // Pastikan Anda menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_pariwisata = $_POST['nama_pariwisata'];
    $lokasi = $_POST['lokasi'];
    $fasilitas = $_POST['fasilitas'];
    $biaya = $_POST['biaya'];
    $deskripsi = $_POST['deskripsi'];
    $keamanan = $_POST['keamanan'];
    $fk_jenis_wisata_id = $_POST['fk_jenis_wisata_id'];
    
    // Update data wisata
    $query = "UPDATE pariwisata SET nama_pariwisata = ?, lokasi = ?, fasilitas = ?, biaya = ?, deskripsi = ?, keamanan = ?, fk_jenis_wisata_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssii", $nama_pariwisata, $lokasi, $fasilitas, $biaya, $deskripsi, $keamanan, $fk_jenis_wisata_id, $id);
    $stmt->execute();

    // Proses URL gambar
    if (!empty($_POST['url_gambar'])) {
        $url_gambar_array = $_POST['url_gambar'];
        foreach ($url_gambar_array as $url_gambar) {
            if (!empty($url_gambar)) {
                $gambar_query = "INSERT INTO gambar_wisata (id_wisata, url_gambar) VALUES (?, ?)";
                $gambar_stmt = $conn->prepare($gambar_query);
                $gambar_stmt->bind_param("is", $id, $url_gambar);
                $gambar_stmt->execute();
            }
        }
    }

    $success_message = "Wisata berhasil diperbarui.";
    header("Location: edit_wisata.php?id=" . $id . "&success=" . urlencode($success_message));
    exit;
}
?>