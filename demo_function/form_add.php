<?php
session_start(); // Start the session to access session variables
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add_styles.css"> <!-- Link to the new CSS file -->
    <title>Add Book</title>
</head>
<body>
    

    <div class="form-container">
        <h2>Add New Book</h2>
        <form action="add.php" method="POST" enctype="multipart/form-data" class="form">
            <label for="publish_date">Publish Date:</label>
            <input type="date" id="publish_date" name="publish_date" required>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <label for="publisher">Publisher:</label>
            <input type="text" id="publisher" name="publisher" required>

            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" required>

            <label for="image">Book Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit">ADD BOOK</button>
        </form>
        <div class="back-button" style="margin-top: 20px;">
            <a class="button" href="list.php">BACK TO BOOK LIST</a>
        </div>
    </div>
</body>
</html>