var player;
var enemy;
var highScore = 0;
var speed = 10;
var score = 0;
var box1;
var box2;

if (speed < 20){
setInterval(function(){speed += 2;}, 5000);
}

function setup() {
  createCanvas(300, 500);
  box1 = createSprite(-32, 470, 64, 64);
  box2 = createSprite(332, 470, 64, 64);
  player = createSprite(150, 470, 64, 64);
  var playerImage = loadImage("player.png");
  player.addImage(playerImage);

  enemy = createSprite(250, 0, 8, 64);
}

function draw() {
  background(0);
  text('HIGHSCORE: ' + localStorage.getItem("highscore"));
  text("Player Score: " + score, 100, 20);

  if (keyDown(LEFT_ARROW)) {
    player.position.x -= 10;
  }
  if (keyDown(RIGHT_ARROW)) {
    player.position.x += 10;
  }

  if (enemy.position.y > 500) {
    enemy.position.y = 0;
    enemy.position.x = random(10, 290);
    score += 1;
  }

  player.collide(box1);
  player.collide(box2);
  enemy.position.y += speed;

  if(player.overlap(enemy)) {
    player.remove();
    enemy.position.y = -100;
    speed = -1000;
    document.getElementById("restart").onclick = function Restart() {
  location.reload();
  };
  }


  drawSprites();
}