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
 * cls.parser.php
 *
 * Ésta clase se encarga de parsear códigos...
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

  // @BBCN: contiene el arreglo de códigos bbcode normales. ([b][/b])
  Static $BBCN = array();
  // @BBCC: contiene el arreglo de códigos bbcode complegos ([url=asd]titulo[/url])
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
    // tomamos el código bbc en una variable para usarlo más fácil
    $bbc = self::$BBCN;
    // recorremos el array
    foreach ($bbc as $key => $item)
     {
      // reemplazamos los códigos
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
    // tomamos el código bbc en una variable para usarlo más fácil
    $bbc = self::$BBCC;
    // recorremos el array
    foreach ($bbc as $key => $item)
     {
      // reemplazamos los códigos
      $texto = preg_replace('#'.str_replace(array('[',']'),array('\[','\]'),str_replace('?','(.+)',$key)).'#i', $item, $texto);
     }
    return $texto;
   }

   /**
   * parsea bbcode simple, y devuelve el texto parseado, el bbcode, se obtiene
   * de una base de datos, y debe pasarse como argumento un array compuesto
   * por el nombre de la tabla, el campo a buscar, y el campo a reemplazar.
   * previa conección hecha.
   *
   * EXAMPLE:
   * DB_BBCN_Parse ('lalalla', array(
   *                                'table'=>'censura',
   *                                'column_search'=>'bad',
   *                                'column_replace'=>'good'
   *                                ));
   *
   * @param string $texto texto a parsear.
   * @param array $bbcn datos de la db.
   *
   * @link WIKI NO DISPONIBLE POR EL MOMENTO
   *
   * @return string
   */
  Static Function DB_BBCN_Parser ($texto, $bbcn)
   {
    // obtenemos el listados de códigos a reemplazar
    $result = mysql_query('SELECT '.$bbcn['column_search'].', '.$bbcn['column_replace'].' FROM '.$bbcn['table']);
    // recorremos los resultados
    while ($array = mysql_fetch_array($result))
     {
     // reemplazamos los códigos
     $texto = str_replace($array[$bbcn['column_search']],$array[$bbcn['column_replace']],$texto);
     }
    // retornamos el texto parseado
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
   * mostrará hola en negrita.-
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
   * mostrará hola en negrita.-
   */