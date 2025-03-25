<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="usertaskdemo.css">
    <title>Document</title>
</head>
<body>
<div class="container-card">
    <form action="usertaskdemodb.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="user_id" value="USER_ID_FROM_SESSION">
        
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description" required></textarea>

        <label>Category:</label>
        <select name="category" required>
            <option value="Plumbing">Plumbing</option>
            <option value="Electrical">Electrical</option>
            <option value="Cleaning">Cleaning</option>
            <!-- Add more categories -->
        </select>

        <label>Priority:</label>
        <select name="priority">
            <option value="Low">Low</option>
            <option value="Medium" selected>Medium</option>
            <option value="High">High</option>
            <option value="Urgent">Urgent</option>
        </select>

        <label>Start Date & Time:</label>
        <input type="datetime-local" name="start_datetime" required>

        <label>End Date & Time:</label>
        <input type="datetime-local" name="end_datetime" required>

        <label>Location:</label>
        <input type="text" name="location" required>

        <label>Contact Person:</label>
        <input type="text" name="contact_person" required>

        <label>Contact Number:</label>
        <input type="text" name="contact_number" required>

        <label>Budget:</label>
        <input type="number" name="budget" step="0.01" required>

        <label>Payment Mode:</label>
        <select name="payment_mode">
            <option value="Cash">Cash</option>
            <option value="Online">Online</option>
            <option value="UPI">UPI</option>
        </select>

        <label>Advance Payment (Optional):</label>
        <input type="number" name="advance_payment" step="0.01">

        <label>Special Instructions:</label>
        <textarea name="special_instructions"></textarea>

        <button type="submit">Submit Task</button>
    </form>
    </div>
</body>
</html>
