<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Project Status</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Project Status</li>
                </ul>
            </div>

            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h5 class="card-title mb-0">Project Status Management</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStatusModal">
                                    <iconify-icon icon="akar-icons:plus" class="me-1"></iconify-icon>
                                    Add New Status
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table bordered-table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Status ID</th>
                                            <th scope="col">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="status-row" data-status-id="Scheduled" data-description="Jadwal yang telah diagendakan">
                                            <td>Scheduled</td>
                                            <td>Jadwal yang telah diagendakan</td>
                                        </tr>
                                        <tr class="status-row" data-status-id="Running" data-description="Projek sedang berjalan">
                                            <td>Running</td>
                                            <td>Projek sedang berjalan</td>
                                        </tr>
                                        <tr class="status-row" data-status-id="Document" data-description="Projek selesai, namun team belum menyerahkan Berita Acara">
                                            <td>Document</td>
                                            <td>Projek selesai, namun team belum menyerahkan Berita Acara</td>
                                        </tr>
                                        <tr class="status-row" data-status-id="Document Check" data-description="Projek selesai, team sudah menyerahkan Berita Acara, belum dicek">
                                            <td>Document Check</td>
                                            <td>Projek selesai, team sudah menyerahkan Berita Acara, belum dicek</td>
                                        </tr>
                                        <tr class="status-row" data-status-id="Done" data-description="Projek selesai, Berita Acara sudah diserahkan dan sudah dilakukan pengecekan">
                                            <td>Done</td>
                                            <td>Projek selesai, Berita Acara sudah diserahkan dan sudah dilakukan pengecekan</td>
                                        </tr>
                                        <tr class="status-row" data-status-id="Cancel" data-description="Projek dibatalkan">
                                            <td>Cancel</td>
                                            <td>Projek dibatalkan</td>
                                        </tr>
                                        <tr class="status-row" data-status-id="Rejected" data-description="Pengajuan Projek, namun ditolak oleh pihak hotel">
                                            <td>Rejected</td>
                                            <td>Pengajuan Projek, namun ditolak oleh pihak hotel</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Status Modal -->
        <div class="modal fade" id="addStatusModal" tabindex="-1" aria-labelledby="addStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStatusModalLabel">Add New Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addStatusForm">
                            <div class="mb-3">
                                <label for="statusId" class="form-label">Status ID</label>
                                <input type="text" class="form-control" id="statusId" required>
                            </div>
                            <div class="mb-3">
                                <label for="statusDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="statusDescription" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveStatusBtn">Save Status</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Detail Modal -->
        <div class="modal fade" id="statusDetailModal" tabindex="-1" aria-labelledby="statusDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusDetailModalLabel">Status Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Status ID</label>
                                    <p class="mb-0" id="detailStatusId"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Description</label>
                                    <p class="mb-0" id="detailStatusDescription"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="editStatusBtn">Edit</button>
                        <button type="button" class="btn btn-danger" id="deleteStatusBtn">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Status Modal -->
        <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStatusModalLabel">Edit Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editStatusForm">
                            <input type="hidden" id="editStatusId">
                            <div class="mb-3">
                                <label for="editStatusDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editStatusDescription" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="updateStatusBtn">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Hover effects for status rows */
            .status-row {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            
            .status-row:hover {
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
            .modal-lg {
                max-width: 800px;
            }
            
            .form-label.fw-semibold {
                color: #6c757d;
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const addStatusModal = new bootstrap.Modal(document.getElementById('addStatusModal'));
                const statusDetailModal = new bootstrap.Modal(document.getElementById('statusDetailModal'));
                const editStatusModal = new bootstrap.Modal(document.getElementById('editStatusModal'));

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

                // Row click event to show status details
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.status-row')) {
                        const row = e.target.closest('.status-row');
                        
                        // Populate detail modal
                        document.getElementById('detailStatusId').textContent = row.dataset.statusId;
                        document.getElementById('detailStatusDescription').textContent = row.dataset.description;
                        
                        // Store current status data for edit/delete
                        window.currentStatusData = {
                            statusId: row.dataset.statusId,
                            description: row.dataset.description
                        };
                        
                        statusDetailModal.show();
                    }
                });

                // Edit status button in detail modal
                document.getElementById('editStatusBtn').addEventListener('click', function() {
                    if (window.currentStatusData) {
                        document.getElementById('editStatusId').value = window.currentStatusData.statusId;
                        document.getElementById('editStatusDescription').value = window.currentStatusData.description;
                        
                        statusDetailModal.hide();
                        editStatusModal.show();
                    }
                });

                // Delete status button in detail modal
                document.getElementById('deleteStatusBtn').addEventListener('click', function() {
                    if (window.currentStatusData) {
                        const statusId = window.currentStatusData.statusId;

                        Swal.fire({
                            title: `Are you sure you want to delete status "${statusId}"?`,
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Here you would typically send the data to the server
                                console.log('Deleting status:', statusId);
                                
                                showToast('Status deleted successfully!');
                                statusDetailModal.hide();
                                
                                // Remove the row from table
                                const row = document.querySelector(`[data-status-id="${statusId}"]`);
                                if (row) row.remove();
                            }
                        });
                    }
                });

                // Save status button event
                document.getElementById('saveStatusBtn').addEventListener('click', function() {
                    const statusId = document.getElementById('statusId').value;
                    const description = document.getElementById('statusDescription').value;
                    
                    // Here you would typically send the data to the server
                    console.log('Saving status:', { statusId, description });
                    
                    showToast('Status saved successfully!');
                    addStatusModal.hide();
                    document.getElementById('addStatusForm').reset();
                });

                // Update status button event
                document.getElementById('updateStatusBtn').addEventListener('click', function() {
                    const statusId = document.getElementById('editStatusId').value;
                    const description = document.getElementById('editStatusDescription').value;
                    
                    // Here you would typically send the data to the server
                    console.log('Updating status:', { statusId, description });
                    
                    showToast('Status updated successfully!');
                    editStatusModal.hide();
                    
                    // Update the row in table
                    const row = document.querySelector(`[data-status-id="${statusId}"]`);
                    if (row) {
                        row.dataset.description = description;
                        row.querySelector('td:last-child').textContent = description;
                    }
                });
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
