<?php
include "./classes/_db_connect.php";
require_once "./includes/auth.php";
check_login();
$user_id = $_SESSION['user_id'];
$errors = array();

if (isset($_GET['todo_id'])){

    $todo_id = filter_var($_GET['todo_id'], FILTER_VALIDATE_INT);

    if ($todo_id === false) {
        echo "Invalid ID!";
        exit;
    }

    if (isset($_POST["submit"]) && $_SERVER['REQUEST_METHOD'] == "POST") {

        $todo_title = trim($_POST['todo_title']);
        
    
        // Validate fields
        if (empty($todo_title)) {
            array_push($errors, "Title is required.");
        }
    
    
        if (empty($errors)) {
            // Prepare the SQL statement
    
            $stmt = $con->conn->prepare("INSERT INTO `sub_todos` (`userid`, `todo_id`, `title`, `is_complete`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
    
            // Check if the statement was prepared successfully

            if ($stmt === false) {
                array_push($errors, "Failed to prepare the SQL statement.");
            } 
            else {
                // Bind parameters
                $is_complete = 0;
                $stmt->bind_param("iisi", $user_id, $todo_id, $todo_title, $is_complete);
    
                // Execute the statement
                if ($stmt->execute()) {
                    header('location:sub_todos.php?id='.$todo_id); // Uncomment and specify location if needed
                    exit;
                } 
                else {
                    array_push($errors, "Failed to save user data.");
                }
    
                // Close the statement
                $stmt->close();
            }
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
            <h1 class="text-center my-3">Create A New Todo</h1>
            <?php if (!empty($errors)) : ?>
                <div class="border border-3 rounded-3 w-50 mx-auto border-danger my-3">
                    <div class="mx-2 my-2 list-group list-group-checkable d-grid gap-1 border-0">
                        <?php foreach ($errors as $err) : ?>
                            <label class="list-group-item bg-opacity-50 bg-danger rounded-3 p-2">
                                <?= htmlspecialchars($err) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php $errors = []; ?>
            <?php endif; ?>


            <form class="w-50 mx-auto my-3" method="post" action="" autocomplete="off">
                <div class="mb-3">
                    <label for="todo_title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="todo_title" name="todo_title" placeholder="Enter A New Todo">
                </div>
                
                <button type="submit" name="submit" class="btn btn-dark">Add</button>
            </form>
        </div>
    </div>
    <?PHP include "./includes/footer.php" ?>
</body>

</html>