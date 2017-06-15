
<!-- 
    - Mittlerer div container navigation aus XML laden
    - If no user show no user nav bar
    - If user show user nav bar
    - if admin show admin nav bar
    
    - change active for each link
-->

<?php include 'config/Navigation.php';?>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">           
            
            <a class="navbar-brand" href="index.php">  Home </a>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul id="menu" class="nav navbar-nav">

                <?php
                    $who='user';
                    
                    $nav = new Navigation();
                    $nav->loadXML("$who");
                    

 
                ?>


                
                
            </ul>
<!--            <form class="navbar-form navbar-right" autocomplete="off">
                     fake fields are a workaround for chrome autofill getting the wrong fields 
                    <input style="display:none" type="text" name="fakeusernameremembered"/>
                    <input style="display:none" type="password" name="fakepasswordremembered"/>
                <div class="form-group">
                    <input class="form-control" placeholder="Username" type="text" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Password" type="password" autocomplete="off">
                </div>
                <button class="btn btn-success" type="submit">Sign in</button>
            </form>-->
        </div>

    </div>
</nav>