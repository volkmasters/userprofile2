<?php

$properties = array();

$tmp = array(
    'tplUser'       => array(
        'type'  => 'textfield',
        'value' => 'tpl.up2User.small.Info',
    ),
    'tplNoUser'     => array(
        'type'  => 'textfield',
        'value' => '@INLINE <p>No User</p>',
    ),
    'user_id'       => array(
        'type'  => 'numberfield',
        'value' => '',
    ),
    'dateFormat'    => array(
        'type'  => 'textfield',
        'value' => 'd F Y, H:i',
    ),
    'gravatarIcon'  => array(
        'type'  => 'textfield',
        'value' => 'mm',
    ),
    'gravatarSize'  => array(
        'type'  => 'numberfield',
        'value' => '64',
    ),
    'toPlaceholder' => array(
        'type'  => 'combo-boolean',
        'value' => false,
    ),
);

foreach ($tmp as $k => $v) {
    $properties[] = array_merge(
        array(
            'name'    => $k,
            'desc'    => PKG_NAME_LOWER . '_prop_' . $k,
            'lexicon' => PKG_NAME_LOWER . ':properties',
        ), $v
    );
}

return $properties;