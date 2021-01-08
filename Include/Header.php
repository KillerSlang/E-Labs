<nav>
<?php
// Start the session
session_start();
if(empty($_COOKIE["taal"])){
    setcookie("taal", "nederlands");
}
if($_COOKIE["taal"] == "english"){
    include_once "Engels.php";
} else {
    include_once "Nederlands.php";
}

/*
if(!isset($_SESSION['SorD'])){
    header("Location: ../Login/login.php");
    exit;
} */


?>



<div>
    <img onclick='location.href="../Pages/Homepage.php"' id='navLogo'src='../Images/Logo.png'>
</div>
<div class = 'menu'>
    <ul>
        <li id=''><a href='voorbereidingen.php'><?=$Voorbereidingen?></a></li>
        <li id=''><a href='labjournalen.php'><?=$Labjournalen?></a></li>
        <li id=''><a href='Protocollen.php?jaar=0'><?=$Protocollen?></a></li>
    </ul>    
</div>
<div class = 'account'>
    <i id='accountLogo' class="fa fa-user-circle-o" aria-hidden="true"></i>
    
    <div class="accountDropdown">
        <div class="accountDropdownButton">        
            <p id='accountName'><?=$_SESSION["Name"]?> </p>
            <i id='accountDrop' class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
        <div class="accountDropdownContent">
            <a href='Instellingen.php'><?=$Instellingen?></a>
            <a href='Logout.php'><?=$Uitloggen?></a>
        </div>
    </div>
</div>
</nav>