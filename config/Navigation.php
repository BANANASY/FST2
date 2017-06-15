<?php
class Navigation{
    
    
    
    function loadXML($who){
        $xml = simplexml_load_file("config/navigation.xml");
   
        if($who=="visitor"){

            foreach($xml->visitor->menu as $element){
                echo '<li><a href="'.$element->link.'">'.$element->title.'</a></li>';
            }
        }
        elseif($who=="user"){
            foreach($xml->user->menu as $element){
                echo '<li><a href="'.$element->link.'">'.$element->title.'</a></li>';
            }
        }
        elseif($who=="admin"){
            foreach($xml->admin->menu as $element){
                echo '<li><a href="'.$element->link.'">'.$element->title.'</a></li>';
            }
        }
    }
    
    
    
    
}
