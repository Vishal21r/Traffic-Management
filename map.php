<?php include 'includes/header.php'; ?>

<main class="map-main">
    <div class="container">
        <h1>Traffic Map</h1>
        <p class="section-description">View real-time traffic conditions and incidents on an interactive map.</p>
        
        <div class="map-container">
            <div id="trafficMap"></div>
            <div class="map-controls">
                <div class="control-group">
                    <h3>Display Options</h3>
                    <label><input type="checkbox" id="showTraffic" checked> Show Traffic</label>
                    <label><input type="checkbox" id="showIncidents" checked> Show Incidents</label>
                    <label><input type="checkbox" id="showCameras"> Show Traffic Cameras</label>
                </div>
                <div class="control-group">
                    <h3>Traffic Filters</h3>
                    <label><input type="checkbox" id="filterLow" checked> Low Congestion</label>
                    <label><input type="checkbox" id="filterMedium" checked> Medium Congestion</label>
                    <label><input type="checkbox" id="filterHigh" checked> High Congestion</label>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create the map
    const map = L.map('trafficMap').setView([31.2429, 75.7016], 14);
    
    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Sample traffic data points
    const trafficPoints = [
        { lat: 40.7128, lng: -74.0060, congestion: 'High', count: 230 },
        { lat: 40.7200, lng: -74.0100, congestion: 'Medium', count: 150 },
        { lat: 40.7150, lng: -73.9900, congestion: 'Low', count: 80 },
        // Add more sample points
    ];
    
    // Sample incident data
    const incidents = [
        { lat: 40.7140, lng: -74.0050, type: 'Accident', severity: 'Moderate', description: 'Two-car collision' },
        { lat: 40.7220, lng: -74.0080, type: 'Construction', severity: 'Minor', description: 'Lane closure' },
        // Add more incidents
    ];
    
    // Display traffic points
    trafficPoints.forEach(point => {
        let color;
        switch(point.congestion) {
            case 'Low': color = '#10b981'; break;
            case 'Medium': color = '#f59e0b'; break;
            case 'High': color = '#ef4444'; break;
            default: color = '#3b82f6';
        }
        
        const circle = L.circle([point.lat, point.lng], {
            color: color,
            fillColor: color,
            fillOpacity: 0.5,
            radius: point.count / 2 // Size based on traffic count
        }).addTo(map);
        
        circle.bindPopup(`<b>${point.congestion} Traffic</b><br>Vehicle count: ${point.count}`);
    });
    
    // Display incidents
    incidents.forEach(incident => {
        const icon = L.divIcon({
            html: `<i class="fas fa-exclamation-triangle" style="color: ${incident.severity === 'Severe' ? '#ef4444' : incident.severity === 'Moderate' ? '#f59e0b' : '#10b981'}"></i>`,
            className: 'incident-marker',
            iconSize: [24, 24]
        });
        
        const marker = L.marker([incident.lat, incident.lng], {icon: icon}).addTo(map);
        marker.bindPopup(`<b>${incident.type}</b><br>${incident.description}<br><span class="severity-badge ${incident.severity.toLowerCase()}">${incident.severity}</span>`);
    });
});
</script>

<style>
.map-main {
    padding: 40px 0;
}

.map-container {
    display: grid;
    grid-template-columns: 1fr 250px;
    gap: 20px;
    margin-top: 20px;
    height: 600px;
}

#trafficMap {
    width: 100%;
    height: 100%;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
}

.map-controls {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 20px;
    overflow-y: auto;
}

.control-group {
    margin-bottom: 20px;
}

.control-group h3 {
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.control-group label {
    display: block;
    margin-bottom: 8px;
    cursor: pointer;
}

.incident-marker {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    background: white;
    border-radius: 50%;
    border: 2px solid #6b7280;
    box-shadow: 0 1px 5px rgba(0,0,0,0.2);
}

@media (max-width: 992px) {
    .map-container {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr auto;
        height: auto;
    }
    
    #trafficMap {
        height: 400px;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
