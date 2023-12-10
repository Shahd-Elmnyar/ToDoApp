<?php 
    include_once 'header.php';
?>
    <section class ="section" >
        <h1> log in</h1>
        <form action ="includes/login.inc.php"method ="post">
            <input type = "text" name ="uid" placeholder="username / email">
            <br>
            <input type = "password"name ="pass" placeholder="password">
            <br>
            <button type="submit" name="submit">Login</button>
        </form>
    <?php
    if (isset($_GET['error'])){
        if ($_GET['error']=='emptyinput'){
            echo '<p>Fill in all fields </p>';
        }
        elseif ($_GET['error']=='wrongLogin'){
            echo '<p>Incorrect login information! </p>';
        }
    }
?>
    </section>
<?php 
    include_once 'footer.php';
?>