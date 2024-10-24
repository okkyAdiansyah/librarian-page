<?php
/**
 * Main plugin settings view
 * 
 * @package Librarian
 */
?>
<div class="wrap">
    <h1>General Settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields( 'librarian_general' );
        do_settings_sections( 'librarian_general' );
        submit_button( 'Save Settings' );
        ?>
    </form>
</div>