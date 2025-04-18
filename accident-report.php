<?php
include 'includes/header.php';
include 'includes/db_connect.php';

$successMessage = '';
$errorMessage = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate and sanitize inputs
        $location = htmlspecialchars($_POST['location'] ?? '');
        $date = htmlspecialchars($_POST['date'] ?? '');
        $time = htmlspecialchars($_POST['time'] ?? '');
        $description = htmlspecialchars($_POST['description'] ?? '');
        $severity = htmlspecialchars($_POST['severity'] ?? '');
        $reporterName = htmlspecialchars($_POST['reporter_name'] ?? '');
        $reporterContact = htmlspecialchars($_POST['reporter_contact'] ?? '');
        
        // Basic validation
        if (empty($location) || empty($date) || empty($time) || empty($description) || empty($severity)) {
            $errorMessage = "Please fill in all required fields.";
        } else {
            // Handle video upload if present
            $videoUrl = '';
            if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/videos/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = uniqid() . '_' . basename($_FILES['video']['name']);
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['video']['tmp_name'], $targetFile)) {
                    $videoUrl = $targetFile;
                }
            }
            
            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO accidents (location, date, time, description, severity, reporter_name, reporter_contact, video_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->execute([$location, $date, $time, $description, $severity, $reporterName, $reporterContact, $videoUrl]);
            
            $successMessage = "Accident report submitted successfully. Thank you for contributing to safer roads.";
            
            // Clear form data after successful submission
            $_POST = [];
        }
    } catch (PDOException $e) {
        $errorMessage = "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<main class="accident-report-main">
    <div class="container">
        <h1>Report an Accident</h1>
        <p class="section-description">Help improve road safety by reporting accidents and hazards you encounter.</p>
        
        <?php if ($successMessage): ?>
        <div class="alert alert-success">
            <?php echo $successMessage; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($errorMessage): ?>
        <div class="alert alert-error">
            <?php echo $errorMessage; ?>
        </div>
        <?php endif; ?>
        
        <div class="accident-form-container">
            <form action="accident-report.php" method="post" enctype="multipart/form-data" class="accident-form">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="location">Location*</label>
                        <input type="text" id="location" name="location" required placeholder="e.g., Main St & 5th Ave" value="<?php echo $_POST['location'] ?? ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="date">Date*</label>
                        <input type="date" id="date" name="date" required value="<?php echo $_POST['date'] ?? date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="time">Time*</label>
                        <input type="time" id="time" name="time" required value="<?php echo $_POST['time'] ?? date('H:i'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="severity">Severity*</label>
                        <select id="severity" name="severity" required>
                            <option value="">Select Severity</option>
                            <option value="Minor" <?php echo (isset($_POST['severity']) && $_POST['severity'] === 'Minor') ? 'selected' : ''; ?>>Minor</option>
                            <option value="Moderate" <?php echo (isset($_POST['severity']) && $_POST['severity'] === 'Moderate') ? 'selected' : ''; ?>>Moderate</option>
                            <option value="Severe" <?php echo (isset($_POST['severity']) && $_POST['severity'] === 'Severe') ? 'selected' : ''; ?>>Severe</option>
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="description">Description*</label>
                        <textarea id="description" name="description" rows="4" required placeholder="Describe what happened, including any relevant details about the accident or hazard..."><?php echo $_POST['description'] ?? ''; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="reporter_name">Your Name (Optional)</label>
                        <input type="text" id="reporter_name" name="reporter_name" value="<?php echo $_POST['reporter_name'] ?? ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="reporter_contact">Contact Info (Optional)</label>
                        <input type="text" id="reporter_contact" name="reporter_contact" placeholder="Email or phone number" value="<?php echo $_POST['reporter_contact'] ?? ''; ?>">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="video">Upload Video Evidence (Optional)</label>
                        <div class="file-upload">
                            <input type="file" id="video" name="video" accept="video/*">
                            <div class="upload-preview" id="videoPreview">
                                <p>No video selected</p>
                                <button type="button" class="btn btn-outline">Choose File</button>
                            </div>
                        </div>
                        <p class="form-help">You can upload a video of the accident or hazard if available. Maximum size: 50MB.</p>
                    </div>
                </div>
                
                <div class="form-notice">
                    <p>This is an anonymous reporting system. Personal details are optional.</p>
                    <p>* Required fields</p>
                </div>
                
                <div class="form-actions">
                    <button type="reset" class="btn btn-outline">Reset Form</button>
                    <button type="submit" class="btn btn-primary">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
