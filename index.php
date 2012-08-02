<?php

/** @I-blog 1.0
 *  desarrollado por Alexander1712
 *  archivo principal index.php
 */

// cargamos funciones b�sicas //
require('extras/ext.functions.php');

// iniciamos autoload
InitAutoLoad();

// iniciamos la clase core y le mandamos la configuraci�n
$Core = new Core ( include ( 'extras/ext.settings.php' ) );

// incluimos la configuraci�n general y la mandamos al core //

echo $Core->Settings['db'];