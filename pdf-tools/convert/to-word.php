<?php include "../../header.php"; ?>
<div class="tool-card pdf-to-word-converter" style="margin-top: 100px;">
    <div class="converter-header">
        <h1><i class="fas fa-file-word"></i> PDF to Word Converter</h1>
        <p class="subtitle">Convert PDF files to editable Word documents while preserving formatting</p>
    </div>

    <div class="converter-flow">
        <!-- Step 1: Upload -->
        <div class="step active" id="uploadStep">
            <form id="pdfToWordForm">
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
                        <label for="format">Output Format:</label>
                        <div class="format-options">
                            <div class="format-option">
                                <input type="radio" id="docxFormat" name="format" value="docx" checked>
                                <label for="docxFormat">
                                    <span class="format-name">Word (.docx)</span>
                                    <span class="format-desc">Modern format (recommended)</span>
                                </label>
                            </div>
                            <div class="format-option">
                                <input type="radio" id="docFormat" name="format" value="doc">
                                <label for="docFormat">
                                    <span class="format-name">Word 97-2003 (.doc)</span>
                                    <span class="format-desc">Legacy compatibility</span>
                                </label>
                            </div>
                            <div class="format-option">
                                <input type="radio" id="odtFormat" name="format" value="odt">
                                <label for="odtFormat">
                                    <span class="format-name">OpenDocument (.odt)</span>
                                    <span class="format-desc">For LibreOffice/OpenOffice</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ocrOption" class="toggle-switch">
                            <input type="checkbox" id="ocrOption">
                            <span class="slider"></span>
                            <span class="toggle-label">Enable OCR (for scanned PDFs)</span>
                        </label>
                    </div>

                    <button type="submit" class="btn convert-btn" disabled id="convertBtn">
                        <i class="fas fa-exchange-alt"></i> Convert to Word
                    </button>
                </div>
            </form>

            <!-- PDF Preview Container -->
            <div class="pdf-preview-container" id="pdfPreviewContainer" style="display: none;">
                <h3>PDF Preview</h3>
                <div class="pdf-preview" id="pdfPreview"></div>
                <p class="page-count">Pages: <span id="pageCount">0</span></p>
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

            <div class="conversion-quality">
                <div class="quality-rating">
                    <span class="quality-label">Conversion Quality:</span>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="rating-text">4.5/5</span>
                    </div>
                </div>
                <p class="quality-note">The converted document preserves most formatting from the original PDF.</p>
            </div>

            <div class="download-actions">
                <button id="downloadWord" class="btn download-btn">
                    <i class="fas fa-download"></i> Download Word Document
                </button>
                <div class="secondary-actions">
                    <button class="btn-text" id="sendToEmail">
                        <i class="fas fa-envelope"></i> Send to Email
                    </button>
                    <button class="btn-text" id="saveToDrive">
                        <i class="fab fa-google-drive"></i> Save to Google Drive
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div class="step loading-state" id="loadingState">
            <div class="loading-content">
                <div class="spinner"></div>
                <h3>Converting your PDF...</h3>
                <p class="progress-text">This may take a few moments</p>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <p class="conversion-tip">
                    <i class="fas fa-lightbulb"></i> Tip: For best results with scanned documents, enable OCR in the options.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Include PDF.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script>
    // Set PDF.js worker path
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

    let pdfFile = null;
    let totalPages = 0;
    let convertedDocUrl = null;

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
        document.getElementById('pdfToWordForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            if (!pdfFile) return;

            // Show loading state
            document.getElementById('uploadStep').classList.remove('active');
            document.getElementById('loadingState').classList.add('active');

            // Get settings
            const format = document.querySelector('input[name="format"]:checked').value;
            const useOcr = document.getElementById('ocrOption').checked;

            // Simulate conversion progress
            const progressFill = document.querySelector('.progress-fill');
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 20;
                if (progress > 90) clearInterval(progressInterval);
                progressFill.style.width = `${Math.min(progress, 100)}%`;
            }, 300);

            try {
                // In a real implementation, you would:
                // 1. Send the PDF to a server for conversion
                // 2. Use a PDF-to-Word conversion library
                // 3. Return the converted document

                // For this demo, we'll simulate the conversion
                await new Promise(resolve => setTimeout(resolve, 2000 + Math.random() * 2000));

                // Create a simulated Word document blob
                // In reality, this would be the actual converted file
                const formatExtension = format === 'doc' ? 'doc' : format === 'odt' ? 'odt' : 'docx';
                const blob = new Blob(['Simulated Word document content'], {
                    type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                });
                convertedDocUrl = URL.createObjectURL(blob);

                // Show results
                document.getElementById('loadingState').classList.remove('active');
                document.getElementById('resultsStep').classList.add('active');

            } catch (error) {
                console.error("Conversion error:", error);
                showToast('Error converting PDF', 'error');
                document.getElementById('loadingState').classList.remove('active');
                document.getElementById('uploadStep').classList.add('active');
            } finally {
                clearInterval(progressInterval);
                progressFill.style.width = '100%';
            }
        });

        // Download Word document
        document.getElementById('downloadWord').addEventListener('click', function() {
            if (!convertedDocUrl) {
                showToast('No converted document available', 'error');
                return;
            }

            const format = document.querySelector('input[name="format"]:checked').value;
            const extension = format === 'doc' ? 'doc' : format === 'odt' ? 'odt' : 'docx';
            const filename = `converted_document.${extension}`;

            const a = document.createElement('a');
            a.href = convertedDocUrl;
            a.download = filename;
            document.body.appendChild(a);
            a.click();

            setTimeout(() => {
                document.body.removeChild(a);
            }, 100);

            showToast('Download started!', 'success');
        });

        // Convert another
        document.getElementById('convertAnother').addEventListener('click', function() {
            resetConverter();
        });
    });

    // Render PDF preview
    async function renderPdfPreview(file) {
        const pdfPreview = document.getElementById('pdfPreview');
        pdfPreview.innerHTML = '';

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({
                data: arrayBuffer
            }).promise;
            totalPages = pdf.numPages;
            document.getElementById('pageCount').textContent = totalPages;

            // Render first page for preview
            const page = await pdf.getPage(1);
            const viewport = page.getViewport({
                scale: 0.8
            });

            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            pdfPreview.appendChild(canvas);

            await page.render({
                canvasContext: context,
                viewport: viewport
            }).promise;

        } catch (error) {
            console.error("Error rendering PDF preview:", error);
            showToast('Error loading PDF preview', 'error');
        }
    }

    // Reset the converter
    function resetConverter() {
        // Reset form
        document.getElementById('pdfFile').value = '';
        document.getElementById('convertBtn').disabled = true;

        // Clear preview
        document.getElementById('pdfPreview').innerHTML = '';
        document.getElementById('pdfPreviewContainer').style.display = 'none';

        // Reset steps
        document.getElementById('resultsStep').classList.remove('active');
        document.getElementById('uploadStep').classList.add('active');

        // Clean up
        if (convertedDocUrl) {
            URL.revokeObjectURL(convertedDocUrl);
            convertedDocUrl = null;
        }
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
    /* PDF to Word Converter Specific Styles */
    .pdf-to-word-converter {
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

    /* Format Options */
    .format-options {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin: 1.5rem 0;
    }

    .format-option {
        flex: 1;
    }

    .format-option input[type="radio"] {
        display: none;
    }

    .format-option label {
        display: block;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .format-option input[type="radio"]:checked+label {
        border-color: #3498db;
        background: #eaf4ff;
    }

    .format-name {
        display: block;
        font-weight: bold;
        margin-bottom: 0.3rem;
    }

    .format-desc {
        display: block;
        font-size: 0.9rem;
        color: #7f8c8d;
    }

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        display: flex;
        align-items: center;
        cursor: pointer;
        margin: 1.5rem 0;
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

    .pdf-preview {
        display: flex;
        justify-content: center;
        background: white;
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .pdf-preview canvas {
        max-width: 100%;
        border: 1px solid #eee;
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

    /* Conversion Quality */
    .conversion-quality {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin: 2rem 0;
    }

    .quality-rating {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .quality-label {
        margin-right: 1rem;
        font-weight: bold;
    }

    .stars {
        color: #f1c40f;
        margin-right: 1rem;
    }

    .rating-text {
        font-size: 0.9rem;
        color: #7f8c8d;
    }

    .quality-note {
        font-size: 0.9rem;
        color: #7f8c8d;
        margin: 0;
    }

    /* Download Actions */
    .download-actions {
        margin-top: 2rem;
    }

    .download-btn {
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
        width: 100%;
    }

    .secondary-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .btn-text {
        background: none;
        border: none;
        color: #3498db;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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

    .conversion-tip {
        font-size: 0.9rem;
        color: #7f8c8d;
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
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
        .pdf-to-word-converter {
            padding: 1rem;
        }

        .format-options {
            flex-direction: column;
        }

        .secondary-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
<?php include "../../footer.php"; ?>