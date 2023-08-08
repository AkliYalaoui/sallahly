<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="description" content="Sallahly is a platform for the most skilled people in the field of repairing electronic things ." />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./assets/sallahly.png" />
    <link rel=" stylesheet" href="../src/css/styles.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <title>Sallahly.dz | Centre des messages</title>
</head>

<?php
include "../server/config.php";
session_start();
if (isset($_SESSION['user_id']) == "") {
    header("Location: login.php");
}
?>

<body>
    <!-- main container -->
    <div class="w-full h-full overflow-auto">
        <!-- header -->
        <?php include "header.php" ?>
        <!-- main container messageries -->
        <section class="w-full h-full container mx-auto p-4">
            <h1 class="text-[25px] font-bold text-center my-4">Centre des messages</h1>
            <?php
            $user_id = $_SESSION["user_id"];
            $GetAllmessage = "SELECT * FROM messageries WHERE user_id='$user_id'";
            $allmessage = $conn->query($GetAllmessage);
            if ($allmessage->num_rows > 0) {
                $message = mysqli_fetch_all($allmessage, MYSQLI_ASSOC);
                foreach ($message as $message) {
            ?>
                    <article style="background-color: #fff; border-radius: 5px; padding: 20px; margin: 20px auto; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); max-width: 900px;">
                        <h3 style="margin: 0; font-size: 24px; color: #333;"><b>Sujet : </b> <?= $message['subject']; ?></h3>
                        <h4 style="margin-top: 10px; font-size: 18px; color: #666;"> <?= $message['message']; ?></h4>
                        <time style="margin-top: 5px; display: block; font-size: 14px; color: #999; text-align: right;" datetime="<?= $message['sent_at']; ?>"><?= $message['sent_at']; ?></time>
                    </article>
            <?php
                }
            } else {
                echo "<p>No messages found.</p>";
            }
            ?>
        </section>

    </div>
    <?php include "footer.php" ?>
</body>
<script type="text/javascript" src='../src/js/index.js'>
</script>

</html>