<?php

class SetNav
{
    public static function set_navToken (string $pageName, string $segmentULR)
    {
        if ($_SERVER["REDIRECT_URL"] == $segmentULR)
        {
            $answer = "<li><a href=\"$segmentULR\" class=\"active\">$pageName</a></li>";
        }
        else
        {
            $answer = "<li><a href=\"$segmentULR\">$pageName</a></li>";
        }
        return $answer;
    }
}

?>