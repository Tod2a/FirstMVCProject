<?php

function set_nav (string $pageName, string $segmentULR)
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

?>