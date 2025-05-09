const timerElement = document.getElementById('timer');
const quizForm = document.getElementById('quiz-form');
const timerContainer = document.querySelector('[data-time-limit]'); // Sélectionne l'élément avec l'attribut data-time-limit
let timeLeft = parseInt(timerContainer.dataset.timeLimit, 10); // Récupère la valeur et la convertit en nombre entier
let timerInterval;

function showNextQuestion(index) {
    document.getElementById('question' + index).style.display = 'none';
    document.getElementById('question' + (index + 1)).style.display = 'block';
}

function showPreviousQuestion(index) {
    document.getElementById('question' + index).style.display = 'none';
    document.getElementById('question' + (index - 1)).style.display = 'block';
}

function updateTimerDisplay() {
    timerElement.textContent = timeLeft;
}

function startTimer() {
    updateTimerDisplay(); // Afficher le temps initialement

    timerInterval = setInterval(function() {
        timeLeft--;
        updateTimerDisplay();

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            quizForm.submit();
        }
    }, 1000);
}

// Démarrer le timer au chargement de la page
startTimer();