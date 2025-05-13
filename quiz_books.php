<!-- Page de quiz pour la catégorie Littérature -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="quiz_style.css">
    <title>Quiz Littérature</title>
</head>
<body>
    <!-- Appel du script quiz_common.php pour la génération de questions et timer -->
    <?php
        require_once 'quiz_common.php';

        $categorie = 'l'; // 'f' pour Films
        $questions = getQuestions($conn, $categorie, $nombre_questions);

        $_SESSION['quiz_questions'] = $questions;
        $_SESSION['quiz_start_time'] = time();
        $_SESSION['quiz_end_time'] = time() + $temps_limite;

        mysqli_close($conn);
    ?>
    <p data-time-limit="<?php echo $temps_limite; ?>">Temps restant : <span id="timer"></span> secondes</p>

    <form id="quiz-form" action="traitement_quiz.php" method="post">

        <h1>Quiz littérature </h1>

        <?php foreach ($questions as $index => $question): ?>
            <div class="question" id="question<?php echo $index; ?>" style="display:<?php echo ($index == 0) ? 'block' : 'none'; ?>;">
                <p><?php echo htmlspecialchars($question['question']); ?></p>
                <div class="reponses">
                    <label><input type="radio" name="reponse<?php echo $index; ?>" value="<?php echo htmlspecialchars($question['reponse1']); ?>" required> <?php echo htmlspecialchars($question['reponse1']); ?></label>
                    <label><input type="radio" name="reponse<?php echo $index; ?>" value="<?php echo htmlspecialchars($question['reponse2']); ?>" required> <?php echo htmlspecialchars($question['reponse2']); ?></label>
                    <label><input type="radio" name="reponse<?php echo $index; ?>" value="<?php echo htmlspecialchars($question['reponse3']); ?>" required> <?php echo htmlspecialchars($question['reponse3']); ?></label>
                    <label><input type="radio" name="reponse<?php echo $index; ?>" value="<?php echo htmlspecialchars($question['reponse4']); ?>" required> <?php echo htmlspecialchars($question['reponse4']); ?></label>
                </div>

                <div class="navigation-buttons">
                    <?php if ($index > 0): ?>
                        <button type="button" class="prev-btn" onclick="showPreviousQuestion(<?php echo $index; ?>)">Précédent</button>
                    <?php endif; ?>

                    <?php if ($index < count($questions) - 1): ?>
                        <button type="button" class="next-btn" onclick="showNextQuestion(<?php echo $index; ?>)">Suivant</button>
                    <?php else: ?>
                        <button type="submit">Terminer le Quiz</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <input type="hidden" name="categorie" value="<?php echo $categorie; ?>">

    </form>

    <script src="quiz_script.js"></script>

</body>
</html>