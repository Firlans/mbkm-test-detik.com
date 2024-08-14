<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Login</h1>
            <?php if (isset($message)) : ?>
                <p class="error"><?= $message ?></p>
            <?php endif ?>
            <p>Please login to your account</p>
            <form action="/login" method="post">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p class="signup-link">Don't have an account? <a href="/register">Sign up</a></p>
        </div>
    </div>
</body>
</html>