<?php
session_start(); // Start the session to access session variables
require "connection.php"; // Include your database connection

// Check if the ID is provided
if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $id = $_REQUEST['id'];

    // Fetch the item details to display
    $sql = "SELECT * FROM book_library WHERE ID = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Store the item details for display
            $publish_date = htmlspecialchars($row['PUBLISH_DATE']);
            $title = htmlspecialchars($row['TITLE']);
            $description = htmlspecialchars($row['DESCRIPTION']);
            $category = htmlspecialchars($row['CATEGORY']);
            $author = htmlspecialchars($row['AUTHOR']);
            $publisher = htmlspecialchars($row['PUBLISHER']);
            $isbn = htmlspecialchars($row['ISBN']);
            $image = htmlspecialchars($row['image']); // Get the image path
        } else {
            $_SESSION['notification'] = "Book not found.";
            header("Location: list.php");
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['notification'] = "Error preparing statement.";
        header("Location: list.php");
        exit();
    }
} else {
    $_SESSION['notification'] = "Invalid ID provided.";
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Deletion</title>
    <link rel="stylesheet" href="del_style.css"> 
</head>
<body>
    <img src="<?php echo $image; ?>" alt="Book Image" class="book-image"> 
    <div class = details-container>
		<div class="book-details">
        <h2>CONFIRM  BOOK DELETION</h2>
        <p><strong>Title:</strong> <?php echo $title; ?></p>
        <p><strong>Author:</strong> <?php echo $author; ?></p>
        <p><strong>Publisher:</strong> <?php echo $publisher; ?></p>
        <p><strong>Publish Date:</strong> <?php echo $publish_date; ?></p>
        <p><strong>ISBN:</strong> <?php echo $isbn; ?></p>
        <p><strong>Description:</strong> <?php echo $description; ?></p>
        <p><strong> ARE YOU SURE YOU WANT TO DELETE THIS BOOK?</strong></p>
        <div class="button-container">
            <form action="delete_action.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" class="button confirm">DELETE</button>
            </form>
            <a href="list.php" class="button cancel">CANCEL</a>
        </div>
    </div>
</div>
</body>
</html>