<?php
include "./classes/_db_connect.php";
include "./includes/auth.php";
check_login();


if (isset($_GET['id']) && isset($_GET['todo_id'])) {

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    $todo_id = filter_var($_GET['todo_id'], FILTER_VALIDATE_INT);

    if ($id === false || $todo_id === false) {
        echo "Invalid input.";
        exit;
    }

    $stmt = $con->conn->prepare("SELECT `is_complete` FROM `sub_todos` WHERE `id` = ?");
    if ($stmt === false) {
        echo "Failed to prepare the SQL statement.";
        exit;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $flag = $row['is_complete'];

        $is_com = $flag == 1 ? 0 : 1;

        $stmt1 = $con->conn->prepare("UPDATE `sub_todos` SET `is_complete` = ?, `updated_at` = CURRENT_TIMESTAMP WHERE `id` = ? AND `todo_id` = ?");

        if ($stmt1 === false) {
            echo "Failed to prepare the SQL statement.";
        } else {
            $stmt1->bind_param("iii", $is_com, $id, $todo_id);

            if ($stmt1->execute()) {
                header('Location: sub_todos.php?id=' . $todo_id);
                exit;
            } else {
                echo "Failed to update sub-todo.";
            }

            $stmt1->close();
        }
    } else {
        echo "No matching sub-todo found.";
    }

    $stmt->close();
} else {
    echo "ID or Todo ID not set.";
}
