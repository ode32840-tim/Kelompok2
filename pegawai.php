<?php
session_start();

// Inisialisasi Data
if (!isset($_SESSION['pegawai'])) {
    $_SESSION['pegawai'] = [
        ['id' => '1', 'nama' => 'Trianingsi Hasan S.Pd', 'username' => 'trianingsi_h', 'jabatan' => 'Guru Tetap', 'instansi' => 'Sekolah ABC', 'npwp' => '09.254.123.4-541.000', 'umur' => '30', 'role' => 'Guru', 'shift' => 'Full Time']
    ];
}
if (!isset($_SESSION['absensi'])) { $_SESSION['absensi'] = []; }

// LOGIKA TAMBAH
if (isset($_POST['tambah_pegawai'])) {
    $id_baru = strval(time());
    $_SESSION['pegawai'][] = [
        'id'            => $id_baru,
        'nama'          => $_POST['nama'],
        'username'      => $_POST['username'],
        'jabatan'       => $_POST['jabatan'],
        'instansi'      => $_POST['instansi'],
        'npwp'          => $_POST['npwp'] ?: '-',
        'umur'          => $_POST['umur'],
        'role'          => $_POST['role'],
        'shift'         => 'Full Time'
    ];
    header("Location: index.php"); exit();
}

// LOGIKA UPDATE (EDIT)
if (isset($_POST['update_pegawai'])) {
    $id_target = $_POST['id_pegawai'];
    foreach ($_SESSION['pegawai'] as $key => $value) {
        if (strval($value['id']) === strval($id_target)) {
            $_SESSION['pegawai'][$key]['nama'] = $_POST['nama'];
            $_SESSION['pegawai'][$key]['username'] = $_POST['username'];
            $_SESSION['pegawai'][$key]['jabatan'] = $_POST['jabatan'];
            $_SESSION['pegawai'][$key]['npwp'] = $_POST['npwp'];
            $_SESSION['pegawai'][$key]['role'] = $_POST['role'];
            $_SESSION['pegawai'][$key]['umur'] = $_POST['umur'];
            break;
        }
    }
    header("Location: index.php"); exit();
}

// LOGIKA HAPUS & ABSEN
if (isset($_GET['aksi'])) {
    $id = $_GET['id'];
    if ($_GET['aksi'] == 'hapus') {
        foreach ($_SESSION['pegawai'] as $k => $v) { if (strval($v['id']) === strval($id)) unset($_SESSION['pegawai'][$k]); }
        $_SESSION['pegawai'] = array_values($_SESSION['pegawai']);
    } elseif ($_GET['aksi'] == 'absen') {
        foreach ($_SESSION['pegawai'] as $p) {
            if (strval($p['id']) === strval($id)) {
                $_SESSION['absensi'][] = ['nama' => $p['nama'], 'waktu' => date("H:i:s d-m-Y")];
                break;
            }
        }
    }
    header("Location: index.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen & Absensi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-size: 13px; }
        .nav-tabs .nav-link.active { font-weight: bold; color: #007bff; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body class="p-3">

<div class="container-fluid">
    <ul class="nav nav-tabs mb-3 no-print" id="tabMenu">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#data-pegawai">Data Pegawai</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#absen-guru">Menu Absen Guru</button></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="data-pegawai">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-bold">MANAJEMEN PEGAWAI</h3>
                    <button class="btn btn-success btn-sm no-print" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-plus"></i> Tambah Pegawai</button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped m-0">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>No</th><th>Nama</th><th>Jabatan</th><th>Role</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($_SESSION['pegawai'] as $p): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($p['nama']) ?></strong></td>
                                <td><?= htmlspecialchars($p['jabatan']) ?></td>
                                <td class="text-center"><span class="badge bg-info text-dark"><?= $p['role'] ?></span></td>
                                <td class="text-center no-print">
                                    <button class="btn btn-xs btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['id'] ?>"><i class="fas fa-edit"></i></button>
                                    <a href="?aksi=hapus&id=<?= $p['id'] ?>" class="btn btn-xs btn-danger" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <form method="POST" class="modal-content">
                                        <div class="modal-header"><h5>Edit Pegawai</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id_pegawai" value="<?= $p['id'] ?>">
                                            <div class="mb-2"><label>Nama</label><input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($p['nama']) ?>" required></div>
                                            <div class="mb-2"><label>Username</label><input type="text" name="username" class="form-control" value="<?= htmlspecialchars($p['username']) ?>" required></div>
                                            <div class="mb-2"><label>Jabatan</label><input type="text" name="jabatan" class="form-control" value="<?= htmlspecialchars($p['jabatan']) ?>" required></div>
                                            <div class="mb-2"><label>Role</label>
                                                <select name="role" class="form-select">
                                                    <option <?= $p['role']=='Guru'?'selected':'' ?>>Guru</option>
                                                    <option <?= $p['role']=='Staff'?'selected':'' ?>>Staff</option>
                                                    <option <?= $p['role']=='Admin'?'selected':'' ?>>Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button type="submit" name="update_pegawai" class="btn btn-primary btn-sm">Simpan</button></div>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="absen-guru">
            <div class="row">
                <div class="col-md-5">
                    <div class="card shadow"><div class="card-header bg-primary text-white text-bold">Pilih Nama Guru</div>
                        <div class="list-group list-group-flush">
                            <?php foreach($_SESSION['pegawai'] as $p): ?>
                                <a href="?aksi=absen&id=<?= $p['id'] ?>" class="list-group-item list-group-item-action">
                                    <strong><?= $p['nama'] ?></strong><br><small><?= $p['jabatan'] ?></small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card shadow"><div class="card-header bg-dark text-white text-bold">Riwayat Hadir</div>
                        <table class="table table-sm">
                            <thead><tr><th>Nama</th><th>Waktu</th></tr></thead>
                            <tbody>
                                <?php foreach(array_reverse($_SESSION['absensi']) as $a): ?>
                                <tr><td><?= $a['nama'] ?></td><td><?= $a['waktu'] ?></td></tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" class="modal-content text-start">
            <div class="modal-header"><h5>Tambah Pegawai</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body px-4">
                <div class="row mb-2"><label class="col-3">Nama</label><div class="col-9"><input type="text" name="nama" class="form-control" required></div></div>
                <div class="row mb-2"><label class="col-3">Username</label><div class="col-9"><input type="text" name="username" class="form-control" required></div></div>
                <div class="row mb-2"><label class="col-3">Jabatan</label><div class="col-9"><input type="text" name="jabatan" class="form-control" required></div></div>
                <div class="row mb-2"><label class="col-3">NPWP</label><div class="col-9"><input type="text" name="npwp" class="form-control"></div></div>
                <div class="row mb-2"><label class="col-3">Instansi</label><div class="col-9"><input type="text" name="instansi" class="form-control" value="Sekolah"></div></div>
                <div class="row mb-2"><label class="col-3">Umur</label><div class="col-9"><input type="number" name="umur" class="form-control"></div></div>
                <div class="row mb-2"><label class="col-3">Role</label>
                    <div class="col-9">
                        <select name="role" class="form-select">
                            <option>Guru</option><option>Staff</option><option>Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button type="submit" name="tambah_pegawai" class="btn btn-primary">Simpan Pegawai</button></div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>