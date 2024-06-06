<?php
require "./includes/auth.php";
require "./classes/_db_connect.php";
check_login();

if (isset($_GET['id'])) {
    // Sanitize and validate the input
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    $todo_id = filter_var($_GET['todo_id'], FILTER_VALIDATE_INT);
     
    
    if ($id === false) {
        echo "Invalid ID!";
        exit;
    }

    // Prepare the SQL statement
    $stmt = $con->conn->prepare("DELETE FROM `sub_todos` WHERE `id` = ?");
    
    if ($stmt === false) {
        // Handle statement preparation error
        echo "Failed to prepare the SQL statement.";
    } 
    else {
        // Bind parameters
        $stmt->bind_param("i", $id);

        // Execute the statement
        if ($stmt->execute()) {
            header('Location: sub_todos.php?id='.$todo_id);
            exit;
        } 
        else {
            echo "Failed to delete todo!";
        }

        // Close the statement
        $stmt->close();
    }
} 
else {
    echo "ID not set!";
}
?>
