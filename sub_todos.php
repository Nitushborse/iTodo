<?php
require "./includes/auth.php";
require "./classes/_db_connect.php";
check_login();

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (isset($_GET['id'])) {
    // Sanitize and validate the input
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if ($id === false) {
        echo "Invalid ID!";
        exit;
    }

    // Prepare the SQL statement
    if ($stmt = $con->conn->prepare("SELECT `id`, `title`, `is_complete` FROM `sub_todos` WHERE `todo_id` = ?")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        echo "Failed to prepare the statement!";
        exit;
    }
} else {
    echo "ID not set!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./includes/headers.php" ?>
    <title>TODO | Sub-Todo</title>
    <style>
        a {
            text-decoration: none;
        }

        .title {
            height: 3.9rem;

        }
    </style>
</head>

<body>
    <?php include "./includes/navbar.php" ?>
    <div style="min-height: 79vh;" class="d-flex justify-content-center align-items-start">

        <div class="container mt-5 d-flex flex-column justify-content-center align-items-center">
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="container d-flex align-items-center py-3 border border-dark border-3 rounded-4 w-75 row mb-1">

                        <div class="col-12 col-md-10 overflow-y-auto title">
                            <?php $is_complete = ($row['is_complete']) == 0 ? "" : "text-decoration-line-through"; ?>

                            <h1 class="fs-4 text-wrap <?= $is_complete; ?>"><?= htmlspecialchars($row['title']); ?></h1>
                        </div>
                        <div class="d-lg-none d-block border-top border-dark border-3 my-3"></div>
                        <div class="col-2 fs-4 d-flex gap-2 border-md-top">
                            <a href="delete_sub_todo.php?id=<?= urlencode($row['id']); ?>&todo_id=<?= urlencode($id); ?>">

                                <img style="width: 30px;" src="./assets/delete_icon.png" alt="icon">
                            </a>
                            <?php if (($row['is_complete']) == 0): ?>
                                <a href="update_sub_todo.php?id=<?= urlencode($row['id']); ?>&todo_id=<?= urlencode($id); ?>">
                                    <img style="width: 30px;" src="./assets/update_icon.png" alt="icon">
                                </a>
                            <?php endif ?>

                            <a href="check_is_complete.php?id=<?= urlencode($row['id']); ?>&todo_id=<?= urlencode($id); ?>">
                                <img style="width: 30px;" <?php $is_complete = ($row['is_complete']) == 0 ? "complete_icon.png" : "not_complete_icon.png"; ?> 
                                src="./assets/<?= $is_complete ?>" alt="icon">
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="d-flex align-items-center justify-content-center">No sub-todos found.</p>
            <?php endif; ?>
            <?php
            $stmt->close();
            $con->conn->close();
            ?>


            <div class="container mt-4 border border-dark border-3 rounded-4 w-75 row">
                <div class="col-12 col-md-10 p-2 d-flex align-items-center justify-content-center mx-auto">
                    <a href="add_sub_todo.php?todo_id=<?= urlencode($id); ?>"><img class="align-self-center" style="width: 55px;" src="./assets/add_icon.png" alt="add icon"></a>
                </div>
            </div>
        </div>
    </div>
    <?php include "./includes/footer.php" ?>
</body>

</html>