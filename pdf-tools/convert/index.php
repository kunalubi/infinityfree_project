<?php include '../../header.php'; ?>
    <div class="tool-intro">
        <h1>Convert PDF Files</h1>
        <p>Transform your PDFs into other formats or create PDFs from different file types.</p>
    </div>

    <div class="tool-grid">
        <div class="tool-card">
            <h2><i class="fas fa-file-image"></i> PDF to JPG</h2>
            <p>Convert each page of your PDF to high-quality JPG images.</p>
            <a href="to-jpg.php" class="btn">Convert to JPG</a>
        </div>
        <div class="tool-card">
            <h2><i class="fas fa-file-image"></i> PDF to PNG</h2>
            <p>Convert PDF pages to PNG images with transparent backgrounds.</p>
            <a href="to-png.php" class="btn">Convert to PNG</a>
        </div>
        <div class="tool-card">
            <h2><i class="fas fa-file-word"></i> PDF to Word</h2>
            <p>Convert PDF files to editable Word documents.</p>
            <a href="to-word.php" class="btn">Convert to Word</a>
        </div>
        <div class="tool-card">
            <h2><i class="fas fa-file-excel"></i> PDF to Excel</h2>
            <p>Extract tables from PDFs to editable Excel spreadsheets.</p>
            <a href="to-excel.php" class="btn">Convert to Excel</a>
        </div>
    </div>
    <div class="tool-card">
        <h1>PDF Converter</h1>
        <p>Convert your PDF files to Word, Excel, JPG, PNG and more.</p>
        <div class="file-upload-area">
            <div class="file-upload">
                <input type="file" id="pdfFile" accept=".pdf" required>
                <label for="pdfFile" class="file-upload-label">Choose PDF file to convert</label>
            </div>
        </div>
        <div class="result-container" style="display: none;">
            <!-- Conversion result will be shown here -->
        </div>
    </div>
    <script src="/pdf-tools/convert/js/convert.js"></script>
<?php include '../../footer.php'; ?>