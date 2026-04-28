<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>DietTrack | Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../img/favicon.ico" rel="icon">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <style>
        body {
            background: #f5f9fc;
        }
        .dashboard-shell {
            min-height: 100vh;
        }
        .sidebar-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 0 45px rgba(0, 0, 0, 0.06);
            background: linear-gradient(180deg, #0f172a 0%, #11243b 100%);
            color: #fff;
            position: sticky;
            top: 24px;
        }
        .sidebar-card .brand-title {
            font-size: 1.45rem;
            font-weight: 700;
        }
        .sidebar-card .brand-subtitle {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.95rem;
        }
        .menu-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255, 255, 255, 0.84);
            text-decoration: none;
            padding: 0.95rem 1rem;
            border-radius: 12px;
            margin-bottom: 0.55rem;
            transition: 0.2s ease;
            border: 1px solid transparent;
        }
        .menu-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.1);
        }
        .menu-link.active {
            color: #fff;
            background: var(--primary);
            box-shadow: 0 10px 25px rgba(4, 187, 133, 0.28);
        }
        .menu-step {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            opacity: 0.72;
        }
        .menu-title {
            display: block;
            font-weight: 600;
            line-height: 1.25;
        }
        .menu-icon {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            font-weight: 700;
            flex-shrink: 0;
        }
        .content-card,
        .card-soft {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 0 45px rgba(0, 0, 0, 0.06);
            background: #fff;
        }
        .content-card {
            padding: 1.5rem;
        }
        .topbar-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 0 45px rgba(0, 0, 0, 0.06);
            background: linear-gradient(135deg, rgba(4, 187, 133, 0.08), rgba(255, 255, 255, 1));
        }
        .summary-box {
            border-radius: 14px;
            background: #fff;
            border: 1px solid #eef2f7;
            padding: 1rem 1.1rem;
            height: 100%;
        }
        .summary-label {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }
        .summary-value {
            font-size: 1.55rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        .table-wrap {
            overflow-x: auto;
        }
        .step-title {
            margin-bottom: 0.35rem;
            font-weight: 700;
            color: #0f172a;
        }
        .section-subtitle {
            color: #6b7280;
            margin-bottom: 1.35rem;
        }
        .table thead th {
            white-space: nowrap;
            font-size: 0.88rem;
            color: #334155;
        }
        .table td {
            vertical-align: middle;
        }
        .form-label {
            font-weight: 600;
            color: #334155;
        }
        .btn {
            border-radius: 10px;
        }
        .section-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        @media (max-width: 991.98px) {
            .sidebar-card {
                position: static;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4 py-lg-5">
        <div class="row g-4 dashboard-shell">
            <div class="col-xl-3 col-lg-4">
                <div class="sidebar-card p-4">
                    <div class="mb-4">
                        <div class="brand-title">DietTrack Admin</div>
                        <div class="brand-subtitle">Manage patients, plans, bookings, meals, progress, and payments.</div>
                    </div>

                    <div class="mb-3">
                        <a class="menu-link <?php echo $activeSection === 'patients' ? 'active' : ''; ?>" href="dashboard.php?section=patients">
                            <span class="menu-icon">1</span>
                            <span>
                                <span class="menu-step">Step 1</span>
                                <span class="menu-title">Patient Management</span>
                            </span>
                        </a>
                        <a class="menu-link <?php echo $activeSection === 'diet_plans' ? 'active' : ''; ?>" href="dashboard.php?section=diet_plans">
                            <span class="menu-icon">2</span>
                            <span>
                                <span class="menu-step">Step 2</span>
                                <span class="menu-title">Diet Plan Assignment</span>
                            </span>
                        </a>
                        <a class="menu-link <?php echo $activeSection === 'appointments' ? 'active' : ''; ?>" href="dashboard.php?section=appointments">
                            <span class="menu-icon">3</span>
                            <span>
                                <span class="menu-step">Step 3</span>
                                <span class="menu-title">Appointments</span>
                            </span>
                        </a>
                        <a class="menu-link <?php echo $activeSection === 'meal_logs' ? 'active' : ''; ?>" href="dashboard.php?section=meal_logs">
                            <span class="menu-icon">4</span>
                            <span>
                                <span class="menu-step">Step 4</span>
                                <span class="menu-title">Meal Tracking</span>
                            </span>
                        </a>
                        <a class="menu-link <?php echo $activeSection === 'progress_logs' ? 'active' : ''; ?>" href="dashboard.php?section=progress_logs">
                            <span class="menu-icon">5</span>
                            <span>
                                <span class="menu-step">Step 5</span>
                                <span class="menu-title">Progress Monitoring</span>
                            </span>
                        </a>
                        <a class="menu-link <?php echo $activeSection === 'payments' ? 'active' : ''; ?>" href="dashboard.php?section=payments">
                            <span class="menu-icon">6</span>
                            <span>
                                <span class="menu-step">Step 6</span>
                                <span class="menu-title">Payment Management</span>
                            </span>
                        </a>
                    </div>

                    <a href="logout.php" class="btn btn-light w-100 mt-3">Logout</a>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8">
                <div class="topbar-card p-4 mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h2 class="text-primary mb-1">Admin Dashboard</h2>
                            <p class="mb-0">Welcome back, <?php echo htmlspecialchars((string) $_SESSION['admin_username']); ?>. Use the left menu to manage each part of the system.</p>
                        </div>
                        <div class="text-md-end">
                            <span class="badge bg-primary fs-6 px-3 py-2"><?php echo htmlspecialchars(str_replace('_', ' ', ucfirst($activeSection))); ?></span>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="summary-box">
                            <div class="summary-label">Current Module</div>
                            <p class="summary-value"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $activeSection))); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-box">
                            <div class="summary-label">Admin User</div>
                            <p class="summary-value"><?php echo htmlspecialchars((string) $_SESSION['admin_username']); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-box">
                            <div class="summary-label">System Status</div>
                            <p class="summary-value">Active</p>
                        </div>
                    </div>
                </div>

                <?php if ($message !== ''): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

        <?php if ($activeSection === 'patients'): ?>
        <div class="card card-soft mb-4">
            <div class="card-body p-4">
                <h4 class="step-title">Patient Management</h4>
                <p class="section-subtitle"><?php echo $editPatient ? 'Update an existing patient profile.' : 'Create and maintain patient records from one place.'; ?></p>
                <form method="post" action="dashboard.php">
                    <input type="hidden" name="entity" value="patients">
                    <input type="hidden" name="action" value="<?php echo $editPatient ? 'update' : 'create'; ?>">
                    <?php if ($editPatient): ?>
                        <input type="hidden" name="row_id" value="<?php echo (int) $editPatient['id']; ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Patient ID</label>
                            <input type="text" name="patient_id" class="form-control" required
                                   value="<?php echo htmlspecialchars((string) ($editPatient['patient_id'] ?? '')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Name</label>
                            <input type="text" name="full_name" class="form-control" required
                                   value="<?php echo htmlspecialchars((string) ($editPatient['full_name'] ?? '')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control"
                                   value="<?php echo htmlspecialchars((string) ($editPatient['dob'] ?? '')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="form-control" min="0"
                                   value="<?php echo htmlspecialchars((string) ($editPatient['age'] ?? '')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control"
                                   value="<?php echo htmlspecialchars((string) ($editPatient['phone_number'] ?? '')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" min="0" name="weight_kg" class="form-control"
                                   value="<?php echo htmlspecialchars((string) ($editPatient['weight_kg'] ?? '')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tall / Height (cm)</label>
                            <input type="number" step="0.01" min="0" name="height_cm" class="form-control"
                                   value="<?php echo htmlspecialchars((string) ($editPatient['height_cm'] ?? '')); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"><?php echo htmlspecialchars((string) ($editPatient['address'] ?? '')); ?></textarea>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button class="btn btn-primary" type="submit"><?php echo $editPatient ? 'Update Patient' : 'Add Patient'; ?></button>
                            <?php if ($editPatient): ?>
                                <a href="dashboard.php?section=patients" class="btn btn-outline-secondary">Cancel Edit</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($activeSection === 'patients'): ?>
        <div class="card card-soft mb-4">
            <div class="card-body p-4">
                <h5 class="mb-3">All Patients</h5>
                <div class="table-wrap">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Age</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Weight</th>
                                <th>Tall/Height</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($patientsResult && $patientsResult->num_rows > 0): ?>
                                <?php while ($patient = $patientsResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo (int) $patient['id']; ?></td>
                                        <td><?php echo htmlspecialchars((string) $patient['patient_id']); ?></td>
                                        <td><?php echo htmlspecialchars((string) $patient['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($patient['dob'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($patient['age'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($patient['phone_number'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($patient['address'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($patient['weight_kg'] ?? '')); ?> kg</td>
                                        <td><?php echo htmlspecialchars((string) ($patient['height_cm'] ?? '')); ?> cm</td>
                                        <td>
                                            <a href="dashboard.php?section=patients&edit_patient=<?php echo (int) $patient['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <a href="dashboard.php?section=patients&delete_patient=<?php echo (int) $patient['id']; ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Delete this patient?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">No patients found yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($activeSection === 'diet_plans'): ?>
        <div class="card card-soft mb-4">
            <div class="card-body p-4">
                <h4 class="step-title">Diet Plan Assignment</h4>
                <p class="section-subtitle"><?php echo $editDietPlan ? 'Edit the selected patient diet plan.' : 'Assign structured diet plans and monitor their status.'; ?></p>
                <form method="post" action="dashboard.php?section=diet_plans">
                    <input type="hidden" name="entity" value="diet_plans">
                    <input type="hidden" name="action" value="<?php echo $editDietPlan ? 'update' : 'create'; ?>">
                    <?php if ($editDietPlan): ?><input type="hidden" name="row_id" value="<?php echo (int) $editDietPlan['id']; ?>"><?php endif; ?>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Patient</label>
                            <select name="patient_ref_id" class="form-select" required>
                                <option value="">Select patient</option>
                                <?php if ($patientsForSelect): while ($p = $patientsForSelect->fetch_assoc()): ?>
                                    <option value="<?php echo (int) $p['id']; ?>" <?php echo ((int) ($editDietPlan['patient_id'] ?? 0) === (int) $p['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($p['patient_id'] . ' - ' . $p['full_name']); ?>
                                    </option>
                                <?php endwhile; endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Plan Name</label><input type="text" name="plan_name" class="form-control" required value="<?php echo htmlspecialchars((string) ($editDietPlan['plan_name'] ?? '')); ?>"></div>
                        <div class="col-md-4"><label class="form-label">Calories/Day</label><input type="number" name="calories_per_day" class="form-control" value="<?php echo htmlspecialchars((string) ($editDietPlan['calories_per_day'] ?? '')); ?>"></div>
                        <div class="col-md-4"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars((string) ($editDietPlan['start_date'] ?? '')); ?>"></div>
                        <div class="col-md-4"><label class="form-label">End Date</label><input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars((string) ($editDietPlan['end_date'] ?? '')); ?>"></div>
                        <div class="col-md-4"><label class="form-label">Status</label><input type="text" name="status" class="form-control" value="<?php echo htmlspecialchars((string) ($editDietPlan['status'] ?? 'active')); ?>"></div>
                        <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"><?php echo htmlspecialchars((string) ($editDietPlan['description'] ?? '')); ?></textarea></div>
                        <div class="col-12 section-actions">
                            <button class="btn btn-primary" type="submit"><?php echo $editDietPlan ? 'Update Diet Plan' : 'Assign Diet Plan'; ?></button>
                            <?php if ($editDietPlan): ?><a href="dashboard.php?section=diet_plans" class="btn btn-outline-secondary">Cancel Edit</a><?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-soft mb-4"><div class="card-body p-4"><h6>Diet Plans List</h6><div class="table-wrap"><table class="table table-bordered"><thead><tr><th>#</th><th>Patient</th><th>Plan</th><th>Calories</th><th>Dates</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php if ($dietPlansResult && $dietPlansResult->num_rows > 0): while ($row = $dietPlansResult->fetch_assoc()): ?><tr><td><?php echo (int) $row['id']; ?></td><td><?php echo htmlspecialchars($row['patient_code'] . ' - ' . $row['full_name']); ?></td><td><?php echo htmlspecialchars((string) $row['plan_name']); ?></td><td><?php echo htmlspecialchars((string) ($row['calories_per_day'] ?? '')); ?></td><td><?php echo htmlspecialchars((string) ($row['start_date'] ?? '')); ?> to <?php echo htmlspecialchars((string) ($row['end_date'] ?? '')); ?></td><td><?php echo htmlspecialchars((string) $row['status']); ?></td><td><a class="btn btn-sm btn-outline-primary" href="dashboard.php?section=diet_plans&edit_diet_plan=<?php echo (int) $row['id']; ?>">Edit</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this diet plan?');" href="dashboard.php?section=diet_plans&delete_diet_plan=<?php echo (int) $row['id']; ?>">Delete</a></td></tr><?php endwhile; else: ?><tr><td colspan="7" class="text-center">No diet plans yet.</td></tr><?php endif; ?></tbody></table></div></div></div>
        <?php endif; ?>

        <?php if ($activeSection === 'appointments'): ?>
        <div class="card card-soft mb-4">
            <div class="card-body p-4">
                <h4 class="step-title">Appointment Scheduling</h4>
                <p class="section-subtitle"><?php echo $editAppointment ? 'Edit the selected clinic appointment.' : 'Book and manage appointments with dieticians.'; ?></p>
                <form method="post" action="dashboard.php?section=appointments">
                    <input type="hidden" name="entity" value="appointments">
                    <input type="hidden" name="action" value="<?php echo $editAppointment ? 'update' : 'create'; ?>">
                    <?php if ($editAppointment): ?><input type="hidden" name="row_id" value="<?php echo (int) $editAppointment['id']; ?>"><?php endif; ?>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Patient</label><select name="patient_ref_id" class="form-select" required><option value="">Select patient</option><?php if ($patientsForSelect): $patientsForSelect->data_seek(0); while ($p = $patientsForSelect->fetch_assoc()): ?><option value="<?php echo (int) $p['id']; ?>" <?php echo ((int) ($editAppointment['patient_id'] ?? 0) === (int) $p['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($p['patient_id'] . ' - ' . $p['full_name']); ?></option><?php endwhile; endif; ?></select></div>
                        <div class="col-md-4"><label class="form-label">Dietician</label><input type="text" name="dietician_name" class="form-control" required value="<?php echo htmlspecialchars((string) ($editAppointment['dietician_name'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Date</label><input type="date" name="appointment_date" class="form-control" required value="<?php echo htmlspecialchars((string) ($editAppointment['appointment_date'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Time</label><input type="time" name="appointment_time" class="form-control" required value="<?php echo htmlspecialchars((string) ($editAppointment['appointment_time'] ?? '')); ?>"></div>
                        <div class="col-md-4"><label class="form-label">Status</label><input type="text" name="status" class="form-control" value="<?php echo htmlspecialchars((string) ($editAppointment['status'] ?? 'scheduled')); ?>"></div>
                        <div class="col-md-8"><label class="form-label">Notes</label><input type="text" name="notes" class="form-control" value="<?php echo htmlspecialchars((string) ($editAppointment['notes'] ?? '')); ?>"></div>
                        <div class="col-12 section-actions"><button class="btn btn-primary" type="submit"><?php echo $editAppointment ? 'Update Appointment' : 'Book Appointment'; ?></button><?php if ($editAppointment): ?><a href="dashboard.php?section=appointments" class="btn btn-outline-secondary">Cancel Edit</a><?php endif; ?></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-soft mb-4"><div class="card-body p-4"><h6>Appointments List</h6><div class="table-wrap"><table class="table table-bordered"><thead><tr><th>#</th><th>Patient</th><th>Dietician</th><th>Date</th><th>Time</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php if ($appointmentsResult && $appointmentsResult->num_rows > 0): while ($row = $appointmentsResult->fetch_assoc()): ?><tr><td><?php echo (int) $row['id']; ?></td><td><?php echo htmlspecialchars($row['patient_code'] . ' - ' . $row['full_name']); ?></td><td><?php echo htmlspecialchars((string) $row['dietician_name']); ?></td><td><?php echo htmlspecialchars((string) $row['appointment_date']); ?></td><td><?php echo htmlspecialchars((string) $row['appointment_time']); ?></td><td><?php echo htmlspecialchars((string) $row['status']); ?></td><td><a class="btn btn-sm btn-outline-primary" href="dashboard.php?section=appointments&edit_appointment=<?php echo (int) $row['id']; ?>">Edit</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this appointment?');" href="dashboard.php?section=appointments&delete_appointment=<?php echo (int) $row['id']; ?>">Delete</a></td></tr><?php endwhile; else: ?><tr><td colspan="7" class="text-center">No appointments yet.</td></tr><?php endif; ?></tbody></table></div></div></div>
        <?php endif; ?>

        <?php if ($activeSection === 'meal_logs'): ?>
        <div class="card card-soft mb-4">
            <div class="card-body p-4">
                <h4 class="step-title">Meal Tracking</h4>
                <p class="section-subtitle"><?php echo $editMealLog ? 'Edit the selected meal tracking record.' : 'Track patient meals and compare them against diet plans.'; ?></p>
                <form method="post" action="dashboard.php?section=meal_logs">
                    <input type="hidden" name="entity" value="meal_logs">
                    <input type="hidden" name="action" value="<?php echo $editMealLog ? 'update' : 'create'; ?>">
                    <?php if ($editMealLog): ?><input type="hidden" name="row_id" value="<?php echo (int) $editMealLog['id']; ?>"><?php endif; ?>
                    <div class="row g-3">
                        <div class="col-md-3"><label class="form-label">Patient</label><select name="patient_ref_id" class="form-select" required><option value="">Select patient</option><?php if ($patientsForSelect): $patientsForSelect->data_seek(0); while ($p = $patientsForSelect->fetch_assoc()): ?><option value="<?php echo (int) $p['id']; ?>" <?php echo ((int) ($editMealLog['patient_id'] ?? 0) === (int) $p['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($p['patient_id'] . ' - ' . $p['full_name']); ?></option><?php endwhile; endif; ?></select></div>
                        <div class="col-md-3"><label class="form-label">Diet Plan (optional)</label><select name="diet_plan_ref_id" class="form-select"><option value="">Select plan</option><?php if ($dietPlansForSelect): while ($plan = $dietPlansForSelect->fetch_assoc()): ?><option value="<?php echo (int) $plan['id']; ?>" <?php echo ((int) ($editMealLog['diet_plan_id'] ?? 0) === (int) $plan['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars((string) $plan['plan_name']); ?></option><?php endwhile; endif; ?></select></div>
                        <div class="col-md-2"><label class="form-label">Meal Date</label><input type="date" name="meal_date" class="form-control" required value="<?php echo htmlspecialchars((string) ($editMealLog['meal_date'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Meal Type</label><input type="text" name="meal_type" class="form-control" placeholder="Breakfast" required value="<?php echo htmlspecialchars((string) ($editMealLog['meal_type'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Status</label><input type="text" name="adherence_status" class="form-control" value="<?php echo htmlspecialchars((string) ($editMealLog['adherence_status'] ?? 'on_track')); ?>"></div>
                        <div class="col-12"><label class="form-label">Meal Details</label><textarea name="meal_details" class="form-control" rows="2"><?php echo htmlspecialchars((string) ($editMealLog['meal_details'] ?? '')); ?></textarea></div>
                        <div class="col-12 section-actions"><button class="btn btn-primary" type="submit"><?php echo $editMealLog ? 'Update Meal Record' : 'Add Meal Record'; ?></button><?php if ($editMealLog): ?><a href="dashboard.php?section=meal_logs" class="btn btn-outline-secondary">Cancel Edit</a><?php endif; ?></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-soft mb-4"><div class="card-body p-4"><h6>Meal Logs</h6><div class="table-wrap"><table class="table table-bordered"><thead><tr><th>#</th><th>Patient</th><th>Plan</th><th>Date</th><th>Type</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php if ($mealLogsResult && $mealLogsResult->num_rows > 0): while ($row = $mealLogsResult->fetch_assoc()): ?><tr><td><?php echo (int) $row['id']; ?></td><td><?php echo htmlspecialchars($row['patient_code'] . ' - ' . $row['full_name']); ?></td><td><?php echo htmlspecialchars((string) ($row['plan_name'] ?? '')); ?></td><td><?php echo htmlspecialchars((string) $row['meal_date']); ?></td><td><?php echo htmlspecialchars((string) $row['meal_type']); ?></td><td><?php echo htmlspecialchars((string) $row['adherence_status']); ?></td><td><a class="btn btn-sm btn-outline-primary" href="dashboard.php?section=meal_logs&edit_meal_log=<?php echo (int) $row['id']; ?>">Edit</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this meal log?');" href="dashboard.php?section=meal_logs&delete_meal_log=<?php echo (int) $row['id']; ?>">Delete</a></td></tr><?php endwhile; else: ?><tr><td colspan="7" class="text-center">No meal logs yet.</td></tr><?php endif; ?></tbody></table></div></div></div>
        <?php endif; ?>

        <?php if ($activeSection === 'progress_logs'): ?>
        <div class="card card-soft mb-4">
            <div class="card-body p-4">
                <h4 class="step-title">Progress Monitoring</h4>
                <p class="section-subtitle"><?php echo $editProgressLog ? 'Edit the selected progress measurement.' : 'Track weight, measurements, and patient progress over time.'; ?></p>
                <form method="post" action="dashboard.php?section=progress_logs">
                    <input type="hidden" name="entity" value="progress_logs">
                    <input type="hidden" name="action" value="<?php echo $editProgressLog ? 'update' : 'create'; ?>">
                    <?php if ($editProgressLog): ?><input type="hidden" name="row_id" value="<?php echo (int) $editProgressLog['id']; ?>"><?php endif; ?>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Patient</label><select name="patient_ref_id" class="form-select" required><option value="">Select patient</option><?php if ($patientsForSelect): $patientsForSelect->data_seek(0); while ($p = $patientsForSelect->fetch_assoc()): ?><option value="<?php echo (int) $p['id']; ?>" <?php echo ((int) ($editProgressLog['patient_id'] ?? 0) === (int) $p['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($p['patient_id'] . ' - ' . $p['full_name']); ?></option><?php endwhile; endif; ?></select></div>
                        <div class="col-md-2"><label class="form-label">Date</label><input type="date" name="log_date" class="form-control" required value="<?php echo htmlspecialchars((string) ($editProgressLog['log_date'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Weight (kg)</label><input type="number" step="0.01" name="weight_kg" class="form-control" value="<?php echo htmlspecialchars((string) ($editProgressLog['weight_kg'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Waist (cm)</label><input type="number" step="0.01" name="waist_cm" class="form-control" value="<?php echo htmlspecialchars((string) ($editProgressLog['waist_cm'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Body Fat %</label><input type="number" step="0.01" name="body_fat_percent" class="form-control" value="<?php echo htmlspecialchars((string) ($editProgressLog['body_fat_percent'] ?? '')); ?>"></div>
                        <div class="col-12"><label class="form-label">Notes</label><input type="text" name="notes" class="form-control" value="<?php echo htmlspecialchars((string) ($editProgressLog['notes'] ?? '')); ?>"></div>
                        <div class="col-12 section-actions"><button class="btn btn-primary" type="submit"><?php echo $editProgressLog ? 'Update Progress Entry' : 'Add Progress Entry'; ?></button><?php if ($editProgressLog): ?><a href="dashboard.php?section=progress_logs" class="btn btn-outline-secondary">Cancel Edit</a><?php endif; ?></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-soft mb-4"><div class="card-body p-4"><h6>Progress Logs</h6><div class="table-wrap"><table class="table table-bordered"><thead><tr><th>#</th><th>Patient</th><th>Date</th><th>Weight</th><th>Waist</th><th>Body Fat</th><th>Actions</th></tr></thead><tbody><?php if ($progressLogsResult && $progressLogsResult->num_rows > 0): while ($row = $progressLogsResult->fetch_assoc()): ?><tr><td><?php echo (int) $row['id']; ?></td><td><?php echo htmlspecialchars($row['patient_code'] . ' - ' . $row['full_name']); ?></td><td><?php echo htmlspecialchars((string) $row['log_date']); ?></td><td><?php echo htmlspecialchars((string) ($row['weight_kg'] ?? '')); ?></td><td><?php echo htmlspecialchars((string) ($row['waist_cm'] ?? '')); ?></td><td><?php echo htmlspecialchars((string) ($row['body_fat_percent'] ?? '')); ?></td><td><a class="btn btn-sm btn-outline-primary" href="dashboard.php?section=progress_logs&edit_progress_log=<?php echo (int) $row['id']; ?>">Edit</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this progress log?');" href="dashboard.php?section=progress_logs&delete_progress_log=<?php echo (int) $row['id']; ?>">Delete</a></td></tr><?php endwhile; else: ?><tr><td colspan="7" class="text-center">No progress logs yet.</td></tr><?php endif; ?></tbody></table></div></div></div>
        <?php endif; ?>

        <?php if ($activeSection === 'payments'): ?>
        <div class="card card-soft mb-4">
            <div class="card-body p-4">
                <h4 class="step-title">Payment Management</h4>
                <p class="section-subtitle"><?php echo $editPayment ? 'Edit the selected payment record.' : 'Record plan and consultation payments for each patient.'; ?></p>
                <form method="post" action="dashboard.php?section=payments">
                    <input type="hidden" name="entity" value="payments">
                    <input type="hidden" name="action" value="<?php echo $editPayment ? 'update' : 'create'; ?>">
                    <?php if ($editPayment): ?><input type="hidden" name="row_id" value="<?php echo (int) $editPayment['id']; ?>"><?php endif; ?>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Patient</label><select name="patient_ref_id" class="form-select" required><option value="">Select patient</option><?php if ($patientsForSelect): $patientsForSelect->data_seek(0); while ($p = $patientsForSelect->fetch_assoc()): ?><option value="<?php echo (int) $p['id']; ?>" <?php echo ((int) ($editPayment['patient_id'] ?? 0) === (int) $p['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($p['patient_id'] . ' - ' . $p['full_name']); ?></option><?php endwhile; endif; ?></select></div>
                        <div class="col-md-2"><label class="form-label">Amount</label><input type="number" step="0.01" name="amount" class="form-control" required value="<?php echo htmlspecialchars((string) ($editPayment['amount'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Payment Date</label><input type="date" name="payment_date" class="form-control" required value="<?php echo htmlspecialchars((string) ($editPayment['payment_date'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Method</label><input type="text" name="payment_method" class="form-control" required value="<?php echo htmlspecialchars((string) ($editPayment['payment_method'] ?? '')); ?>"></div>
                        <div class="col-md-2"><label class="form-label">Status</label><input type="text" name="status" class="form-control" value="<?php echo htmlspecialchars((string) ($editPayment['status'] ?? 'paid')); ?>"></div>
                        <div class="col-12"><label class="form-label">Notes</label><input type="text" name="notes" class="form-control" value="<?php echo htmlspecialchars((string) ($editPayment['notes'] ?? '')); ?>"></div>
                        <div class="col-12 section-actions"><button class="btn btn-primary" type="submit"><?php echo $editPayment ? 'Update Payment' : 'Record Payment'; ?></button><?php if ($editPayment): ?><a href="dashboard.php?section=payments" class="btn btn-outline-secondary">Cancel Edit</a><?php endif; ?></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-soft mb-4"><div class="card-body p-4"><h6>Payments List</h6><div class="table-wrap"><table class="table table-bordered"><thead><tr><th>#</th><th>Patient</th><th>Amount</th><th>Date</th><th>Method</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php if ($paymentsResult && $paymentsResult->num_rows > 0): while ($row = $paymentsResult->fetch_assoc()): ?><tr><td><?php echo (int) $row['id']; ?></td><td><?php echo htmlspecialchars($row['patient_code'] . ' - ' . $row['full_name']); ?></td><td><?php echo htmlspecialchars((string) $row['amount']); ?></td><td><?php echo htmlspecialchars((string) $row['payment_date']); ?></td><td><?php echo htmlspecialchars((string) $row['payment_method']); ?></td><td><?php echo htmlspecialchars((string) $row['status']); ?></td><td><a class="btn btn-sm btn-outline-primary" href="dashboard.php?section=payments&edit_payment=<?php echo (int) $row['id']; ?>">Edit</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this payment?');" href="dashboard.php?section=payments&delete_payment=<?php echo (int) $row['id']; ?>">Delete</a></td></tr><?php endwhile; else: ?><tr><td colspan="7" class="text-center">No payments yet.</td></tr><?php endif; ?></tbody></table></div></div></div>
        <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
