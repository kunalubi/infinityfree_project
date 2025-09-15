<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K&S Tools - Color Palette Generator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .cpg-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .cpg-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .company-logo {
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            font-weight: bold;
            color: #3B82F6;
        }

        .company-logo span {
            font-size: 1.8rem;
            margin-right: 5px;
        }

        .cpg-header h1 {
            font-size: 2.5rem;
            background: linear-gradient(45deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .cpg-header p {
            color: #666;
        }

        .controls {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .control-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .control-group label {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }

        select, input[type="color"] {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        select:focus, input[type="color"]:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        input[type="color"] {
            width: 60px;
            height: 45px;
            border-radius: 10px;
            cursor: pointer;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #3B82F6, #8B5CF6);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #333;
            border: 2px solid #e0e0e0;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-1px);
        }

        .palettes-container {
            display: grid;
            gap: 20px;
        }

        .cpg-palette {
            display: flex;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .cpg-palette:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .cpg-color-swatch {
            flex: 1;
            height: 150px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cpg-color-swatch:hover {
            transform: scale(1.05);
            z-index: 10;
        }

        .color-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 500;
            transform: translateY(100%);
            transition: all 0.3s ease;
        }

        .cpg-color-swatch:hover .color-info {
            transform: translateY(0);
        }

        .color-formats {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px;
            font-size: 0.8rem;
            transform: translateY(-100%);
            transition: all 0.3s ease;
            display: none;
        }

        .cpg-color-swatch:hover .color-formats {
            display: block;
            transform: translateY(0);
        }

        .format-option {
            cursor: pointer;
            padding: 2px 5px;
            border-radius: 3px;
            margin: 2px;
            display: inline-block;
        }

        .format-option:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .lock-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
        }

        .cpg-color-swatch:hover .lock-icon {
            opacity: 1;
        }

        .lock-icon.locked {
            background: #ffd700;
            opacity: 1;
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #ff6b6b;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .favorite-btn:hover {
            transform: scale(1.2);
        }

        .favorite-btn.active {
            color: #ff4757;
        }

        .copy-feedback {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4CAF50;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .copy-feedback.show {
            transform: translateX(0);
        }

        .export-options {
            margin-top: 20px;
            text-align: center;
        }

        .export-btn {
            margin: 0 5px;
            padding: 8px 16px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s ease;
        }

        .export-btn:hover {
            background: #5a6268;
        }

        .contrast-indicator {
            position: absolute;
            bottom: 40px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.8rem;
            font-weight: bold;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .palette-name {
            position: absolute;
            top: -25px;
            left: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #555;
        }

        .palette-name-input {
            background: transparent;
            border: none;
            border-bottom: 1px dashed #999;
            font-size: 0.9rem;
            padding: 2px 5px;
            width: 150px;
        }

        .palette-name-input:focus {
            outline: none;
            border-bottom: 2px solid #3B82F6;
        }

        @media (max-width: 768px) {
            .cpg-container {
                padding: 20px;
            }

            .company-logo {
                position: static;
                justify-content: center;
                margin-bottom: 10px;
            }

            .cpg-header h1 {
                font-size: 2rem;
            }

            .controls {
                flex-direction: column;
                align-items: center;
            }

            .cpg-color-swatch {
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="cpg-container" style="margin-top: 80px;">
        <div class="cpg-header">
            <div class="company-logo">
                <span>🔧</span>
                <span>K&S Tools</span>
            </div>
            <h1 class="title-font" style="background: linear-gradient(45deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                🎨 Color Palette Generator
            </h1>
            <p class="lead text-secondary">Create beautiful color combinations for your projects</p>
        </div>

        <div class="controls">
            <div class="control-group">
                <label for="paletteType">Palette Type</label>
                <select id="paletteType" class="form-select">
                    <option value="random">Random</option>
                    <option value="monochromatic">Monochromatic</option>
                    <option value="analogous">Analogous</option>
                    <option value="complementary">Complementary</option>
                    <option value="triadic">Triadic</option>
                    <option value="tetradic">Tetradic</option>
                    <option value="shades">Shades</option>
                    <option value="pastel">Pastel</option>
                </select>
            </div>
            <div class="control-group">
                <label for="baseColor">Base Color</label>
                <input type="color" id="baseColor" class="form-control form-control-color" value="#3B82F6" title="Choose your color">
            </div>
            <div class="control-group">
                <label for="paletteCount">Palettes</label>
                <select id="paletteCount" class="form-select">
                    <option value="1">1</option>
                    <option value="3" selected>3</option>
                    <option value="5">5</option>
                    <option value="8">8</option>
                </select>
            </div>
            <div class="control-group">
                <label for="colorCount">Colors per Palette</label>
                <select id="colorCount" class="form-select">
                    <option value="3">3</option>
                    <option value="5" selected>5</option>
                    <option value="8">8</option>
                    <option value="10">10</option>
                </select>
            </div>
        </div>

        <div class="action-buttons">
            <button class="btn btn-primary" onclick="generatePalettes()">
                <span>🎲</span> Generate New Palettes
            </button>
            <button class="btn btn-outline-primary" onclick="copyAllPalettes()">
                <span>📋</span> Copy All Colors
            </button>
            <button class="btn btn-outline-primary" onclick="savePalettes()">
                <span>💾</span> Save Palettes
            </button>
            <button class="btn btn-outline-primary" onclick="loadPalettes()">
                <span>📂</span> Load Palettes
            </button>
        </div>

        <div id="palettesContainer" class="row g-4">
            <!-- Palettes will be generated here -->
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-secondary me-2" onclick="downloadCSS()">Download CSS</button>
            <button class="btn btn-secondary me-2" onclick="downloadSCSS()">Download SCSS</button>
            <button class="btn btn-secondary me-2" onclick="downloadJSON()">Download JSON</button>
            <button class="btn btn-secondary me-2" onclick="downloadASE()">Download ASE</button>
            <button class="btn btn-secondary" onclick="downloadPDF()">Download PDF</button>
        </div>
    </div>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div id="copyFeedback" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
            <div class="d-flex">
                <div class="toast-body">
                    Color copied to clipboard!
                </div>
            </div>
        </div>
    </div>

    <script>
        var palettes = [];
        var paletteNames = [];
        var lockedColors = new Set();
        var favorites = new Set();

        // Initialize with default palettes
        document.addEventListener('DOMContentLoaded', function() {
            generatePalettes();
            
            // Load saved palettes if available
            if (localStorage.getItem('ksColorPalettes')) {
                loadPalettes();
            }
        });

        // Color utility functions
        function generateRandomColor() {
            return '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0');
        }

        function hexToRgb(hex) {
            var r = parseInt(hex.slice(1, 3), 16);
            var g = parseInt(hex.slice(3, 5), 16);
            var b = parseInt(hex.slice(5, 7), 16);
            return { r, g, b };
        }

        function rgbToHex(r, g, b) {
            return '#' + [r, g, b].map(x => x.toString(16).padStart(2, '0')).join('');
        }

        function hexToHsl(hex) {
            var r = parseInt(hex.slice(1, 3), 16) / 255;
            var g = parseInt(hex.slice(3, 5), 16) / 255;
            var b = parseInt(hex.slice(5, 7), 16) / 255;

            var max = Math.max(r, g, b);
            var min = Math.min(r, g, b);
            var h, s, l = (max + min) / 2;

            if (max === min) {
                h = s = 0;
            } else {
                var d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                switch (max) {
                    case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                    case g: h = (b - r) / d + 2; break;
                    case b: h = (r - g) / d + 4; break;
                }
                h /= 6;
            }

            return [h * 360, s * 100, l * 100];
        }

        function hslToHex(h, s, l) {
            h /= 360;
            s /= 100;
            l /= 100;

            var c = (1 - Math.abs(2 * l - 1)) * s;
            var x = c * (1 - Math.abs((h * 6) % 2 - 1));
            var m = l - c/2;
            var r = 0, g = 0, b = 0;

            if (0 <= h && h < 1/6) {
                r = c; g = x; b = 0;
            } else if (1/6 <= h && h < 1/3) {
                r = x; g = c; b = 0;
            } else if (1/3 <= h && h < 1/2) {
                r = 0; g = c; b = x;
            } else if (1/2 <= h && h < 2/3) {
                r = 0; g = x; b = c;
            } else if (2/3 <= h && h < 5/6) {
                r = x; g = 0; b = c;
            } else if (5/6 <= h && h < 1) {
                r = c; g = 0; b = x;
            }

            r = Math.round((r + m) * 255);
            g = Math.round((g + m) * 255);
            b = Math.round((b + m) * 255);

            return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
        }

        function getContrastColor(hex) {
            const rgb = hexToRgb(hex);
            const brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
            return brightness > 128 ? '#000000' : '#FFFFFF';
        }

        function getColorFormats(color) {
            const rgb = hexToRgb(color);
            const hsl = hexToHsl(color);
            
            return {
                hex: color.toUpperCase(),
                rgb: `rgb(${rgb.r}, ${rgb.g}, ${rgb.b})`,
                rgba: `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 1)`,
                hsl: `hsl(${Math.round(hsl[0])}, ${Math.round(hsl[1])}%, ${Math.round(hsl[2])}%)`,
                hsla: `hsla(${Math.round(hsl[0])}, ${Math.round(hsl[1])}%, ${Math.round(hsl[2])}%, 1)`,
                cmyk: rgbToCmyk(rgb.r, rgb.g, rgb.b)
            };
        }

        function rgbToCmyk(r, g, b) {
            if (r === 0 && g === 0 && b === 0) return 'cmyk(0%, 0%, 0%, 100%)';
            
            r = r / 255;
            g = g / 255;
            b = b / 255;
            
            let k = 1 - Math.max(r, g, b);
            let c = (1 - r - k) / (1 - k);
            let m = (1 - g - k) / (1 - k);
            let y = (1 - b - k) / (1 - k);
            
            c = Math.round(c * 100);
            m = Math.round(m * 100);
            y = Math.round(y * 100);
            k = Math.round(k * 100);
            
            return `cmyk(${c}%, ${m}%, ${y}%, ${k}%)`;
        }

        function generatePalette(type, baseColor, colorCount) {
            var hsl = hexToHsl(baseColor);
            var h = hsl[0], s = hsl[1], l = hsl[2];
            var colors = [];

            switch (type) {
                case 'monochromatic':
                    for (var i = 0; i < colorCount; i++) {
                        colors.push(hslToHex(h, s, Math.max(10, Math.min(90, l + (i - Math.floor(colorCount/2)) * (80/colorCount)))));
                    }
                    break;
                case 'analogous':
                    for (var i = 0; i < colorCount; i++) {
                        colors.push(hslToHex((h + i * 30 - (colorCount-1)*15) % 360, s, l));
                    }
                    break;
                case 'complementary':
                    colors.push(baseColor);
                    colors.push(hslToHex((h + 180) % 360, s, l));
                    for (var i = 2; i < colorCount; i++) {
                        colors.push(hslToHex(h, s * (0.7 + i*0.1), l * (1 + i*0.1)));
                    }
                    break;
                case 'triadic':
                    for (var i = 0; i < 3; i++) {
                        colors.push(hslToHex((h + i * 120) % 360, s, l));
                    }
                    for (var i = 3; i < colorCount; i++) {
                        colors.push(hslToHex(h, s * (0.6 + i*0.05), l * (1.1 + i*0.05)));
                    }
                    break;
                case 'tetradic':
                    colors.push(baseColor);
                    colors.push(hslToHex((h + 90) % 360, s, l));
                    colors.push(hslToHex((h + 180) % 360, s, l));
                    colors.push(hslToHex((h + 270) % 360, s, l));
                    for (var i = 4; i < colorCount; i++) {
                        colors.push(hslToHex(h, s * (0.5 + i*0.05), l * (1.1 + i*0.05)));
                    }
                    break;
                case 'shades':
                    for (var i = 0; i < colorCount; i++) {
                        colors.push(hslToHex(h, s, Math.max(10, Math.min(90, l - (i * (100/colorCount))))));
                    }
                    break;
                case 'pastel':
                    for (var i = 0; i < colorCount; i++) {
                        colors.push(hslToHex((h + i * (360/colorCount)) % 360, 
                                     Math.max(20, Math.min(60, s * (0.6 + i * 0.1))), 
                                     Math.max(70, Math.min(95, l * (1.1 + i * 0.05)))));
                    }
                    break;
                default: // random
                    for (var i = 0; i < colorCount; i++) {
                        colors.push(generateRandomColor());
                    }
            }

            return colors;
        }

        function generatePalettes() {
            var type = document.getElementById('paletteType').value;
            var baseColor = document.getElementById('baseColor').value;
            var count = parseInt(document.getElementById('paletteCount').value);
            var colorCount = parseInt(document.getElementById('colorCount').value);

            // Preserve locked colors
            var newPalettes = [];
            var newPaletteNames = [];
            for (var i = 0; i < count; i++) {
                var palette;
                if (type === 'random') {
                    palette = generatePalette(type, generateRandomColor(), colorCount);
                } else {
                    var hsl = hexToHsl(baseColor);
                    var h = hsl[0], s = hsl[1], l = hsl[2];
                    var variedColor = hslToHex((h + i * 30) % 360, s, l);
                    palette = generatePalette(type, variedColor, colorCount);
                }
                // Replace locked colors
                for (var j = 0; j < colorCount; j++) {
                    var colorId = i + '-' + j;
                    if (lockedColors.has(colorId) && palettes[i] && palettes[i][j]) {
                        palette[j] = palettes[i][j];
                    }
                }
                newPalettes.push(palette);
                newPaletteNames.push(`Palette ${i + 1}`);
            }
            palettes = newPalettes;
            paletteNames = newPaletteNames;

            renderPalettes();
        }

        function renderPalettes() {
            var container = document.getElementById('palettesContainer');
            container.innerHTML = '';

            for (var paletteIndex = 0; paletteIndex < palettes.length; paletteIndex++) {
                var palette = palettes[paletteIndex];
                var paletteDiv = document.createElement('div');
                paletteDiv.className = 'cpg-palette';
                
                // Add palette name editor
                var nameDiv = document.createElement('div');
                nameDiv.className = 'palette-name';
                var nameInput = document.createElement('input');
                nameInput.className = 'palette-name-input';
                nameInput.type = 'text';
                nameInput.value = paletteNames[paletteIndex];
                nameInput.onchange = (function(index) {
                    return function() {
                        paletteNames[index] = this.value;
                    };
                })(paletteIndex);
                nameDiv.appendChild(nameInput);
                paletteDiv.appendChild(nameDiv);

                for (var colorIndex = 0; colorIndex < palette.length; colorIndex++) {
                    var color = palette[colorIndex];
                    var colorId = paletteIndex + '-' + colorIndex;
                    var swatch = document.createElement('div');
                    swatch.className = 'cpg-color-swatch';
                    swatch.style.backgroundColor = color;
                    swatch.onclick = (function(c) {
                        return function() { copyColor(c); };
                    })(color);

                    var colorInfo = document.createElement('div');
                    colorInfo.className = 'color-info';
                    colorInfo.textContent = color.toUpperCase();

                    var contrastColor = getContrastColor(color);
                    var contrastIndicator = document.createElement('div');
                    contrastIndicator.className = 'contrast-indicator';
                    contrastIndicator.textContent = 'Contrast: ' + (contrastColor === '#000000' ? 'Dark' : 'Light');
                    contrastIndicator.style.color = contrastColor;

                    var colorFormats = document.createElement('div');
                    colorFormats.className = 'color-formats';
                    
                    var formats = getColorFormats(color);
                    for (var format in formats) {
                        var formatOption = document.createElement('div');
                        formatOption.className = 'format-option';
                        formatOption.textContent = formats[format];
                        formatOption.onclick = (function(f) {
                            return function(e) {
                                e.stopPropagation();
                                copyColor(f);
                            };
                        })(formats[format]);
                        colorFormats.appendChild(formatOption);
                    }

                    var lockIcon = document.createElement('div');
                    lockIcon.className = 'lock-icon ' + (lockedColors.has(colorId) ? 'locked' : '');
                    lockIcon.innerHTML = lockedColors.has(colorId) ? '🔒' : '🔓';
                    lockIcon.onclick = (function(id) {
                        return function(e) {
                            e.stopPropagation();
                            toggleLock(id);
                        };
                    })(colorId);

                    swatch.appendChild(colorInfo);
                    swatch.appendChild(contrastIndicator);
                    swatch.appendChild(colorFormats);
                    swatch.appendChild(lockIcon);
                    paletteDiv.appendChild(swatch);
                }

                var favoriteBtn = document.createElement('button');
                favoriteBtn.className = 'favorite-btn ' + (favorites.has(paletteIndex) ? 'active' : '');
                favoriteBtn.innerHTML = '❤️';
                favoriteBtn.onclick = (function(index) {
                    return function(e) {
                        e.stopPropagation();
                        toggleFavorite(index);
                    };
                })(paletteIndex);

                paletteDiv.appendChild(favoriteBtn);
                container.appendChild(paletteDiv);
            }
        }

        function copyColor(color) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(color).then(function() {
                    showCopyFeedback(color + ' copied to clipboard!');
                });
            }
        }

        function showCopyFeedback(message) {
            var feedback = document.getElementById('copyFeedback');
            feedback.textContent = message;
            feedback.classList.add('show');
            setTimeout(function() {
                feedback.classList.remove('show');
            }, 2000);
        }

        function toggleLock(colorId) {
            if (lockedColors.has(colorId)) {
                lockedColors.delete(colorId);
            } else {
                lockedColors.add(colorId);
            }
            renderPalettes();
        }

        function toggleFavorite(paletteIndex) {
            if (favorites.has(paletteIndex)) {
                favorites.delete(paletteIndex);
            } else {
                favorites.add(paletteIndex);
            }
            renderPalettes();
        }

        function copyAllPalettes() {
            var allColors = [];
            for (var i = 0; i < palettes.length; i++) {
                allColors = allColors.concat(palettes[i]);
            }
            var colorString = allColors.join(', ');
            if (navigator.clipboard) {
                navigator.clipboard.writeText(colorString).then(function() {
                    showCopyFeedback('All colors copied to clipboard!');
                });
            }
        }

        function savePalettes() {
            var data = {
                palettes: palettes,
                paletteNames: paletteNames,
                favorites: Array.from(favorites),
                lockedColors: Array.from(lockedColors),
                timestamp: new Date().toISOString(),
                settings: {
                    paletteType: document.getElementById('paletteType').value,
                    baseColor: document.getElementById('baseColor').value,
                    paletteCount: document.getElementById('paletteCount').value,
                    colorCount: document.getElementById('colorCount').value
                }
            };
            
            // Save to localStorage
            localStorage.setItem('ksColorPalettes', JSON.stringify(data));
            
            // Also offer to download
            var blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'ks-color-palettes.json';
            a.click();
            URL.revokeObjectURL(url);
            
            showCopyFeedback('Palettes saved successfully!');
        }

        function loadPalettes() {
            var data;
            
            // Check if we should load from localStorage
            if (localStorage.getItem('ksColorPalettes')) {
                data = JSON.parse(localStorage.getItem('ksColorPalettes'));
            } else {
                showCopyFeedback('No saved palettes found!');
                return;
            }
            
            palettes = data.palettes;
            paletteNames = data.paletteNames || palettes.map((_, i) => `Palette ${i + 1}`);
            favorites = new Set(data.favorites || []);
            lockedColors = new Set(data.lockedColors || []);
            
            // Restore settings
            if (data.settings) {
                document.getElementById('paletteType').value = data.settings.paletteType;
                document.getElementById('baseColor').value = data.settings.baseColor;
                document.getElementById('paletteCount').value = data.settings.paletteCount;
                document.getElementById('colorCount').value = data.settings.colorCount;
            }
            
            renderPalettes();
            showCopyFeedback('Palettes loaded successfully!');
        }

        function downloadCSS() {
            var css = ':root {\n';
            for (var i = 0; i < palettes.length; i++) {
                var paletteName = paletteNames[i].replace(/\s+/g, '-').toLowerCase();
                var palette = palettes[i];
                for (var j = 0; j < palette.length; j++) {
                    css += `  --${paletteName}-${j + 1}: ${palette[j]};\n`;
                }
            }
            css += '}\n\n/* Generated by K&S Tools Color Palette Generator */';

            var blob = new Blob([css], { type: 'text/css' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'ks-color-palette.css';
            a.click();
            URL.revokeObjectURL(url);
        }

        function downloadSCSS() {
            var scss = '// Color Palettes\n';
            for (var i = 0; i < palettes.length; i++) {
                var paletteName = paletteNames[i].replace(/\s+/g, '-').toLowerCase();
                scss += `$${paletteName}: (\n`;
                var palette = palettes[i];
                for (var j = 0; j < palette.length; j++) {
                    scss += `  "color-${j + 1}": ${palette[j]},\n`;
                }
                scss = scss.slice(0, -2) + '\n);\n\n';
            }
            scss += '// Generated by K&S Tools Color Palette Generator';

            var blob = new Blob([scss], { type: 'text/scss' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'ks-color-palette.scss';
            a.click();
            URL.revokeObjectURL(url);
        }

        function downloadJSON() {
            var data = {
                palettes: palettes,
                paletteNames: paletteNames,
                generated: new Date().toISOString(),
                tool: 'K&S Tools Color Palette Generator'
            };
            
            var blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'ks-color-palettes.json';
            a.click();
            URL.revokeObjectURL(url);
        }

        function downloadASE() {
            // ASE file format is binary, so we'll create a simplified text version
            var aseText = 'Adobe Swatch Exchange File\n\n';
            for (var i = 0; i < palettes.length; i++) {
                aseText += `Group: ${paletteNames[i]}\n`;
                var palette = palettes[i];
                for (var j = 0; j < palette.length; j++) {
                    const rgb = hexToRgb(palette[j]);
                    aseText += `Color: ${palette[j]} (RGB ${rgb.r}, ${rgb.g}, ${rgb.b})\n`;
                }
                aseText += '\n';
            }
            aseText += 'Generated by K&S Tools Color Palette Generator';

            var blob = new Blob([aseText], { type: 'text/plain' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'ks-color-palettes.ase';
            a.click();
            URL.revokeObjectURL(url);
        }

        function downloadPDF() {
            // For a real PDF, you'd need a library like jsPDF
            // This is a simplified version that creates a printable HTML page
            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>K&S Tools Color Palette Export</title>');
            printWindow.document.write('<style>body { font-family: Arial; padding: 20px; }');
            printWindow.document.write('.palette { display: flex; margin-bottom: 30px; }');
            printWindow.document.write('.swatch { width: 100px; height: 100px; margin-right: 10px; position: relative; }');
            printWindow.document.write('.color-info { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); color: white; padding: 5px; font-size: 12px; }');
            printWindow.document.write('h1 { color: #3B82F6; }</style></head><body>');
            printWindow.document.write('<h1>K&S Tools Color Palette Export</h1>');
            printWindow.document.write(`<p>Generated on ${new Date().toLocaleString()}</p>`);
            
            for (var i = 0; i < palettes.length; i++) {
                printWindow.document.write(`<h2>${paletteNames[i]}</h2><div class="palette">`);
                var palette = palettes[i];
                for (var j = 0; j < palette.length; j++) {
                    printWindow.document.write(`<div class="swatch" style="background-color: ${palette[j]}">`);
                    printWindow.document.write(`<div class="color-info">${palette[j]}</div>`);
                    printWindow.document.write('</div>');
                }
                printWindow.document.write('</div>');
            }
            
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
            }, 500);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.code === 'Space') {
                e.preventDefault();
                generatePalettes();
            }
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                savePalettes();
            }
            if (e.ctrlKey && e.key === 'l') {
                e.preventDefault();
                loadPalettes();
            }
        });
    </script>
<div style="margin-top: 80px;">
<?php include '../footer.php'; ?>

</div>
</body>
</html>