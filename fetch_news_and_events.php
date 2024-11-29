<?php
// Fetch latest news
include 'admin/database.php';
$news_sql = "SELECT title, content, date FROM news ORDER BY date DESC LIMIT 5";
$news_result = mysqli_query($conn, $news_sql);

// Fetch latest events
$events_sql = "SELECT title, content, date FROM events ORDER BY date DESC LIMIT 5";
$events_result = mysqli_query($conn, $events_sql);

$news_data = [];
$events_data = [];

if ($news_result->num_rows > 0) {
    while($row = $news_result->fetch_assoc()) {
        $news_data[] = $row;
    }
}

if ($events_result->num_rows > 0) {
    while($row = $events_result->fetch_assoc()) {
        $events_data[] = $row;
    }
}

echo json_encode(['news' => $news_data, 'events' => $events_data]);
?>
