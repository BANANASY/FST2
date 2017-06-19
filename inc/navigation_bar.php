
<!-- 
    - Mittlerer div container navigation aus XML laden
    - If no user show no user nav bar
    - If user show user nav bar
    - if admin show admin nav bar
    
    - change active for each link
-->

<?php include 'config/Navigation.php'; ?>

<div class="nav_container container">
    <div class="nav_inner row">
        <div class="col-sm-3">
            <div class="sidebar-nav">
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <span class="visible-xs navbar-brand">Sidebar menu</span>
                    </div>
                    <div class="nav_inner navbar-collapse collapse sidebar-navbar-collapse">
                        <ul class="nav_list nav navbar-nav">
                            <?php
                            $who = 'user';

                            $nav = new Navigation();
                            $nav->loadXML("$who");
                            ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="nav_inner col-sm-9">
            <p class="dibwars">DIBWARS</p>
        </div>
    </div>
</div>



