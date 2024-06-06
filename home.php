<?php
require "./includes/auth.php";
require "./classes/_db_connect.php";
check_login();

// Fetch data from database
$stmt = $con->conn->prepare("SELECT `id`, `title`, `description`, `color` FROM `todo_card` WHERE `user_id` = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./includes/headers.php" ?>
    <title>TODO | Home</title>
    <style>
        .card {
            position: relative;
        }
        .card a.cover-link {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }
        .card a.delete-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            margin: 16px;
            z-index: 2;
        }
        #delete_icon {
            width: 30px;
        }
    </style>
</head>

<body>
    <?php include "./includes/navbar.php" ?>
    <div style="min-height: 79vh;" class="d-flex justify-content-center align-items-center">
        <div class="container mt-5 h-100 position-relative">
            <div class="row">
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <div class="col-md-4">
                            <div class="card mb-4" style="height: 180px; background-color:<?php echo $row['color']; ?>;">
                                <a href="sub_todos.php?id=<?= urlencode($row['id']); ?>" class="cover-link"></a>
                                <div class="card-body h-100 overflow-auto mt-3">
                                    <h5 class="card-title"><?= $row['title']; ?></h5>
                                    <p class="card-text"><?= $row['description']; ?></p>
                                    <a href="delete_todo.php?id=<?= urlencode($row['id']); ?>" class="delete-icon">
                                        <img id="delete_icon" src="./assets/delete_icon.png" alt="delete icon" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php $stmt->close(); ?>
                <?php endif ?>
                <div class="col-md-4">
                    <div class="card d-flex justify-content-center align-items-center flex-column" style="height: 180px;">
                        <div class="card-body h-100 overflow-auto mt-3">
                            <a href="add_todo.php"><img src="./assets/add_icon.png" alt="add icon"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "./includes/footer.php" ?>
</body>

</html>

