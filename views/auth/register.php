<?php session_start(); ?>
<?php include '../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mt-5">
            <div class="card-header bg-success text-white">Registrasi Alumni</div>
            <div class="card-body">
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <form action="../../controllers/AuthController.php" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-control" autocomplete="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" autocomplete="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-success w-100 mb-3">Daftar</button>
                    <div class="text-center">
                        <a href="login.php" class="text-decoration-none">Sudah punya akun? Login disini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>