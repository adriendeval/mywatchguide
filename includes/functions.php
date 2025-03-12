<?php
session_start();

function searchContentTMDB($query) {
    $apiKey = '111c88a4bbb837b13e8e1491e3ac603a';
    $url = "https://api.themoviedb.org/3/search/multi?api_key=$apiKey&query=" . urlencode($query);

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    return $data['results'];
}

function getFavorites() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT c.* FROM content c JOIN favorites f ON c.id = f.content_id WHERE f.user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addToFavorites($contentId) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO favorites (content_id, user_id) VALUES (?, ?)");
    $stmt->execute([$contentId, $_SESSION['user_id']]);
}

function removeFromFavorites($contentId) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM favorites WHERE content_id = ? AND user_id = ?");
    $stmt->execute([$contentId, $_SESSION['user_id']]);
}

function getWatchlist() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT c.* FROM content c JOIN watchlist w ON c.id = w.content_id WHERE w.user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addToWatchlist($contentId) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO watchlist (content_id, user_id) VALUES (?, ?)");
    $stmt->execute([$contentId, $_SESSION['user_id']]);
}

function removeFromWatchlist($contentId) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM watchlist WHERE content_id = ? AND user_id = ?");
    $stmt->execute([$contentId, $_SESSION['user_id']]);
}

function getViewed() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT c.* FROM content c JOIN viewed v ON c.id = v.content_id WHERE v.user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addToViewed($contentId) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO viewed (content_id, user_id) VALUES (?, ?)");
    $stmt->execute([$contentId, $_SESSION['user_id']]);
}

function removeFromViewed($contentId) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM viewed WHERE content_id = ? AND user_id = ?");
    $stmt->execute([$contentId, $_SESSION['user_id']]);
}

function rateContent($id, $rating) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE content SET rating = ? WHERE id = ?");
    $stmt->execute([$rating, $id]);
}

function registerUser($username, $password, $email) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, $email]);
}

function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logout() {
    session_destroy();
}
?>