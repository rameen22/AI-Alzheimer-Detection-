<?php

include 'connect2.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Display</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
  <div class="container">
    <button class="btn btn-primary my-5"> <a href="AddPatientInfo.php" class="text-light">Add New Patient
      </a>
    </button>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Gender</th>
          <th scope="col">Operation</th>
        </tr>
      </thead>

      <tbody>

        <?php

        $sql = "Select * from addpatient";
        $result = mysqli_query($con, $sql);
        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $name = $row['name'];
            $gender = $row['gender'];
            echo '<tr>
                                    <th scope="row">' . $id . '</th>
                                    <td>' . $name . '</td>
                                    <td>' . $gender . '</td>
                                    <td>
                                    <buttn><a class="btn btn-primary" href="update.php?updateid='.$id.'">Update</a></buttn>
                                    <buttn><a class="btn btn-danger" href="delete.php?deleteid='.$id.'">Delete</a></buttn>
                                   </td>
                                  </tr>';
          }
        }


        ?>




      </tbody>
    </table>
  </div>

</body>

</html>