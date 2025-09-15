<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Split & Merge Tool</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 2.5em;
            font-weight: 700;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        
        .tabs {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 30px;
        }
        
        .tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            background: none;
            border: none;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #666;
        }
        
        .tab.active {
            color: #667eea;
            border-bottom: 3px solid #667eea;
        }
        
        .tab:hover {
            background: rgba(102, 126, 234, 0.1);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .upload-zone {
            border: 3px dashed #667eea;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s ease;
            cursor: pointer;
            background: linear-gradient(45deg, #f8f9ff, #fff);
        }
        
        .upload-zone:hover {
            border-color: #764ba2;
            background: linear-gradient(45deg, #f0f2ff, #fff);
            transform: translateY(-2px);
        }
        
        .upload-zone.dragover {
            border-color: #764ba2;
            background: linear-gradient(45deg, #e8ecff, #fff);
            transform: scale(1.02);
        }
        
        .upload-icon {
            font-size: 3em;
            margin-bottom: 15px;
            color: #667eea;
        }
        
        .upload-text {
            color: #333;
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        
        .upload-subtext {
            color: #666;
            font-size: 0.9em;
        }
        
        .file-list {
            margin: 20px 0;
        }
        
        .file-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: white;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .file-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        
        .file-icon {
            font-size: 2em;
            margin-right: 15px;
            color: #667eea;
        }
        
        .file-info {
            flex: 1;
        }
        
        .file-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .file-details {
            color: #666;
            font-size: 0.9em;
        }
        
        .file-actions {
            display: flex;
            gap: 10px;
        }
        
        .controls {
            background: #f8f9ff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .control-group {
            margin-bottom: 15px;
        }
        
        .control-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .control-group input {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        
        .control-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .range-input {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .range-input input[type="range"] {
            flex: 1;
            height: 6px;
            border-radius: 3px;
            background: #ddd;
            outline: none;
            -webkit-appearance: none;
        }
        
        .range-input input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        
        .range-value {
            min-width: 60px;
            text-align: center;
            background: #667eea;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: 600;
        }
        
        button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-small {
            padding: 8px 16px;
            font-size: 0.9em;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }
        
        .btn-danger:hover {
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
        }
        
        .processing {
            text-align: center;
            color: #667eea;
            font-style: italic;
            margin: 20px 0;
        }
        
        .hidden {
            display: none;
        }
        
        .merge-list {
            min-height: 200px;
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 20px;
            background: #f9f9f9;
        }
        
        .merge-item {
            display: flex;
            align-items: center;
            padding: 10px;
            background: white;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            cursor: move;
        }
        
        .merge-item.dragging {
            opacity: 0.5;
        }
        
        .drag-handle {
            margin-right: 10px;
            color: #999;
            cursor: move;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #ddd;
            border-radius: 4px;
            overflow: hidden;
            margin: 10px 0;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
            width: 0%;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            h1 {
                font-size: 2em;
            }
            
            .tabs {
                flex-direction: column;
            }
            
            .file-item {
                flex-direction: column;
                text-align: center;
            }
            
            .file-actions {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📄 PDF Split & Merge</h1>
        <p class="subtitle">Split PDFs into pages or merge multiple PDFs</p>
        
        <div class="tabs">
            <button class="tab active" onclick="switchTab('split')">Split PDF</button>
            <button class="tab" onclick="switchTab('merge')">Merge PDFs</button>
        </div>
        
        <!-- Split PDF Tab -->
        <div id="split-tab" class="tab-content active">
            <div class="upload-zone" id="splitUploadZone">
                <div class="upload-icon">📄</div>
                <div class="upload-text">Drop PDF file here or click to browse</div>
                <div class="upload-subtext">Only PDF files are supported</div>
            </div>
            
            <input type="file" id="splitFileInput" accept=".pdf" class="hidden">
            
            <div id="splitFileList" class="file-list"></div>
            
            <div id="splitControls" class="controls hidden">
                <div class="control-group">
                    <label>Split Options:</label>
                    <div style="margin-top: 10px;">
                        <label style="display: inline-flex; align-items: center; margin-right: 20px;">
                            <input type="radio" name="splitType" value="all" checked style="margin-right: 8px;">
                            Split into individual pages
                        </label>
                        <label style="display: inline-flex; align-items: center; margin-right: 20px;">
                            <input type="radio" name="splitType" value="range" style="margin-right: 8px;">
                            Split by page range
                        </label>
                        <label style="display: inline-flex; align-items: center;">
                            <input type="radio" name="splitType" value="chunks" style="margin-right: 8px;">
                            Split into chunks
                        </label>
                    </div>
                </div>
                
                <div id="rangeControls" class="control-group hidden">
                    <label>Page Range (e.g., 1-5, 7, 10-15):</label>
                    <input type="text" id="pageRange" placeholder="1-5, 7, 10-15">
                </div>
                
                <div id="chunkControls" class="control-group hidden">
                    <label>Pages per chunk:</label>
                    <div class="range-input">
                        <input type="range" id="chunkSize" min="1" max="20" value="5">
                        <div class="range-value" id="chunkSizeValue">5</div>
                    </div>
                </div>
                
                <button id="splitBtn" onclick="splitPDF()">Split PDF</button>
            </div>
            
            <div id="splitProgress" class="processing hidden">
                <div>Processing PDF...</div>
                <div class="progress-bar">
                    <div class="progress-fill" id="splitProgressFill"></div>
                </div>
            </div>
            
            <div id="splitResults" class="file-list hidden"></div>
        </div>
        
        <!-- Merge PDF Tab -->
        <div id="merge-tab" class="tab-content">
            <div class="upload-zone" id="mergeUploadZone">
                <div class="upload-icon">📄</div>
                <div class="upload-text">Drop PDF files here or click to browse</div>
                <div class="upload-subtext">Select multiple PDF files to merge</div>
            </div>
            
            <input type="file" id="mergeFileInput" accept=".pdf" multiple class="hidden">
            
            <div id="mergeFileList" class="file-list">
                <div class="merge-list" id="mergeList">
                    <div style="text-align: center; color: #999; padding: 40px;">
                        No files selected. Add PDF files to merge them.
                    </div>
                </div>
            </div>
            
            <div id="mergeControls" class="controls hidden">
                <div class="control-group">
                    <label>Output filename:</label>
                    <input type="text" id="mergeFileName" value="merged-document.pdf">
                </div>
                
                <button id="mergeBtn" onclick="mergePDFs()">Merge PDFs</button>
                <button class="btn-danger btn-small" onclick="clearMergeList()">Clear All</button>
            </div>
            
            <div id="mergeProgress" class="processing hidden">
                <div>Merging PDFs...</div>
                <div class="progress-bar">
                    <div class="progress-fill" id="mergeProgressFill"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let splitPdfData = null;
        let splitPdfDoc = null;
        let mergeFiles = [];
        let draggedElement = null;
        
        // Initialize event listeners
        document.addEventListener('DOMContentLoaded', function() {
            initializeSplitTab();
            initializeMergeTab();
            initializeRangeControls();
        });
        
        function switchTab(tabName) {
            // Update tab buttons
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.querySelector(`[onclick="switchTab('${tabName}')"]`).classList.add('active');
            
            // Update tab content
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            document.getElementById(`${tabName}-tab`).classList.add('active');
        }
        
        function initializeSplitTab() {
            const uploadZone = document.getElementById('splitUploadZone');
            const fileInput = document.getElementById('splitFileInput');
            
            uploadZone.addEventListener('click', () => fileInput.click());
            uploadZone.addEventListener('dragover', handleDragOver);
            uploadZone.addEventListener('dragleave', handleDragLeave);
            uploadZone.addEventListener('drop', (e) => handleDrop(e, handleSplitFile));
            
            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    handleSplitFile(e.target.files[0]);
                }
            });
        }
        
        function initializeMergeTab() {
            const uploadZone = document.getElementById('mergeUploadZone');
            const fileInput = document.getElementById('mergeFileInput');
            
            uploadZone.addEventListener('click', () => fileInput.click());
            uploadZone.addEventListener('dragover', handleDragOver);
            uploadZone.addEventListener('dragleave', handleDragLeave);
            uploadZone.addEventListener('drop', (e) => handleDrop(e, handleMergeFiles));
            
            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    handleMergeFiles(Array.from(e.target.files));
                }
            });
        }
        
        function initializeRangeControls() {
            const splitTypeRadios = document.querySelectorAll('input[name="splitType"]');
            const rangeControls = document.getElementById('rangeControls');
            const chunkControls = document.getElementById('chunkControls');
            const chunkSize = document.getElementById('chunkSize');
            const chunkSizeValue = document.getElementById('chunkSizeValue');
            
            splitTypeRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    rangeControls.classList.toggle('hidden', radio.value !== 'range');
                    chunkControls.classList.toggle('hidden', radio.value !== 'chunks');
                });
            });
            
            chunkSize.addEventListener('input', () => {
                chunkSizeValue.textContent = chunkSize.value;
            });
        }
        
        function handleDragOver(e) {
            e.preventDefault();
            e.currentTarget.classList.add('dragover');
        }
        
        function handleDragLeave(e) {
            e.currentTarget.classList.remove('dragover');
        }
        
        function handleDrop(e, handler) {
            e.preventDefault();
            e.currentTarget.classList.remove('dragover');
            const files = Array.from(e.dataTransfer.files).filter(file => file.type === 'application/pdf');
            if (files.length > 0) {
                handler(files.length === 1 ? files[0] : files);
            }
        }
        
        async function handleSplitFile(file) {
            if (file.type !== 'application/pdf') {
                alert('Please select a PDF file.');
                return;
            }
            
            try {
                const arrayBuffer = await file.arrayBuffer();
                splitPdfData = new Uint8Array(arrayBuffer);
                splitPdfDoc = await PDFLib.PDFDocument.load(splitPdfData);
                
                const pageCount = splitPdfDoc.getPageCount();
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                
                const fileList = document.getElementById('splitFileList');
                fileList.innerHTML = `
                    <div class="file-item">
                        <div class="file-icon">📄</div>
                        <div class="file-info">
                            <div class="file-name">${file.name}</div>
                            <div class="file-details">${pageCount} pages • ${fileSize} MB</div>
                        </div>
                    </div>
                `;
                
                document.getElementById('splitControls').classList.remove('hidden');
                
                // Update chunk size max value
                const chunkSizeSlider = document.getElementById('chunkSize');
                chunkSizeSlider.max = Math.max(1, Math.floor(pageCount / 2));
                
            } catch (error) {
                alert('Error loading PDF file: ' + error.message);
            }
        }
        
        function handleMergeFiles(files) {
            files.forEach(file => {
                if (file.type === 'application/pdf') {
                    mergeFiles.push({
                        file: file,
                        name: file.name,
                        size: (file.size / 1024 / 1024).toFixed(2)
                    });
                }
            });
            
            updateMergeList();
            document.getElementById('mergeControls').classList.remove('hidden');
        }
        
        function updateMergeList() {
            const mergeList = document.getElementById('mergeList');
            
            if (mergeFiles.length === 0) {
                mergeList.innerHTML = `
                    <div style="text-align: center; color: #999; padding: 40px;">
                        No files selected. Add PDF files to merge them.
                    </div>
                `;
                return;
            }
            
            mergeList.innerHTML = mergeFiles.map((file, index) => `
                <div class="merge-item" draggable="true" data-index="${index}">
                    <div class="drag-handle">⋮⋮</div>
                    <div class="file-icon">📄</div>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-details">${file.size} MB</div>
                    </div>
                    <div class="file-actions">
                        <button class="btn-danger btn-small" onclick="removeMergeFile(${index})">Remove</button>
                    </div>
                </div>
            `).join('');
            
            // Add drag and drop functionality
            mergeList.querySelectorAll('.merge-item').forEach(item => {
                item.addEventListener('dragstart', handleMergeDragStart);
                item.addEventListener('dragover', handleMergeDragOver);
                item.addEventListener('drop', handleMergeDrop);
                item.addEventListener('dragend', handleMergeDragEnd);
            });
        }
        
        function handleMergeDragStart(e) {
            draggedElement = e.target;
            e.target.classList.add('dragging');
        }
        
        function handleMergeDragOver(e) {
            e.preventDefault();
        }
        
        function handleMergeDrop(e) {
            e.preventDefault();
            if (draggedElement && draggedElement !== e.target) {
                const draggedIndex = parseInt(draggedElement.dataset.index);
                const targetIndex = parseInt(e.target.closest('.merge-item').dataset.index);
                
                // Reorder the files
                const draggedFile = mergeFiles.splice(draggedIndex, 1)[0];
                mergeFiles.splice(targetIndex, 0, draggedFile);
                
                updateMergeList();
            }
        }
        
        function handleMergeDragEnd(e) {
            e.target.classList.remove('dragging');
            draggedElement = null;
        }
        
        function removeMergeFile(index) {
            mergeFiles.splice(index, 1);
            updateMergeList();
            
            if (mergeFiles.length === 0) {
                document.getElementById('mergeControls').classList.add('hidden');
            }
        }
        
        function clearMergeList() {
            mergeFiles = [];
            updateMergeList();
            document.getElementById('mergeControls').classList.add('hidden');
        }
        
        async function splitPDF() {
            if (!splitPdfDoc) return;
            
            const splitType = document.querySelector('input[name="splitType"]:checked').value;
            const progressDiv = document.getElementById('splitProgress');
            const progressFill = document.getElementById('splitProgressFill');
            const resultsDiv = document.getElementById('splitResults');
            
            progressDiv.classList.remove('hidden');
            resultsDiv.classList.add('hidden');
            
            try {
                let splitTasks = [];
                
                if (splitType === 'all') {
                    // Split into individual pages
                    for (let i = 0; i < splitPdfDoc.getPageCount(); i++) {
                        splitTasks.push({
                            pages: [i],
                            filename: `page-${i + 1}.pdf`
                        });
                    }
                } else if (splitType === 'range') {
                    // Split by page range
                    const rangeText = document.getElementById('pageRange').value;
                    const ranges = parsePageRanges(rangeText, splitPdfDoc.getPageCount());
                    
                    ranges.forEach((range, index) => {
                        splitTasks.push({
                            pages: range.pages,
                            filename: `pages-${range.label}.pdf`
                        });
                    });
                } else if (splitType === 'chunks') {
                    // Split into chunks
                    const chunkSize = parseInt(document.getElementById('chunkSize').value);
                    const totalPages = splitPdfDoc.getPageCount();
                    
                    for (let i = 0; i < totalPages; i += chunkSize) {
                        const endPage = Math.min(i + chunkSize, totalPages);
                        const pages = [];
                        for (let j = i; j < endPage; j++) {
                            pages.push(j);
                        }
                        
                        splitTasks.push({
                            pages: pages,
                            filename: `chunk-${Math.floor(i / chunkSize) + 1}.pdf`
                        });
                    }
                }
                
                const results = [];
                
                for (let i = 0; i < splitTasks.length; i++) {
                    const task = splitTasks[i];
                    const newPdf = await PDFLib.PDFDocument.create();
                    
                    // Copy pages
                    const copiedPages = await newPdf.copyPages(splitPdfDoc, task.pages);
                    copiedPages.forEach(page => newPdf.addPage(page));
                    
                    const pdfBytes = await newPdf.save();
                    const blob = new Blob([pdfBytes], { type: 'application/pdf' });
                    
                    results.push({
                        filename: task.filename,
                        blob: blob,
                        size: (blob.size / 1024).toFixed(2)
                    });
                    
                    // Update progress
                    const progress = ((i + 1) / splitTasks.length) * 100;
                    progressFill.style.width = progress + '%';
                    
                    // Allow UI to update
                    await new Promise(resolve => setTimeout(resolve, 50));
                }
                
                // Display results
                resultsDiv.innerHTML = `
                    <h3 style="margin-bottom: 20px; color: #333;">Split Results (${results.length} files)</h3>
                    ${results.map(result => `
                        <div class="file-item">
                            <div class="file-icon">📄</div>
                            <div class="file-info">
                                <div class="file-name">${result.filename}</div>
                                <div class="file-details">${result.size} KB</div>
                            </div>
                            <div class="file-actions">
                                <button class="btn-small" onclick="downloadFile('${result.filename}', '${URL.createObjectURL(result.blob)}')">Download</button>
                            </div>
                        </div>
                    `).join('')}
                    <div style="margin-top: 20px; text-align: center;">
                        <button onclick="downloadAllSplitFiles([${results.map((r, i) => `{filename: '${r.filename}', url: '${URL.createObjectURL(r.blob)}'}`).join(', ')}])">Download All</button>
                    </div>
                `;
                
                resultsDiv.classList.remove('hidden');
                
            } catch (error) {
                alert('Error splitting PDF: ' + error.message);
            } finally {
                progressDiv.classList.add('hidden');
            }
        }
        
        function parsePageRanges(rangeText, totalPages) {
            const ranges = [];
            const parts = rangeText.split(',').map(s => s.trim());
            
            parts.forEach(part => {
                if (part.includes('-')) {
                    const [start, end] = part.split('-').map(s => parseInt(s.trim()));
                    if (start >= 1 && end <= totalPages && start <= end) {
                        const pages = [];
                        for (let i = start - 1; i < end; i++) {
                            pages.push(i);
                        }
                        ranges.push({
                            pages: pages,
                            label: `${start}-${end}`
                        });
                    }
                } else {
                    const pageNum = parseInt(part);
                    if (pageNum >= 1 && pageNum <= totalPages) {
                        ranges.push({
                            pages: [pageNum - 1],
                            label: pageNum.toString()
                        });
                    }
                }
            });
            
            return ranges;
        }
        
        async function mergePDFs() {
            if (mergeFiles.length === 0) return;
            
            const progressDiv = document.getElementById('mergeProgress');
            const progressFill = document.getElementById('mergeProgressFill');
            const filename = document.getElementById('mergeFileName').value || 'merged-document.pdf';
            
            progressDiv.classList.remove('hidden');
            
            try {
                const mergedPdf = await PDFLib.PDFDocument.create();
                
                for (let i = 0; i < mergeFiles.length; i++) {
                    const file = mergeFiles[i];
                    const arrayBuffer = await file.file.arrayBuffer();
                    const pdf = await PDFLib.PDFDocument.load(arrayBuffer);
                    
                    const pages = await mergedPdf.copyPages(pdf, pdf.getPageIndices());
                    pages.forEach(page => mergedPdf.addPage(page));
                    
                    // Update progress
                    const progress = ((i + 1) / mergeFiles.length) * 100;
                    progressFill.style.width = progress + '%';
                    
                    // Allow UI to update
                    await new Promise(resolve => setTimeout(resolve, 100));
                }
                
                const pdfBytes = await mergedPdf.save();
                const blob = new Blob([pdfBytes], { type: 'application/pdf' });
                
                // Download the merged PDF