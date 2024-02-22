<?php 
    include_once 'header.php';
?>
<section class="section">
    <h1>Sign Up</h1>
    <form action="includes/signup.inc.php" method="post">
        <div>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name...">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email...">
        </div>
        <div>
            <label for="uid">Username:</label>
            <input type="text" id="uid" name="uid" placeholder="Choose a username...">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password...">
        </div>
        <div>
            <label for="passrepeat">Repeat Password:</label>
            <input type="password" id="passrepeat" name="passrepeat" placeholder="Repeat your password...">
        </div>
        <button type="submit" name="submit">Sign Up</button>
    </form>
    <?php
    if (isset($_GET['error'])){
        if ($_GET['error'] == 'emptyinput'){
            echo '<p>Fill in all fields </p>';
        }
        elseif ($_GET['error'] == 'invaliduid'){
            echo '<p>Choose a proper username! </p>';
        }
        elseif ($_GET['error'] == 'invalidemail'){
            echo '<p>Choose a proper email !</p>';
        }
        elseif ($_GET['error'] == 'passwordsdontmatch'){
            echo "<p>Passwords don't match!</p>";
        }
        elseif ($_GET['error'] == 'stmtFailed'){
            echo '<p>Something went wrong, try again!</p>';
        }
        elseif ($_GET['error'] == 'usernametaken'){
            echo '<p>User already taken !</p>';
        }
        elseif ($_GET['error'] == 'none'){
            echo '<p>You have signed up!</p>';
        }
    }
    ?>
</section>
<?php 
    include_once 'footer.php';
?>
