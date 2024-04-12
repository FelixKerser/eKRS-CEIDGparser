<?php

// Создание метабокса для вашего CPT
function custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // Идентификатор метабокса
        'Дополнительные поля', // Название метабокса
        'display_custom_meta_box', // Функция для вывода содержимого метабокса
        'firmy', // Ваш пользовательский тип записи
        'normal', // Место расположения метабокса (normal, advanced, или side)
        'high' // Приоритет метабокса (high, core, default, или low)
    );
}
add_action('add_meta_boxes', 'custom_meta_box');

// Вывод содержимого метабокса
function display_custom_meta_box($post) {
    // Получение значений полей, если они уже установлены
    $miasto_value = get_post_meta($post->ID, '_miasto', true);
    $adresa_value = get_post_meta($post->ID, '_adresa', true);
    $kod_pocztowy_value = get_post_meta($post->ID, '_kod_pocztowy', true);
    $nip_value = get_post_meta($post->ID, '_nip', true);
    $regon_value = get_post_meta($post->ID, '_regon', true);

	$rejestr_value = get_post_meta($post->ID, '_rejestr', true);
	$krs_value = get_post_meta($post->ID, '_krs', true);
	$formaprawna_value = get_post_meta($post->ID, '_formaprawna', true);
	$wojewodztwo_value = get_post_meta($post->ID, '_wojewodztwo', true);
	$powiat_value = get_post_meta($post->ID, '_powiat', true);
	$gmina_value = get_post_meta($post->ID, '_gmina', true);
	$strona_value = get_post_meta($post->ID, '_strona', true);
	$emailadres_value = get_post_meta($post->ID, '_emailadres', true);
    ?>
    <label for="miasto">Miasto:</label>
    <input type="text" id="miasto" name="miasto" value="<?php echo esc_attr($miasto_value); ?>"><br>
    
    <label for="adresa">Adresa:</label>
    <input type="text" id="adresa" name="adresa" value="<?php echo esc_attr($adresa_value); ?>"><br>
    
    <label for="kod_pocztowy">Kod pocztowy:</label>
    <input type="text" id="kod_pocztowy" name="kod_pocztowy" value="<?php echo esc_attr($kod_pocztowy_value); ?>"><br>
    
    <label for="nip">NIP:</label>
    <input type="text" id="nip" name="nip" value="<?php echo esc_attr($nip_value); ?>"><br>
    
    <label for="regon">REGON:</label>
    <input type="text" id="regon" name="regon" value="<?php echo esc_attr($regon_value); ?>"><br>


	<label for="regon">Rejestr:</label>
    <input type="text" id="rejestr" name="rejestr" value="<?php echo esc_attr($rejestr_value); ?>"><br>

	<label for="regon">KRS:</label>
    <input type="text" id="krs" name="krs" value="<?php echo esc_attr($krs_value); ?>"><br>

	<label for="regon">Forma prawna:</label>
    <input type="text" id="formaprawna" name="formaprawna" value="<?php echo esc_attr($formaprawna_value); ?>"><br>

	<label for="regon">Województwo:</label>
    <input type="text" id="wojewodztwo" name="wojewodztwo" value="<?php echo esc_attr($wojewodztwo_value); ?>"><br>

	<label for="regon">Powiat:</label>
    <input type="text" id="powiat" name="powiat" value="<?php echo esc_attr($powiat_value); ?>"><br>

	<label for="regon">Gmina:</label>
    <input type="text" id="gmina" name="gmina" value="<?php echo esc_attr($gmina_value); ?>"><br>

	<label for="regon">Strona WWW:</label>
    <input type="text" id="strona" name="strona" value="<?php echo esc_attr($strona_value); ?>"><br>

	<label for="regon">Email:</label>
    <input type="text" id="emailadres" name="emailadres" value="<?php echo esc_attr($emailadres_value); ?>"><br>
    <?php
}

// Сохранение значений полей метабокса
function save_custom_meta_box($post_id) {
    // Проверка безопасности
    if (!isset($_POST['custom_field_nonce']) || !wp_verify_nonce($_POST['custom_field_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Проверка прав пользователя
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Сохранение данных
    $fields = array('miasto', 'adresa', 'kod_pocztowy', 'nip', 'regon', 'rejestr', 'krs', 'formaprawna', 'wojewodztwo', 'powiat', 'gmina', 'strona', 'emailadres');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'save_custom_meta_box');