<?php
$servername = "localhost";
$username = "root";        
$password = "";           
$dbname = "adbms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $suggestion = trim($_POST['suggestion']);
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
    $additional = trim($_POST['additional']);

    if (empty($suggestion) || $rating === null) {
        $error = "Suggestion and rating are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (suggestion, rating, additional) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $suggestion, $rating, $additional);

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
    <link rel="stylesheet" href="feed.css">
    <link rel = "website icon" type = "png" href = "BSU.jpg";>
</head>
<body>

    <header>
        <h1>Feedback</h1>
        <p>We value your opinion!</p>
    </header>

    <div class="feedback-container">
    <h2>Send Feedback</h2>
    <?php
    if (!empty($error)) {
        echo "<div class='error'>$error</div>";
    } elseif (!empty($success)) {
        echo "<div class='success'>$success</div>";
    }
    ?>
    <form action="feedback.php" method="POST">
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
       Thank You for the kyutness
    </div>
</div>
</body>
</html>