<!DOCTYPE html>
<html>
<head>
    <title>Test Database API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 20px 0; padding: 15px; border-radius: 8px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        button { padding: 12px 24px; font-size: 16px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px; margin: 5px; }
        button:hover { background: #0056b3; }
        pre { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; margin: 10px 0; font-family: monospace; font-size: 12px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Database API (Full Implementation)</h1>
        
        <div class="row">
            <div class="col-md-6">
                <h3>1. Test Database API</h3>
                <button onclick="testDatabaseAPI()">Test Database API</button>
                <div id="apiResult"></div>
            </div>
            
            <div class="col-md-6">
                <h3>2. Test Modal Form</h3>
                <button onclick="openModal()">Open Add User Modal</button>
                <div id="modalResult"></div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h3>3. Console Log</h3>
                <div id="consoleLog" class="result info">
                    <p>Console logs will appear here...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label for="addUserName" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="addUserName" value="AKBAR TJ" required>
                        </div>
                        <div class="mb-3">
                            <label for="addUserTier" class="form-label">User Tier</label>
                            <select class="form-control" id="addUserTier">
                                <option value="Tier 3" selected>Tier 3</option>
                                <option value="Premium">Premium</option>
                                <option value="Standard">Standard</option>
                                <option value="Basic">Basic</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addStartWork" class="form-label">Start Work</label>
                            <input type="date" class="form-control" id="addStartWork" value="2025-08-04">
                        </div>
                        <div class="mb-3">
                            <label for="addUserRole" class="form-label">User Roles</label>
                            <select class="form-control" id="addUserRole">
                                <option value="">Select Role</option>
                                <option value="Administrator">Administrator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Admin Officer">Admin Officer</option>
                                <option value="User" selected>User</option>
                                <option value="Client">Client</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addUserEmail" class="form-label">User Email</label>
                            <input type="email" class="form-control" id="addUserEmail" value="test@powerpro.id">
                        </div>
                        <div class="mb-3">
                            <label for="addUserPassword" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="addUserPassword" value="test123">
                                <button class="btn btn-outline-secondary" type="button" id="generatePasswordBtn">
                                    <i class="ri-refresh-line"></i> Generate
                                </button>
                            </div>
                            <small class="form-text text-muted">Leave empty to generate random password</small>
                        </div>
                        <div class="mb-3">
                            <label for="addBirthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="addBirthday" value="1990-01-01">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveUserBtn">Save User</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Override console.log to show in our div
        const originalConsoleLog = console.log;
        const originalConsoleError = console.error;
        const consoleLogDiv = document.getElementById('consoleLog');
        
        function addToConsole(message, type = 'log') {
            const timestamp = new Date().toLocaleTimeString();
            const color = type === 'error' ? 'red' : 'black';
            consoleLogDiv.innerHTML += `<div style="color: ${color}; margin: 2px 0;">[${timestamp}] ${message}</div>`;
            consoleLogDiv.scrollTop = consoleLogDiv.scrollHeight;
        }
        
        console.log = function(...args) {
            originalConsoleLog.apply(console, args);
            addToConsole(args.join(' '));
        };
        
        console.error = function(...args) {
            originalConsoleError.apply(console, args);
            addToConsole(args.join(' '), 'error');
        };

        document.addEventListener('DOMContentLoaded', function() {
            const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));

            const showToast = (message, icon = 'success') => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: icon,
                    title: message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            };

            const apiCall = async (url, body) => {
                console.log('API Call - URL:', url);
                console.log('API Call - Body:', body);
                
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(body)
                    });

                    console.log('API Call - Response status:', response.status);

                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('API Call - Error response:', errorText);
                        throw new Error(`Server error: ${response.status} ${response.statusText}. ${errorText}`);
                    }

                    const responseData = await response.json();
                    console.log('API Call - Response data:', responseData);
                    return responseData;
                } catch (error) {
                    console.error('API Call Error:', error);
                    showToast(error.message, 'error');
                    return null;
                }
            };

            // Generate password function
            function generateRandomPassword() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let password = '';
                for (let i = 0; i < 8; i++) {
                    password += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return password;
            }

            // Generate password button event
            document.getElementById('generatePasswordBtn').addEventListener('click', function() {
                const passwordField = document.getElementById('addUserPassword');
                passwordField.value = generateRandomPassword();
                passwordField.type = 'text';
                setTimeout(() => {
                    passwordField.type = 'password';
                }, 2000);
            });

            // Save user button event
            console.log('Setting up save user button event listener');
            
            const saveUserBtn = document.getElementById('saveUserBtn');
            if (!saveUserBtn) {
                console.error('Save User button not found!');
            } else {
                console.log('Save User button found:', saveUserBtn);
                
                saveUserBtn.addEventListener('click', async function(e) {
                    console.log('Save User button clicked!');
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Client-side validation
                    const userName = document.getElementById('addUserName');
                    const userTier = document.getElementById('addUserTier');
                    const startWork = document.getElementById('addStartWork');
                    const userRole = document.getElementById('addUserRole');
                    const userEmail = document.getElementById('addUserEmail');
                    const userPassword = document.getElementById('addUserPassword');
                    const birthday = document.getElementById('addBirthday');
                    
                    // Debug: Check if all elements exist
                    console.log('Form elements:', {
                        userName: userName,
                        userTier: userTier,
                        startWork: startWork,
                        userRole: userRole,
                        userEmail: userEmail,
                        userPassword: userPassword,
                        birthday: birthday
                    });
                    
                    const userNameValue = userName ? userName.value.trim() : '';
                    const userTierValue = userTier ? userTier.value : '';
                    const startWorkValue = startWork ? startWork.value : '';
                    const userRoleValue = userRole ? userRole.value : '';
                    const userEmailValue = userEmail ? userEmail.value.trim() : '';
                    const password = userPassword ? userPassword.value : '';
                    const birthdayValue = birthday ? birthday.value : '';

                    // Validate required fields
                    if (!userNameValue) {
                        showToast('User Name is required', 'error');
                        return;
                    }
                    if (!userTierValue) {
                        showToast('User Tier is required', 'error');
                        return;
                    }
                    if (!userRoleValue) {
                        showToast('User Role is required', 'error');
                        return;
                    }
                    if (!userEmailValue) {
                        showToast('User Email is required', 'error');
                        return;
                    }
                    if (!password) {
                        showToast('Password is required', 'error');
                        return;
                    }

                    // Validate email format
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(userEmailValue)) {
                        showToast('Please enter a valid email address', 'error');
                        return;
                    }

                    const userData = {
                        userName: userNameValue,
                        userTier: userTierValue,
                        startWork: startWorkValue,
                        userRole: userRoleValue,
                        userEmail: userEmailValue,
                        password: password,
                        birthday: birthdayValue,
                    };

                    // Debug logging
                    console.log('Sending user data:', userData);
                    console.log('API URL:', 'wowdash-php/api-user-final-database.php');

                    const data = await apiCall('wowdash-php/api-user-final-database.php', userData);
                    console.log('API Response:', data);
                    
                    const modalResultDiv = document.getElementById('modalResult');
                    modalResultDiv.style.display = 'block';
                    
                    if (data && data.success) {
                        modalResultDiv.className = 'result success';
                        modalResultDiv.innerHTML = `
                            <h4>✅ SUCCESS!</h4>
                            <p><strong>Message:</strong> ${data.message}</p>
                            <p><strong>User ID:</strong> ${data.data.userId}</p>
                            <p><strong>User Name:</strong> ${data.data.userName}</p>
                            <p><strong>Email:</strong> ${data.data.userEmail}</p>
                            <p><strong>Tier:</strong> ${data.data.userTier}</p>
                            <p><strong>Role:</strong> ${data.data.userRole}</p>
                            <p><strong>Database:</strong> User saved to database!</p>
                        `;
                        showToast(data.message);
                        addUserModal.hide();
                        document.getElementById('addUserForm').reset();
                    } else if (data) {
                        modalResultDiv.className = 'result error';
                        modalResultDiv.innerHTML = `
                            <h4>❌ ERROR!</h4>
                            <p><strong>Message:</strong> ${data.message}</p>
                        `;
                        showToast(data.message, 'error');
                    } else {
                        modalResultDiv.className = 'result error';
                        modalResultDiv.innerHTML = `
                            <h4>❌ NO RESPONSE!</h4>
                            <p>No response from server</p>
                        `;
                        console.error('No response from API');
                        showToast('No response from server', 'error');
                    }
                });
            }

            // Make functions global for button clicks
            window.testDatabaseAPI = async function() {
                const resultDiv = document.getElementById('apiResult');
                resultDiv.innerHTML = '<p>Testing...</p>';

                const userData = {
                    userName: 'AKBAR TJ',
                    userTier: 'Tier 3',
                    startWork: '2025-08-04',
                    userRole: 'User',
                    userEmail: 'test' + Date.now() + '@powerpro.id',
                    password: 'test123',
                    birthday: '1990-01-01'
                };

                const data = await apiCall('wowdash-php/api-user-final-database.php', userData);
                
                if (data && data.success) {
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = `
                        <h4>✅ SUCCESS!</h4>
                        <p><strong>Message:</strong> ${data.message}</p>
                        <p><strong>User ID:</strong> ${data.data.userId}</p>
                        <p><strong>User Name:</strong> ${data.data.userName}</p>
                        <p><strong>Email:</strong> ${data.data.userEmail}</p>
                        <p><strong>Tier:</strong> ${data.data.userTier}</p>
                        <p><strong>Role:</strong> ${data.data.userRole}</p>
                        <p><strong>Database:</strong> User saved to database!</p>
                    `;
                } else {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h4>❌ ERROR!</h4>
                        <p>API call failed</p>
                    `;
                }
            };

            window.openModal = function() {
                addUserModal.show();
            };
        });
    </script>
</body>
</html> 