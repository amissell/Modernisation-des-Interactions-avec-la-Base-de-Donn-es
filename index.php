<?php

class Database {
    private $pdo;
    private $host = 'localhost';
    private $dbname = 'persones'; 
    private $username = 'root';
    private $password = '';

    public function __construct() {
        $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data)); 
        return $this->pdo->lastInsertId();  
    }

    public function update($table, $data, $id) {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
        }
        $setSql = implode(", ", $set);

        $sql = "UPDATE $table SET $setSql WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array_merge(array_values($data), [$id]));  
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);  
    }

    public function select($table, $columns = "*", $where = "") {
        $sql = "SELECT $columns FROM $table $where";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$db = new Database();

// $insertData = [
//     'name' => 'Kylian Mbappé', 
//     'position' => 'Forward', 
//     'nationality' => 'France', 
//     'rating' => 94
// ];
// $insertedId = $db->insert('player_profile', $insertData);
// echo "Inserted player with ID: $insertedId<br>"; 

$players = $db->select('player_profile');
foreach ($players as $player) {
    echo "ID: " . $player['id'] . " - Name: " . $player['name'] . " - Position: " . $player['position'] . " - Nationality: " . $player['nationality'] . " - Rating: " . $player['rating'] . "<br>";
}  

$updateData = [
    'rating' => 95, 
    'position' => 'Winger'
];
$updated = $db->update('player_profile', $updateData, 37);  

// $deleted = $db->delete('player_profile', 31);  


?>
