<?php
require_once './partials/db_connection.php';

// Prevent direct access
if(!isset($conn)) {
    header("Location: index.php");
    exit();
}

// Include the detail activities functions
require_once './detail_activities_functions.php';

// Include applications functions for dropdown
require_once './applications_functions.php';

$activityManager = new DetailActivitiesManager($conn);
$applicationsManager = new ApplicationsManager($conn);

// Get applications data for dropdowns
$applications = $applicationsManager->getAllApplications();

// Get activities for display
$activities = $activityManager->getAllActivities();

include './partials/layouts/layoutTop.php';
?>

<div class="dashboard-main-body d-flex flex-column min-vh-100">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="d-flex align-items-center gap-3">
            <h6 class="fw-semibold mb-0">Detail Activities</h6>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addDetailActivityModal">
                <i class="ri-add-line align-bottom"></i> Add New Activity
            </button>
        </div>
    </div>

    <!-- Activity List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Project ID</th>
                            <th>Information Date</th>
                            <th>User & Position</th>
                            <th>Department</th>
                            <th>Application</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($activities)): ?>
                            <?php foreach ($activities as $index => $activity): ?>
                                <tr class="activity-row" 
                                    data-activity-id="<?php echo $activity['id']; ?>"
                                    data-project-id="<?php echo htmlspecialchars($activity['project_id']); ?>"
                                    data-information-date="<?php echo htmlspecialchars($activity['information_date']); ?>"
                                    data-user-position="<?php echo htmlspecialchars($activity['user_position']); ?>"
                                    data-department="<?php echo htmlspecialchars($activity['department']); ?>"
                                    data-application="<?php 
                                        if (!empty($activity['application_code']) && !empty($activity['application_name'])) {
                                            echo htmlspecialchars($activity['application_code'] . ' - ' . $activity['application_name']);
                                        } else {
                                            echo htmlspecialchars($activity['application_name'] ?? 'N/A');
                                        }
                                    ?>"
                                    data-type="<?php echo htmlspecialchars($activity['type']); ?>"
                                    data-status="<?php echo htmlspecialchars($activity['status']); ?>"
                                    data-due-date="<?php echo htmlspecialchars($activity['due_date']); ?>"
                                    data-description="<?php echo htmlspecialchars($activity['description']); ?>"
                                    data-action-solution="<?php echo htmlspecialchars($activity['action_solution']); ?>"
                                    data-cnc-number="<?php echo htmlspecialchars($activity['cnc_number'] ?? ''); ?>"
                                    data-application-id="<?php echo htmlspecialchars($activity['application_id'] ?? ''); ?>">
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($activity['project_id']); ?></td>
                                    <td><?php echo htmlspecialchars($activity['information_date']); ?></td>
                                    <td><?php echo htmlspecialchars($activity['user_position']); ?></td>
                                    <td><?php echo htmlspecialchars($activity['department']); ?></td>
                                    <td><?php 
                                        if (!empty($activity['application_code']) && !empty($activity['application_name'])) {
                                            echo htmlspecialchars($activity['application_code'] . ' - ' . $activity['application_name']);
                                        } else {
                                            echo htmlspecialchars($activity['application_name'] ?? 'N/A');
                                        }
                                    ?></td>
                                    <td><?php echo htmlspecialchars($activity['type']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $activity['status'] == 'Done' ? 'success' : ($activity['status'] == 'On Progress' ? 'warning' : ($activity['status'] == 'Need Requirement' ? 'info' : 'secondary')); ?>">
                                            <?php echo htmlspecialchars($activity['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($activity['due_date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">No activities found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Detail Activity Modal -->
<div class="modal fade" id="addDetailActivityModal" tabindex="-1" aria-labelledby="addDetailActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDetailActivityModalLabel">Add New Detail Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addDetailActivityForm">
                                         <div class="row">
                         <div class="col-md-6 mb-3">
                             <label for="projectId" class="form-label">Project ID</label>
                             <input type="text" class="form-control" id="projectId" name="project_id">
                         </div>
                         <div class="col-md-6 mb-3">
                             <label for="informationDate" class="form-label">Information Date <span class="text-danger">*</span></label>
                             <input type="date" class="form-control" id="informationDate" name="information_date" required>
                         </div>
                     </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="userPosition" class="form-label">User & Position <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="userPosition" name="user_position" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                            <select class="form-control" id="department" name="department" required>
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
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="application" class="form-label">Application <span class="text-danger">*</span></label>
                            <select class="form-control" id="application" name="application" required>
                                <option value="">Select Application</option>
                                <?php foreach ($applications as $app): ?>
                                    <option value="<?php echo htmlspecialchars($app['app_code'] . ' - ' . $app['app_name']); ?>"><?php echo htmlspecialchars($app['app_code'] . ' - ' . $app['app_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="Setup">Setup</option>
                                <option value="Question">Question</option>
                                <option value="Issue">Issue</option>
                                <option value="Report Issue">Report Issue</option>
                                <option value="Report Request">Report Request</option>
                                <option value="Feature Request">Feature Request</option>
                            </select>
                        </div>
                    </div>
                    
                                         <div class="row">
                         <div class="col-md-6 mb-3">
                             <label for="dueDate" class="form-label">Due Date</label>
                             <input type="date" class="form-control" id="dueDate" name="due_date">
                         </div>
                         <div class="col-md-6 mb-3">
                             <label for="status" class="form-label">Status</label>
                             <select class="form-control" id="status" name="status">
                                 <option value="">Select Status</option>
                                 <option value="Open">Open</option>
                                 <option value="On Progress">On Progress</option>
                                 <option value="Need Requirement">Need Requirement</option>
                                 <option value="Done">Done</option>
                             </select>
                         </div>
                     </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cncNumber" class="form-label">CNC Number</label>
                            <input type="text" class="form-control" id="cncNumber" name="cnc_number">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter detailed description..." required></textarea>
                    </div>
                    
                                         <div class="mb-3">
                         <label for="actionSolution" class="form-label">Action / Solution</label>
                         <textarea class="form-control" id="actionSolution" name="action_solution" rows="4" placeholder="Enter action or solution..."></textarea>
                     </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveDetailActivity()">Save Activity</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- View Detail Activity Modal -->
<div class="modal fade" id="viewDetailActivityModal" tabindex="-1" aria-labelledby="viewDetailActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDetailActivityModalLabel">Detail Activity Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Project ID</label>
                        <p class="mb-0" id="viewProjectId"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Information Date</label>
                        <p class="mb-0" id="viewInformationDate"></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">User & Position</label>
                        <p class="mb-0" id="viewUserPosition"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Department</label>
                        <p class="mb-0" id="viewDepartment"></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Application</label>
                        <p class="mb-0" id="viewApplication"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Type</label>
                        <p class="mb-0" id="viewType"></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Due Date</label>
                        <p class="mb-0" id="viewDueDate"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <p class="mb-0" id="viewStatus"></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">CNC Number</label>
                        <p class="mb-0" id="viewCncNumber"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Created By</label>
                        <p class="mb-0" id="viewCreatedBy"></p>
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
                <button type="button" class="btn btn-warning" id="editActivityBtn">Edit</button>
                <button type="button" class="btn btn-danger" id="deleteActivityBtn">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Detail Activity Modal -->
<div class="modal fade" id="editDetailActivityModal" tabindex="-1" aria-labelledby="editDetailActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDetailActivityModalLabel">Edit Detail Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDetailActivityForm">
                    <input type="hidden" id="editActivityId" name="id">
                                         <div class="row">
                         <div class="col-md-6 mb-3">
                             <label for="editProjectId" class="form-label">Project ID</label>
                             <input type="text" class="form-control" id="editProjectId" name="project_id">
                         </div>
                         <div class="col-md-6 mb-3">
                             <label for="editInformationDate" class="form-label">Information Date <span class="text-danger">*</span></label>
                             <input type="date" class="form-control" id="editInformationDate" name="information_date" required>
                         </div>
                     </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editUserPosition" class="form-label">User & Position <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editUserPosition" name="user_position" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editDepartment" class="form-label">Department <span class="text-danger">*</span></label>
                            <select class="form-control" id="editDepartment" name="department" required>
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
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editApplication" class="form-label">Application <span class="text-danger">*</span></label>
                            <select class="form-control" id="editApplication" name="application" required>
                                <option value="">Select Application</option>
                                <?php foreach ($applications as $app): ?>
                                    <option value="<?php echo htmlspecialchars($app['app_code'] . ' - ' . $app['app_name']); ?>"><?php echo htmlspecialchars($app['app_code'] . ' - ' . $app['app_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editType" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-control" id="editType" name="type" required>
                                <option value="">Select Type</option>
                                <option value="Setup">Setup</option>
                                <option value="Question">Question</option>
                                <option value="Issue">Issue</option>
                                <option value="Report Issue">Report Issue</option>
                                <option value="Report Request">Report Request</option>
                                <option value="Feature Request">Feature Request</option>
                            </select>
                        </div>
                    </div>
                    
                                         <div class="row">
                         <div class="col-md-6 mb-3">
                             <label for="editDueDate" class="form-label">Due Date</label>
                             <input type="date" class="form-control" id="editDueDate" name="due_date">
                         </div>
                         <div class="col-md-6 mb-3">
                             <label for="editStatus" class="form-label">Status</label>
                             <select class="form-control" id="editStatus" name="status">
                                 <option value="">Select Status</option>
                                 <option value="Open">Open</option>
                                 <option value="On Progress">On Progress</option>
                                 <option value="Need Requirement">Need Requirement</option>
                                 <option value="Done">Done</option>
                             </select>
                         </div>
                     </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editCncNumber" class="form-label">CNC Number</label>
                            <input type="text" class="form-control" id="editCncNumber" name="cnc_number">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="editDescription" name="description" rows="4" placeholder="Enter detailed description..." required></textarea>
                    </div>
                    
                                         <div class="mb-3">
                         <label for="editActionSolution" class="form-label">Action / Solution</label>
                         <textarea class="form-control" id="editActionSolution" name="action_solution" rows="4" placeholder="Enter action or solution..."></textarea>
                     </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateActivityBtn">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hover effects for activity rows */
    .activity-row {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .activity-row:hover {
        background-color: #90caf9 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(33, 150, 243, 0.3);
        border-left: 4px solid #1565c0;
        color: #0d47a1;
        font-weight: 600;
        border-radius: 4px;
    }
    
    /* Table styling improvements */
    .table tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    
    .table tbody tr:last-child {
        border-bottom: none;
    }
    
    /* Smooth transitions for all interactive elements */
    .btn {
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
    }
    
    /* Modal styling */
    .modal-xl {
        max-width: 1000px;
    }
    
    .form-label.fw-semibold {
        color: #6c757d;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
    // Load applications on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadApplications();
    });
    
    // Load applications from database
    function loadApplications() {
        fetch('detail_activities_functions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=get_applications'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const applicationSelects = ['application', 'editApplication'];
                applicationSelects.forEach(selectId => {
                    const select = document.getElementById(selectId);
                    if (select) {
                        // Clear existing options except the first one (placeholder)
                        while (select.children.length > 1) {
                            select.removeChild(select.lastChild);
                        }
                        
                        data.data.forEach(app => {
                            const option = document.createElement('option');
                            option.value = `${app.code} - ${app.name}`;
                            option.textContent = `${app.code} - ${app.name}`;
                            select.appendChild(option);
                        });
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error loading applications:', error);
        });
    }
    
    // Row click event to show activity details
    document.addEventListener('click', function(e) {
        if (e.target.closest('.activity-row')) {
            const row = e.target.closest('.activity-row');
            
            // Populate detail modal
            document.getElementById('viewProjectId').textContent = row.dataset.projectId;
            document.getElementById('viewInformationDate').textContent = row.dataset.informationDate;
            document.getElementById('viewUserPosition').textContent = row.dataset.userPosition;
            document.getElementById('viewDepartment').textContent = row.dataset.department;
            document.getElementById('viewApplication').textContent = row.dataset.application;
            document.getElementById('viewType').textContent = row.dataset.type;
            document.getElementById('viewDueDate').textContent = row.dataset.dueDate;
            document.getElementById('viewStatus').textContent = row.dataset.status;
            document.getElementById('viewCncNumber').textContent = row.dataset.cncNumber || 'N/A';
            document.getElementById('viewCreatedBy').textContent = 'Admin User';
            document.getElementById('viewDescription').textContent = row.dataset.description;
            document.getElementById('viewActionSolution').textContent = row.dataset.actionSolution;
            
                         // Store current activity data for edit/delete
             window.currentActivityData = {
                 id: row.dataset.activityId,
                 project_id: row.dataset.projectId,
                 information_date: row.dataset.informationDate,
                 user_position: row.dataset.userPosition,
                 department: row.dataset.department,
                 application: row.dataset.application,
                 type: row.dataset.type,
                 status: row.dataset.status,
                 due_date: row.dataset.dueDate,
                 description: row.dataset.description,
                 action_solution: row.dataset.actionSolution,
                 cnc_number: row.dataset.cncNumber
             };
            
            const modal = new bootstrap.Modal(document.getElementById('viewDetailActivityModal'));
            modal.show();
        }
    });
    
    // Edit activity button in detail modal
    document.getElementById('editActivityBtn').addEventListener('click', function() {
        if (window.currentActivityData) {
            // Populate edit form
            document.getElementById('editActivityId').value = window.currentActivityData.id;
            document.getElementById('editProjectId').value = window.currentActivityData.project_id;
            document.getElementById('editInformationDate').value = window.currentActivityData.information_date;
            document.getElementById('editUserPosition').value = window.currentActivityData.user_position;
            document.getElementById('editDepartment').value = window.currentActivityData.department;
                         document.getElementById('editApplication').value = window.currentActivityData.application || '';
            document.getElementById('editType').value = window.currentActivityData.type;
            document.getElementById('editDueDate').value = window.currentActivityData.due_date;
            document.getElementById('editStatus').value = window.currentActivityData.status;
            document.getElementById('editCncNumber').value = window.currentActivityData.cnc_number || '';
            document.getElementById('editDescription').value = window.currentActivityData.description;
            document.getElementById('editActionSolution').value = window.currentActivityData.action_solution;
            
            // Close view modal and open edit modal
            const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewDetailActivityModal'));
            viewModal.hide();
            
            const editModal = new bootstrap.Modal(document.getElementById('editDetailActivityModal'));
            editModal.show();
        }
    });
    
    // Save Detail Activity
    function saveDetailActivity() {
        const form = document.getElementById('addDetailActivityForm');
        
        // Additional validation for required fields
        const typeField = document.getElementById('type');
        const applicationField = document.getElementById('application');
        
        if (!typeField.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Field Required',
                text: 'Please select a Type for the activity.'
            });
            typeField.focus();
            return;
        }
        
        if (!applicationField.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Field Required',
                text: 'Please select an Application for the activity.'
            });
            applicationField.focus();
            return;
        }
        
        if (form.checkValidity()) {
            const formData = new FormData(form);
            formData.append('action', 'create_activity');
            
            // Debug: Log form data
            console.log('Form data being sent:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            fetch('detail_activities_functions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Created!',
                        text: 'Activity created successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to create activity.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error creating activity: ' + error.message
                });
            });
        } else {
            form.reportValidity();
        }
    }
    
    // Update activity button event
    document.getElementById('updateActivityBtn').addEventListener('click', function() {
        const form = document.getElementById('editDetailActivityForm');
        if (form.checkValidity()) {
            const formData = new FormData(form);
            formData.append('action', 'update_activity');
            
            fetch('detail_activities_functions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Activity updated successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Update table row with new data
                    updateTableRow({
                        id: formData.get('id'),
                        project_id: formData.get('project_id'),
                        information_date: formData.get('information_date'),
                        user_position: formData.get('user_position'),
                        department: formData.get('department'),
                        application: formData.get('application'),
                        type: formData.get('type'),
                        status: formData.get('status'),
                        due_date: formData.get('due_date'),
                        description: formData.get('description'),
                        action_solution: formData.get('action_solution'),
                        cnc_number: formData.get('cnc_number')
                    });
                    
                    // Close edit modal
                    const editModal = bootstrap.Modal.getInstance(document.getElementById('editDetailActivityModal'));
                    editModal.hide();
                    
                    // Update current activity data
                    if (window.currentActivityData) {
                        window.currentActivityData = {
                            id: formData.get('id'),
                            project_id: formData.get('project_id'),
                            information_date: formData.get('information_date'),
                            user_position: formData.get('user_position'),
                            department: formData.get('department'),
                            application: formData.get('application'),
                            type: formData.get('type'),
                            status: formData.get('status'),
                            due_date: formData.get('due_date'),
                            description: formData.get('description'),
                            action_solution: formData.get('action_solution'),
                            cnc_number: formData.get('cnc_number')
                        };
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to update activity.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error updating activity.'
                });
            });
        } else {
            form.reportValidity();
        }
    });
    
    // Function to update table row
    function updateTableRow(activityData) {
        const row = document.querySelector(`[data-activity-id="${activityData.id}"]`);
        if (row) {
            // Update visible cells
            row.querySelector('td:nth-child(2)').textContent = activityData.project_id;
            row.querySelector('td:nth-child(3)').textContent = activityData.information_date;
            row.querySelector('td:nth-child(4)').textContent = activityData.user_position;
            row.querySelector('td:nth-child(5)').textContent = activityData.department;
            row.querySelector('td:nth-child(7)').textContent = activityData.type;
            row.querySelector('td:nth-child(8)').innerHTML = `<span class="badge bg-${activityData.status == 'Done' ? 'success' : (activityData.status == 'On Progress' ? 'warning' : (activityData.status == 'Need Requirement' ? 'info' : 'secondary'))}">${activityData.status}</span>`;
            row.querySelector('td:nth-child(9)').textContent = activityData.due_date;
            
            // Update data attributes
            row.dataset.projectId = activityData.project_id;
            row.dataset.informationDate = activityData.information_date;
            row.dataset.userPosition = activityData.user_position;
            row.dataset.department = activityData.department;
            row.dataset.application = activityData.application;
            row.dataset.type = activityData.type;
            row.dataset.status = activityData.status;
            row.dataset.dueDate = activityData.due_date;
            row.dataset.description = activityData.description;
            row.dataset.actionSolution = activityData.action_solution;
            row.dataset.cncNumber = activityData.cnc_number;
        }
    }
    
    // Delete activity button in detail modal
    document.getElementById('deleteActivityBtn').addEventListener('click', function() {
        if (window.currentActivityData) {
            const projectId = window.currentActivityData.project_id;
            const activityId = window.currentActivityData.id;

            Swal.fire({
                title: `Are you sure you want to delete activity ${projectId}?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('action', 'delete_activity');
                    formData.append('id', activityId);
                    
                    fetch('detail_activities_functions.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Activity deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            // Close modal and remove row from table
                            const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewDetailActivityModal'));
                            viewModal.hide();
                            
                            const row = document.querySelector(`[data-activity-id="${activityId}"]`);
                            if (row) row.remove();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message || 'Failed to delete activity.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error deleting activity.'
                        });
                    });
                }
            });
        }
    });
</script>

<?php include './partials/layouts/layoutBottom.php' ?> 