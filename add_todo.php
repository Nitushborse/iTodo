<?php
// session_start();

include "./classes/_db_connect.php";
require_once "./includes/auth.php";
check_login();
$user_id = $_SESSION['user_id'];
$errors = array();


if (isset($_POST["submit"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $card_title = trim($_POST['card_title']);
    $card_description = trim($_POST['card_description']);
    $card_color = trim($_POST['card_color']);

    // Validate fields
    if (empty($card_title)) {
        array_push($errors, "Title is required.");
    }
    if (empty($card_description)) {
        array_push($errors, "Description is required.");
    }
    if (empty($card_color)) {
        array_push($errors, "Color is required.");
    }


    // Check the card title is already exists or not
    $stmt = $con->conn->prepare("SELECT * FROM `todo_card` WHERE `title` = ?");
    $stmt->bind_param("s", $card_title);
    $stmt->execute();
    $result1 = $stmt->get_result();
    if ($result1->num_rows > 0) {
        array_push($errors, "Title already exists.");
    }
    $stmt->close();


    // if (empty($errors)) {

    //     $sql = "INSERT INTO `todo_card` (`user_id`, `title`, `description`, `color`, `created_at`, `updated_at`) VALUES ('$user_id', '$card_title', '$card_description', '$card_color', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

    //     $result = $con->conn->query($sql);
    //     if ($result) {
    //         // header('location:');
    //         echo "seved";
    //     } else {
    //         array_push($errors, "Failed to Create New Todo Catogury.");
    //     }
    // }

    if (empty($errors)) {
        // Prepare the SQL statement
        $stmt = $con->conn->prepare("INSERT INTO `todo_card` (`user_id`, `title`, `description`, `color`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");

        // Check if the statement was prepared successfully
        if ($stmt === false) {
            array_push($errors, "Failed to prepare the SQL statement.");
        } else {
            // Bind parameters
            $stmt->bind_param("isss", $user_id, $card_title, $card_description, $card_color);

            // Execute the statement
            if ($stmt->execute()) {
                header('location:home.php'); // Uncomment and specify location if needed
                // echo "saved";
            } else {
                array_push($errors, "Failed to save user data.");
            }

            // Close the statement
            $stmt->close();
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
    <title>TODO | Create New Todo</title>
</head>

<body>
    <?PHP include "./includes/navbar.php" ?>
    <div style="min-height: 79vh;" class="d-flex justify-content-center align-items-center">
        <div class="container d-flex justify-content-center flex-column mt-3 h-100">
            <h1 class="text-center my-3">Create New Todo Catogury</h1>
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


            <form class="w-50 mx-auto my-3" method="post" action="" autocomplete="off">
                <div class="mb-3">
                    <label for="card_title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="card_title" name="card_title" placeholder="Enter New Todo class">
                </div>
                <div class="mb-3">
                    <label for="card_description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="card_description" name="card_description" placeholder="Enter Todo Description">
                </div>
                <div class="mb-3">
                    <label for="card_color" class="form-label">Select a Color</label>
                    <select class="form-control" id="card_color" name="card_color">
                        <option style="background-color: #153448;" value="#F5DAD2">color1</option>
                        <option style="background-color: #CA8787;" value="#CA8787">color2</option>
                        <option style="background-color: #7469B6;" value="#7469B6">color3</option>
                        <option style="background-color: #FC4100;" value="#FC4100">color4</option>
                        <option style="background-color: #A91D3A;" value="#A91D3A">color5</option>
                        <option style="background-color: #F5DAD2;" value="#F5DAD2">color6</option>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-dark">Add</button>
            </form>
        </div>
    </div>
    <?PHP include "./includes/footer.php" ?>
</body>

</html>