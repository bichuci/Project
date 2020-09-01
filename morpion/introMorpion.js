const taille = 4
const grid = document.querySelector(".grid")

let endGame = false
for (let i = 1; i <= taille; i++) {
    for (let j = 1; j <= taille; j++) {
        let chaine = ""
        if(i == j) {
             chaine += " data-diag1=1"
        }
        if(i+j == taille +1) {
            chaine += " data-diag2=1"
        }
        //grid.innerHTML += '<div class="col-' + parseInt(12 / taille) + ' case" data-x="' + i + '" data-d="' + i + '-' + j + '" data-y="' + j + '"></div>'
        grid.innerHTML += '<div class="col-' + parseInt(12 / taille) + ' case" data-x="' + i + '" '+chaine+' data-y="' + j + '"></div>'
    }
}
let isFirstPlayer = true
grid.addEventListener('click', function (e) {
    if (e.target.innerText == "" && endGame == false) {
        e.target.innerText = (isFirstPlayer) ? 'X' : 'O'
        isFirstPlayer = !isFirstPlayer
        if (testWin()) {
            alert("Vous avez gagné")
        }
    }
})

function testWin() {
    let win = false
    for (let i = 1; i <= taille; i++) {
        const elementLigne = document.querySelectorAll('div[data-x="' + i + '"]')
        const elementColonne = document.querySelectorAll('div[data-y = "' + i + '"]')
        let sameValueX = true
        let sameValueY = true
        //test si on a gagné sur l'axe des X et des Y
        for (let k = 0; k < elementLigne.length - 1; k++) {
            if (elementLigne[k].innerText == "" || elementLigne[k].innerText != elementLigne[k + 1].innerText) {
                sameValueX = false
            }
            if (elementColonne[k].innerText == "" || elementColonne[k].innerText != elementColonne[k + 1].innerText) {
                sameValueY = false
            }
        }
        if (sameValueX || sameValueY ||testDiago()) {
            endGame = true
            win = true
            break
        }
    }

    return win
}

function testDiago() {
    //Solution par manu
    const elementDiag1 = document.querySelectorAll('div[data-diag1 = "1"]')
    const elementDiag2 = document.querySelectorAll('div[data-diag2 = "1"]')
    let sameValueD1 = true
    let sameValueD2 = true
    for (let k = 0; k < elementDiag1.length - 1; k++) {
        if (elementDiag1[k].innerText == "" || elementDiag1[k].innerText != elementDiag1[k + 1].innerText) {
            sameValueD1 = false
        }
        if (elementDiag2[k].innerText == "" || elementDiag2[k].innerText != elementDiag2[k + 1].innerText) {
            sameValueD2 = false
        }
    }
    //Solution par Ihab
    // let tmpValueD1, tmpValueD2
    // let k = 1
    // let sameValueD1 = true
    // let sameValueD2 = true
    // for (let j = 1; j <= taille; j++) {
    //     //Recuperer les elements 1 par 1 sur la premiere et la deuxieme Diag
    //     const elementDiag1 = document.querySelector('div[data-d="' + j + '-' + j + '"]')
    //     const elementDiag2 = document.querySelector('div[data-d="' + j + '-' + (taille-j+1) + '"]')
    //     //Vérifier si le contenu des elements sur la première diago sont identiques
    //     if (elementDiag1.innerText == "" || (k != 1 && elementDiag1.innerText != tmpValueD1)) {
    //         sameValueD1 = false
    //     }
    //     else {
    //         tmpValueD1 = document.querySelector('div[data-d="' + j + '-' + j + '"]').innerText
    //     }
        
    //     //Vérifier si le contenu des elements sur la deuxième diago sont identiques
    //     if (elementDiag2.innerText == "" || (k != 1 && elementDiag2.innerText != tmpValueD2)) {
    //         sameValueD2 = false
    //     }
    //     else {
    //         tmpValueD2 = document.querySelector('div[data-d="' + j + '-' + (taille-j+1) + '"]').innerText
    //     }
    //     k++;
    // }
    return (sameValueD1 || sameValueD2)
}