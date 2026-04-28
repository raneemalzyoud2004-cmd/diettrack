<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$error = '';
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

$createDietPlansTable = "
CREATE TABLE IF NOT EXISTS diet_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    plan_name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    calories_per_day INT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    status VARCHAR(40) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
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

$createMealLogsTable = "
CREATE TABLE IF NOT EXISTS meal_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    diet_plan_id INT NULL,
    meal_date DATE NOT NULL,
    meal_type VARCHAR(50) NOT NULL,
    meal_details TEXT NULL,
    adherence_status VARCHAR(40) DEFAULT 'on_track',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (diet_plan_id) REFERENCES diet_plans(id) ON DELETE SET NULL
)";

$createProgressLogsTable = "
CREATE TABLE IF NOT EXISTS progress_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    log_date DATE NOT NULL,
    weight_kg DECIMAL(6,2) NULL,
    waist_cm DECIMAL(6,2) NULL,
    body_fat_percent DECIMAL(5,2) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
)";

$createPaymentsTable = "
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE NOT NULL,
    payment_method VARCHAR(60) NOT NULL,
    status VARCHAR(40) DEFAULT 'paid',
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
)";

$tableQueries = [
    $createPatientsTable,
    $createDietPlansTable,
    $createAppointmentsTable,
    $createMealLogsTable,
    $createProgressLogsTable,
    $createPaymentsTable
];

foreach ($tableQueries as $query) {
    if (!$conn->query($query)) {
        die('Database table setup failed: ' . $conn->error);
    }
}

$sections = ['patients', 'diet_plans', 'appointments', 'meal_logs', 'progress_logs', 'payments'];
$activeSection = $_GET['section'] ?? 'patients';
if (!in_array($activeSection, $sections, true)) {
    $activeSection = 'patients';
}

$editPatient = null;
$editDietPlan = null;
$editAppointment = null;
$editMealLog = null;
$editProgressLog = null;
$editPayment = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entity = $_POST['entity'] ?? '';
    $action = $_POST['action'] ?? '';

    if ($entity === 'patients' && ($action === 'create' || $action === 'update')) {
        $patientCode = trim($_POST['patient_id'] ?? '');
        $fullName = trim($_POST['full_name'] ?? '');
        $dobValue = trim($_POST['dob'] ?? '') ?: null;
        $age = trim($_POST['age'] ?? '') !== '' ? (int) $_POST['age'] : null;
        $phoneNumber = trim($_POST['phone_number'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $weightKg = trim($_POST['weight_kg'] ?? '') !== '' ? (float) $_POST['weight_kg'] : null;
        $heightCm = trim($_POST['height_cm'] ?? '') !== '' ? (float) $_POST['height_cm'] : null;

        if ($patientCode === '' || $fullName === '') {
            $error = 'Patient ID and Name are required.';
        } elseif ($action === 'create') {
            $stmt = $conn->prepare(
                "INSERT INTO patients (patient_id, full_name, dob, age, phone_number, address, weight_kg, height_cm)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param('sssissdd', $patientCode, $fullName, $dobValue, $age, $phoneNumber, $address, $weightKg, $heightCm);
            if ($stmt->execute()) {
                $message = 'Patient added successfully.';
            } else {
                $error = 'Could not add patient. Patient ID may already exist.';
            }
            $stmt->close();
        } else {
            $rowId = (int) ($_POST['row_id'] ?? 0);
            $stmt = $conn->prepare(
                "UPDATE patients
                 SET patient_id = ?, full_name = ?, dob = ?, age = ?, phone_number = ?, address = ?, weight_kg = ?, height_cm = ?
                 WHERE id = ?"
            );
            $stmt->bind_param('sssissddi', $patientCode, $fullName, $dobValue, $age, $phoneNumber, $address, $weightKg, $heightCm, $rowId);
            if ($stmt->execute()) {
                $message = 'Patient updated successfully.';
            } else {
                $error = 'Could not update patient.';
            }
            $stmt->close();
        }
        $activeSection = 'patients';
    }

    if ($entity === 'diet_plans' && ($action === 'create' || $action === 'update')) {
        $patientId = (int) ($_POST['patient_ref_id'] ?? 0);
        $planName = trim($_POST['plan_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $calories = trim($_POST['calories_per_day'] ?? '') !== '' ? (int) $_POST['calories_per_day'] : null;
        $startDate = trim($_POST['start_date'] ?? '') ?: null;
        $endDate = trim($_POST['end_date'] ?? '') ?: null;
        $status = trim($_POST['status'] ?? 'active');

        if ($patientId <= 0 || $planName === '') {
            $error = 'Patient and Plan Name are required for diet plan.';
        } elseif ($action === 'create') {
            $stmt = $conn->prepare(
                "INSERT INTO diet_plans (patient_id, plan_name, description, calories_per_day, start_date, end_date, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param('ississs', $patientId, $planName, $description, $calories, $startDate, $endDate, $status);
            if ($stmt->execute()) {
                $message = 'Diet plan assigned successfully.';
            } else {
                $error = 'Could not assign diet plan.';
            }
            $stmt->close();
        } else {
            $rowId = (int) ($_POST['row_id'] ?? 0);
            $stmt = $conn->prepare(
                "UPDATE diet_plans
                 SET patient_id = ?, plan_name = ?, description = ?, calories_per_day = ?, start_date = ?, end_date = ?, status = ?
                 WHERE id = ?"
            );
            $stmt->bind_param('ississsi', $patientId, $planName, $description, $calories, $startDate, $endDate, $status, $rowId);
            if ($stmt->execute()) {
                $message = 'Diet plan updated successfully.';
            } else {
                $error = 'Could not update diet plan.';
            }
            $stmt->close();
        }
        $activeSection = 'diet_plans';
    }

    if ($entity === 'appointments' && ($action === 'create' || $action === 'update')) {
        $patientId = (int) ($_POST['patient_ref_id'] ?? 0);
        $dieticianName = trim($_POST['dietician_name'] ?? '');
        $appointmentDate = trim($_POST['appointment_date'] ?? '');
        $appointmentTime = trim($_POST['appointment_time'] ?? '');
        $status = trim($_POST['status'] ?? 'scheduled');
        $notes = trim($_POST['notes'] ?? '');

        if ($patientId <= 0 || $dieticianName === '' || $appointmentDate === '' || $appointmentTime === '') {
            $error = 'Patient, Dietician Name, Date and Time are required.';
        } elseif ($action === 'create') {
            $stmt = $conn->prepare(
                "INSERT INTO appointments (patient_id, dietician_name, appointment_date, appointment_time, status, notes)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param('isssss', $patientId, $dieticianName, $appointmentDate, $appointmentTime, $status, $notes);
            if ($stmt->execute()) {
                $message = 'Appointment scheduled successfully.';
            } else {
                $error = 'Could not create appointment.';
            }
            $stmt->close();
        } else {
            $rowId = (int) ($_POST['row_id'] ?? 0);
            $stmt = $conn->prepare(
                "UPDATE appointments
                 SET patient_id = ?, dietician_name = ?, appointment_date = ?, appointment_time = ?, status = ?, notes = ?
                 WHERE id = ?"
            );
            $stmt->bind_param('isssssi', $patientId, $dieticianName, $appointmentDate, $appointmentTime, $status, $notes, $rowId);
            if ($stmt->execute()) {
                $message = 'Appointment updated successfully.';
            } else {
                $error = 'Could not update appointment.';
            }
            $stmt->close();
        }
        $activeSection = 'appointments';
    }

    if ($entity === 'meal_logs' && ($action === 'create' || $action === 'update')) {
        $patientId = (int) ($_POST['patient_ref_id'] ?? 0);
        $dietPlanIdInput = trim($_POST['diet_plan_ref_id'] ?? '');
        $dietPlanId = $dietPlanIdInput !== '' ? (int) $dietPlanIdInput : null;
        $mealDate = trim($_POST['meal_date'] ?? '');
        $mealType = trim($_POST['meal_type'] ?? '');
        $mealDetails = trim($_POST['meal_details'] ?? '');
        $adherenceStatus = trim($_POST['adherence_status'] ?? 'on_track');

        if ($patientId <= 0 || $mealDate === '' || $mealType === '') {
            $error = 'Patient, Meal Date and Meal Type are required.';
        } elseif ($action === 'create') {
            $stmt = $conn->prepare(
                "INSERT INTO meal_logs (patient_id, diet_plan_id, meal_date, meal_type, meal_details, adherence_status)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param('iissss', $patientId, $dietPlanId, $mealDate, $mealType, $mealDetails, $adherenceStatus);
            if ($stmt->execute()) {
                $message = 'Meal tracking record added.';
            } else {
                $error = 'Could not add meal tracking record.';
            }
            $stmt->close();
        } else {
            $rowId = (int) ($_POST['row_id'] ?? 0);
            $stmt = $conn->prepare(
                "UPDATE meal_logs
                 SET patient_id = ?, diet_plan_id = ?, meal_date = ?, meal_type = ?, meal_details = ?, adherence_status = ?
                 WHERE id = ?"
            );
            $stmt->bind_param('iissssi', $patientId, $dietPlanId, $mealDate, $mealType, $mealDetails, $adherenceStatus, $rowId);
            if ($stmt->execute()) {
                $message = 'Meal tracking record updated.';
            } else {
                $error = 'Could not update meal tracking record.';
            }
            $stmt->close();
        }
        $activeSection = 'meal_logs';
    }

    if ($entity === 'progress_logs' && ($action === 'create' || $action === 'update')) {
        $patientId = (int) ($_POST['patient_ref_id'] ?? 0);
        $logDate = trim($_POST['log_date'] ?? '');
        $weight = trim($_POST['weight_kg'] ?? '') !== '' ? (float) $_POST['weight_kg'] : null;
        $waist = trim($_POST['waist_cm'] ?? '') !== '' ? (float) $_POST['waist_cm'] : null;
        $bodyFat = trim($_POST['body_fat_percent'] ?? '') !== '' ? (float) $_POST['body_fat_percent'] : null;
        $notes = trim($_POST['notes'] ?? '');

        if ($patientId <= 0 || $logDate === '') {
            $error = 'Patient and Log Date are required.';
        } elseif ($action === 'create') {
            $stmt = $conn->prepare(
                "INSERT INTO progress_logs (patient_id, log_date, weight_kg, waist_cm, body_fat_percent, notes)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param('isddds', $patientId, $logDate, $weight, $waist, $bodyFat, $notes);
            if ($stmt->execute()) {
                $message = 'Progress log added successfully.';
            } else {
                $error = 'Could not add progress log.';
            }
            $stmt->close();
        } else {
            $rowId = (int) ($_POST['row_id'] ?? 0);
            $stmt = $conn->prepare(
                "UPDATE progress_logs
                 SET patient_id = ?, log_date = ?, weight_kg = ?, waist_cm = ?, body_fat_percent = ?, notes = ?
                 WHERE id = ?"
            );
            $stmt->bind_param('isdddsi', $patientId, $logDate, $weight, $waist, $bodyFat, $notes, $rowId);
            if ($stmt->execute()) {
                $message = 'Progress log updated successfully.';
            } else {
                $error = 'Could not update progress log.';
            }
            $stmt->close();
        }
        $activeSection = 'progress_logs';
    }

    if ($entity === 'payments' && ($action === 'create' || $action === 'update')) {
        $patientId = (int) ($_POST['patient_ref_id'] ?? 0);
        $amount = trim($_POST['amount'] ?? '') !== '' ? (float) $_POST['amount'] : 0;
        $paymentDate = trim($_POST['payment_date'] ?? '');
        $paymentMethod = trim($_POST['payment_method'] ?? '');
        $status = trim($_POST['status'] ?? 'paid');
        $notes = trim($_POST['notes'] ?? '');

        if ($patientId <= 0 || $amount <= 0 || $paymentDate === '' || $paymentMethod === '') {
            $error = 'Patient, Amount, Payment Date and Method are required.';
        } elseif ($action === 'create') {
            $stmt = $conn->prepare(
                "INSERT INTO payments (patient_id, amount, payment_date, payment_method, status, notes)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param('idssss', $patientId, $amount, $paymentDate, $paymentMethod, $status, $notes);
            if ($stmt->execute()) {
                $message = 'Payment recorded successfully.';
            } else {
                $error = 'Could not record payment.';
            }
            $stmt->close();
        } else {
            $rowId = (int) ($_POST['row_id'] ?? 0);
            $stmt = $conn->prepare(
                "UPDATE payments
                 SET patient_id = ?, amount = ?, payment_date = ?, payment_method = ?, status = ?, notes = ?
                 WHERE id = ?"
            );
            $stmt->bind_param('idssssi', $patientId, $amount, $paymentDate, $paymentMethod, $status, $notes, $rowId);
            if ($stmt->execute()) {
                $message = 'Payment updated successfully.';
            } else {
                $error = 'Could not update payment.';
            }
            $stmt->close();
        }
        $activeSection = 'payments';
    }
}

if (isset($_GET['delete_patient'])) {
    $id = (int) $_GET['delete_patient'];
    $stmt = $conn->prepare("DELETE FROM patients WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $message = 'Patient deleted.';
    $activeSection = 'patients';
}

if (isset($_GET['delete_diet_plan'])) {
    $id = (int) $_GET['delete_diet_plan'];
    $stmt = $conn->prepare("DELETE FROM diet_plans WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $message = 'Diet plan deleted.';
    $activeSection = 'diet_plans';
}

if (isset($_GET['delete_appointment'])) {
    $id = (int) $_GET['delete_appointment'];
    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $message = 'Appointment deleted.';
    $activeSection = 'appointments';
}

if (isset($_GET['delete_meal_log'])) {
    $id = (int) $_GET['delete_meal_log'];
    $stmt = $conn->prepare("DELETE FROM meal_logs WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $message = 'Meal log deleted.';
    $activeSection = 'meal_logs';
}

if (isset($_GET['delete_progress_log'])) {
    $id = (int) $_GET['delete_progress_log'];
    $stmt = $conn->prepare("DELETE FROM progress_logs WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $message = 'Progress log deleted.';
    $activeSection = 'progress_logs';
}

if (isset($_GET['delete_payment'])) {
    $id = (int) $_GET['delete_payment'];
    $stmt = $conn->prepare("DELETE FROM payments WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $message = 'Payment deleted.';
    $activeSection = 'payments';
}

if (isset($_GET['edit_patient'])) {
    $id = (int) $_GET['edit_patient'];
    $stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $editPatient = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $activeSection = 'patients';
}

if (isset($_GET['edit_diet_plan'])) {
    $id = (int) $_GET['edit_diet_plan'];
    $stmt = $conn->prepare("SELECT * FROM diet_plans WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $editDietPlan = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $activeSection = 'diet_plans';
}

if (isset($_GET['edit_appointment'])) {
    $id = (int) $_GET['edit_appointment'];
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $editAppointment = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $activeSection = 'appointments';
}

if (isset($_GET['edit_meal_log'])) {
    $id = (int) $_GET['edit_meal_log'];
    $stmt = $conn->prepare("SELECT * FROM meal_logs WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $editMealLog = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $activeSection = 'meal_logs';
}

if (isset($_GET['edit_progress_log'])) {
    $id = (int) $_GET['edit_progress_log'];
    $stmt = $conn->prepare("SELECT * FROM progress_logs WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $editProgressLog = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $activeSection = 'progress_logs';
}

if (isset($_GET['edit_payment'])) {
    $id = (int) $_GET['edit_payment'];
    $stmt = $conn->prepare("SELECT * FROM payments WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $editPayment = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $activeSection = 'payments';
}

$patientsResult = $conn->query("SELECT * FROM patients ORDER BY id DESC");
$patientsForSelect = $conn->query("SELECT id, patient_id, full_name FROM patients ORDER BY full_name ASC");
$dietPlansResult = $conn->query("SELECT d.*, p.full_name, p.patient_id AS patient_code FROM diet_plans d JOIN patients p ON p.id = d.patient_id ORDER BY d.id DESC");
$appointmentsResult = $conn->query("SELECT a.*, p.full_name, p.patient_id AS patient_code FROM appointments a JOIN patients p ON p.id = a.patient_id ORDER BY a.appointment_date DESC, a.appointment_time DESC");
$mealLogsResult = $conn->query("SELECT m.*, p.full_name, p.patient_id AS patient_code, d.plan_name FROM meal_logs m JOIN patients p ON p.id = m.patient_id LEFT JOIN diet_plans d ON d.id = m.diet_plan_id ORDER BY m.meal_date DESC");
$progressLogsResult = $conn->query("SELECT g.*, p.full_name, p.patient_id AS patient_code FROM progress_logs g JOIN patients p ON p.id = g.patient_id ORDER BY g.log_date DESC");
$paymentsResult = $conn->query("SELECT py.*, p.full_name, p.patient_id AS patient_code FROM payments py JOIN patients p ON p.id = py.patient_id ORDER BY py.payment_date DESC");
$dietPlansForSelect = $conn->query("SELECT id, plan_name FROM diet_plans ORDER BY plan_name ASC");

require __DIR__ . '/dashboard.view.php';
