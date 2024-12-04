<?php

function fetchImages($query, $page = 1) {
    $url = 'https://pixabay.com/api/';
    $api = '47436418-0f37c345f9abf9796a58e8a65';

    $params = [
        'q' => urlencode($query),
        'key' => $api,
        'page' => $page,
        'per_page' => 20,
    ];

    // Build the URL with query parameters
    $url = $url . '?' . http_build_query($params);

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return ['error' => curl_error($ch)];
    }

    curl_close($ch);

    // Return the decoded JSON response
    return json_decode($response, true);
}

function fetchVideos($query, $page = 1) {
    $url = 'https://pixabay.com/api/videos/';
    $api = '47436418-0f37c345f9abf9796a58e8a65';

    $params = [
        'q' => urlencode($query),
        'key' => $api,
        'page' => $page,
        'per_page' => 20,
    ];

    // Build the URL with query parameters
    $url = $url . '?' . http_build_query($params);

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return ['error' => curl_error($ch)];
    }

    curl_close($ch);

    // Return the decoded JSON response
    return json_decode($response, true);
}

// Custom API logic
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = isset($_GET['query']) ? $_GET['query'] : '';
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    if($type == 'photo'){
        $images = fetchImages($query, $page);
    }else if($type == 'video'){
        $images = fetchVideos($query, $page);
    }else{
        $images = '';
    }

    // Fetch images from Pixabay

    // Set response headers
    header('Content-Type: application/json');
    echo json_encode($images);
    exit;
}

?>
