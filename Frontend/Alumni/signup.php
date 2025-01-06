<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '../../Backend/db_connect.php';

    $id_number = $_POST['id_number'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $nature_of_work = $_POST['nature_of_work'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $graduation_year = $_POST['graduation_year'];
    $program_of_study = $_POST['program_of_study'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Adjust your SQL query to include the new fields
    $sql = "INSERT INTO alumni (id_number, name, age, nature_of_work, address, email, phone_number, graduation_year, program_of_study, password)
            VALUES ('$id_number', '$name', $age, '$nature_of_work', '$address', '$email', '$phone_number', '$graduation_year', '$program_of_study', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST">
    <input type="text" name="id_number" placeholder="ID Number" required />
    <input type="text" name="name" placeholder="Name" required />
    <input type="number" name="age" placeholder="Age" required />
    <input type="text" name="nature_of_work" placeholder="Nature of Work" />
    <input type="text" name="address" placeholder="Address" />
    <input type="email" name="email" placeholder="Email" required />
    <input type="text" name="phone_number" placeholder="Phone Number" />
    <input type="text" name="graduation_year" placeholder="Graduation Year" />
    <input type="text" name="program_of_study" placeholder="Program of Study" />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Sign Up</button>
</form>
