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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
        <h2>Add CLient</h2>
        <form id="client-form" method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="name">Client Name</label></th>
                    <td><input name="client_name" type="text" id="client-name" value="" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="email">Email</label></th>
                    <td><input name="client_email" type="email" id="client-email" value="" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="website">Website URL</label></th>
                    <td><input name="client_website" type="text" id="client-website" value="" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="website">Maintenance Date</label></th>
                    <td><input type="date" id="maintenance_date" name="maintenance_date" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="plugins">Plugins Updated?</label></th>
                    <td><input name="plugins" type="checkbox" id="plugins" value="" class="regular-text" ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="themes">Themes Updated?</label></th>
                    <td><input name="themes" type="checkbox" id="themes" value="" class="regular-text"  ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="wordpress">WordPress Updated?</label></th>
                    <td><input name="wordpress" type="checkbox" id="wordpress" value="" class="regular-text"  ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="php-upgrade">PHP Upgrade?</label></th>
                    <td><input name="php_upgrade" type="checkbox" id="php-upgrade" value="" class="regular-text" ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="php-notes">Notes</label></th>
                    <td><textarea id="notes" name="notes" rows="4" cols="60"></textarea></td>
                    
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="submit_client" id="submit" class="button button-primary" value="Submit">
            </p>
        </form>
    </div>