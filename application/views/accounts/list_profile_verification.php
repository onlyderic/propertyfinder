
<?php if($verifiedagent != YES) { ?>
<button class="btn btn-medium btn-primary verify-agent" type="button" data-url="<?php echo site_url('verify/agent/' . url_title($userfullname) . '/' . $usercode); ?>">
    <span><i class="icon-ok-sign icon-white"></i> Verify my license</span><span></span>
</button>
<div class="spacer-small"></div>
<?php } ?>

<?php if(count($list_profile_verification) <= 0) { ?>

<div class="alert alert-info">No records were found.</div>

<?php } else { ?>

<table class="table table-condensed table-striped">
    <tr>
        <th style="width:150px;">Transaction No.</th>
        <th>Amount (US$)</th>
        <th>Date</th>
        <th>Status</th>
        <th>Paid</th>
    </tr>
    <?php foreach($list_profile_verification as $rec) { ?>
    <tr class="info">
        <td rowspan="2" style="width:150px;"><?php echo $rec->code; ?></td>
        <td><?php echo format_money($rec->amount); ?></td>
        <td><?php echo $rec->trxdate; ?></td>
        <td><?php echo (empty($rec->ppstatus) ? '-' : $rec->ppstatus); ?></td>
        <td><?php echo get_text_paid($rec->paystatus); ?></td>
    </tr>
    <tr>
        <td colspan="4">
            <?php 
            if($rec->recstatus == PAYRECSTATUS_VERIFYING) {
                echo 'Verifying account. It will be updated soon.';
            } elseif($rec->recstatus == PAYRECSTATUS_ACTIVE) {
                echo 'Your account has been verified. Thank you.';
            }
            ?>
            &nbsp;
        </td>
    </tr>
    <?php } ?>
</table>

<?php } ?>