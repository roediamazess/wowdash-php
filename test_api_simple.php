<!DOCTYPE html>
<html>
<head>
    <title>Test API Simple</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        button { padding: 10px 20px; margin: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Test API Simple</h1>
    
    <button onclick="testTiers()">Test Tiers API</button>
    <button onclick="testRoles()">Test Roles API</button>
    <button onclick="fixDatabase()">Fix Database</button>
    
    <div id="result"></div>

    <script>
        async function testTiers() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '<p>Testing Tiers API...</p>';
            
            try {
                const response = await fetch('wowdash-php/api-get-tiers.php');
                const data = await response.json();
                
                if (data.success) {
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = `
                        <h3>✅ Tiers API Success!</h3>
                        <p>Found ${data.data.length} tiers:</p>
                        <ul>
                            ${data.data.map(tier => `<li>${tier.name} (ID: ${tier.id})</li>`).join('')}
                        </ul>
                    `;
                } else {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h3>❌ Tiers API Failed!</h3>
                        <p>Error: ${data.message}</p>
                    `;
                }
            } catch (error) {
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `
                    <h3>❌ Network Error!</h3>
                    <p>Error: ${error.message}</p>
                `;
            }
        }

        async function testRoles() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '<p>Testing Roles API...</p>';
            
            try {
                const response = await fetch('wowdash-php/api-get-roles.php');
                const data = await response.json();
                
                if (data.success) {
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = `
                        <h3>✅ Roles API Success!</h3>
                        <p>Found ${data.data.length} roles:</p>
                        <ul>
                            ${data.data.map(role => `<li>${role.name} (ID: ${role.id})</li>`).join('')}
                        </ul>
                    `;
                } else {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h3>❌ Roles API Failed!</h3>
                        <p>Error: ${data.message}</p>
                    `;
                }
            } catch (error) {
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `
                    <h3>❌ Network Error!</h3>
                    <p>Error: ${error.message}</p>
                `;
            }
        }

        function fixDatabase() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '<p>Fixing database...</p>';
            
            // Open fix_database.php in new window
            window.open('fix_database.php', '_blank');
            
            setTimeout(() => {
                resultDiv.innerHTML = '<p>Database fix script opened. Please run it and then test the APIs again.</p>';
            }, 1000);
        }
    </script>
</body>
</html> 