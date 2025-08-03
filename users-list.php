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
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">User ID</th>
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

// Function to generate initials from full name
function generateInitials($firstName, $lastName) {
    $firstInitial = !empty($firstName) ? strtoupper(substr($firstName, 0, 1)) : '';
    $lastInitial = !empty($lastName) ? strtoupper(substr($lastName, 0, 1)) : '';
    
    if ($firstInitial && $lastInitial) {
        return $firstInitial . $lastInitial;
    } elseif ($firstInitial) {
        return $firstInitial;
    } elseif ($lastInitial) {
        return $lastInitial;
    } else {
        return 'U'; // Default for unknown names
    }
}

$sql = "SELECT id, first_name, last_name, CONCAT(first_name, ' ', last_name) as user_name, user_tier, start_work, user_role, email as user_email, birthday FROM users";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $initials = generateInitials($row["first_name"], $row["last_name"]);
        echo '<tr class="user-row" 
            data-user-id="' . htmlspecialchars($row["id"]) . '" 
            data-user-name="' . htmlspecialchars($row["user_name"]) . '" 
            data-user-tier="' . htmlspecialchars($row["user_tier"]) . '" 
            data-start-work="' . htmlspecialchars($row["start_work"]) . '" 
            data-user-role="' . htmlspecialchars($row["user_role"]) . '" 
            data-user-email="' . htmlspecialchars($row["user_email"]) . '" 
            data-birthday="' . htmlspecialchars($row["birthday"]) . '">';
        echo '<td class="user-id">' . htmlspecialchars($initials) . '</td>';
        echo '<td class="user-name">' . htmlspecialchars($row["user_name"]) . '</td>';
        echo '<td class="user-tier">' . htmlspecialchars($row["user_tier"]) . '</td>';
        echo '<td class="start-work">' . htmlspecialchars($row["start_work"]) . '</td>';
        echo '<td class="user-role">' . htmlspecialchars($row["user_role"]) . '</td>';
        echo '<td class="user-email">' . htmlspecialchars($row["user_email"]) . '</td>';
        echo '<td class="birthday">' . htmlspecialchars($row["birthday"]) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="7" class="text-center">No users found.</td></tr>';
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
                                <label for="addUserId" class="form-label">User ID</label>
                                <input type="text" class="form-control" id="addUserId" required>
                            </div>
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

        <!-- User Detail Modal -->
        <div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userDetailModalLabel">User Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">User ID</label>
                                    <p class="mb-0" id="detailUserId"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">User Name</label>
                                    <p class="mb-0" id="detailUserName"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">User Tier</label>
                                    <p class="mb-0" id="detailUserTier"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Start Work</label>
                                    <p class="mb-0" id="detailStartWork"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">User Roles</label>
                                    <p class="mb-0" id="detailUserRole"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">User Email</label>
                                    <p class="mb-0" id="detailUserEmail"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Birthday</label>
                                    <p class="mb-0" id="detailBirthday"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="editUserBtn">Edit</button>
                        <button type="button" class="btn btn-danger" id="deleteUserBtn">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                            <div class="mb-3">
                                <label for="editUserId" class="form-label">User ID</label>
                                <input type="text" class="form-control" id="editUserId" required readonly>
                            </div>
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
                        <button type="button" class="btn btn-primary" id="updateUserBtn">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Hover effects for user rows */
            .user-row {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            
            .user-row:hover {
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
                const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
                const userDetailModal = new bootstrap.Modal(document.getElementById('userDetailModal'));
                const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));

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
                        userId: document.getElementById('addUserId').value,
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
                        location.reload(); 
                    } else if (data) {
                        showToast(data.message, 'error');
                    }
                });

                // Row click event to show user details
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.user-row')) {
                        const row = e.target.closest('.user-row');
                        
                        // Populate detail modal
                        document.getElementById('detailUserId').textContent = row.dataset.userId;
                        document.getElementById('detailUserName').textContent = row.dataset.userName;
                        document.getElementById('detailUserTier').textContent = row.dataset.userTier;
                        document.getElementById('detailStartWork').textContent = row.dataset.startWork;
                        document.getElementById('detailUserRole').textContent = row.dataset.userRole;
                        document.getElementById('detailUserEmail').textContent = row.dataset.userEmail;
                        document.getElementById('detailBirthday').textContent = row.dataset.birthday;
                        
                        // Store current user data for edit/delete
                        window.currentUserData = {
                            userId: row.dataset.userId,
                            userName: row.dataset.userName,
                            userTier: row.dataset.userTier,
                            startWork: row.dataset.startWork,
                            userRole: row.dataset.userRole,
                            userEmail: row.dataset.userEmail,
                            birthday: row.dataset.birthday
                        };
                        
                        userDetailModal.show();
                    }
                });

                // Edit user button in detail modal
                document.getElementById('editUserBtn').addEventListener('click', function() {
                    if (window.currentUserData) {
                        document.getElementById('editUserId').value = window.currentUserData.userId;
                        document.getElementById('editUserName').value = window.currentUserData.userName;
                        document.getElementById('editUserTier').value = window.currentUserData.userTier;
                        document.getElementById('editStartWork').value = window.currentUserData.startWork;
                        document.getElementById('editUserRole').value = window.currentUserData.userRole;
                        document.getElementById('editUserEmail').value = window.currentUserData.userEmail;
                        document.getElementById('editBirthday').value = window.currentUserData.birthday;
                        
                        userDetailModal.hide();
                        editUserModal.show();
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
                        // Update detail modal data
                        if (window.currentUserData) {
                            window.currentUserData = data.data;
                        }
                    } else {
                        showToast(data.message, 'error');
                    }
                });

                // Delete user button in detail modal
                document.getElementById('deleteUserBtn').addEventListener('click', function() {
                    if (window.currentUserData) {
                        const userName = window.currentUserData.userName;
                        const userId = window.currentUserData.userId;

                        Swal.fire({
                            title: `Are you sure you want to delete ${userName}?`,
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete!',
                            cancelButtonText: 'Cancel'
                        }).then(async (result) => {
                            if (result.isConfirmed) {
                                const data = await apiCall('api-user-delete.php', { userIds: [userId] });
                                if (data && data.success) {
                                    showToast(data.message || `${userName} deleted successfully.`);
                                    userDetailModal.hide();
                                    // Remove the row from table
                                    const row = document.querySelector(`[data-user-id="${userId}"]`);
                                    if (row) row.remove();
                                } else {
                                    showToast(data.message || 'Failed to delete user.', 'error');
                                }
                            }
                        });
                    }
                });

                function updateTableRow(userData) {
                    const row = document.querySelector(`[data-user-id="${userData.userId}"]`);
                    if (row) {
                        row.querySelector('.user-name').textContent = userData.userName;
                        row.querySelector('.user-tier').textContent = userData.userTier;
                        row.querySelector('.start-work').textContent = userData.startWork;
                        row.querySelector('.user-role').textContent = userData.userRole;
                        row.querySelector('.user-email').textContent = userData.userEmail;
                        row.querySelector('.birthday').textContent = userData.birthday;

                        // Also update data attributes on the row for future edits
                        row.dataset.userName = userData.userName;
                        row.dataset.userTier = userData.userTier;
                        row.dataset.startWork = userData.startWork;
                        row.dataset.userRole = userData.userRole;
                        row.dataset.userEmail = userData.userEmail;
                        row.dataset.birthday = userData.birthday;
                    }
                }
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
