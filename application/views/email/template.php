<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <style>
    body {
      margin: 0;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 14px;
      line-height: 20px;
      color: #333333;
      background-color: #ECEEF2;
    }
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      margin: 0;
      font-family: inherit;
      font-weight: bold;
      line-height: 20px;
      color: inherit;
      text-rendering: optimizelegibility;
    }
    </style>
</head>
<body>
    
    <table border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" width="100%">
        <tr>
            <td width="100%" align="center" style="background-color:#ECEEF2;">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <table border="0" cellspacing="0" cellpadding="0" width="600">
                    <tr>
                        <td width="100%" align="left" style="background-color:#424242;padding:20px 10px;">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="25" align="left"><img src="<?php echo site_url(); ?>assets/img/propertyfinder.gif" width="20" /></td>
                                    <td style="padding:0px;margin:0px;"><h2 style="color:#ECEEF2;padding:0px;margin:0px;">propertyfinder.com</h2></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" align="center" style="background-color:#999999;height:5px;"></td>
                    </tr>
                    <tr>
                        <td width="100%" style="background-color:#FFFFFF;padding:10px;">

    <?php if($mode == 'register') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td><h3 align="center">Welcome to propertyfinder.com, <?php echo $name; ?>!</h3></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td style="text-align: justify;">
                Thank you for creating an account with us.<br/><br/>You can now upload and market your properties on the most purposeful property portal ever. Experience easier, detailed and up-to-date online property searching!<br/><br/>Best of all, it's FREE! And we intend to put it that way forever.<br/><br/>
                <a href="<?php echo site_url(); ?>" style="text-decoration:none;color:#40568B;">Go to the best property portal site now &Gt;</a>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
                                
    <?php } else if($mode == 'contactus') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td><h3 align="center">User Feedback</h3></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Topic:</strong> <?php echo $topic; ?></td></tr>
        <tr><td>From:</strong> <?php echo $fromname; ?></td></tr>
        <tr><td>Email:</strong> <?php echo $fromemail; ?></td></tr>
        <tr><td>IP Address:</strong> <?php echo $ip; ?></td></tr>
        <tr><td>Message:</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><?php echo $message; ?></td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
    
    <?php } else if($mode == 'forgotpassword') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td style="text-align: justify;">
                To <?php echo $name; ?>:<br/><br/>
                We have received a request to reset your password. Did you personally send this request?<br/>
                If you have not voluntarily do this, please report this malicious email to us at <a href="mailto:report@propertyfinder.com" style="text-decoration:none;color:#40568B;">report@propertyfinder.com</a> along with this email.
                <br/><br/>
                To reset your password, please click the link below or copy and paste it on a browser.<br/>
                You will be asked to reset your password in the form provided by the link.
                <br/><br/>
                <a href="<?php echo $urlcode; ?>" style="text-decoration:none;color:#40568B;"><?php echo $urlcode; ?></a>
                <br/><br/>
                If you encounter problems while using this, please report it to <a href="mailto:report@propertyfinder.com" style="text-decoration:none;color:#40568B;">report@propertyfinder.com</a>.
                <br/><br/>
                Thank you for using propertyfinder.com!
                <br/><br/>
                propertyfinder.com Support Team
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
    
    <?php } else if($mode == 'property feature invoice') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td><h3 align="center">Your propertyfinder.com Receipt</h3></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td colspan="2"><strong>Feature the Property</strong></td></tr>
                    <tr><td width="150">Property:</td><td><a href="<?php echo site_url('property/' . url_title($record['propname']) . '/' . $record['propcode']); ?>" style="text-decoration:none;color:#40568B;"><?php echo $record['propname']; ?></a></td></tr>
                    <tr><td width="150">Type:</td><td><?php echo $record['propclassification']; ?></td></tr>
                    <tr><td width="150">Location:</td><td><?php echo $record['proplocation']; ?></td></tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr><td colspan="2"><strong>Transaction Details</strong></td></tr>
                    <tr><td width="150">PayPal Code:</td><td><?php echo $record['ppcode']; ?></td></tr>
                    <tr><td width="150">Invoice Number:</td><td><?php echo $record['trxcode']; ?></td></tr>
                    <tr><td width="150">Date:</td><td><?php echo $record['startdate']; ?></td></tr>
                    <tr><td width="150">Amount:</td><td><?php echo $record['amount']; ?></td></tr>
                    <tr><td width="150">Status:</td><td><?php echo $record['ppstatus']; ?></td></tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr><td colspan="2"><strong>Feature Details</strong></td></tr>
                    <tr><td width="150">Number of Days:</td><td><?php echo $record['numdays']; ?></td></tr>
                    <tr><td width="150">Start Date:</td><td><?php echo $record['startdate']; ?></td></tr>
                    <tr><td width="150">Expiration Date:</td><td><?php echo $record['enddate']; ?></td></tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td style="text-align:justify;">You can view this transaction record on your <a href="<?php echo site_url('account'); ?>" style="text-decoration:none;color:#40568B;">My Account</a> page.</td></tr>
        <tr><td style="text-align:justify;">If you find a problem on this transaction, please notify us at <a href="mailto:report@propertyfinder.com" style="text-decoration:none;color:#40568B;">report@propertyfinder.com</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Thank you for using propertyfinder's Property Feature!</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>propertyfinder.com Sales Team</td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
    
    <?php } else if($mode == 'profile feature invoice') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td><h3 align="center">Your propertyfinder.com Receipt</h3></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td colspan="2"><strong>Feature My Profile</strong></td></tr>
                    <tr><td width="150">Agent:</td><td><a href="<?php echo site_url('property/' . url_title($record['username']) . '/' . $record['usercode']); ?>" style="text-decoration:none;color:#40568B;"><?php echo $record['username']; ?></a></td></tr>
                    <tr><td width="150">ID:</td><td><?php echo $record['usercode']; ?></td></tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr><td colspan="2"><strong>Transaction Details</strong></td></tr>
                    <tr><td width="150">PayPal Code:</td><td><?php echo $record['ppcode']; ?></td></tr>
                    <tr><td width="150">Invoice Number:</td><td><?php echo $record['trxcode']; ?></td></tr>
                    <tr><td width="150">Date:</td><td><?php echo $record['startdate']; ?></td></tr>
                    <tr><td width="150">Amount:</td><td><?php echo $record['amount']; ?></td></tr>
                    <tr><td width="150">Status:</td><td><?php echo $record['ppstatus']; ?></td></tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr><td colspan="2"><strong>Feature Details</strong></td></tr>
                    <tr><td width="150">Number of Days:</td><td><?php echo $record['numdays']; ?></td></tr>
                    <tr><td width="150">Start Date:</td><td><?php echo $record['startdate']; ?></td></tr>
                    <tr><td width="150">Expiration Date:</td><td><?php echo $record['enddate']; ?></td></tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td style="text-align:justify;">You can view this transaction record on your <a href="<?php echo site_url('account'); ?>" style="text-decoration:none;color:#40568B;">My Account</a> page.</td></tr>
        <tr><td style="text-align:justify;">If you find a problem on this transaction, please notify us at <a href="mailto:report@propertyfinder.com" style="text-decoration:none;color:#40568B;">report@propertyfinder.com</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Thank you for using propertyfinder's Agent Profile Feature!</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>propertyfinder.com Sales Team</td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
    
    <?php } else if($mode == 'verify profile invoice') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td><h3 align="center">Your propertyfinder.com Receipt</h3></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td colspan="2"><strong>Verify My License</strong></td></tr>
                    <tr><td width="150">Agent:</td><td><a href="<?php echo site_url('property/' . url_title($record['username']) . '/' . $record['usercode']); ?>" style="text-decoration:none;color:#40568B;"><?php echo $record['username']; ?></a></td></tr>
                    <tr><td width="150">ID:</td><td><?php echo $record['usercode']; ?></td></tr>
                    <tr><td width="150">License Number:</td><td><?php echo $record['licensenum']; ?></td></tr>
                    <tr><td width="150">Company:</td><td><?php echo $record['companyname']; ?></td></tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr><td colspan="2"><strong>Transaction Details</strong></td></tr>
                    <tr><td width="150">PayPal Code:</td><td><?php echo $record['ppcode']; ?></td></tr>
                    <tr><td width="150">Invoice Number:</td><td><?php echo $record['trxcode']; ?></td></tr>
                    <tr><td width="150">Date:</td><td><?php echo $record['startdate']; ?></td></tr>
                    <tr><td width="150">Amount:</td><td><?php echo $record['amount']; ?></td></tr>
                    <tr><td width="150">Status:</td><td><?php echo $record['ppstatus']; ?></td></tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><strong>Verification Details</strong></td></tr>
        <tr>
            <td style="text-align:justify;">
            This will be a one-time process, and no need for renewal.<br/>
            In the event of negative verification, you will be informed by our staff through email. Please take note that no refund of payment will be made.<br/>
            For successful verification, it will automatically reflect on your account.    
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td style="text-align:justify;">You can view this transaction record on your <a href="<?php echo site_url('account'); ?>" style="text-decoration:none;color:#40568B;">My Account</a> page.</td></tr>
        <tr><td style="text-align:justify;">If you find a problem on this transaction, please notify us at <a href="mailto:report@propertyfinder.com" style="text-decoration:none;color:#40568B;">report@propertyfinder.com</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Thank you for using propertyfinder's Verified Accounts!</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>propertyfinder.com Sales Team</td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>       
    <?php } ?>
                            
                        </td>
                    </tr>
                </table>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
</body>
</html>
        