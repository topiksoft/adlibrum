<select class="item item_type_select input-medium" id="<?php echo @$content['id']; ?>" name="<?php echo @$content['id']; ?>">
    <?php
    foreach (@$content['options'] as $o_key => $o_val) {
        $o_selected = '';
       if (get_value(@$content['id']) == $o_key) $o_selected = 'selected="selected"';
        echo '<option value="'.$o_key.'"'.$o_selected.'>'.$o_val.'</option>';
    }
    ?>
</select>