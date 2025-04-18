document.addEventListener('DOMContentLoaded', function() {
    // Traffic Flow Chart
    if (typeof trafficLabels !== 'undefined' && typeof trafficCounts !== 'undefined' && typeof congestionData !== 'undefined') {
        const ctx = document.getElementById('trafficFlowChart');
        
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: trafficLabels,
                    datasets: [
                        {
                            label: 'Traffic Volume',
                            data: trafficCounts,
                            borderColor: '#2d74da',
                            backgroundColor: 'rgba(45, 116, 218, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Congestion Level',
                            data: congestionData,
                            borderColor: '#ef4444',
                            borderWidth: 2,
                            tension: 0.4,
                            borderDash: [5, 5],
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    stacked: false,
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Traffic Volume'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Congestion Level'
                            },
                            min: 0,
                            max: 3,
                            ticks: {
                                callback: function(value) {
                                    if (value === 1) return 'Low';
                                    if (value === 2) return 'Medium';
                                    if (value === 3) return 'High';
                                    return '';
                                }
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        }
                    }
                }
            });
        }
    } else {
        console.error('Traffic data not available for charts');
    }
    
    // Traffic Heatmap - Only create if we're on the dashboard page
    const heatmapContainer = document.getElementById('trafficHeatmap');
    
    if (heatmapContainer && window.location.pathname.includes('dashboard.php')) {
        // Clear any existing content first
        heatmapContainer.innerHTML = '';
        
        // Create a more sophisticated heatmap for the dashboard
        const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        const hours = [];
        for (let i = 0; i < 24; i++) {
            hours.push(i);
        }
        
        // Create the grid container
        const heatmapGrid = document.createElement('div');
        heatmapGrid.style.display = 'grid';
        heatmapGrid.style.gridTemplateColumns = `auto repeat(${hours.length}, 1fr)`;
        heatmapGrid.style.gridTemplateRows = `auto repeat(${days.length}, 1fr)`;
        heatmapGrid.style.gap = '1px';
        heatmapGrid.style.height = '100%';
        
        // Add empty corner cell
        const cornerCell = document.createElement('div');
        cornerCell.style.gridColumn = '1 / 2';
        cornerCell.style.gridRow = '1 / 2';
        heatmapGrid.appendChild(cornerCell);
        
        // Add hours as header
        hours.forEach((hour, index) => {
            const hourCell = document.createElement('div');
            hourCell.style.gridColumn = `${index + 2} / ${index + 3}`;
            hourCell.style.gridRow = '1 / 2';
            hourCell.style.display = 'flex';
            hourCell.style.alignItems = 'center';
            hourCell.style.justifyContent = 'center';
            hourCell.style.fontSize = '0.7rem';
            hourCell.style.color = '#667085';
            hourCell.textContent = `${hour}:00`;
            heatmapGrid.appendChild(hourCell);
        });
        
        // Add days as first column
        days.forEach((day, index) => {
            const dayCell = document.createElement('div');
            dayCell.style.gridColumn = '1 / 2';
            dayCell.style.gridRow = `${index + 2} / ${index + 3}`;
            dayCell.style.display = 'flex';
            dayCell.style.alignItems = 'center';
            dayCell.style.justifyContent = 'center';
            dayCell.style.padding = '0 5px';
            dayCell.style.fontSize = '0.8rem';
            dayCell.style.color = '#667085';
            dayCell.textContent = day;
            heatmapGrid.appendChild(dayCell);
        });
        
        // Add data cells
        days.forEach((day, dayIndex) => {
            hours.forEach((hour, hourIndex) => {
                const cell = document.createElement('div');
                cell.style.gridColumn = `${hourIndex + 2} / ${hourIndex + 3}`;
                cell.style.gridRow = `${dayIndex + 2} / ${dayIndex + 3}`;
                
                // Determine traffic pattern based on day and hour
                let congestionLevel;
                
                // Weekend pattern
                if (day === 'Saturday' || day === 'Sunday') {
                    if (hour >= 10 && hour <= 18) {
                        // Shopping hours - moderate traffic
                        congestionLevel = 0.3 + Math.random() * 0.4;
                    } else {
                        // Low traffic during other times
                        congestionLevel = Math.random() * 0.3;
                    }
                } 
                // Weekday pattern
                else {
                    if ((hour >= 7 && hour <= 9) || (hour >= 16 && hour <= 18)) {
                        // Rush hours - high traffic
                        congestionLevel = 0.7 + Math.random() * 0.3;
                    } else if (hour >= 10 && hour <= 15) {
                        // Business hours - moderate traffic
                        congestionLevel = 0.3 + Math.random() * 0.4;
                    } else {
                        // Low traffic during other times
                        congestionLevel = Math.random() * 0.3;
                    }
                }
                
                // Determine color based on congestion level
                let color;
                if (congestionLevel < 0.3) {
                    color = '#10b981'; // Green for low traffic
                } else if (congestionLevel < 0.7) {
                    color = '#f59e0b'; // Yellow/orange for medium traffic
                } else {
                    color = '#ef4444'; // Red for high traffic
                }
                
                cell.style.backgroundColor = color;
                cell.title = `${day} ${hour}:00 - ${(hour + 1) % 24}:00: ${Math.round(congestionLevel * 100)}% congestion`;
                
                heatmapGrid.appendChild(cell);
            });
        });
        
        heatmapContainer.appendChild(heatmapGrid);
    }
});
