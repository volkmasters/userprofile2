<?php
/** @var array $scriptProperties */
/** @var userprofile2 $userprofile2 */
if (!$userprofile2 = $modx->getService('userprofile2', 'userprofile2', $modx->getOption('userprofile2_core_path', null,
        $modx->getOption('core_path') . 'components/userprofile2/') . 'model/userprofile2/', $scriptProperties)
) {
    return 'Could not load userprofile2 class!';
}
$userprofile2->initialize($modx->context->key, $scriptProperties);
//
if (empty($user_id)) {
    return '';
}
$row = $userprofile2->getUserFields($user_id);
$realFields = $userprofile2->_getRealFields();
if (!empty($row['type']) && $TabsFields = $userprofile2->getTabsFields($row['type'])) {
    $idx = 1;
    foreach ($TabsFields as $tabName => $tab) {
        if (empty($tab['fields'])
            || !is_array($tab['fields'])
            || array_key_exists($tabName, explode(',', $excludeTabs))
        ) {
            continue;
        }
        if (empty($activeTab)) {
            $row['active'] = ($idx == 1) ? 'active' : '';
        } else {
            $row['active'] = ($activeTab == $tabName) ? 'active' : '';
        }
        $row['tabname'] = $tabName;
        $row['tabtitle'] = $tab['name_in'];
        $row['idx'] = $idx++;
        $row['navrows'] .= empty($tplNavTabsRow)
            ? $userprofile2->pdoTools->getChunk('', $row)
            : $userprofile2->pdoTools->getChunk($tplNavTabsRow, $row, $userprofile2->pdoTools->config['fastMode']);
        $row['fieldrows'] = '';
        foreach ($tab['fields'] as $fieldName => $field) {
            if (array_key_exists($fieldName, $realFields)) {
                $row['value'] = $row[$fieldName];
            } else {
                $row['value'] = $row['extend'][$fieldName];
            }
            $row['name'] = $field['name_in'];
            $row['nameout'] = $field['name_out'];
            $row['class'] = $field['css'];
            $row['type_out'] = $field['type_out'];
            $row['required'] = !empty($field['required']) ? $required : '';
            $row['fieldrows'] .= empty($tplContentTabPaneRow)
                ? $userprofile2->pdoTools->getChunk('', $row)
                : $userprofile2->pdoTools->getChunk($tplContentTabPaneRow, $row,
                    $userprofile2->pdoTools->config['fastMode']);
        }
        $row['tabrows'] .= empty($tplContentTabPane)
            ? $userprofile2->pdoTools->getChunk('', $row)
            : $userprofile2->pdoTools->getChunk($tplContentTabPane, $row, $userprofile2->pdoTools->config['fastMode']);
    }
    $row['contenttabs'] = empty($tplContentTabsOuter)
        ? $userprofile2->pdoTools->getChunk('', $row)
        : $userprofile2->pdoTools->getChunk($tplContentTabsOuter, $row, $userprofile2->pdoTools->config['fastMode']);
    $row['navtabs'] = empty($tplNavTabsOuter)
        ? $userprofile2->pdoTools->getChunk('', $row)
        : $userprofile2->pdoTools->getChunk($tplNavTabsOuter, $row, $userprofile2->pdoTools->config['fastMode']);
    $row['tabs'] = empty($tplTabsOuter)
        ? $userprofile2->pdoTools->getChunk('', $row)
        : $userprofile2->pdoTools->getChunk($tplTabsOuter, $row, $userprofile2->pdoTools->config['fastMode']);
}
// output
$output = empty($tplUser)
    ? $userprofile2->pdoTools->getChunk('', $row)
    : $userprofile2->pdoTools->getChunk($tplUser, $row, $userprofile2->pdoTools->config['fastMode']);
if (!empty($tplWrapper) && (!empty($wrapIfEmpty) || !empty($output))) {
    $output = $userprofile2->pdoTools->getChunk($tplWrapper, array('output' => $output),
        $userprofile2->pdoTools->config['fastMode']);
}
if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
} else {
    return $output;
}