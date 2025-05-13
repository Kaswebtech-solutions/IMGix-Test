<?php
$imgixBaseUrl = 'https://kas-webtech-71.imgix.net/uploads/';
$cups = ['Purple.png', 'Green.png', 'Silver.png'];
$stickers = ['lion.jpg', 'monkey.jpg'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cup Customizer (with Imgix Blend)</title>
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

        .main-file-box {
            display: flex;
            gap: 20px;
            width: 70%;
            max-width: 70%;
        }

        .preview {
            width: 50%;
            text-align: center;
            position: relative;
            border: 2px solid #00000078;
            padding: 10px;
        }

        .cup-image {
            width: 100%;
            max-width: 300px;
        }

        .right_section {
            width: 100%;
            border: 2px solid #00000078;
            padding: 20px;
        }

        .color-circle, .sticker-option {
            cursor: pointer;
            border: 2px solid transparent;
        }

        .color-circle.active, .sticker-option.active {
            border: 2px solid #333;
        }

        .color-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }

        .right-sample-image img {
            width: 100px;
        }

        .imgix-baseurl {
            border: 1.9px solid #767474;
            padding: 8px;
        }
    </style>
</head>
<body>
<div class="main-file-box">
    <!-- Preview Section -->
    <div class="preview">
        <h3>Preview</h3>
        <img class="cup-image" id="cup-preview" src="<?= $imgixBaseUrl . $cups[0] ?>" alt="Cup with Sticker">
    </div>

    <!-- Controls -->
    <div class="right_section">
        <h3 class="cup-color">Cup Color</h3>
        <div style="display: flex; gap: 12px;">
            <?php foreach ($cups as $cupOption):
                $color = strtolower(pathinfo($cupOption, PATHINFO_FILENAME));
                $colorCode = match($color) {
                    'purple' => '#343a96',
                    'green' => '#2e6e43',
                    'silver' => '#c0c0c0',
                    default => '#ccc'
                };
            ?>
                <div class="color-circle" data-cup="<?= $cupOption ?>" style="background: <?= $colorCode ?>;" title="<?= ucfirst($color) ?>"></div>
            <?php endforeach; ?>
        </div>

        <div class="right-sample-image" style="margin-top: 20px;">
            <h3 class="sample-image">Sample Stickers</h3>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <?php foreach ($stickers as $sticker): ?>
                    <div class="imgix-baseurl">
                        <img src="<?= $imgixBaseUrl . 'stickers/' . $sticker ?>" class="sticker-option" data-sticker="<?= $sticker ?>" alt="<?= $sticker ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    const imgixBase = '<?= $imgixBaseUrl ?>';

    function updatePreview(cup, sticker) {
        const cupUrl = imgixBase + cup;
        let finalUrl = cupUrl;

        if (sticker) {
            const blendParams = new URLSearchParams({
                blend: imgixBase + 'stickers/' + sticker,
                'blend-mode': 'normal',
                'blend-align': 'middle,center',
                'blend-width': 120,
                'blend-height': 80,
                'blend-alpha': 100
            });
            finalUrl += '?' + blendParams.toString();
        }

        document.getElementById('cup-preview').src = finalUrl;
    }

    // Cup selection
    document.querySelectorAll('.color-circle').forEach(circle => {
        circle.addEventListener('click', () => {
            const cup = circle.dataset.cup;
            const activeSticker = document.querySelector('.sticker-option.active');
            const sticker = activeSticker ? activeSticker.dataset.sticker : '';

            updatePreview(cup, sticker);

            document.querySelectorAll('.color-circle').forEach(el => el.classList.remove('active'));
            circle.classList.add('active');
        });
    });

    // Sticker selection
    document.querySelectorAll('.sticker-option').forEach(stickerEl => {
        stickerEl.addEventListener('click', () => {
            const sticker = stickerEl.dataset.sticker;
            const activeCup = document.querySelector('.color-circle.active');
            const cup = activeCup ? activeCup.dataset.cup : 'Purple.png';

            updatePreview(cup, sticker);

            document.querySelectorAll('.sticker-option').forEach(el => el.classList.remove('active'));
            stickerEl.classList.add('active');
        });
    });

    // Initial load
    document.querySelector('.color-circle').classList.add('active');
    updatePreview('<?= $cups[0] ?>', '');
</script>
</body>
</html>
