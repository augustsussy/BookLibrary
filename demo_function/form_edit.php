<?php
session_start(); // Start the session to access session variables
include "connection.php";  // Include your database connection

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing book details from the database
    $sql = "SELECT * FROM book_library WHERE ID = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Store the existing values in variables
            $publish_date = $row['PUBLISH_DATE'];
            $title = $row['TITLE'];
            $description = $row['DESCRIPTION'];
            $category = $row['CATEGORY'];
            $author = $row['AUTHOR'];
            $publisher = $row['PUBLISHER'];
            $isbn = $row['ISBN'];
            $image = $row['image'];
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
    $_SESSION['notification'] = "No ID provided.";
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add_styles.css"> <!-- Link to the new CSS file -->
    <title>Update Book</title>
</head>
        
<body>
<div class="form-container">
        <h2>Update Book Details</h2>
        <h2><strong></strong> <?php echo htmlspecialchars($id); ?></h2> <!-- display for book ID -->
        <form action="update.php" method="POST" class="form" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="publish_date">Publish Date:</label>
            <input type="date" id="publish_date" name="publish_date" value="<?php echo htmlspecialchars($publish_date); ?>" required>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" required>

            <label for="publisher">Publisher:</label>
            <input type="text" id="publisher" name="publisher" value="<?php echo htmlspecialchars($publisher); ?>" required>

            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" required>

            <label for="image">Book Image:</label>
            <input type="file" name="image" accept="image/*"> <!-- optional -->

            <p>Current Image: <img src="<?php echo htmlspecialchars($image); ?>" alt="Current Image" style="max-width: 100px;"></p> <!-- Display current image -->

            <button type="submit">UPDATE BOOK</button> <!-- This button will now be centered -->
        </form>
        <div class="back-button" style="margin-top: 20px;">
            <a class="button" href="list.php">BACK TO BOOK LIST</a>
        </div>
    </div>
</body>
</html>