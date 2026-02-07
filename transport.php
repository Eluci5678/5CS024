<?php
include("credentials/db.php");
include("templates/header.php");

$stmt = $mysqli->prepare("SELECT * FROM transit_info");
$stmt->execute();
$result = $stmt->get_result();
?>

<body>
    <a href="index.php">home</a>

    <table>
        <tr>
            <th>Route Name</th>
            <th>Type</th>
            <th>Schedule</th>
            <th>Last Updated</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?=($row['route_name'])?></td>
                <td><?=($row['transport_type'])?></td>
                <td><?=($row['schedule'])?></td>
                <td><?=($row['last_updated'])?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

<?php include("templates/footer.php"); ?>
