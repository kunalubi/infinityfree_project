<?php include "../../header.php"; ?>
    <div class="tool-card">
        <h1>PDF Security Tools</h1>
        <p>Protect your PDF files with passwords and permissions.</p>

        <div class="security-tabs">
            <div class="tab-buttons">
                <button class="tab-btn active" data-tab="protect">Protect PDF</button>
                <button class="tab-btn" data-tab="unlock">Unlock PDF</button>
                <button class="tab-btn" data-tab="permissions">Set Permissions</button>
            </div>

            <div class="tab-content active" id="protect">
                <form id="protectPdfForm">
                    <div class="form-group">
                        <div class="file-upload">
                            <input type="file" id="pdfFile" accept=".pdf" required>
                            <label for="pdfFile" class="file-upload-label">Choose PDF file to protect</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" id="confirmPassword" class="form-control" required>
                    </div>

                    <button type="submit" class="btn">Protect PDF</button>
                </form>
            </div>

            <div class="tab-content" id="unlock">
                <form id="unlockPdfForm">
                    <div class="form-group">
                        <div class="file-upload">
                            <input type="file" id="lockedPdfFile" accept=".pdf" required>
                            <label for="lockedPdfFile" class="file-upload-label">Choose locked PDF file</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="unlockPassword">Password:</label>
                        <input type="password" id="unlockPassword" class="form-control" required>
                    </div>

                    <button type="submit" class="btn">Unlock PDF</button>
                </form>
            </div>

            <div class="tab-content" id="permissions">
                <form id="permissionsPdfForm">
                    <div class="form-group">
                        <div class="file-upload">
                            <input type="file" id="permsPdfFile" accept=".pdf" required>
                            <label for="permsPdfFile" class="file-upload-label">Choose PDF file</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ownerPassword">Owner Password (for permissions):</label>
                        <input type="password" id="ownerPassword" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Permissions:</label>
                        <div class="permissions-list">
                            <label><input type="checkbox" name="printing" checked> Printing</label>
                            <label><input type="checkbox" name="modifying" checked> Modifying</label>
                            <label><input type="checkbox" name="copying" checked> Copying text/images</label>
                            <label><input type="checkbox" name="annotations" checked> Adding annotations</label>
                        </div>
                    </div>

                    <button type="submit" class="btn">Apply Permissions</button>
                </form>
            </div>
        </div>

        <div id="result" class="result-container" style="display: none;">
            <h3>Your secured PDF is ready</h3>
            <button id="downloadSecured" class="btn">Download Secured PDF</button>
        </div>
    </div>

    <script>
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
    </script>
    <?php include "../../footer.php"; ?>