<?php
include("credentials/db.php");
include("templates/header.php");

$stmt = $mysqli->prepare("
    SELECT 
        u.user_id,
        u.name,
        COALESCE(SUM(a.attendance_status), 0) AS attendance_score
    FROM users u
    LEFT JOIN attendance_records a
        ON a.user_id = u.user_id
    GROUP BY u.user_id, u.name
    ORDER BY attendance_score DESC, u.name ASC
");

$stmt->execute();
$result = $stmt->get_result();
?>

<body>
    <a href="index.php">home</a>

    <table>
        <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>Attendance</th>
        </tr>

        <?php
        $rank = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$rank}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['attendance_score']}</td>";
            echo "</tr>";
            $rank++;
        }
        ?>
    </table>
</body>

<?php include("templates/footer.php"); ?>
