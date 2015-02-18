<html>
<head>
    <?php

    require_once __DIR__ . '/vendor/autoload.php';

    $rootDir = __DIR__;

    $baseUrl = './';
    //$baseUrl = '//localhost/';
    //$baseUrl = '/';
    //$baseUrl = '//project.com/';
    //$baseUrl = '//localhost/project/';

    $cacheDir = $rootDir . DIRECTORY_SEPARATOR . 'cache';

    $javascriptAutoloader = new \MF\JavascriptAutoloader\JavascriptAutoloader($rootDir, $baseUrl);
    $javascriptAutoloader
        ->compileToOneFile($cacheDir)
        ->minifyOutput()
        ->denyCache()
        ->addDirectory('scripts')
        ->autoload();

    ?>
</head>
<body>
</body>
</html>
