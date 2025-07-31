<?php include './partials/layouts/layoutTop.php' ?>

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
                                <table class="table bordered-table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">App Code</th>
                                            <th scope="col">App Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="app-row" data-app-code="FO8" data-app-name="Cloud FO">
                                            <td>FO8</td>
                                            <td>Cloud FO</td>
                                        </tr>
                                        <tr>
                                            <td>POS8</td>
                                            <td>Cloud POS</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAppModal" data-code="POS8" data-name="Cloud POS">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAppModal" data-code="POS8">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>AR8</td>
                                            <td>Clout AR</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAppModal" data-code="AR8" data-name="Clout AR">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAppModal" data-code="AR8">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>INV8</td>
                                            <td>Cloud INV</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAppModal" data-code="INV8" data-name="Cloud INV">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAppModal" data-code="INV8">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>AP8</td>
                                            <td>Cloud AP</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAppModal" data-code="AP8" data-name="Cloud AP">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAppModal" data-code="AP8">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>GL8</td>
                                            <td>Cloud GL</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAppModal" data-code="GL8" data-name="Cloud GL">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAppModal" data-code="GL8">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateAppBtn">Update Application</button>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Add event listeners for edit buttons
            document.querySelectorAll('[data-bs-target="#editAppModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const appCode = this.getAttribute('data-code');
                    const name = this.getAttribute('data-name');
                    
                    document.getElementById('editAppCode').value = appCode;
                    document.getElementById('editAppName').value = name;
                });
            });

            // Add event listeners for delete buttons
            document.querySelectorAll('[data-bs-target="#deleteAppModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const appCode = this.getAttribute('data-code');
                    document.getElementById('deleteAppCode').value = appCode;
                });
            });

            // Save application button event
            document.getElementById('saveAppBtn').addEventListener('click', function() {
                const appCode = document.getElementById('appCode').value;
                const name = document.getElementById('appName').value;
                
                // Here you would typically send the data to the server
                console.log('Saving application:', { appCode, name });
                
                // Close the modal
                document.getElementById('addAppModal').querySelector('.btn-close').click();
                
                // Reset form
                document.getElementById('addAppForm').reset();
                
                // Show success message (in a real app)
                alert('Application saved successfully!');
            });

            // Update application button event
            document.getElementById('updateAppBtn').addEventListener('click', function() {
                const appCode = document.getElementById('editAppCode').value;
                const name = document.getElementById('editAppName').value;
                
                // Here you would typically send the data to the server
                console.log('Updating application:', { appCode, name });
                
                // Close the modal
                document.getElementById('editAppModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Application updated successfully!');
            });

            // Delete application button event
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const appCode = document.getElementById('deleteAppCode').value;
                
                // Here you would typically send the data to the server
                console.log('Deleting application:', appCode);
                
                // Close the modal
                document.getElementById('deleteAppModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Application deleted successfully!');
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
