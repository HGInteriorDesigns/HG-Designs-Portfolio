<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Jatin Designs</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: var(--bg-secondary);
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 40px;
            box-shadow: var(--shadow-md);
        }
        .login-card h1 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 30px;
        }
        .login-card h1 span {
            color: var(--accent-color);
            font-weight: 400;
        }
        .error-alert {
            background-color: rgba(211, 47, 47, 0.1);
            border: 1px solid rgba(211, 47, 47, 0.2);
            color: #d32f2f;
            padding: 12px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            border-radius: 2px;
            text-align: center;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        .back-link:hover {
            color: var(--text-primary);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h1>JATIN<span>.ADMIN</span></h1>
        
        <?php if (isset($error)): ?>
            <div class="error-alert">
                <i class="fa-solid fa-circle-exclamation"></i> <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <form action="/admin/login" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="admin">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn primary-btn btn-block">Sign In</button>
        </form>

        <a href="/" class="back-link"><i class="fa-solid fa-arrow-left-long"></i> Back to Portfolio</a>
    </div>

</body>
</html>
