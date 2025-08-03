<?php 
// Session check - bypass for testing
// require_once './session_check.php';

// Check if user has admin role - bypass for testing
// if (!isset($_SESSION['user_role']) || 
//     ($_SESSION['user_role'] !== 'Administrator' && 
//      $_SESSION['user_role'] !== 'Super Admin' && 
//      $_SESSION['user_role'] !== 'Supervisor')) {
//     // Redirect non-admin users to profile settings
//     header('Location: profile-settings.php');
//     exit;
// }

// Include tier data functions
include_once __DIR__ . '/partials/get_tiers.php';
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Users List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-info { background-color: #f8f9fa; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .console-log { background-color: #000; color: #fff; padding: 10px; height: 200px; overflow-y: scroll; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Debug Users List</h1>
        
        <div class="debug-info">
            <h4>Debug Information:</h4>
            <p><strong>Bootstrap Version:</strong> <span id="bootstrapVersion">Loading...</span></p>
            <p><strong>Modal Element:</strong> <span id="modalElement">Loading...</span></p>
            <p><strong>Add Button:</strong> <span id="addButton">Loading...</span></p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h3>Test Add New User Button</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" id="addBtn">
                    Add New User
                </button>
                <div id="buttonResult" class="mt-3"></div>
            </div>
            
            <div class="col-md-6">
                <h3>Test JavaScript Modal</h3>
                <button class="btn btn-success" onclick="testJavaScriptModal()">
                    Test JavaScript Modal
                </button>
                <div id="jsResult" class="mt-3"></div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h3>Console Log</h3>
                <div id="consoleLog" class="console-log">
                    <p>Console logs will appear here...</p>
                </div>
            </div>
        </div>
    </div>

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
                            <label for="addFirstName" class="form-label">First Name *</label>
                            <input type="text" class="form-control" id="addFirstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="addLastName">
                        </div>
                        <div class="mb-3">
                            <label for="addTier" class="form-label">Tier *</label>
                            <select class="form-control" id="addTier" required>
                                <option value="">Select Tier</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addRoles" class="form-label">Roles *</label>
                            <select class="form-control" id="addRoles" required>
                                <option value="">Select Role</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addEmail" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="addEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="addPassword" class="form-label">Password *</label>
                            <input type="password" class="form-control" id="addPassword" placeholder="Enter password" required>
                        </div>
                        <div class="mb-3">
                            <label for="addStartWork" class="form-label">Start Work</label>
                            <input type="date" class="form-control" id="addStartWork" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="mb-3">
                            <label for="addBirthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="addBirthday" placeholder="YYYY-MM-DD">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveUserBtn">Save User</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            const color = type === 'error' ? '#ff6b6b' : '#fff';
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
            console.log('DOM loaded');
            
            // Check Bootstrap
            if (typeof bootstrap !== 'undefined') {
                console.log('✅ Bootstrap is loaded');
                document.getElementById('bootstrapVersion').textContent = 'Loaded';
                document.getElementById('bootstrapVersion').style.color = 'green';
            } else {
                console.error('❌ Bootstrap is not loaded');
                document.getElementById('bootstrapVersion').textContent = 'Not loaded';
                document.getElementById('bootstrapVersion').style.color = 'red';
            }
            
            // Check modal element
            const modalElement = document.getElementById('addUserModal');
            if (modalElement) {
                console.log('✅ Modal element found');
                document.getElementById('modalElement').textContent = 'Found';
                document.getElementById('modalElement').style.color = 'green';
            } else {
                console.error('❌ Modal element not found');
                document.getElementById('modalElement').textContent = 'Not found';
                document.getElementById('modalElement').style.color = 'red';
            }
            
            // Check add button
            const addButton = document.getElementById('addBtn');
            if (addButton) {
                console.log('✅ Add button found');
                document.getElementById('addButton').textContent = 'Found';
                document.getElementById('addButton').style.color = 'green';
                
                // Add click event listener
                addButton.addEventListener('click', function(e) {
                    console.log('Add button clicked!');
                    addToConsole('Add button clicked!');
                    document.getElementById('buttonResult').innerHTML = '<div class="alert alert-success">✅ Add button clicked!</div>';
                });
            } else {
                console.error('❌ Add button not found');
                document.getElementById('addButton').textContent = 'Not found';
                document.getElementById('addButton').style.color = 'red';
            }
            
            // Test modal events
            if (modalElement) {
                modalElement.addEventListener('show.bs.modal', function() {
                    console.log('Modal is showing');
                    addToConsole('Modal is showing');
                    document.getElementById('buttonResult').innerHTML = '<div class="alert alert-info">📋 Modal is showing!</div>';
                });
                
                modalElement.addEventListener('shown.bs.modal', function() {
                    console.log('Modal is shown');
                    addToConsole('Modal is shown');
                    document.getElementById('buttonResult').innerHTML = '<div class="alert alert-success">✅ Modal is shown!</div>';
                });
                
                modalElement.addEventListener('hide.bs.modal', function() {
                    console.log('Modal is hiding');
                    addToConsole('Modal is hiding');
                });
                
                modalElement.addEventListener('hidden.bs.modal', function() {
                    console.log('Modal is hidden');
                    addToConsole('Modal is hidden');
                });
            }
            
            // Test save user button
            const saveUserBtn = document.getElementById('saveUserBtn');
            if (saveUserBtn) {
                console.log('✅ Save User button found');
                saveUserBtn.addEventListener('click', function(e) {
                    console.log('Save User button clicked!');
                    addToConsole('Save User button clicked!');
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Simple validation
                    const firstName = document.getElementById('addFirstName').value;
                    if (!firstName) {
                        console.log('First name is required');
                        addToConsole('First name is required');
                        return;
                    }
                    
                    console.log('Form validation passed');
                    addToConsole('Form validation passed');
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                        console.log('Modal closed');
                        addToConsole('Modal closed');
                    }
                });
            } else {
                console.error('❌ Save User button not found');
            }
        });

        // Global function for testing JavaScript modal
        function testJavaScriptModal() {
            console.log('testJavaScriptModal function called');
            addToConsole('testJavaScriptModal function called');
            
            try {
                const modalElement = document.getElementById('addUserModal');
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                    console.log('Modal shown via JavaScript');
                    addToConsole('Modal shown via JavaScript');
                    document.getElementById('jsResult').innerHTML = '<div class="alert alert-success">✅ Modal shown via JavaScript!</div>';
                } else {
                    throw new Error('Modal element not found');
                }
            } catch (error) {
                console.error('Error showing modal:', error);
                addToConsole('Error showing modal: ' + error.message, 'error');
                document.getElementById('jsResult').innerHTML = '<div class="alert alert-danger">❌ Error: ' + error.message + '</div>';
            }
        }
    </script>
</body>
</html> 