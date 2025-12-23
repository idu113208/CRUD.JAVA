<?php session_start(); ?>
<?php include '../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mt-5">
            <div class="card-header bg-primary text-white">
                <h3 class="h5 mb-0">Login Alumni / Admin</h3>
            </div>
            <div class="card-body">
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <form action="../../controllers/AuthController.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" autocomplete="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 mb-3">Login</button>
                    <div class="text-center">
                        <small>Belum punya akun? <a href="register.php">Daftar disini</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>