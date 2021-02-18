<?php
require_once('dbconnect.php');    //required sya nga i-run ang dbconnect.php first adesir mu proceed
session_start();

        //ang kanang ['username'] kay gikan na sa login.php nga naa sa html folder
        $username = $_POST['username'];
        //ang kaning ['password'] kay gikan gihapon sa login.php nga naa sa html folder
        $password = $_POST['password'];
        //ang purpose ani nga variable kay diri i-store ang password nga gi encrypt
        $newhash ="";

        if(empty($username) || empty($password)){                               //purpose ra ani niya kay kung walay sulod ang username AND password nga field kay magreturn sya ug error didto sa header (kanang naa sa url)
            header("location:../html/login.php?Empty= Please fill in the Blanks!");
        }
        else{
            $stmt = $con->prepare("SELECT user_id, firstname, lastname, username, password FROM tbl_users WHERE username=? LIMIT 1");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            //kaning bind_result kay mao ning mukuha sa data nga ipasa sa prepared statement("$con->prepare("SELECT user_id, firstname, lastname, username, password FROM tbl_users WHERE username=? LIMIT 1")")
            /*
            think of this as an array, nga gi-isa2x ang pagkuha example:


            user_id: 1
            firstname: Renz Ivan
            lastname: Irag
            username: RenzIvan12
            password: 123456


            */
            $stmt->bind_result($user_ID, $firstname, $lastname, $username, $hash);
            $stmt->store_result();


            if($stmt->num_rows == 1){       //???
                while($stmt->fetch()){      //mao ni magkuha or "fetch" sa data nga naa sa database

                    if(password_verify($password, $hash)){          //verify kung ang kani nga password kay nag match sa gi-hash nga password


                        $_SESSION['user_id']=$user_ID;              //kani sila tulo, mao ni ipasa gikan sa database to html para i.display ang user nga naka login
                        $_SESSION['firstname']=$firstname;
                        $_SESSION['lastname']=$lastname;

                        header("location:../index.php");
                    }
                    else{
                    header("location:../html/login.php?Invalid= Incorrect Password!");  //kung dili mag match ang password sa naka hash nga password nga naa sa database
                }
            }
            }else{
                header("location:../html/login.php?Invalid= Username not found!");    //kung ang gi-input nga username kay doesn't exist
            }
            $stmt->close();
        }


?>
