<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        nav #logout-button {
            position: absolute;
            right: 2%;
            bottom: 20%;
            padding: 8px 20px;
            font-size: 20px;
            border-radius: 8px;
            border: none;
            background-color: rgb(81, 159, 185);
            color: black;
            cursor: pointer;
        }

        nav #logout-button:hover {
            background: linear-gradient(rgb(81, 159, 185), #1877f2);
            box-shadow: 1px 1px 4px 0px black;
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

        section {
            width: 100vw;
            height: 1000px;
            background-image: linear-gradient(rgb(10, 10, 51), black, rgb(10, 10, 51), black, rgb(10, 10, 51), black, rgb(10, 10, 51), black);
            margin-top: 176px;
        }

        section h2 {
            text-align: center;
            background: linear-gradient(rgb(81, 159, 185), #1877f2);
            padding: 48px;
            font-size: 48px;
        }

        form {
            width: 62%;
            margin: 24px auto;
            padding: 48px;
            color: silver;
            border-radius: 16px;
            line-height: 32px;
            box-shadow: 1px 1px 16px rgb(81, 159, 185);
        }

        form h4 {
            font-size: 32px;
            color: beige;
            margin-bottom: 16px;
        }

        form input {
            margin: 0px 32px 8px 8px;
            padding: 4px;
            background-color: transparent;
            border: 0px;
            border-bottom: 1px solid silver;
        }

        form .button {
            margin-top: 8px;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            background-color: rgb(81, 159, 185);
            color: black;
            cursor: pointer;
        }

        form .button:hover {
            background: linear-gradient(rgb(81, 159, 185), #1877f2);
            box-shadow: 1px 1px 4px 0px black;
        }
    </style>
</head>

<body>
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
        <a href="logout.php"><button id="logout-button">Log Out</button></a>
    </nav>
    <div class="line-below-nav"></div>

    <header>
        <div class="welcome">
            <h2>Welcome to</h2>
            <h1>Gandaki College of Engineering and Science</h1>
            <h1> <?php echo $_SESSION['username'] ?> </h1>
        </div>
    </header>

    <section>
        <h2>Please fill the student's details</h2>
        <form action="">
            <h4>Personal Details</h4>
            Frist Name:
            <input type="text"><br>
            Middle Name:
            <input type="text"><br>
            Last Name:
            <input type="text"><br>
            Address:
            <input type="text"><br>
            Date of Birth:
            <input type="date"><br>
            Gender:
            <input type="radio" value="male" name="gen"> Male
            <input type="radio" value="female" name="gen"> Female <br>
            Student's Mobile:
            <input type="text" maxlength="10">
            Student's Email:
            <input type="text" placeholder="........@gmail.com"><br><br>
        </form>

        <form action="">
            <h4>Documents Needed</h4>
            <ol type="i">
                <li>Upload Transcript of 11 and 12 here <input type="file" name="doc" id="doc"> </li>
                <li>Upload Migration Certificate here.<input type="file" name="doc1" id="doc1"></li>
                <li>Upload Character Certificate here.<input type="file" name="doc2" id="doc2"></li>
            </ol>

            <b>Submit your form</b> <br>
            <input type="submit" value="Submit" class="button">
            <input type="reset" value="Reset" class="button">
        </form>
    </section>

    <script>
        var logoutButton=document.getElementById("logout-button");
        logoutButton.addEventListener("click", function(){
            alert("Are you sure you want to log out?");
        });
    </script>

</body>

</html>