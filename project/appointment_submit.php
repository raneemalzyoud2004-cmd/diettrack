<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: appointment.html');
    exit;
}

require_once __DIR__ . '/admin/config.php';

$createPatientsTable = "
CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(150) NOT NULL,
    dob DATE NULL,
    age INT NULL,
    phone_number VARCHAR(30) NULL,
    address TEXT NULL,
    weight_kg DECIMAL(6,2) NULL,
    height_cm DECIMAL(6,2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$createAppointmentsTable = "
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    dietician_name VARCHAR(150) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status VARCHAR(40) DEFAULT 'scheduled',
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
)";

if (!$conn->query($createPatientsTable) || !$conn->query($createAppointmentsTable)) {
    header('Location: appointment.html?status=error');
    exit;
}

$fullName = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phoneNumber = trim($_POST['phone_number'] ?? '');
$doctorName = trim($_POST['doctor_name'] ?? '');
$appointmentDateInput = trim($_POST['appointment_date'] ?? '');
$appointmentTimeInput = trim($_POST['appointment_time'] ?? '');
$notes = trim($_POST['notes'] ?? '');

if (
    $fullName === '' ||
    $email === '' ||
    $phoneNumber === '' ||
    $doctorName === '' ||
    $appointmentDateInput === '' ||
    $appointmentTimeInput === ''
) {
    header('Location: appointment.html?status=invalid');
    exit;
}

$dateTimestamp = strtotime($appointmentDateInput);
$timeTimestamp = strtotime($appointmentTimeInput);

if ($dateTimestamp === false || $timeTimestamp === false) {
    header('Location: appointment.html?status=invalid');
    exit;
}

$appointmentDate = date('Y-m-d', $dateTimestamp);
$appointmentTime = date('H:i:s', $timeTimestamp);

$patientDbId = 0;
$findPatientStmt = $conn->prepare(
    "SELECT id FROM patients WHERE full_name = ? AND phone_number = ? LIMIT 1"
);
$findPatientStmt->bind_param('ss', $fullName, $phoneNumber);
$findPatientStmt->execute();
$findPatientResult = $findPatientStmt->get_result();
$existingPatient = $findPatientResult->fetch_assoc();
$findPatientStmt->close();

if ($existingPatient) {
    $patientDbId = (int) $existingPatient['id'];
} else {
    $generatedPatientCode = 'WEB-' . date('YmdHis') . '-' . random_int(100, 999);
    $insertPatientStmt = $conn->prepare(
        "INSERT INTO patients (patient_id, full_name, phone_number) VALUES (?, ?, ?)"
    );
    $insertPatientStmt->bind_param('sss', $generatedPatientCode, $fullName, $phoneNumber);
    if (!$insertPatientStmt->execute()) {
        header('Location: appointment.html?status=error');
        exit;
    }
    $patientDbId = (int) $insertPatientStmt->insert_id;
    $insertPatientStmt->close();
}

$stmt = $conn->prepare(
    "INSERT INTO appointments (patient_id, dietician_name, appointment_date, appointment_time, status, notes)
     VALUES (?, ?, ?, ?, 'scheduled', ?)"
);

$stmt->bind_param(
    'issss',
    $patientDbId,
    $doctorName,
    $appointmentDate,
    $appointmentTime,
    $notes
);

if ($stmt->execute()) {
    header('Location: appointment.html?status=success');
    exit;
}

header('Location: appointment.html?status=error');
exit;
?>
