<?php
include 'db_connect.php';  // Database connection

$score = 0;

// Loop through the submitted answers
foreach ($_POST as $question_id => $answer_id) {
    $question_id = intval(str_replace('question', '', $question_id));
    $answer_id = intval($answer_id);

    // Check if the selected answer is correct
    $sql = "SELECT is_correct FROM answers WHERE id = $answer_id AND question_id = $question_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['is_correct']) {
            $score++;
        }
    }
}

// Display the score
echo "You scored $score out of " . count($_POST) . ".";

$conn->close();
?>
