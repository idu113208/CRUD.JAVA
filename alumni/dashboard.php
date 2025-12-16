<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'alumni') {
    header("Location: ../views/auth/login.php");
    exit();
}

include_once '../config/database.php';
include_once '../models/Alumni.php';
include_once '../models/Tracer.php';

$database = new Database();
$db = $database->getConnection();
$alumni = new Alumni($db);
$tracer = new Tracer($db);

$data_alumni = $alumni->getByUserId($_SESSION['user_id']);
$id_alumni = $data_alumni['id_alumni'] ?? null;
$data_tracer = null;
if($id_alumni) {
    $data_tracer = $tracer->getByAlumniId($id_alumni);
}

// Handle Form Submission
if(isset($_POST['update_profile'])) {

    // Handle File Upload
    $foto_name = $data_alumni['foto'] ?? '';
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/img/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Simple check
        if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
            if(move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $foto_name = basename($_FILES["foto"]["name"]);
            }
        }
    }

    if(!$id_alumni) {
        // Create new
        $alumni->id_user = $_SESSION['user_id'];
        $alumni->npm = $_POST['npm'];
        $alumni->angkatan = $_POST['angkatan'];
        $alumni->program_studi = $_POST['program_studi'];
        $alumni->alamat = $_POST['alamat'];
        $alumni->no_hp = $_POST['no_hp'];
        $alumni->foto = $foto_name;

        if($alumni->create()) {
             $msg = "Profil dibuat.";
             $data_alumni = $alumni->getByUserId($_SESSION['user_id']);
             $id_alumni = $data_alumni['id_alumni'];
        }
    } else {
        // Update
        $alumni->id_user = $_SESSION['user_id'];
        $alumni->npm = $_POST['npm'];
        $alumni->angkatan = $_POST['angkatan'];
        $alumni->program_studi = $_POST['program_studi'];
        $alumni->alamat = $_POST['alamat'];
        $alumni->no_hp = $_POST['no_hp'];
        $alumni->foto = $foto_name;

        $alumni->update();
        $msg = "Profil diperbarui.";
    }
}

if(isset($_POST['update_tracer']) && $id_alumni) {
    $tracer->id_alumni = $id_alumni;
    $tracer->status_kerja = $_POST['status_kerja'];
    $tracer->instansi = $_POST['instansi'];
    $tracer->jabatan = $_POST['jabatan'];
    $tracer->tahun_mulai_kerja = $_POST['tahun_mulai_kerja'];
    $tracer->latitude = $_POST['latitude'];
    $tracer->longitude = $_POST['longitude'];

    if($tracer->saveOrUpdate()) {
        $msg_tracer = "Data Tracer disimpan.";
        $data_tracer = $tracer->getByAlumniId($id_alumni);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 mb-5">
        <h1>Dashboard Alumni</h1>
        <p>Halo, <?php echo $_SESSION['nama']; ?></p>
        <a href="../views/map.php" class="btn btn-info mb-3">Lihat Peta Persebaran</a>
        <a href="../controllers/AuthController.php?action=logout" class="btn btn-danger mb-3">Logout</a>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Data Profil</div>
                    <div class="card-body">
                        <?php if(isset($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3 text-center">
                                <?php if(isset($data_alumni['foto']) && $data_alumni['foto']): ?>
                                    <img src="../assets/img/<?php echo $data_alumni['foto']; ?>" width="100" class="img-thumbnail">
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label>Foto Profil</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>NPM</label>
                                <input type="text" name="npm" class="form-control" value="<?php echo $data_alumni['npm'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Angkatan</label>
                                <input type="number" name="angkatan" class="form-control" value="<?php echo $data_alumni['angkatan'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Program Studi</label>
                                <input type="text" name="program_studi" class="form-control" value="<?php echo $data_alumni['program_studi'] ?? ''; ?>" required>
                            </div>
                             <div class="mb-3">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control"><?php echo $data_alumni['alamat'] ?? ''; ?></textarea>
                            </div>
                             <div class="mb-3">
                                <label>No HP</label>
                                <input type="text" name="no_hp" class="form-control" value="<?php echo $data_alumni['no_hp'] ?? ''; ?>">
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-primary">Simpan Profil</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Tracer Study (Pekerjaan & Lokasi)</div>
                    <div class="card-body">
                         <?php if(!$id_alumni): ?>
                            <div class="alert alert-warning">Lengkapi Profil terlebih dahulu.</div>
                         <?php else: ?>
                            <?php if(isset($msg_tracer)) echo "<div class='alert alert-info'>$msg_tracer</div>"; ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label>Status Kerja</label>
                                    <select name="status_kerja" class="form-control">
                                        <option value="Bekerja" <?php echo ($data_tracer['status_kerja']??'') == 'Bekerja' ? 'selected' : ''; ?>>Bekerja</option>
                                        <option value="Wiraswasta" <?php echo ($data_tracer['status_kerja']??'') == 'Wiraswasta' ? 'selected' : ''; ?>>Wiraswasta</option>
                                        <option value="Lanjut Studi" <?php echo ($data_tracer['status_kerja']??'') == 'Lanjut Studi' ? 'selected' : ''; ?>>Lanjut Studi</option>
                                        <option value="Belum Bekerja" <?php echo ($data_tracer['status_kerja']??'') == 'Belum Bekerja' ? 'selected' : ''; ?>>Belum Bekerja</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Instansi</label>
                                    <input type="text" name="instansi" class="form-control" value="<?php echo $data_tracer['instansi'] ?? ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label>Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" value="<?php echo $data_tracer['jabatan'] ?? ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label>Tahun Mulai</label>
                                    <input type="number" name="tahun_mulai_kerja" class="form-control" value="<?php echo $data_tracer['tahun_mulai_kerja'] ?? ''; ?>">
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Latitude</label>
                                        <input type="text" name="latitude" class="form-control" value="<?php echo $data_tracer['latitude'] ?? ''; ?>" placeholder="-6.200">
                                    </div>
                                    <div class="col">
                                        <label>Longitude</label>
                                        <input type="text" name="longitude" class="form-control" value="<?php echo $data_tracer['longitude'] ?? ''; ?>" placeholder="106.816">
                                    </div>
                                </div>
                                <small class="text-muted">Gunakan Google Maps untuk mendapatkan koordinat.</small>
                                <br><br>
                                <button type="submit" name="update_tracer" class="btn btn-success">Simpan Data Tracer</button>
                            </form>
                         <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>