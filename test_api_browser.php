<!DOCTYPE html>
<html>
<head>
    <title>Test API Browser</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 20px 0; padding: 15px; border-radius: 8px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        button { padding: 12px 24px; font-size: 16px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px; }
        button:hover { background: #0056b3; }
        pre { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; margin: 10px 0; font-family: monospace; font-size: 12px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Test API Browser</h1>
    
    <button onclick="testAPI()">Test API</button>
    <div id="result"></div>

    <script>
        async function testAPI() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '<p>Testing...</p>';

            const userData = {
                userId: 'AB',
                userName: 'AKBAR TJ',
                userTier: 'Tier 3',
                startWork: '2025-08-04',
                userRole: 'User',
                userEmail: 'mamat@powerpro.id',
                password: 'test123',
                birthday: '1990-01-01'
            };

            try {
                console.log('Sending data:', userData);
                
                const response = await fetch('wowdash-php/api-user-simple-test.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                });

                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);

                const responseText = await response.text();
                console.log('Raw response:', responseText);

                resultDiv.innerHTML = `
                    <h3>Response Status: ${response.status}</h3>
                    <h3>Raw Response:</h3>
                    <pre>${responseText}</pre>
                `;

                // Try to parse as JSON
                try {
                    const jsonData = JSON.parse(responseText);
                    resultDiv.innerHTML += `
                        <h3 style="color: green;">✅ JSON Parse Success:</h3>
                        <pre>${JSON.stringify(jsonData, null, 2)}</pre>
                    `;
                } catch (jsonError) {
                    resultDiv.innerHTML += `
                        <h3 style="color: red;">❌ JSON Parse Error:</h3>
                        <p>${jsonError.message}</p>
                    `;
                }

            } catch (error) {
                console.error('Error:', error);
                resultDiv.innerHTML = `
                    <h3 style="color: red;">❌ Network Error:</h3>
                    <p>${error.message}</p>
                `;
            }
        }
    </script>
</body>
</html> 