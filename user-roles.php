<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">User Roles Management</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Settings</li>
                    <li>-</li>
                    <li class="fw-medium">User Roles</li>
                </ul>
            </div>

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                        <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <form class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search roles...">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </form>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addRoleModal" id="addBtn">
                            <iconify-icon icon="ri-add-line" class="icon text-xl line-height-1"></iconify-icon>
                        Add New Role
                        </button>
                        <button id="edit-role-btn" class="btn btn-warning text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" disabled>
                            <iconify-icon icon="ri-pencil-line" class="icon text-xl line-height-1"></iconify-icon> 
                            Edit Role
                        </button>
                        <button id="delete-role-btn" class="btn btn-danger text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" disabled>
                            <iconify-icon icon="ri-delete-bin-line" class="icon text-xl line-height-1"></iconify-icon> 
                            Delete Role
                        </button>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border input-form-dark" type="checkbox" id="selectAll">
                                            </div>
                                            Role ID
                                        </div>
                                    </th>
                                    <th scope="col">Role Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
include_once __DIR__ . '/partials/db_connection.php';

// Create user_roles table if not exists
$createTableSQL = "CREATE TABLE IF NOT EXISTS user_roles (
    role_id VARCHAR(50) PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($createTableSQL) === TRUE) {
    // Check if table is empty and insert default data
    $checkSQL = "SELECT COUNT(*) as count FROM user_roles";
    $result = $conn->query($checkSQL);
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        // Insert default user roles
        $defaultRoles = array(
            array("role_id" => "Administrator", "role_name" => "Me", "description" => "Full system access"),
            array("role_id" => "Supervisor", "role_name" => "Manager", "description" => "Management level access"),
            array("role_id" => "Admin Officer", "role_name" => "Iam", "description" => "Administrative access"),
            array("role_id" => "User", "role_name" => "Team", "description" => "Standard user access"),
            array("role_id" => "Client", "role_name" => "Hotel", "description" => "Client access")
        );
        
        foreach ($defaultRoles as $role) {
            $insertSQL = "INSERT INTO user_roles (role_id, role_name, description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertSQL);
            $stmt->bind_param("sss", $role['role_id'], $role['role_name'], $role['description']);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Fetch and display user roles
$sql = "SELECT role_id, role_name, description, created_at FROM user_roles ORDER BY role_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr id="role-row-' . htmlspecialchars($row["role_id"]) . '" 
            data-role-id="' . htmlspecialchars($row["role_id"]) . '" 
            data-role-name="' . htmlspecialchars($row["role_name"]) . '" 
            data-description="' . htmlspecialchars($row["description"]) . '">';
        echo '<td>';
        echo '<div class="d-flex align-items-center gap-10">';
        echo '<div class="form-check style-check d-flex align-items-center">';
        echo '<input class="form-check-input role-checkbox radius-4 border border-neutral-400" type="checkbox" value="' . htmlspecialchars($row["role_id"]) . '">';
        echo '</div>';
        echo '<span class="role-id">' . htmlspecialchars($row["role_id"]) . '</span>';
        echo '</div>';
        echo '</td>';
        echo '<td class="role-name">' . htmlspecialchars($row["role_name"]) . '</td>';
        echo '<td class="description">' . htmlspecialchars($row["description"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["created_at"]) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4" class="text-center">No roles found.</td></tr>';
}
?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                        <span>Showing 1 to 5 of 5 entries</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <li class="page-item">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="javascript:void(0)">
                                    <iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md bg-primary-600 text-white" href="javascript:void(0)">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="javascript:void(0)">
                                    <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon>
                                </a>
                            </li>
                        </ul>
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
                                <label for="addRoleId" class="form-label">Role ID</label>
                                <input type="text" class="form-control" id="addRoleId" required>
                            </div>
                            <div class="mb-3">
                                <label for="addRoleName" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="addRoleName" required>
                            </div>
                            <div class="mb-3">
                                <label for="addDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="addDescription" rows="3"></textarea>
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
                            <div class="mb-3">
                                <label for="editRoleId" class="form-label">Role ID</label>
                                <input type="text" class="form-control" id="editRoleId" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="editRoleName" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="editRoleName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editDescription" rows="3"></textarea>
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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const addRoleModal = new bootstrap.Modal(document.getElementById('addRoleModal'));
                const editRoleModal = new bootstrap.Modal(document.getElementById('editRoleModal'));
                const editBtn = document.getElementById('edit-role-btn');
                const deleteBtn = document.getElementById('delete-role-btn');
                const selectAllCheckbox = document.getElementById('selectAll');
                const roleCheckboxes = document.querySelectorAll('.role-checkbox');

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

                // Save role button event
                document.getElementById('saveRoleBtn').addEventListener('click', async function() {
                    const roleData = {
                        roleId: document.getElementById('addRoleId').value,
                        roleName: document.getElementById('addRoleName').value,
                        description: document.getElementById('addDescription').value
                    };

                    // Simple validation
                    if (!roleData.roleId || !roleData.roleName) {
                        showToast('Please fill in all required fields.', 'error');
                        return;
                    }

                    // For now, just show success message
                    showToast('Role added successfully!');
                    addRoleModal.hide();
                    document.getElementById('addRoleForm').reset();
                    location.reload();
                });

                // Update role button event
                document.getElementById('updateRoleBtn').addEventListener('click', async function() {
                    const roleData = {
                        roleId: document.getElementById('editRoleId').value,
                        roleName: document.getElementById('editRoleName').value,
                        description: document.getElementById('editDescription').value
                    };

                    // Simple validation
                    if (!roleData.roleId || !roleData.roleName) {
                        showToast('Please fill in all required fields.', 'error');
                        return;
                    }

                    // For now, just show success message
                    showToast('Role updated successfully!');
                    editRoleModal.hide();
                    location.reload();
                });

                // Delete selected roles
                deleteBtn.addEventListener('click', function() {
                    const selectedCheckboxes = document.querySelectorAll('.role-checkbox:checked');
                    const roleIds = Array.from(selectedCheckboxes).map(cb => cb.value);

                    if (roleIds.length > 0) {
                        Swal.fire({
                            title: `Are you sure you want to delete ${roleIds.length} role(s)?`,
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete them!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                showToast(`${roleIds.length} role(s) deleted successfully.`);
                                roleIds.forEach(roleId => {
                                    const row = document.getElementById(`role-row-${roleId}`);
                                    if (row) row.remove();
                                });
                                selectAllCheckbox.checked = false;
                                updateButtonStates();
                            }
                        });
                    }
                });

                // Edit selected role
                editBtn.addEventListener('click', function() {
                    const selectedCheckbox = document.querySelector('.role-checkbox:checked');
                    if (selectedCheckbox) {
                        const row = selectedCheckbox.closest('tr');
                        document.getElementById('editRoleId').value = row.dataset.roleId;
                        document.getElementById('editRoleName').value = row.dataset.roleName;
                        document.getElementById('editDescription').value = row.dataset.description;
                        editRoleModal.show();
                    }
                });

                function updateButtonStates() {
                    const selectedCount = document.querySelectorAll('.role-checkbox:checked').length;
                    editBtn.disabled = selectedCount !== 1;
                    deleteBtn.disabled = selectedCount === 0;
                }

                selectAllCheckbox.addEventListener('change', function() {
                    roleCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateButtonStates();
                });

                roleCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateButtonStates);
                });

                // Initial state
                updateButtonStates();
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?> 