<?php include "../../header.php"; ?>
<div class="tool-card">
    <h1>PDF Editor</h1>
    <p>Edit your PDF files by adding text, images, annotations, and more.</p>

    <div class="editor-container">
        <div class="editor-toolbar">
            <button class="tool-btn" data-tool="text"><i class="fas fa-font"></i> Text</button>
            <button class="tool-btn" data-tool="image"><i class="fas fa-image"></i> Image</button>
            <button class="tool-btn" data-tool="draw"><i class="fas fa-pencil-alt"></i> Draw</button>
            <button class="tool-btn" data-tool="highlight"><i class="fas fa-highlighter"></i> Highlight</button>
            <button class="tool-btn" data-tool="signature"><i class="fas fa-signature"></i> Signature</button>
            <button class="tool-btn btn-danger" data-tool="delete"><i class="fas fa-trash"></i> Delete</button>
        </div>

        <div class="file-upload-area">
            <div class="file-upload">
                <input type="file" id="pdfFile" accept=".pdf" required>
                <label for="pdfFile" class="file-upload-label">Choose PDF file to edit</label>
            </div>
        </div>

        <div class="pdf-preview-container" style="display: none;">
            <div class="pdf-preview-toolbar">
                <button id="rotateLeft" class="btn"><i class="fas fa-undo"></i> Rotate Left</button>
                <button id="rotateRight" class="btn"><i class="fas fa-redo"></i> Rotate Right</button>
                <button id="savePdf" class="btn"><i class="fas fa-save"></i> Save PDF</button>
            </div>
            <div class="pdf-preview">
                <!-- PDF pages would be rendered here -->
                <img src="https://via.placeholder.com/600x800?text=PDF+Preview" alt="PDF Preview" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pdfFileInput = document.getElementById('pdfFile');
        const previewContainer = document.querySelector('.pdf-preview-container');

        // Handle file selection
        pdfFileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const label = document.querySelector('.file-upload-label');
                if (label) {
                    label.textContent = this.files[0].name;
                }

                // Show preview container
                previewContainer.style.display = 'block';

                // In a real app, we would render the PDF here
                showToast('PDF loaded successfully', 'success');
            }
        });

        // Tool buttons functionality
        document.querySelectorAll('.tool-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const tool = this.getAttribute('data-tool');
                showToast(`Selected tool: ${tool}`, 'success');

                // In a real app, this would activate the selected tool
            });
        });

        // Rotate buttons
        document.getElementById('rotateLeft').addEventListener('click', function() {
            showToast('Rotated left', 'success');
        });

        document.getElementById('rotateRight').addEventListener('click', function() {
            showToast('Rotated right', 'success');
        });

        // Save button
        document.getElementById('savePdf').addEventListener('click', function() {
            showToast('Preparing download...', 'success');

            // Simulate processing
            setTimeout(() => {
                showToast('PDF saved successfully!', 'success');

                // In a real app, this would trigger the download
                const link = document.createElement('a');
                link.href = '#';
                link.download = 'edited.pdf';
                link.click();
            }, 1500);
        });
    });
</script>
<?php include "../../footer.php"; ?>