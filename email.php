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

// Debug information
$debug = [];
$debug['gmail_exists'] = file_exists('gmail-integration.php');
$debug['gmail_configured'] = isset($gmail) ? $gmail->isConfigured() : false;
$debug['is_authenticated'] = $isAuthenticated;
$debug['session_token'] = isset($_SESSION['gmail_access_token']) ? 'exists' : 'not exists';

if ($isAuthenticated && isset($gmail)) {
    try {
        $emailsData = $gmail->getEmails($_SESSION['gmail_access_token'], 20);
        $debug['emails_data'] = $emailsData ? 'success' : 'failed';
        
        if (isset($emailsData['messages']) && is_array($emailsData['messages'])) {
            foreach ($emailsData['messages'] as $message) {
                // Check if message is object or array
                $messageId = is_object($message) ? $message->id : $message['id'];
                
                $emailDetails = $gmail->getEmailDetails($_SESSION['gmail_access_token'], $messageId);
                
                // Check if emailDetails is valid
                if ($emailDetails && isset($emailDetails['payload']) && isset($emailDetails['payload']['headers'])) {
                    $headers = $gmail->parseEmailHeaders($emailDetails['payload']['headers']);
                    
                    $emails[] = [
                        'id' => $messageId,
                        'subject' => $headers['Subject'] ?? 'No Subject',
                        'from' => $headers['From'] ?? 'Unknown',
                        'date' => $headers['Date'] ?? '',
                        'snippet' => $emailDetails['snippet'] ?? '',
                        'isRead' => !in_array('UNREAD', $emailDetails['labelIds'] ?? []),
                        'isStarred' => in_array('STARRED', $emailDetails['labelIds'] ?? [])
                    ];
                } else {
                    $debug['error'] = 'Invalid email details structure';
                }
            }
        } else {
            $debug['error'] = 'No messages found or invalid structure';
        }
    } catch (Exception $e) {
        // Handle error
        $error = "Error fetching emails: " . $e->getMessage();
        $debug['error'] = $e->getMessage();
    }
}
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
                            <h5 class="mb-3">Email Dashboard</h5>
                            <p class="text-secondary mb-4">Welcome to your email dashboard. You can view demo emails or connect your Gmail account.</p>
                            
                            <?php if (isset($gmail) && $gmail->isConfigured()): ?>
                            <p class="text-info mb-3"><small>Gmail API is configured. You can connect your Gmail account.</small></p>
                            
                            <!-- Debug Information (remove in production) -->
                            <div class="alert alert-info mb-3">
                                <h6><iconify-icon icon="mdi:bug" class="me-2"></iconify-icon>Debug Info:</h6>
                                <small>
                                    Gmail File: <?php echo $debug['gmail_exists'] ? '✓' : '✗'; ?><br>
                                    Gmail Configured: <?php echo $debug['gmail_configured'] ? '✓' : '✗'; ?><br>
                                    Authenticated: <?php echo $debug['is_authenticated'] ? '✓' : '✗'; ?><br>
                                    Session Token: <?php echo $debug['session_token']; ?><br>
                                    <?php if (isset($debug['emails_data'])): ?>
                                    Emails Data: <?php echo $debug['emails_data']; ?><br>
                                    <?php endif; ?>
                                    <?php if (isset($debug['error'])): ?>
                                    Error: <?php echo $debug['error']; ?><br>
                                    <?php endif; ?>
                                    <?php if (isset($error)): ?>
                                    <strong>PHP Error:</strong> <?php echo $error; ?><br>
                                    <?php endif; ?>
                                </small>
                            </div>
                            
                            <?php if (isset($debug['error']) || isset($error)): ?>
                            <div class="alert alert-warning mb-3">
                                <h6><iconify-icon icon="mdi:alert" class="me-2"></iconify-icon>Gmail Connection Issue</h6>
                                <p class="mb-2">There seems to be an issue with the Gmail connection. You can:</p>
                                <ul class="mb-0">
                                    <li>Try connecting again by clicking "Connect Gmail Account"</li>
                                    <li>Use demo emails by clicking "Show Demo Emails"</li>
                                    <li>Check your Gmail API configuration</li>
                                </ul>
                            </div>
                            <?php endif; ?>
                            
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
                            <?php else: ?>
                            <p class="text-warning mb-3"><small>Gmail API not configured. Using demo mode.</small></p>
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="button" class="btn btn-primary" onclick="showDemoEmails()">
                                    <iconify-icon icon="mdi:email-outline" class="me-2"></iconify-icon>
                                    Show Demo Emails
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="showGmailSetup()">
                                    <iconify-icon icon="mdi:cog" class="me-2"></iconify-icon>
                                    Setup Gmail API
                                </button>
                            </div>
                            <?php endif; ?>
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

        <script>
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
                        const unreadClass = !email.isRead ? 'unread' : '';
                        const starredClass = email.isStarred ? 'starred' : '';
                        const boldClass = !email.isRead ? 'fw-bold' : '';
                        const starIcon = email.isStarred ? '-fill' : '';
                        const avatar = email.from.charAt(0).toUpperCase();
                        const date = new Date(email.date).toLocaleDateString("en-US", {month: "short", day: "numeric"});
                        
                        const emailHtml = "<div class=\"email-item p-16 border-bottom " + unreadClass + "\" data-email-id=\"" + email.id + "\">" +
                            "<div class=\"d-flex align-items-center gap-3\">" +
                                "<div class=\"form-check style-check d-flex align-items-center\">" +
                                    "<input class=\"form-check-input email-checkbox radius-4 border input-form-dark\" type=\"checkbox\" value=\"" + email.id + "\">" +
                                "</div>" +
                                "<button class=\"btn btn-sm btn-link star-email p-0 " + starredClass + "\">" +
                                    "<iconify-icon icon=\"ph:star" + starIcon + "\" class=\"text-warning\"></iconify-icon>" +
                                "</button>" +
                                "<div class=\"flex-grow-1\">" +
                                    "<div class=\"d-flex align-items-center justify-content-between\">" +
                                        "<div class=\"d-flex align-items-center gap-3\">" +
                                            "<div class=\"avatar\">" +
                                                "<div class=\"w-32-px h-32-px bg-primary-600 rounded-circle d-flex align-items-center justify-content-center\">" +
                                                    "<span class=\"text-white fw-semibold text-sm\">" + avatar + "</span>" +
                                                "</div>" +
                                            "</div>" +
                                            "<div>" +
                                                "<h6 class=\"mb-1 " + boldClass + "\">" + email.from + "</h6>" +
                                                "<p class=\"mb-1 text-secondary-light\">" + email.subject + "</p>" +
                                                "<p class=\"mb-0 text-secondary-light text-sm\">" + email.snippet + "</p>" +
                                            "</div>" +
                                        "</div>" +
                                        "<div class=\"text-end\">" +
                                            "<span class=\"text-secondary-light text-sm\">" + date + "</span>" +
                                        "</div>" +
                                    "</div>" +
                                "</div>" +
                            "</div>" +
                        "</div>";
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
            
            // Gmail API Setup function
            function showGmailSetup() {
                const setupHtml = `
                    <div class="modal fade" id="gmailSetupModal" tabindex="-1" aria-labelledby="gmailSetupModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="gmailSetupModalLabel">Setup Gmail API</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-info">
                                        <h6><iconify-icon icon="mdi:information" class="me-2"></iconify-icon>Setup Instructions</h6>
                                        <p class="mb-0">To connect your Gmail account, you need to configure the Gmail API first.</p>
                                    </div>
                                    
                                    <h6 class="mt-4">Step 1: Create Google Cloud Project</h6>
                                    <ol>
                                        <li>Go to <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></li>
                                        <li>Create a new project or select existing project</li>
                                        <li>Enable Gmail API for your project</li>
                                    </ol>
                                    
                                    <h6 class="mt-4">Step 2: Create OAuth 2.0 Credentials</h6>
                                    <ol>
                                        <li>Go to "APIs & Services" > "Credentials"</li>
                                        <li>Click "Create Credentials" > "OAuth 2.0 Client IDs"</li>
                                        <li>Set Application Type to "Web application"</li>
                                        <li>Add Authorized redirect URI: <code>http://localhost/Ultimate-Dashboard/wowdash-php/gmail-callback.php</code></li>
                                        <li>Copy the Client ID and Client Secret</li>
                                    </ol>
                                    
                                    <h6 class="mt-4">Step 3: Update Configuration</h6>
                                    <ol>
                                        <li>Open file: <code>wowdash-php/gmail-integration.php</code></li>
                                        <li>Replace the placeholder values:</li>
                                        <ul>
                                            <li><code>clientId</code> with your actual Client ID</li>
                                            <li><code>clientSecret</code> with your actual Client Secret</li>
                                        </ul>
                                    </ol>
                                    
                                    <div class="alert alert-warning mt-3">
                                        <small><strong>Note:</strong> This is for development only. For production, use proper environment variables and security measures.</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="https://console.cloud.google.com/" target="_blank" class="btn btn-primary">
                                        <iconify-icon icon="mdi:google" class="me-2"></iconify-icon>
                                        Go to Google Cloud Console
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Remove existing modal if any
                const existingModal = document.getElementById('gmailSetupModal');
                if (existingModal) {
                    existingModal.remove();
                }
                
                // Add modal to body
                document.body.insertAdjacentHTML('beforeend', setupHtml);
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('gmailSetupModal'));
                modal.show();
            }
        </script>

<?php include './partials/layouts/layoutBottom.php' ?>