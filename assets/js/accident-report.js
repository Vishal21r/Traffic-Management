// assets/js/accident-report.js
document.addEventListener('DOMContentLoaded', function() {
    // Handle file upload preview
    const videoInput = document.getElementById('video');
    const videoPreview = document.getElementById('videoPreview');
    
    if (videoInput && videoPreview) {
        videoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Clear previous preview
                while (videoPreview.firstChild) {
                    videoPreview.removeChild(videoPreview.firstChild);
                }
                
                // Create preview for video
                const fileName = document.createElement('p');
                fileName.textContent = file.name;
                fileName.style.marginBottom = '5px';
                
                const fileSize = document.createElement('p');
                fileSize.textContent = `Size: ${(file.size / (1024 * 1024)).toFixed(2)} MB`;
                fileSize.style.fontSize = '0.8rem';
                fileSize.style.color = '#667085';
                fileSize.style.marginBottom = '10px';
                
                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remove';
                removeButton.className = 'btn btn-outline';
                removeButton.style.marginTop = '10px';
                removeButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    videoInput.value = '';
                    
                    // Reset preview
                    while (videoPreview.firstChild) {
                        videoPreview.removeChild(videoPreview.firstChild);
                    }
                    
                    const defaultText = document.createElement('p');
                    defaultText.textContent = 'No video selected';
                    
                    const chooseButton = document.createElement('button');
                    chooseButton.textContent = 'Choose File';
                    chooseButton.className = 'btn btn-outline';
                    chooseButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        videoInput.click();
                    });
                    
                    videoPreview.appendChild(defaultText);
                    videoPreview.appendChild(chooseButton);
                });
                
                videoPreview.appendChild(fileName);
                videoPreview.appendChild(fileSize);
                videoPreview.appendChild(removeButton);
            }
        });
        
        // Click handler for the choose file button
        videoPreview.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON' && e.target.textContent === 'Choose File') {
                e.preventDefault();
                videoInput.click();
            }
        });
    }
    
    // Form validation
    const accidentForm = document.querySelector('.accident-form');
    
    if (accidentForm) {
        accidentForm.addEventListener('submit', function(e) {
            const location = document.getElementById('location').value.trim();
            const date = document.getElementById('date').value;
            const time = document.getElementById('time').value;
            const description = document.getElementById('description').value.trim();
            const severity = document.getElementById('severity').value;
            
            if (!location || !date || !time || !description || !severity) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    }
});
