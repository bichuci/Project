// let canvas = document.querySelector('canvas')
// let ctx = canvas.getContext("2d")
// ctx.beginPath()
// ctx.rect(10, 100, 50, 80)
// ctx.fillStyle = "#cd2127"
// ctx.fill()
// ctx.closePath()

// ctx.beginPath()
// ctx.arc(50, 80, 15, 0, Math.PI * 2)
// //ctx.fillStyle = "blue"
// //ctx.fill()
// ctx.strokeStyle = "blue"
// ctx.stroke()
// ctx.closePath()
// //effacer la totalité du canvas
// ctx.clearRect(0, 0, canvas.width, canvas.height)

// let dx = 2
// let dy = 2
// let x = 10
// let y = 20
// let xr = 50
// let yr = 70
// var speed = 20
// let anim = () => {
//     x = x + dx
//     y = y + dy
//     // xr += dx
//     // yr += dy
//     //déplacer le cercle dans le sens inverse quand on arrive a la fin du canvas => largeur
//     if (x >= (canvas.width - 15)) {
//         dx = -dx
//     }
//     //Inverser encore le sens quand on arrive au début du canvas => largeur
//     else if (x <= 15) {
//         dx = 2
//     }
//     //hauteur
//     if (y >= (canvas.height - 15)) {
//         dy = -dy

//     }
//     //hauteur
//     else if (y <= 15) {
//         dy = 2

//     }

//     ctx.clearRect(0, 0, canvas.width, canvas.height)
//     ctx.beginPath()

//     ctx.arc(x, y, 15, 0, Math.PI * 2)
//     //ctx.fillStyle = "blue"
//     //ctx.fill()
//     ctx.strokeStyle = "blue"
//     ctx.stroke()
//     ctx.closePath()

// }

// setInterval(() => {
//     anim()
// }, speed);

// document.addEventListener('keyup',(e) => {
//     if(e.keyCode == 39) {
//         dx = 2
//     }
//     else if(e.keyCode == 37) {
//         dx = -2
//     }
//     else if(e.keyCode == 40) {
//         dy = 2
//     }
//     else if(e.keyCode == 38) {
//         dy = -2
//     }

// })

/*const cases = []
const delta = 2
let x = 10
let y = 10
let dx = 0
let dy = 0
let prop = 0
let gameOver = false
let generateRect = true
let direction = undefined
let cibleCase = {
    x: 0,
    y: 0,
}
const width = 10
const height = 10
const drawRect = (i, j) => {
    ctx.beginPath()
    ctx.rect(i, j, width, height)
    ctx.fillStyle = "#cd2127"
    ctx.fill()
    ctx.closePath()
}

const drawRandomRect = () => {
    if (generateRect) {
        cibleCase.x = Math.floor(Math.random() * (canvas.width - width))
        cibleCase.y = Math.floor(Math.random() * (canvas.height - height))
        generateRect = false
    }
    console.log(cibleCase)
    drawRect(cibleCase.x, cibleCase.y)
}
cases.push({
    x: 0,
    y: 0,
    direction: "right"
})
setInterval(() => {
    ctx.clearRect(0, 0, canvas.width, canvas.height)
    if (!gameOver) {

        if (x >= canvas.width - width || x <= 0 || y >= canvas.height - height || y <= 0) {
            alert("game over")
            gameOver = true
        }
        else if (cases[cases.length - 1].x == cibleCase.x && cases[cases.length - 1].y == cibleCase.y) {
            console.log("test")
            generateRect = true
            cases.push({
                x: cibleCase.x,
                y: cibleCase.y,
                direction: direction
            })
        }
        else {
            for (let c of cases) {
                if(c.x == dx && c.y == dy) {
                    c.direction = direction
                }
                switch (c.direction) {
                    case "right":
                        c.x += delta
                        break;
                    case "left":
                        c.x -= delta
                        break;
                    case "top":
                        c.y -= delta
                        break;
                    case "bottom":
                        c.y += delta
                        break;
                }
                drawRect(c.x, c.y)
                     
            }
        }
        drawRandomRect()
    }
}, 20);
document.addEventListener('keyup', (e) => {
    if (e.keyCode == 37) {
        direction = "left"
    }
    else if (e.keyCode == 39) {
        direction = "right"
    }
    else if (e.keyCode == 38) {
        direction = "top"
    }
    else if (e.keyCode == 40) {
        direction = "bottom"
    }
    if(cases.length > 1) {
        dx = cases[cases.length - 1].x
        dy = cases[cases.length - 1].y
    }
    
})*/

class snake {
    constructor(ctx, width, height) {
        this.ctx = ctx
        this.width = width
        this.height = height
        this.widthCase = 50
        this.heightCase = 50
        this.cases = []
        this.direction = undefined
        this.delta = 2
        this.cible = this.makeCible()
        this.cases.push({
            x: 0,
            y: 0,
            direction: this.direction
        })
        
    }

    makeCible() {
        let cible = {
            x: Math.floor(Math.random() * (this.width - this.widthCase)),
            y: Math.floor(Math.random() * (this.height - this.heightCase))
        }

        return cible
    }

    changeDirection(c) {
        if (c.x == this.cases[this.cases.length - 1].x && c.y == this.cases[this.cases.length - 1].y) {
            console.log("test")
            c.direction = this.direction
        }
    }

    drawAll() {    
        this.ctx.clearRect(0, 0, this.width, this.height)
        for (let i = 0; i < this.cases.length; i++) {
            let c = this.cases[i]
            if (i < this.cases.length - 1) {
                this.changeDirection(c)
            }
            switch (c.direction) {
                case "left":
                    c.x -= this.delta
                    break;
                case "right":
                    c.x += this.delta
                    break;
                case "top":
                    c.y -= this.delta
                    break;
                case "bottom":
                    c.y += this.delta
                    break;
            }
            this.drawCase(c.x, c.y)
            

        }
        this.drawCase(this.cible.x, this.cible.y)
    }

    drawCase(x, y) {
        this.ctx.beginPath()
        this.ctx.rect(x, y, this.widthCase, this.heightCase)
        this.ctx.fillStyle = "#cd2127"
        this.ctx.fill()
        this.ctx.closePath()
    }

    init() {
        this.eventListener()
        setInterval(() => {
            this.drawAll()
            this.reachCible()
        }, 20);
    }

    reachCible() {
        if ((this.cases[this.cases.length - 1].x <= (this.cible.x + this.widthCase) && this.cases[this.cases.length - 1].x >= this.cible.x) && (this.cases[this.cases.length - 1].y <= (this.cible.y + this.heightCase) && this.cases[this.cases.length - 1].y >= this.cible.y)) { 
            let nx = this.cases[this.cases.length - 1].x, ny = this.cases[this.cases.length - 1].y
            switch (this.direction) {
                case "left":
                    nx = this.cases[this.cases.length - 1].x + this.widthCase
                    break;
                case "right":
                    nx = this.cases[this.cases.length - 1].x - this.widthCase
                    break;
                case "top":
                    ny = this.cases[this.cases.length - 1].y + this.height
                    break;
                case "bottom":
                    ny = this.cases[this.cases.length - 1].y - this.height
                    break;
                default:
                    break;
            }
            this.cases.push({
                x: nx,
                y: ny,
                direction: this.direction
            })
            this.cible = this.makeCible()
            console.log(this.cases)
        }
    }

    eventListener() {
        document.addEventListener('keyup', (e) => {
           
            switch (e.keyCode) {
                case 37:
                    this.direction = "left"
                    break;
                case 39:
                    this.direction = "right"
                    break;
                case 38:
                    this.direction = "top"
                    break;
                case 40:
                    this.direction = "bottom"
                    break;
            }
            this.cases[this.cases.length - 1].direction = this.direction
        })
    }
}
let canvas = document.querySelector('canvas')
let ctx = canvas.getContext("2d")
let s = new snake(ctx, canvas.width, canvas.height)
s.init()