<?php


include '/Model/Outil.php';
$pdo = PdoInit();

$conv_id = $_REQUEST["conv_id"];
$user_id = $_SESSION["user_id"];
$session = $_SESSION["token"];

if(VerifSession($pdo)) {
    include '/View/Header.php';
    ?>

<form>
    <input type="HIDDEN" name="conv_id" value =<?=$conv_id?>>
    <input type="HIDDEN" name="user_id" value =<?=$user_id?>>
</form>

<div id="chat"></div>


    <?php
    include '/View/Footer.php';
}




