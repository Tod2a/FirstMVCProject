<?php
namespace App\Views\Part;

class SetNav
{
    //format a nav token with the url and the string
    public static function set_navToken (string $pageName, string $segmentULR)
    {
        //check if we are actually on the page of the token and add the active class if necessary
        if ($_SERVER["REDIRECT_URL"] == $segmentULR)
        {
            $answer = "<li><a href=\"$segmentULR\" class=\"active\">$pageName</a></li>";
        }
        else
        {
            $answer = "<li><a href=\"$segmentULR\">$pageName</a></li>";
        }
        
        //return the token 'li'
        return $answer;
    }
}

?>