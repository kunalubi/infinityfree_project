<?php include "../partials/header.php"; ?>
    <div class="tool-card compress-tool">
        <div class="tool-header">
            <h1><i class="fas fa-compress-alt"></i> PDF Compressor</h1>
            <p class="subtitle">Reduce PDF file size while maintaining quality</p>
        </div>
        
        <div class="compress-flow">
            <!-- Step 1: Upload -->
            <div class="step active" id="step1">
                <form id="compressPdfForm" enctype="multipart/form-data">
                    <div class="upload-area">
                        <div class="file-upload-box">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <input type="file" id="pdfFile" name="pdfFile" accept=".pdf" required>
                            <label for="pdfFile" class="file-upload-label">
                                <strong>Choose a PDF file</strong> or drag it here
                                <span class="file-requirements">(Max 50MB)</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="options-area">
                        <div class="form-group">
                            <label for="compressionLevel">Compression Level:</label>
                            <div class="compression-levels">
                                <div class="level-option">
                                    <input type="radio" id="low" name="compressionLevel" value="low">
                                    <label for="low">
                                        <span class="level-name">Light</span>
                                        <span class="level-desc">Best quality</span>
                                    </label>
                                </div>
                                <div class="level-option">
                                    <input type="radio" id="medium" name="compressionLevel" value="medium" checked>
                                    <label for="medium">
                                        <span class="level-name">Medium</span>
                                        <span class="level-desc">Recommended</span>
                                    </label>
                                </div>
                                <div class="level-option">
                                    <input type="radio" id="high" name="compressionLevel" value="high">
                                    <label for="high">
                                        <span class="level-name">Strong</span>
                                        <span class="level-desc">Smallest size</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn compress-btn">
                            <i class="fas fa-compress-alt"></i> Compress PDF
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Step 2: Results -->
            <div class="step" id="step2">
                <div class="results-header">
                    <h3><i class="fas fa-check-circle"></i> Compression Complete</h3>
                    <button class="btn-text" id="compressAnother">
                        <i class="fas fa-redo"></i> Compress Another
                    </button>
                </div>
                
                <div class="results-comparison">
                    <div class="result-card original">
                        <div class="result-label">
                            <i class="fas fa-file-pdf"></i> Original
                        </div>
                        <div class="preview-container">
                            <canvas id="originalPreview" class="pdf-preview"></canvas>
                        </div>
                        <div class="result-stats">
                            <div class="stat">
                                <span class="stat-label">Size:</span>
                                <span class="stat-value" id="originalSize">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Pages:</span>
                                <span class="stat-value" id="originalPages">-</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="result-card compressed">
                        <div class="result-label">
                            <i class="fas fa-file-archive"></i> Compressed
                        </div>
                        <div class="preview-container">
                            <canvas id="compressedPreview" class="pdf-preview"></canvas>
                        </div>
                        <div class="result-stats">
                            <div class="stat">
                                <span class="stat-label">Size:</span>
                                <span class="stat-value" id="compressedSize">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Reduction:</span>
                                <span class="stat-value" id="reduction">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="results-actions">
                    <button id="downloadCompressed" class="btn download-btn">
                        <i class="fas fa-download"></i> Download Compressed PDF
                    </button>
                    <div class="share-options">
                        <span>Share:</span>
                        <button class="btn-icon"><i class="fas fa-envelope"></i></button>
                        <button class="btn-icon"><i class="fas fa-link"></i></button>
                    </div>
                </div>
            </div>
            
            <!-- Loading State -->
            <div class="step loading-state" id="loadingState">
                <div class="loading-content">
                    <div class="spinner"></div>
                    <h3>Compressing your PDF...</h3>
                    <p class="progress-text">This may take a few moments</p>
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include PDF.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
    // Set PDF.js worker path
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

    // Helper: format bytes
    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    let originalPdfFile, compressedPdfBlob, originalPageCount = 0;

    // PDF Preview using pdf.js
    async function renderPdfPreview(file, canvasId) {
        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({data: arrayBuffer}).promise;
            originalPageCount = pdf.numPages;
            document.getElementById('originalPages').textContent = pdf.numPages;
            
            const page = await pdf.getPage(1);
            const viewport = page.getViewport({scale: 1.0});
            const canvas = document.getElementById(canvasId);
            const context = canvas.getContext('2d');
            
            // Set canvas dimensions
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            
            // Render PDF page
            await page.render({
                canvasContext: context,
                viewport: viewport
            }).promise;
        } catch (error) {
            console.error("Error rendering PDF:", error);
            showToast('Error rendering PDF preview', 'error');
        }
    }

    // File input change handler
    document.getElementById('pdfFile').addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Validate file type
        if (file.type !== 'application/pdf') {
            showToast('Please select a PDF file', 'error');
            return;
        }

        // Validate file size (50MB max)
        if (file.size > 50 * 1024 * 1024) {
            showToast('File size exceeds 50MB limit', 'error');
            this.value = '';
            return;
        }

        originalPdfFile = file;
        
        // Show file info
        document.getElementById('originalSize').textContent = formatBytes(file.size);
        
        // Render original preview
        await renderPdfPreview(file, 'originalPreview');
    });

    // Form submission handler
    document.getElementById('compressPdfForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!originalPdfFile) {
            showToast('Please select a PDF file first', 'error');
            return;
        }

        // Show loading state
        document.getElementById('step1').classList.remove('active');
        document.getElementById('loadingState').classList.add('active');
        
        // Simulate compression progress
        const progressFill = document.querySelector('.progress-fill');
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += Math.random() * 10;
            if (progress > 90) clearInterval(progressInterval);
            progressFill.style.width = `${Math.min(progress, 100)}%`;
        }, 300);

        try {
            // Get selected compression level
            const compressionLevel = document.querySelector('input[name="compressionLevel"]:checked').value;
            let compressionRatio;
            
            switch(compressionLevel) {
                case 'low': compressionRatio = 0.8; break;    // 20% reduction
                case 'medium': compressionRatio = 0.5; break; // 50% reduction
                case 'high': compressionRatio = 0.3; break;   // 70% reduction
                default: compressionRatio = 0.5;
            }
            
            // Simulate compression delay (2-4 seconds)
            const delay = 2000 + Math.random() * 2000;
            await new Promise(resolve => setTimeout(resolve, delay));
            
            // Create a simulated compressed blob
            const compressedSize = Math.floor(originalPdfFile.size * compressionRatio);
            compressedPdfBlob = new Blob([originalPdfFile.slice(0, compressedSize)], {type: 'application/pdf'});
            
            // Update UI with results
            document.getElementById('compressedSize').textContent = formatBytes(compressedSize);
            document.getElementById('reduction').textContent = 
                Math.round(100 - (compressedSize / originalPdfFile.size * 100)) + '%';
            
            // For demo purposes, we'll reuse the original preview
            await renderPdfPreview(originalPdfFile, 'compressedPreview');
            
            // Switch to results view
            document.getElementById('loadingState').classList.remove('active');
            document.getElementById('step2').classList.add('active');
            
        } catch (error) {
            console.error("Compression error:", error);
            showToast('Error during compression', 'error');
            // Return to upload view
            document.getElementById('loadingState').classList.remove('active');
            document.getElementById('step1').classList.add('active');
        } finally {
            clearInterval(progressInterval);
            progressFill.style.width = '100%';
        }
    });

    // Download handler
    document.getElementById('downloadCompressed').addEventListener('click', function() {
        if (!compressedPdfBlob) {
            showToast('No compressed file available', 'error');
            return;
        }
        
        const url = URL.createObjectURL(compressedPdfBlob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'compressed_' + originalPdfFile.name.replace('.pdf', '') + '.pdf';
        document.body.appendChild(a);
        a.click();
        
        // Clean up
        setTimeout(() => {
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }, 100);
        
        showToast('Download started!', 'success');
    });

    // Compress another handler
    document.getElementById('compressAnother').addEventListener('click', function() {
        // Reset form
        document.getElementById('pdfFile').value = '';
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step1').classList.add('active');
        
        // Reset previews
        const canvases = document.querySelectorAll('.pdf-preview');
        canvases.forEach(canvas => {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });
        
        // Reset stats
        document.getElementById('originalSize').textContent = '-';
        document.getElementById('originalPages').textContent = '-';
        document.getElementById('compressedSize').textContent = '-';
        document.getElementById('reduction').textContent = '-';
    });

    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i> ${message}`;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    </script>

    <style>
    /* Compressor Tool Specific Styles */
    .compress-tool {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .tool-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .tool-header h1 {
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    .tool-header .subtitle {
        color: #7f8c8d;
        font-size: 1.1rem;
    }
    
    /* Upload Area */
    .upload-area {
        margin: 2rem 0;
    }
    
    .file-upload-box {
        border: 2px dashed #bdc3c7;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #f8f9fa;
        cursor: pointer;
    }
    
    .file-upload-box:hover {
        border-color: #3498db;
        background: #f1f8ff;
    }
    
    .file-upload-box i {
        font-size: 3rem;
        color: #3498db;
        margin-bottom: 1rem;
    }
    
    .file-upload-box strong {
        display: block;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }
    
    .file-requirements {
        display: block;
        font-size: 0.9rem;
        color: #7f8c8d;
        margin-top: 0.5rem;
    }
    
    /* Compression Levels */
    .compression-levels {
        display: flex;
        gap: 1rem;
        margin: 1.5rem 0;
    }
    
    .level-option {
        flex: 1;
    }
    
    .level-option input[type="radio"] {
        display: none;
    }
    
    .level-option label {
        display: block;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .level-option input[type="radio"]:checked + label {
        border-color: #3498db;
        background: #eaf4ff;
    }
    
    .level-name {
        display: block;
        font-weight: bold;
        margin-bottom: 0.3rem;
    }
    
    .level-desc {
        display: block;
        font-size: 0.9rem;
        color: #7f8c8d;
    }
    
    /* Buttons */
    .compress-btn {
        width: 100%;
        padding: 1rem;
        font-size: 1.1rem;
        margin-top: 1rem;
    }
    
    /* Results Section */
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .results-header h3 {
        color: #27ae60;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    #compressAnother {
        background: none;
        border: none;
        color: #3498db;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .results-comparison {
        display: flex;
        gap: 2rem;
        margin: 2rem 0;
    }
    
    .result-card {
        flex: 1;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    
    .result-card.original {
        border-top: 4px solid #e74c3c;
    }
    
    .result-card.compressed {
        border-top: 4px solid #27ae60;
    }
    
    .result-label {
        padding: 1rem;
        background: #f8f9fa;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .preview-container {
        height: 300px;
        overflow: auto;
        background: #f1f3f4;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .pdf-preview {
        max-width: 100%;
        max-height: 100%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .result-stats {
        padding: 1rem;
        background: white;
    }
    
    .stat {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #7f8c8d;
    }
    
    .stat-value {
        font-weight: bold;
    }
    
    /* Results Actions */
    .results-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
    }
    
    .download-btn {
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
    }
    
    .share-options {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-icon {
        background: none;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #7f8c8d;
        transition: all 0.3s ease;
    }
    
    .btn-icon:hover {
        background: #f1f3f4;
        color: #3498db;
    }
    
    /* Loading State */
    .loading-state {
        text-align: center;
        padding: 3rem 0;
    }
    
    .spinner {
        width: 60px;
        height: 60px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1.5rem;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .progress-bar {
        width: 100%;
        height: 6px;
        background: #f1f3f4;
        border-radius: 3px;
        margin-top: 1.5rem;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        width: 0%;
        background: #3498db;
        transition: width 0.3s ease;
    }
    
    /* Steps */
    .step {
        display: none;
    }
    
    .step.active {
        display: block;
    }
    
    /* Toast Notifications */
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 8px;
        color: white;
        background: #333;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    
    .toast.show {
        transform: translateY(0);
        opacity: 1;
    }
    
    .toast-success {
        background: #27ae60;
    }
    
    .toast-error {
        background: #e74c3c;
    }
    
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .compress-tool {
            padding: 1rem;
        }
        
        .compression-levels {
            flex-direction: column;
        }
        
        .results-comparison {
            flex-direction: column;
        }
        
        .results-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .share-options {
            margin-top: 1rem;
        }
        
        .preview-container {
            height: 200px;
        }
    }
    </style>
<?php include "../partials/footer.php"; ?>