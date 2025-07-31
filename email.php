<?php 
// Include Gmail integration
if (file_exists('gmail-integration.php')) {
    require_once 'gmail-integration.php';
    $gmail = new GmailIntegration();
    
    // Check if user is authenticated
    $isAuthenticated = isset($_SESSION['gmail_access_token']);
    $authUrl = $gmail->getAuthUrl();
} else {
    $isAuthenticated = false;
    $authUrl = '#';
}

// Get emails if authenticated
$emails = [];
$emailCounts = [
    'inbox' => 0,
    'starred' => 0,
    'sent' => 0,
    'draft' => 0,
    'spam' => 0,
    'trash' => 0
];

if ($isAuthenticated && isset($gmail)) {
    try {
        $emailsData = $gmail->getEmails($_SESSION['gmail_access_token'], 20);
        if (isset($emailsData['messages'])) {
            foreach ($emailsData['messages'] as $message) {
                $emailDetails = $gmail->getEmailDetails($_SESSION['gmail_access_token'], $message->id);
                $headers = $gmail->parseEmailHeaders($emailDetails['payload']['headers']);
                
                $emails[] = [
                    'id' => $message->id,
                    'subject' => $headers['Subject'] ?? 'No Subject',
                    'from' => $headers['From'] ?? 'Unknown',
                    'date' => $headers['Date'] ?? '',
                    'snippet' => $emailDetails['snippet'] ?? '',
                    'isRead' => !in_array('UNREAD', $emailDetails['labelIds'] ?? []),
                    'isStarred' => in_array('STARRED', $emailDetails['labelIds'] ?? [])
                ];
            }
        }
    } catch (Exception $e) {
        // Handle error
        $error = "Error fetching emails: " . $e->getMessage();
    }
}

$script = '<script>
    // Email functionality
    document.addEventListener("DOMContentLoaded", function() {
        // Star email functionality
        document.querySelectorAll(".star-email").forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                this.classList.toggle("starred");
            });
        });
        
        // Email selection
        document.querySelectorAll(".email-checkbox").forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                updateEmailSelection();
            });
        });
        
        // Select all emails
        const selectAllElement = document.getElementById("selectAllEmails");
        if (selectAllElement) {
            selectAllElement.addEventListener("change", function() {
                const checkboxes = document.querySelectorAll(".email-checkbox");
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateEmailSelection();
            });
        }
        
        function updateEmailSelection() {
            const selectedEmails = document.querySelectorAll(".email-checkbox:checked");
            const deleteBtn = document.querySelector(".delete-selected");
            
            if (selectedEmails.length > 0) {
                deleteBtn.classList.remove("d-none");
            } else {
                deleteBtn.classList.add("d-none");
            }
        }
    });
    
    // Demo emails function
    function showDemoEmails() {
        const demoEmails = [
            {
                id: "demo1",
                from: "john.doe@example.com",
                subject: "Meeting Tomorrow",
                snippet: "Hi, just a reminder about our meeting tomorrow at 10 AM...",
                date: "2024-01-15",
                isRead: false,
                isStarred: true
            },
            {
                id: "demo2", 
                from: "sarah.smith@company.com",
                subject: "Project Update",
                snippet: "Here is the latest update on the project we discussed...",
                date: "2024-01-14",
                isRead: true,
                isStarred: false
            },
            {
                id: "demo3",
                from: "support@service.com", 
                subject: "Your Order #12345",
                snippet: "Thank you for your order. Your items will be shipped...",
                date: "2024-01-13",
                isRead: true,
                isStarred: false
            },
            {
                id: "demo4",
                from: "newsletter@tech.com",
                subject: "Weekly Tech News",
                snippet: "This week in tech: AI developments, new gadgets...",
                date: "2024-01-12", 
                isRead: false,
                isStarred: true
            }
        ];
        
        const emailList = document.querySelector(".email-list");
        if (emailList) {
            emailList.innerHTML = "";
            
            demoEmails.forEach(email => {
                const emailHtml = \`
                    <div class="email-item p-16 border-bottom \${!email.isRead ? \\'unread\\' : \\'\\'}" data-email-id="\${email.id}">
                        <div class="d-flex align-items-center gap-3">
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input email-checkbox radius-4 border input-form-dark" type="checkbox" value="\${email.id}">
                            </div>
                            <button class="btn btn-sm btn-link star-email p-0 \${email.isStarred ? \\'starred\\' : \\'\\'}">
                                <iconify-icon icon="ph:star\${email.isStarred ? \\'-fill\\' : \\'\\'}" class="text-warning"></iconify-icon>
                            </button>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar">
                                            <div class="w-32-px h-32-px bg-primary-600 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-white fw-semibold text-sm">
                                                    \${email.from.charAt(0).toUpperCase()}
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 \${!email.isRead ? \\'fw-bold\\' : \\'\\'}">
                                                \${email.from}
                                            </h6>
                                            <p class="mb-1 text-secondary-light">
                                                \${email.subject}
                                            </p>
                                            <p class="mb-0 text-secondary-light text-sm">
                                                \${email.snippet}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-secondary-light text-sm">
                                            \${new Date(email.date).toLocaleDateString("en-US", {month: "short", day: "numeric"})}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                \`;
                emailList.innerHTML += emailHtml;
            });
            
            // Update email counts
            document.querySelector(".fw-medium").textContent = demoEmails.length;
            document.querySelectorAll(".fw-medium")[1].textContent = demoEmails.filter(e => e.isStarred).length;
            
            // Reattach event listeners
            document.querySelectorAll(".star-email").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    this.classList.toggle("starred");
                });
            });
            
            document.querySelectorAll(".email-checkbox").forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    updateEmailSelection();
                });
            });
        }
    }
</script>';
?>

<?php include './partials/layouts/layoutTop.php' ?>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Email</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Email</li>
                </ul>
            </div>

            <?php if (!$isAuthenticated): ?>
            <!-- Gmail Connection Required -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <iconify-icon icon="mdi:gmail" class="text-6xl text-danger"></iconify-icon>
                            </div>
                            <h5 class="mb-3">Connect Your Gmail Account</h5>
                            <p class="text-secondary mb-4">To view your emails, please connect your Gmail account first.</p>
                            <p class="text-warning mb-3"><small>Note: Gmail API setup required. For demo, click "Show Demo Emails" below.</small></p>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="<?php echo $authUrl; ?>" class="btn btn-primary">
                                    <iconify-icon icon="mdi:gmail" class="me-2"></iconify-icon>
                                    Connect Gmail Account
                                </a>
                                <button type="button" class="btn btn-outline-primary" onclick="showDemoEmails()">
                                    <iconify-icon icon="mdi:email-outline" class="me-2"></iconify-icon>
                                    Show Demo Emails
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <!-- Email Interface -->
            <div class="row gy-4">
                <div class="col-xxl-3">
                    <div class="card h-100 p-0">
                        <div class="card-body p-24">
                            <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 w-100 radius-8 d-flex align-items-center gap-2 mb-16" data-bs-toggle="modal" data-bs-target="#composeModal">
                                <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>
                                Compose
                            </button>

                            <div class="mt-16">
                                <ul>
                                    <li class="item-active mb-4">
                                        <a href="email.php" class="bg-hover-primary-50 px-12 py-8 w-100 radius-8 text-secondary-light">
                                            <span class="d-flex align-items-center gap-10 justify-content-between w-100">
                                                <span class="d-flex align-items-center gap-10">
                                                    <span class="icon text-xxl line-height-1 d-flex">
                                                        <iconify-icon icon="uil:envelope" class="icon line-height-1"></iconify-icon>
                                                    </span>
                                                    <span class="fw-semibold">Inbox</span>
                                                </span>
                                                <span class="fw-medium"><?php echo count($emails); ?></span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="email.php?filter=starred" class="bg-hover-primary-50 px-12 py-8 w-100 radius-8 text-secondary-light">
                                            <span class="d-flex align-items-center gap-10 justify-content-between w-100">
                                                <span class="d-flex align-items-center gap-10">
                                                    <span class="icon text-xxl line-height-1 d-flex">
                                                        <iconify-icon icon="ph:star-bold" class="icon line-height-1"></iconify-icon>
                                                    </span>
                                                    <span class="fw-semibold">Starred</span>
                                                </span>
                                                <span class="fw-medium"><?php echo count(array_filter($emails, function($email) { return $email['isStarred']; })); ?></span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="email.php?filter=sent" class="bg-hover-primary-50 px-12 py-8 w-100 radius-8 text-secondary-light">
                                            <span class="d-flex align-items-center gap-10 justify-content-between w-100">
                                                <span class="d-flex align-items-center gap-10">
                                                    <span class="icon text-xxl line-height-1 d-flex">
                                                        <iconify-icon icon="ion:paper-plane-outline" class="icon line-height-1"></iconify-icon>
                                                    </span>
                                                    <span class="fw-semibold">Sent</span>
                                                </span>
                                                <span class="fw-medium">0</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="email.php?filter=draft" class="bg-hover-primary-50 px-12 py-8 w-100 radius-8 text-secondary-light">
                                            <span class="d-flex align-items-center gap-10 justify-content-between w-100">
                                                <span class="d-flex align-items-center gap-10">
                                                    <span class="icon text-xxl line-height-1 d-flex">
                                                        <iconify-icon icon="lucide:pencil" class="icon line-height-1"></iconify-icon>
                                                    </span>
                                                    <span class="fw-semibold">Draft</span>
                                                </span>
                                                <span class="fw-medium">0</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="email.php?filter=spam" class="bg-hover-primary-50 px-12 py-8 w-100 radius-8 text-secondary-light">
                                            <span class="d-flex align-items-center gap-10 justify-content-between w-100">
                                                <span class="d-flex align-items-center gap-10">
                                                    <span class="icon text-xxl line-height-1 d-flex">
                                                        <iconify-icon icon="ph:warning-bold" class="icon line-height-1"></iconify-icon>
                                                    </span>
                                                    <span class="fw-semibold">Spam</span>
                                                </span>
                                                <span class="fw-medium">0</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="email.php?filter=trash" class="bg-hover-primary-50 px-12 py-8 w-100 radius-8 text-secondary-light">
                                            <span class="d-flex align-items-center gap-10 justify-content-between w-100">
                                                <span class="d-flex align-items-center gap-10">
                                                    <span class="icon text-xxl line-height-1 d-flex">
                                                        <iconify-icon icon="material-symbols:delete-outline" class="icon line-height-1"></iconify-icon>
                                                    </span>
                                                    <span class="fw-semibold">Trash</span>
                                                </span>
                                                <span class="fw-medium">0</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-9">
                    <div class="card h-100 p-0 email-card">
                        <div class="card-header border-bottom bg-base py-16 px-24">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check style-check d-flex align-items-center">
                                        <input class="form-check-input radius-4 border input-form-dark" type="checkbox" name="checkbox" id="selectAllEmails">
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger delete-selected d-none">
                                        <iconify-icon icon="ri-delete-bin-line" class="me-1"></iconify-icon>
                                        Delete Selected
                                    </button>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <iconify-icon icon="ri-refresh-line"></iconify-icon>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <iconify-icon icon="ri-settings-3-line"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <?php if (empty($emails)): ?>
                            <div class="text-center py-5">
                                <iconify-icon icon="mdi:email-outline" class="text-4xl text-secondary mb-3"></iconify-icon>
                                <h6 class="text-secondary">No emails found</h6>
                                <p class="text-secondary-light">Your inbox is empty</p>
                            </div>
                            <?php else: ?>
                            <div class="email-list">
                                <?php foreach ($emails as $email): ?>
                                <div class="email-item p-16 border-bottom <?php echo !$email['isRead'] ? 'unread' : ''; ?>" data-email-id="<?php echo $email['id']; ?>">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input email-checkbox radius-4 border input-form-dark" type="checkbox" value="<?php echo $email['id']; ?>">
                                        </div>
                                        <button class="btn btn-sm btn-link star-email p-0 <?php echo $email['isStarred'] ? 'starred' : ''; ?>">
                                            <iconify-icon icon="ph:star<?php echo $email['isStarred'] ? '-fill' : ''; ?>" class="text-warning"></iconify-icon>
                                        </button>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar">
                                                        <div class="w-32-px h-32-px bg-primary-600 rounded-circle d-flex align-items-center justify-content-center">
                                                            <span class="text-white fw-semibold text-sm">
                                                                <?php echo strtoupper(substr($email['from'], 0, 1)); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 <?php echo !$email['isRead'] ? 'fw-bold' : ''; ?>">
                                                            <?php echo htmlspecialchars($email['from']); ?>
                                                        </h6>
                                                        <p class="mb-1 text-secondary-light">
                                                            <?php echo htmlspecialchars($email['subject']); ?>
                                                        </p>
                                                        <p class="mb-0 text-secondary-light text-sm">
                                                            <?php echo htmlspecialchars($email['snippet']); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-secondary-light text-sm">
                                                        <?php echo date('M j', strtotime($email['date'])); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Compose Email Modal -->
        <div class="modal fade" id="composeModal" tabindex="-1" aria-labelledby="composeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="composeModalLabel">Compose Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="to" class="form-label">To</label>
                                <input type="email" class="form-control" id="to" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="10" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Send Email</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .email-item {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            
            .email-item:hover {
                background-color: #f8f9fa;
            }
            
            .email-item.unread {
                background-color: #e3f2fd;
                border-left: 3px solid #2196f3;
            }
            
            .star-email.starred {
                color: #ffc107 !important;
            }
            
            .delete-selected {
                transition: all 0.3s ease;
            }
        </style>

<?php include './partials/layouts/layoutBottom.php' ?>