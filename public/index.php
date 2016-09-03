<?php
    
    echo '<pre>';
    
    function formatPath($path = null) {
        return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    }
    
    //print_r($_SERVER);
    
    //function main() {
      
        //$start = microtime(true);
        //for($i = 0; $i < 100000; ++$i) {
            
            defined('ROOT_PATH') || define('ROOT_PATH', dirname(__DIR__));
            defined('LIB_PATH')  || define('LIB_PATH', formatPath(ROOT_PATH . '/library'));
            defined('APP_PATH')  || define('APP_PATH', formatPath(ROOT_PATH . '/application'));
            
            require_once formatPath(LIB_PATH.'/MounirSoft/Application.php');
            $application = new \MounirSoft\Application();
            $application->run();
            
            //str_replace(dirname(dirname($_SERVER['SCRIPT_NAME'])), '', $_SERVER['REQUEST_URI']);
            //$_SERVER['QUERY_STRING'];
            //formatPath(dirname(__DIR__).'/library/MounirSoft/AutoLoader.php');
            //str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, dirname(__DIR__).'/library/MounirSoft/AutoLoader.php');
            //is_dir(__FILE__);
            //clearstatcache();
            //realpath(__FILE__);
            //stat(__FILE__);
        //}
        //$end = microtime(true);
        //var_dump($end - $start);
    //}
    //main();

    
    /*defined('ROOT_PATH') || define('ROOT_PATH', dirname(__DIR__));
    defined('LIB_PATH')  || define('LIB_PATH', formatPath(ROOT_PATH . '/library'));
    defined('APP_PATH')  || define('APP_PATH', formatPath(ROOT_PATH . '/application'));

    require_once formatPath(LIB_PATH.'/MounirSoft/AutoLoader.php');
    
    $loader = new MounirSoft\AutoLoader();
    $loader->register();
    
    
    
    
    new MounirSoft\Mounir();
    
    new MounirSoft\Mounir\Test\Benhajjaj();*/
    
    
    
    //http://www.codeproject.com/Articles/1080626/Code-Your-Own-PHP-MVC-Framework-in-Hour
    //http://php.net/manual/fr/yaf.tutorials.php
    //https://github.com/silexphp/Silex
    //http://www.elvishsu.com/2014/01/start-your-own-mvc-framework-with-php.html#.V8iFuPnJyUk
    //http://anantgarg.com/2009/03/13/write-your-own-php-mvc-framework-part-1/
    exit;
?>













<?php
    //http://php.net/manual/fr/book.yaf.php
    echo "<pre>";
    
    $request_uri = explode('/', $_SERVER['REQUEST_URI']);
    $script_name =  explode('/', $_SERVER['SCRIPT_NAME']);
    $size = sizeof($script_name);
    
    echo dirname($_SERVER['SCRIPT_NAME']);
    echo "<br />";
    echo dirname(__FILE__);
    echo "<br />";
    echo "SCRIPT_NAME - " . substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    echo "<br />";
    echo "TEST - " . substr(__FILE__, 0, strrpos(__FILE__, '/'));
    echo "<br />";
    echo substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '.') + 1);
    
    echo "<br />REQUEST_URI<br />";
    print_r($request_uri);
    echo "<br />SCRIPT_NAME<br />";
    print_r($script_name);
    
    
    
    echo "<hr />";
    
    print_r($_SERVER);
    exit;
    
    for ($i=0; $i < $size; $i++) {
        if ($request_uri[$i] == $script_name[$i])
        unset($request_uri[$i]);
    }
    
    $request_uri = array_values($request_uri);
    
    //print_r($request_uri);
    
    if (!empty($request_uri)) {
        echo "this->_controller = " . $request_uri[0] ."<br />";
        
        unset($request_uri[0]);
        $request_uri = array_values($request_uri);
    }
    
    if (!empty($request_uri)) {
        echo "this->_parms = ";
        print_r($request_uri);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //preg_match_all("/^(".$_SERVER['DOCUMENT_ROOT'].")(*.)\.php$/", $_SERVER['SCRIPT_FILENAME'], $out, PREG_PATTERN_ORDER);
    
    //print_r($out);
    
    
    echo "<hr />";
    
    print_r($_SERVER);

    echo "<hr />";
    echo $_SERVER['REQUEST_URI'];
    echo '<br />';
    echo $_SERVER['SCRIPT_NAME'];
    echo '<br />';
    $snLen = strlen($_SERVER['SCRIPT_NAME']);
    echo substr($_SERVER['REQUEST_URI'], 0, $snLen+1);
    
    exit;
    
    
    
    
    
    /*defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));
    defined('APPLICATION_LIB') || define('APPLICATION_LIB', realpath(dirname(__FILE__) . '/library'));
    
    defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
    
    set_include_path(implode(PATH_SEPARATOR, array(
        APPLICATION_PATH,
        APPLICATION_LIB,
        get_include_path(),
    )));
    
    require_once "Mounir/Application.php";
    
    $application = new Mounir_Application();
    
    $application->run();*/

?>