<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Project Type</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Project Type</li>
                </ul>
            </div>

            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <h5 class="card-title mb-0">Project Type Management</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTypeModal">
                                    <iconify-icon icon="akar-icons:plus" class="me-1"></iconify-icon>
                                    Add New Type
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table bordered-table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project ID</th>
                                            <th scope="col">Project Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="type-row" data-type-id="Implementation" data-type-name="Implementation">
                                            <td>Implementation</td>
                                            <td>Implementation</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="Upgrade" data-type-name="Upgrade">
                                            <td>Upgrade</td>
                                            <td>Upgrade</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="Maintenance" data-type-name="Maintenance">
                                            <td>Maintenance</td>
                                            <td>Maintenance</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="Retraining" data-type-name="Retraining">
                                            <td>Retraining</td>
                                            <td>Retraining</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="On Line Maintenance" data-type-name="On Line Maintenance">
                                            <td>On Line Maintenance</td>
                                            <td>On Line Maintenance</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="Remote Installation" data-type-name="Remote Installation">
                                            <td>Remote Installation</td>
                                            <td>Remote Installation</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="On Line Training" data-type-name="On Line Training">
                                            <td>On Line Training</td>
                                            <td>On Line Training</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="In House Training" data-type-name="In House Training">
                                            <td>In House Training</td>
                                            <td>In House Training</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="Special Request" data-type-name="Special Request">
                                            <td>Special Request</td>
                                            <td>Special Request</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="2nd Implementation" data-type-name="2nd Implementation">
                                            <td>2nd Implementation</td>
                                            <td>2nd Implementation</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="Others" data-type-name="Others">
                                            <td>Others</td>
                                            <td>Others</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="Jakarta Support" data-type-name="Jakarta Support">
                                            <td>Jakarta Support</td>
                                            <td>Jakarta Support</td>
                                        </tr>
                                        <tr class="type-row" data-type-id="Bali Support" data-type-name="Bali Support">
                                            <td>Bali Support</td>
                                            <td>Bali Support</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Type Modal -->
        <div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="addTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTypeModalLabel">Add New Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addTypeForm">
                            <div class="mb-3">
                                <label for="typeId" class="form-label">Project ID</label>
                                <input type="text" class="form-control" id="typeId" required>
                            </div>
                            <div class="mb-3">
                                <label for="typeName" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="typeName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveTypeBtn">Save Type</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Type Detail Modal -->
        <div class="modal fade" id="typeDetailModal" tabindex="-1" aria-labelledby="typeDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="typeDetailModalLabel">Type Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Project ID</label>
                                    <p class="mb-0" id="detailTypeId"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Project Name</label>
                                    <p class="mb-0" id="detailTypeName"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="editTypeBtn">Edit</button>
                        <button type="button" class="btn btn-danger" id="deleteTypeBtn">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Type Modal -->
        <div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="editTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTypeModalLabel">Edit Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTypeForm">
                            <input type="hidden" id="editTypeId">
                            <div class="mb-3">
                                <label for="editTypeName" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="editTypeName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="updateTypeBtn">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Hover effects for type rows */
            .type-row {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            
            .type-row:hover {
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
                const addTypeModal = new bootstrap.Modal(document.getElementById('addTypeModal'));
                const typeDetailModal = new bootstrap.Modal(document.getElementById('typeDetailModal'));
                const editTypeModal = new bootstrap.Modal(document.getElementById('editTypeModal'));

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

                // Row click event to show type details
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.type-row')) {
                        const row = e.target.closest('.type-row');
                        
                        // Populate detail modal
                        document.getElementById('detailTypeId').textContent = row.dataset.typeId;
                        document.getElementById('detailTypeName').textContent = row.dataset.typeName;
                        
                        // Store current type data for edit/delete
                        window.currentTypeData = {
                            typeId: row.dataset.typeId,
                            typeName: row.dataset.typeName
                        };
                        
                        typeDetailModal.show();
                    }
                });

                // Edit type button in detail modal
                document.getElementById('editTypeBtn').addEventListener('click', function() {
                    if (window.currentTypeData) {
                        document.getElementById('editTypeId').value = window.currentTypeData.typeId;
                        document.getElementById('editTypeName').value = window.currentTypeData.typeName;
                        
                        typeDetailModal.hide();
                        editTypeModal.show();
                    }
                });

                // Delete type button in detail modal
                document.getElementById('deleteTypeBtn').addEventListener('click', function() {
                    if (window.currentTypeData) {
                        const typeId = window.currentTypeData.typeId;

                        Swal.fire({
                            title: `Are you sure you want to delete type "${typeId}"?`,
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Here you would typically send the data to the server
                                console.log('Deleting type:', typeId);
                                
                                showToast('Type deleted successfully!');
                                typeDetailModal.hide();
                                
                                // Remove the row from table
                                const row = document.querySelector(`[data-type-id="${typeId}"]`);
                                if (row) row.remove();
                            }
                        });
                    }
                });

                // Save type button event
                document.getElementById('saveTypeBtn').addEventListener('click', function() {
                    const typeId = document.getElementById('typeId').value;
                    const typeName = document.getElementById('typeName').value;
                    
                    // Here you would typically send the data to the server
                    console.log('Saving type:', { typeId, typeName });
                    
                    showToast('Type saved successfully!');
                    addTypeModal.hide();
                    document.getElementById('addTypeForm').reset();
                });

                // Update type button event
                document.getElementById('updateTypeBtn').addEventListener('click', function() {
                    const typeId = document.getElementById('editTypeId').value;
                    const typeName = document.getElementById('editTypeName').value;
                    
                    // Here you would typically send the data to the server
                    console.log('Updating type:', { typeId, typeName });
                    
                    showToast('Type updated successfully!');
                    editTypeModal.hide();
                    
                    // Update the row in table
                    const row = document.querySelector(`[data-type-id="${typeId}"]`);
                    if (row) {
                        row.dataset.typeName = typeName;
                        row.querySelector('td:last-child').textContent = typeName;
                    }
                });
            });
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>
