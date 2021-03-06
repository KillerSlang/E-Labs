<nav>
<?php
// Start the session
session_start();
//include het taalbestand voor de vertalign afhankelijk van welke taal in de cookie staat
if(empty($_COOKIE["taal"])){
    setcookie("taal", "nederlands");
}
if($_COOKIE["taal"] == "english"){
    include_once "Engels.php";
} else {
    include_once "Nederlands.php";
}
//check of er is ingelogd
if(empty($_SESSION) || empty($_SESSION['SorD'])){
    header("Location: ../Pages/index.php");
    exit;
}
?>



<div>
    <img onclick='location.href="../Pages/Homepage.php"' id='navLogo' src='../Images/Logo.png' alt="logo">
</div>
<div class = 'menu'>
    <ul>
        <li><a href='voorbereidingen.php'><?=$Voorbereidingen?></a></li>
        <li><a href='labjournalen.php?jaar=0'><?=$Labjournalen?></a></li>
        <li><a href='Protocollen.php?jaar=0'><?=$Protocollen?></a></li>
    </ul>    
</div>
<div class = 'account'>
    <i id='accountLogo' class="fa fa-user-circle" aria-hidden="true"></i>
    
    <div class="accountDropdown">
        <div class="accountDropdownButton">
            <p id='accountName'><?= $_SESSION["Name"]?> </p>
            <i id='accountDrop' class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
        <div class="accountDropdownContent">
            <a href='Instellingen.php'><?=$Instellingen?></a>
            <a href='Logout.php'><?=$Uitloggen?></a>
        </div>
    </div>
</div>
</nav>