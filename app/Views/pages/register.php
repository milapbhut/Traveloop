<section class="auth-panel wide">
    <div class="auth-visual" aria-hidden="true"></div>
    <form class="auth-card" action="<?= url('/register') ?>" method="post">
        <div class="avatar-placeholder">Photo</div>
        <h1>Registration Screen</h1>
        <div class="two-col">
            <label>
                <span>First name</span>
                <input type="text" name="first_name" required>
            </label>
            <label>
                <span>Last name</span>
                <input type="text" name="last_name" required>
            </label>
            <label>
                <span>Email address</span>
                <input type="email" name="email" required>
            </label>
            <label>
                <span>Phone number</span>
                <input type="tel" name="phone">
            </label>
            <label>
                <span>City</span>
                <input type="text" name="city">
            </label>
            <label>
                <span>Country</span>
                <input type="text" name="country">
            </label>
        </div>
        <label>
            <span>Password</span>
            <input type="password" name="password" required>
        </label>
        <label>
            <span>Additional information</span>
            <textarea name="bio" rows="4" placeholder="Favorite travel style, dietary notes, accessibility preferences"></textarea>
        </label>
        <button class="button primary" type="submit">Register user</button>
    </form>
</section>
