<?php
require_once './partials/db_connection.php';

// --- HANDLE DELETE ---
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_to_delete = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM activity_logs WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    if ($stmt->execute()) {
        header("Location: activity_list.php?status=deleted");
        exit();
    }
    $stmt->close();
}

// --- HANDLE POST REQUESTS (ADD / UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and retrieve POST data
    $information_date = $conn->real_escape_string($_POST['information_date']);
    $user_position = $conn->real_escape_string($_POST['user_position']);
    $department = $conn->real_escape_string($_POST['department']);
    $application = $conn->real_escape_string($_POST['application']);
    $type = $conn->real_escape_string($_POST['type']);
    $description = $conn->real_escape_string($_POST['description']);
    $solution = $conn->real_escape_string($_POST['solution']);
    $due_date = empty($_POST['due_date']) ? NULL : $conn->real_escape_string($_POST['due_date']);
    $status = $conn->real_escape_string($_POST['status']);
    $cnc_number = $conn->real_escape_string($_POST['cnc_number']);

    // --- HANDLE UPDATE ---
    if (isset($_POST['update_activity_log'])) {
        $log_id = (int)$_POST['log_id'];
        $stmt = $conn->prepare("UPDATE activity_logs SET information_date=?, user_position=?, department=?, application=?, type=?, description=?, solution=?, due_date=?, status=?, cnc_number=? WHERE id=?");
        $stmt->bind_param("ssssssssssi", $information_date, $user_position, $department, $application, $type, $description, $solution, $due_date, $status, $cnc_number, $log_id);
        
        if ($stmt->execute()) {
            header("Location: activity_list.php?status=updated");
            exit();
        }
        $stmt->close();
    }
    
    // --- HANDLE ADD ---
    if (isset($_POST['add_activity_log'])) {
        $stmt = $conn->prepare("INSERT INTO activity_logs (information_date, user_position, department, application, type, description, solution, due_date, status, cnc_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $information_date, $user_position, $department, $application, $type, $description, $solution, $due_date, $status, $cnc_number);

        if ($stmt->execute()) {
            header("Location: activity_list.php?status=success");
            exit();
        }
        $stmt->close();
    }
}

include './partials/layouts/layoutTop.php';
?>

<div class="dashboard-main-body">
    <!-- Breadcrumb -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Activity List</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium"><a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary"><iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon> Dashboard</a></li>
            <li>-</li><li class="fw-medium">Activity List</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h5 class="card-title fw-semibold mb-0">Daftar Aktivitas Detail</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#activityListModal" id="addBtn">
                Tambah Aktivitas
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table">
                    <thead>
                        <tr>
                            <th>No</th><th>Info Date</th><th>User & Position</th><th>Department</th><th>Application</th><th>Type</th><th>Due Date</th><th>Status</th><th>CNC</th><th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM activity_logs ORDER BY information_date DESC, created_at DESC";
                        $result = $conn->query($sql);
                        $no = 1;

                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row["information_date"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["user_position"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["department"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["application"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["type"]); ?></td>
                                    <td><?php echo $row["due_date"] ? htmlspecialchars($row["due_date"]) : '-'; ?></td>
                                    <td><span class="badge bg-success"><?php echo htmlspecialchars($row["status"]); ?></span></td>
                                    <td><?php echo htmlspecialchars($row["cnc_number"]); ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-secondary border-0 editBtn" 
                                            data-bs-toggle="modal" data-bs-target="#activityListModal"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-info_date="<?php echo $row['information_date']; ?>"
                                            data-user_position="<?php echo htmlspecialchars($row['user_position']); ?>"
                                            data-department="<?php echo $row['department']; ?>"
                                            data-application="<?php echo $row['application']; ?>"
                                            data-type="<?php echo $row['type']; ?>"
                                            data-description="<?php echo htmlspecialchars($row['description']); ?>"
                                            data-solution="<?php echo htmlspecialchars($row['solution']); ?>"
                                            data-due_date="<?php echo $row['due_date']; ?>"
                                            data-status="<?php echo $row['status']; ?>"
                                            data-cnc_number="<?php echo htmlspecialchars($row['cnc_number']); ?>">
                                            <iconify-icon icon="uil:edit"></iconify-icon>
                                        </button>
                                        <a href="activity_list.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Are you sure you want to delete this log?');">
                                            <iconify-icon icon="uil:trash-alt"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center'>No activity logs found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="activityListModal" tabindex="-1" aria-labelledby="activityListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="mainForm" action="activity_list.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Aktivitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="log_id" name="log_id">
                    <div class="row">
                        <div class="col-md-4 mb-3"><label class="form-label">Information Date</label><input type="date" class="form-control" name="information_date" id="information_date" required></div>
                        <div class="col-md-4 mb-3"><label class="form-label">User & Position</label><input type="text" class="form-control" name="user_position" id="user_position"></div>
                        <div class="col-md-4 mb-3"><label class="form-label">Due Date</label><input type="date" class="form-control" name="due_date" id="due_date"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Department</label><select class="form-select" name="department" id="department" required><option value="">Choose...</option><option>Food & Beverage</option><option>Kitchen</option><option>Room Division</option><option>Front Office</option><option>Housekeeping</option><option>Engineering</option><option>Sales & Marketing</option><option>IT / EDP</option><option>Accounting</option><option>Executive Office</option></select></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Application</label><select class="form-select" name="application" id="application" required><option value="">Choose...</option><option>Cloud POS</option><option>Cloud MGR</option><option>Cloud FO</option><option>Cloud AR</option><option>Cloud INV</option><option>Cloud AP</option><option>Cloud GL</option><option>Keylock</option><option>PABX</option><option>DIM</option><option>Dynamic Rate</option><option>Channel Manager</option><option>PB1</option><option>PowerSIGN</option><option>Multi Properties</option><option>Scanner ID</option><option>IPOS</option><option>Power Runner</option><option>Power RA</option><option>Power ME</option><option>ECOS</option><option>Cloud WS</option><option>Power GO</option><option>Dashpad</option><option>IPTV</option><option>HSIA</option><option>SGI</option><option>Guest Survey</option><option>Loyalty Management</option><option>AccPac</option><option>GL Consolidation</option><option>Self Check In</option><option>Check In Desk</option></select></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Type</label><select class="form-select" name="type" id="type" required><option value="">Choose...</option><option>Setup</option><option>Question</option><option>Issue</option><option>Report Issue</option><option>Report Request</option><option>Feature Request</option></select></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Status</label><select class="form-select" name="status" id="status" required><option value="">Choose...</option><option>Open</option><option>On Progress</option><option>Need Requirement</option><option>DONE</option></select></div>
                    </div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" id="description" rows="3"></textarea></div>
                    <div class="mb-3"><label class="form-label">Action / Solution</label><textarea class="form-control" name="solution" id="solution" rows="3"></textarea></div>
                    <div class="row"><div class="col-md-6 mb-3"><label class="form-label">CNC Number</label><input type="text" class="form-control" name="cnc_number" id="cnc_number"></div></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="submitBtn" name="add_activity_log" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
$conn->close();
include './partials/layouts/layoutBottom.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('mainForm');
    const modalLabel = document.getElementById('modalLabel');
    const submitBtn = document.getElementById('submitBtn');

    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', function () {
            modalLabel.textContent = 'Edit Aktivitas';
            submitBtn.textContent = 'Simpan Perubahan';
            submitBtn.name = 'update_activity_log';

            const data = this.dataset;
            document.getElementById('log_id').value = data.id;
            document.getElementById('information_date').value = data.info_date;
            document.getElementById('user_position').value = data.user_position;
            document.getElementById('department').value = data.department;
            document.getElementById('application').value = data.application;
            document.getElementById('type').value = data.type;
            document.getElementById('description').value = data.description;
            document.getElementById('solution').value = data.solution;
            document.getElementById('due_date').value = data.due_date;
            document.getElementById('status').value = data.status;
            document.getElementById('cnc_number').value = data.cnc_number;
        });
    });

    document.getElementById('addBtn').addEventListener('click', function() {
        modalLabel.textContent = 'Tambah Aktivitas';
        submitBtn.textContent = 'Simpan';
        submitBtn.name = 'add_activity_log';
        form.reset();
        document.getElementById('log_id').value = '';
    });
});
</script>
