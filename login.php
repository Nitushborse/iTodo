<?php
// session_start();
include "./classes/_db_connect.php";
$errors = array();
if (isset($_POST["submit"]) && $_SERVER['REQUEST_METHOD'] == "POST") {

    // Colecting input values 
    $user_name_or_email = trim($_POST['user_name_or_email']);
    $password = $_POST['password'];


    // validating input feilds
    if (empty($user_name_or_email)) {
        array_push($errors, "User name is required.");
    }
    if (empty($password)) {
        array_push($errors, "Password is required.");
    }

    // if validation is succesful then proced to chack user name and password is valid
    if (empty($errors)) {
        $stmt = $con->conn->prepare("SELECT * FROM `users` WHERE `user_name` = ? OR `email` = ?");
        $stmt->bind_param("ss", $user_name_or_email, $user_name_or_email);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows == 1) {
            // array_push($errors, "User name already exists.");
            $user = $result->fetch_assoc();


            if (password_verify($password, $user['pass'])) {
                // Password is correct
                session_start();
                $_SESSION["is_loged_in"] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['user_name'];
                header('location:index.php'); // Redirect to a dashboard or home page
                // exit();
            } else {
                array_push($errors, "Incorrect password.");
            }
        } else {
            array_push($errors, "User not found.");
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?PHP include "./includes/headers.php" ?>
    <title>TODO | Login</title>
</head>

<body>
    <?PHP include "./includes/navbar.php" ?>
    <div style="min-height: 79vh;" class="d-flex justify-content-center align-items-center">
        <div class="container d-flex justify-content-center flex-column my-5 h-100">
            <h1 class="text-center">Log In</h1>
            <?php if (!empty($errors)) : ?>
                <div class="border border-3 rounded-3 w-50 mx-auto border-danger my-3">
                    <div class="mx-2 my-2 list-group list-group-checkable d-grid gap-1 border-0">
                        <?php foreach ($errors as $err) : ?>
                            <label class="list-group-item bg-opacity-50 bg-danger rounded-3 p-2">
                                <?= $err ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php $errors = []; ?>
            <?php endif; ?>
            <form class="w-50 mx-auto" method="post" action="" autocomplete="on">
                <div class="mb-3">
                    <label for="user_name" class="form-label">User Name</label>
                    <input placeholder="Enter User name or Email" type="text" class="form-control" id="user_name" name="user_name_or_email">
                </div>
                <div class="mb-3">
                    <label for="Password1" class="form-label">Password</label>
                    <input placeholder="Enter Password" type="password" class="form-control" id="Password1" name="password">
                </div>
                <p class="my-3">Don't hava an account? <a href="register.php">Register</a></p>
                <button type="submit" name="submit" class="btn btn-dark">Login</button>
            </form>
        </div>
    </div>

    <?PHP include "./includes/footer.php" ?>
</body>

</html>