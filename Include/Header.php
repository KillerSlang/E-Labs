<nav>
<?php
// Start the session
session_start();

/*
if(!isset($_SESSION['SorD'])){
    header("Location: ../Login/login.php");
    exit;
} */

?>
<div>
    <img id='navLogo'src='../Images/Logo.png'>
</div>
<div class = 'menu'>
    <ul>
        <li id=''><a href='Voorbereidingen.php'>Voorbereidingen</a></li>
        <li id=''><a href='Labjournalen.php'>Labjournalen</a></li>
        <li id=''><a href='Protocollen.php'>Protocollen</a></li>
    </ul>    
</div>
<div class = 'account'>
    <i id='accountLogo' class="fa fa-user-circle-o" aria-hidden="true"></i>
    
    <div class="accountDropdown">
        <div class="accountDropdownButton">        
            <p id='accountName'><?= $_SESSION["Name"]?> </p>
            <i id='accountDrop' class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
        <div class="accountDropdownContent">
            <a href='Instellingen.php'>Instellingen</a>
            <a href='Logout.php'>Logout</a>
        </div>
    </div>
    
    <!--
    <div class='accountDropdown'>
        <p id='accountName'><?= $_SESSION["Name"]?> </p>
        <i id='accountDrop' class="fa fa-caret-down" aria-hidden="true"></i>
        <div class='accountDropdownContent'>
            <ul>
                <li id=''><a href='Instellingen.php'>Instellingen</a></li>
                <li id=''><a href='Logout.php'>Logout</a></li>
            </ul>   
        </div>
    </div>-->
</div>
</nav>