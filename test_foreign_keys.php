<!DOCTYPE html>
<html>
<head>
    <title>Test Foreign Keys Structure</title>
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
        <h1>Test Foreign Keys Structure</h1>
        
        <div class="row">
            <div class="col-md-6">
                <h3>1. Test Database Structure</h3>
                <button onclick="testDatabaseStructure()">Test Database Structure</button>
                <div id="structureResult"></div>
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
                            <label for="addFirstName" class="form-label">First Name *</label>
                            <input type="text" class="form-control" id="addFirstName" value="AKBAR" required>
                        </div>
                        <div class="mb-3">
                            <label for="addLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="addLastName" value="TJ">
                        </div>
                        <div class="mb-3">
                            <label for="addTier" class="form-label">Tier *</label>
                            <select class="form-control" id="addTier" required>
                                <option value="">Select Tier</option>
                                <!-- Tiers will be loaded from database -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addRoles" class="form-label">Roles *</label>
                            <select class="form-control" id="addRoles" required>
                                <option value="">Select Role</option>
                                <!-- Roles will be loaded from database -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addEmail" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="addEmail" value="test@powerpro.id" required>
                        </div>
                        <div class="mb-3">
                            <label for="addPassword" class="form-label">Password *</label>
                            <input type="password" class="form-control" id="addPassword" value="test123" required>
                        </div>
                        <div class="mb-3">
                            <label for="addStartWork" class="form-label">Start Work</label>
                            <input type="date" class="form-control" id="addStartWork" value="2025-08-04">
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

            // Load tiers and roles from database
            async function loadTiersAndRoles() {
                try {
                    console.log('Loading tiers and roles from database...');
                    
                    // Load tiers
                    const tiersResponse = await fetch('wowdash-php/api-get-tiers.php');
                    const tiersData = await tiersResponse.json();
                    
                    if (tiersData.success) {
                        const tierSelect = document.getElementById('addTier');
                        tiersData.data.forEach(tier => {
                            const option = document.createElement('option');
                            option.value = tier.name;
                            option.textContent = tier.name;
                            tierSelect.appendChild(option);
                        });
                        console.log('Tiers loaded:', tiersData.data.length);
                    }
                    
                    // Load roles
                    const rolesResponse = await fetch('wowdash-php/api-get-roles.php');
                    const rolesData = await rolesResponse.json();
                    
                    if (rolesData.success) {
                        const roleSelect = document.getElementById('addRoles');
                        rolesData.data.forEach(role => {
                            const option = document.createElement('option');
                            option.value = role.name;
                            option.textContent = role.name;
                            roleSelect.appendChild(option);
                        });
                        console.log('Roles loaded:', rolesData.data.length);
                    }
                } catch (error) {
                    console.error('Error loading tiers and roles:', error);
                }
            }

            // Load tiers and roles when page loads
            loadTiersAndRoles();

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
                    const firstName = document.getElementById('addFirstName');
                    const lastName = document.getElementById('addLastName');
                    const tier = document.getElementById('addTier');
                    const roles = document.getElementById('addRoles');
                    const email = document.getElementById('addEmail');
                    const password = document.getElementById('addPassword');
                    const startWork = document.getElementById('addStartWork');
                    const birthday = document.getElementById('addBirthday');
                    
                    // Debug: Check if all elements exist
                    console.log('Form elements:', {
                        firstName: firstName,
                        lastName: lastName,
                        tier: tier,
                        roles: roles,
                        email: email,
                        password: password,
                        startWork: startWork,
                        birthday: birthday
                    });
                    
                    const firstNameValue = firstName ? firstName.value.trim() : '';
                    const lastNameValue = lastName ? lastName.value.trim() : '';
                    const tierValue = tier ? tier.value : '';
                    const rolesValue = roles ? roles.value : '';
                    const emailValue = email ? email.value.trim() : '';
                    const passwordValue = password ? password.value : '';
                    const startWorkValue = startWork ? startWork.value : '';
                    const birthdayValue = birthday ? birthday.value : '';

                    // Validate required fields
                    if (!firstNameValue) {
                        showToast('First Name is required', 'error');
                        return;
                    }
                    if (!tierValue) {
                        showToast('Tier is required', 'error');
                        return;
                    }
                    if (!rolesValue) {
                        showToast('Roles is required', 'error');
                        return;
                    }
                    if (!emailValue) {
                        showToast('Email is required', 'error');
                        return;
                    }
                    if (!passwordValue) {
                        showToast('Password is required', 'error');
                        return;
                    }

                    // Validate email format
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(emailValue)) {
                        showToast('Please enter a valid email address', 'error');
                        return;
                    }

                    const userData = {
                        firstName: firstNameValue,
                        lastName: lastNameValue,
                        tier: tierValue,
                        roles: rolesValue,
                        email: emailValue,
                        password: passwordValue,
                        startWork: startWorkValue,
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
                            <p><strong>First Name:</strong> ${data.data.firstName}</p>
                            <p><strong>Last Name:</strong> ${data.data.lastName}</p>
                            <p><strong>Tier:</strong> ${data.data.tier}</p>
                            <p><strong>Roles:</strong> ${data.data.roles}</p>
                            <p><strong>Email:</strong> ${data.data.email}</p>
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
            window.testDatabaseStructure = async function() {
                const resultDiv = document.getElementById('structureResult');
                resultDiv.innerHTML = '<p>Testing database structure...</p>';

                try {
                    // Test tiers API
                    const tiersResponse = await fetch('wowdash-php/api-get-tiers.php');
                    const tiersData = await tiersResponse.json();
                    
                    // Test roles API
                    const rolesResponse = await fetch('wowdash-php/api-get-roles.php');
                    const rolesData = await rolesResponse.json();
                    
                    if (tiersData.success && rolesData.success) {
                        resultDiv.className = 'result success';
                        resultDiv.innerHTML = `
                            <h4>✅ DATABASE STRUCTURE OK!</h4>
                            <p><strong>Tiers found:</strong> ${tiersData.data.length}</p>
                            <p><strong>Roles found:</strong> ${rolesData.data.length}</p>
                            <p><strong>Tiers:</strong> ${tiersData.data.map(t => t.name).join(', ')}</p>
                            <p><strong>Roles:</strong> ${rolesData.data.map(r => r.name).join(', ')}</p>
                        `;
                    } else {
                        resultDiv.className = 'result error';
                        resultDiv.innerHTML = `
                            <h4>❌ DATABASE STRUCTURE ERROR!</h4>
                            <p>Tiers API: ${tiersData.success ? 'OK' : 'FAILED'}</p>
                            <p>Roles API: ${rolesData.success ? 'OK' : 'FAILED'}</p>
                        `;
                    }
                } catch (error) {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h4>❌ ERROR!</h4>
                        <p>${error.message}</p>
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