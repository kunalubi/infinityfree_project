<?php include '../header.php'; ?>
    <style>

    
        nav ul li {
            margin-left: 20px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
        }
        
        nav ul li a:hover {
            color: var(--accent);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            flex: 1;
        }
        
        .main-content {
            padding: 40px 0;
        }
        
        .tool-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .tool-title {
            text-align: center;
            margin-bottom: 20px;
            color: var(--primary);
            font-size: 28px;
        }
        
        .upload-container {
            border: 3px dashed #ccc;
            padding: 40px;
            margin: 20px 0;
            border-radius: var(--border-radius);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .upload-container:hover {
            border-color: var(--primary);
            background-color: #f9f9f9;
        }
        
        .upload-icon {
            font-size: 48px;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .upload-text {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .upload-subtext {
            color: #666;
            margin-bottom: 20px;
        }
        
        .btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-success {
            background-color: var(--success);
        }
        
        .btn-success:hover {
            background-color: #218838;
        }
        
        .btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .result-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
        }
        
        .image-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: var(--border-radius);
            background-color: #f9f9f9;
            flex: 1;
            min-width: 300px;
            text-align: center;
        }
        
        .image-box h3 {
            margin-top: 0;
            color: var(--dark);
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
        }
        
        canvas {
            max-width: 100%;
            border: 1px solid #eee;
            background-image: 
                linear-gradient(45deg, #f0f0f0 25%, transparent 25%),
                linear-gradient(-45deg, #f0f0f0 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #f0f0f0 75%),
                linear-gradient(-45deg, transparent 75%, #f0f0f0 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
        
        .loading {
            display: none;
            margin: 30px 0;
            text-align: center;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .notice {
            background-color: #e7f3ff;
            border-left: 4px solid var(--primary);
            padding: 15px;
            margin: 20px 0;
            text-align: left;
            border-radius: 4px;
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            nav ul {
                margin-top: 15px;
                justify-content: center;
            }
            
            .result-container {
                flex-direction: column;
            }
            
            .upload-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>


    <div class="container" style="margin-top: 100px;">
        <div class="main-content">
            <div class="tool-card">
                <h1 class="tool-title">Background Remover Tool</h1>
                
                <div class="notice">
                    <p><strong>Note:</strong> This tool works directly in your browser. For best results, use images with clear contrast between the subject and background.</p>
                </div>
                
                <div class="upload-container" id="upload-area">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">Upload your image</div>
                    <div class="upload-subtext">Click to browse or drag and drop your image here</div>
                    <button class="btn" onclick="document.getElementById('image-input').click()">
                        <i class="fas fa-upload"></i> Select Image
                    </button>
                    <input type="file" id="image-input" class="d-none" accept="image/*">
                </div>
                
                <div style="text-align: center;">
                    <button class="btn" id="remove-bg-btn" disabled>
                        <i class="fas fa-magic"></i> Remove Background
                    </button>
                </div>
                
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p>Processing your image...</p>
                </div>
                
                <div class="result-container">
                    <div class="image-box">
                        <h3>Original Image</h3>
                        <img id="original-image" src="" alt="Original image" style="display: none; max-width: 100%;">
                    </div>
                    
                    <div class="image-box">
                        <h3>Result</h3>
                        <canvas id="result-canvas"></canvas>
                        <div style="margin-top: 15px;">
                            <button class="btn btn-success" id="download-btn" style="display: none;">
                                <i class="fas fa-download"></i> Download Image
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include '../footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image-input');
            const uploadArea = document.getElementById('upload-area');
            const removeBgBtn = document.getElementById('remove-bg-btn');
            const originalImage = document.getElementById('original-image');
            const resultCanvas = document.getElementById('result-canvas');
            const loading = document.getElementById('loading');
            const downloadBtn = document.getElementById('download-btn');
            
            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--primary)';
                this.style.backgroundColor = '#f0f8ff';
            });
            
            uploadArea.addEventListener('dragleave', function() {
                this.style.borderColor = '#ccc';
                this.style.backgroundColor = '#f9f9f9';
            });
            
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#ccc';
                this.style.backgroundColor = '#f9f9f9';
                
                if (e.dataTransfer.files.length) {
                    imageInput.files = e.dataTransfer.files;
                    handleImageUpload();
                }
            });
            
            uploadArea.addEventListener('click', function() {
                imageInput.click();
            });
            
            imageInput.addEventListener('change', handleImageUpload);
            
            function handleImageUpload() {
                if (imageInput.files && imageInput.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        originalImage.src = e.target.result;
                        originalImage.style.display = 'block';
                        removeBgBtn.disabled = false;
                        downloadBtn.style.display = 'none';
                        
                        // Clear previous result
                        const ctx = resultCanvas.getContext('2d');
                        ctx.clearRect(0, 0, resultCanvas.width, resultCanvas.height);
                    }
                    
                    reader.readAsDataURL(imageInput.files[0]);
                }
            }
            
            removeBgBtn.addEventListener('click', function() {
                if (!originalImage.src) return;
                
                loading.style.display = 'block';
                removeBgBtn.disabled = true;
                
                // Use setTimeout to allow the UI to update before processing
                setTimeout(function() {
                    removeBackground();
                    loading.style.display = 'none';
                    removeBgBtn.disabled = false;
                }, 500);
            });
            
            downloadBtn.addEventListener('click', function() {
                if (!resultCanvas.width) return;
                
                const link = document.createElement('a');
                link.download = 'background_removed.png';
                link.href = resultCanvas.toDataURL('image/png');
                link.click();
            });
            
            function removeBackground() {
                const img = new Image();
                img.src = originalImage.src;
                
                img.onload = function() {
                    // Set canvas size to match image
                    resultCanvas.width = img.width;
                    resultCanvas.height = img.height;
                    
                    const ctx = resultCanvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    
                    // Get image data
                    const imageData = ctx.getImageData(0, 0, resultCanvas.width, resultCanvas.height);
                    const data = imageData.data;
                    
                    // Simple background removal algorithm
                    // This assumes the background is relatively uniform
                    // For demonstration purposes, we'll remove pixels similar to the corner pixels
                    
                    // Sample corner pixels to determine background color
                    const corners = [
                        0, // top-left
                        (resultCanvas.width - 1) * 4, // top-right
                        (resultCanvas.height - 1) * resultCanvas.width * 4, // bottom-left
                        (resultCanvas.height * resultCanvas.width - 1) * 4 // bottom-right
                    ];
                    
                    let avgR = 0, avgG = 0, avgB = 0;
                    for (let i = 0; i < corners.length; i++) {
                        avgR += data[corners[i]];
                        avgG += data[corners[i] + 1];
                        avgB += data[corners[i] + 2];
                    }
                    avgR /= corners.length;
                    avgG /= corners.length;
                    avgB /= corners.length;
                    
                    // Remove pixels similar to the background
                    const threshold = 50; // Color similarity threshold
                    
                    for (let i = 0; i < data.length; i += 4) {
                        const r = data[i];
                        const g = data[i + 1];
                        const b = data[i + 2];
                        
                        // Calculate color distance
                        const distance = Math.sqrt(
                            Math.pow(r - avgR, 2) +
                            Math.pow(g - avgG, 2) +
                            Math.pow(b - avgB, 2)
                        );
                        
                        // If pixel is similar to background, make it transparent
                        if (distance < threshold) {
                            data[i + 3] = 0; // Set alpha to 0
                        }
                    }
                    
                    // Put the modified image data back to canvas
                    ctx.putImageData(imageData, 0, 0);
                    
                    // Show download button
                    downloadBtn.style.display = 'inline-flex';
                };
            }
        });
    </script>
</body>
</html>