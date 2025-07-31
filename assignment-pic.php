<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Assignment PIC</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Assignment PIC</li>
                </ul>
            </div>

            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h5 class="card-title mb-0">Assignment PIC Management</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAssignmentModal">
                                    <iconify-icon icon="akar-icons:plus" class="me-1"></iconify-icon>
                                    Add New Assignment
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
                                            <td>Assignment</td>
                                            <td>Ditugaskan oleh Project Coordinator</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAssignmentModal" data-code="Assignment" data-description="Ditugaskan oleh Project Coordinator">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAssignmentModal" data-code="Assignment">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Request</td>
                                            <td>Client Request PIC</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAssignmentModal" data-code="Request" data-description="Client Request PIC">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAssignmentModal" data-code="Request">
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

        <!-- Add Assignment Modal -->
        <div class="modal fade" id="addAssignmentModal" tabindex="-1" aria-labelledby="addAssignmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAssignmentModalLabel">Add New Assignment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addAssignmentForm">
                            <div class="mb-3">
                                <label for="assignmentCode" class="form-label">Code</label>
                                <input type="text" class="form-control" id="assignmentCode" required>
                            </div>
                            <div class="mb-3">
                                <label for="assignmentDescription" class="form-label">Description</label>
                                <input type="text" class="form-control" id="assignmentDescription" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveAssignmentBtn">Save Assignment</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Assignment Modal -->
        <div class="modal fade" id="editAssignmentModal" tabindex="-1" aria-labelledby="editAssignmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAssignmentModalLabel">Edit Assignment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editAssignmentForm">
                            <input type="hidden" id="editAssignmentCode">
                            <div class="mb-3">
                                <label for="editAssignmentDescription" class="form-label">Description</label>
                                <input type="text" class="form-control" id="editAssignmentDescription" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateAssignmentBtn">Update Assignment</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Assignment Modal -->
        <div class="modal fade" id="deleteAssignmentModal" tabindex="-1" aria-labelledby="deleteAssignmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAssignmentModalLabel">Delete Assignment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this assignment?</p>
                        <input type="hidden" id="deleteAssignmentCode">
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
            document.querySelectorAll('[data-bs-target="#editAssignmentModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    const description = this.getAttribute('data-description');
                    
                    document.getElementById('editAssignmentCode').value = code;
                    document.getElementById('editAssignmentDescription').value = description;
                });
            });

            // Add event listeners for delete buttons
            document.querySelectorAll('[data-bs-target="#deleteAssignmentModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    document.getElementById('deleteAssignmentCode').value = code;
                });
            });

            // Save assignment button event
            document.getElementById('saveAssignmentBtn').addEventListener('click', function() {
                const code = document.getElementById('assignmentCode').value;
                const description = document.getElementById('assignmentDescription').value;
                
                // Here you would typically send the data to the server
                console.log('Saving assignment:', { code, description });
                
                // Close the modal
                document.getElementById('addAssignmentModal').querySelector('.btn-close').click();
                
                // Reset form
                document.getElementById('addAssignmentForm').reset();
                
                // Show success message (in a real app)
                alert('Assignment saved successfully!');
            });

            // Update assignment button event
            document.getElementById('updateAssignmentBtn').addEventListener('click', function() {
                const code = document.getElementById('editAssignmentCode').value;
                const description = document.getElementById('editAssignmentDescription').value;
                
                // Here you would typically send the data to the server
                console.log('Updating assignment:', { code, description });
                
                // Close the modal
                document.getElementById('editAssignmentModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Assignment updated successfully!');
            });

            // Delete assignment button event
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const code = document.getElementById('deleteAssignmentCode').value;
                
                // Here you would typically send the data to the server
                console.log('Deleting assignment:', code);
                
                // Close the modal
                document.getElementById('deleteAssignmentModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Assignment deleted successfully!');
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
