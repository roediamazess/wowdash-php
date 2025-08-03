<!DOCTYPE html>
<html>
<head>
    <title>Test Modal Final</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Test Modal Final</h2>
        
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Add New User
        </button>
        
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveUserBtn">Save User</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h4>Result:</h4>
            <div id="result" class="alert alert-info" style="display: none;"></div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
            
            // Save user button event
            document.getElementById('saveUserBtn').addEventListener('click', async function() {
                console.log('Save User button clicked');
                
                const userData = {
                    userName: document.getElementById('userName').value,
                    userTier: document.getElementById('userTier').value,
                    startWork: document.getElementById('startWork').value,
                    userRole: document.getElementById('userRole').value,
                    userEmail: document.getElementById('userEmail').value,
                    birthday: document.getElementById('birthday').value,
                };
                
                console.log('User data to send:', userData);
                console.log('API URL:', 'wowdash-php/api-user-final.php');
                
                const data = await apiCall('wowdash-php/api-user-final.php', userData);
                console.log('API response:', data);
                
                const resultDiv = document.getElementById('result');
                resultDiv.style.display = 'block';
                
                if (data && data.success) {
                    resultDiv.className = 'alert alert-success';
                    resultDiv.innerHTML = `
                        <h4>✅ SUCCESS!</h4>
                        <p><strong>Message:</strong> ${data.message}</p>
                        <p><strong>User ID:</strong> ${data.data.id}</p>
                        <p><strong>User Name:</strong> ${data.data.user_name}</p>
                        <p><strong>Email:</strong> ${data.data.user_email}</p>
                        <p><strong>Tier:</strong> ${data.data.user_tier}</p>
                        <p><strong>Role:</strong> ${data.data.user_role}</p>
                    `;
                    
                    showToast(data.message);
                    addUserModal.hide();
                    document.getElementById('addUserForm').reset();
                } else if (data) {
                    resultDiv.className = 'alert alert-danger';
                    resultDiv.innerHTML = `
                        <h4>❌ ERROR!</h4>
                        <p><strong>Message:</strong> ${data.message}</p>
                    `;
                    showToast(data.message, 'error');
                } else {
                    resultDiv.className = 'alert alert-danger';
                    resultDiv.innerHTML = `
                        <h4>❌ NO RESPONSE!</h4>
                        <p>No response from server</p>
                    `;
                    console.error('No response from API');
                    showToast('No response from server', 'error');
                }
            });
        });
    </script>
</body>
</html> 