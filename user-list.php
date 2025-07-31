<?php 
// Include tier data functions
include_once __DIR__ . '/partials/get_tiers.php';
?>

<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Users List</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Users List</li>
                </ul>
            </div>

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                        <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                        </select>
                        <form class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </form>
                        <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                            <option>Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addUserModal" id="addBtn">
                            <iconify-icon icon="ri-add-line" class="icon text-xl line-height-1"></iconify-icon>
                        Add New User
                        </button>
                        <button id="edit-user-btn" class="btn btn-warning text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" disabled>
                            <iconify-icon icon="ri-pencil-line" class="icon text-xl line-height-1"></iconify-icon> 
                            Edit User
                        </button>
                        <button id="delete-user-btn" class="btn btn-danger text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" disabled>
                            <iconify-icon icon="ri-delete-bin-line" class="icon text-xl line-height-1"></iconify-icon> 
                            Delete User
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
                                            User ID
                                        </div>
                                    </th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">User Tier</th>
                                    <th scope="col">Start Work</th>
                                    <th scope="col">User Roles</th>
                                    <th scope="col">User Email</th>
                                    <th scope="col">Birthday</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
include_once __DIR__ . '/partials/db_connection.php';
$sql = "SELECT user_id, user_name, user_tier, start_work, user_role, user_email, birthday FROM users";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr id="user-row-' . htmlspecialchars($row["user_id"]) . '" 
            data-user-id="' . htmlspecialchars($row["user_id"]) . '" 
            data-user-name="' . htmlspecialchars($row["user_name"]) . '" 
            data-user-tier="' . htmlspecialchars($row["user_tier"]) . '" 
            data-start-work="' . htmlspecialchars($row["start_work"]) . '" 
            data-user-role="' . htmlspecialchars($row["user_role"]) . '" 
            data-user-email="' . htmlspecialchars($row["user_email"]) . '" 
            data-birthday="' . htmlspecialchars($row["birthday"]) . '">';
        echo '<td>';
        echo '<div class="d-flex align-items-center gap-10">';
        echo '<div class="form-check style-check d-flex align-items-center">';
        echo '<input class="form-check-input user-checkbox radius-4 border border-neutral-400" type="checkbox" value="' . htmlspecialchars($row["user_id"]) . '">';
        echo '</div>';
        echo '<span class="user-id">' . htmlspecialchars($row["user_id"]) . '</span>';
        echo '</div>';
        echo '</td>';
        echo '<td class="user-name">' . htmlspecialchars($row["user_name"]) . '</td>';
        echo '<td class="user-tier">' . htmlspecialchars($row["user_tier"]) . '</td>';
        echo '<td class="start-work">' . htmlspecialchars($row["start_work"]) . '</td>';
        echo '<td class="user-role">' . htmlspecialchars($row["user_role"]) . '</td>';
        echo '<td class="user-email">' . htmlspecialchars($row["user_email"]) . '</td>';
        echo '<td class="birthday">' . htmlspecialchars($row["birthday"]) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="8" class="text-center">No users found.</td></tr>';
}
?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                        <span>Showing 1 to 6 of 6 entries</span>
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

        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm">
                            <div class="mb-3">
                                <label for="userName" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="userName" required>
                            </div>
                            <div class="mb-3">
                                <label for="userTier" class="form-label">User Tier</label>
                                <select class="form-control" id="userTier">
                                    <?php echo generateTierOptions(); ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="startWork" class="form-label">Start Work</label>
                                <input type="date" class="form-control" id="startWork" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="mb-3">
                                <label for="userRole" class="form-label">User Roles</label>
                                <select class="form-control" id="userRole">
                                    <option value="">Select Role</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Admin Officer">Admin Officer</option>
                                    <option value="User">User</option>
                                    <option value="Client">Client</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">User Email</label>
                                <input type="email" class="form-control" id="userEmail">
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" class="form-control" id="birthday" placeholder="YYYY-MM-DD">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveUserBtn">Save User</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editUserForm">
                            <input type="hidden" id="editUserId">
                            <div class="mb-3">
                                <label for="editUserName" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="editUserName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUserTier" class="form-label">User Tier</label>
                                <select class="form-control" id="editUserTier">
                                    <?php echo generateTierOptions(); ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editStartWork" class="form-label">Start Work</label>
                                <input type="date" class="form-control" id="editStartWork" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="mb-3">
                                <label for="editUserRole" class="form-label">User Roles</label>
                                <select class="form-control" id="editUserRole">
                                    <option value="">Select Role</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Admin Officer">Admin Officer</option>
                                    <option value="User">User</option>
                                    <option value="Client">Client</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editUserEmail" class="form-label">User Email</label>
                                <input type="email" class="form-control" id="editUserEmail">
                            </div>
                            <div class="mb-3">
                                <label for="editBirthday" class="form-label">Birthday</label>
                                <input type="date" class="form-control" id="editBirthday" placeholder="YYYY-MM-DD">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateUserBtn">Update User</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- View User Modal -->
        <!-- Removed View User Modal as per user request -->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
                const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                const editBtn = document.getElementById('edit-user-btn');
                const deleteBtn = document.getElementById('delete-user-btn');
                const selectAllCheckbox = document.getElementById('selectAll');
                const userCheckboxes = document.querySelectorAll('.user-checkbox');

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

                const apiCall = async (url, body) => {
                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(body)
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            throw new Error(`Server error: ${response.status} ${response.statusText}. ${errorText}`);
                        }

                        return await response.json();
                    } catch (error) {
                        console.error('API Call Error:', error);
                        showToast(error.message, 'error');
                        return null;
                    }
                };

                // Save user button event
                document.getElementById('saveUserBtn').addEventListener('click', async function() {
                    const userData = {
                        userName: document.getElementById('userName').value,
                        userTier: document.getElementById('userTier').value,
                        startWork: document.getElementById('startWork').value,
                        userRole: document.getElementById('userRole').value,
                        userEmail: document.getElementById('userEmail').value,
                        birthday: document.getElementById('birthday').value,
                    };

                    const data = await apiCall('api-user.php', userData);
                    if (data && data.success) {
                        showToast(data.message);
                        addUserModal.hide();
                        document.getElementById('addUserForm').reset();
                        // Instead of reloading, you can dynamically add the new row
                        // For simplicity, we'll reload. For better UX, implement addTableRow().
                        location.reload(); 
                    } else if (data) {
                        showToast(data.message, 'error');
                    }
                });

                // Update user button event
                document.getElementById('updateUserBtn').addEventListener('click', async function() {
                    const userData = {
                        userId: document.getElementById('editUserId').value,
                        userName: document.getElementById('editUserName').value,
                        userTier: document.getElementById('editUserTier').value,
                        startWork: document.getElementById('editStartWork').value,
                        userRole: document.getElementById('editUserRole').value,
                        userEmail: document.getElementById('editUserEmail').value,
                        birthday: document.getElementById('editBirthday').value,
                    };

                    const data = await apiCall('api-user.php', userData);
                    if (data && data.success) {
                        showToast(data.message);
                        editUserModal.hide();
                        updateTableRow(data.data);
                    } else {
                        showToast(data.message, 'error');
                    }
                });

                // Delete selected users
                deleteBtn.addEventListener('click', function() {
                    const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
                    const userIds = Array.from(selectedCheckboxes).map(cb => cb.value);

                    if (userIds.length > 0) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then(async (result) => {
                            if (result.isConfirmed) { 
                                let successCount = 0;
                                let errorCount = 0;
                                for (const userId of userIds) {
                                    const data = await apiCall('api-user-delete.php', { userId: userId });
                                    if (data && data.success) {
                                        const row = document.getElementById(`user-row-${userId}`);
                                        if (row) row.remove();
                                        successCount++;
                                    } else {
                                        errorCount++;
                                    }
                                }
                                if(successCount > 0) {
                                    showToast(`${successCount} user(s) deleted successfully.`, 'success');
                                }
                                if(errorCount > 0) {
                                    showToast(`${errorCount} user(s) could not be deleted.`, 'error');
                                }
                                updateButtonStates();
                            }
                        });
                    }
                });

                // Edit selected user
                editBtn.addEventListener('click', function() {
                    const selectedCheckbox = document.querySelector('.user-checkbox:checked');
                    if (selectedCheckbox) {
                        const row = selectedCheckbox.closest('tr');
                        document.getElementById('editUserId').value = row.dataset.userId;
                        document.getElementById('editUserName').value = row.dataset.userName;
                        document.getElementById('editUserTier').value = row.dataset.userTier;
                        document.getElementById('editStartWork').value = row.dataset.startWork;
                        document.getElementById('editUserRole').value = row.dataset.userRole;
                        document.getElementById('editUserEmail').value = row.dataset.userEmail;
                        document.getElementById('editBirthday').value = row.dataset.birthday;
                        editUserModal.show();
                    }
                });

                function updateButtonStates() {
                    const selectedCount = document.querySelectorAll('.user-checkbox:checked').length;
                    editBtn.disabled = selectedCount !== 1;
                    deleteBtn.disabled = selectedCount === 0;
                }

                selectAllCheckbox.addEventListener('change', function() {
                    userCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateButtonStates();
                });

                userCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateButtonStates);
                });

                function updateTableRow(userData) {
                    const row = document.getElementById(`user-row-${userData.userId}`);
                    if (row) {
                        row.querySelector('.user-name').textContent = userData.userName;
                        row.querySelector('.user-tier').textContent = userData.userTier;
                        row.querySelector('.start-work').textContent = userData.startWork;
                        row.querySelector('.user-role').textContent = userData.userRole;
                        row.querySelector('.user-email').textContent = userData.userEmail;
                        row.querySelector('.birthday').textContent = userData.birthday;

                        // Also update data attributes on the edit button for future edits
                        const editBtn = row.querySelector('.edit-btn');
                        editBtn.setAttribute('data-user-name', userData.userName);
                        editBtn.setAttribute('data-user-tier', userData.userTier);
                        editBtn.setAttribute('data-start-work', userData.startWork);
                        editBtn.setAttribute('data-user-role', userData.userRole);
                        editBtn.setAttribute('data-user-email', userData.userEmail);
                        editBtn.setAttribute('data-birthday', userData.birthday);
                    }
                } 
                // Initial state
                updateButtonStates();
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
