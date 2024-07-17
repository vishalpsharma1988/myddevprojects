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
        <h2>Edit CLient<?php
        // Create a DateTime object from the fetched date
        $fetched_date = $data->maintenance_date;
        $dateTime = new DateTime($fetched_date);
        // Format the date to 'dd-mm-yyyy'
        $dateOnly = $dateTime->format('Y-m-d');
       
        ?></h2>

        <form id="custom-table-form" method="post" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="client_id" value="<?php echo $data->client_id; ?>">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="name">Client Name</label></th>
                    <td><input name="client_name" type="text" id="name" value="<?php echo esc_attr( $data->client_name ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="email">Email</label></th>
                    <td><input name="client_email" type="email" id="email" value="<?php echo esc_attr( $data->client_email ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="website">Website URL</label></th>
                    <td><input name="client_website" type="text" id="website" value="<?php echo esc_attr( $data->client_website ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="website">Maintenance Date</label></th>
                    <td><input type="date" id="maintenance_date" name="maintenance_date" value="<?php  echo esc_attr($dateOnly); ?>" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="plugins">Plugins Updated?</label></th>
                    <td><input name="plugins" type="checkbox" id="plugins" value="<?php echo esc_attr( $data->plugins ); ?>" class="regular-text" <?php checked($data->plugins, 'true'); ?> ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="themes">Themes Updated?</label></th>
                    <td><input name="themes" type="checkbox" id="themes" value="<?php echo esc_attr( $data->themes ); ?>" class="regular-text" <?php checked($data->themes, 'true'); ?> ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="wordpress">WordPress Updated?</label></th>
                    <td><input name="wordpress" type="checkbox" id="wordpress" value="<?php echo esc_attr( $data->wordpress ); ?>" class="regular-text" <?php checked($data->wordpress, 'true'); ?> ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="php-upgrade">PHP Upgrade?</label></th>
                    <td><input name="php_upgrade" type="checkbox" id="php-upgrade" value="<?php echo esc_attr( $data->php_upgrade ); ?>" class="regular-text" <?php checked($data->php_upgrade, 'true'); ?> ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="php-notes">Notes</label></th>
                    <td><textarea id="notes" name="notes" rows="4" cols="60"><?php echo esc_attr( $data->notes); ?></textarea></td>
                    
                </tr>
                <tr>
                    <th scope="row"><label for="status">Status</label></th>
                    <td><select name="options[status]" id="status">
                        <option value="published" <?php selected( $data->status, 'published' ); ?>>Published</option>
                        <option value="draft" <?php selected( $data->status, 'draft' ); ?>>Draft</option>
                    </select></td>
                    
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Update">
            </p>
        </form>
    </div>