<?php

$dir = dirname(__DIR__ ) . '/src/Alipay/request';
$newDir = dirname(__DIR__ ) . '/src/Alipay/Requests';

$file_arr = scandir($dir);
$new_arr = [];
foreach( $file_arr as $item){

    if( $item=='..' )
        continue;
    if( $item=='.' )
        continue;

    echo $item . "\n";

    $filePath = $dir . DIRECTORY_SEPARATOR . $item;
    $newFilePath = $newDir . DIRECTORY_SEPARATOR . $item;

    $content = @file_get_contents($filePath);
    $newContent = str_replace('<?php', "<?php\n\nnamespace Mayijuntuan\Alipay\Requests;\n\n", $content );
    file_put_contents( $newFilePath, $newContent );

}//end foreach

echo "ok\n";

