<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="register-box">
            <h1>Create Account</h1>
            <?php if (isset($message)) : ?>
                <p class="<?= $message === 'registrasi berhasil, silakan login' ? 'success' : 'error'?>"><?= $message ?></p>
            <?php endif ?>

            <p>Join us today! It only takes a minute.</p>
            <form action="/register" method="POST">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="terms">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to the <a href="#">Terms and Conditions</a></label>
                </div>
                <button type="submit">Register</button>
            </form>
            <p class="login-link">Already have an account? <a href="/login">Log in</a></p>
        </div>
    </div>
</body>

</html>