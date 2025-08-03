<!DOCTYPE html>
<html>
<head>
    <title>Test Save User - Fixed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        button { padding: 10px 20px; margin: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Save User - Fixed</h1>
        
        <div class="row">
            <div class="col-md-6">
                <h3>1. Test APIs</h3>
                <button onclick="testTiersAPI()">Test Tiers API</button>
                <button onclick="testRolesAPI()">Test Roles API</button>
                <div id="apiResult"></div>
            </div>
            
            <div class="col-md-6">
                <h3>2. Test Save User</h3>
                <button onclick="testSaveUser()">Test Save User</button>
                <div id="saveResult"></div>
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

            // Make functions global for button clicks
            window.testTiersAPI = async function() {
                const resultDiv = document.getElementById('apiResult');
                resultDiv.innerHTML = '<p>Testing Tiers API...</p>';
                
                try {
                    const response = await fetch('wowdash-php/api-get-tiers-simple.php');
                    const data = await response.json();
                    
                    if (data.success) {
                        resultDiv.className = 'result success';
                        resultDiv.innerHTML = `
                            <h4>✅ Tiers API Success!</h4>
                            <p>Found ${data.data.length} tiers:</p>
                            <ul>
                                ${data.data.map(tier => `<li>${tier.name} (ID: ${tier.id})</li>`).join('')}
                            </ul>
                        `;
                    } else {
                        resultDiv.className = 'result error';
                        resultDiv.innerHTML = `
                            <h4>❌ Tiers API Failed!</h4>
                            <p>Error: ${data.message}</p>
                        `;
                    }
                } catch (error) {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h4>❌ Network Error!</h4>
                        <p>Error: ${error.message}</p>
                    `;
                }
            };

            window.testRolesAPI = async function() {
                const resultDiv = document.getElementById('apiResult');
                resultDiv.innerHTML = '<p>Testing Roles API...</p>';
                
                try {
                    const response = await fetch('wowdash-php/api-get-roles-simple.php');
                    const data = await response.json();
                    
                    if (data.success) {
                        resultDiv.className = 'result success';
                        resultDiv.innerHTML = `
                            <h4>✅ Roles API Success!</h4>
                            <p>Found ${data.data.length} roles:</p>
                            <ul>
                                ${data.data.map(role => `<li>${role.name} (ID: ${role.id})</li>`).join('')}
                            </ul>
                        `;
                    } else {
                        resultDiv.className = 'result error';
                        resultDiv.innerHTML = `
                            <h4>❌ Roles API Failed!</h4>
                            <p>Error: ${data.message}</p>
                        `;
                    }
                } catch (error) {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h4>❌ Network Error!</h4>
                        <p>Error: ${error.message}</p>
                    `;
                }
            };

            window.testSaveUser = async function() {
                const resultDiv = document.getElementById('saveResult');
                resultDiv.innerHTML = '<p>Testing Save User...</p>';
                
                const userData = {
                    firstName: 'Test',
                    lastName: 'User',
                    tier: 'New Born',
                    roles: 'Admin Officer',
                    email: 'test' + Date.now() + '@example.com',
                    password: 'test123',
                    startWork: '2025-08-04',
                    birthday: '1990-01-01'
                };

                console.log('Sending user data:', userData);

                try {
                    const response = await fetch('wowdash-php/api-user-final-database.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(userData)
                    });

                    const data = await response.json();
                    console.log('API Response:', data);
                    
                    if (data && data.success) {
                        resultDiv.className = 'result success';
                        resultDiv.innerHTML = `
                            <h4>✅ SAVE USER SUCCESS!</h4>
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
                    } else if (data) {
                        resultDiv.className = 'result error';
                        resultDiv.innerHTML = `
                            <h4>❌ SAVE USER FAILED!</h4>
                            <p><strong>Message:</strong> ${data.message}</p>
                        `;
                        showToast(data.message, 'error');
                    } else {
                        resultDiv.className = 'result error';
                        resultDiv.innerHTML = `
                            <h4>❌ NO RESPONSE!</h4>
                            <p>No response from server</p>
                        `;
                        showToast('No response from server', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h4>❌ NETWORK ERROR!</h4>
                        <p>Error: ${error.message}</p>
                    `;
                    showToast('Network error: ' + error.message, 'error');
                }
            };
        });
    </script>
</body>
</html> 