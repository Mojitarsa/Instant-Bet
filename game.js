let numberToGuess;
let attempts;
const maxAttempts = 5;

let balance = 10;
let currentBet = 0;
let musicStarted = false;

const bgMusic = document.getElementById("bgMusic");
const winSound = document.getElementById("winSound");
const loseSound = document.getElementById("loseSound");

function initGame() {
    numberToGuess = Math.floor(Math.random() * 50) + 1;
    attempts = 0;

    document.getElementById("triesLeft").textContent = maxAttempts;
    document.getElementById("message").textContent = "";
    document.getElementById("balance").textContent = balance.toFixed(2);

    document.getElementById("guessInput").disabled = false;
    document.getElementById("guessBtn").disabled = false;
    document.getElementById("restartBtn").style.display = "none";

    document.getElementById("gameBox").classList.remove("win-animate");

    bgMusic.currentTime = 0;
    bgMusic.volume = 0.3;
}

window.onload = initGame;

function checkGuess() {

    // 🔊 Start background music after user interaction
    if (!musicStarted) {
        bgMusic.play().catch(() => {});
        musicStarted = true;
    }

    const betInput = document.getElementById("betInput");
    const guessInput = document.getElementById("guessInput");
    const message = document.getElementById("message");
    const triesLeft = document.getElementById("triesLeft");

    currentBet = Number(betInput.value);
    let userGuess = Number(guessInput.value);

    if (!currentBet || currentBet < 1) {
        message.textContent = "❗ Enter a valid bet (R1 or more)";
        return;
    }

    if (currentBet > balance) {
        message.textContent = "❌ Bet exceeds balance";
        return;
    }

    if (!userGuess) {
        message.textContent = "❗ Enter a number to guess";
        return;
    }

    attempts++;
    triesLeft.textContent = maxAttempts - attempts;

    if (userGuess === numberToGuess) {
        let winAmount = currentBet * 0.3;
        balance += winAmount;

        message.textContent = `🎉 YOU WON! +R${winAmount.toFixed(2)}`;

        bgMusic.pause();
        winSound.play();

        endGame(true);
        return;
    }

    if (attempts >= maxAttempts) {
        balance -= currentBet;

        message.textContent =
            `❌ You lost! -R${currentBet.toFixed(2)} (Number was ${numberToGuess})`;

        bgMusic.pause();
        loseSound.play();

        endGame(false);
        return;
    }

    message.textContent =
        userGuess < numberToGuess ? "📉 Too low!" : "📈 Too high!";

    guessInput.value = "";
}

function endGame(won) {
    document.getElementById("balance").textContent = balance.toFixed(2);

    document.getElementById("guessInput").disabled = true;
    document.getElementById("guessBtn").disabled = true;
    document.getElementById("restartBtn").style.display = "block";

    if (won) {
        document.getElementById("gameBox").classList.add("win-animate");
    }
}

function restartGame() {
    winSound.pause();
    loseSound.pause();
    bgMusic.pause();
    musicStarted = false;

    initGame();
}
