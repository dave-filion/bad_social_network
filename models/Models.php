<?php

class User
{   
   function __construct($user_id){
      $q = "SELECT * FROM users WHERE user_id='$user_id'";
      $result = mysql_query($q);
      $row = mysql_fetch_array($result);
      
      $this->user_id = $row['user_id'];
      $this->name  = $row['name'];
      $this->karma = $row['karma'];
      $this->profile_pic = $row['profile_pic'];
      $this->status = stripslashes($row['status']);
      $this->social_score = $row['social_score'];
      $this->content_score = $row['content_score'];
      $this->email = $row['email'];
   }
   
   function __toString(){
      return "$this->user_id : $this->name";
   }
   
}


?>