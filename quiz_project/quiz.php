<?php
session_start(); // Start the session
include 'db_connect.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Fetch questions and answers (your existing code)
$sql = "SELECT q.id AS question_id, q.question, a.id AS answer_id, a.answer, a.is_correct
        FROM questions q
        JOIN answers a ON q.id = a.question_id";
$result = $conn->query($sql);

$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $question_id = $row['question_id'];
        if (!isset($questions[$question_id])) {
            $questions[$question_id] = [
                'question' => $row['question'],
                'answers' => []
            ];
        }
        $questions[$question_id]['answers'][] = [
            'answer_id' => $row['answer_id'],
            'answer' => $row['answer'],
            'is_correct' => $row['is_correct']
        ];
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Quiz</title>
</head>
<body>
    <!-- Display the logged-in user's name -->
    <h1>Welcome to the Online Quiz, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    
    <form action="submit.php" method="POST" id="quiz-form">
        <?php foreach ($questions as $question_id => $question): ?>
            <div class="question">
                <h3><?php echo htmlspecialchars($question['question']); ?></h3>
                <?php foreach ($question['answers'] as $answer): ?>
                    <label>
                        <input type="radio" name="question<?php echo $question_id; ?>" value="<?php echo $answer['answer_id']; ?>">
                        <?php echo htmlspecialchars($answer['answer']); ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit">Submit Quiz</button>
    </form>
    <a href="logout.php">Logout</a> <!-- Link to logout -->
</body>
</html>
