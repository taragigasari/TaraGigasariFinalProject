<?php
class movie
{
   
   private $conn;
   private $table = 'movieinformation';

   
   public $searchQuery;
   public $id;
   public $name;
   public $description;
   public $year;
   public $poster;

  
   public function __construct($db)
   {
       $this->conn = $db;
   }

   
   public function read()
   {
       
       $query = 'SELECT * from ' . $this->table . ";";
       $stmt = $this->conn->prepare($query);

       
       $stmt->execute();

       return $stmt;
   }

  
   public function readById()
   {
       
       $query = 'SELECT * from ' . $this->table . ' where id=?';
       $stmt = $this->conn->prepare($query);

      
       $stmt->bindParam(1, $this->id);

       
       $stmt->execute();

       $row = $stmt->fetch(PDO::FETCH_ASSOC);

       
       $this->id = $row['id'];
       $this->name = $row['name'];
       $this->description = $row['description'];
       $this->year = $row['year'];
       $this->poster = $row['poster'];

       return $stmt;
   }

  
   public function create()
   {
      
       $query = 'insert into ' . $this->table . ' (name,description,year,poster) values(:name,:description,:year,:poster);';

       
       $stmt = $this->conn->prepare($query);

       
       $this->name = htmlspecialchars(strip_tags($this->name));
       $this->description = htmlspecialchars(strip_tags($this->description));
       $this->year = htmlspecialchars(strip_tags($this->year));
       $this->poster = htmlspecialchars(strip_tags($this->poster));

       
       $stmt->bindParam(':name', $this->name);
       $stmt->bindParam(':description', $this->description);
       $stmt->bindParam(':year', $this->year);
       $stmt->bindParam(':poster', $this->poster);

       
       if ($stmt->execute()) {
           return true;
       } else {
           echo "error";
           return false;
       }
   }

   
   public function search()
   {
       
       $query = 'select * from ' . $this->table . ' where name=:name or year=:year';

       
       $stmt = $this->conn->prepare($query);

       
       if (isset($this->searchQuery)) {
           $stmt->bindParam(':name', $this->searchQuery);
           $stmt->bindParam(':year', $this->searchQuery);
       } else {
           $query = 'select * from ' . $this->table;
       }

       
       $stmt->execute();

       return $stmt;
   }

  
   public function delete()
   {
      
       $query = 'delete from ' . $this->table . ' where id=:id';

       
       $stmt = $this->conn->prepare($query);

       
       $stmt->bindParam(':id', $this->id);

       
       $stmt->execute();

       return $stmt;
   }

   
   public function edit()
   {
      
       $query = 'update ' . $this->table . ' set name=:name, description=:description, year=:year, poster=:poster where id=:id;';

       
       $stmt = $this->conn->prepare($query);

      
       $this->id = htmlspecialchars(strip_tags($this->id));
       $this->name = htmlspecialchars(strip_tags($this->name));
       $this->description = htmlspecialchars(strip_tags($this->description));
       $this->year = htmlspecialchars(strip_tags($this->year));
       $this->poster = htmlspecialchars(strip_tags($this->poster));

      
       $stmt->bindParam(':id', $this->id);
       $stmt->bindParam(':name', $this->name);
       $stmt->bindParam(':description', $this->description);
       $stmt->bindParam(':year', $this->year);
       $stmt->bindParam(':poster', $this->poster);

       
       if ($stmt->execute()) {
           return true;
       } else {
           echo "error";
           return false;
       }
   }
}
