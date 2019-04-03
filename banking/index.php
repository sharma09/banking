<?php include 'header.php'; 

if(isset($_POST['accsubmit'])) {
    $acctype = $_POST['acctype'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $clientname = strtoupper($_POST['clientname']);
    $fathername = $_POST['fathername'];
    $mothername = $_POST['mothername'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $phone = $_POST['mobile'];
    $photoname = $_FILES['photo']['name'];
    $phototype = $_FILES['photo']['type'];
    $photosize = $_FILES['photo']['size'];
    $tmpname = $_FILES['photo']['tmp_name'];
    $dates = date('Y-m-d');
    if($phototype == 'image/jpg' || $phototype=='image/jpeg' || $phototype=='png' || $phototype=='gif') {
        if($photosize <= 250000) {
            move_uploaded_file($tmpname, 'userphoto/'.$photoname);
        }
    }
    $accsubmit = $obj->query("INSERT INTO newaccount (acc_type,acc_no,text_pass,fname,fathername,mothername,gender,address,city,state,img_url,mobileno,services) VALUES".
            "('$acctype','$username','$password','$clientname','$fathername','$mothername','$gender','$address','$city','$state','$photoname','$phone','enable')");
    $accsubmit2 = $obj->query("INSERT INTO depositor (dates,acc_no,remarks,creditor,debitor) VALUES ('$dates','$username','Opening',1000,'')");
}



if(isset($_GET['applyonline'])) {
?>
<div class="container">
<?php
if(isset($accsubmit) && isset($accsubmit2)) {
    echo "<div class='alert alert-success'><b>Successful</b> Successfully insert your data..</div>";
}
?>
    <form class="form-horizontal" autocomplete="off" action="index.php?applyonline=1" method="post" style="margin-top:10px;" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Account Type:</label>
            <div class="col-sm-4">
                <select type="text" name="acctype" class="form-control" required="on">
                    <option value="">--Choose type of A/c</option>
                    <option value="Saving A/c">Saving A/c</option>
                    <option value="Current A/c">Current A/c</option>
                    <option value="Loan A/c">Loan A/c</option>
                    <option value="Fixed A/c">Fixed A/c</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Account No:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="username" value="<?php echo '10005'.rand(10000,100000);?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Password:</label>
            <div class="col-sm-4">
                <input type="password" class="form-control" name="password" maxlength="15" placeholder="new password" required="on">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Full Name:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="clientname" placeholder="Client name" required="on">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Father/Husband:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="fathername" placeholder="Father/Husband Name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Mother Name:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="mothername" placeholder="Mother name" required="on">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Phone:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="mobile" placeholder="Mobile no">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Gender:</label>
            <div class="col-sm-4">
                Male <input type="radio" name="gender" checked="checked" value="Male"> Female <input type="radio" name="gender" value="Female">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Address:</label>
            <div class="col-sm-4">
                <textarea class="form-control" name="address" placeholder="Address"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">City:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="city" placeholder="City">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">State:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="state" placeholder="State">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-offset-3">Photo:</label>
            <div class="col-sm-4">
                <input type="file" class="form-control" name="photo">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-5">
                <button type="submit" name="accsubmit" class="btn btn-primary">Save As</button>
            </div>
        </div>
    </form>
</div>

<?php } elseif(isset($_GET['login'])) { 
     
    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $query = $obj->query("SELECT * FROM newaccount WHERE acc_no='$username' AND text_pass='$password'");
        if($query->rowCount()==1) {
            $row = $query->fetch();
            $_SESSION['username'] = $row['acc_no'];
            header('Location: dashboard.php');
            exit();
        } else {
            echo "<div class='alert alert-warning'><b>Warning</b> Wrong your username or password !</div>";
        }
    }
    ?>

<div class="container" style="margin:2%;">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Login</div>
                <div class="panel-body" style="padding:10%;">
                    <form class="form-horizontal" action="index.php?login=1" method="post" autocomplete="off">
                        <div class="form-group">
                            <label>Account No:</label>
                            <input type="text" class="form-control" name="username" >
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" class="form-control" name="password" maxlength="15" placeholder="password" required="on">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="login" value="Login">
                        </div>
                    </form>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <img src="logo/mobile-net.jpg" width="100%" height="330" />
        </div>
    </div>
</div>
<?php } elseif(isset($_GET['contactus'])) {  ?>

<img src="logo/Contacts-Us.png" width="100%" height="350" />
<div class="container">
    <iframe src="https://www.google.com/maps/embed?pb=" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
    <section id="contact">
        <div class="section-content">
            <h1 class="section-header">Get in <span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s"> Touch with us</span></h1>
            <h3>Send our any query..</h3>
        </div>
        <div class="contact-section">
            <div class="container">
                <form>
                    <div class="col-md-6 form-line">
                        <div class="form-group">
                            <label for="exampleInputUsername">Your name</label>
                            <input type="text" class="form-control" id="" placeholder=" Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Email Address</label>
                            <input type="email" class="form-control" id="exampleInputEmail" placeholder=" Enter Email id">
                        </div>	
                        <div class="form-group">
                            <label for="telephone">Mobile No.</label>
                            <input type="tel" class="form-control" id="telephone" placeholder=" Enter 10-digit mobile no.">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for ="description"> Message</label>
                            <textarea  class="form-control" id="description" placeholder="Enter Your Message"></textarea>
                        </div>
                        <div>

                            <button type="button" class="btn btn-default submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Send Message</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>

<?php } elseif(isset($_GET['banking'])) { 
     
    if(isset($_POST['adminlogin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $query = $obj->query("SELECT * FROM admin_logs WHERE adminuser='$username' AND password='$password'");
        if($query->rowCount()==1) {
            $row = $query->fetch();
            $_SESSION['adminuser'] = $row['adminuser'];
            header('Location: adminpage.php');
            exit();
        } else {
            echo "<div class='alert alert-warning'><b>Warning</b> Wrong your username or password !</div>";
        }
    }
    ?>

<div class="container" style="margin:2%;">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">Admin Login</div>
                <div class="panel-body" style="padding:10%;">
                    <form class="form-horizontal" action="index.php?banking=1" method="post" autocomplete="off">
                        <div class="form-group">
                            <label>Account No:</label>
                            <input type="text" class="form-control" name="username" placeholder="Username" required="on">
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" class="form-control" name="password" maxlength="15" placeholder="password" required="on">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-info" name="adminlogin" value="Login">
                        </div>
                    </form>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <img src="logo/Retail-Banking.jpg" width="100%" height="330" />
        </div>
    </div>
</div>


<?php } else { ?>

<img src="logo/Banking-Services.jpg" width="100%" height="350" />
<div class="container">
    <div class="main">
        <div class="row">
            <div class="col-sm-9">
                
                <h3>Four Different Types of Services | Banking</h3>
                <p>A bank’s job is to provide customers with financial services that help people better manage their lives. As technology advances and competition increases, banks are offering different types of services to stay current and attract customers.</p>
                <p>
                Whether you are opening your first bank account or have managed a checking account for years, it helps to know the different types of banking services available. This ensures you get the most out of your current financial institution. Deciding which services are most important can lead you to the bank that best fits your needs.
                </p>
                <p>
                <b>Different Types of Services | Bank Accounts</b><br>
                Individual Banking—Banks typically offer a variety of services to assist individuals in managing their finances, including:
                </p>
                <ul>
                    <li>Checking accounts</li>
                    <li>Savings accounts</li>
                    <li>Debit & credit cards</li>
                    <li>Insurance*</li>
                    <li>Wealth management</li>
                </ul>
                <p>
                Business Banking—Most banks offer financial services for business owners who need to differentiate professional and personal finances. Different types of business banking services include:
                </p>
                <ul>
                    <li>Business loans</li>
                    <li>Checking accounts</li>
                    <li>Savings accounts</li>
                    <li>Debit and credit cards</li>
                    <li>Merchant services (credit card processing, reconciliation and reporting, check collection)</li>
                    <li>Cash management (payroll services, deposit services, etc.)</li>
                </ul>
            </div>
            <div class="col-sm-3">
                <div class="span4 sidebar">
                    <div class="padd">
                        <h3>Loans—Loans</h3>
                        <p>
                        Loans are a common banking service offered, and they come in all shapes and sizes.  Some common types of loans that banks provide include:
                        </p>
                        <ul>
                            <li>Personal loans</li>
                            <li>Home equity loans</li>
                            <li>Home equity lines of credit</li>
                            <li>Home loans</li>
                            <li>Business loans</li>
                        </ul>

                        <h3>Digital Banking</h3>
                        <p>
                            The ability to manage your finances online from your computer, tablet, or smartphone is becoming more and more important to consumers. Banks will typically offer digital banking services that include:
                        </p>
                        <ul>
                            <li>Online, mobile, and tablet banking</li>
                            <li>Mobile check deposit</li>
                            <li>Text alerts</li>
                            <li>eStatements</li>
                            <li>Online bill pay</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }
include 'footer.php'; 
ob_end_flush();
?>