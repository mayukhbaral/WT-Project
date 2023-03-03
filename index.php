<?php
    if (isset($_POST['login-submit'])) {
        include('dbConnect.php');
        $email =   $_POST['email'];
        $password =   $_POST['password'];
        $passwordEncryp = md5($password);
        $sql = "SELECT * FROM users WHERE email = '{$email}'" ;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)>0) {
            $row=mysqli_fetch_assoc($result);
            $password=$row['password'];
            if($password===$passwordEncryp){
                session_start();
                $_SESSION['username'] = $row['username'];
                header("location:dashboard.php");
            }
            else {
                $errors = "Invalid Password or Email";
            }
        }
        else {
            $errors = "Invalid Password or Email";
        }
    }
?>


        
<?php 
   if (isset($_POST["signup-submit"])) { 
      include('dbConnect.php');
      $userName =  $_POST['username'];
      $email =   $_POST['email'];
      $password =   $_POST['password'];
      $rePassword =   $_POST['re-password'];
      $passwordHash = md5($password);
      $errors = array();
      $sql = "SELECT * FROM users WHERE email = '{$email}'" ;
      $sql1 = "SELECT * FROM users WHERE username = '{$userName}'" ;
      $result = mysqli_query($conn, $sql);
      $result1 = mysqli_query($conn, $sql1);

      if (empty($email)) {
         $errors['email']= "Email is mandatory.";
      }
      elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $errors['email'] = "Email is not valid."; 
      }
      elseif (mysqli_num_rows($result)>0) {
         $errors['email'] = "Email is already exist" ; 
      }
      
    
      if(empty($userName)){
         $errors['username'] = "Username is mandatory.";
      } 
      elseif (mysqli_num_rows($result1)>0) {
         $errors['username']= "Username is already exist"  ; 
      }


      if (empty($password)) {
         $errors['password']  = "Password is mandatory.";   
      }
      elseif (strlen($password) < 8 ) {
         $errors['password']  = "Password must be at least 8 characters.";   
      }


      if ($password != $rePassword) {
         $errors['re-password'] = "Password doesn't match.";
      }


      if (count($errors)==0){
         $query = "INSERT INTO users(username,email,password) VALUES('{$userName}', '{$email}', '{$passwordHash}')"; 
         if (mysqli_query($conn, $query)) {
            $success_msg = "Hello! $userName, You have registered successfully. Now, you can log in.";
         }
         else{
            echo "Something is wrong.";
         }
      }
   }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCES</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            position: absolute;
        }

        .line-above-nav {
            position: fixed;
            /* background-color: rgb(19, 19, 41); */
            background-image: linear-gradient(black, rgb(27, 27, 75));
            width: 100%;
            height: 16px;
            top: 0px;
            z-index: 1;
        }

        nav {
            display: block;
            position: fixed;
            top: 16px;
            background-image: linear-gradient(rgb(71, 11, 11), black);
            width: 100%;
            height: 10vh;
            font-size: 20px;
            box-shadow: 0px 2px 20px 0px black;
            z-index: 10;
        }

        nav ul {
            margin: auto;
            width: fit-content;
            height: fit-content;
            list-style: none;
            background-color: rgb(70, 58, 43);
            text-align: center;
            box-shadow: 0px 0px 2px 0px black;
        }

        nav ul li {
            height: 10vh;
            display: inline-block;
            padding: 3% 1vw;
            color: white;
        }

        nav ul li:hover {
            color: gold;
            background-image: linear-gradient(rgb(71, 11, 11), black);
            cursor: pointer;
        }

        nav #nav-buttons{
            width: 24%;
            height: 100%;
            padding: 0px;
            position: absolute;
            display: inline-block;
            top: 0px:;
            right: 0%;
            bottom: 0%;
            margin: auto;
        }

        nav #nav-buttons #login-button {
            height: fit-content;
            padding: 2% 8%;
            position: absolute;
            top: 0px;
            bottom: 0px;
            left: 8%;
            margin: auto;
            font-size: 20px;
            border-radius: 8px;
            border: none;
            background-color: rgb(221, 40, 40);
            color: rgb(238, 238, 238);
            cursor: pointer;
        }

        nav #nav-buttons #signup-button {
            height: fit-content;
            padding: 2% 8%;
            position: absolute;
            top: 0px;
            bottom: 0px;
            right: 8%;
            margin: auto;
            font-size: 20px;
            border-radius: 8px;
            border: 1px solid rgb(221, 40, 40);
            background-color: transparent;
            color: rgb(238, 238, 238);
            cursor: pointer;
        }

        .errmsg{
            font-size: 12px;
            color: red;
        }

        nav #login-button:hover,
        nav #signup-button:hover,
        #login-form button:hover,
        #signup-form button:hover {
            background: linear-gradient(rgb(245, 51, 51), rgb(145, 7, 7));
            box-shadow: 1px 1px 4px 0px black;
        }

        button:active {
            transition: transform .01s ease-in-out;
            transform: scale(0.95);
        }

        #overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, .6);
            opacity: 0;
            transition: opacity .4s ease-in-out;
            z-index: 11;
            pointer-events: none;
        }

        .line-below-nav::after {
            content: '';
            background: url(./gces3-copy2.jpg);
            background-repeat: no-repeat;
            background-position: 0px 16px;
            background-size: cover;
            position: fixed;
            top: 0px;
            right: 0px;
            bottom: 0px;
            left: 0px;
            z-index: -1;
            opacity: .9;
        }

        #login-form {
            position: fixed;
            width: 32vw;
            height: fit-content;
            top: 5vh;
            right: 0px;
            bottom: 0px;
            left: 0px;
            margin: auto;
            background-color: white;
            border-radius: 4%;
            z-index: 12;
            transform: scale(0);
            transition: all .2s ease-in-out;
        }

        #login-form #close-login {
            position: absolute;
            right: 3%;
            top: 2%;
            color: rgb(78, 88, 88);
            cursor: pointer;
        }

        #login-form h2 {
            margin: 8% 12%;
            padding: 2% 12%;
            border-radius: 24px;
            text-align: center;
            background-color: paleturquoise;
            font-size: 32px;
        }

        #login-form form {
            margin: 10% 12%;
            color: rgb(78, 88, 88);
        }

        #login-form form h3 {
            margin: 8% 2% 0%;
            font-size: 20px;
        }

        #login-form input {
            width: 100%;
            padding: 2%;
            border-top: 0;
            border-left: 0;
            border-right: 0;
            outline: none;
        }

        #login-form button {
            display: block;
            margin: 16px auto;
            padding: 8px 32px;
            font-size: 20px;
            border-radius: 8px;
            border: none;
            background-color: rgb(221, 40, 40);
            color: rgb(238, 238, 238);
            cursor: pointer;
        }

        #login-form p {
            text-align: center;
        }

        #login-form #signup-now {
            color: rgb(221, 40, 40);
            cursor: pointer;
        }

        #signup-form {
            position: fixed;
            width: 32vw;
            height: fit-content;
            top: 0px;
            right: 0px;
            bottom: 0px;
            left: 0px;
            margin: auto auto;
            background-color: white;
            align-content: center;
            border-radius: 4%;
            z-index: 12;
            box-sizing: border-box;
            transform: scale(0);
            transition: all .2s ease-in-out;
        }

        #signup-form #close-signup {
            position: absolute;
            right: 3%;
            top: 2%;
            color: rgb(78, 88, 88);
            cursor: pointer;
        }

        #signup-form h2 {
            margin: 8% 12%;
            padding: 2% 12%;
            border-radius: 24px;
            text-align: center;
            background-color: paleturquoise;
            font-size: 32px;
        }

        #signup-form form {
            margin: 10% 12%;
            color: rgb(78, 88, 88);
        }

        #signup-form form h3 {
            margin: 8% 2% 0%;
            font-size: 20px;
        }

        #signup-form input {
            width: 100%;
            padding: 2%;
            border-top: 0;
            border-left: 0;
            border-right: 0;
            border-bottom: 1px solid grey;
            outline: none;
        }

        #signup-form .checkbox {
            width: 32px;
            margin: 8% 2px 4%;
        }

        #signup-form button {
            display: block;
            margin: auto;
            padding: 8px 32px;
            font-size: 20px;
            border-radius: 8px;
            border: none;
            background-color: rgb(221, 40, 40);
            color: rgb(238, 238, 238);
            cursor: pointer;
        }

        #signup-form #login-now {
            cursor: pointer;
            color: rgb(221, 40, 40);
        }

        #signup-form p {
            margin: 4% auto;
            text-align: center;
        }

        .welcome {
            /* position: sticky; */
            display: block;
            margin: 205px 16px;
            height: 200px;
            /* border: 2px solid red; */
        }

        .welcome h1 {
            /* position: sticky; */
            color: white;
            font-size: 64px;
            text-align: center;
            text-shadow: 2px 5px 5px black;
            z-index: -5;
        }

        .welcome h2 {
            /* position: sticky; */
            color: white;
            font-size: 32px;
            text-align: center;
            text-shadow: 2px 5px 5px black;
            z-index: -5;
        }

        .white {
            /* background-color:  rgb(3, 3, 22); */
            background-image: linear-gradient(rgb(10, 10, 51), black, rgb(10, 10, 51), black, rgb(10, 10, 51), black, rgb(10, 10, 51), black);
            width: 100%;
            /* height: 1000px; */
            /* position: absolute; */
            top: 100%;
            /* margin-top:auto; */
            /* z-index: -1; */
            padding: 96px;
        }


        /* ASIDE */
        .aside-admission {
            position: sticky;
            top: 90px;
            display: inline-block;
            float: right;
            margin: 48px -32px;
            width: 256px;
            height: 512px;
            border: 2px solid rebeccapurple;
            z-index: 0;
        }

        .aside-admission .college-name {
            width: 50%;
            height: 25%;
            background-color: blueviolet;
            /* border-bottom-right-radius: 50%; */
            border-radius: 0px 0% 50% 0%;
            padding-top: 32px;
        }

        .aside-admission .college-name h4 {
            font-size: 32px;
            text-align: center;
            line-height: 128px, 0px;
        }

        .aside-admission .college-name p {
            font-size: 12px;
            text-align: center;
        }

        .aside-admission .admission-open {
            text-align: center;
            /* background-color: cadetblue; */
            padding: 16px;
            text-align: left;
            color: white;
            font-size: 40px;
        }

        .aside-admission ul {
            text-align: center;
            /* background-color: cadetblue; */
            padding: 16px;
            text-align: left;
            color: lightgrey;
            font-size: 16px;
            margin-left: 16px;
        }

        .aside-admission ul h5 {
            display: inline-block;
            text-align: left;
            /* background-color: cadetblue; */
            text-align: left;
            color: lightgrey;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .aside-admission ul li {
            margin: 8px 8px;
            text-align: left;
            /* background-color: cadetblue; */
            /* padding: 8px; */
            text-align: left;
            color: lightgrey;
            font-size: 16px;
        }

        /* MAIN */

        main .white>h1 {
            display: block;
            /* background-color: cadetblue; */
            height: 64px;
            margin: -24px 32px 24px;
            text-align: center;
            font-size: 48px;
            color: silver;
        }

        main section {
            display: inline-block;
            /* width: 896px; */
            width: 72%;
            padding: 32px 64px;
            margin: 48px 0px;
            background-color: khaki;

            font-size: 16px;
        }

        main .white section h1 {
            margin: 8px;
            font-size: 32px;
            /* background-color: firebrick; */
        }


        /* FACULTIES */
        .faculties {
            /* border: 2px solid gold; */
            /* background-color: green; */
            display: inline-block;
            width: 72%;
            /* height: 1024px; */
            padding: 0px 64px;
            margin: 16px 0px;
            font-size: 14px;
            box-shadow: 0px 0px 24px 10px rgb(90, 27, 27), 0px 0px 40px 2px black;
        }

        .faculties>h1 {
            display: block;
            /* background-color: cadetblue; */
            height: fit-content;
            margin: 48px auto -16px;
            text-align: center;
            font-size: 48px;
            color: silver;
        }

        .faculties h2 {
            font-size: 32px;
            margin: 8px;
        }

        .faculties .bese {
            /* border: 2px solid green; */
            background-color: gold;
            /* display: inline-block; */
            width: 100%;
            /* height: 32%; */
            padding: 32px 48px 40px;
            margin: 64px 8px;
        }

        .faculties .bece {
            /* border: 2px solid green; */
            background-color: gold;
            /* display: inline-block; */
            width: 100%;
            /* height: 32%; */
            padding: 32px 48px 40px;
            margin: 64px 8px;
        }

        .faculties .mis {
            /* border: 2px solid green; */
            background-color: gold;
            /* display: inline-block; */
            width: 100%;
            /* height: 32%; */
            padding: 32px 48px 40px;
            margin: 64px 8px;
        }

        .it-expo {
            /* border: 2px solid gold; */
            /* background-color: green; */
            display: inline-block;
            width: 72%;
            /* height: 1024px; */
            padding: 48px 128px;
            margin: 64px 0px 8px;
            font-size: 14px;
            text-align: center;
            box-shadow: 0px 0px 24px 10px rgb(90, 27, 27), 0px 0px 40px 2px black;
            color: white;
        }

        .it-expo h2 {
            font-size: 48px;
            margin-bottom: 32px;
        }

        .text-over-image {
            width: 100%;
            background-color: black;
            /* margin: 4px -96px 32px -96px; */
            /* z-index: 10; */
            height: 100vh;
            position: absolute;
            background-color: aqua;
            animation: ani-text-over-image 8s infinite normal;
            background-size: 100vw 100vh;
        }

        @keyframes ani-text-over-image {
            0% {
                background-image: url(./microprocessor-1.jpg);
            }

            20% {
                background-image: url(./microprocessor-1.jpg);
            }

            30% {
                background-image: url(./microprocessor-2.jpg);
            }

            45% {
                background-image: url(./microprocessor-2.jpg);
            }

            55% {
                background-image: url(./microprocessor-3.jpg);
            }

            70% {
                background-image: url(./microprocessor-3.jpg);
            }

            80% {
                background-image: url(./microprocessor-5.jpg);
            }

            100% {
                background-image: url(./microprocessor-5.jpg);
            }
        }

        .text-over-image img {
            width: 100%;
            height: 100vh;
            display: inline-block;
            opacity: .9;
        }

        .text-over-image h4 {
            display: inline-block;
            width: 75%;
            height: fit-content;
            position: absolute;
            top: 0px;
            bottom: 0px;
            right: 0px;
            left: 0px;
            margin: auto;
            text-align: center;
            font-size: 40px;
            line-height: 52px;
            /* background-color: blueviolet; */
            color: white;
            text-shadow: 2px 4px 4px black;
            /* z-index: 2; */
        }

        .three-circles {
            width: 100%;
            height: 75vh;
            /* background-color: crimson; */
            position: absolute;
            top: 100vh;
            padding: 48px 0px 48px 48px;
        }

        .circle {
            display: inline-block;
            width: 300px;
            height: 300px;
            margin: 40px 48px;
            /* border: 5px solid green; */
            box-shadow: 0px 0px 20px 5px black, 0px 0px 20px 5px rgb(10, 10, 51), 0px 0px 25px 10px grey inset;
            background-color: white;
            font-size: 32px;
            text-align: center;
            line-height: 48vh;
            border-radius: 50%;
            font-weight: bold;
            text-shadow: 4px 4px 8px darkslategrey;
        }

        footer {
            display: block;
            width: 100%;
            height: 48vh;
            background-color: rgb(22, 46, 46);
            position: absolute;
            bottom: 0px;
            z-index: 10;
            padding: 50px;
            color: white;
        }

        footer .left {
            display: inline-block;
            float: left;
            width: 24vw;
            /* border: 2px solid gold; */
            /* background-color: green; */
            margin: 8px;
        }

        footer h6 {
            /* float:none; */
            width: 32vw;
            /* border: 2px solid gold; */
            /* background-color: green; */
            margin: 8px auto;
            font-size: 32px;
            text-align: center;
        }

        footer .right {
            display: inline-block;
            float: right;
            width: 24vw;
            /* border: 2px solid gold; */
            /* background-color: green; */
            margin: 8px;
            /* list-style: none; */
        }

        footer .right ul li {
            display: inline-block;
            list-style: none;
            margin: 8px 6px;
        }

        footer .right ul li:hover {
            cursor: pointer;
        }

        .long {
            /* border: 2px solid red; */
            width: 100px;
            height: 1400px;
            margin-top: 200px;
            margin: 8px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }


        @media screen and (max-width: 800px){
            #login-form, #signup-form{
                width: 64vw;
            }
        }

        @media screen and (max-width: 400px){
            #login-form, #signup-form{
                width: 70vw;
            }
        }

        @media screen and (max-width: 300px){
            #login-form, #signup-form{
                width: 80vw;
            }
        }

    </style>
</head>

<body>
    <div id="overlay"></div>

    <div class="line-above-nav"></div>
    <nav>
        <ul class="left">
            <li>Home</li>
            <li>Faculty</li>
            <li>Alumni</li>
            <li>Academics</li>
            <li>Admissions</li>
            <li>More</li>
        </ul>
        <div id="nav-buttons">
            <button id="signup-button">Sign Up</button>
            <button id="login-button">Log In</button>
        </div>
    </nav>
    <div class="line-below-nav"></div>
    <div class="bg-image"></div>

    <div id="login-form">
        <span id="close-login">&#x2716</span>
        <h2>Login</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
            <h3>E-mail</h3>
            <input type="email" placeholder="....@gmail.com" name="email" required>

            <h3>Password</h3>
            <input type="password" placeholder="********" name="password" required>

            <?php  if(isset($errors)) { ?>
                   <p class ="errmsg"><br><?php echo '&#9888' ; echo $errors ?> </p>
                <?php }?>


            <button type="submit" name="login-submit">Log in</button>
            <p>Have not Signed Up yet? <span id="signup-now">Sign Up</span> Now</p>
        </form>
    </div>

    <div id="signup-form">
        <span id="close-signup">&#x2716</span>
        <h2>Sign Up</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">

            <h3>Username</h3>
            <input type="text" placeholder="username" name="username" value="<?=(isset($userName))?$userName:''?>" required>
            <?php  if (isset($errors['username'])) { ?>
               <P id="errmsg_user" class = "errmsg" ><?php echo '&#9888' ; echo $errors['username'] ;?> </p>
            <?php } ?>

            <h3>E-mail</h3>
            <input type="email" placeholder="....@gmail.com" name="email" value="<?=(isset($email))?$email:''?>" required>
            <?php  if (isset($errors['email'])) { ?>
               <p id="errmsg_email" class = "errmsg" ><?php echo '&#9888' ; echo $errors['email']?> </p>
            <?php } ?>

            <h3>Password</h3>
            <input type="password" placeholder="********" name="password" required>
            <?php  if (isset($errors['password'])) { ?> 
               <p id="errmsg_pw" class = "errmsg" ><?php echo '&#9888' ; echo $errors['password']?> </p>
            <?php } ?>

            <h3>Confirm Password</h3>
            <input type="password" placeholder="Re-enter password" name="re-password" required>
            <?php  if (isset($errors['re-password'])) { ?>
               <p id="errmsg_rePw" class = "errmsg" ><?php echo '&#9888' ; echo $errors['re-password']?> </p>
            <?php } ?>

            <input type="checkbox" class="checkbox" required>I agree all the terms and conditions. <br>
            <button id="signup" type="submit" name="signup-submit">Sign Up</button>
            <p>Already have an account? <span id="login-now"> Log in</span> Now</p>

            <?php  if (isset($success_msg)) { ?>
               <p id ="success-msg"><?php echo $success_msg?> </p>
            <?php } ?>
        </form>
    </div>


    <header>
        <div class="welcome">
            <h2>Welcome to</h2>
            <h1>Gandaki College of Engineering and Science</h1>
        </div>
    </header>

    <main>
        <div class="white">
            <h1>First Software Engineering College of Nepal</h1>
            <section>
                <h1>About Us</h1>
                <p>About GCES
                    Located in the serenity of Pokhara Valley, GCES easily snags a top spot on the list of the 'best'
                    programs offered in the field of Computer Engineering, Software Engineering, and specialized field
                    of Information Systems Engineering in Nepal for its overall affordability and success upon
                    graduation.</p>
            </section>
            <aside class="aside-admission">
                <div class="college-name">
                    <h4>GCES</h4>
                    <p>BESE and BECE</p>
                </div>
                <div class="admission-open">Admissions Open</div>
                <ul>
                    <h5>BE Software Engineering</h5>
                    <h5>BE Computer Engineering</h5>
                    Elgibility:
                    <li>10+2 Science</li>
                    <li>Cambridge A level\ Equivalent</li>
                    <li>Minimum "C" grade in every subject</li>
                </ul>
            </aside>

            <div class="faculties">
                <h1>Faculties</h1>
                <div class="bese">
                    <h2>Software Engineering</h2>
                    <p>Bachelors of Software Engineering program is a 4-years 133 credit undergraduate engineering
                        program. Graduates of this program possess knowledge and skills of a defined engineering
                        approach to complex systems analysis, planning, design and construction. The program has a
                        unique, project-driven curriculum, establishing a new model of communication, teamwork, critical
                        thinking and professionalism. </p>
                </div>
                <div class="bece">
                    <h2>Computer Engineering</h2>
                    <p>Bachelors of Computer Engineering program is a 4-years 137 credit undergraduate engineering
                        program. The program is concerned with the analysis, design, and evaluation of computer systems,
                        both hardware, and software. The program emphasizes computer organization and architecture,
                        systems programming, operating systems, and digital hardware design. This field of study not
                        only focuses on how computer systems work but also how they integrate into the larger picture
                    </p>
                </div>
                <div class="mis">
                    <h2>M. Sc. in Information System</h2>
                    <p>The Master of Science in Information System Engineering (M. Sc. ISE) is a 2 year’s 60 credit
                        graduate program under the Faculty of Science and Technology of the Pokhara University. It is
                        aimed at producing professional engineers with the essential skills required to successfully
                        deal with the technical, social, legal and moral aspects of the practices of Information System
                        Engineering in Nepal</p>
                </div>
            </div>

            <div class="it-expo">
                <h2>GCES IT Expo</h2>
                <iframe
                    src="https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2Fgces.pokhara%2Fvideos%2F624324791686060%2F&show_text=false&width=560&t=0"
                    width="560" height="314" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                    allowfullscreen="true"
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                    allowFullScreen="true"></iframe>
            </div>

        </div>
        <div class="text-over-image">
            <!-- <img src="./Images/microprocessor-5.jpg" alt=""> -->
            <h4>Gandaki College of Engineering and Science offers career-oriented programs for motivated students who
                seek academic excellence, personal growth, and professional success.</h4>
            <div class="three-circles">
                <div class="circle">
                    1,000 enrolled
                </div>
                <div class="circle">
                    800 projects
                </div>
                <div class="circle">
                    500 workshops
                </div>
            </div>
        </div>
    </main>


    <footer>
        <h6>Gandaki College of Engineering and Science</h6>
        <div class="left">
            <p class="copyright">&copy; 2022 Gandaki College of Engineering and Science</p>
            <!-- <img src="./Images/gces-logo.png" alt=""> -->
        </div>
        <div class="right">
            <b>Contact Us</b>
            <ul>
                <li>Facebook</li>
                <li>Twitter</li>
                <li>Instagram</li>
                <li>Youtube</li>
            </ul>
        </div>
    </footer>
    
    <div class="long">This is long div.</div>


    <script src="./script.js"></script>

</body>

</html>