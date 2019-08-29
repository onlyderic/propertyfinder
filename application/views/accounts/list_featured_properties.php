
<?php if(count($list_featured_properties) <= 0) { ?>

<div class="alert alert-info">No records were found.</div>

<?php } else { ?>

<table class="table table-condensed table-striped">
    <tr>
        <th style="width:150px;">Transaction No.</th>
        <th>Property Name</th>
        <th>Amount (US$)</th>
        <th>Date</th>
        <th>Status</th>
        <th>Paid</th>
    </tr>
    <?php foreach($list_featured_properties as $rec) { ?>
    <tr class="info">
        <td rowspan="2" style="width:150px;"><?php echo $rec->code; ?></td>
        <td><a href="<?php echo site_url('property/' . url_title($rec->propname) . '/' . $rec->propcode); ?>" target="_blank"><?php echo shorten_text($rec->propname, 30); ?></a></td>
        <td><?php echo format_money($rec->amount); ?></td>
        <td><?php echo $rec->trxdate; ?></td>
        <td><?php echo (empty($rec->ppstatus) ? '-' : $rec->ppstatus); ?></td>
        <td><?php echo get_text_paid($rec->paystatus); ?></td>
    </tr>
    <tr>
        <td colspan="5"><?php echo ( !empty($rec->startdate) && !empty($rec->enddate) ? '(' . $rec->numdays . ' Days) ' . $rec->startdate . ' to ' .$rec->enddate : '' ); ?>&nbsp;</td>
    </tr>
    <?php } ?>
</table>

<?php } ?>