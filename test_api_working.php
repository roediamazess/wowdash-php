<!DOCTYPE html>
<html>
<head>
    <title>Test API Working</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 20px 0; padding: 10px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        button { padding: 10px 20px; font-size: 16px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Test API Working</h1>
    
    <button onclick="testAPI()">Test API</button>
    <div id="result"></div>
    
    <script>
        async function testAPI() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = 'Testing...';
            
            const userData = {
                userName: "Test User",
                userTier: "Tier 3",
                startWork: "2024-01-01",
                userRole: "User",
                userEmail: "test" + Date.now() + "@example.com",
                birthday: "1990-01-01"
            };
            
            try {
                console.log('Sending data:', userData);
                
                const response = await fetch('wowdash-php/api-user-simple.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                });
                
                console.log('Response status:', response.status);
                
                const result = await response.json();
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
                    `;
                } else {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h3>❌ ERROR!</h3>
                        <p><strong>Message:</strong> ${result.message}</p>
                    `;
                }
                
            } catch (error) {
                console.error('Error:', error);
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