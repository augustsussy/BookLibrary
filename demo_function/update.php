<?php
session_start(); // Start the session to access session variables
require "connection.php"; // Include your database connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $publish_date = $_POST['publish_date'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $isbn = $_POST['isbn'];

    // Initialize the image variable
    $target_file = null;

    // Handle image upload if a new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Process the uploaded image
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Image upload successful
        } else {
            $_SESSION['notification'] = "Error uploading image.";
            header("Location: form_edit.php?id=" . $id);
            exit();
        }
    } else {
        // If no new image is uploaded, keep the existing image
        $sql = "SELECT image FROM book_library WHERE ID = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $target_file = $row['image']; // Keep the existing image path
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Check if the ID exists before updating
    $check_sql = "SELECT COUNT(*) FROM book_library WHERE ID = ?";
    if ($check_stmt = mysqli_prepare($conn, $check_sql)) {
        mysqli_stmt_bind_param($check_stmt, "i", $id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_bind_result($check_stmt, $count);
        mysqli_stmt_fetch($check_stmt);
        mysqli_stmt_close($check_stmt);

        if ($count == 0) {
            $_SESSION['notification'] = "No book found with ID: $id";
            header("Location: list.php");
            exit();
        }
    }

    // Prepare the SQL statement
    $sql = "UPDATE book_library SET
        PUBLISH_DATE = ?,
        TITLE = ?,
        DESCRIPTION = ?,
        CATEGORY = ?,
        AUTHOR = ?,
        PUBLISHER = ?,
        ISBN = ?,
        image = ?
        WHERE ID = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssssssi", $publish_date, $title, $description, $category, $author, $publisher, $isbn, $target_file, $id);

        // Debugging: Log the parameters
        error_log("Updating book with ID: $id");
        error_log("Publish Date: $publish_date, Title: $title, Description: $description, Category: $category, Author: $author, Publisher: $publisher, ISBN: $isbn, Image: $target_file");

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['notification'] = "Record updated successfully.";
            header("Location: list.php"); // Redirect to the book list page
            exit();
        } else {
            $_SESSION['notification'] = "Error updating record: " . mysqli_error($conn);
            header("Location: form_edit.php?id=" . $id); // Redirect back to the form
            exit();
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['notification'] = "Error preparing statement.";
        header("Location: form_edit.php?id=" . $id); // Redirect back to the form
        exit();
    }
} else {
    $_SESSION['notification'] = "Invalid request method.";
    header("Location: form_edit.php?id=" . $id); // Redirect back to the form
    exit();
}

// Close the database connection
mysqli_close($conn);
?>