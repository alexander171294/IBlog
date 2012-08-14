<?php

/**
 * I-Blog
 *
 * PHP Version 5.3
 *
 * I-Blog es un proyecto Open Source desarrollado para ser r�pido, y sencillo.
 *
 * El repositorio oficial del proyecto lo puedes encontrar un poco m�s abajo,
 * iblog fu� dise�ado para blogs alojados en servidores peque�os
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
 * archivo que guarda la configuraci�n del scrtip.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// versi�n
define( 'IBLOGVERSION', '1.0' );

//retornamos la configuraci�n
return array(

            // datos de la db //

            'db_host' => 'localhost', // servidor de la base de datos
            # 'db_host' => 'localhost',

            'db_user' => 'root', // usuario de la base de datos
            # 'db_user' => 'root',

            'db_pass' => '', // contrase�a de la base de datos
            # 'db_pass' => 'pasword',

            'db_name' => 'ibloginstall', // nombre de la base de datos
            # 'db_name' => 'iblog',

            // configuraci�n general //

            'site_path' => '/', // carpeta donde se encuentra tu sitio a partir del raiz
            # 'site_path' => '/',

            'tema' => 'default', // dise�o del sitio
            # 'tema' => 'default',

            'cache' => 'cache' // carpeta donde se guardar� el cach�
            # 'cache' => 'cache'

            );