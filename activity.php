<?php
require_once './partials/db_connection.php';

// Prevent direct access
if(!isset($conn)) {
    header("Location: index.php");
    exit();
}

// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    information_date DATE,
    user_position VARCHAR(255),
    department VARCHAR(100),
    application VARCHAR(100),
    type VARCHAR(100),
    description TEXT,
    action_solution TEXT,
    due_date DATE,
    status VARCHAR(50),
    cnc_number VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// --- HANDLE DELETE ---
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_to_delete = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM activities WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    if ($stmt->execute()) {
        header("Location: activity.php?status=deleted");
        exit();
    }
    $stmt->close();
}

// --- HANDLE GET REQUEST FOR EDIT ---
if (isset($_GET['action']) && $_GET['action'] == 'get' && isset($_GET['id'])) {
    $id_to_get = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM activities WHERE id = ?");
    $stmt->bind_param("i", $id_to_get);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        header('Content-Type: application/json');
        echo json_encode($row);
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Not found']);
        exit();
    }
}

// --- HANDLE POST REQUESTS (ADD / UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $information_date = $conn->real_escape_string($_POST['information_date']);
    $user_position = $conn->real_escape_string($_POST['user_position']);
    $department = $conn->real_escape_string($_POST['department']);
    $application = $conn->real_escape_string($_POST['application']);
    $type = $conn->real_escape_string($_POST['type']);
    $description = $conn->real_escape_string($_POST['description']);
    $action_solution = $conn->real_escape_string($_POST['action_solution']);
    $due_date = empty($_POST['due_date']) ? NULL : $conn->real_escape_string($_POST['due_date']);
    $status = $conn->real_escape_string($_POST['status']);
    $cnc_number = $conn->real_escape_string($_POST['cnc_number']);

    if (isset($_POST['add_activity'])) {
        $stmt = $conn->prepare("INSERT INTO activities (information_date, user_position, department, application, type, description, action_solution, due_date, status, cnc_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $information_date, $user_position, $department, $application, $type, $description, $action_solution, $due_date, $status, $cnc_number);
        if ($stmt->execute()) {
            header("Location: activity.php?status=added");
            exit();
        }
        $stmt->close();
    }
    // Handle update activity
    if (isset($_POST['edit_activity']) && isset($_POST['edit_id'])) {
        $edit_id = (int)$_POST['edit_id'];
        $stmt = $conn->prepare("UPDATE activities SET information_date=?, user_position=?, department=?, application=?, type=?, description=?, action_solution=?, due_date=?, status=?, cnc_number=? WHERE id=?");
        $stmt->bind_param("ssssssssssi", $information_date, $user_position, $department, $application, $type, $description, $action_solution, $due_date, $status, $cnc_number, $edit_id);
        if ($stmt->execute()) {
            header("Location: activity.php?status=updated");
            exit();
        }
        $stmt->close();
    }
}

include './partials/layouts/layoutTop.php';
?>

<div class="dashboard-main-body d-flex flex-column min-vh-100">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="d-flex align-items-center gap-3">
            <h6 class="fw-semibold mb-0">Activities</h6>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                <i class="ri-add-line align-bottom"></i> Add New Activity
            </button>
        </div>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="ri-home-4-line icon text-lg"></i>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Components / Activity</li>
        </ul>
    </div>
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-3" id="activityTab" role="tablist" style="background:transparent; border-bottom:0;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active d-flex align-items-center" id="list-tab" data-bs-toggle="tab" data-bs-target="#listView" type="button" role="tab" aria-controls="listView" aria-selected="true">
                <i class="ri-list-check-2 mr-1"></i> List
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-flex align-items-center" id="kanban-tab" data-bs-toggle="tab" data-bs-target="#kanbanView" type="button" role="tab" aria-controls="kanbanView" aria-selected="false">
                <i class="ri-layout-column-line mr-1"></i> Kanban
            </button>
        </li>
    </ul>
    <div class="tab-content" id="activityTabContent">
        <div class="tab-pane fade show active" id="listView" role="tabpanel" aria-labelledby="list-tab">
            <!-- Main Content -->
            <div class="content">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover" id="activityTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Information Date</th>
                                        <th>User & Position</th>
                                        <th>Department</th>
                                        <th>Application</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Action/Solution</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>CNC Number</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $query = "SELECT * FROM activities ORDER BY information_date DESC";
                                $result = $conn->query($query);
                                $no = 1;
                                
                                if ($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$no++."</td>";
                                        echo "<td>".date('d M Y', strtotime($row['information_date']))."</td>";
                                        echo "<td>".htmlspecialchars($row['user_position'])."</td>";
                                        echo "<td>".htmlspecialchars($row['department'])."</td>";
                                        echo "<td>".htmlspecialchars($row['application'])."</td>";
                                        echo "<td>".htmlspecialchars($row['type'])."</td>";
                                        echo "<td>".htmlspecialchars($row['description'])."</td>";
                                        echo "<td>".htmlspecialchars($row['action_solution'])."</td>";
                                        echo "<td>".($row['due_date'] ? date('d M Y', strtotime($row['due_date'])) : '-')."</td>";
                                        echo "<td><span class='badge bg-".($row['status'] == 'Open' ? 'primary' : ($row['status'] == 'In Progress' ? 'warning' : ($row['status'] == 'Completed' ? 'success' : 'secondary')))."'>".$row['status']."</span></td>";
                                        echo "<td>".htmlspecialchars($row['cnc_number'])."</td>";
                                        echo "<td class='text-center'>
                                            <button class='btn btn-xs btn-warning me-1' onclick='editActivity(".$row['id'].")'><i class='ri-edit-line'></i></button>
                                            <button class='btn btn-xs btn-danger' onclick='deleteActivity(".$row['id'].")'><i class='ri-delete-bin-line'></i></button>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='12' class='text-center'>No activities found</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="kanbanView" role="tabpanel" aria-labelledby="kanban-tab">
            <!-- Kanban board dynamically generated from activities -->
            <div class="kanban-board row g-3">
                <?php
                // Prepare activities grouped by status
                $statuses = [
                    'Open' => [],
                    'On Progress' => [],
                    'Need Requirement' => [],
                    'Done' => []
                ];
                $query = "SELECT * FROM activities ORDER BY information_date DESC";
                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $statuses[$row['status']][] = $row;
                    }
                }
                $kanban_colors = [
                    'Open' => 'primary',
                    'On Progress' => 'warning',
                    'Need Requirement' => 'info',
                    'Done' => 'success'
                ];
                foreach ($statuses as $status => $items) {
                ?>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-header bg-<?php echo $kanban_colors[$status]; ?> text-white fw-semibold">
                            <?php echo $status; ?>
                        </div>
                        <div class="card-body kanban-column" style="min-height:200px;">
                            <?php if (count($items) > 0) {
                                foreach ($items as $item) { ?>
                                    <div class="kanban-card mb-3 p-2 border rounded bg-light">
                                        <div class="fw-semibold mb-1"> <?php echo htmlspecialchars($item['user_position']); ?> </div>
                                        <div class="small text-muted mb-1"> <?php echo htmlspecialchars($item['department']); ?> | <?php echo htmlspecialchars($item['application']); ?> </div>
                                        <div class="mb-1"> <span class="badge bg-<?php echo $kanban_colors[$status]; ?>"> <?php echo $item['type']; ?> </span> </div>
                                        <div class="mb-1"> <?php echo htmlspecialchars($item['description']); ?> </div>
                                        <div class="mb-1 text-secondary"> Due: <?php echo ($item['due_date'] ? date('d M Y', strtotime($item['due_date'])) : '-'); ?> </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-xs btn-warning edit-btn" data-id="<?php echo $item['id']; ?>"><i class="ri-edit-line"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger delete-btn" data-id="<?php echo $item['id']; ?>"><i class="ri-delete-bin-line"></i></button>
                                        </div>
                                    </div>
                                <?php }
                            } else {
                                echo '<div class="text-center text-muted">No activities</div>';
                            } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>



<!-- Add Activity Modal -->
<div class="modal fade" id="addActivityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addActivityForm" action="activity.php" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Information Date</label>
                            <input type="date" class="form-control" name="information_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">User & Position</label>
                            <input type="text" class="form-control" name="user_position" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department" required>
                                <option value="Food & Beverage">Food & Beverage</option>
                                <option value="Kitchen">Kitchen</option>
                                <option value="Room Division">Room Division</option>
                                <option value="Front Office">Front Office</option>
                                <option value="Housekeeping">Housekeeping</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Sales & Marketing">Sales & Marketing</option>
                                <option value="IT / EDP">IT / EDP</option>
                                <option value="Accounting">Accounting</option>
                                <option value="Executive Office">Executive Office</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Application</label>
                            <select class="form-select" name="application" required>
                                <option value="Cloud POS">Cloud POS</option>
                                <option value="Cloud MGR">Cloud MGR</option>
                                <option value="Cloud FO">Cloud FO</option>
                                <option value="Cloud AR">Cloud AR</option>
                                <option value="Cloud INV">Cloud INV</option>
                                <option value="Cloud AP">Cloud AP</option>
                                <option value="Cloud GL">Cloud GL</option>
                                <option value="Keylock">Keylock</option>
                                <option value="PABX">PABX</option>
                                <option value="DIM">DIM</option>
                                <option value="Dynamic Rate">Dynamic Rate</option>
                                <option value="Channel Manager">Channel Manager</option>
                                <option value="PB1">PB1</option>
                                <option value="PowerSIGN">PowerSIGN</option>
                                <option value="Multi Properties">Multi Properties</option>
                                <option value="Scanner ID">Scanner ID</option>
                                <option value="IPOS">IPOS</option>
                                <option value="PowerRunner">PowerRunner</option>
                                <option value="Power RA">Power RA</option>
                                <option value="Power ME">Power ME</option>
                                <option value="ECOS">ECOS</option>
                                <option value="CloudWS">CloudWS</option>
                                <option value="PowerGO">PowerGO</option>
                                <option value="Dashpad">Dashpad</option>
                                <option value="IPTV">IPTV</option>
                                <option value="HSIA">HSIA</option>
                                <option value="SGI">SGI</option>
                                <option value="Guest Survey">Guest Survey</option>
                                <option value="Loyalty Management">Loyalty Management</option>
                                <option value="AccPac">AccPac</option>
                                <option value="GL Consolidation">GL Consolidation</option>
                                <option value="Self Check In">Self Check In</option>
                                <option value="Check In Desk">Check In Desk</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type" required>
                                <option value="Setup">Setup</option>
                                <option value="Question">Question</option>
                                <option value="Issue">Issue</option>
                                <option value="Report Issue">Report Issue</option>
                                <option value="Report Request">Report Request</option>
                                <option value="Feature Request">Feature Request</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CNC Number</label>
                            <input type="text" class="form-control" name="cnc_number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-control" name="due_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="Open">Open</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Need Requirement">Need Requirement</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Action/Solution</label>
                            <textarea class="form-control" name="action_solution" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_activity" class="btn btn-primary">Save Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editActivityForm" action="activity.php" method="POST">
                <input type="hidden" name="edit_id" id="editActivityId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Information Date</label>
                            <input type="date" class="form-control" name="information_date" id="edit_information_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">User & Position</label>
                            <input type="text" class="form-control" name="user_position" id="edit_user_position" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department" id="edit_department" required>
                                <option value="Food & Beverage">Food & Beverage</option>
                                <option value="Kitchen">Kitchen</option>
                                <option value="Room Division">Room Division</option>
                                <option value="Front Office">Front Office</option>
                                <option value="Housekeeping">Housekeeping</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Sales & Marketing">Sales & Marketing</option>
                                <option value="IT / EDP">IT / EDP</option>
                                <option value="Accounting">Accounting</option>
                                <option value="Executive Office">Executive Office</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Application</label>
                            <select class="form-select" name="application" id="edit_application" required>
                                <option value="Cloud POS">Cloud POS</option>
                                <option value="Cloud MGR">Cloud MGR</option>
                                <option value="Cloud FO">Cloud FO</option>
                                <option value="Cloud AR">Cloud AR</option>
                                <option value="Cloud INV">Cloud INV</option>
                                <option value="Cloud AP">Cloud AP</option>
                                <option value="Cloud GL">Cloud GL</option>
                                <option value="Keylock">Keylock</option>
                                <option value="PABX">PABX</option>
                                <option value="DIM">DIM</option>
                                <option value="Dynamic Rate">Dynamic Rate</option>
                                <option value="Channel Manager">Channel Manager</option>
                                <option value="PB1">PB1</option>
                                <option value="PowerSIGN">PowerSIGN</option>
                                <option value="Multi Properties">Multi Properties</option>
                                <option value="Scanner ID">Scanner ID</option>
                                <option value="IPOS">IPOS</option>
                                <option value="PowerRunner">PowerRunner</option>
                                <option value="Power RA">Power RA</option>
                                <option value="Power ME">Power ME</option>
                                <option value="ECOS">ECOS</option>
                                <option value="CloudWS">CloudWS</option>
                                <option value="PowerGO">PowerGO</option>
                                <option value="Dashpad">Dashpad</option>
                                <option value="IPTV">IPTV</option>
                                <option value="HSIA">HSIA</option>
                                <option value="SGI">SGI</option>
                                <option value="Guest Survey">Guest Survey</option>
                                <option value="Loyalty Management">Loyalty Management</option>
                                <option value="AccPac">AccPac</option>
                                <option value="GL Consolidation">GL Consolidation</option>
                                <option value="Self Check In">Self Check In</option>
                                <option value="Check In Desk">Check In Desk</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type" id="edit_type" required>
                                <option value="Setup">Setup</option>
                                <option value="Question">Question</option>
                                <option value="Issue">Issue</option>
                                <option value="Report Issue">Report Issue</option>
                                <option value="Report Request">Report Request</option>
                                <option value="Feature Request">Feature Request</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CNC Number</label>
                            <input type="text" class="form-control" name="cnc_number" id="edit_cnc_number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-control" name="due_date" id="edit_due_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="edit_status" required>
                                <option value="Open">Open</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Need Requirement">Need Requirement</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="edit_description" rows="3" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Action/Solution</label>
                            <textarea class="form-control" name="action_solution" id="edit_action_solution" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="edit_activity" class="btn btn-primary">Update Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<noscript>
    <div style="background: #ffeded; color: #b91c1c; padding: 16px; text-align: center; font-weight: bold;">
        Website ini membutuhkan JavaScript agar fitur edit dan delete activity dapat berjalan dengan baik.<br>
        Silakan aktifkan JavaScript di browser Anda untuk pengalaman penuh.
    </div>
</noscript>

<style>
/* Content Layout */
.content-wrapper {
    padding: 1.5rem;
    background: #f8f9fa;
    margin-left: 270px;
}

.content-header {
    margin-bottom: 1.5rem;
    padding: 0;
}

.content-header h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.5rem;
}

.breadcrumb {
    margin: 0;
    padding: 0;
    font-size: 0.875rem;
}

.breadcrumb-item a {
    color: #6B7280;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #111827;
}

/* Card & Table */
.card {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    background: #fff;
    margin-bottom: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

.table {
    margin-bottom: 0;
}

.table th {
    font-weight: 600;
    color: #111827;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #e5e7eb;
}

/* Buttons */
.btn {
    font-weight: 500;
}

.btn-xs {
    padding: 0.2rem 0.4rem;
    font-size: 0.75rem;
    border-radius: 0.25rem;
}

.btn i {
    font-size: 0.875rem;
}

/* Badge */
.badge {
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 500;
}

/* Form Controls */
.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.375rem;
}

.form-control, .form-select {
    border-color: #d1d5db;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.2);
}

/* Modal */
.modal-header {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.modal-body {
    padding: 1rem;
}

.modal-footer {
    padding: 1rem;
    border-top: 1px solid #e5e7eb;
}
/* Custom: Make table search bar match top search bar focus effect */
.input-group:focus-within {
    box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
    border: 1.5px solid #3b82f6 !important;
    border-radius: 0.5rem;
}
}
#customSearch:focus {
    border-color: #3b82f6 !important;
    box-shadow: none;
}

/* Nav Tabs */
.nav-tabs {
    border-bottom: 1px solid #e5e7eb;
}
.nav-tabs .nav-link {
    color: #374151;
    font-weight: 500;
    border: 0;
    border-radius: 0.5rem 0.5rem 0 0;
    background: #f8f9fa;
    margin-right: 0.25rem;
    padding: 0.75rem 1.5rem;
    transition: background 0.2s, color 0.2s;
    display: flex;
    align-items: center;
}
.nav-tabs .nav-link.active {
    background: #fff;
    color: #2563eb;
    box-shadow: 0 -2px 8px rgba(59,130,246,0.05);
}
.nav-tabs .nav-link i {
    font-size: 1.1rem;
    margin-right: 0.5rem;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var table = $('#activityTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[1, 'desc']],
        dom: 'rtip', // Remove length and search from default
        language: {
            search: "",
            searchPlaceholder: "Search...",
            paginate: {
                previous: '<i class="ri-arrow-left-s-line"></i>',
                next: '<i class="ri-arrow-right-s-line"></i>'
            }
        },
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-sm');
        }
    });
    // Custom search input
    $('#customSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Delete confirmation
    window.deleteActivity = function(id) {
        Swal.fire({
            title: 'Delete Activity',
            text: 'Are you sure you want to delete this activity?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6B7280'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'activity.php?action=delete&id=' + id;
            }
        });
    };

    // Edit Activity logic
    window.editActivity = function(id) {
        // Fetch activity data via AJAX
        $.ajax({
            url: 'activity.php',
            type: 'GET',
            data: { action: 'get', id: id },
            dataType: 'json',
            success: function(data) {
                if (data && data.id) {
                    $('#editActivityId').val(data.id);
                    $('#edit_information_date').val(data.information_date);
                    $('#edit_user_position').val(data.user_position);
                    $('#edit_department').val(data.department);
                    $('#edit_application').val(data.application);
                    $('#edit_type').val(data.type);
                    $('#edit_description').val(data.description);
                    $('#edit_action_solution').val(data.action_solution);
                    $('#edit_due_date').val(data.due_date);
                    $('#edit_status').val(data.status);
                    $('#edit_cnc_number').val(data.cnc_number);
                    $('#editActivityModal').modal('show');
                } else {
                    Swal.fire({ icon: 'error', text: 'Failed to fetch activity data.' });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', text: 'Failed to fetch activity data.' });
            }
        });
    };

    // Status notifications
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    if (status) {
        const messages = {
            added: 'Activity added successfully',
            deleted: 'Activity deleted successfully',
            updated: 'Activity updated successfully'
        };
        
        if (messages[status]) {
            Swal.fire({
                icon: 'success',
                text: messages[status],
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    }

    // Use event delegation for edit/delete buttons
    $('#activityTable').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        editActivity(id);
    });
    $('#activityTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        deleteActivity(id);
    });
});
</script>

<?php 
$conn->close();
?>

<!-- Kanban JS Integration -->
<script>
$(function() {
    $("#sortable-wrapper").sortable();
    $("#sortable1, #sortable2, #sortable3").sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
});

// Duplicate Item js
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".duplicate-button").forEach(button => {
        button.addEventListener("click", function() {
            const card = this.closest(".kanban-item");
            const clone = card.cloneNode(true);
            card.parentNode.appendChild(clone);
            clone.querySelector(".delete-button").addEventListener("click", function() {
                clone.remove();
            });
        });
    });
    $(document).on("click", ".delete-button", function() {
        $(this).closest(".kanban-item").addClass("d-none");
    });
});

// Add/Edit Task js
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".add-kanban, .add-task-button").forEach(button => {
        button.addEventListener("click", function() {
            var addTaskModal = new bootstrap.Modal(document.getElementById("addTaskModal"));
            document.getElementById("editTaskId").value = "";
            document.getElementById("taskTitle").value = "";
            document.getElementById("taskDescription").value = "";
            document.getElementById("taskTag").value = "";
            document.getElementById("startDate").value = "";
            document.getElementById("taskImage").value = "";
            document.getElementById("taskImagePreview").style.display = "none";
            document.getElementById("taskImagePreview").src = "";
            addTaskModal.show();
        });
    });
    document.getElementById("taskImage").addEventListener("change", function() {
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("taskImagePreview").src = e.target.result;
            document.getElementById("taskImagePreview").style.display = "block";
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    });
    document.getElementById("saveTaskButton").addEventListener("click", function() {
        var title = document.getElementById("taskTitle").value;
        var description = document.getElementById("taskDescription").value;
        var tag = document.getElementById("taskTag").value;
        var date = document.getElementById("startDate").value;
        var editTaskId = document.getElementById("editTaskId").value;
        var imageSrc = document.getElementById("taskImagePreview").src;
        if (title === "" || description === "") {
            alert("Title and Description cannot be empty");
            return;
        }
        var kanbanCardHTML = `
            <div class="kanban-card bg-neutral-50 p-16 radius-8 mb-24" id="${editTaskId ? editTaskId : "kanban-" + new Date().getTime()}">
                ${imageSrc ? `<div class=\"radius-8 mb-12 max-h-350-px overflow-hidden\"><img src=\"${imageSrc}\" alt=\"\" class=\"w-100 h-100 object-fit-cover\"></div>` : ""}
                <h6 class=\"kanban-title text-lg fw-semibold mb-8\">${title}</h6>
                <p class=\"kanban-desc text-secondary-light\">${description}</p>
                <button type=\"button\" class=\"start-date btn text-primary-600 border rounded border-primary-600 bg-hover-primary-600 text-hover-white d-flex align-items-center gap-2\">
                    <iconify-icon icon=\"lucide:tag\" class=\"icon\"></iconify-icon> <span class=\"kanban-tag fw-semibold\">${tag}</span>
                </button>
                <div class=\"mt-12 d-flex align-items-center justify-content-between gap-10\">
                    <div class=\"d-flex align-items-center justify-content-between gap-10\">
                        <iconify-icon icon=\"solar:calendar-outline\" class=\"text-primary-light\"></iconify-icon>
                        <span class=\"start-date text-secondary-light\">${date}</span>
                    </div>
                    <div class=\"d-flex align-items-center justify-content-between gap-10\">
                        <button type=\"button\" class=\"card-edit-button text-success-600\"><iconify-icon icon=\"lucide:edit\" class=\"icon text-lg line-height-1\"></iconify-icon></button>
                        <button type=\"button\" class=\"card-delete-button text-danger-600\"><iconify-icon icon=\"fluent:delete-24-regular\" class=\"icon text-lg line-height-1\"></iconify-icon></button>
                    </div>
                </div>
            </div>
            `;
        if (editTaskId) {
            var editCard = document.getElementById(editTaskId);
            if (editCard) {
                editCard.outerHTML = kanbanCardHTML;
            }
        } else {
            var targetKanbanItem = document.querySelector(".kanban-item");
            if (targetKanbanItem) {
                var firstKanbanCard = targetKanbanItem.querySelector(".card-body .kanban-card");
                if (firstKanbanCard) {
                    firstKanbanCard.insertAdjacentHTML("beforebegin", kanbanCardHTML);
                } else {
                    targetKanbanItem.querySelector(".card-body").insertAdjacentHTML("afterbegin", kanbanCardHTML);
                }
            }
        }
        var addTaskModal = bootstrap.Modal.getInstance(document.getElementById("addTaskModal"));
        addTaskModal.hide();
    });
    document.addEventListener("click", function(e) {
        if (e.target.closest(".card-edit-button")) {
            var card = e.target.closest(".kanban-card");
            document.getElementById("taskTitle").value = card.querySelector(".kanban-title").textContent;
            document.getElementById("taskDescription").value = card.querySelector(".kanban-desc").textContent;
            document.getElementById("taskTag").value = card.querySelector(".kanban-tag").textContent;
            document.getElementById("startDate").value = card.querySelector(".start-date").textContent;
            document.getElementById("editTaskId").value = card.id;
            var img = card.querySelector("img");
            if (img) {
                document.getElementById("taskImagePreview").src = img.src;
                document.getElementById("taskImagePreview").style.display = "block";
            } else {
                document.getElementById("taskImagePreview").style.display = "none";
                document.getElementById("taskImagePreview").src = "";
            }
            var addTaskModal = new bootstrap.Modal(document.getElementById("addTaskModal"));
            addTaskModal.show();
        }
        if (e.target.closest(".card-delete-button")) {
            var card = e.target.closest(".kanban-card");
            if (card) {
                card.remove();
            }
        }
    });
});
</script>
<!-- Footer will be rendered by layoutBottom.php outside dashboard-main-body -->
<?php include './partials/layouts/layoutBottom.php'; ?>
