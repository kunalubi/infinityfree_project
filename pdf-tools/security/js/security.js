document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Protect PDF form
    const protectForm = document.getElementById('protectPdfForm');
    if (protectForm) {
        protectForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                showToast('Passwords do not match', 'error');
                return;
            }
            
            const button = this.querySelector('button[type="submit"]');
            const originalText = showLoading(button);
            
            setTimeout(() => {
                hideLoading(button, originalText);
                document.getElementById('result').style.display = 'block';
                showToast('PDF protected successfully!', 'success');
            }, 2000);
        });
    }
    
    // Unlock PDF form
    const unlockForm = document.getElementById('unlockPdfForm');
    if (unlockForm) {
        unlockForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button[type="submit"]');
            const originalText = showLoading(button);
            
            setTimeout(() => {
                hideLoading(button, originalText);
                showToast('PDF unlocked successfully!', 'success');
                
                // In a real app, this would trigger download
                const link = document.createElement('a');
                link.href = '#';
                link.download = 'unlocked.pdf';
                link.click();
            }, 2000);
        });
    }
    
    // Download secured PDF
    const downloadSecured = document.getElementById('downloadSecured');
    if (downloadSecured) {
        downloadSecured.addEventListener('click', function() {
            showToast('Download started!', 'success');
        });
    }
});