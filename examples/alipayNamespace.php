<?php

$dir = dirname(__DIR__ ) . '/src/Alipay/aopRequest';
$newDir = dirname(__DIR__ ) . '/src/Alipay/Request';

$file_arr = scandir($dir);
$new_arr = [];
foreach( $file_arr as $item){

    if( $item=='..' )
        continue;
    if( $item=='.' )
        continue;

    $filePath = $dir . DIRECTORY_SEPARATOR . $item;
    $newFilePath = $newDir . DIRECTORY_SEPARATOR . $item;

    $content = @file_get_contents($filePath);
    $newContent = str_replace('<?php', "<?php\n\nnamespace Mayijuntuan\Alipay\Request;\n\n", $content );
    file_put_contents( $newFilePath, $newContent );

}//end foreach

echo "ok\n";

