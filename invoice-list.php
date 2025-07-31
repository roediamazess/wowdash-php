<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Daily Activity List</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Daily Activity List</li>
                </ul>
            </div>

            <!-- Add New Daily Activity Button -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Daily Activity Management</h6>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDailyActivityModal">
                            <iconify-icon icon="ri-add-line" class="me-2"></iconify-icon>
                            Add New Daily Activity
                        </button>
                    </div>
                </div>
            </div>

            <!-- Daily Activity List -->
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span>Show</span>
                            <select class="form-select form-select-sm w-auto">
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                            </select>
                        </div>
                        <div class="icon-field">
                            <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search Daily Activity">
                            <span class="icon">
                                <iconify-icon icon="ion:search-outline"></iconify-icon>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <select class="form-select form-select-sm w-auto">
                            <option>All Status</option>
                            <option>Open</option>
                            <option>On Progress</option>
                            <option>Need Requirement</option>
                            <option>Done</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="daily-activity-list">
                        <div class="activity-item p-16 border-bottom" data-activity-id="1" onclick="viewDailyActivity(1)">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="activity-number">
                                        <div class="w-32-px h-32-px bg-primary-600 rounded-circle d-flex align-items-center justify-content-center">
                                            <span class="text-white fw-semibold text-sm">001</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">John Doe - Manager</h6>
                                        <p class="mb-1 text-secondary-light">Food & Beverage • POS System</p>
                                        <p class="mb-0 text-secondary-light text-sm">Setup new POS system for restaurant area</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="mb-2">
                                        <span class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">On Progress</span>
                                    </div>
                                    <div class="text-secondary-light text-sm">
                                        <div>Info: 25 Jan 2024</div>
                                        <div>Due: 30 Jan 2024</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="activity-item p-16 border-bottom" data-activity-id="2" onclick="viewDailyActivity(2)">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="activity-number">
                                        <div class="w-32-px h-32-px bg-primary-600 rounded-circle d-flex align-items-center justify-content-center">
                                            <span class="text-white fw-semibold text-sm">002</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">Jane Smith - Supervisor</h6>
                                        <p class="mb-1 text-secondary-light">Kitchen • Inventory System</p>
                                        <p class="mb-0 text-secondary-light text-sm">Inventory system showing incorrect stock levels</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="mb-2">
                                        <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Done</span>
                                    </div>
                                    <div class="text-secondary-light text-sm">
                                        <div>Info: 24 Jan 2024</div>
                                        <div>Due: 26 Jan 2024</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Daily Activity Modal -->
        <div class="modal fade" id="addDailyActivityModal" tabindex="-1" aria-labelledby="addDailyActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDailyActivityModalLabel">Add New Daily Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="dailyActivityForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="informationDate" class="form-label">Information Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="informationDate" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="userPosition" class="form-label">User & Position <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="userPosition" placeholder="e.g., John Doe - Manager" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                                    <select class="form-select" id="department" required>
                                        <option value="">Select Department</option>
                                        <option value="Food & Beverage">Food & Beverage</option>
                                        <option value="Kitchen">Kitchen</option>
                                        <option value="Room Division">Room Division</option>
                                        <option value="Front Office">Front Office</option>
                                        <option value="Housekeeping">Housekeeping</option>
                                        <option value="Engineering">Engineering</option>
                                        <option value="Sales & Marketing">Sales & Marketing</option>
                                        <option value="IT / EDP">IT / EDP</option>
                                        <option value="Accounting">Accounting</option>
                                        <option value="Executive Office">Executive Office</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="application" class="form-label">Application <span class="text-danger">*</span></label>
                                    <select class="form-select" id="application" required>
                                        <option value="">Select Application</option>
                                        <option value="POS System">POS System</option>
                                        <option value="Inventory System">Inventory System</option>
                                        <option value="Booking System">Booking System</option>
                                        <option value="HR System">HR System</option>
                                        <option value="Accounting System">Accounting System</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="type" required>
                                        <option value="">Select Type</option>
                                        <option value="Setup">Setup</option>
                                        <option value="Question">Question</option>
                                        <option value="Issue">Issue</option>
                                        <option value="Report Issue">Report Issue</option>
                                        <option value="Report Request">Report Request</option>
                                        <option value="Feature Request">Feature Request</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dueDate" class="form-label">Due Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dueDate" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Open">Open</option>
                                        <option value="On Progress">On Progress</option>
                                        <option value="Need Requirement">Need Requirement</option>
                                        <option value="Done">Done</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cncNumber" class="form-label">CNC Number</label>
                                    <input type="text" class="form-control" id="cncNumber" placeholder="Enter CNC Number">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" rows="4" placeholder="Enter detailed description..." required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="actionSolution" class="form-label">Action / Solution <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="actionSolution" rows="4" placeholder="Enter action or solution..." required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveDailyActivity()">Save Daily Activity</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Daily Activity Modal -->
        <div class="modal fade" id="viewDailyActivityModal" tabindex="-1" aria-labelledby="viewDailyActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewDailyActivityModalLabel">Daily Activity Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Information Date</label>
                                <p class="mb-0" id="viewInformationDate"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">User & Position</label>
                                <p class="mb-0" id="viewUserPosition"></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Department</label>
                                <p class="mb-0" id="viewDepartment"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Application</label>
                                <p class="mb-0" id="viewApplication"></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Type</label>
                                <p class="mb-0" id="viewType"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Due Date</label>
                                <p class="mb-0" id="viewDueDate"></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <p class="mb-0" id="viewStatus"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">CNC Number</label>
                                <p class="mb-0" id="viewCncNumber"></p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <p class="mb-0" id="viewDescription"></p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Action / Solution</label>
                            <p class="mb-0" id="viewActionSolution"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success" onclick="editDailyActivity()">Edit</button>
                            <button type="button" class="btn btn-danger" onclick="deleteDailyActivity()">Delete</button>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .activity-item {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            
            .activity-item:hover {
                background-color: #e3f2fd;
                border-left: 3px solid #2196f3;
            }
        </style>

        <script>
            // View Daily Activity
            function viewDailyActivity(id) {
                // Demo data - in real app, fetch from database
                const demoData = {
                    1: {
                        informationDate: '2024-01-25',
                        userPosition: 'John Doe - Manager',
                        department: 'Food & Beverage',
                        application: 'POS System',
                        type: 'Setup',
                        dueDate: '2024-01-30',
                        status: 'On Progress',
                        cncNumber: 'CNC-001',
                        description: 'Setup new POS system for restaurant area. Need to configure menu items, pricing, and payment methods.',
                        actionSolution: 'Installation completed. Training scheduled for staff on January 28th.'
                    },
                    2: {
                        informationDate: '2024-01-24',
                        userPosition: 'Jane Smith - Supervisor',
                        department: 'Kitchen',
                        application: 'Inventory System',
                        type: 'Issue',
                        dueDate: '2024-01-26',
                        status: 'Done',
                        cncNumber: 'CNC-002',
                        description: 'Inventory system showing incorrect stock levels for kitchen supplies.',
                        actionSolution: 'Database sync issue resolved. Stock levels updated correctly.'
                    }
                };
                
                const data = demoData[id];
                if (data) {
                    document.getElementById('viewInformationDate').textContent = data.informationDate;
                    document.getElementById('viewUserPosition').textContent = data.userPosition;
                    document.getElementById('viewDepartment').textContent = data.department;
                    document.getElementById('viewApplication').textContent = data.application;
                    document.getElementById('viewType').textContent = data.type;
                    document.getElementById('viewDueDate').textContent = data.dueDate;
                    document.getElementById('viewStatus').textContent = data.status;
                    document.getElementById('viewCncNumber').textContent = data.cncNumber;
                    document.getElementById('viewDescription').textContent = data.description;
                    document.getElementById('viewActionSolution').textContent = data.actionSolution;
                    
                    // Store current activity ID for edit/delete
                    window.currentActivityId = id;
                    
                    const modal = new bootstrap.Modal(document.getElementById('viewDailyActivityModal'));
                    modal.show();
                }
            }
            
            // Edit Daily Activity
            function editDailyActivity() {
                if (window.currentActivityId) {
                    // Implementation for edit functionality
                    alert('Edit functionality for Daily Activity ID: ' + window.currentActivityId);
                }
            }
            
            // Delete Daily Activity
            function deleteDailyActivity() {
                if (window.currentActivityId) {
                    if (confirm('Are you sure you want to delete this Daily Activity?')) {
                        // Implementation for delete functionality
                        alert('Delete functionality for Daily Activity ID: ' + window.currentActivityId);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('viewDailyActivityModal'));
                        modal.hide();
                    }
                }
            }
            
            // Save Daily Activity
            function saveDailyActivity() {
                const form = document.getElementById('dailyActivityForm');
                if (form.checkValidity()) {
                    // Implementation for save functionality
                    alert('Daily Activity saved successfully!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addDailyActivityModal'));
                    modal.hide();
                    form.reset();
                } else {
                    form.reportValidity();
                }
            }
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>