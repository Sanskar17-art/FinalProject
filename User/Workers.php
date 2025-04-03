<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Workers</title>
    <link rel="stylesheet" href="../CSS/workers.css">
    <script>
        function fetchWorkers(profession = '') {
            fetch(`../Backend/get_workers.php?profession=${profession}`)
                .then(response => response.json())
                .then(data => {
                    let workerContainer = document.getElementById("worker-list");
                    workerContainer.innerHTML = "";
                    
                    if (data.length === 0) {
                        workerContainer.innerHTML = "<p>No workers found.</p>";
                        return;
                    }
                    
                    data.forEach(worker => {
                        let workerCard = `
                            <div class="worker-card">
                                <img src="../Backend/uploads/${worker.profile_photo}" alt="Profile Photo">
                                <div class="worker-info">
                                    <h3>${worker.name}</h3>
                                    <p><strong>Profession:</strong> ${worker.profession}</p>
                                    <p><strong>Experience:</strong> ${worker.experience}</p>
                                    <p><strong>Qualification:</strong> ${worker.qualification}</p>
                                </div>
                                <form action="worker_profile.php" method="POST" class="view-profile-form">
                                    <input type="hidden" name="worker_id" value="${worker.id}">
                                    <button type="submit" class="view-profile-btn">View Profile</button>
                                </form>
                            </div>
                        `;
                        workerContainer.innerHTML += workerCard;
                    });

                })
                .catch(error => console.error('Error fetching workers:', error));
        }
        
        document.addEventListener("DOMContentLoaded", function () {
            fetchWorkers();
            document.getElementById("search-form").addEventListener("submit", function (event) {
                event.preventDefault();
                let profession = document.getElementById("search-bar").value.trim();
                fetchWorkers(profession);
            });
        });
    </script>
</head>
<body>
    <?php include 'Navbar.php'; ?>
    <div class="container">
        <h2>Find a Worker</h2>
        <form id="search-form">
            <input type="text" id="search-bar" placeholder="Search by profession...">
            <button type="submit">Search</button>
        </form>
        <div id="worker-list" class="worker-list"></div>
    </div>
</body>
</html>