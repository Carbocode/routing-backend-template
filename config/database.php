<?php

/**
 * Classe che gestisce l'accesso al database
 */
class DatabaseService
{
  private static $instance = null; // campo statico condiviso che contiene l'istanza dell'oggetto
  private $db_host = DB_HOST; // dominio del database
  private $db_name = DB_NAME; // nome del database
  private $db_user = DB_USER; // nome utente del database
  private $db_password = DB_PASSWORD; // password del database
  public $connection; // campo che contiene la connessione al databse

  function __construct()
  {
    $this->connection = null;

    $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);
    if ($this->connection->connect_error) {
      die('Connection failed: ' . $this->connection->connect_error);
    }
    //Questo mi permette di utilizzare caratteri speciali
    mysqli_set_charset($this->connection, 'utf8');
  }

  /**
   * Controlla l'esistenza di un'istanza del database, altrimenti la crea
   */
  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new DatabaseService();
    }

    return self::$instance;
  }

  /**
   * Previene la clonazione dell'oggetto
   */
  private function __clone()
  {
    // Prevent cloning of the object
    throw new Exception("Non puoi clonare un oggetto che usa il pattern Singleton");
  }

  /**
   * Previene la deserializzazione di un oggetto
   */
  private function __wakeup()
  {
    // Prevent unserialization of the object
    throw new Exception("L'istanza Singleton deve essere unica");
  }

  /**
   * Esegue una query per il Database
   * @param string $query stringa SQL
   */
  public function exQuery($query)
  {
    $result = $this->connection->query($query);
    if ($result === false) {
      header('HTTP/1.1 500 Internal Server Error');
      die('Query: \n' . $query . '\n Errore: \n' . $this->connection->error);
    }


    return $result;
  }

  /**
   * Restituisce l'ultimo ID inserito
   */
  public function getLastID()
  {
    return $this->connection->insert_id;
  }
}