<?php include '../header.php'; ?>

<div class="container py-5" style="margin-top: 80px;">
    <div class="text-center mb-5">
        <h1 class="title-font" style="background: linear-gradient(45deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            📐 Image Resizer
        </h1>
        <p class="lead text-secondary">Resize your images with perfect quality and aspect ratio control</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="imgr-upload-area mb-4 text-center p-5 border rounded-4 position-relative bg-light" id="uploadArea">
                <div class="imgr-upload-icon mb-3" style="font-size:3rem;color:var(--primary);">☁️</div>
                <div class="imgr-upload-text fw-semibold mb-2">Choose an image file</div>
                <div class="imgr-upload-subtext text-secondary mb-3">or drag it here</div>
                <button class="btn btn-primary mb-2" onclick="document.getElementById('fileInput').click()">
                    Select Image
                </button>
                <input type="file" id="fileInput" class="d-none" accept="image/*">
            </div>

            <div class="alert alert-danger d-none" id="errorMessage"></div>

            <div class="imgr-image-preview card shadow-sm mb-4 d-none" id="imagePreview">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 text-center mb-3 mb-md-0">
                            <div class="fw-semibold mb-2">Original Image</div>
                            <img id="originalImg" class="img-fluid rounded border" alt="Original">
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="fw-semibold mb-2">Resized Preview</div>
                            <img id="resizedImg" class="img-fluid rounded border d-none" alt="Resized Preview">
                            <div id="previewPlaceholder" style="display: flex; align-items: center; justify-content: center; min-height: 200px; background: #f0f0f0; border-radius: 10px; color: #666;">
                                Preview will appear here
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mb-3">
                        <div class="col">
                            <div class="small text-secondary">Original Format</div>
                            <div class="fw-bold" id="originalFormat">-</div>
                        </div>
                        <div class="col">
                            <div class="small text-secondary">Original Size</div>
                            <div class="fw-bold" id="originalDimensions">-</div>
                        </div>
                        <div class="col">
                            <div class="small text-secondary">File Size</div>
                            <div class="fw-bold" id="fileSize">-</div>
                        </div>
                        <div class="col">
                            <div class="small text-secondary">New Size</div>
                            <div class="fw-bold" id="newDimensions">-</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Resize Method:</label>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-primary imgr-resize-method active" data-method="custom">Custom Size</button>
                            <button type="button" class="btn btn-outline-primary imgr-resize-method" data-method="percentage">Percentage</button>
                            <button type="button" class="btn btn-outline-primary imgr-resize-method" data-method="preset">Preset Sizes</button>
                        </div>
                    </div>

                    <div class="row g-3 mb-3" id="customInputs">
                        <div class="col-md-6">
                            <label class="form-label">Width (px)</label>
                            <input type="number" class="form-control" id="widthInput" placeholder="Enter width">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Height (px) <span class="imgr-chain-icon" id="chainIcon">🔗</span></label>
                            <input type="number" class="form-control" id="heightInput" placeholder="Enter height">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-none" id="percentageInputs">
                        <div class="col-md-6">
                            <label class="form-label">Scale Percentage (%)</label>
                            <input type="number" class="form-control" id="percentageInput" placeholder="Enter percentage" min="1" max="500" value="100">
                        </div>
                    </div>

                    <div class="mb-3 d-none" id="presetSizes">
                        <label class="fw-semibold mb-2">Common Sizes:</label>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-secondary imgr-preset-btn" data-width="1920" data-height="1080">1920×1080 (Full HD)</button>
                            <button class="btn btn-outline-secondary imgr-preset-btn" data-width="1280" data-height="720">1280×720 (HD)</button>
                            <button class="btn btn-outline-secondary imgr-preset-btn" data-width="800" data-height="600">800×600</button>
                            <button class="btn btn-outline-secondary imgr-preset-btn" data-width="640" data-height="480">640×480</button>
                            <button class="btn btn-outline-secondary imgr-preset-btn" data-width="512" data-height="512">512×512 (Square)</button>
                            <button class="btn btn-outline-secondary imgr-preset-btn" data-width="300" data-height="300">300×300 (Thumbnail)</button>
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="aspectRatioToggle" checked>
                        <label class="form-check-label" for="aspectRatioToggle">Maintain aspect ratio</label>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Quality:</label>
                        <input type="range" class="form-range" id="qualitySlider" min="10" max="100" value="90">
                        <div class="fw-bold" id="qualityDisplay">90%</div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Output Format:</label>
                        <select id="outputFormat" class="form-select">
                            <option value="image/jpeg">JPEG</option>
                            <option value="image/png">PNG</option>
                            <option value="image/webp">WEBP</option>
                        </select>
                    </div>

                    <button class="btn btn-primary w-100 mb-2" id="resizeBtn">Resize Image</button>

                    <div class="text-center py-4 d-none" id="downloadSection">
                        <div class="text-success fw-semibold mb-3">
                            ✅ Image resized successfully!
                        </div>
                        <button class="btn btn-success me-2" id="downloadBtn">Download Resized Image</button>
                        <button class="btn btn-outline-secondary" id="resizeAnotherBtn">Resize Another Image</button>
                        <div id="estimatedSize" class="mt-2">Estimated file size: -</div>
                    </div>
                </div>
            </div>

            <div class="text-center py-4 d-none" id="processing">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <div>Resizing your image...</div>
            </div>
        </div>
    </div>
</div>

<style>
.imgr-upload-area {
    border: 3px dashed var(--primary);
    background: var(--light);
    transition: all 0.3s;
}
.imgr-upload-area.dragover {
    border-color: var(--accent);
    background: #f0f0ff;
}
.imgr-upload-icon { }
.imgr-upload-text { }
.imgr-upload-subtext { }
.imgr-chain-icon {
    font-size: 1.2rem;
    margin-left: 10px;
    color: var(--primary);
}
.imgr-chain-icon.locked {
    color: #28a745;
}
.imgr-resize-method.active, .imgr-resize-method.selected {
    background: linear-gradient(45deg, var(--primary), var(--accent)) !important;
    color: #fff !important;
    border-color: var(--primary) !important;
}
</style>

<script>
let selectedFile = null;
let resizedBlob = null;
let originalWidth = 0;
let originalHeight = 0;
let aspectRatio = 1;
let resizeMethod = 'custom';

// DOM elements
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const imagePreview = document.getElementById('imagePreview');
const originalImg = document.getElementById('originalImg');
const resizedImg = document.getElementById('resizedImg');
const previewPlaceholder = document.getElementById('previewPlaceholder');
const originalFormat = document.getElementById('originalFormat');
const originalDimensions = document.getElementById('originalDimensions');
const fileSize = document.getElementById('fileSize');
const newDimensions = document.getElementById('newDimensions');
const resizeMethods = document.querySelectorAll('.imgr-resize-method');
const customInputs = document.getElementById('customInputs');
const percentageInputs = document.getElementById('percentageInputs');
const presetSizes = document.getElementById('presetSizes');
const widthInput = document.getElementById('widthInput');
const heightInput = document.getElementById('heightInput');
const percentageInput = document.getElementById('percentageInput');
const presetButtons = document.querySelectorAll('.imgr-preset-btn');
const aspectRatioToggle = document.getElementById('aspectRatioToggle');
const chainIcon = document.getElementById('chainIcon');
const qualitySlider = document.getElementById('qualitySlider');
const qualityDisplay = document.getElementById('qualityDisplay');
const resizeBtn = document.getElementById('resizeBtn');
const downloadBtn = document.getElementById('downloadBtn');
const resizeAnotherBtn = document.getElementById('resizeAnotherBtn');
const downloadSection = document.getElementById('downloadSection');
const processing = document.getElementById('processing');
const errorMessage = document.getElementById('errorMessage');
const outputFormat = document.getElementById('outputFormat');

// Event listeners
uploadArea.addEventListener('dragover', handleDragOver);
uploadArea.addEventListener('drop', handleDrop);
uploadArea.addEventListener('dragleave', handleDragLeave);
fileInput.addEventListener('change', handleFileSelect);
resizeMethods.forEach(method => {
    method.addEventListener('click', () => selectResizeMethod(method.dataset.method));
});
widthInput.addEventListener('input', handleWidthInput);
heightInput.addEventListener('input', handleHeightInput);
percentageInput.addEventListener('input', handlePercentageInput);
presetButtons.forEach(btn => {
    btn.addEventListener('click', () => setPresetSize(btn.dataset.width, btn.dataset.height));
});
aspectRatioToggle.addEventListener('change', updateAspectRatioIcon);
qualitySlider.addEventListener('input', updateQualityDisplay);
resizeBtn.addEventListener('click', resizeImage);
downloadBtn.addEventListener('click', downloadImage);
resizeAnotherBtn.addEventListener('click', resetForNewResize);

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
    if (files.length > 0) {
        handleFile(files[0]);
    }
}
function handleFileSelect(e) {
    const file = e.target.files[0];
    if (file) {
        handleFile(file);
    }
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
        originalImg.src = e.target.result;
        originalImg.onload = function() {
            originalWidth = this.naturalWidth;
            originalHeight = this.naturalHeight;
            aspectRatio = originalWidth / originalHeight;
            
            originalDimensions.textContent = `${originalWidth} × ${originalHeight}`;
            widthInput.value = originalWidth;
            heightInput.value = originalHeight;
            updateNewDimensions();
        };
    };
    reader.readAsDataURL(file);

    const format = file.type.split('/')[1].toUpperCase();
    originalFormat.textContent = format;
    
    const size = formatFileSize(file.size);
    fileSize.textContent = size;

    imagePreview.classList.remove('d-none');
    downloadSection.classList.add('d-none');
    resizeBtn.classList.remove('d-none');
    resetPreview();
}
function selectResizeMethod(method) {
    resizeMethod = method;
    resizeMethods.forEach(m => m.classList.remove('active', 'selected'));
    event.target.classList.add('active', 'selected');

    customInputs.classList.toggle('d-none', method !== 'custom');
    percentageInputs.classList.toggle('d-none', method !== 'percentage');
    presetSizes.classList.toggle('d-none', method !== 'preset');

    updateNewDimensions();
}
function handleWidthInput() {
    if (aspectRatioToggle.checked && widthInput.value && originalWidth) {
        const newWidth = parseInt(widthInput.value);
        const newHeight = Math.round(newWidth / aspectRatio);
        heightInput.value = newHeight;
    }
    updateNewDimensions();
}
function handleHeightInput() {
    if (aspectRatioToggle.checked && heightInput.value && originalHeight) {
        const newHeight = parseInt(heightInput.value);
        const newWidth = Math.round(newHeight * aspectRatio);
        widthInput.value = newWidth;
    }
    updateNewDimensions();
}
function handlePercentageInput() {
    if (percentageInput.value && originalWidth && originalHeight) {
        const percentage = parseInt(percentageInput.value) / 100;
        const newWidth = Math.round(originalWidth * percentage);
        const newHeight = Math.round(originalHeight * percentage);
        widthInput.value = newWidth;
        heightInput.value = newHeight;
    }
    updateNewDimensions();
}
function setPresetSize(width, height) {
    widthInput.value = width;
    heightInput.value = height;
    updateNewDimensions();
}
function updateAspectRatioIcon() {
    chainIcon.textContent = aspectRatioToggle.checked ? '🔗' : '🔓';
    chainIcon.classList.toggle('locked', aspectRatioToggle.checked);
}
function updateNewDimensions() {
    let newWidth, newHeight;

    if (resizeMethod === 'percentage' && percentageInput.value) {
        const percentage = parseInt(percentageInput.value) / 100;
        newWidth = Math.round(originalWidth * percentage);
        newHeight = Math.round(originalHeight * percentage);
    } else {
        newWidth = parseInt(widthInput.value) || originalWidth;
        newHeight = parseInt(heightInput.value) || originalHeight;
    }

    newDimensions.textContent = `${newWidth} × ${newHeight}`;
    generatePreview(newWidth, newHeight);
}
function generatePreview(width, height) {
    if (!selectedFile) return;

    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = width;
    canvas.height = height;

    const img = new Image();
    img.onload = function() {
        ctx.drawImage(img, 0, 0, width, height);
        const previewDataUrl = canvas.toDataURL('image/jpeg', 0.8);
        
        resizedImg.src = previewDataUrl;
        resizedImg.classList.remove('d-none');
        previewPlaceholder.style.display = 'none';
    };
    img.src = originalImg.src;
}
function resetPreview() {
    resizedImg.classList.add('d-none');
    previewPlaceholder.style.display = 'flex';
    newDimensions.textContent = '-';
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
function resizeImage() {
    if (!selectedFile) {
        showError('Please select an image first.');
        return;
    }

    let newWidth, newHeight;

    if (resizeMethod === 'percentage' && percentageInput.value) {
        const percentage = parseInt(percentageInput.value) / 100;
        newWidth = Math.round(originalWidth * percentage);
        newHeight = Math.round(originalHeight * percentage);
    } else {
        newWidth = parseInt(widthInput.value) || originalWidth;
        newHeight = parseInt(heightInput.value) || originalHeight;
    }

    if (newWidth <= 0 || newHeight <= 0) {
        showError('Please enter valid dimensions.');
        return;
    }

    processing.classList.remove('d-none');
    resizeBtn.disabled = true;
    downloadSection.classList.add('d-none');
    hideError();

    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = newWidth;
    canvas.height = newHeight;

    const img = new Image();
    img.onload = function() {
        ctx.drawImage(img, 0, 0, newWidth, newHeight);

        const quality = qualitySlider.value / 100;
        canvas.toBlob(function(blob) {
            if (blob) {
                resizedBlob = blob;
                const estimatedSize = formatFileSize(blob.size);
                document.getElementById('estimatedSize').textContent = 'Estimated file size: ' + estimatedSize;
                processing.classList.add('d-none');
                resizeBtn.classList.add('d-none');
                downloadSection.classList.remove('d-none');
            } else {
                processing.classList.add('d-none');
                resizeBtn.disabled = false;
                resizeBtn.classList.remove('d-none');
                showError('Failed to resize the image. Please try again.');
            }
        }, outputFormat.value, quality);
    };
    img.onerror = function() {
        processing.classList.add('d-none');
        resizeBtn.disabled = false;
        resizeBtn.classList.remove('d-none');
        showError('Failed to load the image for resizing.');
    };
    img.src = originalImg.src;
}
function downloadImage() {
    if (!resizedBlob) return;
    const url = URL.createObjectURL(resizedBlob);
    const a = document.createElement('a');
    let ext = 'jpg';
    if (outputFormat.value === 'image/png') ext = 'png';
    if (outputFormat.value === 'image/webp') ext = 'webp';
    a.href = url;
    a.download = 'resized-image.' + ext;
    document.body.appendChild(a);
    a.click();
    setTimeout(() => {
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }, 100);
}
function resetForNewResize() {
    selectedFile = null;
    resizedBlob = null;
    originalWidth = 0;
    originalHeight = 0;
    aspectRatio = 1;
    resizeMethod = 'custom';
    fileInput.value = '';
    imagePreview.classList.add('d-none');
    downloadSection.classList.add('d-none');
    resizeBtn.classList.remove('d-none');
    resizeBtn.disabled = false;
    hideError();
}
</script>

<?php include '../footer.php'; ?>