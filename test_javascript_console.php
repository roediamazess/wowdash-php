<!DOCTYPE html>
<html>
<head>
    <title>Test JavaScript Console</title>
</head>
<body>
    <h2>Test JavaScript Console</h2>
    
    <div>
        <h3>1. Test Console Log</h3>
        <button onclick="testConsole()">Test Console Log</button>
        <div id="consoleOutput"></div>
    </div>
    
    <div>
        <h3>2. Test Fetch API</h3>
        <button onclick="testFetch()">Test Fetch API</button>
        <div id="fetchOutput"></div>
    </div>
    
    <div>
        <h3>3. Test API Call</h3>
        <button onclick="testAPICall()">Test API Call</button>
        <div id="apiOutput"></div>
    </div>
    
    <script>
        function testConsole() {
            console.log('Test console log message');
            console.error('Test console error message');
            console.warn('Test console warning message');
            
            document.getElementById('consoleOutput').innerHTML = 
                '<p style="color: green;">✅ Console messages logged. Check browser console (F12).</p>';
        }
        
        async function testFetch() {
            try {
                console.log('Testing fetch API...');
                
                const response = await fetch('debug_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({test: 'data'})
                });
                
                console.log('Fetch response status:', response.status);
                console.log('Fetch response headers:', response.headers);
                
                const data = await response.json();
                console.log('Fetch response data:', data);
                
                document.getElementById('fetchOutput').innerHTML = 
                    '<p style="color: green;">✅ Fetch API working. Check console for details.</p>' +
                    '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                
            } catch (error) {
                console.error('Fetch error:', error);
                document.getElementById('fetchOutput').innerHTML = 
                    '<p style="color: red;">❌ Fetch error: ' + error.message + '</p>';
            }
        }
        
        async function testAPICall() {
            try {
                console.log('Testing API call...');
                
                const userData = {
                    userName: "Test User",
                    userTier: "Tier 3",
                    startWork: "2024-01-01",
                    userRole: "User",
                    userEmail: "test@example.com",
                    birthday: "1990-01-01"
                };
                
                console.log('Sending data:', userData);
                
                const response = await fetch('wowdash-php/api-user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                });
                
                console.log('API response status:', response.status);
                
                const data = await response.json();
                console.log('API response data:', data);
                
                if (data.success) {
                    document.getElementById('apiOutput').innerHTML = 
                        '<p style="color: green;">✅ API call successful!</p>' +
                        '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                } else {
                    document.getElementById('apiOutput').innerHTML = 
                        '<p style="color: red;">❌ API call failed: ' + data.message + '</p>' +
                        '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                }
                
            } catch (error) {
                console.error('API call error:', error);
                document.getElementById('apiOutput').innerHTML = 
                    '<p style="color: red;">❌ API call error: ' + error.message + '</p>';
            }
        }
        
        // Log when page loads
        console.log('Test page loaded at:', new Date().toISOString());
        console.log('User agent:', navigator.userAgent);
        console.log('Window location:', window.location.href);
    </script>
</body>
</html> 