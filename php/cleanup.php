<?php
$mysqli->query("DELETE FROM events WHERE end_time < NOW()");
?>