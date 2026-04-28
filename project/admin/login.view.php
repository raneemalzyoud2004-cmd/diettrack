<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>DietTrack | Admin Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(4, 187, 133, 0.12), rgba(238, 249, 255, 0.95));
            font-family: "Open Sans", sans-serif;
        }
        .login-wrap {
            min-height: 100vh;
        }
        .login-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 0 45px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .brand-pane {
            background: var(--primary);
            color: #fff;
            padding: 2rem;
        }
        .form-pane {
            background: #fff;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="container login-wrap d-flex align-items-center justify-content-center py-5">
        <div class="card login-card w-100" style="max-width: 900px;">
            <div class="row g-0">
                <div class="col-md-5 brand-pane d-flex flex-column justify-content-center">
                    <h2 class="mb-3 text-white">DietTrack Admin</h2>
                    <p class="mb-0">Sign in to manage appointments, diet plans, and clinic operations.</p>
                </div>
                <div class="col-md-7 form-pane">
                    <h4 class="mb-4">Admin Login</h4>
                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger py-2"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control py-3" id="username" name="username" placeholder="Enter admin username" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control py-3" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3">Login</button>
                    </form>
                    <p class="text-muted small mt-3 mb-0">Default: admin / admin123</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
