<?php 
try 
{ 
    $db = new PDO('mysql:host=localhost;dbname=broodjeshaven', 'root' ,''); 
} 
catch(PDOException $e) 
{ 
<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=broodjeshaven', 'root', '');
} catch (PDOException $e) {
    $sMsg = '<p> 
            Regelnummer: ' . $e->getLine() . '<br /> 
            Bestand: ' . $e->getFile() . '<br /> 
            Foutmelding: ' . $e->getMessage() . ' 
        </p>';

    trigger_error($sMsg);
}
?>