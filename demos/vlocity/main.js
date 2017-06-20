var difficultyArray = ['easy', 'medium', 'hard', 'extreme', 'other'];
var gamemode;
var difficulty;
var isDifficultySelected = false;

$(document).ready(function() {
    ifClicked();
    checkStorage();

});

function preload() {
    menuMusic = loadSound("assets/menu.mp3");
    buttonClicked = loadSound("assets/buttonClicked.wav");
}

function setup() {
    menuMusic.play();
}

function draw() {
    if (!menuMusic.isPlaying()) {
        menuMusic.play();
    }

    $("p").click(function() {
        if (!buttonClicked.isPlaying()) {
            buttonClicked.play();
        }
    });
}

function ifClicked() {
    $("#play").click(function Play() {
        if (gamemode == "survival") {
            location.href = "survival.html";
        } else if (gamemode == "waves") {
            location.href = "waves.html";
        }
    });

    $("#survival").click(function() {
        if (!isDifficultySelected) {
            $("#" + sessionStorage.getItem('difficulty')).click();
        }
        gamemode = "survival";
        sessionStorage.setItem('gamemode', gamemode);
    });

    $("#waves").click(function() {
        $("p").removeClass("selected");
        isDifficultySelected = false;
        gamemode = "waves";
        sessionStorage.setItem('gamemode', gamemode);
    });

    $("#easy").click(function() {
        isDifficultySelected = true;
        if (sessionStorage.getItem('gamemode') != survival) { $("#survival").click(); }
        sessionStorage.setItem('numEnemy', 2);
        difficulty = "easy";
        sessionStorage.setItem('difficulty', difficulty);
    });

    $("#medium").click(function() {
        isDifficultySelected = true;
        if (sessionStorage.getItem('gamemode') != survival) { $("#survival").click(); }
        sessionStorage.setItem('numEnemy', 3);
        difficulty = "medium";
        sessionStorage.setItem('difficulty', difficulty);
    });

    $("#hard").click(function() {
        isDifficultySelected = true;
        if (sessionStorage.getItem('gamemode') != survival) { $("#survival").click(); }
        sessionStorage.setItem('numEnemy', 4);
        difficulty = "hard";
        sessionStorage.setItem('difficulty', difficulty);
    });

    $("#extreme").click(function() {
        isDifficultySelected = true;
        if (sessionStorage.getItem('gamemode') != survival) { $("#survival").click(); }
        sessionStorage.setItem('numEnemy', 6);
        difficulty = "extreme";
        sessionStorage.setItem('difficulty', difficulty);
    });

    $("#other").click(function() {
        isDifficultySelected = true;
        if (sessionStorage.getItem('gamemode') != survival) { $("#survival").click(); }
        sessionStorage.setItem('numEnemy', 8);
        difficulty = "other";
        sessionStorage.setItem('difficulty', difficulty);
    });

    $(".difficulty").click(function() {
        $(".difficulty").removeClass("selected");
        $("." + difficulty).addClass("selected");
    });

    $(".gamemode").click(function() {
        $(".gamemode").removeClass("selected");
        $("#" + gamemode).addClass("selected");
    });
}

function checkStorage() {
    if (sessionStorage.getItem('difficulty') == null) {
        $("#medium").click();
    } else {
        $("#" + sessionStorage.getItem('difficulty')).click();
    }

    if (sessionStorage.getItem('gamemode') == null) {
        $("#survival").click();
    } else {
        $("#" + sessionStorage.getItem('gamemode')).click();
    }

    if (localStorage.getItem('bestWave') != null) {
        $("#bestWave").html("Best Wave: " + localStorage.getItem('bestWave'));
    }

    for (var i in difficultyArray) {
        var currentDifficulty = difficultyArray[i];

        //Highest Scores
        //If there is no score, sets it to 0
        if (localStorage.getItem(currentDifficulty + 'Score') == null) {
            localStorage.setItem(currentDifficulty + 'Score', 0);
        }

        //Shows highest score
        $("#" + currentDifficulty + "Score").html(localStorage.getItem(currentDifficulty + 'Score'));

        //Best Times
        //If there is no time, sets it to 0
        if (localStorage.getItem(currentDifficulty + 'Time') == null) {
            localStorage.setItem(currentDifficulty + 'Time', 0);
        }

        //Shows best time
        $("#" + currentDifficulty + "Time").html(localStorage.getItem(currentDifficulty + 'Time'));
    }
}
