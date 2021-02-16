<?php
require_once 'ConnectionManager.php';
class UserDAO {
    
    
    public  function retrieve($email) {
        // $sql = 'select name, email, password, height, weight, age, gender, caloriesintake, dailycount from user where email=:email';
        
        // $connMgr = new ConnectionManager();
        // $conn = $connMgr->getConnection();
            
        // $stmt = $conn->prepare($sql);
        // $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        // $stmt->execute();


        // while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //     return new User($row['name'], $row['email'],$row['password'], $row['height'], $row['weight'], $row['age'], $row['gender'], $row['caloriesintake'], $row['dailycount']);
        // }
        return new User("John Doe", "test@gmail.com", "test", 180, 60, 25, 'male', 2500, 1500);
    }

    public  function retrieveAll() {
        // $sql = 'select * from user';
        
        // $connMgr = new ConnectionManager();      
        // $conn = $connMgr->getConnection();

        // $stmt = $conn->prepare($sql);
        // $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // $stmt->execute();

        // $result = array();

        // while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //     $result[] = new User("John Doe", "test@gmail.com", "test", 180, 60, 25, 'male', 2500, 1500);
        // }
        // return $result;
        return new User("John Doe", "test@gmail.com", "test", 180, 60, 25, 'male', 2500, 1500);
    }
  
    public function add($user) {
        $sql = 'insert into user (name, email, password, height, weight, age, gender, caloriesintake, dailycount) values (:name, :email, :password, :height, :weight, :age, :gender, :caloriesintake, :dailycount)';
        
        $connMgr = new ConnectionManager();       
        $conn = $connMgr->getConnection();
         
        $stmt = $conn->prepare($sql); 
        echo $user->name;
        $stmt->bindParam(':name', $user->name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $user->email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $user->password, PDO::PARAM_STR);
        $stmt->bindParam(':height', $user->height, PDO::PARAM_INT);
        $stmt->bindParam(':weight', $user->weight, PDO::PARAM_INT);
        $stmt->bindParam(':age', $user->age, PDO::PARAM_INT);
        $stmt->bindParam(':gender', $user->gender, PDO::PARAM_STR);
        $stmt->bindParam(':caloriesintake', $user->caloriesintake, PDO::PARAM_INT);
        $stmt->bindParam(':dailycount', $user->dailycount, PDO::PARAM_INT);
        
        $isAddOK = False;
        if ($stmt->execute()) {
            $isAddOK = True;
        }
        //$connMgr->close($conn,$stmt);
        $stmt->closeCursor();
        $conn = null;

        return $isAddOK;
    }

    public function updateDailyCount($email, $calories) {
        $sql = 'update user set dailycount=:dailycount where email=:email';

        $connMgr = new ConnectionManager();
        $conn = $connMgr->getConnection();
            
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':dailycount', $calories, PDO::PARAM_INT);
        $stmt->execute();
    }

}
