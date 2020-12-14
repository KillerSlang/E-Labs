<!DOCTYPE HTML>
<html>
    <head>
        <title>Homepage</title>

        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"> -->
        <link href="Homepage.css" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../../Css/Main.css">
        <link rel="stylesheet" href="../../Css/Responsive.css">
    </head>
    <body>
        <header>
            <?php 
            /* Header */
            include_once '../../Include/Header.php';
            ?>
        </header>

        <main>
            <h1>Kies uw bestemming</h1>
            <hr>

            <div id ="container">
                <div id="Voorbereidingen">
                    
                        <p>Voorbereidingen</p>
                        <hr>
                    <a href="">
                        <img id="Voorbereidingenimage" src="images/Voorbereidingenicon.png" alt="Voorbereiding icon">
                    </a>
                </div>
                <div id="Labjournalen">
                    
                        <p>Labjournalen</p>
                        <hr>
                    <a href="">    
                        <img id="Labjournalenimage" src="images/Labjournalenicon.png" alt="Labjournalen icon">
                    </a>
                </div> 
                <div id="Protocollen">
                    
                        <p>Protocollen</p>
                        <hr>
                    <a href="">
                        <img id="Protocollenimage" src="images/Protocollenicon.png" alt="Protocollen icon">
                    </a>
                </div>


                <div id="Voorbereidingenaanmaken">
                   
                        <p>Voorbereidingen</p>
                        <hr>
                    <a href="">        
                        <img id="Voorbereidingenaanmakenimage" src="images/Voorbereidingen_small.png" alt="Voorbereiding small icon">
                    </a>
                </div>
                <div id="Labjournalenaanmaken">
                    
                        <p>Labjournalen</p>
                        <hr>
                    <a href="">
                        <img id="Labjournalenaanmakenimage" src="images/Labjournalen_small.png" alt="Labjournalen small icon">
                    </a>
                </div> 
                <div id="Protocollenaanmaken">
                    
                        <p>Protocollen</p>
                        <hr>
                    <a href="">
                        <img id="Protocollenaanmakenimage" src="images/Protocollen_small.png" alt="Protocollen small icon">
                    </a>
                </div>


            </div>
            </main>

            <footer>
                <?php 
                /* Footer */
                include_once '../../Include/Footer.php';
                ?> 
            </footer>
    </body>

</html>