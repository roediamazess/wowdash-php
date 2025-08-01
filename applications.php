<?php 
include './partials/layouts/layoutTop.php';
include_once './applications_functions.php';

// Get applications data
$manager = new ApplicationsManager($conn);
$applications = $manager->getAllApplications();
?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Applications</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Applications</li>
                </ul>
            </div>

            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h5 class="card-title mb-0">Applications Management</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppModal">
                                    <iconify-icon icon="akar-icons:plus" class="me-1"></iconify-icon>
                                    Add New Application
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table bordered-table mb-0" id="applicationsTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">App Code</th>
                                            <th scope="col">App Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($applications as $app): ?>
                                        <tr class="app-row" data-app-id="<?= $app['id'] ?>" data-app-code="<?= $app['app_code'] ?>" data-app-name="<?= htmlspecialchars($app['app_name']) ?>">
                                            <td><?= $app['app_code'] ?></td>
                                            <td><?= htmlspecialchars($app['app_name']) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Application Modal -->
        <div class="modal fade" id="addAppModal" tabindex="-1" aria-labelledby="addAppModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAppModalLabel">Add New Application</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addAppForm">
                            <div class="mb-3">
                                <label for="appCode" class="form-label">App Code</label>
                                <input type="text" class="form-control" id="appCode" required>
                            </div>
                            <div class="mb-3">
                                <label for="appName" class="form-label">App Name</label>
                                <input type="text" class="form-control" id="appName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveAppBtn">Save Application</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Application Modal -->
        <div class="modal fade" id="editAppModal" tabindex="-1" aria-labelledby="editAppModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAppModalLabel">Edit Application</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editAppForm">
                            <input type="hidden" id="editAppCode">
                            <div class="mb-3">
                                <label for="editAppName" class="form-label">App Name</label>
                                <input type="text" class="form-control" id="editAppName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="updateAppBtn">Close</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Application Modal -->
        <div class="modal fade" id="deleteAppModal" tabindex="-1" aria-labelledby="deleteAppModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAppModalLabel">Delete Application</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this application?</p>
                        <input type="hidden" id="deleteAppCode">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Hover effects for application rows */
            .app-row {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            
            .app-row:hover {
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
        </style>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const addAppModal = new bootstrap.Modal(document.getElementById('addAppModal'));
                const editAppModal = new bootstrap.Modal(document.getElementById('editAppModal'));
                const deleteAppModal = new bootstrap.Modal(document.getElementById('deleteAppModal'));

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

                // Row click event to show application details
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.app-row')) {
                        const row = e.target.closest('.app-row');
                        
                        // Store current app data for edit/delete
                        window.currentAppData = {
                            id: row.dataset.appId,
                            appCode: row.dataset.appCode,
                            appName: row.dataset.appName
                        };
                        
                        // Show edit modal directly
                        document.getElementById('editAppCode').value = row.dataset.appCode;
                        document.getElementById('editAppName').value = row.dataset.appName;
                        editAppModal.show();
                    }
                });

                // Save application button event
                document.getElementById('saveAppBtn').addEventListener('click', function() {
                    const appCode = document.getElementById('appCode').value;
                    const appName = document.getElementById('appName').value;
                    
                    if (!appCode || !appName) {
                        showToast('Please fill in all fields', 'error');
                        return;
                    }
                    
                    const formData = new FormData();
                    formData.append('action', 'create_application');
                    formData.append('app_code', appCode);
                    formData.append('app_name', appName);
                    
                    fetch('applications_functions.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message);
                            addAppModal.hide();
                            document.getElementById('addAppForm').reset();
                            location.reload(); // Refresh to show new data
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showToast('Error saving application', 'error');
                    });
                });

                // Update application button event
                document.getElementById('updateAppBtn').addEventListener('click', function() {
                    if (!window.currentAppData) {
                        showToast('No application selected', 'error');
                        return;
                    }
                    
                    const appCode = document.getElementById('editAppCode').value;
                    const appName = document.getElementById('editAppName').value;
                    
                    if (!appCode || !appName) {
                        showToast('Please fill in all fields', 'error');
                        return;
                    }
                    
                    const formData = new FormData();
                    formData.append('action', 'update_application');
                    formData.append('id', window.currentAppData.id);
                    formData.append('app_code', appCode);
                    formData.append('app_name', appName);
                    
                    fetch('applications_functions.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message);
                            editAppModal.hide();
                            location.reload(); // Refresh to show updated data
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showToast('Error updating application', 'error');
                    });
                });

                // Delete application button event
                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    if (!window.currentAppData) {
                        showToast('No application selected', 'error');
                        return;
                    }
                    
                    Swal.fire({
                        title: `Are you sure you want to delete "${window.currentAppData.appName}"?`,
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const formData = new FormData();
                            formData.append('action', 'delete_application');
                            formData.append('id', window.currentAppData.id);
                            
                            fetch('applications_functions.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showToast(data.message);
                                    deleteAppModal.hide();
                                    location.reload(); // Refresh to show updated data
                                } else {
                                    showToast(data.message, 'error');
                                }
                            })
                            .catch(error => {
                                showToast('Error deleting application', 'error');
                            });
                        }
                    });
                });
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
