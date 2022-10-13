<?php 
    include("configuration/db.php");

    if (!empty($_POST['email']) && !empty($_POST['password'])){
        $query = "SELECT id, email, password FROM users WHERE email=:email";
        $stmt = $conn->prepare($query);
        //replace
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $message = '';

        if (!empty($result)) {
            //if the result we get is not empty
            //we compare the password we get from the POST form with that of our database
            //if these match then it is a user that we do have in the database
            if (count($result) > 0 && password_verify($_POST['password'], $result['password'])){
                //allocate a session in memory with the id
                $_SESSION['user_id'] = $result['id'];
                header('Location: /cdkeys_proyect/view_administrator.php');
            } else {
                $message = 'Sorry, Those credentials do not match';
            }
        } else {
            $message = 'Account does not exist';
        }

    }

?>


<?php include("templates/header.php") ?>

<div class="container">
    <div class="form-center">
        
        <form action="login.php" method="POST" class="border p-5 form">

            <h1>Login</h1><br>
            
            <div class="form-group">
                <label for="InputEmail">Email address</label>
                <input type="email" required name="email" id="InputEmail" class="form-control" placeholder="Enter your mail" autofocus>
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