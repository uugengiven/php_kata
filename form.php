<?php
declare(strict_types=1);

require_once 'MadlibProcessor.php';
use PhpKata\MadlibProcessor;

// THIS IS VERY UNSAFE. WHY?
$filename = $_GET['file'] ?? '';

if (empty($filename)) {
    header('Location: index.php');
    exit;
}

$processor = new MadlibProcessor();

try {
    // THIS IS VERY UNSAFE. WHY?
    $template = $processor->readFile($filename);
    $placeholders = $processor->extractPlaceholders($template);
} catch (Exception $e) {
    $error = "Error loading madlib: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill in the Madlib</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            text-transform: capitalize;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }
        .submit-btn {
            background: #007bff;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
        .submit-btn:hover {
            background: #0056b3;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
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
        .template-preview {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .template-preview h3 {
            margin-top: 0;
            color: #333;
        }
        .template-text {
            font-style: italic;
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">← Back to Madlib List</a>
        
        <h1>🎭 Fill in the Madlib</h1>

        <?php if (isset($error)): ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php else: ?>
            <form method="POST" action="result.php">
                <!-- THIS IS VERY UNSAFE. WHY? -->
                <input type="hidden" name="filename" value="<?= htmlspecialchars($filename) ?>">
                
                <?php foreach ($placeholders as $index => $placeholder): ?>
                    <div class="form-group">
                        <label for="field_<?= $index ?>">
                            Enter a <?= htmlspecialchars($placeholder) ?>:
                        </label>
                        <input 
                            type="text" 
                            id="field_<?= $index ?>" 
                            name="replacements[<?= $index ?>]" 
                            placeholder="Type your <?= htmlspecialchars($placeholder) ?> here..." 
                            required
                        >
                        <!-- Store the placeholder name for processing -->
                        <input type="hidden" name="placeholders[<?= $index ?>]" value="<?= htmlspecialchars($placeholder) ?>">
                    </div>
                <?php endforeach; ?>

                <?php if (empty($placeholders)): ?>
                    <p>No placeholders found in this template.</p>
                <?php else: ?>
                    <button type="submit" class="submit-btn">
                        🎉 Generate My Madlib!
                    </button>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>