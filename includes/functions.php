<?php

add_action('wp_footer', 'hook_css');

function hook_css() {
    ?>

    <script>
  jQuery(document).ready(function(){
         <?Php
    $who_stick_it = get_option('who_stick_it');
    $table_who_stick_it = json_decode($who_stick_it, true);
    foreach ($table_who_stick_it as $key => $value) {
        $class = $value[0];
        if ($value[2] == 'id') {
            $class = "#" . $value[0];
        }
        if ($value[2] == 'class') {
            $class = "." . $value[0];
        }
        if (isset($value[3]) && $value[3] != '') {
            ?>
                        if (!jQuery("<?php echo $value[3] ?>")[0]) {
                            jQuery("<?php echo $class ?>").sticky({topSpacing: <?php echo $value[1] ?>});
                        }
            <?php
        } else {
            ?>
                        jQuery("<?php echo $class ?>").sticky({topSpacing: <?php echo $value[1] ?>});
            <?php
        }
    }
    ?>

  });
</script>
    <?php
}
