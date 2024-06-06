<?php
// require "./includes/auth.php";
// require "./classes/_db_connect.php";
// check_login();


// if (isset($_GET['id'])){
//     $id = $_GET['id']; 
//     // DELETE FROM `users` WHERE `users`.`id` = 15
//     $stmt = $con->conn->prepare("DELETE FROM `todo_card` WHERE `id` = ?");
    
//     if ($stmt === false) {
//         // array_push($errors, "Failed to prepare the SQL statement.");

//     } 
//     else {
//         // Bind parameters
//         $stmt->bind_param("i", $id);

//         // Execute the statement
//         if ($stmt->execute()) {
//             header('location:home.php'); // Uncomment and specify location if needed
//         } 
//         else {
//             echo "Failed to delete todo!";
//         }

//         // Close the statement
//         $stmt->close();
//     }

// }


?>

<?php
require "./includes/auth.php";
require "./classes/_db_connect.php";
check_login();

if (isset($_GET['id'])) {
    // Sanitize and validate the input
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    // $id = $_GET['id']; 
    
    if ($id === false) {
        // echo $id;
        echo "Invalid ID!";
        exit;
    }

    // Prepare the SQL statement
    $stmt = $con->conn->prepare("DELETE FROM `todo_card` WHERE `id` = ?");
    
    if ($stmt === false) {
        // Handle statement preparation error
        echo "Failed to prepare the SQL statement.";
    } else {
        // Bind parameters
        $stmt->bind_param("i", $id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to home.php
            header('Location: home.php');
            exit;
        } else {
            echo "Failed to delete todo!";
        }

        // Close the statement
        $stmt->close();
    }
} else {
    echo "ID not set!";
}
?>
