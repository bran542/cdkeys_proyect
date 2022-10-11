<?php 
    include("configuration/db.php");

    $message = '';

    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password == $confirm_password) {
            $query = "INSERT INTO users (email, password) VALUES (:email, :password)";
            $stmt = $conn->prepare($query);
            //replace
            $stmt->bindParam(':email', $_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                $message = 'Successfully created new user';
            } else {
                $message = 'Error: Sorry there must have been an issue creating your account';
            }

        } else {
            $message = 'Error: Passwords do not match';
        }
        
    }
?>

<?php include("templates/header.php") ?>


<div class="container">
    <div class="form-center">
        
        <form action="signup.php" method="POST" class="border p-5 form">

            <h1>Register</h1><br>
            
            <div class="form-group">
                <label for="InputEmail">Email address</label>
                <input type="email" required name="email" id="InputEmail" class="form-control" placeholder="Enter your mail">
            </div>

            <div class="form-group">
                <label for="InputPassword">Password</label>
                <input type="password" required name="password" id="InputPassword" class="form-control" placeholder="Enter your password">
            </div>

            <div class="form-group">
                <label for="InputConfirm_Password">Confirm Password</label>
                <input type="password" required name="confirm_password" id="InputConfirm_Password" class="form-control" placeholder="Confirm your password">
            </div><br>

            <?php if (!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">SignUp</button><br><br>

            <span><p>Already have an cdkeys_proyect account? <a href="login.php">Login</a></p></span>

        </form>
    </div>
</div>

<?php include("templates/footer.php")?>