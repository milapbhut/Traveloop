<section class="auth-panel">
    <div class="auth-visual" aria-hidden="true"></div>
    <form class="auth-card" action="<?= url('/login') ?>" method="post">
        <div class="avatar-placeholder">Photo</div>
        <h1>Login Screen</h1>
        <label>
            <span>Email address</span>
            <input type="email" name="email" placeholder="you@example.com" required>
        </label>
        <label>
            <span>Password</span>
            <input type="password" name="password" placeholder="Password" required>
        </label>
        <button class="button primary" type="submit">Login</button>
        <div class="inline-links">
            <a href="<?= url('/register') ?>">Create account</a>
            <a href="<?= url('/forgot-password') ?>">Forgot password</a>
        </div>
    </form>
</section>
