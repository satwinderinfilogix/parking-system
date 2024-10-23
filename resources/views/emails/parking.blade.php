<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Parking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            line-height: 1.6;
            color: #555;
        }
        .details {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .details p {
            margin: 5px 0;
        }
        a {
            color: #0066cc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Congratulations!</h2>
        <p>Your parking has been successfully booked.</p>

        <div class="details">
            <h3>Parking Details:</h3>
            <p><strong>Building ID:</strong> {{ $parking->building_id }}</p>
            <p><strong>Unit ID:</strong> {{ $parking->unit_id }}</p>
            <p><strong>Plan:</strong> {{ $parking->plan }}</p>
            <p><strong>Amount:</strong> ${{ $parking->amount }}</p>
            <p><strong>Start Date:</strong> {{ $parking->start_date }}</p>
            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($parking->end_date)->format('Y-m-d') }}</p>
            <p><strong>Car Brand:</strong> {{ $parking->car_brand }}</p>
            <p><strong>Model:</strong> {{ $parking->model }}</p>
            <p><strong>Color:</strong> {{ $parking->color }}</p>
            <p><strong>License Plate:</strong> {{ $parking->license_plate }}</p>
            @if($parking->transaction_id)
                <p><strong>Transaction ID:</strong> {{ $parking->transaction_id }}</p>
            @endif
        </div>

        <p>You can download your invoice by <a href="{{ route('booked-parking', $parking->id) }}">clicking here</a>.</p>
        <p>Thank you!</p>
    </div>
</body>
</html>
