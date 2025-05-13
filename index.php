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
              .main-file-box {
                display: flex;
                gap: 20px;
                width: 70%;
                max-width: 70%;
            }
                  .imgix-baseurl {
                border: 1.9px solid #767474;
                padding: 8px;
            }
             .right-sample-image {
                padding-top: 14px;
            }
                  .right-sample-image h3.sample-image {
                font-weight: 100;
                font-size: 22px;
            }
                  .right_section h3.cup-color {
                margin: 0px 0px 16px;
                font-weight: 100;
                font-size: 22px;
            }
            .preview.center_view {
                width: 100%;
                border: 2px solid #00000078;
            }
            .right_section {
                width: 100%;
                 border: 2px solid #00000078;
                padding: 20px;
            }
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
      .color-circle.active {
    border: 2px solid #333;
}
.sticker-option.active {
    border: 2px solid #333;
}

    </style>
</head>
<body>
<div style="width: 100%; display: flex; justify-content: center; align-items: flex-start; gap: 60px; padding: 40px; font-family: Arial, sans-serif;">
<div class="main-file-box">
        <!-- CENTER: Preview -->
        <div class="preview center_view" style="text-align: center; position: relative;">
            <h3>Preview</h3>
            <img class="cup-image" id="cup-preview" src="<?= $imgixBaseUrl . $cups[0] ?>" alt="Cup" style="width: 300px;">
            <img class="sticker-overlay" id="sticker-preview" src="" alt="Sticker" style="display: none; position: absolute; top: 50%; left: 50%; width: 100px; transform: translate(-50%, -50%); pointer-events: none;">
        </div>
		
      <div class="right_section">
         <!-- LEFT: Cup Colors as Circles -->
        <div>
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
                    <div class="color-circle" data-cup="<?= $cupOption ?>" title="<?= ucfirst($color) ?>" style="width: 30px; height: 30px; border-radius: 50%; background: <?= $colorCode ?>; cursor: pointer; border: 2px solid transparent;"></div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- RIGHT: Sample Images (Stickers) -->
        <div class="right-sample-image">
            <h3 class="sample-image">Sample Images</h3>
            <div class="imgix-option-image" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <?php foreach ($stickers as $stickerOption): ?>
              <div class="imgix-baseurl">
                    <img src="<?= $imgixBaseUrl . 'stickers/' . $stickerOption ?>" alt="<?= $stickerOption ?>" class="sticker-option" data-sticker="<?= $stickerOption ?>" 
                         style="width: 100px; cursor: pointer; border: 2px solid transparent;">
              </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
  </div>
  </div>
    <script>
        function updatePreview(cup, sticker) {
    document.getElementById('cup-preview').src = '<?= $imgixBaseUrl ?>' + cup;
    if (sticker) {
        document.getElementById('sticker-preview').src = '<?= $imgixBaseUrl ?>stickers/' + sticker;
        document.getElementById('sticker-preview').style.display = 'block';
    } else {
        document.getElementById('sticker-preview').style.display = 'none';
    }
}

// Handle cup selection
document.querySelectorAll('.color-circle').forEach(function (circle) {
    circle.addEventListener('click', function () {
        const cup = this.getAttribute('data-cup');
        const activeSticker = document.querySelector('.sticker-option.active');
        const sticker = activeSticker ? activeSticker.getAttribute('data-sticker') : '';
        updatePreview(cup, sticker);

        // Remove .active from all cups
        document.querySelectorAll('.color-circle').forEach(el => el.classList.remove('active'));
        // Add .active to current cup
        this.classList.add('active');
    });
});

// Handle sticker selection
document.querySelectorAll('.sticker-option').forEach(function (img) {
    img.addEventListener('click', function () {
        const sticker = this.getAttribute('data-sticker');
        const activeCup = document.querySelector('.color-circle.active');
        const cup = activeCup ? activeCup.getAttribute('data-cup') : 'Purple.png';
        updatePreview(cup, sticker);

        document.querySelectorAll('.sticker-option').forEach(el => el.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
</body>
</html>
