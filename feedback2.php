<?php
session_start(); // Start the session to access session variables

// Ensure user is logged in
if (!isset($_SESSION['user']['user_id'])) {
    die("You must be logged in to submit feedback.");
}

$servername = "localhost";
$username = "root";        
$password = "";           
$dbname = "adbms";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = $success = "";
$user_id = $_SESSION['user']['user_id']; // Access the user_id from session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $suggestion = trim($_POST['suggestion']);
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
    $additional = trim($_POST['additional']);

    if (empty($suggestion) || $rating === null) {
        $error = "Suggestion and rating are required.";
    } else {
        // Prepare SQL with user_id
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, suggestion, rating, additional) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $user_id, $suggestion, $rating, $additional);

        if ($stmt->execute()) {
            $success = "Thank you for your feedback!";
        } else {
            $error = "Error: Could not send your feedback. Please try again later.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="feedback.css">
</head>
<body>

<header class="header">
    <a href="student_dashboard.php" class="back-button">Dashboard</a>
    <h1 class="center-title">Feedback</h1>
    <div style="width: 130px;"></div>
</header>

<div class="feedback-container">
    <h2>We value your opinion.</h2><br>
    <?php
    if (!empty($error)) {
        echo "<div class='error'>$error</div>";
    } elseif (!empty($success)) {
        echo "<div class='success'>$success</div>";
    }
    ?>
    <form action="feedback2.php" method="POST">
        <div class="form-group">
            <label for="suggestion">Your suggestion</label>
            <textarea id="suggestion" name="suggestion" rows="2" required></textarea>
        </div>

        <div class="form-group">
            <label>How would you rate your experience?</label>
            <div class="rating-stars">
                <input type="radio" id="star5" name="rating" value="5"><label for="star5">&#9733;</label>
                <input type="radio" id="star4" name="rating" value="4"><label for="star4">&#9733;</label>
                <input type="radio" id="star3" name="rating" value="3"><label for="star3">&#9733;</label>
                <input type="radio" id="star2" name="rating" value="2"><label for="star2">&#9733;</label>
                <input type="radio" id="star1" name="rating" value="1"><label for="star1">&#9733;</label>
            </div>
        </div>

        <div class="form-group">
            <label for="additional">Anything else you'd like to share?</label>
            <textarea id="additional" name="additional" rows="2"></textarea>
        </div>

        <div class="form-actions"> 
            <button type="submit" class="submit-btn">Send feedback</button>
        </div>
    </form>
    <div class="powered">
       Thank You!
    </div>
</div>
</body>
</html>
