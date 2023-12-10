<?php 
    include_once 'header.php';
?>
    <section>
        <h1> Sign Up</h1>
        <form action ="includes/signup.inc.php"method ="post">
            <input type = "text" name ="name" placeholder="full name...">
            <br>
            <input type = "email" name ="email" placeholder="email">
            <br>
            <input type = "text"name ="uid" placeholder="user name">
            <br>
            <input type = "password"name ="password" placeholder="password">
            <br>
            <input type = "password" name = "passrepeat" placeholder="repeat password">
            <br>
            <button type = "submit" name = "submit">sign up</button>
        </form>
    <?php
    if (isset($_GET['error'])){
        if ($_GET['error']=='emptyinput'){
            echo '<p>Fill in all fields </p>';
        }
        elseif ($_GET['error']=='invaliduid'){
            echo '<p>Choose a proper username! </p>';
        }
        elseif ($_GET['error']=='invalidemail'){
            echo '<p>Choose a proper email !</p>';
        }
        elseif ($_GET['error']=='passwordsdontmatch'){
            echo "<p>Password doesn't match!</p>";
        }
        elseif ($_GET['error']=='stmtFailed'){
            echo '<p>Something went wrong , try again!</p>';
        }
        elseif ($_GET['error']=='usernametaken'){
            echo '<p>User already taken !</p>';
        }
        elseif ($_GET['error']=='none'){
            echo '<p>You have signed up !</p>';
        }
    }
?>
    </section>
<?php 
    include_once 'footer.php';
?>