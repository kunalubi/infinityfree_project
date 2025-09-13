<?php include '../header.php'; ?>

<div class="container py-5" style="margin-top: 80px;">
    <div class="text-center mb-5">
        <h1 class="title-font" style="background: linear-gradient(45deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
             Image Format Converter
        </h1>
        <p class="lead text-secondary">Convert your images to any format with high quality</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="imgc-upload-area mb-4 text-center p-5 border rounded-4 position-relative bg-light" id="uploadArea">
                <div class="imgc-upload-icon mb-3" style="font-size:3rem;color:var(--primary);">☁️</div>
                <div class="imgc-upload-text fw-semibold mb-2">Choose an image file</div>
                <div class="imgc-upload-subtext text-secondary mb-3">or drag it here</div>
                <button class="btn btn-primary mb-2" onclick="document.getElementById('fileInput').click()">
                    Select Image
                </button>
                <input type="file" id="fileInput" class="d-none" accept="image/*">
            </div>

            <div class="alert alert-danger d-none" id="errorMessage"></div>

            <div class="imgc-image-preview card shadow-sm mb-4 d-none" id="imagePreview">
                <div class="card-body">
                    <img id="previewImg" class="img-fluid rounded mx-auto d-block mb-3" alt="Preview" style="max-height:300px;">
                    <div class="row text-center mb-3">
                        <div class="col">
                            <div class="small text-secondary">Original Format</div>
                            <div class="fw-bold" id="originalFormat">-</div>
                        </div>
                        <div class="col">
                            <div class="small text-secondary">Dimensions</div>
                            <div class="fw-bold" id="dimensions">-</div>
                        </div>
                        <div class="col">
                            <div class="small text-secondary">File Size</div>
                            <div class="fw-bold" id="fileSize">-</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Convert to:</label>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-primary imgc-format-option" data-format="jpg">JPG</button>
                            <button type="button" class="btn btn-outline-primary imgc-format-option" data-format="png">PNG</button>
                            <button type="button" class="btn btn-outline-primary imgc-format-option" data-format="webp">WebP</button>
                            <button type="button" class="btn btn-outline-primary imgc-format-option" data-format="gif">GIF</button>
                            <button type="button" class="btn btn-outline-primary imgc-format-option" data-format="bmp">BMP</button>
                            <button type="button" class="btn btn-outline-primary imgc-format-option" data-format="ico">ICO</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Quality:</label>
                        <input type="range" class="form-range" id="qualitySlider" min="10" max="100" value="90">
                        <div class="fw-bold" id="qualityDisplay">90%</div>
                    </div>
                    <button class="btn btn-primary w-100 mb-2" id="convertBtn">Convert Image</button>
                    <button class="btn btn-success w-100 d-none" id="downloadBtn">Download Converted Image</button>
                </div>
            </div>

            <div class="text-center py-4 d-none" id="processing">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <div>Converting your image...</div>
            </div>
        </div>
    </div>
</div>

<style>
.imgc-upload-area {
    border: 3px dashed var(--primary);
    background: var(--light);
    transition: all 0.3s;
}
.imgc-upload-area.dragover {
    border-color: var(--accent);
    background: #f0f0ff;
}
.imgc-format-option.active, .imgc-format-option.selected {
    background: linear-gradient(45deg, var(--primary), var(--accent)) !important;
    color: #fff !important;
    border-color: var(--primary) !important;
}
</style>

<script>
let selectedFile = null;
let selectedFormat = 'jpg';
let convertedBlob = null;

// DOM elements
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');
const originalFormat = document.getElementById('originalFormat');
const dimensions = document.getElementById('dimensions');
const fileSize = document.getElementById('fileSize');
const formatOptions = document.querySelectorAll('.imgc-format-option');
const qualitySlider = document.getElementById('qualitySlider');
const qualityDisplay = document.getElementById('qualityDisplay');
const convertBtn = document.getElementById('convertBtn');
const downloadBtn = document.getElementById('downloadBtn');
const processing = document.getElementById('processing');
const errorMessage = document.getElementById('errorMessage');

// Event listeners
uploadArea.addEventListener('dragover', handleDragOver);
uploadArea.addEventListener('drop', handleDrop);
uploadArea.addEventListener('dragleave', handleDragLeave);
fileInput.addEventListener('change', handleFileSelect);
formatOptions.forEach(option => {
    option.addEventListener('click', () => selectFormat(option.dataset.format));
});
qualitySlider.addEventListener('input', updateQualityDisplay);
convertBtn.addEventListener('click', convertImage);
downloadBtn.addEventListener('click', downloadImage);

function handleDragOver(e) {
    e.preventDefault();
    uploadArea.classList.add('dragover');
}
function handleDragLeave(e) {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
}
function handleDrop(e) {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    const files = e.dataTransfer.files;
    if (files.length > 0) handleFile(files[0]);
}
function handleFileSelect(e) {
    const file = e.target.files[0];
    if (file) handleFile(file);
}
function handleFile(file) {
    if (!file.type.startsWith('image/')) {
        showError('Please select a valid image file.');
        return;
    }
    selectedFile = file;
    hideError();
    const reader = new FileReader();
    reader.onload = function(e) {
        previewImg.src = e.target.result;
        previewImg.onload = function() {
            dimensions.textContent = `${this.naturalWidth} × ${this.naturalHeight}`;
        };
    };
    reader.readAsDataURL(file);
    const format = file.type.split('/')[1].toUpperCase();
    originalFormat.textContent = format;
    fileSize.textContent = formatFileSize(file.size);
    imagePreview.classList.remove('d-none');
    selectFormat('jpg');
}
function selectFormat(format) {
    selectedFormat = format;
    formatOptions.forEach(option => {
        option.classList.remove('active', 'selected');
        if (option.dataset.format === format) {
            option.classList.add('active', 'selected');
        }
    });
}
function updateQualityDisplay() {
    qualityDisplay.textContent = qualitySlider.value + '%';
}
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
function showError(message) {
    errorMessage.textContent = message;
    errorMessage.classList.remove('d-none');
}
function hideError() {
    errorMessage.classList.add('d-none');
}
function convertImage() {
    if (!selectedFile) {
        showError('Please select an image first.');
        return;
    }
    processing.classList.remove('d-none');
    convertBtn.disabled = true;
    downloadBtn.classList.add('d-none');
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const img = new Image();
    img.onload = function() {
        canvas.width = img.naturalWidth;
        canvas.height = img.naturalHeight;
        ctx.drawImage(img, 0, 0);
        const quality = qualitySlider.value / 100;
        const mimeType = getMimeType(selectedFormat);
        canvas.toBlob(function(blob) {
            convertedBlob = blob;
            processing.classList.add('d-none');
            convertBtn.disabled = false;
            downloadBtn.classList.remove('d-none');
        }, mimeType, quality);
    };
    img.src = previewImg.src;
}
function getMimeType(format) {
    const mimeTypes = {
        'jpg': 'image/jpeg',
        'jpeg': 'image/jpeg',
        'png': 'image/png',
        'webp': 'image/webp',
        'gif': 'image/gif',
        'bmp': 'image/bmp',
        'ico': 'image/x-icon'
    };
    return mimeTypes[format] || 'image/jpeg';
}
function downloadImage() {
    if (!convertedBlob) {
        showError('No converted image available.');
        return;
    }
    const url = URL.createObjectURL(convertedBlob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `converted_image.${selectedFormat}`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// Initialize
selectFormat('jpg');
updateQualityDisplay();
</script>

<?php include '../footer.php'; ?>