<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<h2>Welcome to Instant Bet, <?php echo $_SESSION['username']; ?> 🎉</h2>
<a href="logout.php">Logout</a>

<hr>

<div class="casino-container">

    <!-- 💰 BET SIDE -->
    <div class="bet-panel">
        <h4>💰 Bet</h4>

        <p class="balance-label">Balance</p>
        <div class="balance">R<span id="balance">00</span></div>

        <input type="number" id="betInput" min="1" placeholder="Enter Bet (R1+)">
    </div>

       <!-- Sounds -->
    <audio id="bgMusic" loop>
        <source src="music/background.mp3" type="audio/mpeg">
    </audio>

    <audio id="winSound">
        <source src="music/win.mp3" type="audio/mpeg">
    </audio>

    <audio id="loseSound">
        <source src="music/lose.mp3" type="audio/mpeg">
    </audio>
    

    <!-- 🎮 GAME CENTER -->
<div class="game-panel" id="gameBox">
    <h3>🎲 Guess the Lucky Number</h3>

    <p>Guess between <b>1 & 50</b></p>
    <p>Attempts left: <span id="triesLeft">5</span></p>

    <input type="number" id="guessInput" placeholder="Lucky number">

    <!-- ✅ FIXED BUTTON -->
    <button id="guessBtn" onclick="checkGuess()">Guess</button>

    <p id="message"></p>

    <button id="restartBtn" onclick="restartGame()" style="display:none;">
        🔄 Restart
    </button>
</div>




    <!-- 🔢 RANDOM FLOATING NUMBERS -->
    <div class="number-stickers">
        <span>7</span>
        <span>21</span>
        <span>33</span>
        <span>50</span>
        <span>9</span>
        <span>10</span>
        <span>40</span>
        <span>48</span>
        <span>29</span>
        <span>5</span>
    </div>



</div>

<script src="game.js"></script>
</body>
</html>
