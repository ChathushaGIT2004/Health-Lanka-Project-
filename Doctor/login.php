<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id']; // NIC, Email, or Doctor ID
    $password = $_POST['password'];

    // Check if the user ID is a valid doctor (can be NIC, email, or DoctorID)
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE DoctorID = :user_id OR Email = :user_id OR ContactNo = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($doctor && password_verify($password, $doctor['Password'])) {
        // If login is successful, load hospitals
        $doctor_id = $doctor['DoctorID'];

        // Fetch hospitals assigned to the doctor
        $stmt = $conn->prepare("SELECT h.HospitalID, h.Name FROM hospitals h 
                                JOIN doctor_hospital dh ON h.HospitalID = dh.HospitalID 
                                WHERE dh.DoctorID = :doctor_id");
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->execute();
        $hospitals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // If no hospitals assigned, offer "Private" as an option
        if (count($hospitals) == 0) {
            $hospitals[] = ['HospitalID' => 'Private', 'Name' => 'Private'];
        }

        // Store doctor info in session or pass it to the frontend for further use
        session_start();
        $_SESSION['doctor_id'] = $doctor['DoctorID'];
        echo json_encode(['status' => 'success', 'hospitals' => $hospitals]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
    }
}
?>
