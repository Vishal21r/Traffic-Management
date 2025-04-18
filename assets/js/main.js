document.addEventListener('DOMContentLoaded', function() {
    // Toggle mobile menu
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('nav');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
        });
    }
    
    // Only create homepage charts if we're not on the dashboard page
    const isNotDashboard = !window.location.pathname.includes('dashboard.php');
    
    // Homepage chart preview
    const ctx = document.getElementById('trafficChart');
    
    if (ctx && isNotDashboard) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'],
                datasets: [
                    {
                        label: 'Traffic Flow',
                        data: [120, 190, 130, 150, 180, 170, 160, 190, 210, 170],
                        borderColor: '#2d74da',
                        backgroundColor: 'rgba(45, 116, 218, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Congestion Level',
                        data: [45, 70, 40, 45, 50, 60, 50, 70, 85, 60],
                        borderColor: '#ef4444',
                        borderWidth: 2,
                        tension: 0.4,
                        borderDash: [5, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Traffic Volume'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Time of Day'
                        }
                    }
                }
            }
        });
    }
    
    // Homepage heatmap preview - only create it on the homepage
    const heatmapContainer = document.getElementById('trafficHeatmap');
    
    if (heatmapContainer && isNotDashboard) {
        // Clear any existing content first
        heatmapContainer.innerHTML = '';
        
        // Create a simple representation of a heatmap
        const heatmapData = [];
        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const times = ['12am', '3am', '6am', '9am', '12pm', '3pm', '6pm', '9pm'];
        
        // Generate random data for the heatmap
        for (let i = 0; i < days.length; i++) {
            for (let j = 0; j < times.length; j++) {
                // Simulate typical traffic patterns
                let value;
                if (days[i] === 'Sat' || days[i] === 'Sun') {
                    // Less traffic on weekends
                    value = Math.random() * 0.7;
                } else {
                    // More traffic on weekdays during rush hours
                    if (times[j] === '9am' || times[j] === '6pm') {
                        value = 0.7 + Math.random() * 0.3;
                    } else if (times[j] === '12am' || times[j] === '3am') {
                        value = Math.random() * 0.3;
                    } else {
                        value = 0.3 + Math.random() * 0.4;
                    }
                }
                
                heatmapData.push({
                    day: days[i],
                    time: times[j],
                    value: value
                });
            }
        }
        
        // Create a simple visual representation of the heatmap
        // Create container for the heatmap
        const heatmapGrid = document.createElement('div');
        heatmapGrid.style.display = 'grid';
        heatmapGrid.style.gridTemplateColumns = `repeat(${times.length + 1}, 1fr)`;
        heatmapGrid.style.gridTemplateRows = `repeat(${days.length + 1}, 1fr)`;
        heatmapGrid.style.gap = '2px';
        heatmapGrid.style.height = '100%';
        
        // Add header row with times
        const headerCell = document.createElement('div');
        headerCell.style.gridColumn = '1 / 2';
        headerCell.style.gridRow = '1 / 2';
        headerCell.style.display = 'flex';
        headerCell.style.alignItems = 'center';
        headerCell.style.justifyContent = 'center';
        headerCell.style.fontWeight = 'bold';
        headerCell.style.color = '#667085';
        heatmapGrid.appendChild(headerCell);
        
        times.forEach((time, index) => {
            const timeCell = document.createElement('div');
            timeCell.style.gridColumn = `${index + 2} / ${index + 3}`;
            timeCell.style.gridRow = '1 / 2';
            timeCell.style.display = 'flex';
            timeCell.style.alignItems = 'center';
            timeCell.style.justifyContent = 'center';
            timeCell.style.fontWeight = 'bold';
            timeCell.style.fontSize = '0.7rem';
            timeCell.style.color = '#667085';
            timeCell.textContent = time;
            heatmapGrid.appendChild(timeCell);
        });
        
        // Add days as first column
        days.forEach((day, index) => {
            const dayCell = document.createElement('div');
            dayCell.style.gridColumn = '1 / 2';
            dayCell.style.gridRow = `${index + 2} / ${index + 3}`;
            dayCell.style.display = 'flex';
            dayCell.style.alignItems = 'center';
            dayCell.style.justifyContent = 'center';
            dayCell.style.fontWeight = 'bold';
            dayCell.style.fontSize = '0.8rem';
            dayCell.style.color = '#667085';
            dayCell.textContent = day;
            heatmapGrid.appendChild(dayCell);
        });
        
        // Add the heatmap cells
        heatmapData.forEach((data, index) => {
            const dayIndex = days.indexOf(data.day);
            const timeIndex = times.indexOf(data.time);
            
            const cell = document.createElement('div');
            cell.style.gridColumn = `${timeIndex + 2} / ${timeIndex + 3}`;
            cell.style.gridRow = `${dayIndex + 2} / ${dayIndex + 3}`;
            
            // Determine color based on value
            let color;
            if (data.value < 0.3) {
                color = '#10b981'; // Green for low traffic
            } else if (data.value < 0.7) {
                color = '#f59e0b'; // Yellow/orange for medium traffic
            } else {
                color = '#ef4444'; // Red for high traffic
            }
            
            cell.style.backgroundColor = color;
            cell.style.borderRadius = '2px';
            cell.title = `${data.day} ${data.time}: ${Math.round(data.value * 100)}% congestion`;
            
            heatmapGrid.appendChild(cell);
        });
        
        heatmapContainer.appendChild(heatmapGrid);
    }
});
// Navigation menu functionality
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mainNav = document.getElementById('mainNav');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const headerActions = document.querySelector('.header-actions');
    
    if (mobileMenuToggle && mainNav && mobileMenuOverlay) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            headerActions.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });
        
        mobileMenuOverlay.addEventListener('click', function() {
            mainNav.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            headerActions.classList.remove('active');
            document.body.classList.remove('menu-open');
        });
    }
    
    // Mobile dropdown toggle
    const dropdownItems = document.querySelectorAll('.menu-item.has-dropdown');
    
    if (window.innerWidth <= 992) {
        dropdownItems.forEach(item => {
            const link = item.querySelector('a');
            
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    item.classList.toggle('active');
                }
            });
        });
    }
    
    // Update active menu item
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.menu-item a');
    
    menuItems.forEach(item => {
        const href = item.getAttribute('href');
        if (currentPath.includes(href) && href !== '#' && href !== '/') {
            item.classList.add('active');
            
            // If it's in a dropdown, also activate the parent
            const parentItem = item.closest('.has-dropdown');
            if (parentItem) {
                parentItem.querySelector('> a').classList.add('active');
            }
        }
    });
});
