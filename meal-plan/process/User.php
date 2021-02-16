<?php

class User {
    // property declaration
    public $name;
    public $email;  
    public $password;
    public $height; 
    public $weight;  
    public $age; 
    public $gender;
    public $caloriesintake;
    public $dailycount;
    
    public function __construct($name='', $email='', $password='', $height='', $weight='', $age='', $gender='', $caloriesintake='', $dailycount='') {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->height = $height;
        $this->weight = $weight;
        $this->age = $age;
        $this->gender = $gender;
        $this->caloriesintake = $caloriesintake;
        $this->dailycount = $dailycount;
    }
    
    public function authenticate($enteredPwd) {
        $username = $_POST['email'];
        $dao = new UserDAO();
        $result = $dao->retrieve($this->email);
        return password_verify ($enteredPwd, $result->password);
    }
}

?>