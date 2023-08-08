<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="description" content="Sallahly is a platform for the most skilled people in the field of repairing electronic things ." />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../assets/sallahly.png" />
    <link rel=" stylesheet" href="../../src/css/styles.css" />
    <link rel="stylesheet" href="../../dist/output.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Sallahly.dz | Dashboard Administrateur</title>
</head>

<?php
include "../../server/config.php";
session_start();
if (isset($_SESSION['admin_id']) == "") {
    if (isset($_SESSION['admin_role']) == "admin") {
        header("Location: admin-dashboard.php");
    } else {
        header("Location: admin-login.php");
    }
}

$GetAllUser = "SELECT * FROM users";
$allUser = $conn->query($GetAllUser);
$numberUsers = mysqli_num_rows($allUser);

$GetAllCategories = "SELECT * FROM categories ";
$allCategories = $conn->query($GetAllCategories);
$numberCategories = mysqli_num_rows($allCategories);

$GetAllCmdRepear = "SELECT * FROM reparations ";
$allCmdRepear = $conn->query($GetAllCmdRepear);
$numberCmdRepear = mysqli_num_rows($allCmdRepear);

$GetAllmessages = "SELECT * FROM messageries ";
$allmessages = $conn->query($GetAllmessages);
$numbermessages = mysqli_num_rows($allmessages);

?>

<body>
    <div class="w-full h-full m-0 p-0 relative">

        <!-- header -->
        <?php include "admin-header.php" ?>

        <?php include "notification.php" ?>
        <!-- main container Home page-->
        <div class="w-full h-full flex">
            <?php include "sidebar.php" ?>

            <div class="w-full min-h-[calc(100%-62px)] flex-1 ml-[90px] p-10">
                <div class="p-4 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8  flex flex-wrap items-center justify-center gap-5">
                    <div class="kpi-card" style="background-color: #333; padding: 20px; border-radius: 5px; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); width: 400px;">
                        <div style="display: flex; align-items: center; gap: 2; color: #fff;">
                            <h3 style="font-size: 20px; font-weight: bold;"><?= $numberUsers; ?></h3>
                        </div>
                        <p style="font-size: 14px; color: #eee;">Utilisateurs</p>
                    </div>
                    <div class="kpi-card" style="background-color: #333; padding: 20px; border-radius: 5px; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); width: 400px;">
                        <div style="display: flex; align-items: center; gap: 2; color: #fff;">
                            <h3 style="font-size: 20px; font-weight: bold;"><?= $numberCategories; ?></h3>
                        </div>
                        <p style="font-size: 14px; color: #eee;">Catégories</p>
                    </div>
                    <div class="kpi-card" style="background-color: #333; padding: 20px; border-radius: 5px; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); width: 400px;">
                        <div style="display: flex; align-items: center; gap: 2; color: #fff;">
                            <h3 style="font-size: 20px; font-weight: bold;"><?= $numberCmdRepear; ?></h3>
                        </div>
                        <p style="font-size: 14px; color: #eee;">Commande réparations</p>
                    </div>
                    <div class="kpi-card" style="background-color: #333; padding: 20px; border-radius: 5px; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); width: 400px;">
                        <div style="display: flex; align-items: center; gap: 2; color: #fff;">
                            <h3 style="font-size: 20px; font-weight: bold;"><?= $numbermessages; ?></h3>
                        </div>
                        <p style="font-size: 14px; color: #eee;">Utilisateurs Messages</p>
                    </div>
                </div>
                <div class="mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20 flex flex-wrap items-center justify-center gap-5">
                    <canvas id="barChart" width="400" height="200"></canvas>

                </div>
            </div>
        </div>
    </div>
    <?php
    // Sample data
    $labels = ['Admin', 'Client', 'Tech - Diplomé', 'Tech - Non Diplomé'];
    $GetAllUser = "SELECT role, COUNT(*) as count FROM `users` group BY role;";
    $allUser = $conn->query($GetAllUser);
    $data = [0, 0, 0, 0];

    if ($allUser->num_rows > 0) {
        while ($row = $allUser->fetch_assoc()) {
            switch ($row["role"]) {
                case "admin":
                    $data[0] = $row["count"];
                    break;
                case "user";
                    $data[1] = $row["count"];
                    break;
                case "graduated";
                    $data[2] = $row["count"];
                    break;
                case "non-graduated";
                    $data[3] = $row["count"];
                    break;
            }
        }
    }
    ?>

    <script>
        // Data generated in PHP
        var labels = <?php echo json_encode($labels); ?>;
        var data = <?php echo json_encode($data); ?>;

        // Get canvas element
        var ctx = document.getElementById('barChart').getContext('2d');

        // Create bar chart
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Type d'utilisateur",
                    data: data,
                    backgroundColor: 'rgb(69, 39, 160)',
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


</body>
<script type=" text/javascript" src="../../src/js/index.js"></script>

</html>