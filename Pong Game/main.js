// Phaser Game Configuration
const config = {
    type: Phaser.AUTO, // Automatische selectie van rendering context
    width: 800, // Breedte van het speelveld
    height: 500, // Hoogte van het speelveld

    // Definieert de spelonderdelen
    scene: {
        preload: preload, // Functie vooraf laden van game assets
        create: create, // Functie voor het maken van game-elementen
        update: update // Functie voor het continu updaten van de game
    },
    physics: {
        default: 'arcade', // Arcade physics engine gebruiken
        arcade: {
            gravity: { y: 0 } // Zwaartekracht instellen op nul (geen zwaartekracht)
        }
    }
};

// Phaser Game Instantiatie met bovenstaande configuratie
const game = new Phaser.Game(config);

// Initialisatie van variabelen
let ball;
let paddles;
let keys;
let leftScore = 0;
let rightScore = 0;
let leftScoreText;
let rightScoreText;
let startButton;
let instructionsButton;
let instructionText;
let startPageActive = true;

// Functie voor het vooraf laden van game assets
function preload() {
    this.load.image('paddle', 'assets/paddles.png');
    this.load.image('ball', 'assets/ball.png');
}

// Functie voor het maken van het startmenu
function create() {
    createStartPage.call(this);
}

// Functie om het startmenu te maken
function createStartPage() {
    // Start- en Instructieknoppen
    startButton = this.add.text(350, 200, 'Start', { fontSize: '32px', fill: '#fff' }).setInteractive();
    instructionsButton = this.add.text(310, 250, 'Instructions', { fontSize: '32px', fill: '#fff' }).setInteractive();

    // Eventlisteners voor de knoppen
    startButton.on('pointerdown', startGame, this);
    instructionsButton.on('pointerdown', showInstructions, this);
}

// Functie om het spel te starten
function startGame() {
    // Verwijderen van startmenu-elementen
    startButton.destroy();
    instructionsButton.destroy();

    if (instructionText) {
        instructionText.destroy();
    }

    // Initialisatie van de paddles en bal
    paddles = this.physics.add.group();

    const leftPaddle = paddles.create(50, config.height / 2, 'paddle');
    leftPaddle.setCollideWorldBounds(true);
    leftPaddle.setImmovable();

    const rightPaddle = paddles.create(config.width - 50, config.height / 2, 'paddle');
    rightPaddle.setCollideWorldBounds(true);
    rightPaddle.setImmovable();

    ball = this.physics.add.sprite(config.width / 2, config.height / 2, 'ball');
    ball.setCollideWorldBounds(true);
    ball.setBounce(1);
    ball.setVelocity(Phaser.Math.Between(-600, 600), 600);

    keys = this.input.keyboard.addKeys({
        'upLeft': Phaser.Input.Keyboard.KeyCodes.W,
        'downLeft': Phaser.Input.Keyboard.KeyCodes.S,
        'upRight': Phaser.Input.Keyboard.KeyCodes.UP,
        'downRight': Phaser.Input.Keyboard.KeyCodes.DOWN,
    });

    leftScoreText = this.add.text(50, 50, 'Left: 0', {
        fontSize: '24px',
        fill: '#fff',
    });

    rightScoreText = this.add.text(config.width - 150, 50, 'Right: 0', {
        fontSize: '24px',
        fill: '#fff',
    });

    startPageActive = false; // Het spel is gestart
}

// Functie om instructies te tonen
function showInstructions() {
    instructionText = this.add.text(100, 100, "Movement: left paddle (W/S), right paddle (↑/↓)", { fontSize: '24px', fill: '#fff' });
}

// Functie voor het continu updaten van de game
function update() {
    if (startPageActive) {
        return; // Stop de update als het startmenu actief is
    }

    // Beweging van de paddles
    if (keys.upLeft.isDown) {
        paddles.getChildren()[0].setVelocityY(-600);
    } else if (keys.downLeft.isDown) {
        paddles.getChildren()[0].setVelocityY(600);
    } else {
        paddles.getChildren()[0].setVelocityY(0);
    }

    if (keys.upRight.isDown) {
        paddles.getChildren()[1].setVelocityY(-600);
    } else if (keys.downRight.isDown) {
        paddles.getChildren()[1].setVelocityY(600);
    } else {
        paddles.getChildren()[1].setVelocityY(0);
    }

    // Controleer de botsingen tussen de bal en paddles
    this.physics.world.collide(ball, paddles, (ball, paddle) => {
        // Verhoog bal snelheid
        ball.setVelocityX(ball.body.velocity.x * 1.1);
        ball.setVelocityY(ball.body.velocity.y * 1.1);
    });

    // Controleer score en reset de bal indien nodig
    if (ball.x <= 20) {
        rightScore += 1;
        rightScoreText.setText(`Right: ${rightScore}`);
        resetBallpaddle();
    } else if (ball.x >= 780) {
        leftScore += 1;
        leftScoreText.setText(`Left: ${leftScore}`);
        resetBallpaddle();
    }
    $.ajax({
        type: "POST",
        url: "submit_form.php",
        data: {
            rightScore: rightScore,
            leftScore: leftScore
        },
        success: function (response) {
            console.log("Scores succesvol opgeslagen:", response);
        },
        error: function (error) {
            console.error("Fout bij het opslaan van scores:", error);
        }
    });
}

// Functie om de bal en paddles te resetten
function resetBallpaddle() {
    ball.setPosition(config.width / 2, config.height / 2);
    ball.setVelocity(Phaser.Math.Between(-600, 600), 600);

    // Paddles worden teruggezet naar het midden
    paddles.getChildren()[0].setPosition(50, config.height / 2);
    paddles.getChildren()[1].setPosition(config.width - 50, config.height / 2);
}

