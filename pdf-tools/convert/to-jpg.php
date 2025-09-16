<?php include "../../header.php"; ?>
<div class="tool-card pdf-to-jpg-converter" style="margin-top: 100px;">
    <div class="converter-header">
        <h1><i class="fas fa-file-image"></i> PDF to JPG Converter</h1>
        <p class="subtitle">Convert each page of your PDF to high-quality JPG images</p>
    </div>

    <div class="converter-flow">
        <!-- Step 1: Upload -->
        <div class="step active" id="uploadStep">
            <form id="pdfToJpgForm">
                <div class="upload-area">
                    <div class="file-upload-box">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <input type="file" id="pdfFile" accept=".pdf" required>
                        <label for="pdfFile" class="file-upload-label">
                            <strong>Choose a PDF file</strong> or drag it here
                            <span class="file-requirements">(Max 50MB)</span>
                        </label>
                    </div>
                </div>

                <div class="options-area">
                    <div class="form-group">
                        <label for="quality">Image Quality:</label>
                        <div class="quality-options">
                            <div class="quality-option">
                                <input type="radio" id="highQuality" name="quality" value="high">
                                <label for="highQuality">
                                    <span class="quality-name">High</span>
                                    <span class="quality-desc">300 DPI (Best quality)</span>
                                </label> 
                            </div>
                            <div class="quality-option">
                                <input type="radio" id="mediumQuality" name="quality" value="medium" checked>
                                <label for="mediumQuality">
                                    <span class="quality-name">Medium</span>
                                    <span class="quality-desc">150 DPI (Recommended)</span>
                                </label>
                            </div>
                            <div class="quality-option">
                                <input type="radio" id="lowQuality" name="quality" value="low">
                                <label for="lowQuality">
                                    <span class="quality-name">Low</span>
                                    <span class="quality-desc">72 DPI (Smaller files)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn convert-btn" disabled id="convertBtn">
                        <i class="fas fa-exchange-alt"></i> Convert to JPG
                    </button>
                </div>
            </form>

            <!-- PDF Preview Container -->
            <div class="pdf-preview-container" id="pdfPreviewContainer" style="display: none;">
                <h3>PDF Preview</h3>
                <div class="pdf-pages" id="pdfPages"></div>
                <p class="page-count">Total pages: <span id="pageCount">0</span></p>
            </div>
        </div>

        <!-- Step 2: Conversion Results -->
        <div class="step" id="resultsStep">
            <div class="results-header">
                <h3><i class="fas fa-check-circle"></i> Conversion Complete</h3>
                <button class="btn-text" id="convertAnother">
                    <i class="fas fa-redo"></i> Convert Another
                </button>
            </div>

            <div class="conversion-options">
                <div class="form-group">
                    <label for="imageFormat">Output Format:</label>
                    <select id="imageFormat" class="form-control">
                        <option value="jpg">JPG (Recommended)</option>
                        <option value="png">PNG (Lossless)</option>
                    </select>
                </div>
            </div>

            <div class="images-grid" id="imagesGrid"></div>

            <div class="download-actions">
                <button id="downloadAll" class="btn download-btn">
                    <i class="fas fa-download"></i> Download All as ZIP
                </button>
            </div>
        </div>

        <!-- Loading State -->
        <div class="step loading-state" id="loadingState">
            <div class="loading-content">
                <div class="spinner"></div>
                <h3>Converting your PDF...</h3>
                <p class="progress-text">Processing page <span id="currentPage">1</span> of <span id="totalPages">1</span></p>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include required libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
    // Set PDF.js worker path
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

    let pdfFile = null;
    let totalPages = 0;
    let convertedImages = [];

    // Initialize the converter
    document.addEventListener('DOMContentLoaded', function() {
        // Set up file input
        const pdfInput = document.getElementById('pdfFile');
        const convertBtn = document.getElementById('convertBtn');
        const pdfPreviewContainer = document.getElementById('pdfPreviewContainer');

        pdfInput.addEventListener('change', async function(e) {
            if (!this.files || this.files.length === 0) return;

            pdfFile = this.files[0];

            // Validate file
            if (pdfFile.type !== 'application/pdf') {
                showToast('Please select a PDF file', 'error');
                this.value = '';
                return;
            }

            if (pdfFile.size > 50 * 1024 * 1024) {
                showToast('File size exceeds 50MB limit', 'error');
                this.value = '';
                return;
            }

            // Enable convert button
            convertBtn.disabled = false;

            // Show PDF preview
            pdfPreviewContainer.style.display = 'block';
            await renderPdfPreview(pdfFile);
        });

        // Form submission
        document.getElementById('pdfToJpgForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            if (!pdfFile) return;

            // Show loading state
            document.getElementById('uploadStep').classList.remove('active');
            document.getElementById('loadingState').classList.add('active');

            // Get quality setting
            const quality = document.querySelector('input[name="quality"]:checked').value;

            // Perform actual conversion
            await convertPdfToImages(pdfFile, quality);

            // Show results
            document.getElementById('loadingState').classList.remove('active');
            document.getElementById('resultsStep').classList.add('active');
            showResults();
        });

        // Convert another
        document.getElementById('convertAnother').addEventListener('click', function() {
            resetConverter();
        });

        // Download all images
        document.getElementById('downloadAll').addEventListener('click', function() {
            downloadAllImages();
        });
    });

    // Render PDF preview
    async function renderPdfPreview(file) {
        const pdfPagesContainer = document.getElementById('pdfPages');
        pdfPagesContainer.innerHTML = '';

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({
                data: arrayBuffer
            }).promise;
            totalPages = pdf.numPages;
            document.getElementById('pageCount').textContent = totalPages;
            document.getElementById('totalPages').textContent = totalPages;

            // Render first 3 pages for preview
            const pagesToRender = Math.min(totalPages, 3);
            for (let i = 1; i <= pagesToRender; i++) {
                const page = await pdf.getPage(i);
                const viewport = page.getViewport({
                    scale: 0.5
                });

                const pageContainer = document.createElement('div');
                pageContainer.className = 'pdf-page';

                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                pageContainer.appendChild(canvas);
                pdfPagesContainer.appendChild(pageContainer);

                await page.render({
                    canvasContext: context,
                    viewport: viewport
                }).promise;

                // Add page number
                const pageNumber = document.createElement('div');
                pageNumber.className = 'page-number';
                pageNumber.textContent = `Page ${i}`;
                pageContainer.appendChild(pageNumber);
            }

            if (totalPages > 3) {
                const morePages = document.createElement('div');
                morePages.className = 'more-pages';
                morePages.textContent = `+ ${totalPages - 3} more pages...`;
                pdfPagesContainer.appendChild(morePages);
            }

        } catch (error) {
            console.error("Error rendering PDF preview:", error);
            showToast('Error loading PDF preview', 'error');
        }
    }

    // Convert PDF to JPG images
    async function convertPdfToImages(file, quality) {
        const progressFill = document.querySelector('.progress-fill');
        const currentPageEl = document.getElementById('currentPage');

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({
                data: arrayBuffer
            }).promise;
            totalPages = pdf.numPages;

            // Clear previous conversions
            convertedImages = [];

            // Convert each page to image
            for (let i = 1; i <= totalPages; i++) {
                currentPageEl.textContent = i;
                const progress = (i / totalPages) * 100;
                progressFill.style.width = `${progress}%`;

                const page = await pdf.getPage(i);
                const viewport = page.getViewport({
                    scale: 2.0
                }); // Higher scale for better quality

                // Create canvas for this page
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page to canvas
                await page.render({
                    canvasContext: context,
                    viewport: viewport
                }).promise;

                // Convert canvas to JPG blob
                const blob = await new Promise(resolve => {
                    canvas.toBlob(blob => resolve(blob), 'image/jpeg', getQualityValue(quality));
                });

                // Create object URL for the image
                const imgUrl = URL.createObjectURL(blob);

                // Store image data
                convertedImages.push({
                    url: imgUrl,
                    blob: blob,
                    pageNumber: i,
                    quality: quality
                });
            }

        } catch (error) {
            console.error("Error converting PDF:", error);
            showToast('Error converting PDF', 'error');
            throw error;
        }
    }

    // Get quality value (0-1) based on selection
    function getQualityValue(quality) {
        switch (quality) {
            case 'high':
                return 0.9;
            case 'medium':
                return 0.7;
            case 'low':
                return 0.5;
            default:
                return 0.7;
        }
    }

    // Show conversion results
    function showResults() {
        const imagesGrid = document.getElementById('imagesGrid');
        imagesGrid.innerHTML = '';

        convertedImages.forEach(img => {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'image-container';

            const imgElement = document.createElement('img');
            imgElement.src = img.url;
            imgElement.alt = `Page ${img.pageNumber}`;

            const imgInfo = document.createElement('div');
            imgInfo.className = 'image-info';
            imgInfo.innerHTML = `
                <span class="page-number">Page ${img.pageNumber}</span>
                <span class="quality-badge">${img.quality} quality</span>
                <button class="btn-icon download-single" data-index="${img.pageNumber - 1}">
                    <i class="fas fa-download"></i>
                </button>
            `;

            imgContainer.appendChild(imgElement);
            imgContainer.appendChild(imgInfo);
            imagesGrid.appendChild(imgContainer);
        });

        // Set up single image downloads
        document.querySelectorAll('.download-single').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                downloadSingleImage(index);
            });
        });
    }

    // Download single image
    function downloadSingleImage(index) {
        if (!convertedImages[index]) return;

        const img = convertedImages[index];
        const filename = `page_${img.pageNumber}.jpg`;

        // Use FileSaver.js to download the blob
        saveAs(img.blob, filename);
        showToast('Download started!', 'success');
    }

    // Download all images as ZIP
    async function downloadAllImages() {
        showToast('Preparing ZIP download...', 'info');

        try {
            const zip = new JSZip();
            const imgFolder = zip.folder("converted_images");

            // Add each image to the ZIP
            for (let i = 0; i < convertedImages.length; i++) {
                const img = convertedImages[i];
                const filename = `page_${img.pageNumber}.jpg`;
                imgFolder.file(filename, img.blob);
            }

            // Generate the ZIP file
            const content = await zip.generateAsync({
                type: "blob"
            });

            // Download the ZIP
            saveAs(content, "converted_images.zip");
            showToast('ZIP download started!', 'success');

        } catch (error) {
            console.error("Error creating ZIP:", error);
            showToast('Error creating ZIP file', 'error');
        }
    }

    // Reset the converter
    function resetConverter() {
        // Reset form
        document.getElementById('pdfFile').value = '';
        document.getElementById('convertBtn').disabled = true;

        // Clear previews and results
        document.getElementById('pdfPages').innerHTML = '';
        document.getElementById('pdfPreviewContainer').style.display = 'none';
        document.getElementById('imagesGrid').innerHTML = '';

        // Reset steps
        document.getElementById('resultsStep').classList.remove('active');
        document.getElementById('uploadStep').classList.add('active');

        // Clear data and revoke object URLs
        convertedImages.forEach(img => {
            URL.revokeObjectURL(img.url);
        });

        pdfFile = null;
        totalPages = 0;
        convertedImages = [];
    }

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
    /* PDF to JPG Converter Specific Styles */
    .pdf-to-jpg-converter {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
    }

    .converter-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .converter-header h1 {
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .converter-header .subtitle {
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

    /* Quality Options */
    .quality-options {
        display: flex;
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .quality-option {
        flex: 1;
    }

    .quality-option input[type="radio"] {
        display: none;
    }

    .quality-option label {
        display: block;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .quality-option input[type="radio"]:checked+label {
        border-color: #3498db;
        background: #eaf4ff;
    }

    .quality-name {
        display: block;
        font-weight: bold;
        margin-bottom: 0.3rem;
    }

    .quality-desc {
        display: block;
        font-size: 0.9rem;
        color: #7f8c8d;
    }

    /* PDF Preview */
    .pdf-preview-container {
        margin-top: 2rem;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .pdf-preview-container h3 {
        margin-bottom: 1rem;
        color: #2c3e50;
    }

    .pdf-pages {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 1rem;
    }

    .pdf-page {
        position: relative;
        flex: 0 0 auto;
        background: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .pdf-page canvas {
        display: block;
    }

    .page-number {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.3rem;
        text-align: center;
        font-size: 0.9rem;
    }

    .more-pages {
        display: flex;
        align-items: center;
        padding: 0 1rem;
        color: #7f8c8d;
        font-style: italic;
    }

    .page-count {
        margin-top: 1rem;
        text-align: center;
        font-size: 0.9rem;
        color: #7f8c8d;
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

    #convertAnother {
        background: none;
        border: none;
        color: #3498db;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Images Grid */
    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }

    .image-container {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .image-container img {
        width: 100%;
        height: auto;
        display: block;
        border-bottom: 1px solid #eee;
    }

    .image-info {
        padding: 0.8rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-number {
        font-weight: bold;
    }

    .quality-badge {
        background: #eaf4ff;
        color: #3498db;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    /* Download Actions */
    .download-actions {
        display: flex;
        justify-content: flex-start;
        margin-top: 2rem;
    }

    .download-btn {
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
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

    .toast-info {
        background: #3498db;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .pdf-to-jpg-converter {
            padding: 1rem;
        }

        .quality-options {
            flex-direction: column;
        }

        .pdf-pages {
            flex-direction: column;
        }

        .download-actions {
            justify-content: center;
        }

        .images-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?php include "../../footer.php"; ?>