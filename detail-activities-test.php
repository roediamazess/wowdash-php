<?php
require_once './partials/db_connection.php';

// Prevent direct access
if(!isset($conn)) {
    header("Location: index.php");
    exit();
}

include './partials/layouts/layoutTop.php';
?>

<div class="dashboard-main-body d-flex flex-column min-vh-100">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="d-flex align-items-center gap-3">
            <h6 class="fw-semibold mb-0">Detail Activities - Test Mode</h6>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addDetailActivityModal">
                <i class="ri-add-line align-bottom"></i> Add New Activity
            </button>
        </div>
    </div>

    <!-- Database Status -->
    <div class="alert alert-info">
        <h6>Database Status:</h6>
        <?php
        $detailTable = $conn->query("SHOW TABLES LIKE 'detail_activities'");
        $appTable = $conn->query("SHOW TABLES LIKE 'applications'");
        
        if ($detailTable->num_rows > 0) {
            echo "<p style='color: green;'>✓ detail_activities table exists</p>";
        } else {
            echo "<p style='color: red;'>✗ detail_activities table missing</p>";
        }
        
        if ($appTable->num_rows > 0) {
            echo "<p style='color: green;'>✓ applications table exists</p>";
        } else {
            echo "<p style='color: red;'>✗ applications table missing</p>";
        }
        ?>
        <p><a href="setup_database.php" class="btn btn-sm btn-warning">Setup Database</a></p>
    </div>

    <!-- Activity List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Project ID</th>
                            <th>Information Date</th>
                            <th>User & Position</th>
                            <th>Department</th>
                            <th>Application</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="10" class="text-center">
                                <p>Database not setup yet. Please run setup first.</p>
                                <a href="setup_database.php" class="btn btn-primary">Setup Database</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Detail Activity Modal -->
<div class="modal fade" id="addDetailActivityModal" tabindex="-1" aria-labelledby="addDetailActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDetailActivityModalLabel">Add New Detail Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <strong>Database Required:</strong> Please setup the database first before adding activities.
                </div>
                <form id="addDetailActivityForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="projectId" class="form-label">Project ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="projectId" name="project_id" required disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="informationDate" class="form-label">Information Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="informationDate" name="information_date" required disabled>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="userPosition" class="form-label">User & Position <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="userPosition" name="user_position" required disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                            <select class="form-control" id="department" name="department" required disabled>
                                <option value="">Select Department</option>
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
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="application" class="form-label">Application <span class="text-danger">*</span></label>
                            <select class="form-control" id="application" name="application_id" required disabled>
                                <option value="">Select Application</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-control" id="type" name="type" required disabled>
                                <option value="">Select Type</option>
                                <option value="Setup">Setup</option>
                                <option value="Question">Question</option>
                                <option value="Issue">Issue</option>
                                <option value="Report Issue">Report Issue</option>
                                <option value="Report Request">Report Request</option>
                                <option value="Feature Request">Feature Request</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dueDate" class="form-label">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="dueDate" name="due_date" required disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required disabled>
                                <option value="">Select Status</option>
                                <option value="Open">Open</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Need Requirement">Need Requirement</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cncNumber" class="form-label">CNC Number</label>
                            <input type="text" class="form-control" id="cncNumber" name="cnc_number" disabled>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter detailed description..." required disabled></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="actionSolution" class="form-label">Action / Solution <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="actionSolution" name="action_solution" rows="4" placeholder="Enter action or solution..." required disabled></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="alert('Please setup database first!')" disabled>Save Activity</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Show database setup reminder
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Detail Activities Test Mode - Database setup required');
    });
</script>

<?php include './partials/layouts/layoutBottom.php' ?> 