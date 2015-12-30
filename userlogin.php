
<?php
	include 'header.php';
    require_once('WebsiteUser.php');
    session_start();
    if(isset($_SESSION['websiteUser'])){
        if($_SESSION['websiteUser']->isAuthenticated()){
            session_write_close();
            header('Location:mailing_list.php');
        }
    }
    $missingFields = false;
    if(isset($_GET['submit'])){
        if(isset($_GET['username']) && isset($_GET['password'])){
            if($_GET['username'] == "" || $_GET['password'] == ""){
                $missingFields = true;
            } else {
                //All fields set, fields have a value
                $websiteUser = new WebsiteUser();
                if(!$websiteUser->hasDbError()){
                    $username = $_GET['username'];
                    $password = $_GET['password'];
                    $websiteUser->authenticate($username, $password);
                    if($websiteUser->isAuthenticated($username, $password)){
                        $_SESSION['websiteUser'] = $websiteUser;
						$lastLogin = date("y-m-d");
						$websiteUser->lastLogin($username, $password, $lastLogin);
						$_SESSION["username"] = $username;
						$_SESSION["password"] = $password;
                        header('Location: mailing_list.php');
                    }
                }
            }
        }
    }

            //Missing username/password
            if($missingFields){
                echo '<h3 style="color:red;">Please enter both a username and a password</h3>';
            }
            
            //Authentication failed
            if(isset($websiteUser)){
                if(!$websiteUser->isAuthenticated()){
                    echo '<h3 style="color:red;">Login failed. Please try again.</h3>';
                }
            }
        ?>
        
        <form name="login" id="login" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" id="username"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" id="password"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" id="submit" value="Login"></td>
                <td><input type="reset" name="reset" id="reset" value="Reset"></td>
            </tr>
        </table>
        </form>


<?php include 'footer.php'; ?>