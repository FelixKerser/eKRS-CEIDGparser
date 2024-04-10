<?php
// Подключение Selenium WebDriver
require_once('vendor/autoload.php');
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\Exception\TimeOutException;
require_once('simple_html_dom.php');
set_time_limit(86400);
// Установка параметров
// $host = 'http://192.168.137.1:4444/'; 
// $capabilities = \Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
// $driver = RemoteWebDriver::create($host, $capabilities);
// $wait = new WebDriverWait($driver, 120);
?>
<style>
    .parser{
        position:absolute;
        opacity:0;
        top:0;
        pointer-events:none;
    }
</style>
<?
function stringToGUID($string) {
    // Вычисляем SHA-1 хеш строки
    $sha1 = sha1($string);

    // Форматируем SHA-1 хеш в GUID вид
    $guid = sprintf('%08s-%04s-%04x-%04x-%12s',
        // первая часть: хеш первых 8 символов
        substr($sha1, 0, 8),
        // вторая часть: хеш следующих 4 символов
        substr($sha1, 8, 4),
        // третья часть: генерируем случайное 16-битное число
        mt_rand(0, 0xffff),
        // четвертая часть: генерируем случайное 16-битное число
        mt_rand(0, 0xffff),
        // пятая часть: оставшиеся 12 символов хеша
        substr($sha1, 12, 12)
    );

    return $guid;
}

function parse($miasto, $gmina, $przedsiebiorca, $stowarzyszenia, $wojewodztwo){
    for ($i = 0; $i < 19; $i++) {
    $host = 'http://localhost:4444'; 
    $capabilities = \Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
    $driver = RemoteWebDriver::create($host, $capabilities);
    $wait = new WebDriverWait($driver, 120);
    $driver->get('https://ekrs.ms.gov.pl/krsrdf/krs/wyszukiwaniepodmiotu?');

    $jqueryScript = file_get_contents('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js');
    $driver->executeScript($jqueryScript);

    // sleep(3); 

    $wait->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::tagName('body')));


    if($miasto != ''){
        $driver->executeScript("document.getElementById('miejscowosc').setAttribute('value', '". $miasto ."');");
    }

    if($gmina != ''){
        $driver->executeScript("document.getElementById('gmina').setAttribute('value', '". $gmina ."');");
    }

    if($przedsiebiorca != ''){
        $driver->executeScript("document.getElementById('rejestrPrzedsiebiorcy').setAttribute('checked', true);");
    }

    if($stowarzyszenia != ''){
        $driver->executeScript("document.getElementById('rejestrStowarzyszenia').setAttribute('checked', true);");
    }

    if($wojewodztwo != ''){
        $driver->executeScript("document.getElementById('wojewodztwo').setAttribute('value', '". $wojewodztwo ."');");
    }

    // $driver->executeScript("document.getElementById('rejestrPrzedsiebiorcy').setAttribute('checked', true);");
    $driver->executeScript("document.getElementById('form').submit();");
    $driver->executeScript("document.getElementById('szukaj').click();");
    $temporarily = $i + 1;
    $driver->executeScript("document.querySelectorAll('.daneSzczegolowe a')[".$temporarily."].click();");
    $driver->executeScript("document.getElementsByClassName('big')[0].classList.add('nazwa');document.getElementsByClassName('big')[5].classList.add('nip');document.getElementsByClassName('big')[6].classList.add('miasto');document.getElementsByClassName('big')[7].classList.add('regon');document.getElementsByClassName('big')[10].classList.add('adresa');document.getElementsByClassName('big')[12].classList.add('pocztowykod');");
    // sleep(15); 
    // Получение HTML содержимого страницы
    $html = $driver->getPageSource();

    // Вывод HTML содержимого
    echo '<div class="parser">';
    echo "------------------";
    echo $html;
    echo "------------------";
    echo '</div>';


    // Закрытие браузера
    $driver->quit();

            // Создаем объект Simple HTML DOM
            $dom = str_get_html($html);

            if ($dom !== false) {
                $previous_values = array();
                $table = $dom->find('.danePodmiotu', 0);
                // Находим все элементы с классом "nazwa"
                // echo '<div class="wynik">';
                //     $nazwa = $table->find('.nazwa');
                //     $adresa = $table->find('.adresa');
                //     $kodpocztowy = $table->find('.pocztowykod');
                //     $nip = $table->find('.nip');
                //     $regon = $table->find('.regon');
                //     echo 'Nazwa: '.$nazwa->plaintext;
                //     echo 'Adresa: '.$adresa->plaintext;
                //     echo 'Kod Pocztowy: '.$kodpocztowy->plaintext;
                //     echo 'NIP: '.$nip->plaintext;
                //     echo 'REGON: '.$regon->plaintext;
                // echo '</div>';
                $_nazwa;
                $_miasto;
                $_adresa;
                $_pocztowykod;
                $_nip;
                $_regon;
                foreach($table->find('.nazwa') as $element) {
                    $nazwa_content = $element->plaintext;
                    // echo '<div class="wynik">';
                    // echo 'Nazwa firmy: '.$nazwa_content;
                    // echo '</div>';
                    $_nazwa = $nazwa_content;
                }
                foreach($table->find('.miasto') as $element) {
                    $nazwa_content = $element->plaintext;
                    // echo '<div class="wynik">';
                    // echo 'Miasto: '.$nazwa_content;
                    // echo '</div>';
                    $_miasto = $nazwa_content;
                }
                foreach($table->find('.adresa') as $element) {
                    $nazwa_content = $element->plaintext;
                    // echo '<div class="wynik">';
                    // echo 'Adresa: '.$nazwa_content;
                    // echo '</div>';
                    $_adresa = $nazwa_content;
                }
                foreach($table->find('.pocztowykod') as $element) {
                    $nazwa_content = $element->plaintext;
                    // echo '<div class="wynik">';
                    // echo 'Kod pocztowy: '.$nazwa_content;
                    // echo '</div>';
                    $_pocztowykod = $nazwa_content;
                }
                foreach($table->find('.nip') as $element) {
                    $nazwa_content = $element->plaintext;
                    // echo '<div class="wynik">';
                    // echo 'NIP: '.$nazwa_content;
                    // echo '</div>';
                    $_nip = $nazwa_content;
                }
                foreach($table->find('.regon') as $element) {
                    $nazwa_content = $element->plaintext;
                    // echo '<div class="wynik">';
                    // echo 'Regon: '.$nazwa_content;
                    // echo '</div>';
                    // echo '--------------';
                    $_regon = $nazwa_content;
                }

                                $table_posts = 'wp_' . 'posts';
                                $table_postmeta = 'wp_' . 'postmeta';

                                // Устанавливаем часовой пояс
                                date_default_timezone_set('UTC');

                                // Получаем текущую дату и время
                                $currentDateTime = date('Y-m-d H:i:s');

                                $sql_insert_post = sprintf("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '%s', '%s', '', '%s', '', 'publish', 'open', 'open', '', LAST_INSERT_ID(), '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', '', '0', '', '0', 'firmy', '', '0') ON DUPLICATE KEY UPDATE 
                                `post_author` = VALUES(`post_author`), 
                                `post_date` = VALUES(`post_date`), 
                                `post_date_gmt` = VALUES(`post_date_gmt`), 
                                `post_content` = VALUES(`post_content`), 
                                `post_excerpt` = VALUES(`post_excerpt`), 
                                `post_status` = VALUES(`post_status`), 
                                `comment_status` = VALUES(`comment_status`), 
                                `ping_status` = VALUES(`ping_status`), 
                                `post_password` = VALUES(`post_password`), 
                                `to_ping` = VALUES(`to_ping`), 
                                `pinged` = VALUES(`pinged`), 
                                `post_modified` = VALUES(`post_modified`), 
                                `post_modified_gmt` = VALUES(`post_modified_gmt`), 
                                `post_content_filtered` = VALUES(`post_content_filtered`), 
                                `post_parent` = VALUES(`post_parent`), 
                                `guid` = VALUES(`guid`), 
                                `menu_order` = VALUES(`menu_order`), 
                                `post_type` = VALUES(`post_type`), 
                                `post_mime_type` = VALUES(`post_mime_type`), 
                                `comment_count` = VALUES(`comment_count`);
                                UPDATE wp_posts
                                SET guid = CONCAT((SELECT option_value FROM wp_options WHERE option_name = 'siteurl'), 'firmy/?p=', LAST_INSERT_ID())
                                WHERE ID = LAST_INSERT_ID();
                                ", $currentDateTime, $currentDateTime, $_nazwa);

                                $sql_insert_meta = "
                                INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) 
                                VALUES 
                                    ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_miasto', '". $_miasto ."'),
                                    ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_adresa', '". $_adresa ."'),
                                    ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_kod_pocztowy', '". $_pocztowykod ."'),
                                    ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_nip', '". $_nip ."'),
                                    ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_regon', '". $_regon ."') ON DUPLICATE KEY UPDATE `post_id` = VALUES(`post_id`), `meta_key` = VALUES(`meta_key`), `meta_value` = VALUES(`meta_value`);";

                                echo $sql_insert_post;
                                echo '<br/>';
                                echo $sql_insert_meta;
                                echo '<br/>';


            }
        }
        if($_POST['strony'] != '1'){
        for ($i = 1; $i < intval($_POST['strony']); $i++) {
            $host = 'http://localhost:4444/'; 
            $capabilities = \Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
            // $driver = RemoteWebDriver::create($host, $capabilities);
            // $wait = new WebDriverWait($driver, 120);
            // $driver->get('https://ekrs.ms.gov.pl/krsrdf/krs/wyszukiwaniepodmiotu?');
        
        
        
            // $jqueryScript = file_get_contents('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js');
            // $driver->executeScript($jqueryScript);
        
        
            // $wait->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::tagName('body')));

            // if($miasto != ''){
            //     $driver->executeScript("document.getElementById('miejscowosc').setAttribute('value', '". $miasto ."');");
            // }
        
            // if($gmina != ''){
            //     $driver->executeScript("document.getElementById('gmina').setAttribute('value', '". $gmina ."');");
            // }
        
            // if($przedsiebiorca != ''){
            //     $driver->executeScript("document.getElementById('rejestrPrzedsiebiorcy').setAttribute('checked', true);");
            // }
        
            // if($stowarzyszenia != ''){
            //     $driver->executeScript("document.getElementById('rejestrStowarzyszenia').setAttribute('checked', true);");
            // }

            // if($wojewodztwo != ''){
            //     $driver->executeScript("document.getElementById('wojewodztwo').setAttribute('value', '". $wojewodztwo ."');");
            // }
        
            // // $driver->executeScript("document.getElementById('rejestrPrzedsiebiorcy').setAttribute('checked', true);");
            // $driver->executeScript("document.getElementById('form').submit();");
            // $driver->executeScript("document.getElementById('szukaj').click();");
            
            for ($d = 0; $d < 19; $d++){
                $dad = RemoteWebDriver::create($host, $capabilities);
                $wait = new WebDriverWait($dad, 120);
                $dad->get('https://ekrs.ms.gov.pl/krsrdf/krs/wyszukiwaniepodmiotu?');

                $jqueryScript = file_get_contents('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js');
                $dad->executeScript($jqueryScript);
            
            
                $wait->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::tagName('body')));
    
                if($miasto != ''){
                    $dad->executeScript("document.getElementById('miejscowosc').setAttribute('value', '". $miasto ."');");
                }
            
                if($gmina != ''){
                    $dad->executeScript("document.getElementById('gmina').setAttribute('value', '". $gmina ."');");
                }
            
                if($przedsiebiorca != ''){
                    $dad->executeScript("document.getElementById('rejestrPrzedsiebiorcy').setAttribute('checked', true);");
                }
            
                if($stowarzyszenia != ''){
                    $dad->executeScript("document.getElementById('rejestrStowarzyszenia').setAttribute('checked', true);");
                }
    
                if($wojewodztwo != ''){
                    $dad->executeScript("document.getElementById('wojewodztwo').setAttribute('value', '". $wojewodztwo ."');");
                }
            
                // $driver->executeScript("document.getElementById('rejestrPrzedsiebiorcy').setAttribute('checked', true);");
                $dad->executeScript("document.getElementById('form').submit();");
                $dad->executeScript("document.getElementById('szukaj').click();");
            
                for ($j = 0; $j < $i; $j++) {
                    $dad->executeScript("document.getElementsByClassName('buttonPager')[2].click();");
                    try {
                        $wait = new WebDriverWait($dad, 15);
                        // Ожидаем появления элемента с id 'new-blockus' в течение 5 секунд
                        $newDataElement = $wait->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('new-blockus')));
                    } catch (TimeOutException $e) {
                        // Если время ожидания истекло, продолжаем выполнение без ошибки
                        // $html = $driver->getPageSource();
                    
                        // $newDataElement = $driver->findElement(WebDriverBy::id('form'));
                        // $html = $newDataElement->getAttribute('innerHTML');
                        // echo '<div class="parser">';
                        // echo $html;
                        // echo '</div>';
                    }
                }

                $temporarily = $d + 1;
                $dad->executeScript("document.querySelectorAll('.daneSzczegolowe a')[".$temporarily."].click();");
                $dad->executeScript("document.getElementsByClassName('big')[0].classList.add('nazwa');document.getElementsByClassName('big')[5].classList.add('nip');document.getElementsByClassName('big')[6].classList.add('miasto');document.getElementsByClassName('big')[7].classList.add('regon');document.getElementsByClassName('big')[10].classList.add('adresa');document.getElementsByClassName('big')[12].classList.add('pocztowykod');");
                $htmlnew = $dad->getPageSource();
                echo '<div class="parser">';
                echo $htmlnew;
                echo '</div>';

                $domnew = str_get_html($htmlnew);

                if ($domnew !== false) {
                    $previous_values = array();
                    $table = $domnew->find('.danePodmiotu', 0);
                    // Находим все элементы с классом "nazwa"
                    // echo '<div class="wynik">';
                    //     $nazwa = $table->find('.nazwa');
                    //     $adresa = $table->find('.adresa');
                    //     $kodpocztowy = $table->find('.pocztowykod');
                    //     $nip = $table->find('.nip');
                    //     $regon = $table->find('.regon');
                    //     echo 'Nazwa: '.$nazwa->plaintext;
                    //     echo 'Adresa: '.$adresa->plaintext;
                    //     echo 'Kod Pocztowy: '.$kodpocztowy->plaintext;
                    //     echo 'NIP: '.$nip->plaintext;
                    //     echo 'REGON: '.$regon->plaintext;
                    // echo '</div>';
                    $_nazwa;
                    $_miasto;
                    $_adresa;
                    $_pocztowykod;
                    $_nip;
                    $_regon;
                    foreach($table->find('.nazwa') as $element) {
                        $nazwa_content = $element->plaintext;
                        // echo '<div class="wynik">';
                        // echo 'Nazwa firmy: '.$nazwa_content;
                        // echo '</div>';
                        $_nazwa = $nazwa_content;
                    }
                    foreach($table->find('.miasto') as $element) {
                        $nazwa_content = $element->plaintext;
                        // echo '<div class="wynik">';
                        // echo 'Miasto: '.$nazwa_content;
                        // echo '</div>';
                        $_miasto = $nazwa_content;
                    }
                    foreach($table->find('.adresa') as $element) {
                        $nazwa_content = $element->plaintext;
                        // echo '<div class="wynik">';
                        // echo 'Adresa: '.$nazwa_content;
                        // echo '</div>';
                        $_adresa = $nazwa_content;
                    }
                    foreach($table->find('.pocztowykod') as $element) {
                        $nazwa_content = $element->plaintext;
                        // echo '<div class="wynik">';
                        // echo 'Kod pocztowy: '.$nazwa_content;
                        // echo '</div>';
                        $_pocztowykod = $nazwa_content;
                    }
                    foreach($table->find('.nip') as $element) {
                        $nazwa_content = $element->plaintext;
                        // echo '<div class="wynik">';
                        // echo 'NIP: '.$nazwa_content;
                        // echo '</div>';
                        $_nip = $nazwa_content;
                    }
                    foreach($table->find('.regon') as $element) {
                        $nazwa_content = $element->plaintext;
                        // echo '<div class="wynik">';
                        // echo 'Regon: '.$nazwa_content;
                        // echo '</div>';
                        // echo '--------------';
                        $_regon = $nazwa_content;
                    }
    
                                    $table_posts = 'wp_' . 'posts';
                                    $table_postmeta = 'wp_' . 'postmeta';
    
                                    // Устанавливаем часовой пояс
                                    date_default_timezone_set('UTC');
    
                                    // Получаем текущую дату и время
                                    $currentDateTime = date('Y-m-d H:i:s');
    
                                    $sql_insert_post = sprintf("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '%s', '%s', '', '%s', '', 'publish', 'open', 'open', '', LAST_INSERT_ID(), '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', '', '0', '', '0', 'firmy', '', '0') ON DUPLICATE KEY UPDATE 
                                    `post_author` = VALUES(`post_author`), 
                                    `post_date` = VALUES(`post_date`), 
                                    `post_date_gmt` = VALUES(`post_date_gmt`), 
                                    `post_content` = VALUES(`post_content`), 
                                    `post_excerpt` = VALUES(`post_excerpt`), 
                                    `post_status` = VALUES(`post_status`), 
                                    `comment_status` = VALUES(`comment_status`), 
                                    `ping_status` = VALUES(`ping_status`), 
                                    `post_password` = VALUES(`post_password`), 
                                    `to_ping` = VALUES(`to_ping`), 
                                    `pinged` = VALUES(`pinged`), 
                                    `post_modified` = VALUES(`post_modified`), 
                                    `post_modified_gmt` = VALUES(`post_modified_gmt`), 
                                    `post_content_filtered` = VALUES(`post_content_filtered`), 
                                    `post_parent` = VALUES(`post_parent`), 
                                    `guid` = VALUES(`guid`), 
                                    `menu_order` = VALUES(`menu_order`), 
                                    `post_type` = VALUES(`post_type`), 
                                    `post_mime_type` = VALUES(`post_mime_type`), 
                                    `comment_count` = VALUES(`comment_count`);
                                    UPDATE wp_posts
                                    SET guid = CONCAT((SELECT option_value FROM wp_options WHERE option_name = 'siteurl'), 'firmy/?p=', LAST_INSERT_ID())
                                    WHERE ID = LAST_INSERT_ID();
                                    ", $currentDateTime, $currentDateTime, $_nazwa);
    
                                    $sql_insert_meta = "
                                    INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) 
                                    VALUES 
                                        ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_miasto', '". $_miasto ."'),
                                        ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_adresa', '". $_adresa ."'),
                                        ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_kod_pocztowy', '". $_pocztowykod ."'),
                                        ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_nip', '". $_nip ."'),
                                        ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_regon', '". $_regon ."') ON DUPLICATE KEY UPDATE `post_id` = VALUES(`post_id`), `meta_key` = VALUES(`meta_key`), `meta_value` = VALUES(`meta_value`);";
    
                                    echo $sql_insert_post;
                                    echo '<br/>';
                                    echo $sql_insert_meta;
                                    echo '<br/>';
    
    
                        }
                        $dad->quit();
            }
            

            // $htmlnew = $driver->getPageSource();
            // echo '<div class="parser">';
            // echo $htmlnew;
            // echo '</div>';


            // $driver->quit();

            // for ($i = 0; $i < 19; $i++) {
            //     $temporarily = $i + 1;
            //     $driver->executeScript("document.querySelectorAll('.daneSzczegolowe a')[".$temporarily."].click();");
            //     $driver->executeScript("document.getElementsByClassName('big')[0].classList.add('nazwa');document.getElementsByClassName('big')[5].classList.add('nip');document.getElementsByClassName('big')[6].classList.add('miasto');document.getElementsByClassName('big')[7].classList.add('regon');document.getElementsByClassName('big')[10].classList.add('adresa');document.getElementsByClassName('big')[12].classList.add('pocztowykod');");
            //     $html = $driver->getPageSource();
            //     // Вывод HTML содержимого
            //     echo '<div class="parser">';
            //     echo "------------------";
            //     echo $htmlnew;
            //     echo "------------------";
            //     echo '</div>';
            //     $domnew = str_get_html($htmlnew);
            //     if ($domnew !== false) {
            //         $previous_values = array();
            //         $table = $domnew->find('.danePodmiotu', 0);
            //         // Находим все элементы с классом "nazwa"
            //         // echo '<div class="wynik">';
            //         //     $nazwa = $table->find('.nazwa');
            //         //     $adresa = $table->find('.adresa');
            //         //     $kodpocztowy = $table->find('.pocztowykod');
            //         //     $nip = $table->find('.nip');
            //         //     $regon = $table->find('.regon');
            //         //     echo 'Nazwa: '.$nazwa->plaintext;
            //         //     echo 'Adresa: '.$adresa->plaintext;
            //         //     echo 'Kod Pocztowy: '.$kodpocztowy->plaintext;
            //         //     echo 'NIP: '.$nip->plaintext;
            //         //     echo 'REGON: '.$regon->plaintext;
            //         // echo '</div>';
            //         $_nazwa;
            //         $_miasto;
            //         $_adresa;
            //         $_pocztowykod;
            //         $_nip;
            //         $_regon;
            //         foreach($table->find('.nazwa') as $element) {
            //             $nazwa_content = $element->plaintext;
            //             // echo '<div class="wynik">';
            //             // echo 'Nazwa firmy: '.$nazwa_content;
            //             // echo '</div>';
            //             $_nazwa = $nazwa_content;
            //         }
            //         foreach($table->find('.miasto') as $element) {
            //             $nazwa_content = $element->plaintext;
            //             // echo '<div class="wynik">';
            //             // echo 'Miasto: '.$nazwa_content;
            //             // echo '</div>';
            //             $_miasto = $nazwa_content;
            //         }
            //         foreach($table->find('.adresa') as $element) {
            //             $nazwa_content = $element->plaintext;
            //             // echo '<div class="wynik">';
            //             // echo 'Adresa: '.$nazwa_content;
            //             // echo '</div>';
            //             $_adresa = $nazwa_content;
            //         }
            //         foreach($table->find('.pocztowykod') as $element) {
            //             $nazwa_content = $element->plaintext;
            //             // echo '<div class="wynik">';
            //             // echo 'Kod pocztowy: '.$nazwa_content;
            //             // echo '</div>';
            //             $_pocztowykod = $nazwa_content;
            //         }
            //         foreach($table->find('.nip') as $element) {
            //             $nazwa_content = $element->plaintext;
            //             // echo '<div class="wynik">';
            //             // echo 'NIP: '.$nazwa_content;
            //             // echo '</div>';
            //             $_nip = $nazwa_content;
            //         }
            //         foreach($table->find('.regon') as $element) {
            //             $nazwa_content = $element->plaintext;
            //             // echo '<div class="wynik">';
            //             // echo 'Regon: '.$nazwa_content;
            //             // echo '</div>';
            //             // echo '--------------';
            //             $_regon = $nazwa_content;
            //         }
    
            //                         $table_posts = 'wp_' . 'posts';
            //                         $table_postmeta = 'wp_' . 'postmeta';
    
            //                         // Устанавливаем часовой пояс
            //                         date_default_timezone_set('UTC');
    
            //                         // Получаем текущую дату и время
            //                         $currentDateTime = date('Y-m-d H:i:s');
    
            //                         $sql_insert_post = sprintf("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '%s', '%s', '', '%s', '', 'publish', 'open', 'open', LAST_INSERT_ID(), '', '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', '', '0', '', '0', 'firmy', '', '0') ON DUPLICATE KEY UPDATE 
            //                         `post_author` = VALUES(`post_author`), 
            //                         `post_date` = VALUES(`post_date`), 
            //                         `post_date_gmt` = VALUES(`post_date_gmt`), 
            //                         `post_content` = VALUES(`post_content`), 
            //                         `post_excerpt` = VALUES(`post_excerpt`), 
            //                         `post_status` = VALUES(`post_status`), 
            //                         `comment_status` = VALUES(`comment_status`), 
            //                         `ping_status` = VALUES(`ping_status`), 
            //                         `post_password` = VALUES(`post_password`), 
            //                         `to_ping` = VALUES(`to_ping`), 
            //                         `pinged` = VALUES(`pinged`), 
            //                         `post_modified` = VALUES(`post_modified`), 
            //                         `post_modified_gmt` = VALUES(`post_modified_gmt`), 
            //                         `post_content_filtered` = VALUES(`post_content_filtered`), 
            //                         `post_parent` = VALUES(`post_parent`), 
            //                         `guid` = VALUES(`guid`), 
            //                         `menu_order` = VALUES(`menu_order`), 
            //                         `post_type` = VALUES(`post_type`), 
            //                         `post_mime_type` = VALUES(`post_mime_type`), 
            //                         `comment_count` = VALUES(`comment_count`);
            //                         UPDATE wp_posts
            //                         SET guid = CONCAT((SELECT option_value FROM wp_options WHERE option_name = 'siteurl'), 'firmy/?p=', LAST_INSERT_ID())
            //                         WHERE ID = LAST_INSERT_ID();
            //                         ", $currentDateTime, $currentDateTime, $_nazwa);
    
            //                         $sql_insert_meta = "
            //                         INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) 
            //                         VALUES 
            //                             ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_miasto', '". $_miasto ."'),
            //                             ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_adresa', '". $_adresa ."'),
            //                             ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_kod_pocztowy', '". $_pocztowykod ."'),
            //                             ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_nip', '". $_nip ."'),
            //                             ((SELECT `ID` FROM `wp_posts` WHERE `post_title` = '". $_nazwa ."'), '_regon', '". $_regon ."') ON DUPLICATE KEY UPDATE `post_id` = VALUES(`post_id`), `meta_key` = VALUES(`meta_key`), `meta_value` = VALUES(`meta_value`);";
    
            //                         echo $sql_insert_post;
            //                         echo '<br/>';
            //                         echo $sql_insert_meta;
            //                         echo '<br/>';
    
    
            //             }
            //         // $driver->navigate()->back();
            //     }

            }
        }

        // echo '<div class="parser">';
        // echo $html;
        // echo '</div>';

}

if($_POST['miasto'] != ''){
    $miasta = explode(", ", $_POST['miasto']);
} else {
    $miasta = '';
}

if($_POST['gmina'] != ''){
    $gminy = explode(", ", $_POST['gmina']);
} else {
    $gminy = '';
}

if($_POST['wojewodztwo'] != ''){
    $wojewodztwa = explode(", ", $_POST['wojewodztwo']);
} else {
    $wojewodztwa = '';
}

if($miasta != ''){
    foreach ($miasta as $miasto) {
        parse($miasto, '', $_POST['rejestrPrzedsiebiorcy'], $_POST['rejestrStowarzyszenia'], '');
    }
}

if($gminy != ''){
    foreach ($gminy as $gmina) {
        parse('', $gmina, $_POST['rejestrPrzedsiebiorcy'], $_POST['rejestrStowarzyszenia'], '');
    }
}

if($wojewodztwa != ''){
    foreach ($wojewodztwa as $wojewodztwo) {
        parse('', '', $_POST['rejestrPrzedsiebiorcy'], $_POST['rejestrStowarzyszenia'], $wojewodztwo);
    }
}