<?php
class Autoloader
{
    private static $config;

    public static function init(): void
    {
        self::load_config();
        self::register();
    }

    private static function load_config(): void
	{
        // Load the autoloader configuration from the 'config.json' file.
		$config = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.json';
        self::$config = json_decode(file_get_contents($config), true)['autoloader'];
	}

    private static function register(): void
{
    // The function "spl_autoload_register()" is used to register custom autoload functions.
    // This function is executed when a Class is called for the first time.
    // It takes an array as parameter with the Class and the method to be called to handle the loading of the Class.
    // (The magic constant "__CLASS__" returns the name of the class it is used in.)
    // In summary, when a Class is called for the first time, the function "spl_autoload_register()" is automatically executed,
    // then, the "load" method of the current Class (Autoloader) is triggered and the contents of the "use" statement are passed to it as a parameter.
    spl_autoload_register([__CLASS__, 'load']);
}

	private static function load(string $classNamespace): void
	{
        foreach (self::$config as $namespaceConfig => $roads)
        {
            // If the namespace in the configuration is found at the beginning of the Class's namespace:
            if (strpos($classNamespace, $namespaceConfig) === 0)
            {
                // Check if there are multiple roads for the same namespace. If the configuration path is unique, place it in an array.
                $roads = is_string($roads) ? [$roads] : $roads;

                // Iterate through the roads:
                foreach ($roads as $road)
                {
                    // Convert the namespace to the file path for the targeted Class:
                    $filePath = self::convertNamespaceToFilePath($namespaceConfig, $road, $classNamespace);

                    // Check if the file containing the Class exists:
                    if (file_exists($filePath))
                    {
                        // Import the Class.
                        include_once $filePath;

                        // Exit both loops.
                        break 2;
                    }
                }
            }
        }
    }

    private static function convertNamespaceToFilePath(string $namespaceConfig, string $path, string $classNamespace): string
    {
        // Replace the namespace in the Class with the specified path.
        $className = str_replace($namespaceConfig, $path, $classNamespace);

        // Construct the file path for the Class.
        $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $className . '.php';

        // Replace forward slashes with the appropriate directory separator.
        $filePath = str_replace('/', DIRECTORY_SEPARATOR, $filePath);

        return $filePath;
    }
}