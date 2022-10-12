<?php include("templates/header.php") ?>

<div class="container">
    <div class="form-center">
        
        <form action="login.php" method="POST" class="border p-5 form">

            <h1>Login</h1><br>
            
            <div class="form-group">
                <label for="InputEmail">Email address</label>
                <input type="email" required name="email" id="InputEmail" class="form-control" placeholder="Enter your mail">
            </div>

            <div class="form-group">
                <label for="InputPassword">Password</label>
                <input type="password" required name="password" id="InputPassword" class="form-control" placeholder="Enter your password">
            </div><br>

            <?php if (!empty($message)): ?>
                <p><?= $message; ?></p>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">Login</button><br><br>

            <span><p>You don't have an account on cdkeys_proyect yet? <a href="signup.php">SignUp</a></p></span>

        </form>
    </div>
</div>

<?php include("templates/footer.php") ?>