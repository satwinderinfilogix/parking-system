<!-- resources/views/privacy_policy.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .privacy-policy-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .policy-content {
            margin-top: 20px;
            line-height: 1.6;
        }
        .update-button {
            display: block;
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }
        .update-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="privacy-policy-container">
    <h2>Privacy Policy</h2>
    <div class="policy-content">
        {!! $content !!}
    </div>
</div>

</body>
</html>