<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login if session is not set
    header('Location: User_Login.php');
    exit();
}

// Include the header
include('Navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home - Find Your Professional Worker</title>
    <link rel="stylesheet" href="../CSS/User_Home.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        function fetchWorkers(profession = '') {
            const workerList = document.getElementById("worker-list");
            workerList.classList.add('loading');
            
            fetch(`../Backend/get_workers.php?profession=${profession}`)
                .then(response => response.json())
                .then(data => {
                    workerList.innerHTML = "";
                    
                    if (data.length === 0) {
                        workerList.innerHTML = `
                            <div class="no-results fade-in">
                                <i class="fas fa-search" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem;"></i>
                                <p>No workers found for "${profession}". Try a different search term.</p>
                            </div>`;
                        return;
                    }
                    
                    data.forEach((worker, index) => {
                        let workerCard = `
                            <div class="worker-card slide-up" style="animation-delay: ${index * 0.1}s">
                                <div class="worker-image">
                                    <img src="../Backend/uploads/${worker.profile_photo}" alt="${worker.name}'s Profile Photo">
                                </div>
                                <div class="worker-info">
                                    <h3>${worker.name}</h3>
                                    <p class="profession">${worker.profession}</p>
                                </div>
                                <form action="worker_profile.php" method="POST" class="view-profile-form">
                                    <input type="hidden" name="worker_id" value="${worker.id}">
                                    <button type="submit" class="view-profile-btn">
                                        <span class="btn-icon">
                                            <i class="fas fa-user-circle"></i>
                                        </span>
                                        <span class="btn-text">View Profile</span>
                                    </button>
                                </form>
                            </div>
                        `;
                        workerList.innerHTML += workerCard;
                    });
                })
                .catch(error => {
                    console.error('Error fetching workers:', error);
                    workerList.innerHTML = `
                        <div class="error-message fade-in">
                            <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
                            <p>Error loading workers. Please try again later.</p>
                        </div>`;
                })
                .finally(() => {
                    workerList.classList.remove('loading');
                });
        }
        
        document.addEventListener("DOMContentLoaded", function () {
            fetchWorkers();
            
            const searchForm = document.getElementById("search-form");
            const searchBar = document.getElementById("search-bar");
            
            searchForm.addEventListener("submit", function (event) {
                event.preventDefault();
                let profession = searchBar.value.trim();
                fetchWorkers(profession);
            });

            // Add input event listener for real-time search
            searchBar.addEventListener("input", function() {
                let profession = this.value.trim();
                if (profession.length >= 2) {
                    fetchWorkers(profession);
                }
            });
        });
    </script>
</head>
<body>
    
    <div class="container">
        <h2>Available Workers</h2>
        <form id="search-form">
            <input type="text" id="search-bar" placeholder="Search by profession (e.g., Plumber, Electrician, Carpenter)">
            <button type="submit">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
        <div id="worker-list" class="worker-list"></div>
    </div>
</body>
</html>
