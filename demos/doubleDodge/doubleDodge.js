var player;
var enemy1;
var enemy2;
var highScore;
var speed = 10;
var score = 0;

if (speed < 20){
setInterval(function(){speed += 2;}, 5000);
}

function setup() {
  createCanvas(500, 500);
  box1 = createSprite(-30, 250, 64, 500);
  box2 = createSprite(250, 530,500, 64);
  box3 = createSprite(530, 250, 64, 500);
  box4 = createSprite(250, -30,500, 64);
  player = createSprite(100, 400, 64, 64);

  var playerImage = loadImage("player.png");
  player.addImage(playerImage);



  enemy1 = createSprite(250, 0, 8, 64);
  enemy2 = createSprite(500, 200, 64, 8);
}

function draw() {
  background(0);
  text("Player Score: " + score, 208, 20);

  if (keyDown(LEFT_ARROW)) {
    player.position.x -= 10;
  }
  if (keyDown(RIGHT_ARROW)) {
    player.position.x += 10;
  }
  if (keyDown(DOWN_ARROW)) {
    player.position.y += 10;
  }
  if (keyDown(UP_ARROW)) {
    player.position.y -= 10;
  }

  if (enemy1.position.y > 500) {
    enemy1.position.y = 0;
    enemy1.position.x = random(0, 500);
    score += 1;
  }

  if (enemy2.position.x < -30) {
    enemy2.position.x = 500;
    enemy2.position.y = random(0, 500);
    score += 1;
  }

  player.collide(box1);
  player.collide(box2);
  player.collide(box3);
  player.collide(box4);
  enemy1.position.y += speed;
  enemy2.position.x -= speed;

  if(player.overlap(enemy1)) {
    player.remove();
    enemy1.position.y = -100;
    enemy2.position.x = 600;
    speed = -1000;
    onclick = function Restart() {
  location.reload();
  };
  }
    if(player.overlap(enemy2)) {
    player.remove();
    enemy1.position.y = -100;
    enemy2.position.x = 600;
    speed = -1000;
    document.getElementById("restart").onclick = function Restart() {
      location.reload();
    };
  }


  drawSprites();
}