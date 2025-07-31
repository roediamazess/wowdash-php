<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Roles & Access</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Roles & Access</li>
                </ul>
            </div>

            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h5 class="card-title mb-0">Roles Management</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                                    <iconify-icon icon="akar-icons:plus" class="me-1"></iconify-icon>
                                    Add New Role
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table bordered-table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Roles ID</th>
                                            <th scope="col">Roles Name</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Administrator</td>
                                            <td>Me</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-id="Administrator" data-name="Me">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" data-id="Administrator">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Supervisor</td>
                                            <td>Manager</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-id="Supervisor" data-name="Manager">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" data-id="Supervisor">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Admin Officer</td>
                                            <td>Iam</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-id="Admin Officer" data-name="Iam">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" data-id="Admin Officer">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>User</td>
                                            <td>Team</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-id="User" data-name="Team">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" data-id="User">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Client</td>
                                            <td>Hotel</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-id="Client" data-name="Hotel">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" data-id="Client">
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

        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addRoleForm">
                            <div class="mb-3">
                                <label for="roleId" class="form-label">Roles ID</label>
                                <input type="text" class="form-control" id="roleId" required>
                            </div>
                            <div class="mb-3">
                                <label for="roleName" class="form-label">Roles Name</label>
                                <input type="text" class="form-control" id="roleName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveRoleBtn">Save Role</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Role Modal -->
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editRoleForm">
                            <input type="hidden" id="editRoleId">
                            <div class="mb-3">
                                <label for="editRoleName" class="form-label">Roles Name</label>
                                <input type="text" class="form-control" id="editRoleName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateRoleBtn">Update Role</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Role Modal -->
        <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteRoleModalLabel">Delete Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this role?</p>
                        <input type="hidden" id="deleteRoleId">
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
            document.querySelectorAll('[data-bs-target="#editRoleModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-id');
                    const roleName = this.getAttribute('data-name');
                    
                    document.getElementById('editRoleId').value = roleId;
                    document.getElementById('editRoleName').value = roleName;
                });
            });

            // Add event listeners for delete buttons
            document.querySelectorAll('[data-bs-target="#deleteRoleModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-id');
                    document.getElementById('deleteRoleId').value = roleId;
                });
            });

            // Save role button event
            document.getElementById('saveRoleBtn').addEventListener('click', function() {
                const roleId = document.getElementById('roleId').value;
                const roleName = document.getElementById('roleName').value;
                
                // Here you would typically send the data to the server
                console.log('Saving role:', { roleId, roleName });
                
                // Close the modal
                document.getElementById('addRoleModal').querySelector('.btn-close').click();
                
                // Reset form
                document.getElementById('addRoleForm').reset();
                
                // Show success message (in a real app)
                alert('Role saved successfully!');
            });

            // Update role button event
            document.getElementById('updateRoleBtn').addEventListener('click', function() {
                const roleId = document.getElementById('editRoleId').value;
                const roleName = document.getElementById('editRoleName').value;
                
                // Here you would typically send the data to the server
                console.log('Updating role:', { roleId, roleName });
                
                // Close the modal
                document.getElementById('editRoleModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Role updated successfully!');
            });

            // Delete role button event
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const roleId = document.getElementById('deleteRoleId').value;
                
                // Here you would typically send the data to the server
                console.log('Deleting role:', roleId);
                
                // Close the modal
                document.getElementById('deleteRoleModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Role deleted successfully!');
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
