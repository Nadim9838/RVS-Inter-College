<body id="inner_page" data-spy="scroll" data-target="#navbar-wd" data-offset="98">

<?php include 'header.php'; ?>

<!-- section -->
<section class="inner_banner">
  <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="full">
            <h3>Department and Faculties</h3>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end section -->

<?php 
include 'admin/database.php';
$sql = "SELECT department, faculty_name, post, faculty_image FROM department ORDER BY faculty_name";
$result = mysqli_query($conn,$sql);

$departments = [];
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
  $departments[$row['department']][] = $row;
}
}
mysqli_close($conn);
?>

<!-- section -->
<div class="container">
  <?php
    $index = 1;
    foreach ($departments as $department => $facultyList): ?>
        <h2 class="mt-5"><?php echo "$index. ".$department; ?></h2>
        <table class="table table-striped faculty-table">
            <thead>
                <tr>
                    <th>Faculty Name</th>
                    <th>Post</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facultyList as $faculty): ?>
                    <tr>
                        <td><?php echo $faculty['faculty_name']; ?></td>
                        <td><?php echo $faculty['post']; ?></td>
                        <td><img src="admin/faculty-image/<?php echo $faculty['faculty_image']; ?>" alt="Faculty Image" class="faculty-image"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
  <?php $index++; endforeach; ?>
</div>
<!-- end section -->


<!-- Footer Section  -->
<?php include 'footer.php' ?>
<!-- Footer Section end  -->

</body>

</html>