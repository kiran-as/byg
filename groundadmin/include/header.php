<?php
$filenamearray = explode('groundadmin/',$_SERVER['PHP_SELF']);
$filename = $filenamearray[1];
$groundindexselected='';
$groundadminblockseat='';
$groundadmineditamountindex='';
$groundadminreleaseseat='';
$report='';
if($filename=='groundindex.php')
{ 
   $groundindexselected = "class='active'";
}
else if($filename=='groundadminblockseat.php')
{ 
   $groundadminblockseat ="class='active'";
   
}
else if($filename=='groundadmineditamountindex.php')
{ 
   $groundadmineditamountindex="class='active'";
   
}
else if($filename=='groundadminreleaseseat.php')
{
   $groundadminreleaseseat="class='active'";
}
else 
{ 
  $report="class='active'";
}
?>
    
	
	<header>
        <div class="navbar navbar-inverse top--header" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <a href="groundindex.php" class="navbar-brand logo logo--small mar-t10 mar-r30 mar-b10">Book Your Ground</a>              
            </div>   
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav header-nav mar-t10">
					
                  <li <?php echo $groundindexselected;?>><a href="groundindex.php">Ground Details</a></li>
                  <li <?php echo $groundadminblockseat;?>><a href="groundadminblockseat.php">Block Seats</a></li>
                  <li <?php echo $groundadmineditamountindex;?>><a href="groundadmineditamountindex.php">Edit price</a></li>
                  <li <?php echo $groundadminreleaseseat;?>><a href="groundadminreleaseseat.php">Release Seats</a></li>
                  <li <?php echo $report;?>><a href="report.php">Reports</a></li>
                </ul>               
                <ul class="nav navbar-nav navbar-right header-right mar-t10">
                  <li class="pad-t15"><?php echo $_SESSION['name'];?></li>
                  <li><a href="index.php">Logout</a></li>
                </ul>
              </div>                   
          </div>
        </div>      
    </header>