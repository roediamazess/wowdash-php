<?php 
include './partials/layouts/layoutTop.php';
require_once './detail_activity_functions.php';

// Get activities from database
$activities = $detailActivityManager->getAllActivities(20, 0, null);
?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Detail Activity List</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Detail Activity List</li>
                </ul>
            </div>

            <!-- Add New Detail Activity Button -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Detail Activity Management</h6>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDetailActivityModal">
                            <iconify-icon icon="ri-add-line" class="me-2"></iconify-icon>
                            Add New Detail Activity
                        </button>
                    </div>
                </div>
            </div>

            <!-- Detail Activity List -->
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
                            <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search Detail Activity">
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
                    <div class="detail-activity-list">
                        <?php if (empty($activities)): ?>
                        <div class="text-center py-5">
                            <iconify-icon icon="mdi:clipboard-text-outline" class="text-4xl text-secondary mb-3"></iconify-icon>
                            <h6 class="text-secondary">No Detail Activities Found</h6>
                            <p class="text-secondary-light">Start by adding your first detail activity</p>
                        </div>
                        <?php else: ?>
                        <?php foreach ($activities as $activity): ?>
                        <div class="activity-item p-16 border-bottom" data-activity-id="<?php echo $activity['id']; ?>" onclick="viewDetailActivity(<?php echo $activity['id']; ?>)">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="activity-number">
                                        <div class="w-32-px h-32-px bg-primary-600 rounded-circle d-flex align-items-center justify-content-center">
                                            <span class="text-white fw-semibold text-sm"><?php echo substr($activity['activity_number'], 3); ?></span>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold"><?php echo htmlspecialchars($activity['user_position']); ?></h6>
                                        <p class="mb-1 text-secondary-light"><?php echo htmlspecialchars($activity['department']); ?> • <?php echo htmlspecialchars($activity['application']); ?></p>
                                        <p class="mb-0 text-secondary-light text-sm"><?php echo htmlspecialchars(substr($activity['description'], 0, 80)) . (strlen($activity['description']) > 80 ? '...' : ''); ?></p>
                                        <small class="text-secondary-light">Project ID: <?php echo htmlspecialchars($activity['project_id']); ?> • Created by: <?php echo htmlspecialchars($activity['creator_name']); ?></small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="mb-2">
                                        <?php
                                        $statusClass = '';
                                        switch($activity['status']) {
                                            case 'Open': $statusClass = 'bg-primary-focus text-primary-main'; break;
                                            case 'On Progress': $statusClass = 'bg-warning-focus text-warning-main'; break;
                                            case 'Need Requirement': $statusClass = 'bg-info-focus text-info-main'; break;
                                            case 'Done': $statusClass = 'bg-success-focus text-success-main'; break;
                                            default: $statusClass = 'bg-secondary-focus text-secondary-main';
                                        }
                                        ?>
                                        <span class="<?php echo $statusClass; ?> px-24 py-4 rounded-pill fw-medium text-sm"><?php echo htmlspecialchars($activity['status']); ?></span>
                                    </div>
                                    <div class="text-secondary-light text-sm">
                                        <div>Info: <?php echo date('d M Y', strtotime($activity['information_date'])); ?></div>
                                        <div>Due: <?php echo date('d M Y', strtotime($activity['due_date'])); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Detail Activity Modal -->
        <div class="modal fade" id="addDetailActivityModal" tabindex="-1" aria-labelledby="addDetailActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDetailActivityModalLabel">Add New Detail Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="detailActivityForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="projectId" class="form-label">Project ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="projectId" name="project_id" placeholder="e.g., PRJ-001" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="informationDate" class="form-label">Information Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="informationDate" name="information_date" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="userPosition" class="form-label">User & Position <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="userPosition" name="user_position" placeholder="e.g., John Doe - Manager" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                                    <select class="form-select" id="department" name="department" required>
                                        <option value="">Select Department</option>
                                        <?php 
                                        $departments = $detailActivityManager->getDepartments();
                                        foreach ($departments as $dept): 
                                        ?>
                                        <option value="<?php echo htmlspecialchars($dept['name']); ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="application" class="form-label">Application <span class="text-danger">*</span></label>
                                    <select class="form-select" id="application" name="application" required>
                                        <option value="">Select Application</option>
                                        <?php 
                                        $applications = $detailActivityManager->getApplications();
                                        foreach ($applications as $app): 
                                        ?>
                                        <option value="<?php echo htmlspecialchars($app['name']); ?>"><?php echo htmlspecialchars($app['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <?php 
                                        $types = $detailActivityManager->getActivityTypes();
                                        foreach ($types as $type): 
                                        ?>
                                        <option value="<?php echo htmlspecialchars($type['name']); ?>"><?php echo htmlspecialchars($type['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="dueDate" class="form-label">Due Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dueDate" name="due_date" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <?php 
                                        $statuses = $detailActivityManager->getStatusOptions();
                                        foreach ($statuses as $status): 
                                        ?>
                                        <option value="<?php echo htmlspecialchars($status['name']); ?>"><?php echo htmlspecialchars($status['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cncNumber" class="form-label">CNC Number</label>
                                    <input type="text" class="form-control" id="cncNumber" name="cnc_number" placeholder="Enter CNC Number">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="createdBy" class="form-label">Created By <span class="text-danger">*</span></label>
                                    <select class="form-select" id="createdBy" name="created_by" required>
                                        <option value="">Select User</option>
                                        <?php 
                                        $users = $detailActivityManager->getUsers();
                                        foreach ($users as $user): 
                                        ?>
                                        <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter detailed description..." required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="actionSolution" class="form-label">Action / Solution <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="actionSolution" name="action_solution" rows="4" placeholder="Enter action or solution..." required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveDetailActivity()">Save Detail Activity</button>
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
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success" onclick="editDetailActivity()">Edit</button>
                            <button type="button" class="btn btn-danger" onclick="deleteDetailActivity()">Delete</button>
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
            // View Detail Activity
            function viewDetailActivity(id) {
                // Fetch activity data from database
                fetch('detail_activity_functions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=get_activity&id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        const activity = data.data;
                        
                        document.getElementById('viewProjectId').textContent = activity.project_id;
                        document.getElementById('viewInformationDate').textContent = activity.information_date;
                        document.getElementById('viewUserPosition').textContent = activity.user_position;
                        document.getElementById('viewDepartment').textContent = activity.department;
                        document.getElementById('viewApplication').textContent = activity.application;
                        document.getElementById('viewType').textContent = activity.type;
                        document.getElementById('viewDueDate').textContent = activity.due_date;
                        document.getElementById('viewStatus').textContent = activity.status;
                        document.getElementById('viewCncNumber').textContent = activity.cnc_number || 'N/A';
                        document.getElementById('viewCreatedBy').textContent = activity.creator_name;
                        document.getElementById('viewDescription').textContent = activity.description;
                        document.getElementById('viewActionSolution').textContent = activity.action_solution;
                        
                        // Store current activity ID for edit/delete
                        window.currentActivityId = id;
                        
                        const modal = new bootstrap.Modal(document.getElementById('viewDetailActivityModal'));
                        modal.show();
                    } else {
                        alert('Failed to load activity details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading activity details');
                });
            }
            
            // Edit Detail Activity
            function editDetailActivity() {
                if (window.currentActivityId) {
                    // Implementation for edit functionality
                    alert('Edit functionality for Detail Activity ID: ' + window.currentActivityId);
                }
            }
            
            // Delete Detail Activity
            function deleteDetailActivity() {
                if (window.currentActivityId) {
                    if (confirm('Are you sure you want to delete this Detail Activity?')) {
                        // Delete from database
                        fetch('detail_activity_functions.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `action=delete_activity&id=${window.currentActivityId}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Activity deleted successfully!');
                                const modal = bootstrap.Modal.getInstance(document.getElementById('viewDetailActivityModal'));
                                modal.hide();
                                // Reload page to refresh list
                                location.reload();
                            } else {
                                alert('Failed to delete activity: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting activity');
                        });
                    }
                }
            }
            
            // Save Detail Activity
            function saveDetailActivity() {
                const form = document.getElementById('detailActivityForm');
                if (form.checkValidity()) {
                    const formData = new FormData(form);
                    formData.append('action', 'create_activity');
                    
                    fetch('detail_activity_functions.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Detail Activity saved successfully!');
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addDetailActivityModal'));
                            modal.hide();
                            form.reset();
                            // Reload page to refresh list
                            location.reload();
                        } else {
                            alert('Failed to save activity: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error saving activity');
                    });
                } else {
                    form.reportValidity();
                }
            }
        </script>

<?php include './partials/layouts/layoutBottom.php' ?> 