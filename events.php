<?php
include("credentials/db.php");
include("templates/header.php");

$stmt = $mysqli->prepare("SELECT * FROM events");
$stmt->execute();
$result = $stmt->get_result();
?>

<body>
    <a href="index.php">home</a>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="event-pannel">
            <h1><?=($row['title'])?></h1>
            <p><?=($row['events_description'])?></p>
        </div>
    <?php endwhile; ?>
</body>

<?php include("templates/footer.php");?>