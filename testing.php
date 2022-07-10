<?php
//echo phpinfo();

//1 шаг получить блок который нужно нарастить 

// $img = imagecreatefromjpeg('assets/promo/bd/red_girl_test.jpg');//получаем изображение
// $size = imagesx($img);//ширина картинки
// $image=imagecreatetruecolor($size, 70);
// // создадим белый фон с чёрной рамкой
// $back = imagecolorallocate($image, 255, 255, 255);
// imagefilledrectangle($image, 0, 0, $size - 1, $size - 1, $back);
// //var_dump($image);
// // // не забудьте вывести правильный заголовок!
//  header('Content-Type: image/png');
// imagepng($image);
// imagedestroy($image);
        

//2 шаг соединить картинку наращивания с иходной картинкой
// function merge($filename_x, $filename_y, $filename_result) {

//     // Get dimensions for specified images
   
//     list($width_x, $height_x) = getimagesize($filename_x);
//     list($width_y, $height_y) = getimagesize($filename_y);
   
//     // Create new image with desired dimensions
   
//     $image = imagecreatetruecolor($width_x + $width_y, $height_x);
   
//     // Load images and then copy to destination image
   
//     $image_x = imagecreatefromjpeg($filename_x);
//     $image_y = imagecreatefromgif($filename_y);
   
//     imagecopy($image, $image_x, 0, 0, 0, 0, $width_x, $height_x);
//     imagecopy($image, $image_y, $width_x, 0, 0, 0, $width_y, $height_y);
   
//     // Save the resulting image to disk (as JPEG)
   
//     imagejpeg($image, $filename_result);
   
//     // Clean up
   
//     imagedestroy($image);
//     imagedestroy($image_x);
//     imagedestroy($image_y);
   
//    }
//    merge('assets/promo/bd/red_girl_test.jpg', 'assets/promo/bd/white_block.jpg', 'assets/promo/bd/merge.jpg');














//3 шаг наложение телеграм или ватсап со второго шага
    //$src = imagecreatefromjpeg('assets/promo/bd/Whatsapp_1.jpg');
    $src = imagecreatefromjpeg('assets/promo/bd/Telegram_1.jpg');

    $main_img = imagecreatefromjpeg('assets/promo/bd/width_block/merge_football.jpg');

    $w_src = imagesx($src);//размеры большой картинки
    $h_src = imagesy($src);

    $w_dest = imagesx($main_img);//размеры большой картинки
    $h_dest = imagesy($main_img);

    $transfer_x = ($w_dest/2) - 100; //положение маленькой картинки на главной картинки 
    $transfer_y = $h_dest-50;
    
    imagecopyresampled($main_img, $src, $transfer_x, $transfer_y, 0, 0, $w_src, $h_src, $w_src, $h_src);


 header('Content-Type: image/jpeg');
 imagedestroy($src);
imagejpeg($main_img, null, 100);
imagedestroy($main_img);


