<nav>
<?php
// Start the session
session_start();
$_SESSION["Name"] = 'Ömer avici';
$_SESSION["StudentID"] = '1';
$_SESSION["SorD"] = "Student";
?>
<div>
    <img onclick='location.href="../index.html"' id='navLogo'src='../Images/Logo.png'>
</div>
<div class = 'menu'>
    <ul>
        <li id=''><a href='Voorbereidingen.php'>Voorbereidingen</a></li>
        <li id=''><a href='Labjournalen.php'>Labjournalen</a></li>
        <li id=''><a href='Protocollen.php?jaar=0'>Protocollen</a></li>
    </ul>    
</div>
<div class = 'account'>
    <i id='accountLogo' class="fas fa-user-circle" aria-hidden="true"></i>
    
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
</div>
</nav>