<?php
session_start();
//   session_start();
include "./classes/_db_connect.php";
// $con = new DBConnection();
// $con->conn;

$errors = array();


if (isset($_POST["submit"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $user_name = trim($_POST['user_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $avatar_img = $_FILES['avatar_img'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Validate fields
    if (empty($first_name)) {
        array_push($errors, "First name is required.");
    }
    if (empty($last_name)) {
        array_push($errors, "Last name is required.");
    }
    if (empty($user_name)) {
        array_push($errors, "User name is required.");
    }
    if (empty($email)) {
        array_push($errors, "Email is required.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format.");
    }
    if (empty($mobile)) {
        array_push($errors, "Mobile number is required.");
    } elseif (strlen($mobile) < 10) {
        array_push($errors, "Mobile number must be at least 10 characters long.");
    }
    if (empty($password)) {
        array_push($errors, "Password is required.");
    } elseif (strlen($password) < 6) {
        array_push($errors, "Password must be at least 6 characters long.");
    }
    if ($avatar_img['error'] != UPLOAD_ERR_OK) {
        array_push($errors, "Avatar image is required.");
    } else {
        $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $detected_type = exif_imagetype($avatar_img['tmp_name']);
        if (!in_array($detected_type, $allowed_types)) {
            array_push($errors, "Only PNG, JPEG, and GIF images are allowed.");
        }
    }

    // echo "<pre>";
    // print_r($_FILES["file"]);
    // echo "</pre>";

    // $filename = $_FILES["file"]["name"];
    // $temp_file = $_FILES["file"]["tmp_name"];
    // $loc = "uploads/";
    // move_uploaded_file($temp_file,$loc . $filename);
    // $filename = $avatar_img["avatar_img"]["name"];
    // $temp_file = $avatar_img["avatar_img"]["tmp_name"];
    // $loc = "up/";
    // move_uploaded_file($temp_file, $loc . $filename);
    // echo "file";




    // if (empty($errors)) {
    //     // Process the form data, e.g., save to database
    //     // Redirect or show success message
    //     // $sql = "INSERT INTO `users` (`first_name`,`last_name`,`user_name`, `email`, `mobile_no`,`avater_url`, `pass`) VALUES ( '$first_name', '$last_name', '$user_name', '$email', '$mobile','','$password_hash')";

    //     // header('location:login.php');
    // }

    // $sql1 = "SELECT * FROM `users` WHERE `user_name` = `$user_name`";
    // $result1 = $con->conn->query($sql1);
    // if($result1->num_rows > 0){
    //     array_push($errors, "User name alrady exist.");
    // }
    
    // Check if the user name already exists
    $stmt = $con->conn->prepare("SELECT * FROM `users` WHERE `user_name` = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result1 = $stmt->get_result();
    if ($result1->num_rows > 0) {
        array_push($errors, "User name already exists.");
    }
    $stmt->close();

    // Check if the email already exists
    $stmt = $con->conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result2 = $stmt->get_result();
    if ($result2->num_rows > 0) {
        array_push($errors, "Email already exists.");
    }
    $stmt->close();

    if (empty($errors)) {
        // Process the form data, e.g., save to database
        // echo "<pre>";
        // print_r($_FILES["avatar_img"]);
        // echo "</pre>";
        $filename = $_FILES["avatar_img"]["name"];
        $temp_file = $_FILES["avatar_img"]["tmp_name"];
        $loc = "uploads/";
        if (move_uploaded_file($temp_file, $loc . $filename)) {
            // echo "File uploaded successfully.";
            $avatae_uri =  $loc . $filename;

            // Database insertion code can be added here
            // Example: 
            $sql = "INSERT INTO `users` (`first_name`, `last_name`, `user_name`, `email`, `mobile_no`, `avatar_url`, `pass`) VALUES ('$first_name', '$last_name', '$user_name', '$email', '$mobile', '$avatae_uri', '$password_hash')";

            $result = $con->conn->query($sql);
            if ($result) {
                header('location:login.php');
            } else {
                array_push($errors, "Failed to save user data.");
            }
        } else {
            array_push($errors, "Failed to upload file.");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?PHP include "./includes/headers.php" ?>
    <title>TODO | Register</title>
</head>

<body>
    <?PHP include "./includes/navbar.php" ?>
    <div class="container d-flex justify-content-center flex-column mt-3">
        <h1 class="text-center">Register</h1>
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


        <form class="w-50 mx-auto" method="post" action="" autocomplete="on" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name">
            </div>
            <div class="mb-3">
                <label for="user_name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name">
            </div>
            <div class="mb-3">
                <label for="email1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email1" aria-describedby="emailHelp" name="email">
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile No</label>
                <input type="text" class="form-control" id="mobile" name="mobile">
            </div>
            <div class="mb-3">
                <label for="avatar_img1" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar_img1" name="avatar_img">
            </div>
            <div class="mb-3">
                <label for="Password1" class="form-label">Password</label>
                <input type="password" class="form-control" id="Password1" name="password">
            </div>
            <p class="my-3">already hava an account? <a href="login.php">Login</a></p>
            <button type="submit" name="submit" class="btn btn-dark">Submit</button>
        </form>
    </div>
    <?PHP include "./includes/footer.php" ?>
</body>

</html>