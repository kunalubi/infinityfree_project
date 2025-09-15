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