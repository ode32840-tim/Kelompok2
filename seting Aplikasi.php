<?php
$file = "setting.json";

/* DEFAULT SETTING */
$default = [
    "instansi" => "PAUD Amal Tododara TIKEP",
    "pesan" => "Absensi Pegawai (GURU)",
    "nama_app" => "Absensi Online",
    "zona" => "Asia/Jayapura",
    "mulai" => "07:00",
    "inisialisasi" => false
];

if (!file_exists($file)) {
    file_put_contents($file, json_encode($default, JSON_PRETTY_PRINT));
}

$data = json_decode(file_get_contents($file), true);

/* PASTIKAN SEMUA KEY ADA */
foreach ($default as $k => $v) {
    if (!isset($data[$k])) $data[$k] = $v;
}

/* SIMPAN */
if (isset($_POST['simpan'])) {
    $data['instansi'] = $_POST['instansi'];
    $data['pesan'] = $_POST['pesan'];
    $data['nama_app'] = $_POST['nama_app'];
    $data['zona'] = $_POST['zona'];
    $data['mulai'] = $_POST['mulai'];
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    echo "<script>alert('Perubahan berhasil disimpan');</script>";
}

/* INISIALISASI */
if (isset($_POST['inisialisasi'])) {
    $data['inisialisasi'] = true;
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    echo "<script>alert('Aplikasi telah diinisialisasi');</script>";
}

/* RESET */
if (isset($_POST['reset'])) {
    file_put_contents($file, json_encode($default, JSON_PRETTY_PRINT));
    header("Location: setting_aplikasi.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Setting Aplikasi</title>
<style>
body{margin:0;font-family:Arial;background:#f4f6f9}
.header{height:55px;background:#343a40;color:white;display:flex;align-items:center;padding:0 20px;font-size:20px}
.sidebar{width:240px;position:fixed;top:55px;bottom:0;background:#212529;color:white}
.sidebar h3{padding:15px;margin:0;font-size:14px;color:#adb5bd}
.sidebar a{display:block;padding:12px 20px;color:#c2c7d0;text-decoration:none}
.sidebar a.active,.sidebar a:hover{background:#343a40;color:white}
.content{margin-left:240px;padding:30px}
.card{background:white;border-radius:6px;width:70%;padding:25px;box-shadow:0 0 5px rgba(0,0,0,.1)}
.btn{padding:10px 16px;border:none;border-radius:5px;color:white;cursor:pointer}
.green{background:#28a745}
.red{background:#dc3545}
.gray{background:#6c757d}
.row{display:flex;align-items:center;margin-bottom:18px}
.row label{width:220px}
.row input,.row select{width:320px;padding:10px;border:1px solid #ccc;border-radius:5px}
.group{display:flex}
.group input,.group select{border-radius:5px 0 0 5px}
.group button{border-radius:0 5px 5px 0}
</style>
</head>

<body>

<div class="header">Absensi Online</div>

<div class="sidebar">
    <h3>HOME</h3>
    <a>Dashboard Admin</a>
    <h3>ADMIN</h3>
    <a class="active">Settings Aplikasi</a>
</div>

<div class="content">
<h1>🛠️ Setting Aplikasi</h1>

<div class="card">
<form method="POST">

<button class="btn green" name="inisialisasi" type="submit">
<?= $data['inisialisasi'] ? "✔ Sudah Di Inisialisasi" : "✔ Telah Di Inisialisasi"; ?>
</button>

<button class="btn red" name="reset" type="submit"
onclick="return confirm('Reset ke pengaturan awal?')">
⟲ Reset Setting App
</button>

<hr><br>

<div class="row">
<label>Nama Instansi</label>
<input name="instansi" value="<?= $data['instansi']; ?>">
</div>

<div class="row">
<label>Pesan Halaman Depan</label>
<input name="pesan" value="<?= $data['pesan']; ?>">
</div>

<div class="row">
<label>Nama Aplikasi Absensi</label>
<input name="nama_app" value="<?= $data['nama_app']; ?>">
</div>

<div class="row">
<label>Zona Waktu Absensi</label>
<select name="zona">
<?php
$zona = ["waktu indonesia barat","waktu indonesia tengah","waktu indonesia timur"];
foreach($zona as $z){
    $s = $data['zona']==$z ? "selected" : "";
    echo "<option $s>$z</option>";
}
?>
</select>
</div>

<div class="row">
<label>Absen Dimulai Jam</label>
<div class="group">
<input type="time" name="mulai" value="<?= $data['mulai']; ?>">
<button type="button" class="btn gray"
onclick="
let d=new Date();
document.querySelector('[name=mulai]').value=
String(d.getHours()).padStart(2,'0')+':'+
String(d.getMinutes()).padStart(2,'0');
">
Set Current Time
</button>
</div>
</div>

<button class="btn green" name="simpan" type="submit">
Simpan Perubahan
</button>

</form>
</div>
</div>

</body>
</html>
