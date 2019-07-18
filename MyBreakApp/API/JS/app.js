console.log(window.location.origin + "/MyBreakApp/API/Backend/checkLogin.php")
let scuolaSelezionata = null;
let sedeSelezionata = null;
let classeSelezionata = 1;
let carrello = [];
let panini = [];

function ottieniElemento(id) {
    return document.getElementById(id).value;
}

function login() {
    let nome = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/checkLogin.php",
        method: "POST",
        data: {
            nome,
            password
        },

        success: function (data) {
            data = data.replace("\n", "");
            data = data.replace("\r", "");
            eval(data);
        }

    });
}

function registrati() {
    let username = ottieniElemento("username");
    let password = ottieniElemento("password");
    let nome = ottieniElemento("nome");
    let cognome = ottieniElemento("cognome");
    let classe = classeSelezionata;
    let oggetto = {
        username,
        password,
        nome,
        cognome,
        classeSelezionata
    };
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/Registrati.php",
        method: "POST",
        data: oggetto,
        success: function (data) {
            document.getElementById("out").innerHTML = data;
        }
    })



}

function ottieniScuola() {
    $('#select').find('option').remove().end();
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/ottieniScuole.php",
        method: "POST",
        success: function (data) {
            let selectTag = document.createElement("select");
            let scuole = JSON.parse(data);


            let optionTags = [];

            for (let i = 0; i < scuole.length; i++) {
                let scuola = scuole[i];

                let optionTag = document.createElement("option");
                optionTag.value = scuola.IDScuola;
                optionTag.innerHTML = `${scuola.NomeScuola} della citta di ${scuola.Citta}`;
                selectTag.appendChild(optionTag);

            }

            scuolaSelezionata = selectTag.options[selectTag.selectedIndex].value;
            selectTag.addEventListener("change", () => {

                let selectTag = document.getElementById("select");

                scuolaSelezionata = selectTag.options[selectTag.selectedIndex].value;

                ottieniSede(scuolaSelezionata);

            });
            ottieniSede(scuolaSelezionata);
            document.getElementById("scuole").appendChild(selectTag);
        }

    })
}

function ottieniSede(IDScuola) {
    $('#sediSelect').find('option').remove().end()
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/ottieniSedi.php",
        method: "POST",
        data: {
            idScuola: IDScuola
        },
        success: function (data) {
            let selectTag = document.getElementById("sediSelect");
            let sedi = JSON.parse(data);
            sedeSelezionata = sedi[0].IDSede;

            let optionTags = [];

            for (let i = 0; i < sedi.length; i++) {
                let sede = sedi[i];

                let optionTag = document.createElement("option");
                optionTag.value = sede.IDSede;
                optionTag.innerHTML = `${sede.NomeSede}`;
                selectTag.appendChild(optionTag);

            }

            sedeSelezionata = selectTag.options[selectTag.selectedIndex].value;
            selectTag.addEventListener("change", () => {

                let selectTag = document.getElementById("sediSelect");

                sedeSelezionata = selectTag.options[selectTag.selectedIndex].value;

                selezionaClasse(scuolaSelezionata, sedeSelezionata);
            });

            selezionaClasse(scuolaSelezionata, sedeSelezionata);
            document.getElementById("sedi").appendChild(selectTag);
        }

    })
}

function selezionaClasse(scuola, sede) {
    try {
        $('#classiSelect').find('option').remove().end()
    } catch (exception) {

    }

    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/ottieniClassi.php",
        method: "POST",
        data: {
            IDScuola: scuola,
            IDSede: sede
        },
        success: function (data) {
            let selectTag = document.getElementById("classiSelect");
            let classi = JSON.parse(data);



            let optionTags = [];

            for (let i = 0; i < classi.length; i++) {
                let classe = classi[i];

                let optionTag = document.createElement("option");
                optionTag.value = classe.IDClasse;
                optionTag.innerHTML = `${classe.Sezione}`;
                selectTag.appendChild(optionTag);

            }

            classeSelezionata = selectTag.options[selectTag.selectedIndex].value;
            selectTag.addEventListener("change", () => {

                let selectTag = document.getElementById("classiSelect");

                classeSelezionata = selectTag.options[selectTag.selectedIndex].value;


            });

            document.getElementById("classi").appendChild(selectTag);
        }

    })
}

function ottieniPanini(idScuola)
{
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/ottieniPanini.php",
        method: "POST",
        data: {idScuola},
        success: function(data)
        {
            console.log(data);
            panini = JSON.parse(data);
            let out = document.getElementById("out");
            console.log(panini);
            for(let i = 0; i < panini.length; i++)
            {
                let panino = panini[i];
                let divPanino = document.createElement("div");
                
                let tagImmagine = document.createElement("img");
                tagImmagine.src = panino.Immagine;
                tagImmagine.width = 250;
                tagImmagine.height = 250;
                
                let buttonPrezzo = document.createElement("button");
                buttonPrezzo.textContent = "Compra questo panino per solo " + panino.Prezzo + "€";
                buttonPrezzo.addEventListener("click", ()=>{aggiungiAlCarrello(panino);});

                
                let tagNome = document.createElement("p");
                tagNome.textContent = panino.Nome;
                
                divPanino.appendChild(tagNome);
                divPanino.appendChild(tagImmagine);
                divPanino.appendChild(buttonPrezzo);
                out.appendChild(divPanino);
                
                
            }
            
        }
    });
}

function aggiungiAlCarrello(panino)
{
    carrello.push(panino);
}


function compra(idUtente)
{
    console.log(carrello);
    let newCarrello = [];
    for(let i = 0; i < carrello.length; i++)
    {
        let panino = carrello[i]
        newCarrello.push({id: panino.IDPanino});
    }
    
    let daMandare = {idUtente: idUtente, panini: newCarrello};
    
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/inserisciPanini.php",
        method: "POST",
        data: daMandare,
        success: function(data)
        {
            if(data === "tappofrat")
            {
                alert("Ciao bellissimo, ma quanto cazzo mangi?");
            }
        }
        
        
    });
}

class Classe
{
    constructor(nomeClasse)
    {
        this.nomeClasse = nomeClasse;
        this.panini = [];
    }
    
    uguale(classe2)
    {
        return this.nomeClasse === classe2.nomeClasse;
    }
    
    addPanino(nome, prezzo, qta)
    {
        this.panini.push({nome, prezzo, qta});
    }
    
    calcolaNumeroPaniniOrdinati()
    {
        let numero = 0;
        let panini = this.panini;
        for(let i = 0; i < panini.length; i++)
        {
            let panino = panini[i];
            numero += Number(panino.qta);
        }
        return numero;
    }
    
    calcolaPrezzoTotale()
    {
        let prezzo = 0;
        let panini = this.panini;
        for(let i = 0; i < panini.length; i++)
        {
            let panino = panini[i];
            prezzo += Number(panino.prezzo);
        }
        return prezzo;
    }
    
}

function stampaTabellaPaninara(ordine)
{
    let panini = JSON.parse(ordine);
    console.log(panini);
    
    let classi = [];
    //COUNT(*) as Qta, Classe.Sezione, Panino.Nome, Panino.Prezzo
    let matrice = [];
    let indice = 0;
    for(let i = 0; i < panini.length; i++)
    {
        let find = false;
        let panino = panini[i];
        let classe = new Classe(panino.Sezione);
        for(let j = 0; j < classi.length; j++)
        {
            if(classe.uguale(classi[j]))
            {
                find = true;
                classe = classi[j];
            }
        }
        if(!find)
        {
            classi.push(classe);
        }
        classe.addPanino(panino.Nome, panino.Prezzo, panino.Qta)
    }
    
    let doveScrivere = document.getElementById("tabellaStampata");
    for(let i = 0; i < classi.length; i++)
    {
        let classe = classi[i];
        let titolo = document.createElement("h5");
        titolo.textContent = "La classe " + classe.nomeClasse + " ha ordinato " + classe.calcolaNumeroPaniniOrdinati() + " per il costo di " + classe.calcolaPrezzoTotale() + "€";
        
        
        let tabella = document.createElement("table");
        tabella.border = 2;
        
        
        
        for(let i = 0; i < classe.panini.length; i++)
        {
            let panino = classe.panini[i];
            let riga = document.createElement("tr");
        
            let nomeCella = document.createElement("td");
            let prezzoCella = document.createElement("td");
            let qtaCella = document.createElement("td");
            
            nomeCella.textContent = panino.nome;
            prezzoCella.textContent = panino.prezzo + "€";
            qtaCella.textContent = panino.qta;
            
            riga.appendChild(nomeCella);
            riga.appendChild(prezzoCella);
            riga.appendChild(qtaCella);
            
            tabella.appendChild(riga);
        }
        doveScrivere.appendChild(titolo);
        doveScrivere.appendChild(tabella);
        
        
    }
    
    
}


function parsaScuolaSedeClasse()
{
    let dom = document.getElementById("out").textContent;
    let ogg = JSON.parse(dom);
    console.log(ogg);
}