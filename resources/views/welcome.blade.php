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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #007BFF, #6C757D);
            color: #fff;
            text-align: center;
            flex-direction: column;
            box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 3rem;
            margin: 0;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        h2 {
            margin: 10px 0;
            font-size: 1.5rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .button-container {
            margin-top: 30px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .button-container a {
            display: inline-block;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: bold;
            background-color: #FFC107;
            color: #212529;
            text-decoration: none;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .button-container a:hover {
            background-color: #E0A800;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            transform: translateY(-3px);
        }

        .button-container a:active {
            transform: translateY(0);
            box-shadow: 0 3px 7px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <h1>Tugas SIG</h1>
    <h2>A. Jagad Miftahul Rizqy</h2>
    <h2>2105541056</h2>
    <div class="button-container">
        <a href="{{ url('/peta') }}">Tugas SIG 1</a>
        <a href="{{ url('/interactive') }}">Tugas SIG 2</a>
        <a href="{{ url('/handson3') }}">Tugas SIG 3</a>
        <a href="{{ url('/jarak') }}">Tugas SIG 4</a>
    </div>
</body>
</html>
