<?php
require_once('/var/www/html/moodle/config.php');
require 'vendor/autoload.php'; // Ensure AWS SDK is installed and this path is correct

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

// Initialize AWS SES client
$client = SesClient::factory(array(
    'version' => 'latest',
    'region'  => 'us-east-1',
    'credentials' => [
        'key'    => 'AKIA2BFSQNJ4XQB7XRE3',  // Replace with your new SMTP username
        'secret' => 'BLDjq8omSHkgg2Phl3rpZ6pyo3E93zofDsaL5NMrpI5w',  // Replace with your new SMTP password
    ],
));

// Collect data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $userEmail = $data['userEmail'];
    $userName = $data['userName'];
    $testResults = $data['testResults']; // Assume this contains test results in a string format

    $params = [
        'Destination' => [
            'ToAddresses' => [$userEmail, 'admin@onecultureworld.com'],
        ],
        'Message' => [
            'Body' => [
                'Text' => [
                    'Charset' => 'UTF-8',
                    'Data' => $testResults,
                ],
            ],
            'Subject' => [
                'Charset' => 'UTF-8',
                'Data' => 'Test Results',
            ],
        ],
        'Source' => 'noreply@onecultureworld.com',
    ];

    try {
        $result = $client->sendEmail($params);
        echo json_encode(['status' => 'success']);
    } catch (AwsException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
?>

