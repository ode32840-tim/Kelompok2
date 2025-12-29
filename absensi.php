<?php
session_start();

/* ===== KONEKSI ===== */
$conn = mysqli_connect("localhost","root","","absensi");
if(!$conn){ die("Koneksi gagal"); }

/* ===== LOGIN ===== */
if(isset($_POST['login'])){
  $u=$_POST['username'];
  $p=$_POST['password'];

  $q=mysqli_query($conn,"SELECT * FROM users WHERE username='$u'");
  $d=mysqli_fetch_assoc($q);

  if($d && $p==$d['password']){
    $_SESSION['login']=true;
    $_SESSION['id']=$d['id'];
    $_SESSION['nama']=$d['nama'];
    $_SESSION['jabatan']=$d['jabatan'];
    header("Location: absensi.php");
  }else{
    $error="Username atau Password salah";
  }
}

/* ===== LOGOUT ===== */
if(isset($_GET['logout'])){
  session_destroy();
  header("Location: absensi.php");
  exit;
}

/* ===== ABSEN (SETIAP KLIK = BARIS BARU) ===== */
if(isset($_POST['absen'])){
  $id=$_SESSION['id'];
  $tgl=date("Y-m-d");
  $jam=date("H:i:s");

  $last=mysqli_query($conn,"SELECT * FROM kehadiran 
    WHERE user_id='$id' AND tanggal='$tgl'
    ORDER BY id DESC LIMIT 1");
  $d=mysqli_fetch_assoc($last);

  if(!$d || $d['status']=='Pulang'){
    mysqli_query($conn,"INSERT INTO kehadiran
      (user_id,tanggal,waktu_datang,status)
      VALUES('$id','$tgl','$jam','Hadir')");
    $msg="Absen Datang";
  }else{
    mysqli_query($conn,"INSERT INTO kehadiran
      (user_id,tanggal,waktu_pulang,status)
      VALUES('$id','$tgl','$jam','Pulang')");
    $msg="Absen Pulang";
  }
}

/* ===== HAPUS ===== */
if(isset($_GET['hapus'])){
  mysqli_query($conn,"DELETE FROM kehadiran WHERE id='$_GET[hapus]'");
  header("Location: absensi.php?menu=data");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Absensi Online</title>
<style>
body{margin:0;font-family:Segoe UI;background:#f2f2f2}
.sidebar{width:220px;height:100vh;background:#2f3b45;float:left;color:#fff}
.sidebar h2{padding:15px}
.sidebar a{display:block;color:#fff;padding:12px;text-decoration:none}
.sidebar a:hover{background:#1abc9c}

.top{background:#3c4b57;color:#fff;padding:15px;margin-left:220px}
.main{margin-left:220px;padding:20px}

.card{background:#fff;border-radius:6px;padding:20px;margin-bottom:20px}
.flex{display:flex;gap:20px}
.btn{padding:8px 14px;border:none;border-radius:4px;cursor:pointer}
.btn-primary{background:#007bff;color:#fff}
.btn-dark{background:#343a40;color:#fff}
.badge{background:green;color:#fff;padding:5px 10px;border-radius:10px}

table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ccc;padding:8px;text-align:center}
th{background:#f0f0f0}
</style>
</head>
<body>

<?php if(!isset($_SESSION['login'])){ ?>
<!-- ===== LOGIN ===== -->
<div class="card" style="width:350px;margin:100px auto">
<h3>Login Absensi</h3>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="POST">
<input type="text" name="username" placeholder="Username" required><br><br>
<input type="password" name="password" placeholder="Password" required><br><br>
<button class="btn btn-primary" name="login">Login</button>
</form>
</div>

<?php }else{ ?>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
<h2>Absensi Online</h2>
<a href="?menu=dashboard">Dashboard</a>
<a href="?menu=data">Data Kehadiran</a>
<a href="?logout=1">Logout</a>
</div>

<div class="top">
Login sebagai: <b><?= $_SESSION['nama']; ?></b>
</div>

<div class="main">
<?php $menu=$_GET['menu'] ?? 'dashboard'; ?>

<?php if($menu=='dashboard'){ ?>
<!-- ===== DASHBOARD ===== -->
<div class="flex">
<div class="card" style="flex:2">
<h3>Identitas</h3>
<p><b>Nama:</b> <?= $_SESSION['nama']; ?></p>
<p><b>Jabatan:</b> <?= $_SESSION['jabatan']; ?></p>
<p><b>Shift:</b> <span class="badge">Full Time</span></p>
</div>

<div class="card" style="flex:1;text-align:center">
<h3>Absensi</h3>
<h2><?= date("H:i:s"); ?></h2>
<p><?= date("l, d F Y"); ?></p>

<?php if(isset($msg)) echo "<p style='color:green'>$msg</p>"; ?>

<form method="POST">
<button class="btn btn-dark" name="absen">Absen</button>
</form>
</div>
</div>
<?php } ?>

<?php if($menu=='data'){ ?>
<!-- ===== FILTER ===== -->
<?php
$search=$_GET['search'] ?? '';
$bulan=$_GET['bulan'] ?? '';
?>
<div class="card">
<form method="GET" style="display:flex;justify-content:space-between">
<input type="hidden" name="menu" value="data">
<input type="text" name="search" placeholder="Cari nama..." value="<?= $search ?>">
<input type="month" name="bulan" value="<?= $bulan ?>">
<div>
<button class="btn btn-primary">Search</button>
<a href="?menu=data" class="btn btn-dark">Refresh</a>
</div>
</form>
</div>

<!-- ===== TABLE ===== -->
<div class="card">
<h3>Data Kehadiran</h3>
<table>
<tr>
<th>No</th><th>Tanggal</th><th>Nama</th>
<th>Datang</th><th>Pulang</th>
<th>Status</th><th>Aksi</th>
</tr>

<?php
$no=1;
$sql="SELECT k.*,u.nama FROM kehadiran k JOIN users u ON k.user_id=u.id WHERE 1";
if($search!=''){ $sql.=" AND u.nama LIKE '%$search%'"; }
if($bulan!=''){ $sql.=" AND k.tanggal LIKE '$bulan%'"; }
$sql.=" ORDER BY k.id DESC";
$q=mysqli_query($conn,$sql);

while($r=mysqli_fetch_assoc($q)){
?>
<tr>
<td><?= $no++; ?></td>
<td><?= $r['tanggal']; ?></td>
<td><?= $r['nama']; ?></td>
<td><?= $r['waktu_datang'] ?? '-'; ?></td>
<td><?= $r['waktu_pulang'] ?? '-'; ?></td>
<td><?= $r['status']; ?></td>
<td>
<a href="?menu=data&hapus=<?= $r['id']; ?>"
onclick="return confirm('Hapus data?')">Hapus</a>
</td>
</tr>
<?php } ?>
</table>
</div>
<?php } ?>

</div>
<?php } ?>
</body>
</html>