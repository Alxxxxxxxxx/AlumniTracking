<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '../../Backend/db_connect.php';

    $id_number = $_POST['id_number'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $nature_of_work = $_POST['nature_of_work'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO alumni (id_number, name, age, nature_of_work, address, password)
            VALUES ('$id_number', '$name', $age, '$nature_of_work', '$address', '$password')";
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
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Sign Up</button>
</form>
