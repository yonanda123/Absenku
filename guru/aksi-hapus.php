<?php
require "../config.php";
if (isset($_SESSION['guru']) or isset($_SESSION['admin'])) {
    // hapus pengumuman
    if (isset($_GET['hapus_pengumuman'])) {
        $id_pengumuman = $_POST['id_pengumuman'];
        $query1 = mysqli_query($conn, "DELETE FROM tb_pengumuman WHERE id_pengumuman = '$id_pengumuman'");
        $query2 = mysqli_query($conn, "DELETE FROM tb_tanggapan WHERE id_pengumuman = '$id_pengumuman'");
        if ($query1 && $query2) {
            echo 'berhasil';
        }
    }
    // hapus kelas
    if (isset($_GET['hapus_kelas'])) {
        $token_kelas = $_POST['token_kelas'];
        $query1 = mysqli_query($conn, "DELETE FROM tb_kelas WHERE token_kelas = '$token_kelas'");
        $query2 = mysqli_query($conn, "DELETE FROM tb_siswa WHERE token_kelas = '$token_kelas'");
        $query3 = mysqli_query($conn, "DELETE FROM tb_pengumuman WHERE token_kelas = '$token_kelas'");
        $query4 = mysqli_query($conn, "DELETE FROM a_masuk WHERE token_kelas = '$token_kelas'");
        $query5 = mysqli_query($conn, "DELETE FROM a_masukket WHERE token_kelas = '$token_kelas'");
        $query6 = mysqli_query($conn, "DELETE FROM a_pulang WHERE token_kelas = '$token_kelas'");
        $query5 = mysqli_query($conn, "DELETE FROM a_pulangket WHERE token_kelas = '$token_kelas'");
        if ($query1 && $query2 && $query3 && $query4 && $query5 && $query6) {
            echo 'berhasil';
        }
    }
    // hapus siswa
    if (isset($_GET['hapus_siswa'])) {
        $id_siswa = $_POST['id_siswa'];
        $query1 = mysqli_query($conn, "DELETE FROM tb_siswa WHERE id_siswa = '$id_siswa'");
        $query2 = mysqli_query($conn, "DELETE FROM a_masuk WHERE id_siswa = '$id_siswa'");
        $query3 = mysqli_query($conn, "DELETE FROM a_pulang WHERE id_siswa = '$id_siswa'");
        $query4 = mysqli_query($conn, "DELETE FROM tb_tanggapan WHERE id_siswa = '$id_siswa'");
        if ($query1 && $query2 && $query3 && $query4) {
            echo 'berhasil';
        }
    }
    // hapus ceklis siswa
    if (isset($_GET['hapus_ceklis_siswa'])) {
        if (empty($_POST['id_siswa'])) {
            echo 'tidak ada';
            return false;
        }
        $id_siswa = $_POST['id_siswa'];
        $jml_ceklis = count($id_siswa);
        for ($i = 0; $i < $jml_ceklis; $i++) {
            $query = mysqli_query($conn, "DELETE FROM tb_siswa WHERE id_siswa = '$id_siswa[$i]'");
        }
        if ($query) {
            echo 'berhasil';
        }
    }
    // hapus guru
    if (isset($_GET['hapus_guru'])) {
        $id_guru = $_POST['id_guru'];
        $query1 = mysqli_query($conn, "DELETE FROM tb_guru WHERE id_guru = '$id_guru'");
        $query2 = mysqli_query($conn, "DELETE FROM a_masuk WHERE id_guru = '$id_guru'");
        $query3 = mysqli_query($conn, "DELETE FROM a_pulang WHERE id_guru = '$id_guru'");
        $query4 = mysqli_query($conn, "DELETE FROM tb_kelas WHERE id_guru = '$id_guru'");
        $query5 = mysqli_query($conn, "DELETE FROM tb_pengumuman WHERE id_guru = '$id_guru'");
        $query6 = mysqli_query($conn, "DELETE FROM tb_siswa WHERE id_guru = '$id_guru'");

        if ($query1 && $query2 && $query3 && $query4 && $query5 && $query6) {
            echo 'berhasil';
        }
    }
}
