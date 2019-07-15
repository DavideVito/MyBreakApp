console.log(window.location.origin + "/MyBreakApp/API/Backend/checkLogin.php")
let scuolaSelezionata = null;
let sedeSelezionata = null;
let classeSelezionata = 1;

function ottieniElemento(id)
{
    return document.getElementById(id).value;
}

function login()
{
    let nome = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    $.ajax(
            {
                url: window.location.origin + "/MyBreakApp/API/Backend/checkLogin.php",
                method: "POST",
                data: {nome, password},
                
                success: function (data) {
                    data = data.replace("\n", "");
                    data = data.replace("\r", "");
                    
                    eval(data);
                }
                
            });
}




function registrati()
{
    let username = ottieniElemento("username");
    let password = ottieniElemento("password");
    let nome = ottieniElemento("nome");
    let cognome = ottieniElemento("cognome");
    let classe = classeSelezionata;
    let oggetto = {username, password, nome, cognome, classeSelezionata};
    $.ajax(
            {
                url: window.location.origin + "/MyBreakApp/API/Backend/Registrati.php",
                method: "POST",
                data: oggetto,
                success: function(data)
                {
                    document.getElementById("out").innerHTML = data;
                }
            })
    
    
    
}

/*
 * <input type="text" name="nome" id="username" value="" />
        <input type="text" name="nome" id="password" value="" />
        <input type="text" name="nome" id="nome" value="" />
        <input type="text" name="nome" id="cognome" value="" />*/


function ottieniScuola()
{
    $('#select').find('option').remove().end()
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/ottieniScuole.php",
        method: "POST",
        success: function(data)
        {
            let selectTag = document.createElement("select");
            let scuole = JSON.parse(data);

           
            let optionTags = [];
            
            for(let i = 0; i < scuole.length; i++)
            {
                let scuola = scuole[i];
                
                let optionTag = document.createElement("option");
                optionTag.value = scuola.IDScuola;
                optionTag.innerHTML = `${scuola.NomeScuola} della citta di ${scuola.Citta}`;
                selectTag.appendChild(optionTag);
                
            }
            
            scuolaSelezionata = selectTag.options[selectTag.selectedIndex].value;
            selectTag.addEventListener("change", ()=>{ 
                
                let selectTag = document.getElementById("select");
                
                scuolaSelezionata = selectTag.options[selectTag.selectedIndex].value;
                
                ottieniSede(scuolaSelezionata); 
            
            });
            ottieniSede(scuolaSelezionata);
            document.getElementById("scuole").appendChild(selectTag);
        }
        
    })
}

function ottieniSede(IDScuola)
{
    $('#sediSelect').find('option').remove().end()
    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/ottieniSedi.php",
        method: "POST",
        data: { idScuola: IDScuola},
        success: function(data)
        {
            let selectTag = document.getElementById("sediSelect");
            let sedi = JSON.parse(data);
            sedeSelezionata = sedi[0].IDSede;
            
            let optionTags = [];
            
            for(let i = 0; i < sedi.length; i++)
            {
                let sede = sedi[i];
                
                let optionTag = document.createElement("option");
                optionTag.value = sede.IDSede;
                optionTag.innerHTML = `${sede.NomeSede}`;
                selectTag.appendChild(optionTag);
                
            }
            
            sedeSelezionata = selectTag.options[selectTag.selectedIndex].value;
            selectTag.addEventListener("change", ()=>{ 
                
                let selectTag = document.getElementById("sediSelect");
                
                sedeSelezionata = selectTag.options[selectTag.selectedIndex].value;
                
                selezionaClasse(scuolaSelezionata, sedeSelezionata); });
            
            selezionaClasse(scuolaSelezionata, sedeSelezionata);
            document.getElementById("sedi").appendChild(selectTag);
        }
        
    })
}

function selezionaClasse(scuola, sede)
{
    try
    {
        $('#classiSelect').find('option').remove().end()
    } catch (exception) {
        
    }

    $.ajax({
        url: window.location.origin + "/MyBreakApp/API/Backend/ottieniClassi.php",
        method: "POST",
        data: { IDScuola: scuola, IDSede: sede},
        success: function(data)
        {
            let selectTag = document.getElementById("classiSelect");
            let classi = JSON.parse(data);

            
            
            let optionTags = [];
            
            for(let i = 0; i < classi.length; i++)
            {
                let classe = classi[i];
                
                let optionTag = document.createElement("option");
                optionTag.value = classe.IDClasse;
                optionTag.innerHTML = `${classe.Sezione}`;
                selectTag.appendChild(optionTag);
                
            }
            
            classeSelezionata = selectTag.options[selectTag.selectedIndex].value;
            selectTag.addEventListener("change", ()=>{ 
                
                let selectTag = document.getElementById("classiSelect");
                
                classeSelezionata = selectTag.options[selectTag.selectedIndex].value;
                
            
            });

            document.getElementById("classi").appendChild(selectTag);
        }
        
    })
}