<?php include 'header.php'; 
if(!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

<div class="container" style="margin-top:2%;margin-bottom:2%;">
    <div class="row">
        <div class="col-sm-3">
            <div class="span4 sidebar">
                <div class="padd">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="dashboard.php?fixedacc=1">Fixed Deposit A/c</a></li>
                        <li><a href="dashboard.php?statement=1">Statement your A/c</a></li>
                        <li><a href="dashboard.php?recharge=1">Online Recharge</a></li>
                        <li><a href="#">Personal loans</a></li>
                        <li><a href="#">Pay your policy</a></li>
                        <li><a href="#">Pay Electricity Bill</a></li>
                        <li><a href="#">Recharge DTH</a></li>
                        
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Client Information
                    <img src="userphoto/<?= $client['img_url']?>" width="38" height="40" style="float:right;margin-top:-10px;border-radius:50%;" />
                </div>
                <div class="panel-body">
                    
                    <?php if(isset($_GET['fixedacc'])) { 
                        
                        $fdrsql2 = $obj->query("SELECT * FROM fixed_deposit WHERE accountno='$username'");
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
                        if($balance > 500) {
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
                            }
                        } else {
                            $noamt = "you have sufficiant balance";
                        }
                        ?>
                    
                    <form class="form-horizontal" action="dashboard.php?fixedacc=1" method="post">
                        <?php 
                        if(isset($insertfixed) && isset($insertdeposit)) {
                            echo '<div class="alert alert-success"><b>Success</b> Successfully insert your data</div>';
                        }
                        if(isset($noamt)) {
                            echo '<div class="alert alert-warning"><b>Warning</b> '.$noamt.'</div>';
                        }
                        ?>
                        <div class="form-group">
                            <label class="col-sm-5">Account No.</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="account" value="<?= $client['acc_no']?>" readonly="on"/>
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
                    
                    <?php } elseif (isset($_GET['statement'])) { 
                        
                        $statementsql = $obj->query("SELECT * FROM depositor WHERE acc_no='$username' ORDER BY 'dates'");
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
                     } elseif (isset($_GET['recharge'])) { ?>
                    
                    <form class="form-horizontal" action="dashboard.php?recharge=1" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 col-sm-offset-1">Connection</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="service">
                                    <option value="">--Select service--</option>
                                    <option value="AirTel">AirTel</option>
                                    <option value="vodafone">Vodafone</option>
                                    <option value="Jio">Jio</option>
                                    <option value="Idea">Idea</option>
                                    <option value="TataDocomo">TataDocomo</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-sm-offset-1">Mobile No</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="moblie" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-sm-offset-1">Amount</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="amount" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-4">
                                <input type="submit" class="form-control btn-primary" name="recharged" />
                            </div>
                        </div>
                    </form>
                    
                    <?php } else { ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Account No.:</th>
                            <td><?= $client['acc_no']?></td>
                        </tr>
                        <tr>
                            <th>Account Type:</th>
                            <td><?= $client['acc_type']?></td>
                        </tr>
                        <tr>
                            <th>Password.:</th>
                            <td><?= $client['text_pass']?></td>
                        </tr>
                        <tr>
                            <th>Name.:</th>
                            <td><?= $client['fname']?></td>
                        </tr>
                        <tr>
                            <th>Father Name:</th>
                            <td><?= $client['fathername']?></td>
                        </tr>
                        <tr>
                            <th>Mother Name :</th>
                            <td><?= $client['mothername']?></td>
                        </tr>
                        <tr>
                            <th>Contact No :</th>
                            <td><?= $client['mobileno']?></td>
                        </tr>
                        <tr>
                            <th>Gender :</th>
                            <td><?= $client['gender']?></td>
                        </tr>
                        <tr>
                            <th>Address :</th>
                            <td><?= $client['address']?></td>
                        </tr>
                        <tr>
                            <th>City :</th>
                            <td><?= $client['city']?></td>
                        </tr>
                        <tr>
                            <th>State:</th>
                            <td><?= $client['state']?></td>
                        </tr>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>

<?php include 'footer.php'; ?>