var player;
var enemy;
var dropRate = 0;
var points = 0;
var endAnimation = false;
var endAnimationDone = false;
var time = 0;
var timer;
var isPaused = false;
var playerSpeed = 10;
var dropsCollected = 0;
var dropsMade = 0;
var numEnemy = sessionStorage.getItem('numEnemy');
var difficulty = sessionStorage.getItem('difficulty');
var gamemode = sessionStorage.getItem('gamemode');
var hasShield = false;
var turnBlue = 255;
var spawnEnemyXPosition;
var spawnEnemyYPosition;
var spawnEnemyDirection;
var isSlowPillOut = false;

$(window).blur(function() {
	isPaused = true;
});

$(window).focus(function() {
	isPaused = false;
});

function preload() {
	loadAssets();
	impact.setVolume(1);
	end.setVolume(1);
	soundtrack.setVolume(0.5);
	coinSound.setVolume(1);
}

function setup() {
	soundtrack.play();
	createCanvas(1300, 800);
	players = new Group();
	enemies = new Group();
	coins = new Group();
	gems = new Group();
	shields = new Group();
	slowPills = new Group();
	player = createSprite(random(20, width / 4), random(height - height / 4, height - 20), 40, 40);
	player.shapeColor = "white";
	players.add(player);
	for (var i = 0; i < numEnemy; i++) {
		newEnemy = createSprite(random(width - width / 5, width - 30), random(30, height / 5), 50, 50);
		newEnemy.setSpeed(random(9, 13), -random(190, 260));
		newEnemy.shapeColor = "rgb(" + String(parseInt(random(100, 255))) + "," + String(parseInt(random(100, 255))) + "," + String(parseInt(random(100, 255))) + ")";
		enemies.add(newEnemy);
	}
	if (gamemode == "survival") {
		timer = setInterval(function() {
			if (!isPaused) {
				time++;
				for (var i = 0; i < enemies.length; i++) {
					enemies[i].addSpeed(0.1, enemy.getDirection());
				};
			}
		}, 1000);
	}

}

function draw() {
	background(0);
	updateText();

	if (endAnimation == false) {
		checkCollisions();
		playerMovement();
		enemyMovement();
		updatePickups();
	}

	if (hasShield) {
		if (turnBlue > 100) {
			turnBlue = turnBlue - 8;
			player.shapeColor = "rgb(" + (turnBlue + 100) + "," + (turnBlue + 100) + ", 255)";
		}
	} else {
		turnBlue = 255;
		player.shapeColor = 'white';
	}

	endGame();

	$("#restart").click(function Restart() { location.reload(); });
	$("#back").click(function Back() { location.href = "index.html"; });

	//Draw Order (z-order)
	slowPills.draw();
	shields.draw();
	gems.draw();
	coins.draw();
	players.draw();
	enemies.draw();
}

function getCoin(player, coin) {
	coin.remove();
	points += 1;
	coinSound.play();
	dropsCollected++;
}

function getGem(player, pill) {
	pill.remove();
	points += 5;
	coinSound.play();
	dropsCollected++;
}

function getShield(player, shield) {
	shield.remove();
	hasShield = true;
	coinSound.play();
	dropsCollected++;
}

function getSlowPill(player, pill) {
	pill.remove();
	for (var i = 0; i < enemies.length; i++) {
		enemy = enemies[i];
		enemy.addSpeed(-10, enemy.getDirection());
	};
	setTimeout(function() {
		for (var i = 0; i < enemies.length; i++) {
			enemy = enemies[i];
			enemy.addSpeed(10, enemy.getDirection());
		};
		isSlowPillOut = false;
	}, 5000);
	coinSound.play();
	dropsCollected++;
}

function loadAssets() {
	impact = loadSound("assets/impact.mp3");
	end = loadSound("assets/end2.mp3");
	soundtrack = loadSound("assets/soundtrack2.mp3");
	circle = loadImage("assets/circle.png");
	coinSound = loadSound("assets/coin.mp3");
	laser = loadSound("assets/laser.mp3");
}

function updateText() {
	document.getElementById("time").innerHTML = "Time: " + time;
	document.getElementById("points").innerHTML = "Points: " + points;
	document.getElementById("gamemode").innerHTML = gamemode + " - " + difficulty;
}

function playerMovement() {
	if (keyDown(LEFT_ARROW) && !(player.position.x - player.width / 2 <= 0)) {
		player.position.x -= playerSpeed;
	}
	if (keyDown(RIGHT_ARROW) && !(player.position.x + player.width / 2 >= width)) {
		player.position.x += playerSpeed;
	}
	if (keyDown(UP_ARROW) && !(player.position.y - player.height / 2 <= 0)) {
		player.position.y -= playerSpeed;
	}
	if (keyDown(DOWN_ARROW) && !(player.position.y + player.height / 2 >= height)) {
		player.position.y += playerSpeed;
	}
}

function enemyMovement() {
	for (var i = 0; i < enemies.length; i++) {
		enemy = enemies[i];
		if (enemy.position.y + enemy.height / 2 >= 800) {
			enemy.velocity.y = -abs(enemy.velocity.y);
		} else if (enemy.position.y - enemy.height / 2 <= 0) {
			enemy.velocity.y = abs(enemy.velocity.y);
		}

		if (enemy.position.x + enemy.width / 2 >= 1300) {
			enemy.velocity.x = -abs(enemy.velocity.x);
		} else if (enemy.position.x - enemy.width / 2 <= 0) {
			enemy.velocity.x = abs(enemy.velocity.x);
		}

		enemies.bounce(enemies)

		if (enemy.position.x + enemy.width / 2 >= 1300 || enemy.position.x - enemy.width / 2 <= 0 || enemy.position.y + enemy.height / 2 >= 800 || enemy.position.y - enemy.height / 2 <= 0) {
			enemy.width = 100;
			enemy.height = 100;
			if (!impact.isPlaying()) {
				impact.play();
			}
		}

		if (enemy.width > 50) {
			enemy.width = enemy.width ** 0.98;
			enemy.height = enemy.height ** 0.98;
		}

	}
}

function updatePickups() {
	dropRate++;
	if ((dropRate % 50 == 0) && (dropsMade - dropsCollected < 10)) {
		var dropChoice = random(0, 100);
		if (dropChoice > 70 && dropChoice <= 80) {
			var pill = createSprite(random(10, width - 10), random(10, height - 10), 15, 15);
			pill.shapeColor = "red";
			gems.add(pill);
		} else if (dropChoice > 80 && dropChoice <= 90) {
			var shield = createSprite(random(10, width - 10), random(10, height - 10), 15, 15);
			shield.shapeColor = "blue";
			shields.add(shield);
		} else if (dropChoice > 90 && !isSlowPillOut) {
			var pill = createSprite(random(10, width - 10), random(10, height - 10), 15, 15);
			pill.shapeColor = "green";
			slowPills.add(pill);
			isSlowPillOut = true;
		} else {
			var coin = createSprite(random(10, width - 10), random(10, height - 10), 15, 15);
			coin.shapeColor = "yellow";
			coins.add(coin);
		}
		dropsMade++;
	}
}

function checkCollisions() {
	player.overlap(enemies, checkShieldBlock);
	player.overlap(coins, getCoin);
	player.overlap(shields, getShield);
	player.overlap(gems, getGem);
	player.overlap(slowPills, getSlowPill);
}

function checkShieldBlock(player, enemy) {
	if (hasShield) {
		enemy.remove();
		hasShield = false;
		coinSound.play();
		findNewSpawns();
		newEnemy = createSprite(spawnEnemyXPosition, spawnEnemyYPosition, 50, 50);
		newEnemy.setSpeed(random(9, 13), spawnEnemyDirection);
		newEnemy.shapeColor = "rgb(" + String(parseInt(random(100, 255))) + "," + String(parseInt(random(100, 255))) + "," + String(parseInt(random(100, 255))) + ")";
		enemies.add(newEnemy);
	} else {
		endAnimation = true;
	}
}

function endGame() {
	if (endAnimation && !endAnimationDone) {

		if (key == ' ') { location.reload(); }
		clearInterval(timer);

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

		if (points > localStorage.getItem(difficulty + 'Score')) {
			localStorage.setItem(difficulty + 'Score', points)
			alert("New Highscore! - " + points + " points!")
		}

		if (time > localStorage.getItem(difficulty + 'Time')) {
			localStorage.setItem(difficulty + 'Time', time)
			alert("New Best Time! - " + time + " seconds!")
		}
	}
}

function findNewSpawns() {
	if (player.position.x < width / 2) {
		spawnEnemyXPosition = random(width - width / 5, width - 30);
	} else if (player.position.x > width / 2) {
		spawnEnemyXPosition = random(30, width / 5);
	}
	if (player.position.y > height / 2) {
		spawnEnemyYPosition = random(30, height / 5);
	} else if (player.position.y < height / 2) {
		spawnEnemyYPosition = random(height - height / 5, height - 30);
	}

	if (player.position.x < width / 2 && player.position.y < height / 2) {
		spawnEnemyDirection = random(190, 260);
	} else if (player.position.x > width / 2 && player.position.y < height / 2) {
		spawnEnemyDirection = random(280, 350);
	} else if (player.position.x < width / 2 && player.position.y > height / 2) {
		spawnEnemyDirection = random(100, 170);
	} else if (player.position.x > width / 2 && player.position.y > height / 2) {
		spawnEnemyDirection = random(10, 80);
	}
}
