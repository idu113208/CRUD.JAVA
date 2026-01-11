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
                    <div class="form-floating mb-3">
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Lengkap" autocomplete="name" required>
                        <label for="nama">Nama Lengkap</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" autocomplete="email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="new-password" required>
                        <label for="password">Password</label>
                    </div>
                    <button type="submit" name="register" class="btn btn-success w-100">Daftar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>