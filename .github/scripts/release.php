<?php

// Create API URL
$packagist_username = getenv('PACKAGIST_USERNAME');
$packaigst_api_token = getenv('PACKAGIST_API_TOKEN');

// Encode API data
$github_context = getenv('GITHUB_CONTEXT');
$github = json_decode(getenv('GITHUB_CONTEXT'), true);

// Run Packagist update
try {
    // Check if package exists
    $packages = json_decode(file_get_contents("https://packagist.org/packages/list.json?vendor={$github['repository_owner']}"), true);
    if (in_array($github['repository'], $packages['packageNames'])) {
        // Package exists, update existing package
        $packagist_url = "https://packagist.org/api/update-package?username={$packagist_username}&apiToken={$packaigst_api_token}";
        $data = json_encode(['repository' => ['url' => "https://packagist.org/packages/{$github['repository']}"]]);
    } else {
        // Package doesn't exist, create new package
        $packagist_url = "https://packagist.org/api/create-package?username={$packagist_username}&apiToken={$packaigst_api_token}";
        $data = json_encode(['repository' => ['url' => "https://github.com/{$github['repository']}"]]);
    }

    // Setup headers
    $headers = [
        "Content-Type: application/json",
        "Content-Length: " . strlen($data)
    ];

    // Call Packagist API
    $response = fetch('POST', $packagist_url, $data, $headers);
    echo $response;
    exit(0);
} catch (RuntimeException $e) {
    echo $e;
    exit(1);
}

/**
 * Simple PHP Fetch command
 *
 * @param string $method
 * @param string $url
 * @param string $body
 * @param array $headers
 * @return void
 */
function fetch(string $method, string $url, string $body, array $headers = []) {
    $context = stream_context_create([
        "http" => [
            // http://docs.php.net/manual/en/context.http.php
            "method"        => $method,
            "header"        => implode("\r\n", $headers),
            "content"       => $body,
            "ignore_errors" => true,
        ],
    ]);

    $response = file_get_contents($url, false, $context);

    /**
     * @var array $http_response_header materializes out of thin air
     */

    $status_line = $http_response_header[0];

    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

    $status = $match[1];

    if ($status > "400") {
        throw new RuntimeException("unexpected response status: {$status_line}\n" . $response);
    }

    return $response;
}