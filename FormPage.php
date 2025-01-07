<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Form</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4 text-center">Log In</h2>
    <p class="text-center">
        Rest assured that your information for this questionnaire will be treated with confidentiality.
        <br><small>*Add Data Privacy Act and Terms & Conditions</small>
    </p>
    <form action="process_form.php" method="POST">
        <!-- PART 1: PERSONAL INFORMATION -->
        <h4 class="mb-3">Personal Information</h4>
        <p>Be reminded that if no answers are applicable, write or choose "N/A.”.</p>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="privacy_consent" id="privacy_consent" class="form-check-input" required>
            <label for="privacy_consent" class="form-check-label">
                I have read and understood the information and details provided by the research. I, therefore, give consent to participate in this study.
            </label>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="present_location" class="form-label">Present Location</label>
            <select name="present_location" id="present_location" class="form-select" required>
                <option value="In the Philippines">In the Philippines</option>
                <option value="Foreign Country">Foreign Country</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="present_address" class="form-label">Present Address</label>
            <input type="text" name="present_address" id="present_address" class="form-control" placeholder="Ex. Sta. Mesa, Manila, Philippines" required>
        </div>
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" name="contact_number" id="contact_number" class="form-control" required>
        </div>

        <!-- PART 2: STRAND AND GRADUATION YEAR -->
        <h4 class="mb-3">Strand and Graduation Year</h4>
        <div class="mb-3">
            <label class="form-label">Strand</label>
            <div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Humanities and Social Sciences" id="strand_humss" class="form-check-input" required>
                    <label for="strand_humss" class="form-check-label">Humanities and Social Sciences</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Science, Technology, Engineering, and Mathematics" id="strand_stem" class="form-check-input" required>
                    <label for="strand_stem" class="form-check-label">Science, Technology, Engineering, and Mathematics</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Accountancy, Businesses, and Management" id="strand_abm" class="form-check-input" required>
                    <label for="strand_abm" class="form-check-label">Accountancy, Businesses, and Management</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Information and Communication Technology" id="strand_ict" class="form-check-input" required>
                    <label for="strand_ict" class="form-check-label">Information and Communication Technology</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Food and Beverages" id="strand_food" class="form-check-input" required>
                    <label for="strand_food" class="form-check-label">Food and Beverages</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Others" id="strand_others" class="form-check-input" required>
                    <label for="strand_others" class="form-check-label">Others</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="years_of_enrollment" class="form-label">Years of Enrollment</label>
            <input type="text" name="years_of_enrollment" id="years_of_enrollment" class="form-control" placeholder="Ex. 2020 - 2024" required>
        </div>

        <!-- PART 3: CONNECTION TO SCHOOL -->
        <h4 class="mb-3">Connection to Sacred Heart of Jesus Catholic School</h4>
        <div class="mb-3">
            <label for="involvement" class="form-label">Involvement</label>
            <input type="text" name="involvement" id="involvement" class="form-control" placeholder="Ex. SC President 2024-2025" required>
        </div>
        <div class="mb-3">
            <label for="academic_awards" class="form-label">Graduation Academic Awards</label>
            <input type="text" name="academic_awards" id="academic_awards" class="form-control" placeholder="Ex. With Honors, Valedictorian (2025)" required>
        </div>

        <!-- PART 4: EMPLOYMENT -->
        <h4 class="mb-3">Employment</h4>
        <div class="mb-3">
            <label for="current_status" class="form-label">Current Status</label>
            <select name="current_status" id="current_status" class="form-select" required>
                <option value="Secondary Student">Secondary Student</option>
                <option value="Tertiary Student">Tertiary Student</option>
                <option value="Graduate School">Graduate School</option>
                <option value="Working Student">Working Student</option>
                <option value="Employed">Employed</option>
                <option value="Self-Employed">Self-Employed</option>
                <option value="Not-Employed">Not-Employed</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="university_employer" class="form-label">Name of University / Business / Employer</label>
            <input type="text" name="university_employer" id="university_employer" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="position_year_level" class="form-label">Position / Year Level</label>
            <input type="text" name="position_year_level" id="position_year_level" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="sector" class="form-label">Sector</label>
            <select name="sector" id="sector" class="form-select" required>
                <option value="Private">Private</option>
                <option value="Public">Public</option>
                <option value="Government">Government</option>
                <option value="NGO">NGO</option>
                <option value="Non-Profit">Non-Profit</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="type_of_employment" class="form-label">Type of Employment</label>
            <select name="type_of_employment" id="type_of_employment" class="form-select" required>
                <option value="Full-time">Full-time</option>
                <option value="Part-Time">Part-Time</option>
                <option value="Others">Others</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="year_hired" class="form-label">Year When Hired / Enrolled / Established</label>
            <input type="text" name="year_hired" id="year_hired" class="form-control" required>
        </div>

        <!-- PART 5: CONFIRMATION -->
        <h4 class="mb-3">Confirmation</h4>
        <div class="form-check mb-3">
            <input type="checkbox" name="confirm_data" id="confirm_data" class="form-check-input" required>
            <label for="confirm_data" class="form-check-label">
                I confirm that all the information given is true and honest.
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
