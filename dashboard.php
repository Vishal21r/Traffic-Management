<?php
include 'includes/header.php';
include 'includes/db_connect.php';

// Fetch traffic data for the dashboard
try {
    $stmt = $pdo->query("SELECT * FROM traffic_data ORDER BY timestamp DESC LIMIT 100");
    $trafficData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM accidents WHERE status = 'Reported'");
    $activeIncidents = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Prepare data for charts
    $labels = [];
    $trafficCounts = [];
    $congestionData = [];
    
    foreach ($trafficData as $data) {
        $labels[] = date('H:i', strtotime($data['timestamp']));
        $trafficCounts[] = $data['traffic_count'];
        
        // Assign numeric values to congestion levels
        switch ($data['congestion_level']) {
            case 'Low':
                $congestionData[] = 1;
                break;
            case 'Medium':
                $congestionData[] = 2;
                break;
            case 'High':
                $congestionData[] = 3;
                break;
            default:
                $congestionData[] = 0;
        }
    }
    
    // Convert data to JSON for JavaScript
    $labelsJSON = json_encode($labels);
    $trafficCountsJSON = json_encode($trafficCounts);
    $congestionDataJSON = json_encode($congestionData);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<main class="dashboard-main">
    <div class="container">
        <h1>Live Traffic Dashboard</h1>
        <p class="dashboard-description">Monitor congestion data, accident reports, and traffic flow in real-time across the city.</p>
        
        <div class="dashboard-grid">
            <div class="dashboard-card traffic-chart-card">
                <h2>Traffic Flow & Congestion Levels</h2>
                <div class="chart-container">
                    <canvas id="trafficFlowChart"></canvas>
                </div>
            </div>
            
            <div class="dashboard-card metrics-card">
                <h2>Current Metrics</h2>
                <div class="metrics-grid">
                    <div class="metric">
                        <h3><?php echo $activeIncidents; ?></h3>
                        <p>Active Incident Alerts</p>
                        <div class="metric-icon warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="metric">
                        <h3>27 mph</h3>
                        <p>Average Traffic Speed</p>
                        <div class="metric-icon neutral">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                    </div>
                    <div class="metric">
                        <h3>Medium</h3>
                        <p>Overall Congestion</p>
                        <div class="metric-icon caution">
                            <i class="fas fa-car"></i>
                        </div>
                    </div>
                    <div class="metric">
                        <h3>15 min</h3>
                        <p>Avg. Delay Downtown</p>
                        <div class="metric-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-card heatmap-card">
                <h2>Traffic Congestion Heatmap</h2>
                <div class="heatmap-container" id="trafficHeatmap">
                    <!-- Heatmap will be rendered by JavaScript -->
                </div>
                <div class="heatmap-legend">
                    <span class="legend-item low">Low</span>
                    <span class="legend-item medium">Medium</span>
                    <span class="legend-item high">High</span>
                </div>
            </div>
            
            <div class="dashboard-card incidents-card">
                <h2>Recent Incidents</h2>
                <div class="incidents-list">
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT * FROM accidents ORDER BY created_at DESC LIMIT 5");
                        $incidents = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (count($incidents) > 0) {
                            foreach ($incidents as $incident) {
                                $severityClass = strtolower($incident['severity']);
                                echo '<div class="incident-item">';
                                echo '<div class="incident-severity ' . $severityClass . '">' . $incident['severity'] . '</div>';
                                echo '<div class="incident-details">';
                                echo '<h4>' . htmlspecialchars($incident['location']) . '</h4>';
                                echo '<p>' . date('F j, Y g:i A', strtotime($incident['date'] . ' ' . $incident['time'])) . '</p>';
                                echo '<p>' . htmlspecialchars(substr($incident['description'], 0, 100)) . '...</p>';
                                echo '</div>';
                                echo '<div class="incident-status">' . $incident['status'] . '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No recent incidents reported.</p>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </div>
                <a href="accident-report.php" class="btn btn-primary">Report New Incident</a>
            </div>
        </div>
    </div>
</main>

<script>
// Pass PHP data to JavaScript
const trafficLabels = <?php echo $labelsJSON; ?>;
const trafficCounts = <?php echo $trafficCountsJSON; ?>;
const congestionData = <?php echo $congestionDataJSON; ?>;
</script>

<?php include 'includes/footer.php'; ?>
