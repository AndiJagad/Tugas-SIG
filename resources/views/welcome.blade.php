<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            flex-direction: column;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Tugas SIG</h1>
    <h2>A. Jagad Miftahul Rizqy</h2>
    <h2>2105541056</h2>
    <div class="button-container">
        <a href="{{ url('/peta') }}">tugas-sig-1</a>
    </div>
</body>
</html>
