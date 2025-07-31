<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Tier Level</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Tier Level</li>
                </ul>
            </div>

            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h5 class="card-title mb-0">Tier Level Management</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTierModal">
                                    <iconify-icon icon="akar-icons:plus" class="me-1"></iconify-icon>
                                    Add New Tier
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table bordered-table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tier Code</th>
                                            <th scope="col">Tier Name</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>New Born</td>
                                            <td>Baru Masuk</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTierModal" data-code="New Born" data-name="Baru Masuk">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTierModal" data-code="New Born">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tier 1</td>
                                            <td>Baru Assist</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTierModal" data-code="Tier 1" data-name="Baru Assist">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTierModal" data-code="Tier 1">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tier 2</td>
                                            <td>Trial Leader</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTierModal" data-code="Tier 2" data-name="Trial Leader">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTierModal" data-code="Tier 2">
                                                        <iconify-icon icon="mingcute:delete-2-line" class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tier 3</td>
                                            <td>Leader</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTierModal" data-code="Tier 3" data-name="Leader">
                                                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTierModal" data-code="Tier 3">
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

        <!-- Add Tier Modal -->
        <div class="modal fade" id="addTierModal" tabindex="-1" aria-labelledby="addTierModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTierModalLabel">Add New Tier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addTierForm">
                            <div class="mb-3">
                                <label for="tierCode" class="form-label">Tier Code</label>
                                <input type="text" class="form-control" id="tierCode" required>
                            </div>
                            <div class="mb-3">
                                <label for="tierName" class="form-label">Tier Name</label>
                                <input type="text" class="form-control" id="tierName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveTierBtn">Save Tier</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Tier Modal -->
        <div class="modal fade" id="editTierModal" tabindex="-1" aria-labelledby="editTierModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTierModalLabel">Edit Tier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTierForm">
                            <input type="hidden" id="editTierCode">
                            <div class="mb-3">
                                <label for="editTierName" class="form-label">Tier Name</label>
                                <input type="text" class="form-control" id="editTierName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateTierBtn">Update Tier</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Tier Modal -->
        <div class="modal fade" id="deleteTierModal" tabindex="-1" aria-labelledby="deleteTierModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteTierModalLabel">Delete Tier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this tier?</p>
                        <input type="hidden" id="deleteTierCode">
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
            document.querySelectorAll('[data-bs-target="#editTierModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const tierCode = this.getAttribute('data-code');
                    const tierName = this.getAttribute('data-name');
                    
                    document.getElementById('editTierCode').value = tierCode;
                    document.getElementById('editTierName').value = tierName;
                });
            });

            // Add event listeners for delete buttons
            document.querySelectorAll('[data-bs-target="#deleteTierModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const tierCode = this.getAttribute('data-code');
                    document.getElementById('deleteTierCode').value = tierCode;
                });
            });

            // Save tier button event
            document.getElementById('saveTierBtn').addEventListener('click', function() {
                const tierCode = document.getElementById('tierCode').value;
                const tierName = document.getElementById('tierName').value;
                
                // Here you would typically send the data to the server
                console.log('Saving tier:', { tierCode, tierName });
                
                // Close the modal
                document.getElementById('addTierModal').querySelector('.btn-close').click();
                
                // Reset form
                document.getElementById('addTierForm').reset();
                
                // Show success message (in a real app)
                alert('Tier saved successfully!');
            });

            // Update tier button event
            document.getElementById('updateTierBtn').addEventListener('click', function() {
                const tierCode = document.getElementById('editTierCode').value;
                const tierName = document.getElementById('editTierName').value;
                
                // Here you would typically send the data to the server
                console.log('Updating tier:', { tierCode, tierName });
                
                // Close the modal
                document.getElementById('editTierModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Tier updated successfully!');
            });

            // Delete tier button event
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const tierCode = document.getElementById('deleteTierCode').value;
                
                // Here you would typically send the data to the server
                console.log('Deleting tier:', tierCode);
                
                // Close the modal
                document.getElementById('deleteTierModal').querySelector('.btn-close').click();
                
                // Show success message (in a real app)
                alert('Tier deleted successfully!');
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
