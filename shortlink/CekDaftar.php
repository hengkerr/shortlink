<?php
session_start();

require_once('./connect.php');

if($_SERVER['REQUEST_METHOD']==='POST'){
    $error_msg=false;
    if(isset($_POST['username'])&&isset($_POST['password'])){
        echo "hallo";
        if(!empty($_POST['username'])&&!empty($_POST['password'])){
            $username=$_POST['username'];
            $password=md5($_POST['password']);
            $av_char="/[^a-z0-9A-Z@._]/";
            if(preg_match($av_char, $username)===1){
                $_SESSION['error']="Use the right input!";
                $error_msg=true;
            }
            else if(preg_match($av_char, $_POST['password'])===1){
                $_SESSION['error']="Use the right input!";
                $error_msg=true;
            }
            if($error_msg){
                header("Location: ./daftar.php");
                die;
            }
            if(empty($username)){
                $_SESSION['error']="Username tidak boleh kosong!";
                $error_msg=true;
            }
            else if(strlen($username) < 4){
                $_SESSION['error']="Username terlalu pendek!";
                $error_msg=true;
            }
            else if(strlen($username) > 50){
                $_SESSION['error']="Username terlalu panjang!";
                $error_msg=true;
            }
            if(empty($_POST['password'])){
                $_SESSION['error']="Password tidak boleh kosong!";
                $error_msg=true;
            }
            else if(strlen($_POST['password']) < 7){
                $_SESSION['error']="Password terlalu pendek!";
                $error_msg=true;
            }
            else if(strlen($_POST['password']) > 50){
                $_SESSION['error']="Password terlalu panjang!";
                $error_msg=true;
            }
            if($error_msg){
                header("Location: ./daftar.php");
                die;
            }
            $sql="SELECT userName FROM username WHERE userName=?";
            $query=$mysqli->prepare($sql);
            $hasil=$query->bind_param("s",$username);
            $query->execute();
            // $query->bind_result($user_email_data);
            $query->store_result();
            if($query->num_rows==0){
                $sql="INSERT INTO username(userName,userPass) VALUES (?,?)";
                $query=$mysqli->prepare($sql);
                $hasil=$query->bind_param("ss",$username,$password);
                $query->execute();
                if($query->affected_rows<0){
                    $message="Sign Up Failed";
                    header("location: ./daftar.php?message=$message");
                }
                else{
                    $message="Sign Up Success";
                    header("location: ./login.php?message=$message");
                }
            }
            else{
                    $query->fetch();
                    $error_msg=true;
                    $_SESSION['error']="Sign Up Failed!<br>Nama telah digunakan!";
                    header("location: ./daftar.php");
                    die;
            }
        }
        else if(empty($_POST['username'])||empty($_POST['password'])){
            $_SESSION['error']="The username or password has not been filled!";
            header("Location: ./daftar.php");
            die;
        }
    }
    else if(!isset($_POST['username']) && !isset($_POST['password'])){
        $_SESSION['error']="The username or password has not been filled!";
        header("Location: ./daftar.php");
        die;
    }
}
?>