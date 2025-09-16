<?php include "../../header.php"; ?>
<div class="tool-card pdf-to-png-converter" style="margin-top: 100px;">
    <div class="converter-header">
        <h1><i class="fas fa-file-image"></i> PDF to PNG Converter</h1>
        <p class="subtitle">Convert PDF pages to PNG images with transparent backgrounds</p>
    </div>

    <div class="converter-flow">
        <!-- Step 1: Upload -->
        <div class="step active" id="uploadStep">
            <form id="pdfToPngForm">
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
                        <label for="transparentBg" class="toggle-switch">
                            <input type="checkbox" id="transparentBg" checked>
                            <span class="slider"></span>
                            <span class="toggle-label">Transparent Background</span>
                        </label>
                    </div>

                    <button type="submit" class="btn convert-btn" disabled id="convertBtn">
                        <i class="fas fa-exchange-alt"></i> Convert to PNG
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
                    <label for="dpiSetting">Resolution:</label>
                    <select id="dpiSetting" class="form-control">
                        <option value="300">300 DPI (High Quality)</option>
                        <option value="150" selected>150 DPI (Recommended)</option>
                        <option value="72">72 DPI (Web Use)</option>
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
        document.getElementById('pdfToPngForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            if (!pdfFile) return;

            // Show loading state
            document.getElementById('uploadStep').classList.remove('active');
            document.getElementById('loadingState').classList.add('active');

            // Get settings
            const transparentBg = document.getElementById('transparentBg').checked;
            const dpi = parseInt(document.getElementById('dpiSetting').value);

            // Perform actual conversion
            await convertPdfToPng(pdfFile, transparentBg, dpi);

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

    // Convert PDF to PNG images
    async function convertPdfToPng(file, transparentBg, dpi) {
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

            // Calculate scale based on DPI (assuming 96 DPI as standard screen DPI)
            const scale = dpi / 96;

            // Convert each page to PNG
            for (let i = 1; i <= totalPages; i++) {
                currentPageEl.textContent = i;
                const progress = (i / totalPages) * 100;
                progressFill.style.width = `${progress}%`;

                const page = await pdf.getPage(i);
                const viewport = page.getViewport({
                    scale: scale
                });

                // Create canvas for this page
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Set transparent background if enabled
                if (transparentBg) {
                    context.fillStyle = 'transparent';
                    context.fillRect(0, 0, canvas.width, canvas.height);
                } else {
                    context.fillStyle = 'white';
                    context.fillRect(0, 0, canvas.width, canvas.height);
                }

                // Render PDF page to canvas
                await page.render({
                    canvasContext: context,
                    viewport: viewport
                }).promise;

                // Convert canvas to PNG blob
                const blob = await new Promise(resolve => {
                    canvas.toBlob(blob => resolve(blob), 'image/png');
                });

                // Create object URL for the image
                const imgUrl = URL.createObjectURL(blob);

                // Store image data
                convertedImages.push({
                    url: imgUrl,
                    blob: blob,
                    pageNumber: i,
                    dpi: dpi,
                    transparent: transparentBg
                });
            }

        } catch (error) {
            console.error("Error converting PDF:", error);
            showToast('Error converting PDF', 'error');
            throw error;
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
            imgElement.style.background = img.transparent ?
                'url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAMUlEQVQ4T2NkYGD4z0AswKj9//9/BmQxFE1sAqia0TQjXQKqGU0z0iWgmtE0AwB8VwXhB8Uz5QAAAABJRU5ErkJggg==")' :
                'white';

            const imgInfo = document.createElement('div');
            imgInfo.className = 'image-info';
            imgInfo.innerHTML = `
                <span class="page-number">Page ${img.pageNumber}</span>
                <span class="quality-badge">${img.dpi} DPI</span>
                <span class="transparency-badge">${img.transparent ? 'Transparent' : 'White BG'}</span>
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
        const filename = `page_${img.pageNumber}.png`;

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
                const filename = `page_${img.pageNumber}.png`;
                imgFolder.file(filename, img.blob);
            }

            // Generate the ZIP file
            const content = await zip.generateAsync({
                type: "blob"
            });

            // Download the ZIP
            saveAs(content, "converted_png_images.zip");
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
    /* PDF to PNG Converter Specific Styles */
    .pdf-to-png-converter {
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

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: relative;
        width: 50px;
        height: 24px;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
        margin-right: 10px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #3498db;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .toggle-label {
        font-weight: normal;
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
        max-height: 300px;
        object-fit: contain;
        display: block;
        border-bottom: 1px solid #eee;
    }

    .image-info {
        padding: 0.8rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .page-number {
        font-weight: bold;
    }

    .quality-badge,
    .transparency-badge {
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .quality-badge {
        background: #eaf4ff;
        color: #3498db;
    }

    .transparency-badge {
        background: #e8f5e9;
        color: #2e7d32;
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
        .pdf-to-png-converter {
            padding: 1rem;
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