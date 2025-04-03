-- Create hire_requests table
CREATE TABLE IF NOT EXISTS hire_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    worker_id INT NOT NULL,
    user_id INT NOT NULL,
    request_date DATETIME NOT NULL,
    status ENUM('pending', 'accepted', 'rejected', 'completed') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (worker_id) REFERENCES workers(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Add status column to workers table if it doesn't exist
ALTER TABLE workers ADD COLUMN IF NOT EXISTS status ENUM('available', 'hired', 'unavailable') NOT NULL DEFAULT 'available'; 