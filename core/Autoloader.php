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
            // Si le namespace présent dans la configuration est trouvé en première position du namespace de la Classe :
            if (strpos($classNamespace, $namespaceConfig) === 0)
            {
                // Vérifier s'il existe plusieurs roads pour un même namespace. Si le chemin de configuration est unique, le placer dans un tableau.
                $roads = is_string($roads) ? [$roads] : $roads;

                // Parcourir les roads :
                foreach ($roads as $road)
                {
                    // Convertir le namespace par le road vers le fichier de la Classe visée :
                    $filePath = self::convertNamespaceToFilePath($namespaceConfig, $road, $classNamespace);

                    // Vérifier si le fichier contenant la Classe existe :
                    if (file_exists($filePath))
                    {
                        // Importer la Classe.
                        include_once $filePath;

                        // Sortir des deux boucles.
                        break 2;
                    }
                }
            }
        }
	}

    private static function convertNamespaceToFilePath(string $namespaceConfig, string $path, string $classNamespace): string
	{
        $className = str_replace($namespaceConfig, $path, $classNamespace);

        $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $className . '.php';

        $filePath = str_replace('/', DIRECTORY_SEPARATOR, $filePath);

        return $filePath;
    }
}