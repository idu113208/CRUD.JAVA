<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero { background: #f8f9fa; padding: 100px 0; text-align: center; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">SI-ALUMNI</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="views/auth/login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="views/auth/register.php">Daftar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div class="container">
            <h1>Selamat Datang di Sistem Informasi Alumni</h1>
            <p class="lead">Melacak jejak alumni, membangun jejaring profesional.</p>
            <a href="views/map.php" class="btn btn-primary btn-lg">Lihat Peta Persebaran</a>
            <a href="views/auth/register.php" class="btn btn-outline-secondary btn-lg">Bergabung Sekarang</a>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <h3>Tracer Study</h3>
                <p>Isi data pekerjaan untuk membantu akreditasi kampus.</p>
            </div>
            <div class="col-md-4 text-center">
                <h3>GIS Mapping</h3>
                <p>Lihat di mana alumni bekerja melalui peta interaktif.</p>
            </div>
            <div class="col-md-4 text-center">
                <h3>Jejaring</h3>
                <p>Temukan teman seangkatan dan bangun relasi.</p>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5 py-4 bg-light">
        <p>&copy; <?php echo date('Y'); ?> Sistem Informasi Alumni</p>
    </footer>
</body>
</html>