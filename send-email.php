<?php

// Security: Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Direct access not allowed');
}

// Capture form data
$userName    = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
$userPhone   = filter_var($_POST['number'], FILTER_SANITIZE_SPECIAL_CHARS);
$userMessage = filter_var($_POST['message'], FILTER_SANITIZE_SPECIAL_CHARS);

// 2. Prepare the MSG91 Payload
$data = [
    "recipients" => [
        [
            "to" => [
                [
                    "email" => "mahadevfoods1998@gmail.com",
                    "name"  => "Mahadev Foods"
                ],
                [
                    "email" => "visheshkingrani999@gmail.com",
                    "name"  => "Vishesh Kingrani"
                ]
            ],
            "variables" => [
                "FullName"         => $userName,    
                "PhoneNumber"        => $userPhone,
                "Message"      => $userMessage
            ]
        ]
    ],
    "from" => [
        "email" => "no-reply@bhaupoha.com"
    ],
    "domain"      => "bhaupoha.com",
    "template_id" => "bhaupoha_website_contact_1"
];

// 3. Initialize cURL
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://control.msg91.com/api/v5/email/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($data), // Automatically formats the array to JSON
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json',
        'authkey: 508817AgTk7htjFQ6a1006dfP1',
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

// 4. Return response to your Frontend
header('Content-Type: application/json');
if ($err) {
    echo json_encode(["status" => "error", "message" => $err]);
} else {
    echo $response;
}
?>
