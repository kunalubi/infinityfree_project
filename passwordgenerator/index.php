<?php include '../header.php'; ?>

<div class="password-generator-container" style="margin-top: 100px;">
    <div class="password-generator-card">
        <div class="password-generator-header">
            <h2 class="password-generator-title">
                <i class="fas fa-key"></i>
                <span>Password Generator</span>
            </h2>
        </div>
        <div class="password-generator-content">
            <form id="password-form">
                <!-- Password Length -->
                <div class="password-field">
                    <label class="password-label">
                        <i class="fas fa-ruler"></i>
                        <span>Password Length: <strong id="length-value">12</strong></span>
                    </label>
                    <div class="password-control">
                        <input class="password-slider" type="range" id="length" min="4" max="64" value="12">
                    </div>
                    <div class="password-range-labels">
                        <small>4</small>
                        <small>64</small>
                    </div>
                </div>
                
                <!-- Character Types -->
                <div class="password-field">
                    <label class="password-label">
                        <i class="fas fa-font"></i>
                        <span>Character Types</span>
                    </label>
                    <div class="password-control">
                        <label class="password-checkbox">
                            <input type="checkbox" id="uppercase" checked>
                            Uppercase Letters (A-Z)
                        </label>
                        <label class="password-checkbox">
                            <input type="checkbox" id="numbers" checked>
                            Numbers (0-9)
                        </label>
                        <label class="password-checkbox">
                            <input type="checkbox" id="specialChars" checked>
                            Special Characters (!@#$% etc.)
                        </label>
                    </div>
                </div>
                
                <!-- Password Requirements -->
                <div class="password-field">
                    <label class="password-label">
                        <i class="fas fa-check-circle"></i>
                        <span>Password Requirements</span>
                    </label>
                    <div class="password-control">
                        <label class="password-checkbox">
                            <input type="checkbox" id="minLength" checked>
                            Minimum 8 characters
                        </label>
                        <label class="password-checkbox">
                            <input type="checkbox" id="minUppercase" checked>
                            At least one uppercase letter
                        </label>
                        <label class="password-checkbox">
                            <input type="checkbox" id="minNumbers" checked>
                            At least one number
                        </label>
                        <label class="password-checkbox">
                            <input type="checkbox" id="minSpecialChars" checked>
                            At least one special character
                        </label>
                    </div>
                </div>
                
                <!-- Strength Meter -->
                <div class="password-field">
                    <label class="password-label">
                        <i class="fas fa-bolt"></i>
                        <span>Password Strength</span>
                    </label>
                    <div class="password-strength-meter">
                        <div class="password-strength-bar" id="strength-bar"></div>
                    </div>
                    <div class="password-strength-labels">
                        <span>Weak</span>
                        <span>Fair</span>
                        <span>Good</span>
                        <span>Strong</span>
                        <span>Excellent</span>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="password-field">
                    <div class="password-buttons">
                        <button class="password-generate-btn" id="generate-btn" type="button">
                            <span class="icon">
                                <i class="fas fa-key"></i>
                            </span>
                            <span>Generate Password</span>
                        </button>
                        <button class="password-show-btn" id="show-password-btn" type="button" disabled>
                            <span class="icon">
                                <i class="fas fa-eye"></i>
                            </span>
                            <span>Show Password</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Modal -->
<div class="password-modal" id="password-modal">
    <div class="password-modal-background"></div>
    <div class="password-modal-card">
        <header class="password-modal-header">
            <p class="password-modal-title">
                <i class="fas fa-lock"></i>
                <span>Your Secure Password</span>
            </p>
            <button class="password-modal-close" aria-label="close" id="close-modal-btn"></button>
        </header>
        <section class="password-modal-body">
            <div class="password-display">
                <p id="generated-password" class="password-text"></p>
                <span class="password-copy-btn" id="copy-btn" title="Copy to clipboard">
                    <i class="fas fa-copy"></i>
                </span>
            </div>
            <div class="password-notification">
                <button class="password-notification-close"></button>
                <strong>Important:</strong> Make sure to save this password in a secure place. 
                We don't store any passwords.
            </div>
            <div class="password-strength-info">
                <h4 class="password-subtitle">
                    <i class="fas fa-shield-alt"></i>
                    <span>Password Strength:</span>
                    <span id="strength-text" class="password-strength-label">Good</span>
                </h4>
                <progress class="password-strength-progress" id="strength-progress" value="75" max="100">75%</progress>
            </div>
        </section>
        <footer class="password-modal-footer">
            <button class="password-regenerate-btn" id="regenerate-btn">
                <span class="icon">
                    <i class="fas fa-sync-alt"></i>
                </span>
                <span>Generate New</span>
            </button>
            <button class="password-modal-close-btn" id="close-modal-btn-footer">
                Close
            </button>
        </footer>
    </div>
</div>

<style>
/* Password Generator Specific Styles */
.password-generator-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1.5rem;
    animation: fadeIn 0.6s ease-out;
}

.password-generator-card {
    border-radius: 12px;
    box-shadow: var(--shadow);
    border: none;
    overflow: hidden;
    transform: translateY(0);
    transition: var(--transition);
}

.password-generator-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.password-generator-header {
    background: linear-gradient(135deg, rgba(108, 92, 231, 0.1), rgba(253, 121, 168, 0.1));
    padding: 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.password-generator-title {
    color: var(--primary);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.password-generator-content {
    padding: 2rem;
}

.password-field {
    margin-bottom: 1.5rem;
}

.password-label {
    font-weight: 500;
    color: var(--dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}



.password-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--primary);
    cursor: pointer;
    transition: var(--transition);
}

.password-slider::-webkit-slider-thumb:hover {
    transform: scale(1.1);
    background: var(--primary-dark);
}

.password-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: var(--transition);
    padding: 0.5rem 0;
}

.password-checkbox input {
    margin-right: 10px;
}

.password-checkbox:hover {
    color: var(--primary);
}

.password-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: center;
}

.password-generate-btn, 
.password-show-btn {
    font-weight: 500;
    transition: var(--transition);
    border-radius: 50px;
    padding: 1rem 1.5rem;
}

.password-generate-btn {
    background-color: var(--primary);
    border-color: var(--primary);
    color: white;
    box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
}

.password-generate-btn:hover {
    background-color: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
}

.password-show-btn {
    background-color: var(--accent);
    border-color: var(--accent);
    color: white;
    box-shadow: 0 4px 15px rgba(253, 121, 168, 0.3);
}

.password-show-btn:hover {
    background-color: var(--accent);
    opacity: 0.9;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(253, 121, 168, 0.4);
}

.password-strength-meter {
    margin: 1.5rem 0;
    height: 8px;
    background-color: #eee;
    border-radius: 4px;
    overflow: hidden;
    position: relative;
}

.password-strength-bar {
    height: 100%;
    width: 0%;
    transition: var(--transition);
}

.password-strength-labels {
    display: flex;
    justify-content: space-between;
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: var(--dark-light);
}

/* Modal Styles */
.password-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 100;
    animation: fadeIn 0.3s ease-out;
}

.password-modal.is-active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.password-modal-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.password-modal-card {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    width: 90%;
    max-width: 500px;
    z-index: 101;
    transform: translateY(0);
    transition: var(--transition);
    animation: slideUp 0.4s ease-out;
}

.password-modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.password-modal-title {
    font-weight: 600;
    color: var(--primary);
    font-size: 1.2rem;
}

.password-modal-body {
    padding: 2rem;
}

.password-display {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: var(--light);
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.password-text {
    font-family: monospace;
    font-size: 1.2rem;
    word-break: break-all;
}

.password-copy-btn {
    margin-left: 1rem;
    cursor: pointer;
    color: var(--primary);
    transition: var(--transition);
}

.password-copy-btn:hover {
    color: var(--primary-dark);
    transform: scale(1.1);
}

.password-notification {
    padding: 1rem;
    background-color: #f5f5f5;
    border-radius: 6px;
    margin-bottom: 1.5rem;
    position: relative;
}

.password-modal-footer {
    padding: 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.password-regenerate-btn {
    background-color: var(--primary);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    cursor: pointer;
    transition: var(--transition);
}

.password-regenerate-btn:hover {
    background-color: var(--primary-dark);
}

.password-modal-close-btn {
    background-color: #f5f5f5;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    cursor: pointer;
    transition: var(--transition);
}

.password-modal-close-btn:hover {
    background-color: #e0e0e0;
}

.password-strength-info {
    margin-top: 1.5rem;
}

.password-subtitle {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.password-strength-label {
    font-weight: bold;
}

.password-strength-progress {
    width: 100%;
    height: 8px;
    border-radius: 4px;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { 
        opacity: 0;
        transform: translateY(20px);
    }
    to { 
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.pulse {
    animation: pulse 1.5s infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .password-generator-content {
        padding: 1.5rem;
    }
    
    .password-buttons {
        flex-direction: column;
        width: 100%;
    }
    
    .password-generate-btn,
    .password-show-btn {
        width: 100%;
    }
}
</style>

    <!-- Footer -->
  <?php include '../footer.php'; ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const form = document.getElementById('password-form');
            const generateBtn = document.getElementById('generate-btn');
            const lengthInput = document.getElementById('length');
            const lengthValue = document.getElementById('length-value');
            const uppercaseCheckbox = document.getElementById('uppercase');
            const numbersCheckbox = document.getElementById('numbers');
            const specialCharsCheckbox = document.getElementById('specialChars');
            const minLengthCheckbox = document.getElementById('minLength');
            const minUppercaseCheckbox = document.getElementById('minUppercase');
            const minNumbersCheckbox = document.getElementById('minNumbers');
            const minSpecialCharsCheckbox = document.getElementById('minSpecialChars');
            const showPasswordBtn = document.getElementById('show-password-btn');
            const passwordModal = document.getElementById('password-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const closeModalBtnFooter = document.getElementById('close-modal-btn-footer');
            const generatedPasswordText = document.getElementById('generated-password');
            const copyBtn = document.getElementById('copy-btn');
            const regenerateBtn = document.getElementById('regenerate-btn');
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            const strengthProgress = document.getElementById('strength-progress');
            
            let generatedPassword = '';
            let strengthScore = 0;
            
            // Event Listeners
            lengthInput.addEventListener('input', updateLengthValue);
            generateBtn.addEventListener('click', generatePassword);
            showPasswordBtn.addEventListener('click', showPasswordModal);
            closeModalBtn.addEventListener('click', closeModal);
            closeModalBtnFooter.addEventListener('click', closeModal);
            copyBtn.addEventListener('click', copyToClipboard);
            regenerateBtn.addEventListener('click', regeneratePassword);
            
            // Update length value display
            function updateLengthValue() {
                lengthValue.textContent = lengthInput.value;
            }
            
            // Generate password
            function generatePassword() {
                const length = parseInt(lengthInput.value);
                const hasUppercase = uppercaseCheckbox.checked;
                const hasNumbers = numbersCheckbox.checked;
                const hasSpecialChars = specialCharsCheckbox.checked;
                const minLength = minLengthCheckbox.checked;
                const minUppercase = minUppercaseCheckbox.checked;
                const minNumbers = minNumbersCheckbox.checked;
                const minSpecialChars = minSpecialCharsCheckbox.checked;
                
                // Validate at least one character type is selected
                if (!hasUppercase && !hasNumbers && !hasSpecialChars) {
                    showNotification('Please select at least one character type', 'is-danger');
                    return;
                }
                
                let chars = 'abcdefghijklmnopqrstuvwxyz';
                if (hasUppercase) chars += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                if (hasNumbers) chars += '0123456789';
                if (hasSpecialChars) chars += '!@#$%^&*()_+~`|}{[]:;?><,./-=';
                
                let password = '';
                let attempts = 0;
                const maxAttempts = 20;
                let requirementsMet = false;
                
                // Generate password until all requirements are met or max attempts reached
                do {
                    password = '';
                    for (let i = 0; i < length; i++) {
                        password += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    
                    // Check requirements
                    requirementsMet = true;
                    
                    if (minLength && password.length < 8) {
                        requirementsMet = false;
                    }
                    
                    if (minUppercase && hasUppercase && !password.match(/[A-Z]/)) {
                        requirementsMet = false;
                    }
                    
                    if (minNumbers && hasNumbers && !password.match(/[0-9]/)) {
                        requirementsMet = false;
                    }
                    
                    if (minSpecialChars && hasSpecialChars && !password.match(/[^a-zA-Z0-9]/)) {
                        requirementsMet = false;
                    }
                    
                    attempts++;
                    
                    if (attempts >= maxAttempts) {
                        showNotification('Could not generate password with current requirements. Try adjusting your settings.', 'is-warning');
                        break;
                    }
                } while (!requirementsMet);
                
                generatedPassword = password;
                showPasswordBtn.disabled = false;
                
                // Calculate and display strength
                calculatePasswordStrength(password);
                
                // Show success notification
                if (requirementsMet) {
                    showNotification('Password generated successfully!', 'is-success');
                }
            }
            
            // Calculate password strength
            function calculatePasswordStrength(password) {
                let score = 0;
                
                // Length contributes up to 50 points
                score += Math.min(password.length * 2, 50);
                
                // Character variety contributes up to 50 points
                let varietyScore = 0;
                if (password.match(/[A-Z]/)) varietyScore += 10;
                if (password.match(/[a-z]/)) varietyScore += 10;
                if (password.match(/[0-9]/)) varietyScore += 10;
                if (password.match(/[^a-zA-Z0-9]/)) varietyScore += 20;
                
                score += varietyScore;
                
                // Normalize to 100%
                score = Math.min(score, 100);
                strengthScore = score;
                
                // Update strength bar
                strengthBar.style.width = score + '%';
                strengthProgress.value = score;
                
                // Update color and text based on strength
                let strengthColor, strengthLabel;
                
                if (score < 20) {
                    strengthColor = '#ff3860'; // Red
                    strengthLabel = 'Very Weak';
                } else if (score < 40) {
                    strengthColor = '#ff7043'; // Orange
                    strengthLabel = 'Weak';
                } else if (score < 60) {
                    strengthColor = '#ffdd57'; // Yellow
                    strengthLabel = 'Fair';
                } else if (score < 80) {
                    strengthColor = '#23d160'; // Green
                    strengthLabel = 'Strong';
                } else {
                    strengthColor = '#00d1b2'; // Teal
                    strengthLabel = 'Excellent';
                }
                
                strengthBar.style.backgroundColor = strengthColor;
                strengthProgress.className = `progress is-small ${getStrengthClass(score)}`;
                
                if (strengthText) {
                    strengthText.textContent = strengthLabel;
                    strengthText.className = `has-text-weight-bold ${getStrengthTextClass(score)}`;
                }
            }
            
            function getStrengthClass(score) {
                if (score < 20) return 'is-danger';
                if (score < 40) return 'is-warning';
                if (score < 60) return 'is-info';
                if (score < 80) return 'is-success';
                return 'is-primary';
            }
            
            function getStrengthTextClass(score) {
                if (score < 20) return 'has-text-danger';
                if (score < 40) return 'has-text-warning';
                if (score < 60) return 'has-text-info';
                if (score < 80) return 'has-text-success';
                return 'has-text-primary';
            }
            
            // Show password modal
            function showPasswordModal() {
                if (generatedPassword) {
                    generatedPasswordText.textContent = generatedPassword;
                    passwordModal.classList.add('is-active');
                    
                    // Update modal with current strength info
                    if (strengthText) {
                        strengthText.textContent = getStrengthLabel(strengthScore);
                        strengthText.className = `has-text-weight-bold ${getStrengthTextClass(strengthScore)}`;
                    }
                    
                    if (strengthProgress) {
                        strengthProgress.value = strengthScore;
                        strengthProgress.className = `progress is-small ${getStrengthClass(strengthScore)}`;
                    }
                }
            }
            
            function getStrengthLabel(score) {
                if (score < 20) return 'Very Weak';
                if (score < 40) return 'Weak';
                if (score < 60) return 'Fair';
                if (score < 80) return 'Strong';
                return 'Excellent';
            }
            
            // Close modal
            function closeModal() {
                passwordModal.classList.remove('is-active');
            }
            
            // Copy to clipboard
            function copyToClipboard() {
                navigator.clipboard.writeText(generatedPassword)
                    .then(() => {
                        copyBtn.innerHTML = '<i class="fas fa-check"></i>';
                        showNotification('Password copied to clipboard!', 'is-success');
                        setTimeout(() => {
                            copyBtn.innerHTML = '<i class="fas fa-copy"></i>';
                        }, 2000);
                    })
                    .catch(err => {
                        console.error('Failed to copy: ', err);
                        showNotification('Failed to copy password', 'is-danger');
                    });
            }
            
            // Regenerate password
            function regeneratePassword() {
                generatePassword();
                if (generatedPassword) {
                    generatedPasswordText.textContent = generatedPassword;
                    
                    // Update modal with new strength info
                    if (strengthText) {
                        strengthText.textContent = getStrengthLabel(strengthScore);
                        strengthText.className = `has-text-weight-bold ${getStrengthTextClass(strengthScore)}`;
                    }
                    
                    if (strengthProgress) {
                        strengthProgress.value = strengthScore;
                        strengthProgress.className = `progress is-small ${getStrengthClass(strengthScore)}`;
                    }
                    
                    showNotification('New password generated!', 'is-success');
                }
            }
            
            // Show notification
            function showNotification(message, type) {
                // Remove any existing notifications
                const existingNotifications = document.querySelectorAll('.notification-toast');
                existingNotifications.forEach(notification => notification.remove());
                
                // Create new notification
                const notification = document.createElement('div');
                notification.className = `notification-toast notification ${type} is-light`;
                notification.style.position = 'fixed';
                notification.style.bottom = '20px';
                notification.style.left = '20px';
                notification.style.zIndex = '1000';
                notification.style.maxWidth = '300px';
                notification.style.animation = 'slideUp 0.3s ease-out';
                notification.innerHTML = `
                    <button class="delete"></button>
                    ${message}
                `;
                
                document.body.appendChild(notification);
                
                // Auto-remove after 5 seconds
                setTimeout(() => {
                    notification.style.animation = 'fadeOut 0.3s ease-out';
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 5000);
                
                // Add click to dismiss
                notification.querySelector('.delete').addEventListener('click', () => {
                    notification.remove();
                });
            }
            
            // Initialize
            updateLengthValue();
            
            // Add fadeOut animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeOut {
                    from { opacity: 1; transform: translateY(0); }
                    to { opacity: 0; transform: translateY(10px); }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>