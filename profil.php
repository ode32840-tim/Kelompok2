<?php
// data user (contoh statis)
$user = [
    "nama" => "Triansi Hasan S.Pd",
    "umur" => "33 Tahun",
    "instansi" => "PAUD Amal Tododara",
    "jabatan" => "Admin Sekolah",
    "npwp" => "67375375",
    "ttl" => "Tidore, 1992-02-10",
    "gender" => "Perempuan",
    "shift" => "Full Time",
    "verifikasi" => "Terverifikasi"
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - Absensi Online</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2>Absensi Online</h2>

        <div class="menu">
            <p class="menu-title">HOME</p>
            <ul>
                <li>Dashboard Admin</li>
            </ul>

            <p class="menu-title">MENU</p>
            <ul>
                <li>Data Kehadiran</li>
            </ul>

            <p class="menu-title">ADMIN</p>
            <ul>
                <li>Data Pegawai</li>
                <li>Absensi Aplikasi</li>
            </ul>
        </div>

        <div class="welcome">
            Selamat Datang:<br>
            <strong><?= $user['nama']; ?></strong>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">
        <header class="topbar">
            <h1>Profil Saya</h1>
            <div class="profile-menu">
                <a href="#">Profil Saya</a>
                <a href="#">Setelan</a>
                <a href="#">Logout</a>
            </div>
        </header>

        <section class="profile-card">
            <div class="profile-left">
                <img src="assets/user.png" alt="Foto Profil">
            </div>

            <div class="profile-right">
                <table>
                    <tr><td>Nama Lengkap</td><td>: <?= $user['nama']; ?></td></tr>
                    <tr><td>Umur</td><td>: <?= $user['umur']; ?></td></tr>
                    <tr><td>Instansi</td><td>: <?= $user['instansi']; ?></td></tr>
                    <tr><td>Jabatan</td><td>: <?= $user['jabatan']; ?></td></tr>
                    <tr><td>NPWP</td><td>: <?= $user['npwp']; ?></td></tr>
                    <tr><td>Tempat / Tgl Lahir</td><td>: <?= $user['ttl']; ?></td></tr>
                    <tr><td>Jenis Kelamin</td><td>: <?= $user['gender']; ?></td></tr>
                    <tr><td>Shift Bekerja</td><td>: <?= $user['shift']; ?></td></tr>
                    <tr>
                        <td>Verifikasi Akun</td>
                        <td>: <span class="badge"><?= $user['verifikasi']; ?></span></td>
                    </tr>
                </table>
            </div>
        </section>
    </main>

</div>

</body>
</html>
