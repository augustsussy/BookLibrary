<?php
session_start(); // Start the session
require "connection.php"; // Include the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $publish_date = $_POST['publish_date'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $isbn = $_POST['isbn'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target_dir = "images/"; // Directory where images will be stored
        $target_file = $target_dir . basename($image);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            $_SESSION['notification'] = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (optional)
        if ($_FILES['image']['size'] > 500000) { // Limit to 500KB
            $_SESSION['notification'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['notification'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['notification'] = "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Prepare the SQL statement
                $sql = "INSERT INTO book_library (PUBLISH_DATE, TITLE, DESCRIPTION, CATEGORY, AUTHOR, PUBLISHER, ISBN, IMAGE) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                // Initialize a prepared statement
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    // Bind parameters
                    mysqli_stmt_bind_param($stmt, "ssssssss", $publish_date, $title, $description, $category, $author, $publisher, $isbn, $target_file);
                    
                    // Execute the statement
                    if (mysqli_stmt_execute($stmt)) {
                        $_SESSION['notification'] = "Record added successfully."; // Set success message
                    } else {
                        $_SESSION['notification'] = "Error: " . mysqli_error($conn); // Set error message
                    }
                    
                    // Close the statement
                    mysqli_stmt_close($stmt);
                } else {
                    $_SESSION['notification'] = "Error preparing statement: " . mysqli_error($conn); // Set error message
                }
            } else {
                $_SESSION['notification'] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $_SESSION['notification'] = "No image uploaded or there was an upload error.";
    }

    // Redirect to the list page
    header("Location: list.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>