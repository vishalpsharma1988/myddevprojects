<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/vishalpsharma1988
 * @since      1.0.0
 *
 * @package    Wmr
 * @subpackage Wmr/admin/partials
 */

$fetched_date = $data->maintenance_date;
$dateTime = new DateTime($fetched_date);
$dateOnly = $dateTime->format('Y-m-d');
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. --> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Column Field Display</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            max-width: 800px; /* Adjust as needed */
            margin: 0 auto;
        }
        .field {
            width: 50%; /* Two columns */
            box-sizing: border-box;
            padding: 10px;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<h2>View CLient</h2>
<div class="container">

    <div class="field">
        <span class="label">Client Name: </span><?php echo esc_attr( $data->client_name ); ?>
    </div>
    <div class="field">
        <span class="label">Email: </span> <?php echo esc_attr( $data->client_email ); ?>
    </div>
    <div class="field">
        <span class="label">Website URL: </span> <?php echo esc_attr( $data->client_website ); ?>
    </div>
    <div class="field">
        <span class="label">Maintenance Date: </span> <?php  echo esc_attr($dateOnly); ?>
    </div>
    <div class="field">
        <span class="label">Plugins Updated?: </span> <?php echo esc_attr( $data->plugins ); ?>
    </div>
    <div class="field">
        <span class="label">Themes Updated?: </span> <?php echo esc_attr( $data->themes ); ?>
    </div>
    <div class="field">
        <span class="label">WordPress Updated?: </span> <?php echo esc_attr( $data->wordpress ); ?>
    </div>
    <div class="field">
        <span class="label">PHP Upgrade?: </span> <?php echo esc_attr( $data->php_upgrade ); ?>
    </div>
    <div class="field">
        <span class="label">Notes: </span> <?php echo esc_attr( $data->notes); ?>
    </div>
    <div class="field">
        <span class="label">Status: </span> <?php echo $data->status; ?>
    </div>
</div>

</body>
</html>
