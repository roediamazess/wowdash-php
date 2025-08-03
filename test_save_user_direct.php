<!DOCTYPE html>
<html>
<head>
    <title>Test Save User Direct</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Test Save User Direct</h2>
        
        <div class="card">
            <div class="card-body">
                <form id="testForm">
                    <div class="mb-3">
                        <label for="userName" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="userName" value="Fajar Ahmad Akbar" required>
                    </div>
                    <div class="mb-3">
                        <label for="userTier" class="form-label">User Tier</label>
                        <select class="form-control" id="userTier">
                            <option value="Tier 3">Tier 3</option>
                            <option value="Premium">Premium</option>
                            <option value="Standard">Standard</option>
                            <option value="Basic">Basic</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="startWork" class="form-label">Start Work</label>
                        <input type="date" class="form-control" id="startWork" value="2024-01-01">
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">User Role</label>
                        <select class="form-control" id="userRole">
                            <option value="User">User</option>
                            <option value="Administrator">Administrator</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Admin Officer">Admin Officer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">User Email</label>
                        <input type="email" class="form-control" id="userEmail" value="akbar@powerpro.co.id" required>
                    </div>
                    <div class="mb-3">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date" class="form-control" id="birthday" value="1990-01-01">
                    </div>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </form>
            </div>
        </div>
        
        <div class="mt-4">
            <h4>Result:</h4>
            <div id="result" class="alert alert-info" style="display: none;"></div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            
            console.log('Sending data:', userData);
            
            try {
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
                
                const resultDiv = document.getElementById('result');
                resultDiv.style.display = 'block';
                
                if (result.success) {
                    resultDiv.className = 'alert alert-success';
                    resultDiv.innerHTML = '<strong>Success!</strong><br>' + result.message + '<br><br><pre>' + JSON.stringify(result.data, null, 2) + '</pre>';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'User Created Successfully!',
                        text: result.message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    resultDiv.className = 'alert alert-danger';
                    resultDiv.innerHTML = '<strong>Error!</strong><br>' + result.message;
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: result.message
                    });
                }
                
            } catch (error) {
                console.error('Error:', error);
                const resultDiv = document.getElementById('result');
                resultDiv.style.display = 'block';
                resultDiv.className = 'alert alert-danger';
                resultDiv.innerHTML = '<strong>Network Error!</strong><br>' + error.message;
                
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error!',
                    text: error.message
                });
            }
        });
    </script>
</body>
</html> 