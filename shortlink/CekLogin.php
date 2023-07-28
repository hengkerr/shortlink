<?php
session_start();

require_once('connect.php');

if($_SERVER['REQUEST_METHOD']==='POST'){
    $error_msg=false;
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        //user want to login
        $username=$_POST['username'];
        $password=md5($_POST['password']);
        $av_char="/[^a-z0-9A-Z@._]/"; 
        if(preg_match($av_char, $username)===1){
            $_SESSION['error']="Use the right input!";
            $error_msg=true;
        }
        else if(preg_match($av_char, $password)===1){
            $_SESSION['error']="Use the right input!";
            $error_msg=true;
        }
        if($error_msg){
            header("Location: ./login.php");
            die;
        }
        if(strlen($username) < 4){
            $_SESSION['error']="Username terlalu pendek!";
            $error_msg=true;
        }
        if(strlen($_POST['password']) < 7){
            $_SESSION['error']="Password terlalu pendek!";
            $error_msg=true;
        }
        else if(strlen($_POST['password']) > 50){
            $_SESSION['error']="Password terlalu panjang!";
            $error_msg=true;
        }
        if($error_msg){
            header("Location: ./login.php");
            die;
        }
        
        $sql="SELECT userID,userName FROM username WHERE userName = ? AND userPass= ?";
        $query=$mysqli->prepare($sql);
        $hasil=$query->bind_param("ss",$username,$password);
        $query->execute();
        $query->bind_result($user_id,$username_data);
        $query->store_result();
        if($query->num_rows>0){
            
            //username or password is valid
            $query->fetch();
            $_SESSION['is_login']=true;
            $_SESSION['user_id']=$user_id;
            $_SESSION['username']=$username_data;
            header("Location: ./index.php");
        }
        else{
            //username or password invalid
            $message="Username atau password salah!";
            header("Location: ./login.php?message=$message");
            $mysqli->close();
            session_destroy();
            unset($_SESSION);
            die;
        }
    }
    else{
        $_SESSION['error']="Username dan password tidak boleh kosong!";
        header("Location: ./login.php");
        die;
    }
}
?>