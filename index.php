<?php

$imgixBaseUrl = 'https://kaswebtechsolutions.com/imgix-test/uploads/';
// Sample cup and sticker files
$cups = ['Purple.png', 'Green.png', 'Silver.png'];
$stickers = ['monkey.svg', 'random.svg'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cup Customizer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 60px;
            padding: 40px;
            background-color: #f9f9f9;
        }

        .sidebar, .stickers {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .sidebar img, .stickers img {
            width: 100px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        .sidebar img:hover, .stickers img:hover {
            border-color: #333;
        }

        .preview {
            width: 50%;
            text-align: center;
            position: relative;
        }

        .cup-image {
            width: 100%;
            max-width: 300px;
        }

        .sticker-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 151px;
            height: 80px;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .active {
            border-color: #333;
        }
    </style>
</head>
<body>

<!-- LEFT: Cup Options -->
<div class="sidebar">
    <h3>Select Cup</h3>
    <?php foreach ($cups as $cupOption): ?>
        <img src="<?= $imgixBaseUrl . $cupOption ?>" alt="<?= $cupOption ?>" class="cup-option" data-cup="<?= $cupOption ?>">
    <?php endforeach; ?>
</div>

<!-- CENTER: Preview -->
<div class="preview">
    <h3>Preview</h3>
    <img class="cup-image" id="cup-preview" src="<?= $imgixBaseUrl . $cups[0] ?>" alt="Cup">
    <img class="sticker-overlay" id="sticker-preview" src="" alt="Sticker" style="display: none;">
</div>

<!-- RIGHT: Sticker Options -->
<div class="stickers">
    <h3>Select Sticker</h3>
    <?php foreach ($stickers as $stickerOption): ?>
        <img src="<?= $imgixBaseUrl . 'stickers/' . $stickerOption ?>" alt="<?= $stickerOption ?>" class="sticker-option" data-sticker="<?= $stickerOption ?>">
    <?php endforeach; ?>
</div>

<script>
    // Function to update the preview without reloading the page
    function updatePreview(cup, sticker) {
        // Update cup image
        document.getElementById('cup-preview').src = 'https://kaswebtechsolutions.com/imgix-test/uploads/' + cup;
        // If a sticker is selected, display it; otherwise, hide it
        if (sticker) {
            document.getElementById('sticker-preview').src = 'https://kaswebtechsolutions.com/imgix-test/uploads/stickers/' + sticker;
            document.getElementById('sticker-preview').style.display = 'block';
        } else {
            document.getElementById('sticker-preview').style.display = 'none';
        }
    }

    // Event listeners for cup selection
    document.querySelectorAll('.cup-option').forEach(function (img) {
        img.addEventListener('click', function () {
            const cup = this.getAttribute('data-cup');
            const sticker = document.querySelector('.sticker-option.active') ? document.querySelector('.sticker-option.active').getAttribute('data-sticker') : ''; 
            updatePreview(cup, sticker);

          document.querySelectorAll('.cup-option').forEach(function (item) {
                item.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Event listeners for sticker selection
    document.querySelectorAll('.sticker-option').forEach(function (img) {
        img.addEventListener('click', function () {
            const sticker = this.getAttribute('data-sticker');
            const cup = document.querySelector('.cup-option.active') ? document.querySelector('.cup-option.active').getAttribute('data-cup') : 'Purple.png';
            updatePreview(cup, sticker);

            // Set the active state for stickers
            document.querySelectorAll('.sticker-option').forEach(function (item) {
                item.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
</script>
</body>
</html>