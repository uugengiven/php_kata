<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madlibs Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome {
            text-align: center;
            margin-bottom: 30px;
            font-size: 18px;
            color: #666;
        }
        .madlib-list {
            list-style: none;
            padding: 0;
        }
        .madlib-list li {
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .madlib-list a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            font-size: 16px;
        }
        .madlib-list a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎭 Welcome to Madlibs Generator! 🎭</h1>
        
        <div class="welcome">
            <p>Choose a madlib template from the list below to get started!</p>
            <p>Fill in the blanks and create your own hilarious stories.</p>
        </div>

        <div class="warning">
            ⚠️ SECURITY WARNING: THIS IS VERY UNSAFE. WHY?
        </div>

        <h2>Available Madlibs:</h2>
        <ul class="madlib-list">
            <li>
                <a href="form.php?file=sample_madlib.txt">📚 The Author's Adventure</a>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">
                    A story about a famous author and their colorful book
                </p>
            </li>
            <li>
                <a href="form.php?file=vacation_madlib.txt">🏖️ Dream Vacation</a>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">
                    Plan your perfect getaway adventure
                </p>
            </li>
            <li>
                <a href="form.php?file=pet_madlib.txt">🐕 My Crazy Pet</a>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">
                    Tell us about your unusual pet's daily routine
                </p>
            </li>
            <li>
                <a href="form.php?file=school_madlib.txt">🎒 School Day Gone Wrong</a>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">
                    A typical day at school that turns into chaos
                </p>
            </li>
        </ul>
    </div>
</body>
</html>