<?php
require_once __DIR__ . '/vendor/autoload.php';
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

//:) yay!!

$links = [
    ['href' => 'leaderboard.php', 'label' => 'leaderboard'],
    ['href' => 'transport.php', 'label' => 'transport'],
    ['href' => 'gym.php', 'label' => 'gym'],
    ['href' => 'clubs.php', 'label' => 'clubs'],
    ['href' => 'events.php', 'label' => 'events'],
];

echo $twig->render('index.twig', [
    'links' => $links
]);
?>