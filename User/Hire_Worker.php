<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to hire a worker.";
    header("Location: login.php");
    exit();
}

if (!isset($_POST['worker_id'])) {
    $_SESSION['error'] = "Invalid request.";
    header("Location: Workers.php");
    exit();
}

$worker_id = intval($_POST['worker_id']);
$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT * FROM workers WHERE id = ? AND is_available = 1");
$query->bind_param("i", $worker_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Worker is not available for hire.";
    header("Location: Workers.php");
    exit();
}

$worker = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_request'])) {
    $errors = [];
    
    if (empty($_POST['job_title'])) {
        $errors[] = "Job title is required";
    }
    
    if (empty($_POST['job_description'])) {
        $errors[] = "Job description is required";
    }
    
    if (!isset($_POST['job_type'])) {
        $errors[] = "Job type is required";
    }
    
    if ($_POST['job_type'] === 'hourly' && empty($_POST['estimated_hours'])) {
        $errors[] = "Estimated hours required for hourly jobs";
    }
    
    if ($_POST['job_type'] === 'fixed' && empty($_POST['budget'])) {
        $errors[] = "Budget required for fixed price jobs";
    }
    
    if (empty($_POST['start_date'])) {
        $errors[] = "Start date is required";
    }
    
    if (empty($_POST['deadline'])) {
        $errors[] = "Deadline is required";
    }
    
    if (empty($errors)) {
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Insert hiring request
            $insert_query = $conn->prepare("INSERT INTO hiring_requests 
                (user_id, worker_id, job_title, job_description, job_type, 
                budget, estimated_hours, start_date, deadline, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
            
            $insert_query->bind_param("iisssdiss", 
                $user_id,
                $worker_id,
                $_POST['job_title'],
                $_POST['job_description'],
                $_POST['job_type'],
                $_POST['budget'] ?: null,
                $_POST['estimated_hours'] ?: null,
                $_POST['start_date'],
                $_POST['deadline']
            );
            
            $insert_query->execute();
            
            // Update worker status
            $update_worker = $conn->prepare("UPDATE workers SET status = 'hired' WHERE worker_id = ?");
            $update_worker->bind_param("i", $worker_id);
            $update_worker->execute();
            
            // Commit transaction
            $conn->commit();
            $_SESSION['success'] = "Hiring request submitted successfully!";
            header("Location: worker_profile.php");
            exit();
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $_SESSION['error'] = "Error submitting hiring request. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hire <?php echo htmlspecialchars($worker['name']); ?></title>
    <link rel="stylesheet" href="CSS/workers.css">
    <link rel="stylesheet" href="CSS/hire_worker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hire-form-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="date"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .form-group textarea {
            height: 150px;
            resize: vertical;
        }
        
        .job-type-group {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .job-type-option {
            flex: 1;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .job-type-option.selected {
            border-color: #3498db;
            background: #f7f9fc;
        }
        
        .job-type-option input[type="radio"] {
            display: none;
        }
        
        .submit-btn {
            background: #3498db;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .submit-btn:hover {
            background: #2980b9;
        }
        
        .error-message {
            color: #e74c3c;
            margin-bottom: 15px;
            padding: 10px;
            background: #fde8e8;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <div class="hiring-form-container">
        <div class="form-header">
            <h2>Submit Hiring Request</h2>
            <?php if ($worker['name']): ?>
                <p>Hiring <?php echo htmlspecialchars($worker['name']); ?> - <?php echo htmlspecialchars($worker['profession']); ?></p>
            <?php endif; ?>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php 
                echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?php 
                echo htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <form action="../Backend/process_hiring_request.php" method="POST" id="hiringForm">
            <input type="hidden" name="worker_id" value="<?php echo $worker_id; ?>">

            <div class="form-group">
                <label class="required-field" for="job_title">Job Title</label>
                <input type="text" id="job_title" name="job_title" required 
                       placeholder="Enter a clear and concise job title">
            </div>

            <div class="form-group">
                <label class="required-field" for="job_description">Job Description</label>
                <textarea id="job_description" name="job_description" required 
                          placeholder="Describe the job requirements, responsibilities, and any specific skills needed"></textarea>
            </div>

            <div class="form-group">
                <label class="required-field">Job Type</label>
                <div class="job-type-group">
                    <label class="job-type-option">
                        <input type="radio" name="job_type" value="hourly" required>
                        <i class="fas fa-clock"></i>
                        Hourly Rate
                    </label>
                    <label class="job-type-option">
                        <input type="radio" name="job_type" value="fixed" required>
                        <i class="fas fa-dollar-sign"></i>
                        Fixed Price
                    </label>
                </div>
            </div>

            <div class="form-group" id="hourlyFields" style="display: none;">
                <label class="required-field" for="estimated_hours">Estimated Hours</label>
                <input type="number" id="estimated_hours" name="estimated_hours" min="1" 
                       placeholder="Enter the estimated number of hours">
            </div>

            <div class="form-group" id="fixedFields" style="display: none;">
                <label class="required-field" for="budget">Budget ($)</label>
                <input type="number" id="budget" name="budget" min="1" step="0.01" 
                       placeholder="Enter the fixed budget amount">
            </div>

            <div class="form-group">
                <label class="required-field" for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" required 
                       min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label class="required-field" for="deadline">Deadline</label>
                <input type="date" id="deadline" name="deadline" required 
                       min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label class="required-field" for="contact_person">Contact Person</label>
                <input type="text" id="contact_person" name="contact_person" required 
                       placeholder="Enter the name of the contact person">
            </div>

            <div class="form-group">
                <label class="required-field" for="mobile_number">Mobile Number</label>
                <input type="tel" id="mobile_number" name="mobile_number" required 
                       pattern="[0-9]{10}" placeholder="Enter 10-digit mobile number">
                <small class="form-text text-muted">Please enter a valid 10-digit mobile number</small>
            </div>

            <div class="form-group">
                <label class="required-field" for="location">Job Location</label>
                <div id="map" style="height: 300px; margin-bottom: 10px; border-radius: 8px;"></div>
                <input type="hidden" id="latitude" name="latitude" required>
                <input type="hidden" id="longitude" name="longitude" required>
                <input type="text" id="location_address" name="location_address" required 
                       placeholder="Selected location address" readonly>
                <small class="form-text text-muted">Click on the map to select the job location</small>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-paper-plane"></i>
                Submit Hiring Request
            </button>
        </form>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        // Show/hide fields based on job type selection
        document.querySelectorAll('input[name="job_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('hourlyFields').style.display = 
                    this.value === 'hourly' ? 'block' : 'none';
                document.getElementById('fixedFields').style.display = 
                    this.value === 'fixed' ? 'block' : 'none';
                
                // Update selected state of job type options
                document.querySelectorAll('.job-type-option').forEach(option => {
                    option.classList.remove('selected');
                });
                this.closest('.job-type-option').classList.add('selected');
            });
        });

        // Initialize the map
        document.addEventListener('DOMContentLoaded', function() {
            // Default to a central location (you can change this to your preferred default)
            const defaultLat = 20.5937; // Default latitude (India)
            const defaultLng = 78.9629; // Default longitude (India)
            
            // Initialize the map with more zoom options
            const map = L.map('map', {
                center: [defaultLat, defaultLng],
                zoom: 5,
                zoomControl: false // We'll add a custom zoom control
            });
            
            // Add the OpenStreetMap tiles with more detailed options
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
                minZoom: 3
            }).addTo(map);
            
            // Add a custom zoom control in the top right corner
            L.control.zoom({
                position: 'topright'
            }).addTo(map);
            
            // Add a marker
            let marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);
            
            // Add a search control
            const geocoder = L.Control.geocoder({
                defaultMarkGeocode: false,
                placeholder: 'Search for a location...',
                position: 'topleft',
                geocoder: L.Control.Geocoder.nominatim()
            }).addTo(map);
            
            // Handle search results
            geocoder.on('markgeocode', function(e) {
                const latlng = e.geocode.center;
                marker.setLatLng(latlng);
                map.setView(latlng, 16);
                updateLocation(latlng.lat, latlng.lng);
            });
            
            // Update coordinates when marker is dragged
            marker.on('dragend', function(e) {
                const position = e.target.getLatLng();
                updateLocation(position.lat, position.lng);
            });
            
            // Update coordinates when map is clicked
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                
                // Move marker to clicked position
                marker.setLatLng([lat, lng]);
                
                // Update location fields
                updateLocation(lat, lng);
            });
            
            // Function to update location fields
            function updateLocation(lat, lng) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                
                // Reverse geocoding to get address
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                    .then(response => response.json())
                    .then(data => {
                        let address = data.display_name;
                        
                        // If we have detailed address components, create a more structured address
                        if (data.address) {
                            const addr = data.address;
                            let structuredAddress = '';
                            
                            if (addr.house_number) structuredAddress += addr.house_number + ' ';
                            if (addr.road) structuredAddress += addr.road + ', ';
                            if (addr.suburb) structuredAddress += addr.suburb + ', ';
                            if (addr.city || addr.town || addr.village) structuredAddress += (addr.city || addr.town || addr.village) + ', ';
                            if (addr.state) structuredAddress += addr.state + ', ';
                            if (addr.postcode) structuredAddress += addr.postcode + ', ';
                            if (addr.country) structuredAddress += addr.country;
                            
                            if (structuredAddress) {
                                address = structuredAddress;
                            }
                        }
                        
                        document.getElementById('location_address').value = address;
                    })
                    .catch(error => {
                        console.error('Error fetching address:', error);
                        document.getElementById('location_address').value = `${lat}, ${lng}`;
                    });
            }
            
            // Try to get user's location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    // Center map on user's location
                    map.setView([lat, lng], 15);
                    
                    // Move marker to user's location
                    marker.setLatLng([lat, lng]);
                    
                    // Update location fields
                    updateLocation(lat, lng);
                }, function(error) {
                    console.error('Error getting location:', error);
                });
            }
            
            // Add a scale control
            L.control.scale({
                imperial: false,
                position: 'bottomright'
            }).addTo(map);
            
            // Add a fullscreen control
            L.control.fullscreen({
                position: 'topleft',
                title: 'View Fullscreen',
                titleCancel: 'Exit Fullscreen',
                forceSeparateButton: true
            }).addTo(map);
        });

        // Form validation
        document.getElementById('hiringForm').addEventListener('submit', function(e) {
            const jobType = document.querySelector('input[name="job_type"]:checked')?.value;
            const estimatedHours = document.getElementById('estimated_hours').value;
            const budget = document.getElementById('budget').value;
            const startDate = new Date(document.getElementById('start_date').value);
            const deadline = new Date(document.getElementById('deadline').value);
            const latitude = document.getElementById('latitude').value;
            const longitude = document.getElementById('longitude').value;
            
            let errors = [];

            if (jobType === 'hourly' && !estimatedHours) {
                errors.push('Please enter estimated hours for hourly job type');
            } else if (jobType === 'fixed' && !budget) {
                errors.push('Please enter budget for fixed price job type');
            }

            if (deadline <= startDate) {
                errors.push('Deadline must be after the start date');
            }
            
            if (!latitude || !longitude) {
                errors.push('Please select a location on the map');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    </script>
</body>
</html>