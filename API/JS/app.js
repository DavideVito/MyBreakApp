
let scuolaSelezionata = null;
let sedeSelezionata = null;
let classeSelezionata = 1;
let carrello = [];
let panini = [];
scuole = [];
sedi = [];

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

function ottieniSede(scuola) {
    $('#sediSelect').find('option').remove().end()
    let selectTag = document.getElementById("sediSelect");


    let sedi = scuola.sedi;
    let optionTags = [];

    for (let i = 0; i < sedi.length; i++) {
        let sede = sedi[i];

        let optionTag = document.createElement("option");
        if (sede.classi[0].length !== 0)
        {
            optionTag.value = sede.classi[0][0].IDSede;
        } else
        {
            continue;
        }
        optionTag.innerHTML = `${sede.nomeSede}`;
        selectTag.appendChild(optionTag);

    }

    sedeSelezionata = selectTag.options[selectTag.selectedIndex].value;
    selectTag.addEventListener("change", () => {

        let selectTag = document.getElementById("sediSelect");

        sedeSelezionata = selectTag.options[selectTag.selectedIndex].value;

        sedeSelezionata = Sede.ottieniSedeDaId(sedeSelezionata);

        selezionaClasse(sedeSelezionata.classi[0]);
    });

    sedeSelezionata = Sede.ottieniSedeDaId(sedeSelezionata);

    selezionaClasse(sedeSelezionata.classi[0]);

    document.getElementById("sedi").appendChild(selectTag);
}

function selezionaClasse(classi) {
    try {
        $('#classiSelect').find('option').remove().end();
    } catch (exception) {

    }

    let selectTag = document.getElementById("classiSelect");

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

function ottieniPanini(idScuola)
{
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/ottieniPanini.php",
        method: "POST",
        data: {idScuola},
        success: function (data)
        {
            panini = JSON.parse(data);
            let out = document.getElementById("out");
            for (let i = 0; i < panini.length; i++)
            {
                let panino = panini[i];
                let divPanino = document.createElement("div");

                let tagImmagine = document.createElement("img");
                tagImmagine.src = panino.Immagine;
                tagImmagine.width = 250;
                tagImmagine.height = 250;

                let paragrafo = document.createElement("p");
                paragrafo.textContent = "Clicca per comprare questo panino al costo di: " + panino.Prezzo + "€";
                paragrafo.style.padding = -20;
                tagImmagine.addEventListener("click", () => {

                    $(paragrafo).animate({opacity: 0}, 400, null, () =>
                    {
                        $(paragrafo).text("Panino aggiunto");
                        $(paragrafo).animate({opacity: 1}, 400);

                    });

                    setTimeout(() => {

                        $(paragrafo).animate({opacity: 0}, 400, null, () =>
                        {
                            $(paragrafo).text("Clicca per comprare questo panino al costo di: " + panino.Prezzo + "€");
                            $(paragrafo).animate({opacity: 1}, 400);
                        });




                    }, 1500);


                    aggiungiAlCarrello(panino);
                });

                paragrafo.addEventListener('click', () => {
                    alert("Non qua genio, sulla foto ❤️");
                });

                let tagNome = document.createElement("p");
                tagNome.textContent = panino.Nome;
                $(tagNome).css({fontSize: 25});
                $(tagNome).css({color: "#212F3C"});


                divPanino.appendChild(tagNome);
                divPanino.appendChild(tagImmagine);
                divPanino.appendChild(paragrafo);
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
    let newCarrello = [];
    for (let i = 0; i < carrello.length; i++)
    {
        let panino = carrello[i]
        newCarrello.push({id: panino.IDPanino});
    }

    let daMandare = {idUtente: idUtente, panini: newCarrello};
    debugger;
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/inserisciPanini.php",
        method: "POST",
        data: daMandare,
        success: function (data)
        {
            if (data === "tappofrat")
            {
                alert("Ciao bellissimo, ma quanto cazzo mangi?");
            }
            carrello = [];
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

    addPanino(nome, prezzo, qta, id, idOrdine, idUtente)
    {
        this.panini.push({nome, prezzo, qta, id, idOrdine, idUtente});
    }

    calcolaNumeroPaniniOrdinati()
    {
        let numero = 0;
        let panini = this.panini;
        for (let i = 0; i < panini.length; i++)
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
        for (let i = 0; i < panini.length; i++)
        {
            let panino = panini[i];
            prezzo += Number(panino.prezzo) * Number(panino.qta);
        }
        return prezzo;
    }

}

function stampaTabellaPaninara(ordine)
{
    classi = [];
    let panini = JSON.parse(ordine);

    let matrice = [];
    let indice = 0;
    for (let i = 0; i < panini.length; i++)
    {
        let find = false;
        let panino = panini[i];
        let classe = new Classe(panino.Sezione);
        for (let j = 0; j < classi.length; j++)
        {
            if (classe.uguale(classi[j]))
            {
                find = true;
                classe = classi[j];
            }
        }
        if (!find)
        {
            classi.push(classe);
        }
        classe.addPanino(panino.Nome, panino.Prezzo, panino.Qta, panino.IDPanino, panino.IDOrdine, panino.IDUtente);
    }
    let doveScrivere = document.getElementById("tabellaStampata");
    for (let i = 0; i < classi.length; i++)
    {
        let classe = classi[i];
        let titolo = document.createElement("h5");
        titolo.textContent = "La classe " + classe.nomeClasse + " ha ordinato " + classe.calcolaNumeroPaniniOrdinati() + " per il costo di " + classe.calcolaPrezzoTotale() + "€";


        let tabella = document.createElement("table");
        tabella.className = "tabella";
        tabella.border = 2;


        for (let j = 0; j < classe.panini.length; j++)
        {
            let panino = classe.panini[j];

            let pulsante = document.createElement("input");
            pulsante.type = "button";
            pulsante.value = `Clicca per inserire 1 panino ${panino.nome}`;
            pulsante.addEventListener("click", () => {
                segnaPanino(panino.idOrdine);
            });


            let riga = document.createElement("tr");

            let nomeCella = document.createElement("td");
            let prezzoCella = document.createElement("td");
            let qtaCella = document.createElement("td");
            let buttonCella = document.createElement("td");
            buttonCella.appendChild(pulsante);

            nomeCella.textContent = panino.nome;
            prezzoCella.textContent = panino.prezzo + "€";
            qtaCella.textContent = panino.qta;

            riga.appendChild(nomeCella);
            riga.appendChild(prezzoCella);
            riga.appendChild(qtaCella);
            riga.appendChild(buttonCella);

            tabella.appendChild(riga);
        }
        doveScrivere.appendChild(titolo);
        doveScrivere.appendChild(tabella);
    }
}

function segnaPanino(idOrdine)
{
    mandaAlServer(idOrdine);
}

function mandaAlServer(idOrdine)
{
    let sedeAndID = document.getElementById("idSedeIdClasse").textContent;

    sedeAndID = JSON.parse(sedeAndID);

    let oggettoDaMandare = {
        idOrdine: idOrdine,
        sede: sedeAndID.sede,
        scuola: sedeAndID.scuola

    };


    let oggettoAjax = {
        url: window.location.origin + "/MyBreakApp/API/Backend/decrementaPaninoDatabase.php",
        method: "POST",
        data: oggettoDaMandare,
        success: function (data)
        {

            rimuoviTuttiFigliDiUnTag("tabellaStampata");
            stampaTabellaPaninara(data);
        }


    };

    $.ajax(oggettoAjax);

}

class Scuola
{
    constructor(nomeScuola)
    {
        this.nomeScuola = nomeScuola;
        this.sedi = [];
    }

    aggiungiSede(sedeOggetto)
    {
        this.sedi.push(sedeOggetto);
    }

    static ottieniScuolaDaId(id)
    {
        for (let i = 0; i < scuole.length; i++)
        {
            let scuola = scuole[i];
            for (let j = 0; j < scuola.sedi.length; j++)
            {
                let sede = scuola.sedi[j];
                let classi = sede.classi[0];
                for (let k = 0; k < classi.length; k++)
                {
                    let classe = classi[k];
                    if (classe.IDScuola === id)
                    {
                        return scuola;
                    }

                }
            }
        }
    }
}

class Sede
{
    constructor(nomeSede)
    {
        this.nomeSede = nomeSede;
        this.classi = new Array();

    }

    aggiungiClasse(classe)
    {
        this.classi.push(classe);
    }

    static ottieniSedeDaId(id)
    {
        for (let j = 0; j < sedi.length; j++)
        {
            let sede = sedi[j];
            let classi = sede.classi[0];
            for (let k = 0; k < classi.length; k++)
            {
                let classe = classi[k];
                if (classe.IDSede === id)
                {
                    return sede;
                }

            }
        }
    }
}

function parsaScuolaSedeClasse()
{
    let dom = document.getElementById("jsonDb").textContent;
    let ogg = JSON.parse(dom);
    scuole = [];

    for (let scuolaProp in ogg)
    {
        if (ogg.hasOwnProperty(scuolaProp))
        {
            let scuola = new Scuola(scuolaProp);

            for (let sediProp in ogg[scuolaProp])
            {
                let sede = new Sede(sediProp);
                sede.aggiungiClasse(ogg[scuolaProp][sediProp]);
                scuola.aggiungiSede(sede);
            }
            scuole.push(scuola);
        }
    }


    let selectScuola = document.createElement("select");
    //let optionTagTmp = document.createElement("option");
    selectScuola.id = "select";
    //optionTagTmp.innerHTML = "fjoejfoe";
    //selectScuola.appendChild(optionTagTmp);

    for (let i = 0; i < scuole.length; i++)
    {
        let scuola = scuole[i];
        let optionTag = document.createElement("option");


        if (scuola.sedi[0].classi[0].length !== 0)
        {
            optionTag.value = scuola.sedi[0].classi[0][0].IDScuola;
        } else
        {
            continue;
        }
        optionTag.innerHTML = `${scuola.nomeScuola} della citta di ${scuola.sedi[0].classi[0][0].Citta}`;
        selectScuola.appendChild(optionTag);

    }

    selectScuola.addEventListener("change", () => {

        let selectTag = document.getElementById("select");

        let scuolaSelezionata = selectTag.options[selectTag.selectedIndex].value;

        scuolaSelezionata = Scuola.ottieniScuolaDaId(scuolaSelezionata);

        sedi = scuolaSelezionata.sedi;
        ottieniSede(scuolaSelezionata);

    });

    let scuolaSelezionata = selectScuola.options[selectScuola.selectedIndex].value;

    scuolaSelezionata = Scuola.ottieniScuolaDaId(scuolaSelezionata);

    sedi = scuolaSelezionata.sedi;
    ottieniSede(scuolaSelezionata);
    document.getElementById("scuole").appendChild(selectScuola);
}



function stampaScuole()
{
    parsaScuolaSedeClasse();
    document.body.write(JSON.stringify(scuolaSelezionata));
}

function rimuoviTuttiFigliDiUnTag(idTag)
{
    var tag = document.getElementById(idTag);
    while (tag.firstChild) {
        tag.removeChild(tag.firstChild);
    }
}