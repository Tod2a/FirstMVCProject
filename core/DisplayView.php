<?php
namespace Core;

class DisplayView
{
    //Show the view with the header and the footer
    public static function show_view (array $pageInfos, string $action, ?array $args = null)
    {
        //set the roads to the directory of view and part
        $roadOfVues = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
        $roadOfVuesPart = $roadOfVues . DIRECTORY_SEPARATOR . 'part' . DIRECTORY_SEPARATOR;

        //set the page title
        $title = $pageInfos['title'];

        require_once $roadOfVuesPart . 'header.php';

        require_once $roadOfVues . $pageInfos['view'] . DIRECTORY_SEPARATOR . $action . '.php';

        require_once $roadOfVuesPart . 'footer.php';

    }

    //Show the 404 error page
    public static function show_error404()
    {
        // Inform the browser that it is a 404 error.
        header("HTTP/1.0 404 Not Found");
        // Load the view for the 404 error page.
        show_view(['view' => 'view_error404', 'title' => "Error 404"], 'index');
        // Exit the script.
        exit();
    }
}

?>