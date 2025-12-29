<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Absensi Online - Single Page</title>
<style>
  /* Layout sizes tuned to match the sketch proportions */
  :root{
    --sidebar-w:240px;
    --gutter:18px;
    --card-bg:#fff;
    --muted:#666;
    --accent:#2f3a46;
    --paper:#fbfbfb;
  }
  html,body{height:100%;margin:0;font-family: 'Segoe UI', Tahoma, Arial, sans-serif;background:var(--paper);color:#222}
  /* header */
  .topbar{
    position:fixed;top:0;left:0;right:0;height:70px;background:#f7f7f7;border-bottom:2px solid #ddd;
    display:flex;align-items:center;padding:0 var(--gutter);box-sizing:border-box;
  }
  .topbar h1{margin:0;font-weight:600;font-size:28px;letter-spacing:0.6px}
  .topbar .user{margin-left:auto;font-size:22px;opacity:.8}
  /* main layout */
  .layout{display:flex;min-height:calc(100vh - 70px);margin-top:70px}
  /* sidebar */
  .sidebar{
    width:var(--sidebar-w);
    background:#fafafa;
    border-right:2px solid #ddd;
    padding:22px;
    box-sizing:border-box;
    position:relative;
  }
  .sidebar h3{margin:0 0 12px 0;font-size:16px}
  .nav-item{padding:10px 6px;border-radius:4px;cursor:pointer;margin-bottom:10px;font-size:18px}
  .nav-item.active{font-weight:700}
  .sidebar .welcome{position:absolute;bottom:18px;left:22px;right:22px;font-size:14px;color:var(--muted)}
  /* main content */
  .main{flex:1;padding:var(--gutter);box-sizing:border-box}
  /* cards row */
  .row{display:flex;gap:20px;align-items:flex-start}
  .card{background:var(--card-bg);border:2px solid #ddd;border-radius:6px;padding:14px;box-sizing:border-box}
  .card.center{flex:1 1 auto;min-width:520px}
  .card.right{width:320px;flex-shrink:0}
  .card h2{margin:0 0 8px 0;font-size:18px;display:flex;align-items:center;gap:8px}
  .profile{display:flex;gap:18px;align-items:flex-start}
  .avatar{width:110px;height:110px;border:2px solid #bbb;border-radius:6px;background:linear-gradient(#fff,#f2f2f2);display:flex;align-items:center;justify-content:center;font-size:40px;color:#999}
  .info p{margin:8px 0;font-size:15px}
  .muted{color:var(--muted)}
  .footer-note{border-top:2px solid #e9e9e9;margin-top:12px;padding-top:10px;font-size:14px}
  /* Big time (right card) */
  .time-large{font-size:34px;font-weight:700;margin:6px 0;text-align:center}
  .date-small{text-align:center;color:var(--muted);margin-bottom:10px}
  select, input[type="text"]{padding:8px;border-radius:6px;border:1px solid #ccc;background:#fff;box-sizing:border-box}
  .btn{padding:10px 14px;border-radius:6px;border:1px solid #666;background:#f4f4f4;cursor:pointer}
  .btn.primary{background:#2b7cff;color:#fff;border-color:#2b7cff}
  .status-badge{display:inline-block;padding:6px 10px;border-radius:6px}
  .status-late{background:#dc3545;color:#fff}
  /* Data Kehadiran table */
  .page-title{display:flex;justify-content:space-between;align-items:center}
  .table-wrap{background:#fff;border:2px solid #ddd;padding:14px;border-radius:6px}
  .table-actions{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
  .table-actions .left{display:flex;align-items:center;gap:8px}
  .entries-select{padding:6px 8px;border-radius:6px;border:1px solid #ccc}
  table{width:100%;border-collapse:collapse}
  th,td{border:1px solid #cfcfcf;padding:10px;text-align:left;vertical-align:middle}
  th{background:#f6f6f6}
  td.center{text-align:center}
  .pager{display:flex;align-items:center;gap:8px;justify-content:flex-end;margin-top:12px}
  .page-num{padding:6px 10px;border:1px solid #ccc;border-radius:6px;background:#fff}
  /* modal */
  .modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,0.4);display:none;align-items:center;justify-content:center;z-index:80}
  .modal{background:#fff;padding:16px;border-radius:8px;width:420px;box-shadow:0 8px 40px rgba(0,0,0,0.25)}
  /* footer bottom */
  .bottom-bar{border-top:2px solid #ddd;margin-top:16px;padding:12px 0;text-align:center;color:var(--muted)}
  /* small responsive */
  @media(max-width:980px){
    .row{flex-direction:column}
    .card.right{width:100%}
    .sidebar{display:none}
    .main{margin-left:0}
  }
</style>
</head>
<body>

  <div class="topbar">
    <h1>Absensi Online</h1>
    <div class="user">👤</div>
  </div>

  <div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar" aria-label="Sidebar">
      <h3>HOME</h3>
      <div id="menu-dashboard" class="nav-item active" onclick="navigate('dashboard')">◉ Dashboard</div>
      <hr style="border:none;border-top:1px solid #eee;margin:10px 0">
      <h3>MENU</h3>
      <div id="menu-kehadiran" class="nav-item" onclick="navigate('kehadiran')">□ Data Kehadiran</div>

      <div class="welcome">
        <div style="font-size:13px;color:#999">Selamat Datang:</div>
        <div style="font-weight:700">Nurul A. Sagama</div>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <!-- DASHBOARD VIEW -->
      <section id="view-dashboard">
        <div class="row">
          <div class="card center">
            <h2>👤 Identitas Diri</h2>
            <div style="height:8px;border-top:2px solid #eee;margin-bottom:10px"></div>

            <div class="profile">
              <div class="avatar">N</div>
              <div class="info">
                <p><strong>Nama Lengkap:</strong> <span id="txtNama">Nurul A. Sagama</span></p>
                <p><strong>Umur:</strong> 21 Tahun</p>
                <p><strong>Instansi:</strong> PAUD Amal Tododara TIKEP</p>
                <p><strong>Jabatan:</strong> Guru</p>
                <p><strong>NPWP:</strong> Tidak Ada</p>
                <p><strong>Tempat/Tanggal Lahir:</strong> Tidore, 2004-03-13</p>
                <p><strong>Jenis Kelamin:</strong> Perempuan</p>
                <p><strong>Shift Bekerja:</strong> Full Time</p>
              </div>
            </div>

            <div class="footer-note">
              <div><strong>Kode Pegawai:</strong> <span id="kodePegawai">054491262739806</span></div>
              <div style="color:var(--muted);margin-top:6px">Akun Dibuat: 23 April 2025</div>
            </div>
          </div>

          <div class="card right">
            <h2>🕒 Absensi</h2>
            <div style="height:8px;border-top:2px solid #eee;margin-bottom:6px"></div>

            <div class="time-large" id="clock">00:00:00</div>
            <div class="date-small" id="dateText">Jumat, 28 November 2025</div>

            <div style="margin:12px 0">
              <select id="workMode" onchange="onModeChange()">
                <option value="kantor">Bekerja Di Kantor</option>
                <option value="luar">Bekerja Di Luar Kantor</option>
              </select>
            </div>

            <div style="margin-top:10px;text-align:center">
              <div style="font-weight:600">Status Kehadiran: <span id="attStatus">Belum Absen</span></div>
              <div style="margin-top:8px">Waktu Datang: <span id="timeDatang">00:00:00</span></div>
              <div>Waktu Pulang: <span id="timePulang">00:00:00</span></div>
            </div>

            <div style="margin-top:14px;text-align:center">
              <button id="btnAbsen" class="btn primary" onclick="handleAbsen()">Absen</button>
            </div>

            <div style="margin-top:14px;border-top:1px solid #eee;padding-top:10px;font-size:14px;color:var(--muted);text-align:left">
              <div><strong>Absen Datang Jam:</strong> 07:00:00</div>
              <div style="margin-top:6px"><strong>Absen Pulang Jam:</strong> 11:13:00</div>
            </div>
          </div>
        </div>
      </section>

      <!-- DATA KEHADIRAN VIEW -->
      <section id="view-kehadiran" style="display:none">
        <div class="page-title" style="margin-bottom:12px">
          <div style="font-size:22px;font-weight:700">👥 Data Kehadiran</div>
          <div><button class="btn" onclick="refreshTable()">⟳ Refresh Tabel</button></div>
        </div>

        <div class="table-wrap card">
          <div class="table-actions">
            <div class="left">
              <label style="display:flex;align-items:center;gap:8px">
                Show
                <select id="entriesPerPage" class="entries-select" onchange="renderTable()">
                  <option value="5">5</option>
                  <option value="10" selected>10</option>
                  <option value="25">25</option>
                </select>
                entries
              </label>
            </div>
            <div style="display:flex;align-items:center;gap:10px">
              <label style="color:var(--muted)">Search:</label>
              <input id="searchBox" type="text" placeholder="Cari..." oninput="onSearch()" />
            </div>
          </div>

          <div style="overflow:auto">
            <table id="attendanceTable" role="table" aria-label="Data Kehadiran">
              <thead>
                <tr>
                  <th style="width:50px">No</th>
                  <th>Tanggal</th>
                  <th>Nama Pegawai</th>
                  <th>Waktu Datang</th>
                  <th>Waktu Pulang</th>
                  <th style="width:120px">Status</th>
                  <th style="width:110px">Aksi</th>
                </tr>
              </thead>
              <tbody id="tbody"></tbody>
            </table>
          </div>

          <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px">
            <div id="showingText" class="muted">Showing 0 to 0 of 0 entries</div>
            <div class="pager">
              <button class="btn" onclick="prevPage()">Previous</button>
              <div class="page-num" id="currentPage">1</div>
              <button class="btn" onclick="nextPage()">Next</button>
            </div>
          </div>
        </div>
      </section>

      <div class="bottom-bar">
        Copyright © 2025 Absensi by kelompok 2
      </div>
    </main>
  </div>

  <!-- EDIT MODAL -->
  <div id="modal" class="modal-backdrop">
    <div class="modal">
      <h3>Edit Absensi</h3>
      <div style="margin-top:8px">
        <label>Nama Pegawai</label>
        <input id="editNama" type="text" />
      </div>
      <div style="margin-top:8px">
        <label>Tanggal</label>
        <input id="editTanggal" type="date" />
      </div>
      <div style="margin-top:8px;display:flex;gap:8px">
        <div style="flex:1"><label>Waktu Datang</label><input id="editDatang" type="time" /></div>
        <div style="flex:1"><label>Waktu Pulang</label><input id="editPulang" type="time" /></div>
      </div>
      <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
        <button class="btn" onclick="closeModal()">Batal</button>
        <button class="btn primary" onclick="saveEdit()">Simpan</button>
      </div>
    </div>
  </div>

<script>
/* ------------------------
   In-memory data + persistence
   ------------------------ */
const STORAGE_KEY = 'absensi_data_v1';
let dataStore = JSON.parse(localStorage.getItem(STORAGE_KEY) || 'null');
if(!dataStore){
  // initial sample data (from your example)
  dataStore = [
    {
      id: 1,
      tanggal: '2025-11-07',
      tanggalText: 'Jumat, 7 November 2025',
      nama: 'Nurul A. Sagama',
      waktu_datang: '12:46:28',
      waktu_pulang: '12:46:34',
      status: 'Absen Terlambat'
    }
  ];
  localStorage.setItem(STORAGE_KEY, JSON.stringify(dataStore));
}

/* ------------- Clock ------------- */
function pad(n){return n<10?'0'+n:n}
function nowTime(){return new Date().toLocaleTimeString('id-ID')}
function nowDateText(){return new Date().toLocaleDateString('id-ID',{ weekday:'long', day:'numeric', month:'long', year:'numeric'})}

function startClock(){
  document.getElementById('clock').textContent = nowTime();
  document.getElementById('dateText').textContent = nowDateText();
  setInterval(()=> document.getElementById('clock').textContent = nowTime(), 1000);
}
startClock();

/* ------------- Navigation ------------- */
function navigate(view){
  document.getElementById('view-dashboard').style.display = view==='dashboard'? 'block' : 'none';
  document.getElementById('view-kehadiran').style.display = view==='kehadiran'? 'block' : 'none';
  document.getElementById('menu-dashboard').classList.toggle('active', view==='dashboard');
  document.getElementById('menu-kehadiran').classList.toggle('active', view==='kehadiran');
  if(view==='kehadiran') renderTable();
}

/* ------------- Absen logic (add arrival / set pulang) ------------- */
const currentPegawai = { id: 1, nama: 'Nurul A. Sagama', kode: '054491262739806' };
let arrivalFlag = false; // simple toggle for demo

function handleAbsen(){
  const mode = document.getElementById('workMode').value;
  const today = new Date().toISOString().slice(0,10); // YYYY-MM-DD
  // find latest for today
  const exists = dataStore.find(r => r.tanggal === today && r.nama === currentPegawai.nama);
  const time = nowTime();

  if(!exists){
    // insert datang
    const nextId = dataStore.length ? Math.max(...dataStore.map(r=>r.id)) + 1 : 1;
    const rec = {
      id: nextId,
      tanggal: today,
      tanggalText: (new Date()).toLocaleDateString('id-ID',{ weekday:'long', day:'numeric', month:'long', year:'numeric'}),
      nama: currentPegawai.nama,
      waktu_datang: time,
      waktu_pulang: '-',
      status: 'Hadir',
      mode_kerja: mode
    };
    dataStore.unshift(rec);
    persist();
    document.getElementById('attStatus').textContent = 'Sudah Absen (Datang)';
    document.getElementById('timeDatang').textContent = time;
    alert('Absen datang tersimpan: ' + time);
  } else {
    // if exists but no pulang -> set pulang
    if(!exists.waktu_pulang || exists.waktu_pulang === '-' || exists.waktu_pulang === null){
      exists.waktu_pulang = time;
      exists.status = 'Pulang';
      persist();
      document.getElementById('attStatus').textContent = 'Sudah Absen (Pulang)';
      document.getElementById('timePulang').textContent = time;
      alert('Absen pulang tersimpan: ' + time);
    } else {
      // already completed today -> create new datang entry
      const nextId = dataStore.length ? Math.max(...dataStore.map(r=>r.id)) + 1 : 1;
      const rec = {
        id: nextId,
        tanggal: today,
        tanggalText: (new Date()).toLocaleDateString('id-ID',{ weekday:'long', day:'numeric', month:'long', year:'numeric'}),
        nama: currentPegawai.nama,
        waktu_datang: time,
        waktu_pulang: '-',
        status: 'Hadir',
        mode_kerja: mode
      };
      dataStore.unshift(rec);
      persist();
      document.getElementById('attStatus').textContent = 'Sudah Absen (Datang)';
      document.getElementById('timeDatang').textContent = time;
      alert('Absen datang (baru) tersimpan: ' + time);
    }
  }
  // if user currently on data page, refresh table
  if(document.getElementById('view-kehadiran').style.display !== 'none') renderTable();
}

function persist(){ localStorage.setItem(STORAGE_KEY, JSON.stringify(dataStore)); }

/* ------------- Table rendering, search, pagination ------------- */
let filtered = [...dataStore];
let currentPage = 1;

function onSearch(){
  const q = (document.getElementById('searchBox').value || '').trim().toLowerCase();
  filtered = dataStore.filter(r => {
    return r.nama.toLowerCase().includes(q) || (r.tanggalText||r.tanggal).toLowerCase().includes(q) || (r.status||'').toLowerCase().includes(q);
  });
  currentPage = 1;
  renderTable();
}

function refreshTable(){
  // reload from storage (acts as refresh)
  dataStore = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
  filtered = [...dataStore];
  currentPage = 1;
  document.getElementById('searchBox').value = '';
  renderTable();
  alert('Tabel berhasil diperbarui');
}

function renderTable(){
  const perPage = parseInt(document.getElementById('entriesPerPage').value,10) || 10;
  // ensure filtered sync
  filtered = filtered.length ? filtered : [...dataStore];
  const total = filtered.length;
  const pages = Math.max(1, Math.ceil(total / perPage));
  if(currentPage > pages) currentPage = pages;
  const start = (currentPage - 1) * perPage;
  const end = Math.min(total, start + perPage);

  const tbody = document.getElementById('tbody');
  tbody.innerHTML = '';
  if(total === 0){
    tbody.innerHTML = '<tr><td colspan="7" class="center">Tidak ada data</td></tr>';
  } else {
    for(let i=start;i<end;i++){
      const r = filtered[i];
      const tr = document.createElement('tr');
      const statusClass = r.status === 'Absen Terlambat' ? 'status-late' : '';
      tr.innerHTML = `
        <td class="center">${i+1}</td>
        <td>${r.tanggalText || r.tanggal}</td>
        <td>${r.nama}</td>
        <td class="center">${r.waktu_datang || '-'}</td>
        <td class="center">${r.waktu_pulang || '-'}</td>
        <td class="center"><span class="status-badge ${statusClass}">${r.status || '-'}</span></td>
        <td class="center">
          <button class="btn" onclick="openEdit(${r.id})">ED</button>
          <button class="btn" style="background:#dc3545;color:#fff" onclick="deleteRecord(${r.id})">DEL</button>
        </td>
      `;
      tbody.appendChild(tr);
    }
  }
  document.getElementById('showingText').textContent = `Showing ${total? start+1 : 0} to ${total? end : 0} of ${total} entries`;
  document.getElementById('currentPage').textContent = currentPage;
}

function prevPage(){ if(currentPage>1){ currentPage--; renderTable(); } }
function nextPage(){ const perPage = parseInt(document.getElementById('entriesPerPage').value,10)||10; const maxp = Math.max(1, Math.ceil(filtered.length/perPage)); if(currentPage < maxp){ currentPage++; renderTable(); } }

/* ------------- Edit / Delete ------------- */
let editingId = null;
function openEdit(id){
  const rec = dataStore.find(r=>r.id===id);
  if(!rec) return alert('Data tidak ditemukan');
  editingId = id;
  document.getElementById('editNama').value = rec.nama;
  document.getElementById('editTanggal').value = rec.tanggal;
  document.getElementById('editDatang').value = rec.waktu_datang && rec.waktu_datang!=='-' ? rec.waktu_datang.substring(0,5) : '';
  document.getElementById('editPulang').value = rec.waktu_pulang && rec.waktu_pulang!=='-' ? rec.waktu_pulang.substring(0,5) : '';
  document.getElementById('modal').style.display = 'flex';
}

function closeModal(){
  document.getElementById('modal').style.display = 'none';
  editingId = null;
}

function saveEdit(){
  if(!editingId) return;
  const rec = dataStore.find(r=>r.id===editingId);
  if(!rec) return alert('Data tidak ditemukan');
  rec.nama = document.getElementById('editNama').value || rec.nama;
  const d = document.getElementById('editTanggal').value;
  if(d) { rec.tanggal = d; rec.tanggalText = (new Date(d)).toLocaleDateString('id-ID',{ weekday:'long', day:'numeric', month:'long', year:'numeric'}); }
  const datang = document.getElementById('editDatang').value;
  const pulang = document.getElementById('editPulang').value;
  rec.waktu_datang = datang ? (da = datang + ':00') : rec.waktu_datang;
  rec.waktu_pulang = pulang ? (pulang + ':00') : rec.waktu_pulang;
  rec.status = rec.waktu_pulang && rec.waktu_pulang !== '-' ? 'Pulang' : 'Hadir';
  persist();
  closeModal();
  renderTable();
  alert('Perubahan tersimpan');
}

/* ------------- Delete ------------- */
function deleteRecord(id){
  if(!confirm('Yakin ingin menghapus data ini?')) return;
  dataStore = dataStore.filter(r=>r.id !== id);
  filtered = filtered.filter(r=>r.id !== id);
  persist();
  renderTable();
  alert('Data berhasil dihapus');
}

/* ------------- Helpers ------------- */
function onModeChange(){ /* placeholder for future */ }

/* init: show dashboard and prefill */
document.getElementById('txtNama').textContent = currentPegawai.nama;
document.getElementById('kodePegawai').textContent = currentPegawai.kode;
renderTable();

</script>
</body>
</html>
