




<?php
session_start();
include_once 'connect.php';
// include 'p/_modal.php';
// include "boot.php";




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input from the form
    $groupname = $_POST['checkgroupname'];
    echo $groupname;

    // Separate the input whenever a comma comes and save it into an array
    // $array = explode(",", $groupmembername);

    // Trim each element in the array to remove any leading or trailing whitespace
    // $array = array_map('trim', $array);

    // Output the array for demonstration purposes
    // print_r($array);
}

  


















    // $group=$_REQUEST['checkgroupname'];
    // echo$group;

    if(isset($_POST['groupcheck'])) {
        if(isset($_POST['checkgroupname'])) {

    $groupname=$_POST['checkgroupname'];
     echo $groupname;
    // $groupname=$_POST[''];
    if($groupname){
        
        $groupname=$_POST['checkgroupname'];
        // echo $groupname;echo'<br>';
        
        $querygname = "SELECT `GROUP_NAME` FROM `groups` WHERE GROUP_NAME='" . $groupname . "'";
        $resultgname = mysqli_query($conn, $querygname); 
        // echo $querygname;
        // echo $resultgname;
    //     echo "Group not found";
    //    echo' <a href='."prac2.php".'>back to group search</a>';
        
    if ($resultgname === false) {
        echo "Group not found";
        echo '<a href="groupfind.php">back to group search</a>';
        echo "Error: " . mysqli_error($conn);
        } else {
            $datagname = mysqli_fetch_assoc($resultgname);
            
            if ($datagname) {
                $gname = $datagname["GROUP_NAME"];
                if($groupname != $gname) {
                    echo "Group not found";
                } else {
       
      
    if(isset($_SESSION['username'])) {





            $UNAME = $_SESSION['username'];
            // echo $UNAME;echo'<br>';
            $query1 = "SELECT `U_ID` FROM `user` WHERE U_NAME='" . $UNAME . "'";
            $result12 = mysqli_query($conn, $query1);
            $data = mysqli_fetch_assoc($result12);
            $uid = $data["U_ID"];
            if (!$result12) {
                echo mysqli_error($conn);
            }

            //getting group name

            $groupname=$_POST['checkgroupname'];
            $requestgname = $_SESSION['groupname'];
            // echo $groupname;echo'<br>';
            $querygname = "SELECT `GROUP_NAME` FROM `groups` WHERE GROUP_NAME='" . $groupname . "'";
            $resultgname = mysqli_query($conn, $querygname);
            $datagname = mysqli_fetch_assoc($resultgname);
            $gname = $datagname["GROUP_NAME"];
            // echo "<br>";
            // echo "<br>";
            // echo "<br>";

            // echo $gname;
            // echo "<br>";
            // echo "<br>";
            if (!$resultgname) {
                echo mysqli_error($conn);
            }
            // $_SESSION['groupname']=$gname;
            // $gn=$_SESSION['groupname'];
            $_SESSION['groupname']=$gname;
            $gn=$_SESSION['groupname'];
            // echo "session:<br>";
            // echo "<br>";
            // echo"$gn";
            // echo "<br>";
            // echo "<br>";



            //getting group id

            $groupname=$_POST['checkgroupname'];
            // echo $groupname;echo'<br>';
            $_SESSION['gname']=$_POST['checkgroupname'];

            $querygn = "SELECT `G_ID` FROM `groups` WHERE GROUP_NAME='" . $groupname . "'";
            $resultgn = mysqli_query($conn, $querygn);
            $datagn = mysqli_fetch_assoc($resultgn);
            $gid = $datagn["G_ID"];
            // echo $gid;
            if (!$resultgn) {
                echo mysqli_error($conn);
            }



            //getting group memeber


            $querygm = "SELECT `groupmember` FROM `groups` WHERE G_ID='" . $gid . "'";
            $resultgm = mysqli_query($conn, $querygm);
            $datagm = mysqli_fetch_assoc($resultgm);
            $groupmember = $datagm["groupmember"];
            // echo $groupmember;
            if (!$resultgn) {
                echo mysqli_error($conn);
            }



               
                $arraygm=array();
                // Separate the input whenever a comma comes and save it into an array
                $arraygm = explode(",", $groupmember);

                // Trim each element in the array to remove any leading or trailing whitespace
                $arraygm = array_map('trim', $arraygm);

                // Output the array for demonstration purposes
                // print_r($arraygm);


                $elementCount = count($arraygm);
                // echo "arraycount:";
                // echo $elementCount;


                    //fetch file data with pagination
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }






            // Define how many results you want per page
            $results_per_page = 5;

                $start_from = ($page - 1) * $results_per_page;
        $query2 = "SELECT * FROM group_files WHERE G_ID=" . $gid . " LIMIT $start_from, $results_per_page";
        $result2 = mysqli_query($conn, $query2);



        //-----------------------------------------------------
        //   adminname
            

            $adquery="SELECT `admin_name` FROM `groups` WHERE `G_ID`='" . $gid . "'";
            $resultadmin = mysqli_query($conn, $adquery);
            $recordadmin=mysqli_fetch_assoc($resultadmin);
        // echo $recordadmin['admin_name'];

        $_SESSION['groupadminname']=$recordadmin['admin_name'];
        $gan=$_SESSION['groupadminname'];
        // echo "session:<br>";
        // echo "<br>";
        // echo "session:"; echo"$gan";
        // echo "<br>";
        // echo "<br>";
            if($recordadmin) {
                // print_r($recordadmin) ;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            

            // echo $UNAME;echo "<br>";
            if($recordadmin['admin_name']==$UNAME){
                // echo 'hello';
                echo '<br>';
                echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>User Dashbord</title>
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
                    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
                </head>
                <body>
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Drivehub</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                        Messages
                                    </button>
                                </li>
                            </ul>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    <form action="logout.php" method="post">
                    <!-- Bootstrap-styled logout button -->
                    <button type="submit" name="logout" class="btn btn-danger  btn-block">Logout</button>
                  </form>
                </nav>
            
                
            
                <div class="container mt-8" style="margin-left: 1px;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border bg-dark text-white text-center">
                                <div class="card-body">
                                    <img src="p/image1.jpg" class="card-img-top mb-3" alt="Not set">
                                    <h5 class="card-title">';
                                    ?>
                                     <?php 
                                    //  echo $_SESSION["username"];
                                    echo $groupname;echo':';echo $groupmember;?> 
                                     <?php echo'<h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
                                    <ul class="list-group list-group-flush text-white">
                                    <li class="list-group-item"><a href="Assignment.php">Assignment</a></li>
                                    <li class="list-group-item" ><a href="group.php">Groups</a></li>
                                    <li class="list-group-item" ><a href="message.php"> Messages</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8" style="margin-top: 10px; margin-bottom: 90px; margin-left: 50px;">
                            <table class="table" style="background-color: rgba(255, 255, 255, 0);">
                                <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>File type</th>
                                    <th>File size</th>
                                    <th>Date/time</th>
                                    <th>Download</th>
                                    <th>DELETE</th>
                                    <th>uploadedby</th>
                                </tr>
                                </thead>
                                <tbody>';?>
                                <?php
                                while ($fdata = mysqli_fetch_assoc($result2)) {
                                    ?><?php echo'
                                    <tr>
                                        <td>';?><?php echo $fdata["gfile_name"]; echo'</td>
                                        <!-- Add more cells for other file data -->
                                        <td>'; echo $fdata["gfile_type"]; echo '</td>
                                        <td>'; echo $fdata["gfile_size"];  echo'KB</td>
                                        <td>'; echo $fdata["gfile_created_date"]; echo '</td>';
                                        echo '<td>'; echo $gan; echo '</td>';
                                        ?>
                                        <?php
                                         //fetch name and path
                                        $query="select * from group_files where gfid=".$fdata["gfid"];
                                        $result=mysqli_query($conn,$query);
                                        if(!$result){
                                            echo mysqli_error($conn);
                                        }
                                        $record=mysqli_fetch_assoc($result);
                                        $dbpath= $record["gfile_path"];
                                        $fname=$_SESSION["username"].",".$fdata["gfile_name"];
                                        $serverFilePath = str_replace('/', DIRECTORY_SEPARATOR, $dbpath);
                                        

                                       echo' <td><a download="'?><?php echo $fname?><?php echo'"'?><?php echo 'href="'?><?php echo $serverFilePath?> <?php echo '">📥</a></td>';?>

                                     <?php echo '<td><a href="gdelete.php?file_id='?><?php echo $fdata["gfid"];?><?php echo '">🗑️</a></td>';echo' <td>'; echo $gan; echo '</td>';;?>
                                       
                                    <?php
                                }
                                ?><?php echo'
                                </tbody>
                            </table>
            
                            <!-- Pagination links -->
                            <ul class="pagination">';?>
                                 <?php
                                $sql = "SELECT COUNT(*) AS total FROM group_files WHERE G_ID=" . $gid;
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $total_pages = ceil($row["total"] / $results_per_page);
            
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<li class='page-item'><a class='page-link' href='groupdesktop2.php?page=" . $i . "'>" . $i . "</a></li>";
                                }
                                
                                echo '<div class="container">
                                <div class="container">
                                <form action="gupload.php" method="post" enctype="multipart/form-data">
                        <label for="file" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Choose File
                            <input type="file" id="file" name="file" style="display: none;">
                        </label>
                        <input type="submit" value="Upload File" class="btn btn-success">
                    </form>
                </div>
                                        
                        </div>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <script>
                    document.getElementById("openFileSystem").addEventListener("click", function() {
                        document.getElementById("fileInput").click();
                    });
                </script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
                </body>
                </html>';
            

                echo 'hello';

        } 
        
        // echo $UNAME;
        
        for ($i = 0; $i < $elementCount; $i++) {
            
                  
        if($arraygm[$i]==$UNAME){

            
                        echo"<br>";

                    //  echo"admin nahi he user groupmember he samjaha lodu";

                    echo '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>User Dashbord</title>
                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
                        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
                    </head>
                    <body>
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="#">Drivehub</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                                    </li>
                                    <li class="nav-item">
                                           
                                    
                                    </li>
                                </ul>
                                <form class="d-flex" role="search">
                                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                        <form action="logout.php" method="post">
                        <!-- Bootstrap-styled logout button -->
                        <button type="submit" name="logout" class="btn btn-danger  btn-block">Logout</button>
                      </form>
                    </nav>';
                
        
              

                
echo '
                <div class="container mt-8" style="margin-left: 1px;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border bg-dark text-white text-center">
                                <div class="card-body">
                                    <img src="p/image1.jpg" class="card-img-top mb-3" alt="Not set">
                                    <h5 class="card-title">';?><?php echo $groupname;echo':';echo $groupmember;?><?php echo '<h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
                                    <ul class="list-group list-group-flush text-white">
                                        <li class="list-group-item">Groups</li>
                                        <li class="list-group-item">Files</li>
                                        <li class="list-group-item"> <a href="message.php"> Messages</a></li>
                                      
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8" style="margin-top: 10px; margin-bottom: 90px; margin-left: 50px;">
                            <table class="table" style="background-color: rgba(255, 255, 255, 0);">
                                <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>File type</th>
                                    <th>File size</th>
                                    <th>Date/time</th>
                                    <th>Download</th>
                                    <th>uploadedby</th>
                                </tr>
                                </thead>
                                <tbody>'; ?>
                                <?php
                                while ($fdata = mysqli_fetch_assoc($result2)) {
                                    ?><?php echo'
                                    <tr>
                                        <td>';?><?php echo $fdata["gfile_name"]; echo'</td>
                                        <!-- Add more cells for other file data -->
                                        <td>'; echo $fdata["gfile_type"]; echo '</td>
                                        <td>'; echo $fdata["gfile_size"];  echo'KB</td>
                                        <td>'; echo $fdata["gfile_created_date"]; echo '</td>';
                                        ?>
                                        <?php
                                         //fetch name and path
                                        $query="select * from group_files where gfid=".$fdata["gfid"];
                                        $result=mysqli_query($conn,$query);
                                        if(!$result){
                                            echo mysqli_error($conn);
                                        }
                                        $record=mysqli_fetch_assoc($result);
                                        $dbpath= $record["gfile_path"];
                                        $fname=$_SESSION["username"].",".$fdata["gfile_name"];
                                        $serverFilePath = str_replace('/', DIRECTORY_SEPARATOR, $dbpath);
                                        

                                       echo' <td><a download="'?><?php echo $fname?><?php echo'"'?><?php echo 'href="'?><?php echo $serverFilePath?> <?php echo '">📥</a></td>';echo' <td>'; echo $gan; echo '</td>';?>
                                       
                                    <?php
                                }
                                ?><?php echo'
                                </tbody>
                            </table>
                                <a href="pullrequest.php?gmname='.$arraygm[$i].'">request</a>
            
                            <!-- Pagination links -->
                            <ul class="pagination">';?>
                                 <?php
                                $sql = "SELECT COUNT(*) AS total FROM group_files WHERE G_ID=" . $gid;
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $total_pages = ceil($row["total"] / $results_per_page);
            
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<li class='page-item'><a class='page-link' href='groupdesktop2.php?page=" . $i . "'>" . $i . "</a></li>";
                                }
                                
                        echo'
                            </ul>
                        </div>
                    </div>
                </div>
                
                <script>
                    document.getElementById("openFileSystem").addEventListener("click", function() {
                        document.getElementById("fileInput").click();
                    });
                </script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
                </body>
                </html>';
                break;
            








        }
        

    }
}


}

// }






  
//  }

        }

    }
}

}
    else{
        echo "groupnot found";
    }
 }



?>
