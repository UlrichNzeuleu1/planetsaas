<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$first_letter = substr($dropcap_content, 0, 1);
$first_letter_style = array();
$first_letter_style[] = " color: $dropcap_box_color;";
$first_letter_style[] = " background: $dropcap_box_bg;";
?>
<div class="cms-dropcap <?php echo $el_class; ?> <?php if ($dropcap_box == 'yes') {echo 'box'; } ?> <?php echo $dropcap_type ?>">
    <?php echo '<span class="cms-first-letter" '. haswell_build_style($first_letter_style) .'>'.$first_letter.'</span>'; ?>
    <?php echo substr($dropcap_content, 1, strlen($dropcap_content)); ?>
</div>