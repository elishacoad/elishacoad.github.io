var system;
var blownUp = true;

function setup() {
    createCanvas(720, 400);
    system = new ParticleSystem(createVector(width / 2, height / 2));
}

function draw() {

    background(51);
    blowup();

}

function blowup() {
    if (blownUp) {
        for (var i = 0; i < 50; i++) {
            system.addParticle();
        }
        blownUp = false;
    }
    system.run();
}
// A simple Particle class
var Particle = function(position) {
    this.acceleration = createVector(random(-0.05, 0.05), random(-0.05, 0.05));
    this.velocity = createVector(random(-1, 1), random(-1, 1));
    this.position = position.copy();
    this.lifespan = 255.0;
};

Particle.prototype.run = function() {
    this.update();
    this.display();
};

// Method to update position
Particle.prototype.update = function() {
    this.velocity.add(this.acceleration);
    this.position.add(this.velocity);
    this.lifespan -= 2;
};

// Method to display
Particle.prototype.display = function() {
    rect(this.position.x, this.position.y, 10, 10);
    strokeWeight(0);
    fill(random(100, 255), random(100, 255), random(100, 255), this.lifespan);
};

// Is the particle still useful?
Particle.prototype.isDead = function() {
    if (this.lifespan < 0) {
        return true;
    } else {
        return false;
    }
};

var ParticleSystem = function(position) {
    this.origin = position.copy();
    this.particles = [];
};

ParticleSystem.prototype.addParticle = function() {
    this.particles.push(new Particle(this.origin));
};

ParticleSystem.prototype.run = function() {
    for (var i = this.particles.length - 1; i >= 0; i--) {
        var p = this.particles[i];
        p.run();
        if (p.isDead()) {
            this.particles.splice(i, 1);
        }
    }
};
