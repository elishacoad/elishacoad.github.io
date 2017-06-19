

var wave = 1;
var numEnemy = 1;
var enemiesLeft = 1;
var keyPressed;
var isShootingUp = false;
var isShootingRight = false;
var isShootingDown = false;
var isShootingLeft = false;
var timeoutHasExecuted;
var hasShotRecently = false;
var turnRed = 255;
var bestWave = localStorage.getItem('bestWave');
if (bestWave == null) { bestWave = 0; }

document.addEventListener("keydown", keyDownHandler, true);
document.addEventListener("keyup", keyUpHandler, true);

function setup() {

	soundtrack.play();
	createCanvas(1300, 800);
	players = new Group();
	enemies = new Group();
	coins = new Group();
	bluePills = new Group();
	bullets = new Group();
	player = createSprite(random(20, width / 4), random(height - height / 4, height - 20), 40, 40);
	player.shapeColor = "white";
	players.add(player);
	for (var i = 0; i < numEnemy; i++) {
		newEnemy = createSprite(random(width - width / 5, width - 30), random(30, height / 5), 50, 50);
		newEnemy.setSpeed(random(9, 13), -random(190, 260));
		newEnemy.shapeColor = "rgb(" + String(parseInt(random(100, 255))) + "," + String(parseInt(random(100, 255))) + "," + String(parseInt(random(100, 255))) + ")";
		enemies.add(newEnemy);
		enemiesLeft = numEnemy;
	}
	timer = setInterval(function() {
		if (!isPaused) {
			time++;
		}
	}, 1000);
}

function draw() {
	background(0);
	updateText();

	if (endAnimation == false) {
		playerMovement();
		enemyMovement();
		// updatePickups();
		checkCollisions();
		playerActions();
		for (var i = 0; i < bullets.length; i++) {
			bullet = bullets[i];
			bullet.overlap(enemies, bulletHit)
		}
		newWave();
		if (!hasShotRecently) {
			if (turnRed > 100) {
				turnRed = turnRed - 8;
				player.shapeColor = "rgb(255," + turnRed + "," + turnRed + ")";
			}
		} else {
			turnRed = 255;
			player.shapeColor = 'white';
		}
	}

	endGame();

	if (key == ' ') { location.reload(); }
	$("#restart").click(function Restart() { location.reload(); });
	$("#back").click(function Back() { location.href = "index.html"; });

	//Draw Order (z-order)
	bluePills.draw();
	coins.draw();
	players.draw();
	enemies.draw();
	bullets.draw();
}

function updateText() {
	document.getElementById("wave").innerHTML = "Wave: " + wave;
	document.getElementById("gamemode").innerHTML = gamemode + " - Best: " + bestWave;
}

function endGame() {
	if (endAnimation && !endAnimationDone) {

		clearInterval(timer);
		player.shapeColor = 'white';

		for (var i = 0; i < enemies.length; i++) {
			enemy = enemies[i];
			enemy.velocity.x = 0;
			enemy.velocity.y = 0;
		}

		if (soundtrack.isPlaying()) {
			end.play();
		}

		player.width = player.width ** 1.01;
		player.height = player.height ** 1.01;
		player.rotationSpeed = player.rotationSpeed ** 1.01 + 0.2;

		if (player.width >= 3000) {
			endAnimationDone = true;
		}

		if (soundtrack.isPlaying()) {
			soundtrack.stop();
		}

		if (wave > localStorage.getItem('bestWave')) {
			localStorage.setItem('bestWave', wave);
			alert("New Best Wave! You reached wave " + wave + "!");
		}
	}
}

function newWave() {
	textSize(72);
	textAlign(CENTER, CENTER);
	if (enemiesLeft > 0) {
		text(enemiesLeft, width / 2, height / 2);
		timeoutHasExecuted = false;
	} else {
		text("Wave Completed!", width / 2, height / 2);
		if (timeoutHasExecuted == false) {
			setTimeout(function() { spawnNewEnemies(); }, 3000);
		}
		timeoutHasExecuted = true;
	}
}

function playerActions() {
	if (!hasShotRecently) {
		if (isShootingUp) {
			spawnBullet(270);
		} else if (isShootingRight) {
			spawnBullet(0);
		} else if (isShootingDown) {
			spawnBullet(90);
		} else if (isShootingLeft) {
			spawnBullet(180);
		}
	}
}

function bulletHit(bullet, enemy) {
	bullet.remove();
	enemy.remove();
	points += 1;
	coinSound.play();
	enemiesLeft--;
}

function keyDownHandler(event) {

	keyPressed = String.fromCharCode(event.keyCode);
	if (keyPressed == "W") {
		isShootingUp = true;
	} else if (keyPressed == "D") {
		isShootingRight = true;
	} else if (keyPressed == "S") {
		isShootingDown = true;
	} else if (keyPressed == "A") {
		isShootingLeft = true;
	}
}

function keyUpHandler(event) {
	var keyPressed = String.fromCharCode(event.keyCode);

	if ((keyPressed == "W") || (keyPressed == "A") ||
		(keyPressed == "S") || (keyPressed == "D")) {
		isShootingUp = false;
		isShootingRight = false;
		isShootingDown = false;
		isShootingLeft = false;
	}
}

function spawnNewEnemies() {
	if (enemiesLeft == 0) {
		numEnemy++;
		for (var i = 0; i < numEnemy; i++) {
			findNewSpawns();
			newEnemy = createSprite(spawnEnemyXPosition, spawnEnemyYPosition, 50, 50);
			newEnemy.setSpeed(random(9, 13), spawnEnemyDirection);
			newEnemy.shapeColor = "rgb(" + String(parseInt(random(100, 255))) + "," + String(parseInt(random(100, 255))) + "," + String(parseInt(random(100, 255))) + ")";
			enemies.add(newEnemy);
			enemiesLeft = numEnemy;
			wave = numEnemy;
		}
	}
}

function spawnBullet(bulletAngle) {
	var bulletHeight;
	var bulletWidth;

	//Right
	if (bulletAngle == 0) {
		bulletHeight = 10;
		bulletWidth = 20;
	}
	//Up
	else if (bulletAngle == 270) {
		bulletHeight = 20;
		bulletWidth = 10;
	}
	//Left
	else if (bulletAngle == 180) {
		bulletHeight = 10;
		bulletWidth = 20;
	}
	//Down
	else if (bulletAngle == 90) {
		bulletHeight = 20;
		bulletWidth = 10;
	}

	bullet = createSprite(player.position.x, player.position.y, bulletWidth, bulletHeight);
	bullet.setSpeed(20, bulletAngle);
	bullet.shapeColor = "red";
	bullet.life = 60;
	bullets.add(bullet);
	laser.play();
	hasShotRecently = true;
	setTimeout(function() { hasShotRecently = false; }, 1000);
}

function checkCollisions() {
	if (player.overlap(enemies)) { endAnimation = true; };
}
