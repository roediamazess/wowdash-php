<?php
require_once './partials/db_connection.php';

// --- HANDLE DELETE ---
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_to_delete = $conn->real_escape_string($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM customers WHERE customer_id = ?");
    $stmt->bind_param("s", $id_to_delete);
    if ($stmt->execute()) {
        header("Location: customer.php?status=deleted");
        exit();
    } else {
        // Handle error, e.g., show an error message
    }
    $stmt->close();
}

// --- HANDLE POST REQUESTS (ADD / UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and retrieve common POST data
    $customer_id = $conn->real_escape_string($_POST['customer_id']);
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $customer_star = (int)$_POST['customer_star'];
    $customer_room = (int)$_POST['customer_room'];
    $customer_outlet = (int)$_POST['customer_outlet'];
    $customer_type = $conn->real_escape_string($_POST['customer_type']);
    $customer_group = $conn->real_escape_string($_POST['customer_group']);
    $customer_zone = $conn->real_escape_string($_POST['customer_zone']);
    $customer_address = $conn->real_escape_string($_POST['customer_address']);
    $billing = $conn->real_escape_string($_POST['billing']);

    // --- HANDLE UPDATE ---
    if (isset($_POST['update_customer'])) {
        $original_customer_id = $conn->real_escape_string($_POST['original_customer_id']);
        $stmt = $conn->prepare("UPDATE customers SET customer_id = ?, customer_name = ?, customer_star = ?, customer_room = ?, customer_outlet = ?, customer_type = ?, customer_group = ?, customer_zone = ?, customer_address = ?, billing = ? WHERE customer_id = ?");
        $stmt->bind_param("ssiiissssss", $customer_id, $customer_name, $customer_star, $customer_room, $customer_outlet, $customer_type, $customer_group, $customer_zone, $customer_address, $billing, $original_customer_id);
        
        if ($stmt->execute()) {
            header("Location: customer.php?status=updated");
            exit();
        } else {
            // Handle error
        }
        $stmt->close();
    }
    
    // --- HANDLE ADD ---
    if (isset($_POST['add_customer'])) {
        $stmt = $conn->prepare("INSERT INTO customers (customer_id, customer_name, customer_star, customer_room, customer_outlet, customer_type, customer_group, customer_zone, customer_address, billing) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiisssss", $customer_id, $customer_name, $customer_star, $customer_room, $customer_outlet, $customer_type, $customer_group, $customer_zone, $customer_address, $billing);

        if ($stmt->execute()) {
            header("Location: customer.php?status=success");
            exit();
        } else {
            // Handle error
        }
        $stmt->close();
    }
}

include './partials/layouts/layoutTop.php';
?>

<style>
    .customer-star { color: #ffc107; font-size: 1.1rem; }
</style>

<div class="dashboard-main-body">
    <!-- Breadcrumb -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Customer</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon> Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Customer</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h5 class="card-title fw-semibold mb-0">Daftar Pelanggan</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal" id="addCustomerBtn">
                Tambah Pelanggan Baru
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Name</th><th>Star</th><th>Room</th><th>Outlet</th><th>Type</th><th>Group</th><th>Zone</th><th>Billing</th><th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_select = "SELECT * FROM customers ORDER BY created_at DESC";
                        $result = $conn->query($sql_select);

                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row["customer_id"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["customer_name"]); ?></td>
                                    <td class='customer-star'>
                                        <?php for ($i = 0; $i < $row["customer_star"]; $i++) { echo '<iconify-icon icon="solar:star-bold"></iconify-icon>'; } ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row["customer_room"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["customer_outlet"]); ?></td>
                                    <td><span class='badge bg-info'><?php echo htmlspecialchars($row["customer_type"]); ?></span></td>
                                    <td><?php echo htmlspecialchars($row["customer_group"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["customer_zone"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["billing"]); ?></td>
                                    <td class='text-center'>
                                        <button type='button' class='btn btn-sm btn-outline-secondary border-0 editBtn' 
                                            data-bs-toggle='modal' data-bs-target='#customerModal'
                                            data-id='<?php echo htmlspecialchars($row['customer_id']); ?>'
                                            data-name='<?php echo htmlspecialchars($row['customer_name']); ?>'
                                            data-star='<?php echo htmlspecialchars($row['customer_star']); ?>'
                                            data-room='<?php echo htmlspecialchars($row['customer_room']); ?>'
                                            data-outlet='<?php echo htmlspecialchars($row['customer_outlet']); ?>'
                                            data-type='<?php echo htmlspecialchars($row['customer_type']); ?>'
                                            data-group='<?php echo htmlspecialchars($row['customer_group']); ?>'
                                            data-zone='<?php echo htmlspecialchars($row['customer_zone']); ?>'
                                            data-address='<?php echo htmlspecialchars($row['customer_address']); ?>'
                                            data-billing='<?php echo htmlspecialchars($row['billing']); ?>'>
                                            <iconify-icon icon='uil:edit'></iconify-icon>
                                        </button>
                                        <a href='customer.php?action=delete&id=<?php echo htmlspecialchars($row['customer_id']); ?>' class='btn btn-sm btn-outline-danger border-0' onclick='return confirm("Are you sure you want to delete this customer?");'>
                                            <iconify-icon icon='uil:trash-alt'></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center'>No customers found. Please add a new customer.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="customerForm" action="customer.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="original_customer_id" name="original_customer_id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customerId" class="form-label">Customer ID</label>
                            <input type="text" class="form-control" id="customerId" name="customer_id" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customerName" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customerName" name="customer_name" required>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customerStar" class="form-label">Customer Star (1-6)</label>
                            <select class="form-select" id="customerStar" name="customer_star">
                                <option value="0" selected>Choose star...</option>
                                <option value="1">1 Star</option><option value="2">2 Stars</option><option value="3">3 Stars</option><option value="4">4 Stars</option><option value="5">5 Stars</option><option value="6">6 Stars</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="customerRoom" class="form-label">Rooms</label>
                            <input type="number" class="form-control" id="customerRoom" name="customer_room">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="customerOutlet" class="form-label">Outlets</label>
                            <input type="number" class="form-control" id="customerOutlet" name="customer_outlet">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customerType" class="form-label">Customer Type</label>
                            <select class="form-select" id="customerType" name="customer_type" required>
                                <option value="" selected>Choose type...</option>
                                <option value="Hotel">Hotel</option><option value="Restaurant">Restaurant</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                             <label for="billing" class="form-label">Billing</label>
                            <select class="form-select" id="billing" name="billing" required>
                                <option value="" selected>Choose billing...</option>
                                <option value="Contract Maintenance">Contract Maintenance</option><option value="Subscription">Subscription</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customerGroup" class="form-label">Customer Group</label>
                            <input type="text" class="form-control" id="customerGroup" name="customer_group">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customerZone" class="form-label">Customer Zone</label>
                            <input type="text" class="form-control" id="customerZone" name="customer_zone">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="customerAddress" class="form-label">Customer Address</label>
                        <textarea class="form-control" id="customerAddress" name="customer_address" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="submitBtn" name="add_customer" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
$conn->close();
include './partials/layouts/layoutBottom.php' 
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const customerModal = document.getElementById('customerModal');
    const customerForm = document.getElementById('customerForm');
    const modalLabel = document.getElementById('customerModalLabel');
    const submitBtn = document.getElementById('submitBtn');

    // Handle Edit Button Clicks
    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', function () {
            modalLabel.textContent = 'Edit Pelanggan';
            submitBtn.textContent = 'Simpan Perubahan';
            submitBtn.name = 'update_customer';

            const data = this.dataset;
            document.getElementById('original_customer_id').value = data.id;
            document.getElementById('customerId').value = data.id;
            document.getElementById('customerName').value = data.name;
            document.getElementById('customerStar').value = data.star;
            document.getElementById('customerRoom').value = data.room;
            document.getElementById('customerOutlet').value = data.outlet;
            document.getElementById('customerType').value = data.type;
            document.getElementById('customerGroup').value = data.group;
            document.getElementById('customerZone').value = data.zone;
            document.getElementById('customerAddress').value = data.address;
            document.getElementById('billing').value = data.billing;
        });
    });

    // Handle Add Button Click (Reset Modal)
    document.getElementById('addCustomerBtn').addEventListener('click', function() {
        modalLabel.textContent = 'Tambah Pelanggan Baru';
        submitBtn.textContent = 'Simpan';
        submitBtn.name = 'add_customer';
        
        customerForm.reset();
        document.getElementById('original_customer_id').value = '';
    });
});
</script>
