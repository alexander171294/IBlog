<?php

class LittleDB
 {
  // Devuelve el objeto db
  public static $instance;
  // contiene los datos de coneccion
  public $conn = null;
  // IP o Host de la Base de datos
  protected $host = null;
  // Usuario del Servidor
  protected $user = null;
  // Contraseña del Servidor
  protected $pass = '';
  // Nombre de la Base de datos
  protected $db = null;
  // Funcion de registro
  protected $logger = null;
  // Prefijo de la base de datos
  public $prefix = '';
  // Cantidad de consultas realizadas
  public $count = 0;



  /**
   * Constructor de la clase
   * @param string $host Url o DNS del Servidor MySQL
   * @param string $user Usuario del servidor
   * @param string &pass Contraseña del servidor
   * @param string $db Nombre de la base de datos
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function __construct($host, $user, $pass, $db, $logger = null)
   {
    $this->host = $host;
    $this->user = $user;
    $this->pass = $pass;
    $this->db = $db;
    $this->logger = $logger;
   } // public function __construct();



  /**
   * Obtenemos una instancia de la clase, la primera vez pasamos los parametros para conectar.
   * @return object $instance Instancia de la base de datos.
   * @author Ignacio Daniel Rostagno <ignaciorostagno@vijona.com.ar>
   */
  public static function getInstance($host = NULL, $user = NULL, $pass = NULL, $db = NULL)
   {
    if(!isset(self::$instance))
     {
      self::$instance = new LittleDB($host, $user, $pass, $db);
     }
    return self::$instance;
   } // public static function getInstance();

  /**
   * No se permite clonar el objeto.
   * @author Ignacio Daniel Rostagno <ignaciorostagno@vijona.com.ar>
   */
  public function __clone() { }

  /**
   * No se permite serealizar el objeto.
   * @author Ignacio Daniel Rostagno <ignaciorostagno@vijona.com.ar>
   */
  public function __wakeup() { }



  /**
   * Conectar al servidor y seleccionar la DB
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function connect()
   {
    if($this->is_connected() == false)
     {
      $this->conn = mysql_connect($this->host, $this->user, $this->pass) or die('Error: No se ha podido conectar al servidor.');
      mysql_select_db($this->db, $this->conn) or die('Error: Base de datos inexistente.');
     }
   } // public function connect();



  /**
   * Checkear si está conectado al servidor
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  private function is_connected()
   {
    if(!is_resource($this->conn) || $this->conn == null || !$this->conn) { return false; }
    else { return true; }
   }



  /**
   * Ejecutar una consulta en la base de datos
   * @param string cons Consulta SQL
   * @param miexed values Arreglo con los valores a reemplazar por Parse_vars
   * @param boolean ret = retornar Array de datos o no.
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function query($cons, $values = null, $ret = false)
   {
    if($this->is_connected() == true)
     {
      if($values != null)
       {
        if(!is_array($values)) { $values = array($values); }
        $query = $this->parse_vars($cons, $values);
       }
      else { $query = $cons; }
      if($ret == true)
       {
        $res = $this->_query($query);
        if($res == false || empty($res)) { $return = false; }
        else
         {
          if(is_resource($res))
           {
            $return = mysql_fetch_array($res, MYSQL_ASSOC);
            $this->free($res);
           }
          else { $return = true; }
         }
       }
      else
       {
        $return = new Query($query, $this->conn);
        ++$this->count;
       }
      return $return;
     }
    else { return false; }
   } // public function query();



  /**
   * Liberar memoria asociada a la conección
   * @author Cody Roodaka <roodakazo@hotmail.com>
   * @param resource query Cosulta SQL
   * @return boolean
   */
  private function free($query)
   {
    return mysql_free_result($query);
   } // private function free();




  private function _query($query)
   {
    ++$this->count;
    if(is_array($this->logger) == true)
     {
      call_user_func_array($this->logger, array($query));
     }
    return mysql_query($query, $this->conn);
   } // private function _query()




  /**
   * Insertar Datos en una tabla
   * @param table Nombre de la tabla
   * @param array Arreglo con los campos y valores; 'campo' => 'valor'
   * @param return Retornar o no el ID del insert.
   * @author Cody Roodaka <roodakazo@hotmail.com>
   * @return int|array
   */
  public function insert($table, $array, $return = false)
   {
    if(is_array($array) && $table != null && $this->is_connected() == true)
     {
      $fields = implode(', ', array_keys($array));
      $values = $this->parse_input($array);
      $query = $this->_query('INSERT INTO '.$this->db.'.'.$this->prefix.$table.' ( '.$fields.' ) VALUES ( '.$values.' )');

      // Seteamos el resultado,
      if($return == true) { return mysql_insert_id($this->conn); }
      else
       {
        if(!$query || $query == false) { return false; }
        else { return true; }
       }
     }
    else { return false; }
   } // public function insert();




  /**
   * Borrar una fila
   * @param table nombre de la tabla
   * @param where  Condicionantes
   * @param return Retornar nro de filas afectadas
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function delete($table, $cond = array(), $return = false)
   {
    if(is_array($cond) == true && $this->is_connected() == true)
     {
      $where = array();
      foreach($cond as $key => $value)
       {
        $where[] = $key.' = '.$this->parse_input($value);
       }
      $conditions = implode(' && ', $where);
      $query = $this->_query('DELETE FROM '.$this->db.'.'.$this->prefix.$table.' WHERE '.$conditions);
      if($return == true) { return mysql_affected_rows($this->conn); }
      else
       {
        if(!$query || $query == false) { return false; }
        else { return true; }
       }
     } else { return false; }
   } // public function delete();



  /**
   * Actualizar una fila
   * @param table nombre de la tabla
   * @param where  Condicionantes
   * @param return Retornar nro de filas afectadas
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function update($table, $array = array(), $cond = array(), $return = false)
   {
    if(is_array($cond) == true && $table != null)
     {
      $fiel = array();
      foreach($array as $field => $value)
       {
        $fiel[] = $field.' = '.$this->parse_input($value);
       }
      $fields = implode(', ', $fiel);
      $wher = array();
      foreach($cond as $field => $value) { $wher[] = $field.' = '.$this->parse_input($value); }
      $where = implode(' && ', $wher);
      $query = $this->_query('UPDATE '.$this->db.'.'.$this->prefix.$table.' SET '.$fields.' WHERE '.$where);
      if($return == true) { return mysql_affected_rows($this->conn); }
      else
       {
        if(!$query || $query == false) { return false; }
        else { return true; }
       }
     } else { return false; }
   } // public function update();


  /**
   * Funcion encargada de realizar el parseo de la consulta SQL agregando las
   * variables de forma segura mediante la validacion de los datos.
   * En la consulta se reemplazan los ? por la variable en $params
   * manteniendo el orden correspondiente.
   * @param string $q Consulta SQL
   * @param array $params Arreglo con los parametros a insertar.
   * @author Ignacio Daniel Rostagno <ignaciorostagno@vijona.com.ar>
   */
  protected function parse_vars($q, $params)
   {
    //Validamos que los parametros sea un arreglo.
    if(!is_array($params))
     {
      throw new Exception("El parametro debe ser un arreglo válido");
      return $q;
     }
    //Validamos que tengamos igual numero de parametros que de los necesarios.
    if(count($params) != preg_match_all("/\?/", $q, $aux))
     {
      throw new Exception("No coinciden la cantidad de parametros necesarios con los provistos");
      return $q;
     }
    //Reemplazamos las etiquetas.
    foreach($params as $param)
     {
      $q = preg_replace("/\?/", $this->parse_input($param), $q, 1);
     }
    return $q;
   } // protected function parse_vars();


  /**
   * Función que se encarga de determinar el tipo de datos para ver si debe
   * aplicar la prevención de inyecciones SQL, si debe usar comillas o si es
   * un literal ( funcion SQL ).
   * @param mixed $objet Objeto a analizar.
   * @return string Cadena segura.
   * @author Ignacio Daniel Rostagno <ignaciorostagno@vijona.com.ar>
  */
  protected function parse_input($object)
   {
    if(is_object($object))
     { //Es un objeto?
      return (string)$object;
     }
    elseif(is_numeric($object))
     { //Es un número?
      if(is_int($object)) { return $object; }
      if (((int) $object) == $object) { return (int) $object; }
      return (float)$object;
     }
    elseif($object === NULL)
     { //Es NULL?
      return 'NULL';
     }
    elseif(is_array($object))
     { //Es un arreglo?
      $object = array_map(array($this, 'parse_input'), $object);
      return implode(', ', $object);
     }
    else
     { //Suponemos una cadena
      return "\"".mysql_real_escape_string($object)."\"";
     }
   } // protected function parse_input();



  /**
   * Destruir & Desconectar la clase
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function __destruct()
   {
    if($this->conn != null) { return mysql_close($this->conn); }
    else { return false; }
   }
 } // class LittleDB();

// =============================================================================

class Query
 {
  protected $query = false;
  protected $result = array();
  /**
   * Inicializar los datos
   * @param $query Consulta SQL
   * @param $conn Recurso de conección SQL
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function __construct($query, $conn)
   {
    $cons = mysql_query($query, $conn);
    if($cons == false || !$cons) { return false; }
    else { $this->query = $cons; }
   } // function __construct();
  /**
   * Devolvemos el array con los datos de la consulta
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function fetchrow($object = false)
   {
    $query = mysql_fetch_array($this->query, MYSQL_ASSOC);
    if($object == false) { return $query; }
    else { return (object) $query; }
   } // public function fetchrow();
  /**
   * Devolvemos la cantidad de filas afectadas por la consulta
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function numrows()
  {
   return mysql_num_rows($this->query);
  } // public function numrows();



  public function get($field, $default)
   {
    $this->result = mysql_fetch_array($this->query, MYSQL_ASSOC);
    if(isset($this->result[$field])) { return $this->result[$field]; }
    else { return $default; }
   } // public function get();
 } // class Query