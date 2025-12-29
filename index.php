date_default_timezone_set("Asia/Jakarta");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Absensi Online</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2>Absensi Pegawai</h2>

        <div class="menu">
            <p class="menu-title">HOME</p>
            <a href="#" class="active">Dashboard</a>

            <p class="menu-title">MENU</p>
            <a href="#">Data Kehadiran</a>

            <p class="menu-title">ADMIN</p>
            <a href="#">Data Pegawai</a>
            <a href="#">Absensi Aplikasi</a>
        </div>

        <div class="welcome">
            Selamat Datang:<br>
            <strong>Triansi Hasan S.Pd</strong>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <div class="header">
            <h1>Dashboard</h1>
            <button class="btn">Refresh Data</button>
        </div>

        <!-- INFO BOX -->
        <div class="cards">
            <div class="card">
                <h3>Jumlah Pegawai</h3>
                <p class="big">5 Pegawai</p>
                <a href="#">Lihat Selengkapnya</a>
            </div>

            <div class="card">
                <h3>Terlambat</h3>
                <p class="big">1 Pegawai</p>
                <span>Data Hari Ini</span>
            </div>

            <div class="card">
                <h3>Hadir</h3>
                <p class="big">0 Pegawai</p>
                <a href="#">Lihat Selengkapnya</a>
            </div>

            <div class="card time">
                <h3>Hari Ini</h3>
                <p class="clock"><?= date("H:i:s"); ?></p>
                <p><?= date("l, d F Y"); ?></p>
                <a href="#">Lihat Selengkapnya</a>
            </div>
        </div>

        <!-- TABLES -->
        <div class="tables">
            <div class="table-box">
                <h3>Daftar Pegawai Terlambat [Hari Ini]</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jam Masuk</th>
                            <th>Nama Pegawai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>08:56:48</td>
                            <td>Triansi Hasan</td>
                            <td class="late">Absen Terlambat</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-box">
                <h3>Daftar Pegawai Hadir [Hari Ini]</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu Datang</th>
                            <th>Nama Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="nodata">No data available in table</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

</body>
</html>
