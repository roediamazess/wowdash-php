<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Project Information</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Project Information</li>
                </ul>
            </div>

            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h5 class="card-title mb-0">Project Information Management</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInfoModal">
                                    <iconify-icon icon="akar-icons:plus" class="me-1"></iconify-icon>
                                    Add New Information
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table bordered-table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Code</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Request</td>
                                            <td>Client Request</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editInfoModal" data-code="Request" data-description="Client Request">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteInfoModal" data-code="Request">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Submission</td>
                                            <td>Pengajuan dari Power Pro</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editInfoModal" data-code="Submission" data-description="Pengajuan dari Power Pro">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteInfoModal" data-code="Submission">
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

        <!-- Add Information Modal -->
        <div class="modal fade" id="addInfoModal" tabindex="-1" aria-labelledby="addInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addInfoModalLabel">Add New Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addInfoForm">
                            <div class="mb-3">
                                <label for="infoCode" class="form-label">Code</label>
                                <input type="text" class="form-control" id="infoCode" required>
                            </div>
                            <div class="mb-3">
                                <label for="infoDescription" class="form-label">Description</label>
                                <input type="text" class="form-control" id="infoDescription" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveInfoBtn">Save Information</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Information Modal -->
        <div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editInfoModalLabel">Edit Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editInfoForm">
                            <input type="hidden" id="editInfoCode">
                            <div class="mb-3">
                                <label for="editInfoDescription" class="form-label">Description</label>
                                <input type="text" class="form-control" id="editInfoDescription" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="updateInfoBtn">Close</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Information Modal -->
        <div class="modal fade" id="deleteInfoModal" tabindex="-1" aria-labelledby="deleteInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteInfoModalLabel">Delete Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this information?</p>
                        <input type="hidden" id="deleteInfoCode">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Add event listeners for edit buttons
            document.querySelectorAll('[data-bs-target="#editInfoModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    const description = this.getAttribute('data-description');
                    
                    document.getElementById('editInfoCode').value = code;
                    document.getElementById('editInfoDescription').value = description;
                });
            });

            // Add event listeners for delete buttons
            document.querySelectorAll('[data-bs-target="#deleteInfoModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    document.getElementById('deleteInfoCode').value = code;
                });
            });

            // Save information button event
            document.getElementById('saveInfoBtn').addEventListener('click', function() {
                const code = document.getElementById('infoCode').value;
                const description = document.getElementById('infoDescription').value;
                
                // Here you would typically send the data to the server
                console.log('Saving information:', { code, description });
                
                // Close the modal
                document.getElementById('addInfoModal').querySelector('.btn-close').click();
                
                // Reset form
                document.getElementById('addInfoForm').reset();
                
                // Show success message (in a real app)
                alert('Information saved successfully!');
            });

            // Update information button event
            document.getElementById('updateInfoBtn').addEventListener('click', function() {
                const code = document.getElementById('editInfoCode').value;
                const description = document.getElementById('editInfoDescription').value;
                
                // Here you would typically send the data to the server
                console.log('Updating information:', { code, description });
                
                // Close the modal
                document.getElementById('editInfoModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Information updated successfully!');
            });

            // Delete information button event
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const code = document.getElementById('deleteInfoCode').value;
                
                // Here you would typically send the data to the server
                console.log('Deleting information:', code);
                
                // Close the modal
                document.getElementById('deleteInfoModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Information deleted successfully!');
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
