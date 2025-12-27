<?php
/* =====================================
   KONFIGURASI FILE
===================================== */
$file = "profile.json";

/* =====================================
   DATA DEFAULT (LENGKAP)
===================================== */
$default = [
    "nama"      => "Trianinsi Hasan S.Pd",
    "username"  => "admin",
    "jabatan"   => "Admin Sekolah",
    "instansi"  => "PAUD Amal Tododara TIKEP",
    "umur"      => "33",
    "npwp"      => "67375375",
    "remember"  => false
];

/* =====================================
   BUAT FILE JIKA BELUM ADA
===================================== */
if (!file_exists($file)) {
    file_put_contents($file, json_encode($default, JSON_PRETTY_PRINT));
}

/* =====================================
   BACA & NORMALISASI DATA
===================================== */
$data = json_decode(file_get_contents($file), true);

/* Tambahkan key yang belum ada */
foreach ($default as $key => $value) {
    if (!isset($data[$key])) {
        $data[$key] = $value;
    }
}

/* =====================================
   SIMPAN SETELAN DASAR
===================================== */
if (isset($_POST['simpan_dasar'])) {
    $data['nama']     = $_POST['nama'];
    $data['username'] = $_POST['username'];
    $data['jabatan']  = $_POST['jabatan'];
    $data['instansi'] = $_POST['instansi'];
    $data['umur']     = $_POST['umur'];
    $data['npwp']     = $_POST['npwp'];

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    echo "<script>alert('Setelan dasar berhasil disimpan');</script>";
}

/* =====================================
   SIMPAN REMEMBER ME
===================================== */
if (isset($_POST['simpan_remember'])) {
    $data['remember'] = isset($_POST['remember']) ? true : false;
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    echo "<script>alert('Pengaturan Remember Me disimpan');</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Setelan</title>

<style>
body{margin:0;font-family:Arial;background:#f4f4f4}
.sidebar{width:260px;height:100vh;position:fixed;background:#263238;color:white}
.sidebar h2{padding:20px}
.sidebar a{display:block;padding:15px 20px;color:white;text-decoration:none;border-bottom:1px solid #37474F}
.sidebar a:hover{background:#455A64}
.main{margin-left:260px;padding:30px}
.card{background:white;padding:25px;border-radius:10px;width:80%}

/* TAB */
.tabs{display:flex;border-bottom:1px solid #ddd;margin-bottom:20px}
.tab{padding:12px 20px;cursor:pointer}
.tab.active{border-bottom:3px solid #0288D1;font-weight:bold;color:#0288D1}

/* CONTENT */
.tab-content{display:none}
.tab-content.active{display:block}

/* FORM */
.row{display:flex;align-items:center;margin-bottom:15px}
.row label{width:220px;font-weight:bold}
.row input{width:60%;padding:10px;border:1px solid #ccc;border-radius:5px}
.umur{display:flex;align-items:center}
.umur span{margin-left:10px}
.btn{padding:10px 18px;background:#0288D1;color:white;border:none;border-radius:5px;cursor:pointer}
.box{background:#f9f9f9;padding:15px;border-radius:5px}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Absensi Online</h2>
    <a href="#">Dashboard Admin</a>
    <a href="#">Data Kehadiran</a>
    <a href="#">Data Pegawai</a>
    <a href="#" style="background:#455A64">Settings Aplikasi</a>

    <div style="padding:15px;margin-top:200px">
        Selamat Datang:<br>
        <b><?= htmlspecialchars($data['nama']); ?></b>
    </div>
</div>

<!-- MAIN -->
<div class="main">
<h1>⚙ Setelan</h1>

<div class="card">

<!-- TAB MENU -->
<div class="tabs">
    <div class="tab active" onclick="openTab(event,'dasar')">⚙ Setelan Dasar</div>
    <div class="tab" onclick="openTab(event,'password')">🔒 Ganti Password</div>
    <div class="tab" onclick="openTab(event,'remember')">🔑 Remember Me</div>
</div>

<!-- SETELAN DASAR -->
<div id="dasar" class="tab-content active">
<form method="POST">
    <div class="row"><label>Nama Lengkap</label><input name="nama" value="<?= $data['nama']; ?>"></div>
    <div class="row"><label>Username</label><input name="username" value="<?= $data['username']; ?>"></div>
    <div class="row"><label>Jabatan</label><input name="jabatan" value="<?= $data['jabatan']; ?>"></div>
    <div class="row"><label>Instansi</label><input name="instansi" value="<?= $data['instansi']; ?>"></div>
    <div class="row">
        <label>Umur</label>
        <div class="umur">
            <input name="umur" value="<?= $data['umur']; ?>" style="width:120px">
            <span>Tahun</span>
        </div>
    </div>
    <div class="row"><label>NPWP</label><input name="npwp" value="<?= $data['npwp']; ?>"></div>
    <button class="btn" name="simpan_dasar">Simpan Perubahan</button>
</form>
</div>

<!-- GANTI PASSWORD -->
<div id="password" class="tab-content">
<div class="box">
    <div class="row"><label>Password Lama</label><input type="password"></div>
    <div class="row"><label>Password Baru</label><input type="password"></div>
    <div class="row"><label>Konfirmasi Password</label><input type="password"></div>
    <button class="btn">Ganti Password</button>
</div>
</div>

<!-- REMEMBER ME -->
<div id="remember" class="tab-content">
<form method="POST" class="box">
    <label>
        <input type="checkbox" name="remember"
        <?= $data['remember'] ? 'checked' : ''; ?>>
        Aktifkan Remember Me
    </label>
    <br><br>
    <button class="btn" name="simpan_remember">Simpan</button>
</form>
</div>

</div>
</div>

<script>
function openTab(e,id){
    document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active'));
    e.target.classList.add('active');
    document.getElementById(id).classList.add('active');
}
</script>

</body>
</html>
