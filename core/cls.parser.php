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
 * cls.parser.php
 *
 * �sta clase se encarga de parsear c�digos...
 * funciones:
 *   Parsear BBCode_compuesto
 *   Parsear BBCode_normal
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

Class Parser
 {

  // variables locales de la clase //

  // @BBCN: contiene el arreglo de c�digos bbcode normales. ([b][/b])
  Static $BBCN = array();
  // @BBCC: contiene el arreglo de c�digos bbcode complegos ([url=asd]titulo[/url])
  Static $BBCC = array();

  /**
   * parsea bbcode simple, y devuelve el texto parseado, previamente seteado el
   * bbcode en la variable BBCN.
   *
   * @param string $texto texto a parsear.
   *
   * @link WIKI NO DISPONIBLE POR EL MOMENTO
   *
   * @return string
   */
  Static Function Parsear_bbcn ($texto)
   {
    // tomamos el c�digo bbc en una variable para usarlo m�s f�cil
    $bbc = self::$BBCN;
    // recorremos el array
    foreach ($bbc as $key => $item)
     {
      //reemplazamos los c�digos
      $texto = str_replace($key,$item,$texto);
     }
    // retornamos el texto parseado
    return $texto;
   }

   /**
   * parsea bbcode complejo, y devuelve el texto parseado, previamente seteado el
   * bbcode en la variable BBCC.
   *
   * @param string $texto texto a parsear.
   *
   * @link WIKI NO DISPONIBLE POR EL MOMENTO
   *
   * @return string
   */
  Static Function Parsear_bbcc ($texto)
   {
    // tomamos el c�digo bbc en una variable para usarlo m�s f�cil
    $bbc = self::$BBCC;
    // recorremos el array
    foreach ($bbc as $key => $item)
     {
      $texto = preg_replace('#'.str_replace(array('[',']'),array('\[','\]'),str_replace('?','(.+)',$key)).'#i', $item, $texto);
     }
    return $texto;
   }

 }

 /**
   *      EJEMPLO DE USO PARSER BBCN
   *
   * Parser::$BBCN = array(
   *                       '[b]'=>'<b>',
   *                       '[/b]'=>'</b>'
   *                      );
   *
   * $resultado = Parser::Parsear_bbcn('[b]hola[/b]');
   *
   * echo $resultado;
   *
   * mostrar� hola en negrita.-
   */


 /**
   *      EJEMPLO DE USO PARSER BBCC
   *
   * Parser::$BBCC = array(
   *                       '[url=?]?[/url]'=>'<a href="$1">$2</a>',
   *                      );
   *
   * $resultado = Parser::Parsear_bbcc('[b]hola[/b]');
   *
   * echo $resultado;
   *
   * mostrar� hola en negrita.-
   */