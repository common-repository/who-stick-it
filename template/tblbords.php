<?php
$who_stick_it = get_option('who_stick_it');
$table_who_stick_it = json_decode($who_stick_it, true);

if (isset($_POST['sup_suc'])) {
    unset($table_who_stick_it[$_POST['sup_suc']]);
    $new_value = json_encode($table_who_stick_it);
    self::set_option('who_stick_it', $new_value);
}


if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $espace = $_POST['space'];
    $type = $_POST['type'];
    $exclude = $_POST['exclude'];
    if (isset($who_stick_it)) {
        $table_who_stick_it = json_decode($who_stick_it, true);
        $sum = count($table_who_stick_it);
        $sum = $sum + 1;
        $table_who_stick_it[$sum] = array($name, $espace, $type, $exclude);
        $new_value = json_encode($table_who_stick_it);
        self::set_option('who_stick_it', $new_value);
    } else {
        $table_who_stick_it = array();
        $table_who_stick_it[] = array($name, $espace, $type, $exclude);
        $new_value = json_encode($table_who_stick_it);
        self::set_option('who_stick_it', $new_value);
    }
}

if ((isset($_POST['id_stick'])) && (isset($_POST['space'])) && (isset($_POST['name']))) {
    $table_who_stick_it = json_decode($who_stick_it, true);
    $name = $_POST['name'];
    $espace = $_POST['space'];
    $type = $_POST['type'];
    $exclude = $_POST['exclude'];

    $table_who_stick_it[$_POST['id_stick']] = array($name, $espace, $type, $exclude);
    $new_value = json_encode($table_who_stick_it);
    self::set_option('who_stick_it', $new_value);
}
//ajouter un sytéme de tris 
?>   
<div class="block_admin" style="float: left; width: 90%; margin: 0%; padding: 0%; height: 50px;">
    <h1>AlT Stick it</h1>
    <p><?php _e("- Choose the type of item to cover: a class or ID .", "who-stick-it"); ?></p>
    <p><?php _e("- Indicate the distance in pixels between your class / ID and the top of the page when the user going scroller menu will be locked at the distance you have indicated .", "who-stick-it"); ?></p>
    <table>  
        <thead>
            <tr>
                <th><?php _e("Type", "who-stick-it"); ?></th>
                <th><?php _e("Name of your class or ID", "who-stick-it"); ?></th>
                <th><?php _e("Pixel space with the top of the page", "who-stick-it"); ?></th>
                <th><?php _e("If a class or ID is present do not enable the sticky", "who-stick-it"); ?></th>
                <th colspan="2"><?php _e("Edit / Delete", "who-stick-it"); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>   
        <form method="POST">
            <td  >    
                <select name="type" required>
                    <option value=""></option>
                    <option value="class">class</option>
                    <option value="id">ID</option>
                </select>
            </td>
            <td>    
                <input type="text" name="name" placeholder="<?php _e("Name of your class or ID", "who-stick-it"); ?>" required style="width: 200px">
            </td>
            <td >    
                <input  type="number" name="space" placeholder="<?php _e("Pixel size", "who-stick-it"); ?>" value="0" >pixel
            </td>
            <td >    
                <input  type="number" name="exclude" placeholder="<?php _e("#id, .class ", "who-stick-it"); ?>" value="" >exclude
            </td>
            <td >     
                <input type="submit" class="button button-primary" value="<?php _e("Add On", "who-stick-it"); ?>" style="width: 100px">
            </td>
        </form>
        </tr>

        <?php
        if (isset($table_who_stick_it)) {
            foreach ($table_who_stick_it as $key => $value) {
                ?>

                <tr>
                <form method="POST">
                    <td>
                        <select name="type" required>
                            <option value=""></option>
                            <option value="class" <?php echo ($value[2] == "class") ? 'selected' : '' ?>>class</option>
                            <option value="id" <?php echo ($value[2] == "id") ? 'selected' : '' ?>>id</option>
                        </select>
                    </td>
                    <td>  
                        <input type="text" name="name" value="<?php echo $value[0] ?>" required style="width: 200px">
                    </td>
                    <td> 
                        <input type="text" name="space" value="<?php echo $value[1] ?>">pixel
                    </td>
                    <td> 
                        <input type="text" name="exclude" value="<?php echo $value[3] ?>">exclude
                    </td>
                    <td>    
                        <input type="submit" class="button button-primary" value="Editer" style="width: 100px">
                        <input type="hidden" name="id_stick" value="<?php echo $key ?>">
                    </td>
                </form>
                <td>   
                    <form method="POST">
                        <input type="hidden" name="sup_suc" value="<?php echo $key ?>" >
                        <input type="submit" class="button button-primary" value="Supprimer" style="background: red; border-color: brown; width: 100px;" onclick="javascript:return confirm('<?php _e("Are you sure?", "who-stick-it"); ?>')">
                    </form>
                </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>