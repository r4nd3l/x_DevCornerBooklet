<?php
  /*
   * PDO Database Class
   * Conenct to Database
   * Create prepared statements
   * Bind values
   * Return rows and results
   */
   class Database{
     private $host = DB_HOST;
     private $user = DB_USER;
     private $pass = DB_PASS;
     private $dbname = DB_NAME;

     private $dbh;
     private $stmt;
     private $error;

     public function __construct(){
       // Set DSN
       $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
       $options = array(
         PDO::ATTR_PERSISTENT => true,
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
       );

       // Create PDO instance
       try{
         $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
       }catch(PDOException $e){
         $this->error = $e->getMessage();
         echo $this->error;
       }
     }

     // Prepare statement with query
     public function query($sql){
       $this->stmt = $this->dbh->prepare($sql);
     }

     // Bind values
     public function bind($param, $value, $type = null){
       if(is_null($type)){
         switch(true){
           case is_int($value):
              $type = PDO::PARAM_INT;
              breark;
           case is_bool($value):
              $type = PDO::PARAM_BOOL;
              breark;
           case is_null($value):
              $type = PDO::PARAM_NULL;
              breark;
           default:
              $type = PDO::PARAM_STR;
         }
       }

       $this->stmt->bindvalue($param, $value, $type);
     }

     // Execute the prepared statement
     public function execute(){
       return $this->stmt->execute();
     }

     // Get result set as array of objects
     public function resultSet(){
       $this->execute();
       return $this->stmt->fetchAll(PDO::FETCH_OBJ);
     }

     // Get single record as object
     public function single(){
       $this->execute();
       return $this->stmt->fetch(PDO::FETCH_OBJ);
     }

     // Get row count
     public function rowCount(){
       return $this->stmt->rowCount();
     }
   }



          // sql to create table - posts
          // $sql = "CREATE TABLE posts (
          // id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          // user_id int(11) NOT NULL,
          // title varchar(255) NOT NULL,
          // body text NOT NULL,
          // created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
          // )";

          // sql to create table - users
          // $sql = "CREATE TABLE users (
          // id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          // name varchar(255) NOT NULL,
          // email varchar(255) NOT NULL,
          // password varchar(255) NOT NULL,
          // created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
          // )";
