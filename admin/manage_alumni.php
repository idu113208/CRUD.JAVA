<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/auth/login.php");
    exit();
}

include_once '../config/database.php';
include_once '../models/Alumni.php';

$database = new Database();
$db = $database->getConnection();
$alumni = new Alumni($db);

if(isset($_POST['delete'])) {
    $id_to_delete = $_POST['id_alumni'];
    if($alumni->delete($id_to_delete)) {
        $msg = "Data berhasil dihapus.";
    } else {
        $error = "Gagal menghapus data.";
    }
}

$stmt = $alumni->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3>Manajemen Alumni</h3>
        <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

        <?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>NPM</th>
                    <th>Angkatan</th>
                    <th>Prodi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td>
                        <?php if($row['foto']): ?>
                            <img src="../assets/img/<?php echo $row['foto']; ?>" width="50">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['npm']; ?></td>
                    <td><?php echo $row['angkatan']; ?></td>
                    <td><?php echo $row['program_studi']; ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Yakin hapus?');">
                            <input type="hidden" name="id_alumni" value="<?php echo $row['id_alumni']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>