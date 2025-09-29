<?php
declare(strict_types=1);

require_once 'MadlibProcessor.php';
use PhpKata\MadlibProcessor;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// THIS IS VERY UNSAFE. WHY?
$filename = $_POST['filename'] ?? '';
$replacements = $_POST['replacements'] ?? [];
$placeholders = $_POST['placeholders'] ?? [];

if (empty($filename) || empty($replacements) || empty($placeholders)) {
    header('Location: index.php');
    exit;
}

$processor = new MadlibProcessor();

try {
    // THIS IS VERY UNSAFE. WHY?
    $template = $processor->readFile($filename);
    
    // Build replacement tuples from form data
    $replacementTuples = [];
    foreach ($placeholders as $index => $placeholder) {
        if (isset($replacements[$index]) && !empty(trim($replacements[$index]))) {
            $replacementTuples[] = [$placeholder, trim($replacements[$index])];
        }
    }
    
    // Generate the final madlib
    $result = $processor->replacePlaceholders($template, $replacementTuples);
    
} catch (Exception $e) {
    $error = "Error processing madlib: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Madlib Result</title>
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
        .result-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border: 2px solid #28a745;
            margin: 30px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .madlib-text {
            font-size: 20px;
            line-height: 1.8;
            color: #333;
            text-align: justify;
        }
        .actions {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
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
        .summary {
            background: #e2e3e5;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .summary h3 {
            margin-top: 0;
        }
        .replacement-item {
            margin: 5px 0;
            font-family: monospace;
        }
        .celebration {
            text-align: center;
            font-size: 48px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎉 Your Completed Madlib! 🎉</h1>

        <div class="warning">
            ⚠️ SECURITY WARNING: THIS IS VERY UNSAFE. WHY?
        </div>

        <?php if (isset($error)): ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php else: ?>
            <div class="celebration">🎭✨🎊</div>
            
            <div class="result-box">
                <div class="madlib-text">
                    <?= nl2br(htmlspecialchars($result)) ?>
                </div>
            </div>

            <div class="summary">
                <h3>Your Replacements:</h3>
                <?php foreach ($replacementTuples as $tuple): ?>
                    <div class="replacement-item">
                        <strong><?= htmlspecialchars($tuple[0]) ?></strong> → <?= htmlspecialchars($tuple[1]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="actions">
            <a href="form.php?file=<?= urlencode($filename) ?>" class="btn btn-primary">
                🔄 Try Again
            </a>
            <a href="index.php" class="btn btn-secondary">
                📝 Choose Different Madlib
            </a>
        </div>
    </div>
</body>
</html>