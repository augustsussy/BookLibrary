<?php
session_start();
include "connection.php";  // script will continue

$sql ="SELECT * FROM `book_library`";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Book Library</title>
    <style>
        .notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #f0f0e5;
            color: #56443f;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
            z-index: 1000;
        }
    </style>
</head>

<body>
<div class="carousel">
    <div class="carousel-images">
        <img src="images/bkk_cover.png" alt="Image 1" class="carousel-image active">
        <img src="images/cover_1.png" alt="Image 2" class="carousel-image">
        <img src="images/cover_2.png" alt="Image 3" class="carousel-image">
    </div>
    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="next" onclick="changeSlide(1)">&#10095;</button>
</div>
<div class="add-button" style = "margin-bottom: 20px;">
            <a class="button" href="form_add.php">ADD BOOK</a>
        </div>
<div class="table-container">


<div class="notification" id="notification">
        <?php
        // Display notification if it exists
        if (isset($_SESSION['notification'])) {
            echo $_SESSION['notification'];
            unset($_SESSION['notification']); // Clear the notification after displaying it
        }
        ?>
    </div>

    <script>
        // Show the notification if it exists
        const notification = document.getElementById('notification');
        if (notification.innerText) {
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none'; // Hide after 5 seconds
            }, 5000);
        }
    </script>

    

<?php if(mysqli_num_rows($result) > 0): ?>
    <table class="centered-table">
        <tr>
             <!-- New column for the image -->
            <th>BOOK ID</th>
            <th>PUBLISH DATE</th>
            <th>TITLE</th>
            <th>DESCRIPTION</th>
            <th>CATEGORY</th>
            <th>AUTHOR</th>
            <th>PUBLISHER</th>
            <th>ISBN</th>
            <th>IMAGE</th>
            <th>ACTION</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>

            <td><?php echo $row["ID"]; ?> </td>
            <td><?php echo $row["PUBLISH_DATE"]; ?> </td>
            <td><?php echo $row["TITLE"]; ?> </td>
            <td><?php echo $row["DESCRIPTION"]; ?> </td>
            <td><?php echo $row["CATEGORY"]; ?> </td>
            <td><?php echo $row["AUTHOR"]; ?> </td>
            <td><?php echo $row["PUBLISHER"]; ?> </td>
            <td><?php echo $row["ISBN"]; ?> </td>
            <td>
            <img src="<?php echo $row['image']; ?>" alt="Book Image" style="max-width: 100px; height: auto;">
            </td>
            <td>
                <div class="button-container">
                    <div class="edit-button">
                        <a class="button" href="form_edit.php?id=<?php echo $row["ID"]; ?>">EDIT</a>
                    </div>
                    <div class="delete-button">
                        <a class="button" href="delete.php?id=<?php echo $row["ID"]; ?>">DELETE</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </table> 
<?php else: ?>
    <p>No records found.</p>
<?php endif; ?>
    </div>

    <script>
let currentSlide = 0;
let slideInterval;

function showSlide(index) {
    const slides = document.querySelectorAll('.carousel-image');
    const totalSlides = slides.length;

    if (index >= totalSlides) {
        currentSlide = 0; // Loop back to the first slide
    } else if (index < 0) {
        currentSlide = totalSlides - 1; // Loop back to the last slide
    } else {
        currentSlide = index;
    }

    // Calculate the offset for the transform property
    const offset = -currentSlide * 100; // Move left by 100% of the current slide
    document.querySelector('.carousel-images').style.transform = `translateX(${offset}%)`;

    slides.forEach((slide, i) => {
        slide.classList.remove('active'); // Remove active class from all slides
        if (i === currentSlide) {
            slide.classList.add('active'); // Add active class to the current slide
        }
    });
}

function changeSlide(direction) {
    clearInterval(slideInterval); // Clear the automatic slide change
    showSlide(currentSlide + direction);
    restartSlideInterval(); // Restart the interval after manual change
}

// Function to start the automatic slide change
function startSlideInterval() {
    slideInterval = setInterval(() => {
        changeSlide(1);
    }, 5000);
}

// Function to restart the automatic slide change
function restartSlideInterval() {
    clearInterval(slideInterval); // Clear any existing interval
    startSlideInterval(); // Start a new interval
}

// Automatically change slides every 5 seconds (optional)
startSlideInterval(); // Start the interval on initial load

// Initial display
showSlide(currentSlide);
</script>
</body>
</html>