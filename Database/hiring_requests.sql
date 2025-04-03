-- Create hiring_requests table
CREATE TABLE IF NOT EXISTS hiring_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    worker_id INT NOT NULL,
    job_title VARCHAR(255) NOT NULL,
    job_description TEXT NOT NULL,
    job_type ENUM('hourly', 'fixed') NOT NULL,
    budget DECIMAL(10,2) NULL,
    estimated_hours INT NULL,
    start_date DATE NOT NULL,
    deadline DATE NOT NULL,
    status ENUM('pending', 'accepted', 'rejected', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (worker_id) REFERENCES workers(id) ON DELETE CASCADE,
    CHECK (deadline > start_date),
    CHECK (
        (job_type = 'hourly' AND estimated_hours IS NOT NULL AND budget IS NULL) OR
        (job_type = 'fixed' AND budget IS NOT NULL AND estimated_hours IS NULL)
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add indexes for better performance
CREATE INDEX idx_user_id ON hiring_requests(user_id);
CREATE INDEX idx_worker_id ON hiring_requests(worker_id);
CREATE INDEX idx_status ON hiring_requests(status);
CREATE INDEX idx_created_at ON hiring_requests(created_at);

-- Add comments for documentation
ALTER TABLE hiring_requests
    MODIFY COLUMN id INT COMMENT 'Unique identifier for the hiring request',
    MODIFY COLUMN user_id INT COMMENT 'ID of the user who made the request',
    MODIFY COLUMN worker_id INT COMMENT 'ID of the worker being hired',
    MODIFY COLUMN job_title VARCHAR(255) COMMENT 'Title of the job',
    MODIFY COLUMN job_description TEXT COMMENT 'Detailed description of the job',
    MODIFY COLUMN job_type ENUM('hourly', 'fixed') COMMENT 'Type of job payment (hourly or fixed price)',
    MODIFY COLUMN budget DECIMAL(10,2) COMMENT 'Fixed price for the job (if job_type is fixed)',
    MODIFY COLUMN estimated_hours INT COMMENT 'Estimated hours for the job (if job_type is hourly)',
    MODIFY COLUMN start_date DATE COMMENT 'Expected start date of the job',
    MODIFY COLUMN deadline DATE COMMENT 'Expected completion date of the job',
    MODIFY COLUMN status ENUM('pending', 'accepted', 'rejected', 'completed', 'cancelled') COMMENT 'Current status of the hiring request',
    MODIFY COLUMN created_at TIMESTAMP COMMENT 'Timestamp when the request was created',
    MODIFY COLUMN updated_at TIMESTAMP COMMENT 'Timestamp when the request was last updated'; 