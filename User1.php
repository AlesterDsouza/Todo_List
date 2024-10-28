<?php
require_once 'db1.php';

class User1{
    private $db;

    public function __construct() {
        $this->db = new db1();
    }

    public function create1($Task) {
        $stmt = $this->db->conn->prepare("INSERT INTO task (Task) VALUES (?)");
        // $stmt->bind_param("ssisss", $firstName, $lastName, $mobileNumber, $email, $address, $profilePic);
        $stmt->bind_param("s", $Task);
        return $stmt->execute();
    }

    public function read1() {
        $result = $this->db->conn->query("SELECT * FROM task");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update1($id, $Task) {
        $stmt = $this->db->conn->prepare("UPDATE task SET Task = ? WHERE ID = ?");
        $stmt->bind_param("si", $Task, $id);
        return $stmt->execute();
    }

   
    public function delete1($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM task WHERE ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function find1($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM task WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function fetchTasks($search = '', $limit = 5, $offset = 0) {
        $query = "SELECT * FROM task WHERE Task LIKE ?  LIMIT ? OFFSET ?";
        $stmt = $this->db->conn->prepare($query);
        $likeSearch = "%$search%";
        $stmt->bind_param('sii', $likeSearch, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    // Method to count total users for pagination purposes
    public function countTasks($search = '') {
        $query = "SELECT COUNT(*) as total FROM task WHERE Task LIKE ? ";
        $stmt = $this->db->conn->prepare($query);
        $likeSearch = "%$search%";
        $stmt->bind_param('s', $likeSearch);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }


    // public function search1($firstName, $lastName, $mobileNumber, $email, $address){
    //        $stmt=$this->db->conn->prepare(" SELECT * from tblusers where FirstName like %?% OR LastName like %?% OR MobileNumber like %?% OR Email like %?%  OR Address like %?% " );
    //        $stmt->bind_param("ssisss", $firstName, $lastName, $mobileNumber, $email, $address);
    //        return $stmt->fetch_all(MYSQLI_ASSOC);
    // }
}
?>
