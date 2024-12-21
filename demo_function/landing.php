<?php
// landing.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <title>Landing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0e5; /* Light background */
            color: #56443f; /* Dark text */
            font-family: 'Poppins', sans-serif;
        }

        header {
            background-color: #8b645a; /* Header background */
            color: #f0f0e5; /* Header text */
            padding: 20px;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .text-content {
            flex: 1;
            max-width: 50%;
        }

        .text-content h1 {
            font-size: 2.5em;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 10px;
        }

        .text-content p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .cta-button {
            background-color: #56443f; /* Button background */
            color: #f0f0e5; /* Button text */
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
            font-weight: bold;
            font-family: 'Poppins', sans-serif;
        }

        .cta-button:hover {
            background-color: #c39d88; /* Button hover */
            color: #f0f0e5;
            font-weight: bold;
        }

        .image-content {
            flex: 1;
            max-width: auto;
            text-align: right;
        }

        .image-content img {
            max-width: 100%;
            height: auto;
            width: 100%;
        }

        .carousel {
            margin-top: 40px;
            position: relative;
            height: 0;
            padding-bottom: 50%; /* 1:1 Aspect Ratio */
            overflow: hidden;
        }

        .carousel img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Maintain aspect ratio */
            transition: opacity 0.5s ease;
            opacity: 0;
        }

        .carousel img.active {
            opacity: 1;
        }

        .carousel-buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .carousel-button {
            background-color: rgba(139, 100, 90, 0.8);
            color: #f0f0e5;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 1.5em;
            transition: background-color 0.3s;
        }

        .carousel-button:hover {
            background-color: rgba(195, 157, 136, 0.8);
        }

        .about-developer {
            margin-top: 40px;
            text-align: left;
            line-height: 2.0;
            font-size: 1.2em;
            font-weight: semi=bold;
            font-family: 'Poppins', sans-serif;

        }

        .about-developer img {
            max-width: 150px;
            border-radius: 50%;
        }

        footer {
            background-color: #56443f; /* Footer background */
            color: #e4c7b7; /* Footer text */
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            width: 100%;
            font-family: 'Poppins', sans-serif;
        }

    </style>
</head>
<body>

<header>
    <h1>Welcome to The Literary Lounge: Your Digital Home for Book Lovers</h1>
    <h2>Your Personal Reading Compiler.</h2>
</header>

<div class="container">
    <div class="main-content">
        <div class="text-content">
            <h2>Be Part of the Story!</h2>
            <p>Discover amazing opportunities and resources tailored just for you. Whether you're looking to learn, grow, or connect, we have something for everyone.</p>
            <a href="list.php" class="cta-button">GET STARTED</a>
        </div>
        <div class="image-content">
            <img src="images/static_image.jpeg" alt="Static Image" />
        </div>
    </div>

    <div class="carousel">
        <img src="images/bc_1.jpg" alt="Book 1" class="active" />
        <img src="images/bc_2.jpg" alt="Book 2" />
        <img src="images/bc_3.jpg" alt="Book 3" />
        <div class="carousel-buttons">
            <button class="carousel-button" id="prevBtn">&#10094;</button>
            <button class="carousel-button" id="nextBtn">&#10095;</button>
        </div>
    </div>

    <div class="about-developer">
        <h2>About the Developer</h2>
        <img src="images/DIZON_ID.jpg" alt="Developer Image" />
        <p>Hi! I'm August, a student developer passionate about exploring the world of technology and creating practical solutions through coding. 
            As part of my academic journey, I’ve worked on various projects like library systems, e-commerce prototypes, 
            and portfolio websites to sharpen my skills and bring ideas to life.</p>

            <p>Through this project, The Literary Lounge, I’ve found a unique way to blend my passion for visual storytelling with my work in programming. 
                While I’m not an avid reader myself, I enjoy watching and immersing myself in engaging content. 
                This project allowed me to create a platform where others can share that same enjoyment and connect over books, 
                blending both my interest in interactive media and the power of technology.</p>

            <p>This experience has taught me the importance of user-centered design and problem-solving, and I look forward to applying these lessons to future projects. 
                As part of my coursework at Bulacan State University, my academic goal is to finish with flying colors, 
                and I’m eager to deepen my knowledge of database management and develop my professionalism in UI/UX design. 
                Thank you for visiting and supporting my work!</p>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> August. All rights reserved.</p>
</footer>

<script>
let currentIndex = 0;
const images = document.querySelectorAll('.carousel img');
const totalImages = images.length;

function showImage(index) {
    images.forEach((image, i) => {
        image.classList.remove('active'); // Remove active class from all images
        if (i === index) {
            image.classList.add('active'); // Add active class to the current image
        }
    });
    currentIndex = index; // Update the currentIndex
}

// Event listeners for Next and Previous buttons
document.getElementById('nextBtn').onclick = function() {
    const nextIndex = (currentIndex + 1) % totalImages;
    showImage(nextIndex);
};

document.getElementById('prevBtn').onclick = function() {
    const prevIndex = (currentIndex - 1 + totalImages) % totalImages;
    showImage(prevIndex);
};
</script>

</body>
</html>
