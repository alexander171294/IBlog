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
 * ext.bbcode.php
 *
 * archivo que configura el BBcode.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// establecemos los bbc a parsear
    Parser::$BBCN = array(
                          '[b]'=>'<b>',
                          '[/b]'=>'</b>',
                          '[strong]'=>'<b>',
                          '[/strong]'=>'</b>',
                          '[del]'=>'<del>',
                          '[/del]'=>'</del>'
                          );
// establecemos los bbc complejos a parsear
    Parser::$BBCC = array(
                          '[url=?]?[/url]'=>'<a href=\'$1\'>$2</a>',
                          '[img]?[/img]'=>'<img src=\'$1\'>'
                         );