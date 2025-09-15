<?php include '../header.php'; ?>

<div class="qr-generator-container" style="margin-top: 100px;">
    <div class="qr-generator-card">
        <div class="qr-generator-header">
            <h1 class="qr-generator-title">
                <i class="fas fa-qrcode qr-generator-icon"></i>
                QR Code Generator
            </h1>
            <p class="qr-generator-subtitle">Create beautiful QR codes with advanced customization</p>
        </div>

        <div class="qr-generator-body">
            <!-- QR Type Selection -->
            <div class="qr-generator-section">
                <label class="qr-generator-label">QR Code Type</label>
                <div class="qr-type-buttons" id="typeButtons">
                    <button class="qr-type-btn qr-type-active" data-type="Website">
                        <i class="fas fa-globe qr-type-icon"></i> Website
                    </button>
                    <button class="qr-type-btn" data-type="Text">
                        <i class="fas fa-file-alt qr-type-icon"></i> Text
                    </button>
                    <button class="qr-type-btn" data-type="Email">
                        <i class="fas fa-envelope qr-type-icon"></i> Email
                    </button>
                    <button class="qr-type-btn" data-type="Phone">
                        <i class="fas fa-phone qr-type-icon"></i> Phone
                    </button>
                    <button class="qr-type-btn" data-type="SMS">
                        <i class="fas fa-comment-dots qr-type-icon"></i> SMS
                    </button>
                    <button class="qr-type-btn" data-type="WiFi">
                        <i class="fas fa-wifi qr-type-icon"></i> Wi-Fi
                    </button>
                    <button class="qr-type-btn" data-type="Location">
                        <i class="fas fa-map-marker-alt qr-type-icon"></i> Location
                    </button>
                    <button class="qr-type-btn" data-type="vCard">
                        <i class="fas fa-id-card qr-type-icon"></i> vCard
                    </button>
                </div>
            </div>

            <!-- Quick Templates -->
            <div class="qr-generator-section">
                <label class="qr-generator-label">Quick Templates</label>
                <div class="qr-template-buttons" id="templateButtons"></div>
            </div>

            <!-- Input Field -->
            <div class="qr-generator-section">
                <!-- <label class="qr-generator-input-label" id="inputLabel">Enter URL here...</label> -->
                <textarea class="qr-generator-textarea" id="qrInput" placeholder="https://example.com"></textarea>
            </div>

            <!-- Options Grid -->
            <div class="qr-options-grid">
                <div class="qr-option-group">
                    <label class="qr-option-label">Size</label>
                    <select class="qr-generator-select" id="qrSize">
                        <option value="200">Small (200px)</option>
                        <option value="300" selected>Medium (300px)</option>
                        <option value="400">Large (400px)</option>
                        <option value="500">Extra Large (500px)</option>
                    </select>
                </div>

                <div class="qr-option-group">
                    <label class="qr-option-label">Foreground Color</label>
                    <input type="color" class="qr-generator-color" id="qrColor" value="#000000">
                </div>

                <div class="qr-option-group">
                    <label class="qr-option-label">Background Color</label>
                    <input type="color" class="qr-generator-color" id="bgColor" value="#ffffff">
                </div>

                <div class="qr-option-group">
                    <label class="qr-option-label">Error Correction</label>
                    <select class="qr-generator-select" id="errorLevel">
                        <option value="L">Low</option>
                        <option value="M" selected>Medium</option>
                        <option value="Q">Quartile</option>
                        <option value="H">High</option>
                    </select>
                </div>
            </div>

            <!-- Generate Button -->
            <button class="qr-generator-button" id="generateBtn">
                <span class="qr-generator-button-icon">
                    <i class="fas fa-qrcode"></i>
                </span>
                <span id="btnText">Generate QR Code</span>
                <span class="qr-generator-spinner" id="spinner"></span>
            </button>

            <!-- QR Output -->
            <div class="qr-output-container" id="qrOutput">
                <div class="qr-code-display" id="qrcode"></div>
                
                <div class="qr-action-buttons">
                    <button class="qr-download-button qr-download-png" id="downloadPngBtn">
                        <i class="fas fa-download qr-action-icon"></i>
                        Download PNG
                    </button>
                    <button class="qr-download-button qr-download-svg" id="downloadSvgBtn">
                        <i class="fas fa-vector-square qr-action-icon"></i>
                        Download SVG
                    </button>
                    <button class="qr-share-button" id="shareBtn">
                        <i class="fas fa-share-alt qr-action-icon"></i>
                        Share
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="qr-stats-container">
                <div class="qr-stat-item">
                    <div class="qr-stat-number" id="generatedCount">0</div>
                    <div class="qr-stat-label">Generated</div>
                </div>
                <div class="qr-stat-item">
                    <div class="qr-stat-number" id="downloadCount">0</div>
                    <div class="qr-stat-label">Downloaded</div>
                </div>
                <div class="qr-stat-item">
                    <div class="qr-stat-number" id="currentSize">300px</div>
                    <div class="qr-stat-label">Current Size</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* QR Generator Specific Styles (won't conflict with global) */
.qr-generator-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 20px;
}

.qr-generator-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    padding: 40px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.qr-generator-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    animation: qr-shimmer 3s infinite;
}

@keyframes qr-shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

.qr-generator-header {
    text-align: center;
    margin-bottom: 40px;
}

.qr-generator-title {
    font-size: 2.5em;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
    animation: qr-glow 2s ease-in-out infinite alternate;
}

@keyframes qr-glow {
    from { filter: drop-shadow(0 0 5px rgba(102, 126, 234, 0.3)); }
    to { filter: drop-shadow(0 0 20px rgba(102, 126, 234, 0.6)); }
}

.qr-generator-subtitle {
    color: #666;
    font-size: 1.1em;
    opacity: 0;
    animation: qr-fadeIn 1s ease-out 0.5s forwards;
}

@keyframes qr-fadeIn {
    to { opacity: 1; }
}

.qr-generator-section {
    margin-bottom: 30px;
}

.qr-generator-label {
    display: block;
    color: #555;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 14px;
}

.qr-type-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}

.qr-type-btn {
    border: none;
    background: rgba(241, 243, 255, 0.8);
    color: #333;
    padding: 15px 20px;
    border-radius: 15px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: 2px solid transparent;
}

.qr-type-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.3) 0%, transparent 70%);
    transition: all 0.4s ease;
    transform: translate(-50%, -50%);
    border-radius: 50%;
}

.qr-type-btn:hover::before {
    width: 200px;
    height: 200px;
}

.qr-type-active, .qr-type-btn:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    border-color: rgba(255, 255, 255, 0.3);
}

.qr-type-icon {
    font-size: 16px;
    transition: transform 0.3s ease;
}

.qr-type-btn:hover .qr-type-icon {
    transform: scale(1.2) rotate(5deg);
}

.qr-generator-textarea {
    width: 100%;
    padding: 20px;
    font-size: 16px;
    border-radius: 15px;
    border: 2px solid #e0e0e0;
    outline: none;
    background: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
    resize: vertical;
    min-height: 120px;
}

.qr-generator-textarea:focus {
    border-color: #667eea;
    background: rgba(255, 255, 255, 1);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
}

.qr-generator-input-label {
    position: absolute;
    top: 20px;
    left: 20px;
    color: #999;
    font-size: 16px;
    pointer-events: none;
    transition: all 0.3s ease;
    background: white;
    padding: 0 5px;
}

.qr-generator-input-label.active {
    top: -10px;
    font-size: 12px;
    color: #667eea;
    font-weight: 600;
}

.qr-options-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.qr-option-group {
    background: rgba(255, 255, 255, 0.5);
    padding: 20px;
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.qr-generator-select, .qr-generator-color {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 14px;
    background: white;
    transition: all 0.3s ease;
}

.qr-generator-select:focus, .qr-generator-color:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.qr-generator-button {
    width: 100%;
    padding: 18px;
    font-size: 18px;
    font-weight: 600;
    border: none;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 50px;
    cursor: pointer;
    margin-bottom: 30px;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.qr-generator-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s ease;
}

.qr-generator-button:hover::before {
    left: 100%;
}

.qr-generator-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.qr-generator-button:active {
    transform: translateY(-1px);
}

.qr-generator-button.loading {
    pointer-events: none;
    opacity: 0.8;
}

.qr-generator-spinner {
    display: none;
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: qr-spin 1s linear infinite;
}

@keyframes qr-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.qr-output-container {
    display: none;
    text-align: center;
    background: rgba(255, 255, 255, 0.6);
    padding: 30px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    animation: qr-fadeInScale 0.6s ease-out;
}

@keyframes qr-fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.qr-code-display {
    position: relative;
    display: inline-block;
    margin-bottom: 20px;
}

.qr-code-display img {
    max-width: 100%;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.qr-code-display img:hover {
    transform: scale(1.05);
}

.qr-action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.qr-download-button, .qr-share-button {
    padding: 12px 25px;
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.qr-download-button:hover, .qr-share-button:hover {
    transform: translateY(-2px);
}

.qr-download-png {
    background: linear-gradient(135deg, #28a745, #20c997);
    box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
}

.qr-download-svg {
    background: linear-gradient(135deg, #17a2b8, #138496);
    box-shadow: 0 10px 25px rgba(23, 162, 184, 0.3);
}

.qr-share-button {
    background: linear-gradient(135deg, #007bff, #6610f2);
    box-shadow: 0 10px 25px rgba(0, 123, 255, 0.3);
}

.qr-action-icon {
    font-size: 14px;
}

.qr-template-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.qr-template-btn {
    padding: 8px 15px;
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    border: 1px solid rgba(102, 126, 234, 0.3);
    border-radius: 20px;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.3s ease;
}

.qr-template-btn:hover {
    background: #667eea;
    color: white;
    transform: translateY(-1px);
}

.qr-stats-container {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 15px;
}

.qr-stat-item {
    text-align: center;
}

.qr-stat-number {
    font-size: 1.5em;
    font-weight: bold;
    color: #667eea;
}

.qr-stat-label {
    font-size: 0.9em;
    color: #666;
}

@media (max-width: 768px) {
    .qr-generator-card {
        padding: 20px;
    }
    
    .qr-generator-title {
        font-size: 2em;
    }
    
    .qr-type-buttons {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .qr-options-grid {
        grid-template-columns: 1fr;
    }
    
    .qr-action-buttons {
        flex-direction: column;
    }
}
</style>

<script>
// JavaScript remains exactly the same as your original
// Only the HTML structure and class names have changed
const placeholders = {
    Website: "Enter website URL (https://...)",
    Text: "Enter plain text or message",
    Email: "Enter email address (user@example.com)",
    Phone: "Enter phone number (+1234567890)",
    SMS: "Format: +1234567890:Your message here",
    WiFi: "Format: WIFI:T:WPA;S:NetworkName;P:Password;;",
    Location: "Format: geo:latitude,longitude (e.g. geo:37.7749,-122.4194)",
    vCard: "Enter vCard data or contact information"
};

const templates = {
    Website: ["https://google.com", "https://github.com", "https://stackoverflow.com"],
    Text: ["Hello World!", "Meeting at 3 PM", "Check this out!"],
    Email: ["contact@company.com", "support@website.com", "hello@example.com"],
    Phone: ["+1234567890", "+911234567890", "+447123456789"],
    SMS: ["+1234567890:Hello!", "+1234567890:Meeting reminder", "+1234567890:Thank you!"],
    WiFi: ["WIFI:T:WPA;S:MyNetwork;P:password123;;", "WIFI:T:WEP;S:Guest;P:guest123;;"],
    Location: ["geo:37.7749,-122.4194", "geo:40.7128,-74.0060", "geo:51.5074,-0.1278"],
    vCard: ["BEGIN:VCARD\nVERSION:3.0\nFN:John Doe\nTEL:+1234567890\nEMAIL:john@example.com\nEND:VCARD"]
};

let selectedType = "Website";
let generatedCount = 0;
let downloadCount = 0;

const inputField = document.getElementById("qrInput");
const inputLabel = document.getElementById("inputLabel");
const sizeSelect = document.getElementById("qrSize");

// Initialize
updateTemplates();
setupFloatingLabel();

// Handle type selection
document.querySelectorAll(".qr-type-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        document.querySelectorAll(".qr-type-btn").forEach(b => b.classList.remove("qr-type-active"));
        btn.classList.add("qr-type-active");
        selectedType = btn.dataset.type;
        inputLabel.textContent = placeholders[selectedType];
        inputField.value = '';
        updateTemplates();
        document.getElementById("qrOutput").style.display = 'none';
    });
});

// Size change handler
sizeSelect.addEventListener('change', () => {
    document.getElementById('currentSize').textContent = sizeSelect.value + 'px';
});

function setupFloatingLabel() {
    inputField.addEventListener('input', updateFloatingLabel);
    inputField.addEventListener('focus', updateFloatingLabel);
    inputField.addEventListener('blur', updateFloatingLabel);
}

function updateFloatingLabel() {
    if (inputField.value.trim() || document.activeElement === inputField) {
        inputLabel.classList.add('active');
    } else {
        inputLabel.classList.remove('active');
    }
}

function updateTemplates() {
    const templateButtons = document.getElementById('templateButtons');
    templateButtons.innerHTML = '';
    
    if (templates[selectedType]) {
        templates[selectedType].forEach(template => {
            const btn = document.createElement('button');
            btn.className = 'qr-template-btn';
            btn.textContent = template.length > 30 ? template.substring(0, 30) + '...' : template;
            btn.onclick = () => {
                inputField.value = template;
                updateFloatingLabel();
            };
            templateButtons.appendChild(btn);
        });
    }
}

document.getElementById('generateBtn').addEventListener('click', generateQR);
document.getElementById('downloadPngBtn').addEventListener('click', () => downloadQR('png'));
document.getElementById('downloadSvgBtn').addEventListener('click', () => downloadQR('svg'));
document.getElementById('shareBtn').addEventListener('click', shareQR);

function generateQR() {
    const text = inputField.value.trim();
    if (!text) {
        inputField.focus();
        return;
    }

    const size = document.getElementById('qrSize').value;
    const fgColor = document.getElementById('qrColor').value.substring(1);
    const bgColor = document.getElementById('bgColor').value.substring(1);
    const errorLevel = document.getElementById('errorLevel').value;

    // Show loading state
    const btn = document.getElementById('generateBtn');
    const spinner = document.getElementById('spinner');
    const btnText = document.getElementById('btnText');
    
    btn.classList.add('loading');
    spinner.style.display = 'inline-block';
    btnText.textContent = 'Generating...';

    const url = `https://api.qrserver.com/v1/create-qr-code/?size=${size}x${size}&data=${encodeURIComponent(text)}&color=${fgColor}&bgcolor=${bgColor}&ecc=${errorLevel}&margin=20`;

    const img = new Image();
    img.crossOrigin = "anonymous";
    
    img.onload = () => {
        document.getElementById("qrcode").innerHTML = '';
        document.getElementById("qrcode").appendChild(img);
        document.getElementById("qrOutput").style.display = "block";
        
        // Update stats
        generatedCount++;
        document.getElementById('generatedCount').textContent = generatedCount;
        
        // Reset button state
        btn.classList.remove('loading');
        spinner.style.display = 'none';
        btnText.textContent = 'Generate QR Code';
        
        // Scroll to result
        document.getElementById("qrOutput").scrollIntoView({ behavior: 'smooth' });
    };

    img.onerror = () => {
        alert('Error generating QR code. Please try again.');
        btn.classList.remove('loading');
        spinner.style.display = 'none';
        btnText.textContent = 'Generate QR Code';
    };

    img.src = url;
}

function downloadQR(format = 'png') {
    const img = document.querySelector("#qrcode img");
    if (!img) return;

    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");
    canvas.width = img.naturalWidth;
    canvas.height = img.naturalHeight;
    ctx.drawImage(img, 0, 0);

    if (format === 'svg') {
        const svgData = `<svg xmlns="http://www.w3.org/2000/svg" width="${canvas.width}" height="${canvas.height}">
            <image href="${img.src}" width="${canvas.width}" height="${canvas.height}"/>
        </svg>`;
        
        const blob = new Blob([svgData], { type: 'image/svg+xml' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = `qrcode_${Date.now()}.svg`;
        a.click();
        URL.revokeObjectURL(url);
    } else {
        canvas.toBlob(blob => {
            const a = document.createElement("a");
            a.href = URL.createObjectURL(blob);
            a.download = `qrcode_${Date.now()}.${format}`;
            a.click();
            URL.revokeObjectURL(a.href);
        });
    }

    downloadCount++;
    document.getElementById('downloadCount').textContent = downloadCount;
}

function shareQR() {
    const img = document.querySelector("#qrcode img");
    if (!img) return;

    if (navigator.share) {
        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        canvas.width = img.naturalWidth;
        canvas.height = img.naturalHeight;
        ctx.drawImage(img, 0, 0);
        
        canvas.toBlob(blob => {
            const file = new File([blob], 'qrcode.png', { type: 'image/png' });
            navigator.share({
                title: 'QR Code',
                text: 'Check out this QR code!',
                files: [file]
            });
        });
    } else {
        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        canvas.width = img.naturalWidth;
        canvas.height = img.naturalHeight;
        ctx.drawImage(img, 0, 0);
        
        canvas.toBlob(blob => {
            const url = URL.createObjectURL(blob);
            navigator.clipboard.writeText(url).then(() => {
                alert('QR code URL copied to clipboard!');
            });
        });
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    if (e.ctrlKey || e.metaKey) {
        if (e.key === 'Enter') {
            e.preventDefault();
            generateQR();
        }
    }
});

// Auto-generate on input (debounced)
let debounceTimer;
inputField.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        if (inputField.value.trim().length > 5) {
            generateQR();
        }
    }, 1000);
});
</script>

<?php include '../footer.php'; ?>