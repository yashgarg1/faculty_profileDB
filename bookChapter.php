<?php
require_once 'core/init.php';

$user = new User();

/* user redirect  */
if ($user->isLoggedIn()) {
} else {
  Redirect::to('index.php');
}

/* TEXT BOOK submit */
if (Input::exists() && isset($_POST['csubmit'])) {
  try {

    // fetch variables that are already stored in User from studentinfo table 
    $fname = $user->data()->Name;
    $roll = $user->data()->{'Roll No'};
    $prog = $user->data()->prog;
    $dept = $user->data()->department;
    $ptype = 'c';
    $email = $user->data()->email;
    $aemail = $user->data()->aemail;

    // columns that we get from form input
    $ctitle = Input::get('ctitle');
    $cauthors = Input::get('cauthors');
    $btitle = Input::get('btitle');
    $cpublisher = Input::get('cpublisher');
    $cyear = Input::get('cyear');
    $cbook = Input::get('cbook');
    $clink = Input::get('clink');

    // connect with localhost
    $conn = mysqli_connect("localhost", "root", "jrtalent", "faculty_profile_db");
    if (!$conn)
      die("Unable to connect to database");

    // insert query
    $stmt = "INSERT INTO `faculty_profile_publications` (`sno`, `fname`, `roll`, `dept`, `prog`, `ptype`, `title`, `authors`, `publication`, `publisher`, `pdate`, `location`, `pages`, `onlineLink`, `duration`, `impactFactor`, `bookTitle`, `bookType`, `editedVolume`, `eduPackageType`, `eduPackageLevel`, `patentNo`, `projectBudget`, `projectSponser`, `projectRole`, `projectStatus`, `email`, `aemail`) VALUES (NULL, '$fname', '$roll', '$dept', '$prog', 'bc', '$ctitle', '$cauthors', NULL, '$cpublisher', '$cyear', NULL, NULL, '$clink', NULL, NULL, '$btitle', '$cbook', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$email', '$aemail');";
    // echo $stmt;
    // run insert query
    $result = mysqli_query($conn, $stmt);
  } catch (Exception $e) {
    die($e->getMessage());
  }
}

/* delete */
if (Input::exists() && isset($_POST['delete_entry'])) {

  try {

    $fname = $user->data()->Name;
    $roll = $user->data()->{'Roll No'};
    $prog = $user->data()->prog;
    $dept = $user->data()->department;
    $ptype = 'j';
    $email = $user->data()->email;
    $aemail = $user->data()->aemail;
    // echo $fid;

    // columns that we get from form input
    $ctitle = Input::get('ctitle');
    $cauthors = Input::get('cauthors');
    $cpublisher = Input::get('cpublisher');
    $cyear = Input::get('cyear');
    $btitle = Input::get('btitle');
    $cbook = Input::get('cbook');
    $clink = Input::get('clink');



    // connect with localhost
    $conn = mysqli_connect("localhost", "root", "jrtalent", "faculty_profile_db");
    if (!$conn)
      die("Unable to connect to database");

    // delete query
    $stmt = "DELETE FROM `faculty_profile_publications` WHERE roll='$roll' AND ptype='bc' AND title=$ctitle AND authors=$cauthors AND publisher=$cpublisher AND pdate=$cyear AND bookType=$cbook AND bookTitle=$btitle;";
    //echo $stmt;
    // run delete query
    $result = mysqli_query($conn, $stmt);
  } catch (Exception $e) {

    die($e->getMessage());
  }
}

/* edit */
if (Input::exists() && isset($_POST['edit'])) {
  try {

    $roll = $user->data()->{'Roll No'};

    // new input
    $ctitle = Input::get('ctitle');
    $cauthors = Input::get('cauthors');
    $cpublisher = Input::get('cpublisher');
    $cyear = Input::get('cyear');
    $cbook = Input::get('cbook');
    $btitle = Input::get('btitle');
    $clink = Input::get('clink');

    // prev input
    $ctitlePrev = Input::get('ctitlePrev');
    $cauthorsPrev = Input::get('cauthorsPrev');
    $cpublisherPrev = Input::get('cpublisherPrev');
    $cyearPrev = Input::get('cyearPrev');
    $cbookPrev = Input::get('cbookPrev');
    $btitlePrev = Input::get('btitlePrev');
    $clinkPrev = Input::get('clinkPrev');


    // connect with localhost
    $conn = mysqli_connect("localhost", "root", "jrtalent", "faculty_profile_db");
    if (!$conn)
      die("Unable to connect to database");

    // update query
    $stmt = "UPDATE `faculty_profile_publications` SET title='$ctitle', authors='$cauthors', publisher='$cpublisher', pdate='$cyear', onlineLink='$clink', bookTitle='$btitle', bookType='$cbook' WHERE roll='$roll' AND ptype='bc' AND  title=$ctitlePrev AND authors=$cauthorsPrev AND publisher=$cpublisherPrev AND pdate=$cyearPrev AND onlineLink=$clinkPrev AND bookTitle=$btitlePrev AND bookType=$cbookPrev;";
    //echo $stmt;
    // run query
    $result = mysqli_query($conn, $stmt);
  } catch (Exception $e) {
    //echo "Here8";
    die($e->getMessage());
  }
}

?>


<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Book Chapter</title>

  <!-- CSS -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark p-2 fixed-top">
    <div class="container">
      <a href="journal.php" class="navbar-brand">Homepage</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- NAVBAR collapse -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <!-- SHOW USERNAME -->
          <li class="nav-item px-2">
            <a href="profile.php" class="nav-link">
              <i class="fa fa-user"></i> <?php echo escape($user->data()->Name); ?>
            </a>
          </li>

          <li class="nav-item px-2">
            <a href="logout.php" class="nav-link">
              <i class="fa fa-user-times"></i> Logout
            </a>
          </li>
        </ul>
      </div>
      <!-- NAVBAR collapse ends -->
    </div>
  </nav>
  <!-- NAVBAR ends -->

  <br><br>

  <!-- MAIN BODY CONTENT -->
  <div class="wrapper d-flex align-items-stretch">

    <!-- MAIN BODY - SIDEBAR  -->
    <nav id="sidebar">

      <!-- SIDEBAR TOGGLER -->
      <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
      </div>
      <!-- SIDEBAR TOGGLER ends -->

      <!-- SIDEBAR CONTENT -->
      <div class="p-4 pt-5">

        <!-- SIDEBAR HEADER -->
        <h1><a href="#" class="logo">Dashboard</a></h1>
        <!-- SIDEBAR HEADING ends -->

        <!-- SIDEBAR LISTS -->
        <ul class="list-unstyled components mb-5">

          <!-- AREA list -->
          <li>
            <a href="#areaSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              Area
            </a>
            <ul class="collapse list-unstyled show" id="areaSubmenu">
              <li>
                <a href="researchArea.php">Research Area</a>
              </li>
            </ul>
          </li>
          <!-- AREA list ends -->

          <!-- TEACHING list -->
          <li>
            <a href="#teachingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              Teaching
            </a>
            <ul class="collapse list-unstyled show" id="teachingSubmenu">
              <li>
                <a href="teaching.php">Teaching</a>
              </li>
            </ul>
          </li>
          <!-- TEACHING list ends -->

          <!-- RESEARCH list -->
          <li>
            <a href="#researchSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              Research
            </a>
            <ul class="collapse list-unstyled show" id="researchSubmenu">
              <li>
                <a href="guidance.php">Guidance</a>
              </li>
              <li>
                <a href="sponsoredResearch.php">Sponsored Research</a>
              </li>
              <li>
                <a href="consultancy.php">Consultancy</a>
              </li>
              <li>
                <a href="developmentWork.php">Development Work</a>
              </li>
              <li>
                <a href="patent.php">Patent</a>
              </li>
              <li>
                <a href="copyright.php">CopyRight</a>
              </li>
              <li>
                <a href="technologyTransfer.php">Technology Transfer</a>
              </li>
            </ul>
          </li>
          <!-- RESEARCH list ends -->

          <!-- Honours list -->
          <li>
            <a href="#honoursSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              Honours
            </a>
            <ul class="collapse list-unstyled show" id="honoursSubmenu">
              <li>
                <a href="fellowProfessional.php">Fellow - Professional Body</a>
              </li>
              <li>
                <a href="memberProfessional.php">Member - Professional Body</a>
              </li>
              <li>
                <a href="memberEditorial.php">Member - Editorial Body</a>
              </li>
              <li>
                <a href="awards.php">Awards</a>
              </li>
              <li>
                <a href="fellowships.php">Fellowships</a>
              </li>
              <li>
                <a href="invitedLectures.php">Invited Lectures</a>
              </li>
            </ul>
          </li>
          <!-- HONOURS list ends -->

          <!-- PUBLICATIONS list -->
          <li class="active">
            <a href="#publicationsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              Publications
            </a>
            <ul class="collapse list-unstyled show" id="publicationsSubmenu">
              <li>
                <a href="journal.php">Journals</a>
              </li>
              <li>
                <a href="conference.php">Conference</a>
              </li>
              <li>
                <a href="textBooks.php">Text Books</a>
              </li>
              <li>
                <a href="bookChapter.php">Book Chapter</a>
              </li>
              <li>
                <a href="editedVolumes.php">Edited Volumes</a>
              </li>
              <li>
                <a href="educationalPackages.php">Educational Packages</a>
              </li>
              <li>
                <a href="otherPublications.php">Other Publications</a>
              </li>
            </ul>
          </li>
          <!-- PUBLICATIONS ends -->

          <!-- ACTIVITIES list -->
          <li>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Activity</a>
            <ul class="collapse list-unstyled show" id="homeSubmenu">
              <li>
                <a href="studentActivities.php">Student Activities</a>
              </li>
              <li>
                <a href="departmentalActivities.php">Departmental Activities</a>
              </li>
              <li>
                <a href="instituteActivites.php">Institute Activities</a>
              </li>
              <li>
                <a href="professionalActivities.php">Professional Activities</a>
              </li>
              <li>
                <a href="seminar.php">Seminar, Conference, Workshops</a>
              </li>
              <li>
                <a href="shortTerm.php">Short Term Course</a>
              </li>
              <li>
                <a href="Activities_VA.php">Visit Abroad</a>
              </li>
              <li>
                <a href="otherAcademic.php">Other Academic Activity</a>
              </li>
              <li>
                <a href="anyOther.php">Any Other Information</a>
              </li>
            </ul>
          </li>
          <!-- ACTIVITIES list ends -->
        </ul>
        <!-- SIDEBAR LISTS ends -->
      </div>
      <!-- SIDEBAR CONTENT ends -->
    </nav>
    <!-- MAIN BODY - SIDEBAR ends -->


    <div id="content" class="p-4 p-md-5 pt-5">

      <!-- MAIN BODY - Page CONTENT  -->
      <section id="posts">
        <div class="container">
          <div class="row">
            <div class="col-md-12" style="width: 65rem;">

              <!-- 
                if edit btn is clicked then edit form will be displayed else insert form will be displayed
               -->

              <!-- TEXT BOOKS EDIT/INSERT form -->
              <?php if (Input::exists() && isset($_POST['edit_entry'])) {

                $ctitle = Input::get('ctitle');
                $cauthors = Input::get('cauthors');
                $cbook = Input::get('cbook');
                $cpublisher = Input::get('cpublisher');
                $cyear = Input::get('cyear');
                $btitle = Input::get('btitle');
                $clink = Input::get('clink');

              ?>
                <!-- TEXT BOOK EDIT FORM -->
                <div class="card">
                  <!-- TEXT BOOK EDIT FORM - HEADER -->
                  <div class="card-header">
                    <h4><i class='fa fa-edit'></i> Edit Your Book Chapter</h4>
                  </div>
                  <br>
                  <!-- TEXT BOOK EDIT FORM - HEADER ends -->

                  <!-- TEXT BOOK EDIT FORM - BODY -->
                  <form action="bookChapter.php" method="post">

                    <input type="hidden" name="ctitlePrev" value="<?php echo $ctitle ?>">
                    <input type="hidden" name="cauthorsPrev" value="<?php echo $cauthors ?>">
                    <input type="hidden" name="cbookPrev" value="<?php echo $cbook ?>">
                    <input type="hidden" name="cpublisherPrev" value="<?php echo $cpublisher ?>">
                    <input type="hidden" name="cyearPrev" value="<?php echo $cyear ?>">
                    <input type="hidden" name="btitlePrev" value="<?php echo $btitle ?>">
                    <input type="hidden" name="clinkPrev" value="<?php echo $clink ?>">




                    <div class="form-group">
                      <label> Chapter Title<span class="m-1 text-primary">*</span></label>
                      <input type="text" class="form-control" name="ctitle" required value=<?php echo "$ctitle" ?>>
                    </div>

                    <div class="form-group">
                      <label> Book Title<span class="m-1 text-primary">*</span></label>
                      <input type="text" class="form-control" name="btitle" required value=<?php echo "$btitle" ?>>
                    </div>

                    <div class="form-group">
                      <label> Authors<span class="m-1 text-primary">*</span></label>
                      <input type="text" class="form-control" name="cauthors" required value=<?php echo "$cauthors" ?>>
                    </div>


                    <div class="form-group">
                      <label> Publisher<span class="m-1 text-primary">*</span></label>
                      <input type="text" class="form-control" name="cpublisher" required value=<?php echo "$cpublisher" ?>>
                    </div>

                    <div class="form-group">
                      <label for="cyear"> Published Date</label>
                      <input type="date" id="cyear" name="cyear" value=<?php echo "$cyear" ?>>
                    </div>

                    <div class="form-group">
                      <label> Online link</label>
                      <input type="text" class="form-control" name="clink" value=<?php echo "$clink" ?>>
                    </div>

                    <div class="form-group">
                      <label> Book Type</label>
                      <input type="text" class="form-control" name="cbook" value=<?php echo "$cbook" ?>>
                    </div>

                    <input type="submit" class="btn btn-info" name="edit" value="Edit">

                  </form>
                  <!-- TEXT BOOK EDIT FORM - BODY ends -->
                </div>
                <br>
                <!-- TEXT BOOK EDIT FORM ends -->
              <?php
              } else { ?>
                <!-- TEXT BOOK INSERT FORM -->
                <div class="card">
                  <!-- TEXT BOOK INSERT FORM - HEADER -->
                  <div class="card-header">
                    <h4><i class='fa fa-edit'></i> Insert Book Chapter</h4>
                  </div>
                  <br>
                  <!-- TEXT BOOK INSERT FORM - HEADER ends -->

                  <!-- TEXT BOOK INSERT FORM - BODY -->
                  <form action="bookChapter.php" method="post">

                    <div class="form-group">
                      <label> Chapter Title<span class="m-1 text-primary">*</span></label>
                      <input type="text" class="form-control" name="ctitle" required>
                    </div>

                    <div class="form-group">
                      <label> Book Title<span class="m-1 text-primary">*</span></label>
                      <input type="text" class="form-control" name="btitle" required>
                    </div>

                    <div class="form-group">
                      <label> Authors<span class="m-1 text-primary">*</span></label>
                      <input type="text" class="form-control" name="cauthors" required>
                    </div>

                    <div class="form-group">
                      <label> Publisher<span class="m-1 text-primary">*</span></label>
                      <input type="text" class="form-control" name="cpublisher" required>
                    </div>

                    <div class="form-group">
                      <label for="cyear"> Published Date</label>
                      <input type="date" id="cyear" name="cyear">
                    </div>



                    <div class="form-group">
                      <label> Online link</label>
                      <input type="text" class="form-control" name="clink">
                    </div>

                    <div class="form-group">
                      <label> Book Type</label>
                      <input type="text" class="form-control" name="cbook">
                    </div>

                    <input type="submit" class="btn btn-info" name="csubmit" value="Submit">

                  </form>
                  <!-- TEXT BOOK INSERT FORM - BODY ends -->
                </div>
                <br>
                <!-- TEXT BOOK INSERT FORM ends -->
              <?php } ?>
              <!-- TEXT BOOKS EDIT/INSERT form ends -->

              <!-- VIEW ADDED TEXT BOOKS -->
              <div class="card">
                <div class="card-header">
                  <h4><i class="fa fa-file-text"></i> Added Records</h4>
                </div>
                <table class="table table-striped table-hover">
                  <thead class="thead-inverse">
                    <tr>
                      <th>Chapter Title</th>
                      <th>Book Title</th>
                      <th>Authors</th>
                      <th>Publisher</th>
                      <th>Date</th>
                      <th>Online Link</th>
                      <th>Book Type</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    $roll = $user->data()->{'Roll No'};
                    $conn = mysqli_connect("localhost", "root", "jrtalent", "faculty_profile_db");
                    if (!$conn)
                      die("Unable to connect to database");

                    // echo $roll;
                    $stmt = "SELECT * FROM faculty_profile_publications WHERE roll='$roll' AND ptype='bc' ORDER BY lastUpdated DESC;";
                    // echo $stmt;
                    $result = mysqli_query($conn, $stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                      <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['bookTitle']; ?></td>
                        <td><?php echo $row['authors']; ?></td>
                        <td><?php echo $row['publisher']; ?></td>
                        <td><?php echo $row['pdate']; ?></td>
                        <td><?php echo $row['onlineLink']; ?></td>
                        <td><?php echo $row['bookType']; ?></td>

                        <!-- EDIT -->
                        <td>
                          <form action="bookChapter.php" method="post">
                            <input type="hidden" name="ctitle" value="<?php echo "'";
                                                                      echo $row['title'];
                                                                      echo "'"; ?>">
                            <input type="hidden" name="btitle" value="<?php echo "'";
                                                                      echo $row['bookTitle'];
                                                                      echo "'"; ?>">
                            <input type="hidden" name="cauthors" value="<?php echo "'";
                                                                        echo $row['authors'];
                                                                        echo "'"; ?>">
                            <input type="hidden" name="cbook" value="<?php echo "'";
                                                                      echo $row['bookType'];
                                                                      echo "'"; ?>">

                            <input type="hidden" name="cpublisher" value="<?php echo "'";
                                                                          echo $row['publisher'];
                                                                          echo "'"; ?>">
                            <input type="hidden" name="cyear" value="<?php echo "'";
                                                                      echo $row['pdate'];
                                                                      echo "'"; ?>">

                            <input type="hidden" name="clink" value="<?php echo "'";
                                                                      echo $row['onlineLink'];
                                                                      echo "'"; ?>">

                            <input type="submit" class="btn btn-primary" name="edit_entry" value="Edit" style="background-color: green">
                          </form>
                        </td>
                        <!-- EDIT ends -->
                        <!-- DELETE -->
                        <td>
                          <form action="bookChapter.php" method="post">
                            <input type="hidden" name="ctitle" value="<?php echo "'";
                                                                      echo $row['title'];
                                                                      echo "'"; ?>">
                            <input type="hidden" name="btitle" value="<?php echo "'";
                                                                      echo $row['bookTitle'];
                                                                      echo "'"; ?>">

                            <input type="hidden" name="cauthors" value="<?php echo "'";
                                                                        echo $row['authors'];
                                                                        echo "'"; ?>">
                            <input type="hidden" name="cbook" value="<?php echo "'";
                                                                      echo $row['bookType'];
                                                                      echo "'"; ?>">

                            <input type="hidden" name="cpublisher" value="<?php echo "'";
                                                                          echo $row['publisher'];
                                                                          echo "'"; ?>">
                            <input type="hidden" name="cyear" value="<?php echo "'";
                                                                      echo $row['pdate'];
                                                                      echo "'"; ?>">

                            <input type="hidden" name="clink" value="<?php echo "'";
                                                                      echo $row['onlineLink'];
                                                                      echo "'"; ?>">

                            <input type="submit" class="btn btn-danger" name="delete_entry" value="Delete">
                          </form>
                        </td>
                        <!-- DELETE ends -->
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>

              </div>
              <br>
              <br>
              <!-- VIEW ADDED TEXT BOOKS ends -->



              <!-- Search Functions -->
              <div class="card">
                <div class="card-header">
                  <h4><i class="fa fa-search mr-3"></i> Search Book Chapter </h4>
                </div>
                <br>
                <br>

                <!-- Search 0 - by book title -->
                <form action="bookChapter.php">
                  <div class="input-group">
                    <input type="text" required name="BnameS" class="form-control" placeholder="Search By Book Title">
                    <input type="submit" name="BnameSearch" class="btn btn-secondary">
                  </div>
                </form>
                <br>
                <div class="table-responsive">
                  <?php
                  if (strlen(Input::get('BnameS')) > 0) {
                    $bnames = DB::getInstance();
                    $bname = Input::get('BnameS');

                    $bnames->query("SELECT fname,dept,title,bookTitle,authors, publisher,CONCAT_WS('-', MONTH(pdate), YEAR(pdate)) AS day, bookType FROM faculty_profile_publications WHERE ptype = 'bc' AND bookTitle LIKE '%$bname%' ORDER BY pdate DESC");

                    if ($bnames->count()) {
                      echo "<table class=\"table table-striped table-hover\">";
                      echo "<thead class=\"thead-inverse\">";
                      echo "<tr><th>Name</th><th>Dept</th><th>Chapter Title</th><th>Book Title</th><th>Authors</th><th>Publisher</th><th>Year</th><th>Book Type</th></tr></thead>";
                      echo "<tbody>";

                      foreach ($bnames->results() as $row) {
                        echo "<tr><td>$row->fname</td><td>$row->dept</td><td>$row->title</td><td>$row->bookTitle</td><td>$row->authors</td><td>$row->publisher</td><td>$row->day</td><td>$row->bookType</td> </tr>\n";
                      }
                      echo "</tbody></table>";
                    }
                  }
                  ?>
                </div>
                <!-- Search 0 - by book title ends -->

                <br>

                <!-- Search 1- by chapter title -->
                <form action="bookChapter.php">
                  <div class="input-group">
                    <input type="text" required name="CnameS" class="form-control" placeholder="Search By Chapter Title">
                    <input type="submit" name="CnameSearch" class="btn btn-secondary">
                  </div>
                </form>
                <br>
                <div class="table-responsive">
                  <?php
                  if (strlen(Input::get('CnameS')) > 0) {
                    $cnames = DB::getInstance();
                    $cname = Input::get('CnameS');

                    $cnames->query("SELECT fname,dept,title,bookTitle,authors, publisher,CONCAT_WS('-', MONTH(pdate), YEAR(pdate)) AS day, bookType FROM faculty_profile_publications WHERE ptype = 'bc' AND title LIKE '%$cname%' ORDER BY pdate DESC");

                    if ($cnames->count()) {
                      echo "<table class=\"table table-striped table-hover\">";
                      echo "<thead class=\"thead-inverse\">";
                      echo "<tr><th>Name</th><th>Dept</th><th>Chapter Title</th><th>Book Title</th><th>Authors</th><th>Publisher</th><th>Year</th><th>Book Type</th></tr></thead>";
                      echo "<tbody>";

                      foreach ($cnames->results() as $row) {
                        echo "<tr><td>$row->fname</td><td>$row->dept</td><td>$row->title</td><td>$row->bookTitle</td><td>$row->authors</td><td>$row->publisher</td><td>$row->day</td><td>$row->bookType</td> </tr>\n";
                      }
                      echo "</tbody></table>";
                    }
                  }
                  ?>
                </div>
                <!-- Search 1- by chapter title ends -->

                <br>

                <!-- Search 2 - by publisher name -->
                <form action="bookChapter.php">
                  <div class="input-group">
                    <input type="text" name="CpnameS" required class="form-control" placeholder="Search By Publisher Name">
                    <input type="submit" name="JpnameSearch" class="btn btn-secondary">
                  </div>
                </form>
                <br>
                <div class="table-responsive">
                  <?php
                  if (strlen(Input::get('CpnameS')) > 0) {
                    $cpnames = DB::getInstance();
                    $cpname = Input::get('CpnameS');

                    $cpnames->query("SELECT fname,dept,title,bookTitle,authors, publisher,CONCAT_WS('-', MONTH(pdate), YEAR(pdate)) AS day, bookType FROM faculty_profile_publications WHERE ptype = 'bc' AND publisher LIKE '%$cpname%' ORDER BY pdate DESC");

                    if ($cpnames->count()) {
                      echo "<table class=\"table table-striped table-hover\">";
                      echo "<thead class=\"thead-inverse\">";
                      echo "<tr><th>Name</th><th>Dept</th><th>Chapter Title</th><th>Book Title</th><th>Authors</th><th>Publisher</th><th>Year</th><th>Book Type</th></tr></thead>";
                      echo "<tbody>";

                      foreach ($cpnames->results() as $row) {
                        echo "<tr><td>$row->fname</td><td>$row->dept</td><td>$row->title</td><td>$row->bookTitle</td><td>$row->authors</td><td>$row->publisher</td><td>$row->day</td><td>$row->bookType</td></tr>\n";
                      }
                      echo "</tbody></table>";
                    }
                  }
                  ?>
                </div>
                <!-- Search 2 - by publisher name ends -->
                <br>


                <!-- Search 3 - by year -->
                <form action="bookChapter.php">
                  <div class="input-group">
                    <input type="text" name="cyearS" required class="form-control" placeholder="Search By Text Books published in last X years">
                    <input type="submit" name="jyearSearch" class="btn btn-secondary">
                  </div>
                </form>
                <br>
                <div class="table-responsive">
                  <?php
                  if (strlen(Input::get('cyearS') && is_numeric(Input::get('cyearS'))) > 0) {
                    $cyears = DB::getInstance();
                    $cyear = Input::get('cyearS');

                    $cyears->query("SELECT fname,dept,title,bookTitle,authors, publisher, CONCAT_WS('-', MONTH(pdate), YEAR(pdate)) AS day, bookType  FROM faculty_profile_publications WHERE ptype = 'bc' AND DATEDIFF(CURRENT_DATE, pdate)/365 < $cyear ORDER BY pdate DESC");

                    if ($cyears->count()) {
                      echo "<table class=\"table table-striped table-hover\">";
                      echo "<thead class=\"thead-inverse\">";
                      echo "<tr><th>Name</th><th>Dept</th><th>Chapter Title</th><th>Book Title</th><th>Authors</th><th>Publisher</th><th>Year</th><th>Book Type</th></tr></thead>";
                      echo "<tbody>";

                      foreach ($cyears->results() as $row) {
                        echo "<tr><td>$row->fname</td><td>$row->dept</td><td>$row->title</td><td>$row->bookTitle</td><td>$row->authors</td><td>$row->publisher</td><td>$row->day</td><td>$row->bookType</td></tr>\n";
                      }
                      echo "</tbody></table>";
                    }
                  }
                  ?>
                </div>
                <!-- Search 3 - by year ends-->

                <br>


                <!-- Search 4 - by faculty name -->
                <form action="bookChapter.php">
                  <div class="input-group">
                    <input type="text" name="CfnameS" required class="form-control" placeholder="Search By Faculty Name">
                    <input type="submit" name="CfnameSearch" class="btn btn-secondary">
                  </div>
                </form>
                <br>
                <div class="table-responsive">
                  <?php
                  if (strlen(Input::get('CfnameS')) > 0) {
                    $cfnames = DB::getInstance();
                    $cfname = Input::get('CfnameS');
                    $cfnames->query("SELECT fname,dept,title,bookTitle,authors,  publisher,CONCAT_WS('-', MONTH(pdate), YEAR(pdate)) AS day, bookType FROM faculty_profile_publications WHERE ptype = 'bc' AND fname LIKE '%$cfname%' ORDER BY pdate DESC");

                    if ($cfnames->count()) {
                      echo "<table class=\"table table-striped table-hover\">";
                      echo "<thead class=\"thead-inverse\">";
                      echo "<tr><th>Name</th><th>Dept</th><th>Chapter Title</th><th>Book Title</th><th>Authors</th><th>Publisher</th><th>Year</th><th>Book Type</th></tr></thead>";
                      echo "<tbody>";

                      foreach ($cfnames->results() as $row) {
                        echo "<tr><td>$row->fname</td><td>$row->dept</td><td>$row->title</td><td>$row->bookTitle</td><td>$row->authors</td><td>$row->publisher</td><td>$row->day</td><td>$row->bookType</td></tr>\n";
                      }
                      echo "</tbody></table>";
                    }
                  }
                  ?>
                </div>
                <!-- Search 4 ends - by faculty name -->
              </div>
              <br>
              <!-- Search Functions ends -->

            </div>
          </div>
        </div>
      </section>
      <!-- MAIN BODY - PAGE CONTENT ends -->
    </div>

  </div>
  <!-- MAIN BODY CONTENT ends -->

  <!-- floating to the top button -->
  <a href="#" id="scroll" style="display: none;"><span></span></a>

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/others.js"></script>
</body>

</html>