<?php
namespace App\Views\Part;

use Core\ManageConnection;

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

    public static function set_navi ():string
    {
        //check if a account is connected
        if (ManageConnection::is_connected())
        {
            //set the nav with the profile page
            return SetNav::set_navToken("Accueil", "/") . SetNav::set_navToken("Contact", BASE_URL . '/contact') . SetNav::set_navToken("Profil", "/connexion/profil") . SetNav::set_navToken("Galerie", "/galerie");
        }
        else
        {
            //set the nav with the connection page
            return SetNav::set_navToken("Accueil", "/") . SetNav::set_navToken("Contact", BASE_URL . '/contact') . SetNav::set_navToken("Connexion", "/connexion") . SetNav::set_navToken("Galerie", "/galerie");
        }
    }
}

?>