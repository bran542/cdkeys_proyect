<?php include("templates/header.php") ?>

<div class="container">
    <div class="form-center">
        
        <form action="signup.php" method="POST" class="border p-5 form">

            <h1>Register</h1><br>
            
            <div class="form-group">
                <label for="InputEmail">Email address</label>
                <input type="email" name="email" id="InputEmail" class="form-control" placeholder="Enter your mail">
            </div>

            <div class="form-group">
                <label for="InputPassword">Password</label>
                <input type="password" name="password" id="InputPassword" class="form-control" placeholder="Enter your password">
            </div>

            <div class="form-group">
                <label for="InputConfirm_Password">Confirm Password</label>
                <input type="password" name="confirm_password" id="InputConfirm_Password" class="form-control" placeholder="Confirm your password">
            </div><br>

            <button type="submit" class="btn btn-primary w-100">SignUp</button><br><br>

            <span><p>Already have an cdkeys_proyect account? <a href="login.php">Login</a></p></span>

        </form>
    </div>
</div>

<?php include("templates/footer.php")?>