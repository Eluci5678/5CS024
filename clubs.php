<?php
include("credentials/db.php");
include("templates/header.php");

$stmt = $mysqli->prepare("SELECT * FROM clubs");
$stmt->execute();
$result = $stmt->get_result();
?>

<body>
    <a href="index.php">home</a>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="club-pannel">
            <h1><?=($row['club_name'])?></h1>
            <p><?=($row['description'])?></p>
        </div>
    <?php endwhile; ?>
</body>

<?php include("templates/footer.php");?>