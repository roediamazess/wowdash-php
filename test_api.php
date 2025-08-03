<!DOCTYPE html>
<html>
<head>
    <title>Test API</title>
</head>
<body>
    <h2>Test User API</h2>
    
    <form id="testForm">
        <div>
            <label>User Name:</label>
            <input type="text" id="userName" value="Fajar Ahmad Akbar" required>
        </div>
        <div>
            <label>User Tier:</label>
            <select id="userTier">
                <option value="Tier 3">Tier 3</option>
                <option value="Premium">Premium</option>
                <option value="Standard">Standard</option>
                <option value="Basic">Basic</option>
            </select>
        </div>
        <div>
            <label>Start Work:</label>
            <input type="date" id="startWork" value="2024-01-01">
        </div>
        <div>
            <label>User Role:</label>
            <select id="userRole">
                <option value="User">User</option>
                <option value="Administrator">Administrator</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Admin Officer">Admin Officer</option>
            </select>
        </div>
        <div>
            <label>User Email:</label>
            <input type="email" id="userEmail" value="akbar@powerpro.co.id" required>
        </div>
        <div>
            <label>Birthday:</label>
            <input type="date" id="birthday" value="1990-01-01">
        </div>
        <button type="submit">Test Save User</button>
    </form>
    
    <div id="result"></div>
    
    <script>
        document.getElementById('testForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const userData = {
                userName: document.getElementById('userName').value,
                userTier: document.getElementById('userTier').value,
                startWork: document.getElementById('startWork').value,
                userRole: document.getElementById('userRole').value,
                userEmail: document.getElementById('userEmail').value,
                birthday: document.getElementById('birthday').value,
            };
            
            try {
                const response = await fetch('wowdash-php/api-user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                });
                
                const result = await response.json();
                document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(result, null, 2) + '</pre>';
                
                if (result.success) {
                    alert('Success: ' + result.message);
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                document.getElementById('result').innerHTML = '<pre>Error: ' + error.message + '</pre>';
                alert('Network error: ' + error.message);
            }
        });
    </script>
</body>
</html> 