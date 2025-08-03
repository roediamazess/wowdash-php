<!DOCTYPE html>
<html>
<head>
    <title>Test API Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 20px 0; padding: 15px; border-radius: 8px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        button { padding: 12px 24px; font-size: 16px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px; }
        button:hover { background: #0056b3; }
        .log { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; margin: 10px 0; font-family: monospace; font-size: 12px; }
    </style>
</head>
<body>
    <h1>Test API Test</h1>
    
    <button onclick="testAPI()">Test API Test</button>
    <div id="result"></div>
    <div id="log"></div>
    
    <script>
        async function testAPI() {
            const resultDiv = document.getElementById('result');
            const logDiv = document.getElementById('log');
            
            resultDiv.innerHTML = '<p>Testing...</p>';
            logDiv.innerHTML = '<h3>Console Log:</h3>';
            
            const userData = {
                userName: "Fajar Ahmad Akbar",
                userTier: "Tier 3",
                startWork: "2024-01-01",
                userRole: "User",
                userEmail: "test" + Date.now() + "@example.com",
                birthday: "1990-01-01"
            };
            
            function addLog(message) {
                logDiv.innerHTML += '<div class="log">' + new Date().toLocaleTimeString() + ': ' + message + '</div>';
            }
            
            try {
                addLog('Sending data: ' + JSON.stringify(userData));
                console.log('Sending data:', userData);
                
                const response = await fetch('wowdash-php/api-user-test.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                });
                
                addLog('Response status: ' + response.status);
                console.log('Response status:', response.status);
                
                const result = await response.json();
                addLog('Response data: ' + JSON.stringify(result));
                console.log('Response data:', result);
                
                if (result.success) {
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = `
                        <h3>✅ SUCCESS!</h3>
                        <p><strong>Message:</strong> ${result.message}</p>
                        <p><strong>User ID:</strong> ${result.data.id}</p>
                        <p><strong>User Name:</strong> ${result.data.user_name}</p>
                        <p><strong>Email:</strong> ${result.data.user_email}</p>
                        <p><strong>Tier:</strong> ${result.data.user_tier}</p>
                        <p><strong>Role:</strong> ${result.data.user_role}</p>
                        <p><strong>Start Work:</strong> ${result.data.start_work}</p>
                        <p><strong>Birthday:</strong> ${result.data.birthday}</p>
                    `;
                    addLog('✅ SUCCESS - User created successfully');
                } else {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h3>❌ ERROR!</h3>
                        <p><strong>Message:</strong> ${result.message}</p>
                    `;
                    addLog('❌ ERROR - ' + result.message);
                }
                
            } catch (error) {
                console.error('Error:', error);
                addLog('❌ NETWORK ERROR - ' + error.message);
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `
                    <h3>❌ NETWORK ERROR!</h3>
                    <p><strong>Error:</strong> ${error.message}</p>
                `;
            }
        }
    </script>
</body>
</html> 