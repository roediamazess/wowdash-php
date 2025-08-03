<!DOCTYPE html>
<html>
<head>
    <title>Test Bootstrap Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        button { padding: 10px 20px; margin: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Bootstrap Modal</h1>
        
        <div class="row">
            <div class="col-md-6">
                <h3>1. Test Modal dengan data-bs-toggle</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testModal1">
                    Test Modal 1 (data-bs-toggle)
                </button>
                <div id="result1" class="result"></div>
            </div>
            
            <div class="col-md-6">
                <h3>2. Test Modal dengan JavaScript</h3>
                <button class="btn btn-success" onclick="testModal2()">
                    Test Modal 2 (JavaScript)
                </button>
                <div id="result2" class="result"></div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h3>3. Console Log</h3>
                <div id="consoleLog" class="result" style="background-color: #f8f9fa; height: 200px; overflow-y: scroll;">
                    <p>Console logs will appear here...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Modal 1 -->
    <div class="modal fade" id="testModal1" tabindex="-1" aria-labelledby="testModal1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testModal1Label">Test Modal 1</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>This is test modal 1 using data-bs-toggle</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Modal 2 -->
    <div class="modal fade" id="testModal2" tabindex="-1" aria-labelledby="testModal2Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testModal2Label">Test Modal 2</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>This is test modal 2 using JavaScript</p>
                </div>
                <div class="modal-footer">
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
            const color = type === 'error' ? 'red' : 'black';
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
            console.log('Bootstrap version:', typeof bootstrap);
            console.log('Modal constructor:', typeof bootstrap.Modal);
            
            // Test if Bootstrap is loaded
            if (typeof bootstrap !== 'undefined') {
                console.log('✅ Bootstrap is loaded');
                addToConsole('✅ Bootstrap is loaded');
            } else {
                console.error('❌ Bootstrap is not loaded');
                addToConsole('❌ Bootstrap is not loaded', 'error');
            }
            
            // Test modal 1
            const modal1 = document.getElementById('testModal1');
            if (modal1) {
                console.log('✅ Modal 1 element found');
                addToConsole('✅ Modal 1 element found');
                
                // Listen for modal events
                modal1.addEventListener('show.bs.modal', function() {
                    console.log('Modal 1 is showing');
                    addToConsole('Modal 1 is showing');
                    document.getElementById('result1').className = 'result success';
                    document.getElementById('result1').innerHTML = '<h4>✅ Modal 1 is showing!</h4>';
                });
                
                modal1.addEventListener('shown.bs.modal', function() {
                    console.log('Modal 1 is shown');
                    addToConsole('Modal 1 is shown');
                });
            } else {
                console.error('❌ Modal 1 element not found');
                addToConsole('❌ Modal 1 element not found', 'error');
            }
            
            // Test modal 2
            const modal2 = document.getElementById('testModal2');
            if (modal2) {
                console.log('✅ Modal 2 element found');
                addToConsole('✅ Modal 2 element found');
                
                // Listen for modal events
                modal2.addEventListener('show.bs.modal', function() {
                    console.log('Modal 2 is showing');
                    addToConsole('Modal 2 is showing');
                    document.getElementById('result2').className = 'result success';
                    document.getElementById('result2').innerHTML = '<h4>✅ Modal 2 is showing!</h4>';
                });
            } else {
                console.error('❌ Modal 2 element not found');
                addToConsole('❌ Modal 2 element not found', 'error');
            }
        });

        // Global function for testing modal 2
        function testModal2() {
            console.log('testModal2 function called');
            addToConsole('testModal2 function called');
            
            try {
                const modal = new bootstrap.Modal(document.getElementById('testModal2'));
                modal.show();
                console.log('Modal 2 shown via JavaScript');
                addToConsole('Modal 2 shown via JavaScript');
            } catch (error) {
                console.error('Error showing modal 2:', error);
                addToConsole('Error showing modal 2: ' + error.message, 'error');
                document.getElementById('result2').className = 'result error';
                document.getElementById('result2').innerHTML = '<h4>❌ Error showing modal 2</h4><p>' + error.message + '</p>';
            }
        }
    </script>
</body>
</html> 