<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $browser_title;?></title>

    <?php foreach ($css_files as $css_file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $css_file;?>">
    <?php endforeach; ?>

</head>
<body>









<div class="container" style="paddin-top:3px;">
    <main>
<?php foreach ($arbs as $website=>$website_details) : ?>
<?php foreach ($website_details as $sport=>$sport_details) : ?>
<?php foreach ($sport_details as $competition=>$competition_arbs) : ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><?php echo $website;?></li>
            <li class="breadcrumb-item"><?php echo $sport;?></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $competition;?></li>
        </ol>
    </nav>

<?php foreach ($competition_arbs as $results): ?>
<h4><?php echo $results['teams'][0] . ' vs ' . $results['teams'][1];?></h4>


<?php foreach ($results['arbs'] as $arb) : $i = 0;?>
    <table id="<?php echo $results['teams'][0];?>-<?php echo $results['teams'][1];?>" class="mb-5 table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Odds</th><th>Bookmakers</th><th>Result</th><th style="text-align: center">Fractional Odds</th><th style="text-align: center">Market Total</th>
        </tr>
        </thead>
    <?php foreach($arb['odds'] as $odd): ?>
        <tr class="<?php if($i == (count($arb['odds'])-1)): ?>py-5<?php endif;?>">
            <td><?php echo $odd['odds'];?></td>
            <td><?php echo $odd['bookmakers'];?></td>
            <td><?php echo $odd['result'];?></td>
            <td align="center"><?php echo $odd['fractional_odds'];?></td>
            <?php if($i == (count($arb['odds'])-1)): ?>
                <td align="center"><?php echo $arb['market_total'];?></td>
            <?php else: ?>
            <td></td>
            <?php endif;?>
        </tr>
    <?php $i++;?>
    <?php endforeach;?>
    </table>
<?php endforeach; ?>

<?php endforeach;?>
<?php endforeach; ?>
<?php endforeach; ?>
<?php endforeach;?>
    </main>
</div>

<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>