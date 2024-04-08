<?php
    $connstring = getenv('DB_CONN_STRING');

    class Users {
        // Egenskaper
        public $username;
        public $pass;
        public $color;
        public $date;

        // Metoder
        function __construct(string $username, string $pass, string $color, string $date) {
            if(isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['color'])) {
                $this->username = $username;
                $this->pass = $pass;
                $this->color = $color;
                
                // Läs in kontouppgifter
                $username = $_POST['username'];
                $pass = $_POST['pass'];
                $color = $_POST['color'];
                $date = date("Y-m-d");

                $userAvailable = true;

                // Anslut till databasen
                $db = mysqli_connect($connstring) or die('Fel vid anslutning');
    
                // SQL-fråga för att skriva till databasen
                $sql = "SELECT username FROM users;";
                $result = mysqli_query($db, $sql);
                
                if ($username == "" or $pass == "" or $color == "") {
                    echo '<p class="message">Fill in all fields!</p>';
                }

                // Kollar om användarnamnet är upptaget
                else {
                    while($row = mysqli_fetch_array($result)) {
                        if ($row['username'] == $username) {
                            echo '<p class="message">This username is not available!</p>';
    
                            $userAvailable = false;
                        }
                    }
    
                    if ($userAvailable == true) {
                        $db = mysqli_connect($connstring) or die('Fel vid anslutning');
            
                        $sql = "INSERT INTO users(username, createDate, pass, color) VALUES('$username', '$date', '$pass', '$color');";
                        $result = mysqli_query($db, $sql);
            
                        // Stäng databasanslutningen
                        $db->close();
    
                        $_SESSION['loggedin_user'] = $username;
    
                        header("Location:http://posthouse.one/index.php");
                    }
                }
            }
        }

        static function logIn() {
            if(isset($_POST['username']) && isset($_POST['pass'])) {
                // Läs in inloggningsuppgifter
                $username = $_POST['username'];
                $pass = $_POST['pass'];

                $db = mysqli_connect($connstring) or die('Fel vid anslutning');
        
                // SQL-fråga för att läsa inloggningsuppgifter
                $sql = "SELECT pass FROM users WHERE username = '$username';" or die('Username not found');
                $result = mysqli_query($db, $sql);
                $row = mysqli_fetch_array($result);

                // Kollar att uppgifterna stämmer
                if ($row == null) {
                    echo '<p class="message">User not found!</p>';
                }

                else if ($pass == $row[0]) {
                    $_SESSION['loggedin_user'] = $username;

                    header("Location:http://posthouse.one/index.php");
                }

                else {
                    echo '<p class="message">Incorrect password!</p>';
                }

                $db->close();
            }
        }

        static function getLoggedInUser() {
            if (isset($_SESSION['loggedin_user'])) {
                $db = mysqli_connect($connstring) or die('Fel vid anslutning');

                $username = $_SESSION['loggedin_user'];
            
                // SQL-fråga  för att hämta färg från databasen
                $sql = "SELECT color FROM users WHERE username = '$username';";
                $result = mysqli_query($db, $sql);
                $row = mysqli_fetch_array($result);

                $userColor = $row[0];

                echo '<div><p>Logged in as: <a href="userposts.php?user=' . $username . '" class="username" style="color:' . $userColor . ';">' . $_SESSION['loggedin_user'] . '</a></p></div>';
                
                $db->close();
            }

            else {
                echo '<div><p>Not logged in!</p></div>';
            }
        }

        static function loadUsers() {
            $db = mysqli_connect($connstring) or die('Fel vid anslutning');
            
            // SQL-fråga för att läsa uppgifter från databasen i rätt ordning
            $sql = "SELECT username, color FROM users ORDER BY username;" or die('Username not found');
            $result = mysqli_query($db, $sql);
            
            while ($row = mysqli_fetch_array($result)) {
                echo '<li><a href="userposts.php?user=' . $row['username'] . '" class="username" style="color: ' . $row['color'] . '">' . $row['username'] . '</a></li>';
            }
        }
    }