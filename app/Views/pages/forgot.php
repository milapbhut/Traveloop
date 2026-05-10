<section class="auth-panel">
    <div class="auth-visual compact" aria-hidden="true"></div>
    <form class="auth-card" action="<?= url('/login') ?>" method="post">
        <h1>Reset Password</h1>
        <p class="muted">Enter your email and continue with demo login for now.</p>
        <label>
            <span>Email address</span>
            <input type="email" name="email" required>
        </label>
        <button class="button primary" type="submit">Continue</button>
    </form>
</section>
