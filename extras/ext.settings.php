<?php

/**
 * I-Blog
 *
 * PHP Version 5.3
 *
 * I-Blog es un proyecto Open Source desarrollado para ser rápido, y sencillo.
 *
 * El repositorio oficial del proyecto lo puedes encontrar un poco más abajo,
 * iblog fué diseñado para blogs alojados en servidores pequeños
 * que no cuenten con tantos recursos para tener un blog pesado como son otros
 * sistemas de blog. .
 *
 * @author    Alexander Eberle Renzulli <alexander171294@live.com>
 * @copyright 2012 AlEb Corporation / (http://www.alebcorp.com.ar)
 * @license   http://www.gnu.org/copyleft/gpl.html
 * @link      https://github.com/alexander171294/IBlog
 */

/**
 * ext.settings.php
 *
 * archivo que guarda la configuración del scrtip.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// versión
define( 'IBLOGVERSION', '1.0' );

//retornamos la configuración
return array(

            // datos de la db //

            'db_host' => 'localhost', // servidor de la base de datos
            # 'db_host' => 'localhost',

            'db_user' => 'root', // usuario de la base de datos
            # 'db_user' => 'root',

            'db_pass' => '', // contraseña de la base de datos
            # 'db_pass' => 'pasword',

            'db_name' => 'ibloginstall', // nombre de la base de datos
            # 'db_name' => 'iblog',

            // configuración general //

            'site_path' => '/', // carpeta donde se encuentra tu sitio a partir del raiz
            # 'site_path' => '/',

            'tema' => 'default', // diseño del sitio
            # 'tema' => 'default',

            'cache' => 'cache' // carpeta donde se guardará el caché
            # 'cache' => 'cache'

            );