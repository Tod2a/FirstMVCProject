<?php
namespace Core;

class Router
{
    private static $routes = [];

    // Function to configure a route:
    public static function config_route(string $method, string $path, string $controller, string $action): void
    {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
        ];
    }

    private static function prepare_pathForComparisonUrl(string $path, array $patterns): string
    {
        // Iterate through patterns:
        foreach ($patterns as $marker => $pattern)
        {
            // Replace {marker} with the corresponding regular expression.
            $path = str_replace('{' . $marker . '}', '(' . $pattern . ')', $path);
        }
        return $path;
    }

    // Function to test routes:
    public static function start_router(?array $patterns = []): void
    {
        // Retrieve different segments of the URL from "$_GET['url']".
        // This is made possible by this line in the ".htaccess" file: RewriteRule ^(.*)$ public/index.php?url=$1 [QSA,L]
        // Prevent code injections using the filter_input function:
            // "INPUT_GET" indicates that the function should retrieve the variable from the "$_GET" superglobal.
            // "url" is the name assigned in the ".htaccess" file.
            // "FILTER_SANITIZE_URL" is the filter used to clean the variable by removing all illegal characters from a URL.
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL) ?? "";
    
        // Remove slashes at the beginning and end of the URL.
        $url = trim($url, '/');
    
        // Get the method of the server request ("GET" or "POST").
        $method = $_SERVER['REQUEST_METHOD'];
    
        // If the method is "POST," check if a specific method has been added in the hidden form fields ("PUT" or "DELETE").
        $method = $method === 'POST' && isset($_POST['_method']) ? strtoupper($_POST['_method']) : $method;
    
        // Process each route:
        foreach (self::$routes as $route)
        {
            // Remove slashes at the beginning and end of the URL.
            $path = trim($route['path'], '/');
        
            // Prepare the path to check if it matches the URL, even if it contains placeholders (e.g., {id}).
            $path = Router::prepare_pathForComparisonUrl($path, $patterns);
        
            // Check if the current route matches the URL and if the methods are identical.
            if ($route['method'] === $method && preg_match("#^$path$#", $url, $matches))
            {
                // Prepare URL parameters to cleanly pass them to the controller:
                array_shift($matches);
            
                Router::load_controller($route['controller'], $route['action'], $matches);
                return;
            }
        }
    
        // Load the controller for the 404 error page.
        Router::load_controller('controller_error404', 'index');
    }

    private static function load_controller(string $controller, string $action, ?array $urlParams = []): void
    {
        // Load the controller.
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $controller . '.php';

        // Call the static method from the two strings and pass any potential parameters retrieved from the URL (id, slug, etc.).
        call_user_func(["\\app\\controllers\\$controller", $action], ...$urlParams);
    }
}
?>
