    <ul class="thumbnails">
    <?php
    foreach ($this->presets as $preset => $preset_item)
    {
        $preset_attr = str_replace(" ", "", strtolower($preset));
    ?>
            <li class="span2">
                <a href="javascript:void(0);" id="preset_<?php echo @$preset_attr ?>" class="thumbnail preset" data-preset-id="<?php echo @$preset_attr ?>" <?php if(file_exists('img/presets/' . $preset_attr . '.png')) echo ' style="background-image:url(img/presets/' . $preset_attr . '.png'.')"'; ?>>
                    <div><?php echo @$preset ?></div>
                </a>
            </li>
    <?php
    }
    ?>
    </ul>
