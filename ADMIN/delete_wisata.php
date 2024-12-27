<?php
session_start();
require "../config.php"; // Pastikan Anda menghubungkan ke database
if (isset($_SESSION)){
    if ($_SESSION['level']!='admin'){
        header('Location: ../index.php');
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus gambar terkait dari tabel gambar_wisata
    $delete_gambar_query = "DELETE FROM gambar_wisata WHERE id_wisata = ?";
    $stmt = $conn->prepare($delete_gambar_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Hapus data wisata dari tabel pariwisata
    $delete_wisata_query = "DELETE FROM pariwisata WHERE id = ?";
    $stmt = $conn->prepare($delete_wisata_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirect ke halaman manajemen wisata dengan pesan sukses
    header("Location: index.php?message=Data berhasil dihapus");
    exit;
} else {
    echo "ID tidak diberikan.";
    exit;
}
?>