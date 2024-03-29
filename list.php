<?php
include('includes/functions.php');
include('views/header.php');
?>

<!-- list Section -->
<section id="list">
    <div class="list container">
        <div class="list-header">
            <h1 class="section-title"><span>BTV </span>Mitglieder</h1>
            <h2>Mitgliederliste</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Mitgliedsnr</th>
                    <th>Vorname</th>
                    <th>Email</th>
                    <th>Optionen</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $id = $_SESSION['id'];
                if (!isset($_SESSION["email"])) {
                    header("Location: login.php");
                } else {
                    $isTrainer = User::isTrainer($id);
                    if ($isTrainer) {
                        $mysql = getMysqlConnection();
                        $stmt = $mysql->prepare("SELECT * FROM member_v1");
                        $stmt->execute();
                        $stmt->setFetchMode(PDO::FETCH_OBJ);
                        $result = $stmt->fetchAll();
                        if ($result) {
                            foreach ($result as $item) {
                                ?>
                                <tr>
                                    <td><?php echo $item->id; ?></td>
                                    <td><?php echo $item->forename ?></td>
                                    <td><?php echo $item->email ?></td>
                                    <td>
                                        <a href="viewMemberDetails.php?id=<?php echo $item->id ?>"
                                           class="btn">Mitglied anzeigen</a>
                                        <a href="editUserDetails.php?id=<?php echo $item->id ?>"
                                           class="btn">Mitglied bearbeiten</a>
                                    </td>
                                </tr>
                                <?php
                            }

                        } else {
                            ?>
                            <tr>
                                <td>Kein Eintrag gefunden</td>
                            </tr>
                            <?php
                        }
                    } else {
                        header("Location: viewMemberDetails.php?id=$id");
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- End list Section -->

<?php
include('views/footer.php');
?>