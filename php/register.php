<?php

    require_once('dbconnect.php');
    session_start();


    $username = mysqli_real_escape_string($con, $_POST['username']) ;            //kaning ['username'] kay mao ni ang name="username" nga naa sa signup.php Line 40
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);          //mame="firstname" Line 48
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);            //mame="lastname" Line 56
    $password = mysqli_real_escape_string($con, $_POST['password']);            //mame="password" Line 64
    $cfm_password = mysqli_real_escape_string($con, $_POST['confirmpassword']); //same ra gihapon ni nga password, gibutang lang ug lain variable para ma compare sila duha sa original password
    $icode = mysqli_real_escape_string($con, $_POST['icode']);

    $errors = array();    //nagcreate siyag array para diri ibutang ang mga errors

    if(empty($username)) {array_push($errors, "Username is empty!");}           //pareha ani, ang function sa array_push kay i-push niya ning mga if statements padung sa array nga $errors
    if(empty($firstname)) {array_push($errors, "Firstname is empty!");}
    if(empty($lastname)) {array_push($errors, "Lastname is empty!");}
    if(empty($password)) {array_push($errors, "Password is empty!");}
    //naa diri gi compare ang $password ug ang password nga gistore sa $cfm_password
    if($password != $cfm_password){array_push($errors, "Password does not match!");}


    if(!empty($username)){                                                      //kung dili empty ang username nga field, proceed
        $stmt = $con->prepare("SELECT username FROM tbl_users WHERE username=? LIMIT 1"); //search niya sa database kung nag exist ba ni siya nga user
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->store_result();

    if($stmt->num_rows == 1){
        array_push($errors, "username is already registered");
        $stmt->close();
    }
    }

    if(count($errors)==0){        //i-count niya ang pila ka errors nga nag true sa array nga #errors Line 14, kung wala, i-run niya ang ning code nga naa sa ubos
        $password = password_hash($cfm_password, PASSWORD_BCRYPT);              //i-encrypt ang password_hash


        /*
        Ani ang mahitabo diri sa OutOfBoundsException

        ang kanang VALUES (?, ?, ?, ? ) bitaw
        gamitan nag bind_param para isa2xhon siya ug add

        taraw

        INSERT INTO tbl_users(username, firstname, lastname, password) VALUES (? = $username, ? = $firstname, ? = $lastname, ? = $password)
        */
        $stmt = $con->prepare("INSERT INTO tbl_users(username, firstname, lastname, password ) VALUES (?,?,?,?)");


        $stmt->bind_param('ssss', $username,  $firstname,  $lastname,  $password);
        $stmt->execute();
        header("location:../html/signup.php?Success= Successfully Registered!");
    }else{
        header("location:../html/signup.php?Error= $errors[0]");
    }
?>
