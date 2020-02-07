<?php
require_once '../JS/OttieniJQuery.php';
require_once '../JS/OttieniMain.php';
?> 


</div>
<script>stampaScuole('<?php
$sito = $_SERVER['HTTP_HOST'] . "/MyBreakApp/API/Backend/ottieniScuole.php";
//var_dump();
$esito = file_get_contents("https://" . $_SERVER['HTTP_HOST'] . "/MyBreakApp/API/Backend/ottieniScuole.php");
$esito = json_decode($esito);
//$scule = $esito;
$scuole = [];
//ottengo le sedi
foreach ($esito as $scuola) {
    $sedi = [];
    $idScuola = $scuola->IDScuola;
    $curlScuole = curl_init();
    curl_setopt($curlScuole, CURLOPT_URL, "https://" . $_SERVER['HTTP_HOST'] . "/MyBreakApp/API/Backend/ottieniSedi.php");
    curl_setopt($curlScuole, CURLOPT_POSTFIELDS, "idScuola=$idScuola");
    curl_setopt($curlScuole, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($curlScuole);
    $server_output = json_decode($server_output);
    array_push($sedi, $server_output);
    $sedi = $sedi[0];
    //var_dump($sedi);
    curl_close($curlScuole);
    for ($i = 0; $i < count($sedi); $i++) {
        $sede = $sedi[$i];
        $idSede = $sede->IDSede;
        $curlClassi = curl_init();
        curl_setopt($curlClassi, CURLOPT_URL, "https://" . $_SERVER['HTTP_HOST'] . "/MyBreakApp/API/Backend/ottieniClassi.php");
        curl_setopt($curlClassi, CURLOPT_POSTFIELDS, "IDSede=$idSede&IDScuola=$idScuola");
        curl_setopt($curlClassi, CURLOPT_RETURNTRANSFER, true);
        $server_output2 = curl_exec($curlClassi);
        $server_output2 = json_decode($server_output2);
        $scuole["$scuola->NomeScuola"]["$sede->NomeSede"] = $server_output2;

        curl_close($curlClassi);
    }
}
echo str_replace(" ", "", json_encode($scuole));
?>')</script>