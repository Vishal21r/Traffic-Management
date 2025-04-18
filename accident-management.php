<?php
include 'includes/header.php';
include 'includes/db_connect.php';

// Process status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accident_id']) && isset($_POST['status'])) {
    try {
        $id = (int)$_POST['accident_id'];
        $status = $_POST['status'];
        
        // Validate status
        if (!in_array($status, ['Reported', 'In Progress', 'Resolved'])) {
            throw new Exception("Invalid status value");
        }
        
        // Update the accident status
        $stmt = $pdo->prepare("UPDATE accidents SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        
        $successMessage = "Accident #$id status updated to $status successfully!";
    } catch (Exception $e) {
        $errorMessage = "Error updating status: " . $e->getMessage();
    }
}

// Fetch all accidents for management
try {
    $stmt = $pdo->query("SELECT * FROM accidents ORDER BY date DESC, time DESC");
    $accidents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorMessage = "Error retrieving accidents: " . $e->getMessage();
    $accidents = [];
}
?>

<main class="admin-main">
    <div class="container">
        <h1>Accident Management</h1>
        <p class="section-description">Review and update the status of accident reports in the system.</p>
        
        <?php if (isset($successMessage)): ?>
        <div class="alert alert-success">
            <?php echo $successMessage; ?>
        </div>
        <?php endif; ?>
        
        <?php if (isset($errorMessage)): ?>
        <div class="alert alert-error">
            <?php echo $errorMessage; ?>
        </div>
        <?php endif; ?>
        
        <div class="admin-panel">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date & Time</th>
                        <th>Location</th>
                        <th>Severity</th>
                        <th>Description</th>
                        <th>Current Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accidents as $accident): ?>
                    <tr>
                        <td><?php echo $accident['id']; ?></td>
                        <td><?php echo date('M d, Y H:i', strtotime($accident['date'] . ' ' . $accident['time'])); ?></td>
                        <td><?php echo htmlspecialchars($accident['location']); ?></td>
                        <td>
                            <span class="severity-badge <?php echo strtolower($accident['severity']); ?>">
                                <?php echo $accident['severity']; ?>
                            </span>
                        </td>
                        <td><?php echo substr(htmlspecialchars($accident['description']), 0, 100) . '...'; ?></td>
                        <td>
                            <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $accident['status'])); ?>">
                                <?php echo $accident['status']; ?>
                            </span>
                        </td>
                        <td>
                            <form method="post" class="status-update-form">
                                <input type="hidden" name="accident_id" value="<?php echo $accident['id']; ?>">
                                <select name="status" class="status-select">
                                    <option value="Reported" <?php echo $accident['status'] === 'Reported' ? 'selected' : ''; ?>>Reported</option>
                                    <option value="In Progress" <?php echo $accident['status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="Resolved" <?php echo $accident['status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if (count($accidents) === 0): ?>
                    <tr>
                        <td colspan="7" class="no-data">No accident reports found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<style>
/* Additional styles for the accident management page */
.admin-panel {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 20px;
    margin-top: 20px;
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

.data-table th {
    background-color: var(--secondary-color);
    font-weight: 600;
}

.severity-badge,
.status-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 20px;
    font-size: 0.8rem;
    text-align: center;
    color: white;
}

.severity-badge.minor {
    background-color: #10b981;
}

.severity-badge.moderate {
    background-color: #f59e0b;
}

.severity-badge.severe {
    background-color: #ef4444;
}

.status-badge.reported {
    background-color: #6b7280;
}

.status-badge.in-progress {
    background-color: #3b82f6;
}

.status-badge.resolved {
    background-color: #10b981;
}

.status-update-form {
    display: flex;
    gap: 5px;
}

.status-select {
    padding: 5px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: 0.9rem;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 0.9rem;
}

.no-data {
    text-align: center;
    color: var(--light-text);
    padding: 20px !important;
}
</style>

<?php include 'includes/footer.php'; ?>
