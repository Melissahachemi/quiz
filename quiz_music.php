<?php
$categorie = 'm'; // 'm' pour Musique
include_once 'quiz_common.php';

$questions = getQuestions($conn, $categorie, $nombre_questions);

$_SESSION['quiz_questions'] = $questions;
$_SESSION['quiz_start_time'] = time();
$_SESSION['quiz_end_time'] = time() + $temps_limite;

mysqli_close($conn);
?>

<h1>Quiz Musique</h1>

<?php foreach ($questions as $index => $question): ?>
    <div class="question" id="question<?php echo $index; ?>" style="display:<?php echo ($index == 0) ? 'block' : 'none'; ?>;">
        <p><?php echo htmlspecialchars($question['question']); ?></p>
        <label><input type="radio" name="reponse<?php echo $index; ?>" value="<?php echo htmlspecialchars($question['reponse1']); ?>" required> <?php echo htmlspecialchars($question['reponse1']); ?></label><br>
        <label><input type="radio" name="reponse<?php echo $index; ?>" value="<?php echo htmlspecialchars($question['reponse2']); ?>" required> <?php echo htmlspecialchars($question['reponse2']); ?></label><br>
        <label><input type="radio" name="reponse<?php echo $index; ?>" value="<?php echo htmlspecialchars($question['reponse3']); ?>" required> <?php echo htmlspecialchars($question['reponse3']); ?></label><br>
        <label><input type="radio" name="reponse<?php echo $index; ?>" value="<?php echo htmlspecialchars($question['reponse4']); ?>" required> <?php echo htmlspecialchars($question['reponse4']); ?></label><br>

        <?php if ($index < count($questions) - 1): ?>
            <button type="button" class="next-btn" onclick="showNextQuestion(<?php echo $index; ?>)">Suivant</button>
        <?php else: ?>
            <button type="submit">Terminer le Quiz</button>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<input type="hidden" name="categorie" value="<?php echo $categorie; ?>">

</form>

<script>
    function showNextQuestion(index) {
        document.getElementById('question' + index).style.display = 'none';
        document.getElementById('question' + (index + 1)).style.display = 'block';
    }

    let timeLeft = <?php echo $temps_limite; ?>;
    const timerElement = document.getElementById('timer');

    const timerInterval = setInterval(function() {
        timeLeft--;
        timerElement.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            document.getElementById('quiz-form').submit();
        }
    }, 1000);
</script>

</body>
</html>