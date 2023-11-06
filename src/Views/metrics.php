<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Forge | Metrics</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datatables.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>
    <div class="container center-content">
        <div class="row custom-block">
            <h1>Metrics</h1>
        </div>
        <table id="metrics" style="width: 100%" class="custom-block">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Ad id</th>
                    <th>Impressions</th>
                    <th>Clicks</th>
                    <th>Unique Clicks</th>
                    <th>Leads</th>
                    <th>Conversion</th>
                    <th>Roi (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $metric) { ?>
                    <tr>
                        <td><?php echo $metric['id'] ?></td>
                        <td><?php echo $metric['ad_id'] ?></td>
                        <td><?php echo $metric['impressions'] ?></td>
                        <td><?php echo $metric['clicks'] ?></td>
                        <td><?php echo $metric['unique_clicks'] ?></td>
                        <td><?php echo $metric['leads'] ?></td>
                        <td><?php echo $metric['conversion'] ?></td>
                        <td><?php echo $metric['roi'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/datatables.min.js" ></script>
<script type="text/javascript" >
    $( document ).ready(function () {
        $('#metrics').DataTable({
            responsive: true
        })
    })
</script>
</body>
</html>
