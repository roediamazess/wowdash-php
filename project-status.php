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
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Scheduled</td>
                                            <td>Jadwal yang telah diagendakan</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStatusModal" data-id="Scheduled" data-description="Jadwal yang telah diagendakan">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStatusModal" data-id="Scheduled">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Running</td>
                                            <td>Projek sedang berjalan</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStatusModal" data-id="Running" data-description="Projek sedang berjalan">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStatusModal" data-id="Running">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Document</td>
                                            <td>Projek selesai, namun team belum menyerahkan Berita Acara</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStatusModal" data-id="Document" data-description="Projek selesai, namun team belum menyerahkan Berita Acara">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStatusModal" data-id="Document">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Document Check</td>
                                            <td>Projek selesai, team sudah menyerahkan Berita Acara, belum dicek</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStatusModal" data-id="Document Check" data-description="Projek selesai, team sudah menyerahkan Berita Acara, belum dicek">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStatusModal" data-id="Document Check">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Done</td>
                                            <td>Projek selesai, Berita Acara sudah diserahkan dan sudah dilakukan pengecekan</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStatusModal" data-id="Done" data-description="Projek selesai, Berita Acara sudah diserahkan dan sudah dilakukan pengecekan">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStatusModal" data-id="Done">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Cancel</td>
                                            <td>Projek dibatalkan</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStatusModal" data-id="Cancel" data-description="Projek dibatalkan">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStatusModal" data-id="Cancel">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Rejected</td>
                                            <td>Pengajuan Projek, namun ditolak oleh pihak hotel</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStatusModal" data-id="Rejected" data-description="Pengajuan Projek, namun ditolak oleh pihak hotel">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStatusModal" data-id="Rejected">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateStatusBtn">Update Status</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Status Modal -->
        <div class="modal fade" id="deleteStatusModal" tabindex="-1" aria-labelledby="deleteStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteStatusModalLabel">Delete Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this status?</p>
                        <input type="hidden" id="deleteStatusId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Add event listeners for edit buttons
            document.querySelectorAll('[data-bs-target="#editStatusModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const statusId = this.getAttribute('data-id');
                    const description = this.getAttribute('data-description');
                    
                    document.getElementById('editStatusId').value = statusId;
                    document.getElementById('editStatusDescription').value = description;
                });
            });

            // Add event listeners for delete buttons
            document.querySelectorAll('[data-bs-target="#deleteStatusModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const statusId = this.getAttribute('data-id');
                    document.getElementById('deleteStatusId').value = statusId;
                });
            });

            // Save status button event
            document.getElementById('saveStatusBtn').addEventListener('click', function() {
                const statusId = document.getElementById('statusId').value;
                const description = document.getElementById('statusDescription').value;
                
                // Here you would typically send the data to the server
                console.log('Saving status:', { statusId, description });
                
                // Close the modal
                document.getElementById('addStatusModal').querySelector('.btn-close').click();
                
                // Reset form
                document.getElementById('addStatusForm').reset();
                
                // Show success message (in a real app)
                alert('Status saved successfully!');
            });

            // Update status button event
            document.getElementById('updateStatusBtn').addEventListener('click', function() {
                const statusId = document.getElementById('editStatusId').value;
                const description = document.getElementById('editStatusDescription').value;
                
                // Here you would typically send the data to the server
                console.log('Updating status:', { statusId, description });
                
                // Close the modal
                document.getElementById('editStatusModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Status updated successfully!');
            });

            // Delete status button event
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const statusId = document.getElementById('deleteStatusId').value;
                
                // Here you would typically send the data to the server
                console.log('Deleting status:', statusId);
                
                // Close the modal
                document.getElementById('deleteStatusModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Status deleted successfully!');
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
