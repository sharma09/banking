<?php include 'header.php'; 

if(!isset($_SESSION['adminuser'])) {
    header('Location: index.php');
    exit();
}
if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
$statement = $obj->query("SELECT * FROM newaccount");
$fetchd = $statement->fetchAll();
?>

<div class="container-fluid" style="min-height:450px;">
    <div class="row">
        <div class="col-sm-9">
            <?php if(isset($_GET['deposit'])) {
                
                if(isset($_POST['credited'])) {
                    $acc = $_POST['account'];
                    $deposit = $_POST['amount'];
                    $ddate = date_format(date_create($_POST['ddated']),'Y-m-d');
                    $remarks = $_POST['remarks'];

                    $insertdeposit = $obj->query("INSERT INTO depositor (dates,acc_no,remarks,creditor,debitor) VALUES ('$ddate','$acc','$remarks','$deposit','')");
                    if(isset($insertdeposit)) {
                        echo '<div class="alert alert-success"><b>Success</b> Successfully insert your data</div>';
                    }
                }
                ?>
                <form class="form-horizontal" action="adminpage.php?deposit=1" method="post" style="margin-top:2%;width:80%;">
                    <div class="form-group">
                        <label class="col-sm-4 col-sm-offset-1">Date</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" name="ddated">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-sm-offset-1">Account No.</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="account">
                                <option value="">--select a/c--</option>
                                <?php foreach($fetchd as $option) { ?>
                                    <option value="<?= $option['acc_no']?>"><?= $option['acc_no'].' '.$option['fname'].' '.$option['acc_type']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-sm-offset-1">Diposit Amount</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="amount" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-sm-offset-1">Remarks</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="remarks">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-5">
                            <input type="submit" name="credited" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            
            <?php } elseif (isset($_GET['fixedacc'])) {
            
                $fdrsql2 = $obj->query("SELECT * FROM fixed_deposit");
                $fdrfetch = $fdrsql2->fetchAll();
                if(!empty($fdrfetch)) {
                ?>
                <table class="table table-bordered" style="overflow-x:auto;">
                    <tr>
                        <th>FDR A/c no.</th>
                        <th>Deposit Date</th>
                        <th>Amount</th>
                        <th>Interest</th>
                        <th>Days</th>
                        <th>Maturity-Amt</th>
                        <th>M-Date</th>
                    </tr>
                    <?php foreach($fdrfetch as $fdrstatement) { ?>
                    <tr>
                        <td><?= $fdrstatement['fdr_accno']?></td>
                        <td><?= date_format(date_create($fdrstatement['ddates']),'d-M-Y')?></td>
                        <td><?= $fdrstatement['amount']?></td>
                        <td><?= $fdrstatement['interest']?></td>
                        <td><?= $fdrstatement['period']?></td>
                        <td><?= $fdrstatement['maturity']?></td>
                        <td><?= date_format(date_create($fdrstatement['mdates']),'d-M-Y')?></td>
                    </tr>

                    <?php } ?>
                </table>

            <?php
                }
                if(isset($_POST['fixed'])) {
                    $acc = $_POST['account'];
                    $fdracc = $_POST['fdraccount'];
                    $deposit = $_POST['amount'];
                    $ddate = date_format(date_create($_POST['ddated']),'Y-m-d');
                    $mdate = date_format(date_create($_POST['mdated']),'Y-m-d');
                    $deposit = $_POST['amount'];
                    $days = $_POST['days'];
                    $interest = $_POST['interest'];
                    $mkintt = $interest/12;
                    $inttamout = ($deposit*$mkintt/100);
                    $ondays = $inttamout/30;
                    $meturity = $deposit+($ondays*$days);
                    $sdate = date('Y-m-d');

                    $insertfixed = $obj->query("INSERT INTO fixed_deposit (dates,accountno,ddates,fdr_accno,interest,period,amount,maturity,mdates) ".
                            "VALUES ('$sdate','$acc','$ddate','$fdracc','$interest','$days','$deposit','$meturity','$mdate')");
                    $insertdeposit = $obj->query("INSERT INTO depositor (dates,acc_no,remarks,creditor,debitor) ".
                            "VALUES ('$sdate','$acc','FDR transfer amount -- A/c.$fdracc','','$deposit')");
                    if(isset($insertfixed) && isset($insertdeposit)) {
                        echo '<div class="alert alert-success"><b>Success</b> Successfully insert your data</div>';
                    }
                }
                ?>

            <form class="form-horizontal" action="adminpage.php?fixedacc=1" method="post">
                <div class="form-group">
                    <label class="col-sm-5">Account No.</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="account">
                            <option value="">--select a/c--</option>
                            <?php foreach($fetchd as $option) { ?>
                                <option value="<?= $option['acc_no']?>"><?= $option['acc_no'].' '.$option['fname'].' '.$option['acc_type']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5">Fixed A/c No.</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="fdraccount" value="<?= '5500'.rand(10000,100000)?>" readonly="on"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5">Date</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" name="ddated" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5">Fixed Deposit Amount</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="amount" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5">Fixed Deposit Period</label>
                    <div class="col-sm-6">
                    <input type="text" name="days" class="form-control" placeholder="Enter the days"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5">Interest Rate %</label>
                    <div class="col-sm-6">
                    <input type="text" name="interest" class="form-control" placeholder="00.00"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5">Maturity Date</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" name="mdated" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-5">
                    <input type="submit" name="fixed" class="btn btn-default"/>
                    </div>
                </div>
            </form>
            
            <?php } elseif (isset($_GET['statement'])) { ?>
            
                <form class="form-horizontal" action="adminpage.php?statement=1" method="post" style="margin-top:3%;">
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-offset-3">Account No.</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="account">
                                <option value="">--select a/c--</option>
                                <?php foreach($fetchd as $option) { ?>
                                    <option value="<?= $option['acc_no']?>"><?= $option['acc_no'].' '.$option['fname'].' '.$option['acc_type']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-5">
                            <input type="submit" class="btn btn-primary" name="submitstate"/>
                        </div>
                    </div>
                </form>
            <?php
            if(isset($_POST['submitstate'])) {
                $account = $_POST['account'];
                $statementsql = $obj->query("SELECT * FROM depositor WHERE acc_no='$account' ORDER BY 'dates'");
                $statementfetch = $statementsql->fetchAll();
                if(!empty($statementfetch)) {
                ?>
                    <table class="table table-bordered" style="overflow-x: auto;">
                        <tr>
                            <th>Dated</th>
                            <th>Remarks</th>
                            <th>Deposit</th>
                            <th>Withdrawal</th>
                            <th>Balance</th>
                        </tr>
                        <?php foreach($statementfetch as $statement) { ?>
                        <tr>
                            <td><?= date_format(date_create($statement['dates']),'d-M-Y')?></td>
                            <td><?= $statement['remarks']?></td>
                            <td><?= $cr = $statement['creditor']?></td>
                            <td><?= $dr = $statement['debitor']?></td>
                            <td><?= @$amt += ($cr-$dr)?></td>
                        </tr>
                        <?php } ?>
                    </table>
                <?php }
            }
            } else { ?>
            
            <table class="table table-bordered">
                <tr>
                    <th>Account No.</th>
                    <th>Date</th>
                    <th>Photo</th>
                    <th>Client Name</th>
                    <th>Father name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Contact</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php if(!empty($fetchd)) {
                    foreach($fetchd as $userstate) {
                    ?>
                    <tr>
                        <td><?= $userstate['acc_no']?></td>
                        <td><?= date_format(date_create($userstate['dates']),'d-M-Y')?></td>
                        <td><img src="userphoto/<?= $userstate['img_url']?>" width="40" height="40" /></td>
                        <td><?= $userstate['fname']?></td>
                        <td><?= $userstate['fathername']?></td>
                        <td><?= $userstate['address']?></td>
                        <td><?= $userstate['city']?></td>
                        <td><?= $userstate['state']?></td>
                        <td><?= $userstate['mobileno']?></td>
                        <td class="text-center"><span class="glyphicon glyphicon-refresh"></span></td>
                        <td class="text-center"><span class="glyphicon glyphicon-trash"></span></td>
                    </tr>
                <?php } } ?>
                </table>
             <?php } ?>
            
        </div>
        <div class="col-sm-3">
            <div class="span4 sidebar">
                <div class="padd">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="adminpage.php">User Statement</a></li>
                        <li><a href="adminpage.php?deposit=1">Deposit Amount</a></li>
                        <li><a href="adminpage.php?fixedacc=1">Fixed Deposit A/c</a></li>
                        <li><a href="adminpage.php?statement=1">A/c wise Statement</a></li>
                        <li><a href="#">Personal loans</a></li>
                        <li><a href="#">Pay your policy</a></li>
                        <li><a href="#">Print Passbook</a></li>
                        <li><a href="#">Update/Delete A/c</a></li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>