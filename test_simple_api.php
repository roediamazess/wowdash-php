<!DOCTYPE html>
<html>
<head>
    <title>Test Simple API</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 20px 0; padding: 15px; border-radius: 8px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        button { padding: 12px 24px; font-size: 16px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px; margin: 5px; }
        button:hover { background: #0056b3; }
        pre { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; margin: 10px 0; font-family: monospace; font-size: 12px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Test Simple API (No Database)</h1>
    
    <button onclick="testAPI()">Test Simple API</button>
    <div id="result"></div>

    <script>
        async function testAPI() {
            const resultDiv = document.getElementById('result');
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

            console.log('Testing API with data:', userData);

            try {
                const response = await fetch('wowdash-php/api-user-simple-final.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(userData)
                });

                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);

                const responseText = await response.text();
                console.log('Raw response:', responseText);

                let data;
                try {
                    data = JSON.parse(responseText);
                    console.log('Parsed JSON:', data);
                } catch (parseError) {
                    console.error('JSON parse error:', parseError);
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h4>❌ JSON PARSE ERROR!</h4>
                        <p><strong>Raw Response:</strong></p>
                        <pre>${responseText}</pre>
                        <p><strong>Parse Error:</strong> ${parseError.message}</p>
                    `;
                    return;
                }

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
                        <p><strong>Raw Response:</strong></p>
                        <pre>${responseText}</pre>
                    `;
                } else {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h4>❌ ERROR!</h4>
                        <p><strong>Message:</strong> ${data.message}</p>
                        <p><strong>Raw Response:</strong></p>
                        <pre>${responseText}</pre>
                    `;
                }
            } catch (error) {
                console.error('Fetch error:', error);
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `
                    <h4>❌ FETCH ERROR!</h4>
                    <p><strong>Error:</strong> ${error.message}</p>
                `;
            }
        }
    </script>
</body>
</html> 