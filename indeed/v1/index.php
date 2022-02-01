<?php
include_once "functions.php";
include_once "models.php";

$token = 'tjFdAvWnchXWaAkH5J74BMjKMu8wdu';
$access_token = get('access_token');
$items = [];
if ($access_token == $token) {
    $query = get('q');
    $location = get('location');
    $start = intval(get('start'));
    $limit = intval(get('limit'));
    $base_url = 'https://www.indeed.com';
    $url = $base_url . '/jobs?q=' . urlencode($query) . '&limit=' . $limit . '&start=' . $start . '&l=' . urlencode($location);

    $response = response($url);
    $data = get_string_between($response, 'id="mosaic-provider-jobcards"', 'id="toast"');

    $results = explode('<a id="', $data);

    foreach ($results as $res) {
        $job = new Job($res);
        if ($job->title)
            $items[] = $job;
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($items);
