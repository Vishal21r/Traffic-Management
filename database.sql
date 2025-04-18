-- Traffic data table
CREATE TABLE IF NOT EXISTS traffic_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location VARCHAR(255) NOT NULL,
    timestamp DATETIME NOT NULL,
    traffic_count INT NOT NULL,
    congestion_level ENUM('Low', 'Medium', 'High') NOT NULL,
    average_speed FLOAT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Accidents table
CREATE TABLE IF NOT EXISTS accidents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    description TEXT,
    severity ENUM('Minor', 'Moderate', 'Severe') NOT NULL,
    reporter_name VARCHAR(255),
    reporter_contact VARCHAR(255),
    status ENUM('Reported', 'In Progress', 'Resolved') DEFAULT 'Reported',
    video_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample traffic data
INSERT INTO traffic_data (location, timestamp, traffic_count, congestion_level, average_speed)
VALUES 
('Main St & 5th Ave', NOW() - INTERVAL 1 HOUR, 145, 'Medium', 25.5),
('Broadway & 7th St', NOW() - INTERVAL 2 HOUR, 230, 'High', 18.2),
('Park Road & Oak Lane', NOW() - INTERVAL 3 HOUR, 89, 'Low', 38.7),
('Main St & 5th Ave', NOW() - INTERVAL 4 HOUR, 120, 'Medium', 27.8),
('Broadway & 7th St', NOW() - INTERVAL 5 HOUR, 210, 'High', 19.5);

-- Insert sample accident data
INSERT INTO accidents (location, date, time, description, severity, reporter_name, status)
VALUES 
('Highway 101 Mile 24', CURDATE(), '08:30:00', 'Two-vehicle collision, blocking right lane', 'Moderate', 'Traffic Officer Smith', 'In Progress'),
('Downtown Main St & 3rd Ave', CURDATE() - INTERVAL 1 DAY, '17:15:00', 'Pedestrian incident, emergency services on scene', 'Severe', 'Anonymous Witness', 'Resolved'),
('Eastside Shopping Mall Entrance', CURDATE(), '12:45:00', 'Minor fender bender in parking lot', 'Minor', 'Mall Security', 'Reported');

-- Add these to your database.sql file
CREATE INDEX idx_traffic_timestamp ON traffic_data(timestamp);
CREATE INDEX idx_accidents_date ON accidents(date);
CREATE INDEX idx_accidents_status ON accidents(status);
