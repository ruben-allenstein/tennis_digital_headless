<?php
require('includes/functions.php');
require('views/header.php');

$message = '';
if (isset($_POST['submit_register'])) {
    $mysql = getMysqlConnection();
    $stmt = $mysql->prepare("SELECT * FROM member_v1 WHERE email = :email");
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count == 0) {
        if ($_POST['pw'] == $_POST['pw2']) {
            User::registerUser($_POST['forename'], $_POST['email'], $_POST['pw'], 0, $_POST['phonenumber']);
            $message = 'Der Account wurde angelegt!';
        } else {
            $message = 'Die Passwörter stimmen nicht überein';
        }
    } else {
        $message = 'Die Email ist bereits vergeben!';
    }
}
?>
    <!-- register Section -->
    <section id="register">
        <div class="login container">
            <div class="login-header">
                <h1 class="section-title"><span>Jetzt</span> Registrieren</h1>
                <div class="card-header">
                    <h2><?php echo $message ?></h2>
                </div>
                <div class="member-bottom">
                    <?php if (!$_POST) { ?>
                        <form action="register.php" method="post">
                            <label for="forename">Vorname</label><br>
                            <input type="text" name="forename" placeholder="Bitte Vornamen eingeben" required><br>
                            <label for="email">Email</label><br>
                            <input type="email" name="email" placeholder="Bitte Email eingeben" required><br>
                            <label for="tel">Telefonnummer</label><br>
                            <input type="tel" minlength="10" title="Die Telefonnummer muss mindestens 10 Zeichen haben" name="phonenumber" pattern="0(17|25)([0-9]{0,})([-]{0,1})([0-9]{4,})"/>

                            <label for="pw">Passwort</label><br>
                            <input type="password" name="pw" placeholder="Gewünschtes Passwort" required><br>
                            <label for="pw">Passwort wiederholen</label><br>
                            <input type="password" name="pw2" placeholder="Password wiederholen" required><br>
                            <button type="submit" name="submit_register" class="register-btn">Registrieren</button>
                        </form>
                    <?php } else {
                        $message = 'Sie haben sich erfolgreich registriert!';
                    } ?>
                    <br>
                </div>
            </div>
        </div>
    </section>
    <!-- END register Section -->
<?php
require('views/footer.php');