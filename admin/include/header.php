    <header>
        <div class="navbar navbar-inverse top--header" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <a href="#" class="navbar-brand logo logo--small mar-t10 mar-r30 mar-b10">Book Your Ground</a>              
            </div>   
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav header-nav mar-t10">
                 <li class=""><a href="#">&nbsp;&nbsp;&nbsp;</a></li>
                  <li><a href="groundadminindex.php">Ground Admin</a></li>
                  <li><a href="locationindex.php">Location</a></li>
                  <li><a href="sportindex.php">Sport</a></li>
                  <li><a href="groundindex.php">New Ground</a></li>
                  <li><a href="report.php">Reports</a></li>
                </ul>               
                <ul class="nav navbar-nav navbar-right header-right mar-t10">
                  <li class="pad-t15"><?php echo $_SESSION['name'];?></li>
                  <li><a href="index.php">Logout</a></li>
                </ul>
              </div>                   
          </div>
        </div>      
    </header>