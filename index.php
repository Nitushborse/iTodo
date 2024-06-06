<?php
// require "./includes/auth.php";
$flag = true;
session_start();
if (!isset($_SESSION['is_loged_in'])) {
    $flag = false;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./includes/headers.php" ?>
    <title>TODO</title>
</head>

<body>
    <?php include "./includes/navbar.php" ?>
    <div style="min-height: 79vh;" class="d-flex justify-content-center align-items-center">
        <div class="container d-flex justify-content-center align-items-center flex-column h-100">
            <h1 class="my-5 fs-1 text-center fw-bold">Stay Organized, Stay Productive</h1>
            <p class="w-auto text-center fs-3  mb-5">Welcome to <span class="fw-bold">iTodo</span>, your ultimate solution to keep track of tasks and boost productivity.Manage your to-dos effortlessly with our user-friendly interface and powerful features.</p>
            <?php if($flag): ?>
            <div class="my-4">
                <a type="button" class="btn btn-dark fs-5 mx-2" href="add_todo.php">Add Todos</a>
                <a type="button" class="btn btn-dark fs-5 mx-2" href="home.php">View Todos</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include "./includes/footer.php" ?>
</body>

</html>