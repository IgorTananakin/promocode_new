<?php
// error_reporting(E_ALL);
// ini_set('error_log', __DIR__ . '/log.txt');
// error_log('Запись в лог', 0);
// определяем кодировку
header('Content-type: text/html; charset=utf-8');
// Создаем объект бота
$bot = new Bot();
// Обрабатываем пришедшие данные test
$bot->init('php://input');

/**
 * Class Bot
 */
class Bot
{
    // <bot_token> - созданный токен для нашего бота от @BotFather
    private $botToken = "1459202654:AAH644YzCZo9wQ27L7RvHiUpwRzsXQkELh4";
    // адрес для запросов к API Telegram
    private $apiUrl = "https://api.telegram.org/bot";
    // url sites
    private $url_sites = 'https://promobot.jsonb.ru/';
    // админы
    private $ADMIN = [5574121203, 5453854424, 5391936892, 659025951, 122815990, 169024420, 802243803, 569032193, 196620115, 1440214573, 483595318, 1660455309, 1862633986, 1872329574, 1927819764, 1656594297, 2034540659, 2137518532, 1295698464, 5081659868, 882013448, 1928875918, 5217432820, 732595243, 5423441684, 5343624925];

    private $sportEmodjiArray = [0 => '', '⚽', '🏒', '🏀', '🎾', '', '🏐', '🏉', 40 => '🕹'];
    private $arrayDate = [
        'day' => [],
        'month' => []
    ];
    private $arrayMonths = [
        'ru' => [
            1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'
        ],
        'uz' => [
            1 => 'Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun', 'Iyul', 'Avgust', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr'
        ],
        'en' => [
            1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ]
    ];
    private $arrayNumber = ['1️⃣', '2️⃣', '3️⃣', '4️⃣', '5️⃣', '6️⃣', '7️⃣', '8️⃣', '9️⃣', '🔟'];
    private $textLangArray = [
        'ru' => [
            'express' => 'Экспресс дня',
            'bonus' => 'Бонус от Linebet',
            'totalKef' => 'Итоговый коэффициент',
            'event' => 'Событие',
            'coefficient' => 'Коэффициент',
            'viewEvent' => 'Просмотреть событие'
        ],
        'uz' => [
            'express' => 'Kun ekspressi',
            'bonus' => 'LINEBET dan bonus',
            'totalKef' => 'Yakuniy Koeffitsiyent',
            'event' => 'Xodisa',
            'coefficient' => 'Koeffitsiyent',
            'viewEvent' => 'Hodisaga utish'
        ],
        'en' => [
            'express' => 'Express of the day',
            'bonus' => 'Bonus from Linebet',
            'totalKef' => 'Final coefficient',
            'event' => 'Event',
            'coefficient' => 'Coefficient',
            'viewEvent' => 'View event'
        ]
    ];

    public function init($data_php)
    {
        // создаем массив из пришедших данных от API Telegram
        $data = $this->getData($data_php);
        // id чата отправителя
        $chat_id = $data['message']['chat']['id'];
        //включаем логирование будет лежать рядом с этим файлом
        //$this->setFileLog($data, "log.txt");

        // стартовая кнопка
        // $justKeyboard = $this->getKeyBoard([
        //     [
        //         ["text" => "UZB 🇺🇿"],
        //         ["text" => "RUS 🇷🇺"],
        //         ["text" => "ENG 🇬🇧"],

        //         //        [ "text" => "Ещё" ],
        //     ],
        //     [
        //         ["text" => "BD 🇧🇩"],
        //         ["text" => "MN 🇲🇳"],
        //         ["text" => "FR 🇫🇷"],
        //     ],
        //     [
        //         ["text" => "SW 🇰🇪"],
        //         ["text" => "PK 🇩🇿"],
        //         ["text" => "IN 🇮🇳"]
        //     ]
        // ]);
        $justKeyboard = $this->getKeyBoard([
            [
                ["text" => "UZB 🇺🇿"],
                ["text" => "RUS 🇷🇺"],
                ["text" => "ENG 🇬🇧"],
                ["text" => "BD 🇧🇩"],
                ["text" => "MN 🇲🇳"],

                //        [ "text" => "Ещё" ],
            ],
            
            [
                ["text" => "FR 🇫🇷"],
                ["text" => "SW 🇰🇪"],
                ["text" => "PK 🇩🇿"],
                ["text" => "SO 🇸🇴"],
                ["text" => "IN 🇮🇳"]
            ]
        ]);
        $buttons_time = $this->getKeyBoard([
            [
                ["text" => "Старое промо"],
                ["text" => "Новое промо"],
                ['text' => 'Экспресс дня']
            ],
            [
                ["text" => "Отмена"]
            ]
        ]);
        $buttons_time2 = $this->getKeyBoard([
            [
                ["text" => "Старое промо"],
                ["text" => "Новое промо"],
                ["text" => "Новое промо2"],
            ],
            [
                ["text" => "Отмена"]
            ]
        ]);
        $buttons_time3 = $this->getKeyBoard([
            [
                ["text" => "Картинки"],
                ["text" => "Видео"],

            ],
            [
                ["text" => "Отмена"]
            ]
        ]);
        $buttons_time4 = $this->getKeyBoard([
            [
                ["text" => "Ватсап"],
                ["text" => "Телеграм"],
                ["text" => "Старое промо BD"],
            ], [
                ["text" => "Новое промо"],
                ["text" => "Новое промо2"],
                ["text" => "football_kriket"],
            ],
            [
                ["text" => "Отмена"]
            ]
        ]);
        // $buttons_time5 = $this->getKeyBoard([
        //     [
        //         ["text" => "Старое промо"],
        //         ["text" => "Новое промо"],
        //         ["text" => "Новое промо2"],
        //         ["text" => "football_kriket"],
        //     ],
        //     [
        //         ["text" => "Отмена"]
        //     ]
        // ]);
        // $buttons_time4 = $this->getKeyBoard([
        //     [
        //         ["text" => "Ватсап"],
        //         ["text" => "Телеграм"],

        //     ],
        //     [
        //         ["text" => "Отмена"]
        //     ]
        // ]);
        // Кнопка отмены
        $otmena = $this->getKeyBoard([
            [
                ["text" => "Отмена"]
            ]
        ]);
        $express = $this->getKeyBoard([
            [
                ["text" => "Экспресс дня"]
            ],
            [
                ["text" => "Отмена"]
            ]
        ]);
        $ehe = $this->getKeyBoard([
            [
                ["text" => "big"],
                ["text" => "line"],
                ["text" => "cray"],
                ["text" => "1x"],
            ],
            [
                ["text" => "Отмена"]
            ]
        ]);


        if (array_key_exists('message', $data)) {
            // пришла команда /start
            if ($data['message']['text'] == "/start") {
                //  проверка на существование файла
                if ($this->fwd($chat_id) == false) {
                    $this->fwclose($chat_id);
                }
                //  проверка на существование файла у такого пользователя если не существует создаём
                if ($this->fwd2($chat_id) == false) {
                    $this->fwclose2($chat_id);
                }
                //  проверка на существование файла у такого пользователя если не существует создаём
                if ($this->fwd3($chat_id) == false) {
                    $this->fwclose3($chat_id);
                }

                // проверка на админа
                $textAd = $this->isAdmin($chat_id);
                if ($textAd == "Привет админ") {

                    $dataSend = array(
                        'text' => "Приветствую Админ, выберите действие.",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");
                } else {
                    $this->sendMessage($chat_id, $textAd);
                }
            }
        }

        $textAd = $this->isAdmin($chat_id);
        if ($textAd == "Привет админ") {
            $message = $data['message']['text'];

            if (!file_exists("img/$chat_id/")) {
                mkdir("img/$chat_id/", 0700);
            }

            $file = file_get_contents("file/$chat_id.txt");
            $file1 = file_get_contents("file/phone$chat_id.txt");
            if (!empty($file1)) {
                //Создаём картинку


                $this->fwclose2($chat_id);
                header('Content-Type: image/jpeg');
                $text = $message;
                $text = mb_strtoupper($text);
                $time = time();

                if ($file1 == "BD_промо") {
                    $dataSend = array(
                        'text' => "готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    $file_number = file_get_contents("file/number$chat_id.txt");

                    //mrg_team_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_team_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 375.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 1.902, 1.255, 430.82334384858, 1, 1, 1);
                    //mrg_car_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_car_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 375.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.15, 448.96053946054, 1, 1, 1);
                    //mrg_football_tg
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_football_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.055, 194.14185814186, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.62, 289.14185814186, 1, 1, 1);
                    //mrg_girl_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_girl_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 375.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 1.942, 1.50, 455.62770339856, 1, 1, 1);
                    //mrg_green_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_green_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 380.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 3.842, 1.40, 165.60359187923, 1, 1, 1);
                    //mrg_messi_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_messi_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 380.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.30, 440.15346534653, 1, 1, 1);
                    //mrg_money_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_money_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 380.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 1.68, 1.38, 548.35714285714, 255, 255, 255);
                    //mrg_neimar_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_neimar_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 346.48951048951, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.08, 1.25, 415.34615384615, 255, 255, 255);
                    //mrg_red_girl_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_red_girl_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.065, 215.62037962038, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.32, 1.36, 248.08620689655, 1, 1, 1);
                    //mrg_ronald_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_ronald_wt.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 377.45854145854, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 60, 2.92, 1.25, 0, 1, 1, 1);

                    $this->fwclose3($chat_id);
                }
                if ($file1 == "BD_промо_tg") {
                    $dataSend = array(
                        'text' => "готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    $file_number = file_get_contents("file/number$chat_id.txt");

                    //mrg_team_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_team_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 375.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 1.902, 1.255, 430.82334384858, 1, 1, 1);
                    //mrg_car_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_car_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 375.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.15, 448.96053946054, 1, 1, 1);
                    //mrg_football_tg
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_football_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.055, 194.14185814186, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.62, 289.14185814186, 1, 1, 1);
                    //mrg_girl_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_girl_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 375.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 1.942, 1.50, 455.62770339856, 1, 1, 1);
                    //mrg_green_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_green_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 380.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 3.842, 1.40, 165.60359187923, 1, 1, 1);
                    //mrg_messi_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_messi_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 380.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.30, 440.15346534653, 1, 1, 1);
                    //mrg_money_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_money_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 380.46053946054, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 1.68, 1.38, 548.35714285714, 255, 255, 255);
                    //mrg_neimar_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_neimar_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 346.48951048951, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.08, 1.25, 415.34615384615, 255, 255, 255);
                    //mrg_red_girl_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_red_girl_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.065, 215.62037962038, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.32, 1.36, 248.08620689655, 1, 1, 1);
                    //mrg_ronald_wt
                    $this->textToImageSend($chat_id, $this->textToImageSend1($chat_id, 'assets/promo/bd/width_block/mrg_ronald_tg.jpg', $file_number, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.035, 377.45854145854, 1, 1, 1), $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 60, 2.92, 1.25, 0, 1, 1, 1);

                    $this->fwclose3($chat_id);
                }
                if ($message == "Отмена") {
                    $dataSend = array(
                        'text' => "Отмена действий",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");
                    $this->fwclose($chat_id);
                }
            }
            if (
                !empty($file)  && $message != "UZB 🇺🇿" && $message != "RUS 🇷🇺" && $message != "IN 🇮🇳"
                && $message != "SW 🇰🇪" && $message != "PK 🇩🇿" && $message != "MN 🇲🇳"
                && $message != "ENG 🇬🇧" && $message != "BD 🇧🇩" && $message != "SO 🇸🇴" && $message != "Старое промо"
                && $message != "Новое промо" && $message != "Новое промо2"
                && $message != "football_kriket" && $message != "Отмена"
                && $message != "FR 🇫🇷" && $message != "Картинки" && $message != "Ватсап" && $message != "промо"
                && $message != "Телеграм"

                //&& $message != "Телеграм" 
                && $message != "Видео" && $message != "/infobot" && $message != "Ещё"
                && $file != "<" && $message != "/start" && $message != "/stop" && $message != "Экспресс дня"
            ) {

                $this->fwclose($chat_id);
                $this->fwclose3($chat_id);
                //Создаём картинку
                header('Content-Type: image/jpeg');
                $text = $message;
                $text = mb_strtoupper($text);
                $time = time();


                if ($file == "UZB новое") {

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");


                    header('Content-type: text/html; charset=utf-8');

                    // afro_video
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/afro_video.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        986,
                        [
                            ['maxLen' => 18, 'x' => 9.75, 'y' => 425, 'size' => 13],
                            ['maxLen' => 10, 'x' => 16.5, 'y' => 420, 'size' => 22],
                            ['maxLen' => 6, 'x' => 30, 'y' => 415, 'size' => 40]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                }
                if ($file == "UZB старое") {

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");
                    // $this->sendMessage( $chat_id, $text );



                    //box_uzb
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/box_uzb.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 1.175, 1.14, 809.05319148936, 255, 255, 255);
                    //eat
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/eat.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 5.042, 1.295, 304.30126933756, 255, 255, 255);
                    //linebet_uzb_box
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/linebet_uzb_box.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 1.282, 11.130, 715.55382215289, 255, 255, 255);
                    //team_ronald
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/team_ronald.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 4.512, 1.100, 95.86170212766, 255, 255, 255);
                    //mbape_team
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/mbape_team.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 5.152, 3.400, 66.127329192547, 255, 255, 255);
                    //messi_team
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/messi_team.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.052, 1.110, 366.31578947368, 255, 255, 255);
                    //kazinoga_team
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/kazinoga_team.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.052, 1.230, 345.31578947368, 255, 255, 255);
                    //kazinogaz_team
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/kazinogaz_team.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.052, 1.230, 345.31578947368, 255, 255, 255);
                    //eldor
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/eldor.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 1.302, 1.330, 680.4930875576, 255, 255, 255);
                    //yellow_car
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/yellow_car.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 2.002, 3.330, 390.46053946054, 255, 255, 255);
                    //xabib
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/xabib.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.012, 1.080, 397.77932405567, 255, 255, 255);
                    //linebet_gold_28
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/linebet_gold_28.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.012, 1.605, 258.76739562624, 255, 255, 255);
                    //bike
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/bike.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.005, 1.325, 416.15336658354, 255, 255, 255);
                    //women_in_white
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/women_in_white.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 4.705, 1.175, 53.043039319872, 0, 0, 0);
                    //cabriolet
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/cabriolet.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 85, 7.205, 2.075, 125.11901457321, 0, 0, 0);
                    //flower_girl
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/flower_girl.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.005, 1.255, 382.65336658354, 255, 255, 255);
                    //disco_girl
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/disco_girl.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 125, 2.005, 1.109, 850.40773067332, 255, 255, 255);





                    //girl
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/girl.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 30, 'y' => 950, 'size' => 36],
                            ['maxLen' => 10, 'x' => 40, 'y' => 950, 'size' => 40],
                            ['maxLen' => 6, 'x' => 50, 'y' => 950, 'size' => 46]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );

                    //gif_new
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/gif_new.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        850,
                        [
                            ['maxLen' => 17, 'x' => 35, 'y' => 550, 'size' => 50],
                            ['maxLen' => 13, 'x' => 30, 'y' => 550, 'size' => 55],
                            ['maxLen' => 10, 'x' => 25, 'y' => 550, 'size' => 60]
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    //line_aviator_green
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/line_aviator_green.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        986,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 770, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 770, 'size' => 38],
                            ['maxLen' => 6, 'x' => 10, 'y' => 770, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    // gif1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/gif1.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        720,
                        [
                            ['maxLen' => 16, 'x' => 4.8125, 'y' => 710, 'size' => 35],
                            ['maxLen' => 10, 'x' => 8.25, 'y' => 700, 'size' => 60],
                            ['maxLen' => 5, 'x' => 11, 'y' => 700, 'size' => 80]
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );

                    //super_car
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/super_car.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        580,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 65, 'size' => 20],
                            ['maxLen' => 10, 'x' => 20, 'y' => 65, 'size' => 25],
                            ['maxLen' => 6, 'x' => 35, 'y' => 65, 'size' => 46]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y',
                        ':enable=between(t\,2.5\,16.9)'
                    );

                    // linenewspromo_1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/linenewspromo_1.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1090,
                        [
                            ['maxLen' => 25, 'x' => 20, 'y' => 1105, 'size' => 37]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y',
                        ':enable=between(t\,9.2\,16)'
                    );

                    $abzac = "Kim LINEBET bilan birga - Katta yutuqlarga EGA !!!

                    Promokod Degan joyiga   <b> " . $text . " </b>  deb yozib Registrasiya qiling  va
                    BIRINCHI depozitingiz va har DUSHANBA KUNI qilingan depozitga 200 % bonusni qo'lga kiriting!

                                        IOS -larga APP store-dan mobile dastur yuklasangiz bo'ladi
                    📲 Androilda  uchun, Mobil dastur bu yerda👇";



                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "RUS") {

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    //linebet_rus_box
                    $this->textToImageSend($chat_id, 'assets/promo/rus/linebet_rus_box.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 1.282, 11.130, 715.55382215289, 255, 255, 255);
                    // instruction
                    $this->textToImageSend($chat_id, 'assets/promo/rus/instruction.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.20, 1.05, 749.33333333333, 0, 0, 0);
                    // tachka_bud
                    $this->textToImageSend($chat_id, 'assets/promo/rus/tachka_bud.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.17, 433.63366336634, 255, 255, 255);
                    // karta21
                    $this->textToImageSend($chat_id, 'assets/promo/rus/karta21.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.17, 433.63366336634, 255, 255, 255);
                    // merelen
                    $this->textToImageSend($chat_id, 'assets/promo/rus/merelen.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.17, 433.63366336634, 255, 255, 255);
                    // casino_3
                    $this->textToImageSend($chat_id, 'assets/promo/rus/casino_3.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.17, 433.63366336634, 255, 255, 255);
                    // chiil
                    $this->textToImageSend($chat_id, 'assets/promo/rus/chiil.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.17, 433.63366336634, 255, 255, 255);
                    // MK
                    $this->textToImageSend($chat_id, 'assets/promo/rus/mk.jpg', $text, 'assets/font/Brothers Bold.ttf', 46, 2, 2.26, 404, 0, 0, 0);
                    // all sport
                    $this->textToImageSend($chat_id, 'assets/promo/rus/football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 51, 1.22, 1.17, 738.24475524476, 0, 255, 6);
                    //myach
                    $this->textToImageSend($chat_id, 'assets/promo/rus/ufc.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 46, 2, 1.72, 383, 255, 255, 255);
                    // MK2
                    $this->textToImageSend($chat_id, 'assets/promo/rus/mortal_kombat_2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 1.51, 1.146, 535.23178807947, 0, 0, 0);
                    // tachka
                    $this->textToImageSend($chat_id, 'assets/promo/rus/tachka.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 34, 2.15, 1.11, 380.82558139535, 0, 0, 0);
                    // salah
                    $this->textToImageSend($chat_id, 'assets/promo/rus/salah.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 1.46, 1.15, 540.22602739726, 0, 0, 0);
                    // MESSI
                    $this->textToImageSend($chat_id, 'assets/promo/rus/messi.jpg', $text, 'assets/font/morganbig_extrabolditalic.otf', 36, 1.51, 1.12, 579.73178807947, 0, 0, 0);
                    // KYPALNIK
                    $this->textToImageSend($chat_id, 'assets/promo/rus/kypalnik.jpg', $text, 'assets/font/MorganBig__ExtraboldItalic.otf', 35, 1.92, 1.4, 431, 0, 0, 0);

                    header('Content-type: text/html; charset=utf-8');

                    // RU
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/rus/RU.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        460,
                        [
                            ['maxLen' => 18, 'x' => 9, 'y' => 337, 'size' => 18],
                            ['maxLen' => 12, 'x' => 11, 'y' => 333, 'size' => 25],
                            ['maxLen' => 9, 'x' => 13, 'y' => 331, 'size' => 35]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // RU_1_1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/rus/RU_1_1.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        640,
                        [
                            ['maxLen' => 18, 'x' => 9, 'y' => 384, 'size' => 27],
                            ['maxLen' => 12, 'x' => 11, 'y' => 382, 'size' => 35]
                        ],
                        'black',
                        '-filter_complex',
                        '-strict -2 -y'
                    );
                    // RU_1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/rus/RU_1.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        640,
                        [
                            ['maxLen' => 18, 'x' => 9, 'y' => 384, 'size' => 27],
                            ['maxLen' => 12, 'x' => 11, 'y' => 382, 'size' => 35]
                        ],
                        'black',
                        '-filter_complex',
                        '-strict -2 -y'
                    );
                    // kazino
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/kazino.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        990,
                        [
                            ['maxLen' => 18, 'x' => 7, 'y' => 470, 'size' => 30],
                            ['maxLen' => 15, 'x' => 9, 'y' => 468, 'size' => 35],
                            ['maxLen' => 13, 'x' => 9, 'y' => 465, 'size' => 40],
                            ['maxLen' => 12, 'x' => 11, 'y' => 464, 'size' => 45],
                            ['maxLen' => 10, 'x' => 11, 'y' => 457, 'size' => 55]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );
                    // bablo2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/bablo2.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1070,
                        [
                            ['maxLen' => 18, 'x' => 7, 'y' => 526, 'size' => 30],
                            ['maxLen' => 15, 'x' => 9, 'y' => 524, 'size' => 35],
                            ['maxLen' => 13, 'x' => 9, 'y' => 520, 'size' => 40],
                            ['maxLen' => 12, 'x' => 11, 'y' => 518, 'size' => 45],
                            ['maxLen' => 10, 'x' => 11, 'y' => 512, 'size' => 55]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );


                    $abzac = 'ЛУЧШАЯ  БУКМЕКЕРСКАЯ КОМПАНИЯ - LINEBET.

                    Зарегистрируйтесь прямо сейчас. 
                    При регистрации введите в промо-код: <b>' . $text . '</b> 
                    и получите бонус до 8000 рублей на ПЕРВЫЙ депозит.
                    Круглосуточная поддержка игроков !
                    Не забудьте написать промокод: <b>' . $text . '</b>

                    📲 Мобильное приложение здесь👇';

                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "SW") {

                    //fotball_sw
                    $this->textToImageSend($chat_id, 'assets/promo/sw/fotball_sw.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.052, 1.30, 417.31578947368, 1, 1, 1);
                    //game_sw
                    $this->textToImageSend($chat_id, 'assets/promo/sw/game_sw.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 6.402, 2.22, 75.32208684786, 1, 1, 1);
                    //gold_sw
                    $this->textToImageSend($chat_id, 'assets/promo/sw/gold_sw.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 60, 2.002, 1.62, 305.45854145854, 255, 255, 255);
                    //green_car_sw
                    $this->textToImageSend($chat_id, 'assets/promo/sw/green_car_sw.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 8.115, 1.080, 98.524029574861, 255, 255, 255);
                    //ka_sw
                    $this->textToImageSend($chat_id, 'assets/promo/sw/ka_sw.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.005, 1.160, 430.65336658354, 255, 255, 255);
                    //space_sw
                    $this->textToImageSend($chat_id, 'assets/promo/sw/space_sw.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.35, 432.95854145854, 255, 255, 255);
                    //mbape_sw
                    $this->textToImageSend($chat_id, 'assets/promo/sw/mbape_sw.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.00, 1.125, 761, 255, 255, 255);
                    //ku_sw
                    $this->textToImageSend($chat_id, 'assets/promo/sw/ku_sw.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.00, 1.155, 363.5, 255, 255, 255);
                    //phone_sw
                    $this->textToImageSend($chat_id, 'assets/promo/sw/phone_sw.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.20, 1.05, 749.33333333333, 0, 0, 0);
                    // africa
                    $this->textToImageSend($chat_id, 'assets/promo/sw/africa.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.005, 1.215, 64.232593961799, 255, 255, 255);
                    //afro_men_new размер большой
                    $this->textToImageSend($chat_id, 'assets/promo/sw/afro_men_new.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 1.305, 1.215, 64.232593961799, 255, 255, 255);
                    //afro_women
                    $this->textToImageSend($chat_id, 'assets/promo/sw/afro_women.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 85, 1.265, 1.055, 64.232593961799, 0, 0, 0);
                    //afro_women2
                    $this->textToImageSend($chat_id, 'assets/promo/sw/afro_women2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.355, 1.355, 211.0110701107, 0, 0, 0);
                    // karta21
                    $this->textToImageSend($chat_id, 'assets/promo/uzb/karta21.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.17, 433.63366336634, 255, 255, 255);
                    // MK
                    $this->textToImageSend($chat_id, 'assets/promo/sw/mk.jpg', $text, 'assets/font/Brothers Bold.ttf', 46, 2, 2.34, 404, 0, 0, 0);
                    // all sport
                    $this->textToImageSend($chat_id, 'assets/promo/sw/football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 30, 1.14, 1.163, 856.36842105263, 0, 255, 6);
                    //myach
                    $this->textToImageSend($chat_id, 'assets/promo/sw/ufc.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 46, 2, 1.72, 383, 255, 255, 255);
                    // MK2
                    $this->textToImageSend($chat_id, 'assets/promo/sw/mortal_kombat_2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 1.51, 1.146, 535.23178807947, 0, 0, 0);
                    // tachka
                    $this->textToImageSend($chat_id, 'assets/promo/sw/tachka.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 34, 1.53, 1.11, 584.38235294118, 0, 0, 0);
                    // KYPALNIK
                    $this->textToImageSend($chat_id, 'assets/promo/sw/kypalnik.jpg', $text, 'assets/font/MorganBig__ExtraboldItalic.otf', 35, 1.8, 1.4, 468.5, 0, 0, 0);
                    // KOST
                    $this->textToImageSend($chat_id, 'assets/promo/sw/kost.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 38, 2, 1.11, 415, 255, 255, 255);


                    

                    header('Content-type: text/html; charset=utf-8');


                    
                    //linebet_sound
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/linebet_sound.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 300, 'size' => 30],
                            ['maxLen' => 10, 'x' => 25, 'y' => 300, 'size' => 40],
                            ['maxLen' => 6, 'x' => 25, 'y' => 300, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //linebet_sound2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/linebet_sound2.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 300, 'size' => 30],
                            ['maxLen' => 10, 'x' => 25, 'y' => 300, 'size' => 40],
                            ['maxLen' => 6, 'x' => 25, 'y' => 300, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //linebet_sound3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/linebet_sound3.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 300, 'size' => 30],
                            ['maxLen' => 10, 'x' => 25, 'y' => 300, 'size' => 40],
                            ['maxLen' => 6, 'x' => 25, 'y' => 300, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet1.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet2.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet3.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet4
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet4.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet5
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet5.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //mbape
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/mbape.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1000,
                        [
                            ['maxLen' => 18, 'x' => 80, 'y' => 650, 'size' => 36],
                            ['maxLen' => 10, 'x' => 80, 'y' => 650, 'size' => 40],
                            ['maxLen' => 6, 'x' => 140, 'y' => 650, 'size' => 46]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );

                    // Comp_1_3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/Comp_1_3.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        510,
                        [
                            ['maxLen' => 18, 'x' => 19, 'y' => 335, 'size' => 25],
                            ['maxLen' => 12, 'x' => 20, 'y' => 330, 'size' => 35]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // ken
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/ken.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        510,
                        [
                            ['maxLen' => 18, 'x' => 19, 'y' => 335, 'size' => 25],
                            ['maxLen' => 12, 'x' => 20, 'y' => 330, 'size' => 35]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // black_girl_sw
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/black_girl_sw.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        316,
                        [
                            ['maxLen' => 16, 'x' => 11, 'y' => 283, 'size' => 15],
                            ['maxLen' => 10, 'x' => 13, 'y' => 280, 'size' => 20]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // bablo2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/bablo2.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1070,
                        [
                            ['maxLen' => 18, 'x' => 7, 'y' => 526, 'size' => 30],
                            ['maxLen' => 15, 'x' => 9, 'y' => 524, 'size' => 35],
                            ['maxLen' => 13, 'x' => 9, 'y' => 520, 'size' => 40],
                            ['maxLen' => 12, 'x' => 11, 'y' => 518, 'size' => 45],
                            ['maxLen' => 10, 'x' => 11, 'y' => 512, 'size' => 55]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );
                    // kazino
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/kazino.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        990,
                        [
                            ['maxLen' => 18, 'x' => 7, 'y' => 470, 'size' => 30],
                            ['maxLen' => 15, 'x' => 9, 'y' => 468, 'size' => 35],
                            ['maxLen' => 13, 'x' => 9, 'y' => 465, 'size' => 40],
                            ['maxLen' => 12, 'x' => 11, 'y' => 464, 'size' => 45],
                            ['maxLen' => 10, 'x' => 11, 'y' => 457, 'size' => 55]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );


                    $abzac = '  Jisajili sasa:
                    Wakati wa kusajili, ingiza promo kodi: <b>' . $text . '</b> 
                    na upate bonasi zaidi ya shilingi 200,000 kwa mara yako ya KWANZA.
                    Msaada wa mchezaji wa masaa 24 siku 7!
                    Usisahau kuandika promo kodi: <b>' . $text . '</b> 

                    📲Pakua App yetu hapa👇🏾';

                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "SO") {

                    //fotball_so
                    $this->textToImageSend($chat_id, 'assets/promo/so/fotball_so.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.052, 1.30, 417.31578947368, 1, 1, 1);
                    //game_so
                    $this->textToImageSend($chat_id, 'assets/promo/so/game_so.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 6.402, 2.22, 75.32208684786, 1, 1, 1);
                    //gold_so
                    $this->textToImageSend($chat_id, 'assets/promo/so/gold_so.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 60, 2.002, 1.62, 305.45854145854, 255, 255, 255);
                    //green_car_so
                    $this->textToImageSend($chat_id, 'assets/promo/so/green_car_so.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 8.115, 1.080, 98.524029574861, 255, 255, 255);
                    //ka_so
                    $this->textToImageSend($chat_id, 'assets/promo/so/ka_so.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.005, 1.160, 430.65336658354, 255, 255, 255);
                    //space_so
                    $this->textToImageSend($chat_id, 'assets/promo/so/space_so.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.35, 432.95854145854, 255, 255, 255);
                    //mbape_so
                    $this->textToImageSend($chat_id, 'assets/promo/so/mbape_so.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.00, 1.125, 761, 255, 255, 255);
                    //ku_so
                    $this->textToImageSend($chat_id, 'assets/promo/so/ku_so.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.00, 1.155, 363.5, 255, 255, 255);
                    //phone_so
                    $this->textToImageSend($chat_id, 'assets/promo/so/phone_so.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.20, 1.05, 749.33333333333, 0, 0, 0);
                    

                    

                    header('Content-type: text/html; charset=utf-8');


                    
                    //linebet_sound
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/linebet_sound.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 300, 'size' => 30],
                            ['maxLen' => 10, 'x' => 25, 'y' => 300, 'size' => 40],
                            ['maxLen' => 6, 'x' => 25, 'y' => 300, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //linebet_sound2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/linebet_sound2.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 300, 'size' => 30],
                            ['maxLen' => 10, 'x' => 25, 'y' => 300, 'size' => 40],
                            ['maxLen' => 6, 'x' => 25, 'y' => 300, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //linebet_sound3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/linebet_sound3.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 300, 'size' => 30],
                            ['maxLen' => 10, 'x' => 25, 'y' => 300, 'size' => 40],
                            ['maxLen' => 6, 'x' => 25, 'y' => 300, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet1.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet2.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet3.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet4
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet4.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet5
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/promo_linebet5.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //mbape
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/sw/mbape.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1000,
                        [
                            ['maxLen' => 18, 'x' => 80, 'y' => 650, 'size' => 36],
                            ['maxLen' => 10, 'x' => 80, 'y' => 650, 'size' => 40],
                            ['maxLen' => 6, 'x' => 140, 'y' => 650, 'size' => 46]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );


                    $abzac = "WE ARE LINEBET, THE BEST BOOKMAKING COMPANY \nGali promo code ka ...\noo hel gunno ilaa $ 150 depositkaga  ugu horeeya.\nTaageerida ciyaartoyda 24/7!\nHa iloobin promo codekaaga ...!\n\n📲 Lasoo dag mobil appka👇🏾";

                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "PK") {

                    // 20000PKR
                    $this->textToImageSend($chat_id, 'assets/promo/dz/20000PKR.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 2.005, 1.135, 385.64837905237, 255, 255, 255);
                    //arab_girl
                    $this->textToImageSend($chat_id, 'assets/promo/dz/arab_girl.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 6.005, 1.235, 57.15570358035, 255, 255, 255);
                    //beisbol
                    $this->textToImageSend($chat_id, 'assets/promo/dz/beisbol.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.415, 1.575, 663.25088339223, 255, 255, 255);
                    //highest_win
                    $this->textToImageSend($chat_id, 'assets/promo/dz/highest_win.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.000, 1.295, 396.5, 255, 255, 255);
                    //pakistan
                    $this->textToImageSend($chat_id, 'assets/promo/dz/pakistan.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 44, 2.000, 1.104, 370.5, 255, 255, 255);
                    //afab_men
                    $this->textToImageSend($chat_id, 'assets/promo/dz/afab_men.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 1.265, 1.434, 696.25494071146, 255, 255, 255, 7);

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    header('Content-type: text/html; charset=utf-8');

                    $abzac = 'LINEBET THE BEST BOOKMAKING COMPANY!
The bookmaker you can trust!

Enter in the promocode  <b>' . $text . '</b> 
and get 100% bonus on your FIRST deposit.
24/7 player support!
Don\'t forget about your promo code! <b>' . $text . '</b>!

📲 Download mobile app👇';


                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "ENG") {

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    //green_linebet_game
                    $this->textToImageSend($chat_id, 'assets/promo/eng/green_linebet_game.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 6.402, 2.22, 75.32208684786, 1, 1, 1);
                    //space
                    $this->textToImageSend($chat_id, 'assets/promo/eng/space.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.35, 432.95854145854, 1, 1, 1);
                    //space_blue
                    $this->textToImageSend($chat_id, 'assets/promo/eng/space_blue.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.002, 1.35, 432.95854145854, 1, 1, 1);
                    //yellow_football
                    $this->textToImageSend($chat_id, 'assets/promo/eng/yellow_football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 85, 2.052, 1.04, 192.81578947368, 255, 255, 255);
                    //blue_football
                    $this->textToImageSend($chat_id, 'assets/promo/eng/blue_football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.052, 1.44, 425.31578947368, 255, 255, 255);
                    //win_football
                    $this->textToImageSend($chat_id, 'assets/promo/eng/win_football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.052, 1.16, 371.31578947368, 255, 255, 255);
                    //sevrole_football
                    $this->textToImageSend($chat_id, 'assets/promo/eng/sevrole_football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.052, 1.16, 425.31578947368, 255, 255, 255);
                    //salax_football
                    $this->textToImageSend($chat_id, 'assets/promo/eng/salax_football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 3.242, 1.125, 175.12769895126, 1, 1, 1);
                    //hourse
                    $this->textToImageSend($chat_id, 'assets/promo/bd/hourse.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 9.00, 1.10, 4.3333333333333, 0, 0, 0);
                    //casino_kub
                    $this->textToImageSend($chat_id, 'assets/promo/bd/casino_kub.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 25, 2.00, 1.105, 499.5, 255, 255, 255);
                    //big_wins
                    $this->textToImageSend($chat_id, 'assets/promo/bd/big_wins.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.00, 1.125, 653.5, 255, 255, 255);
                    //casino_people
                    $this->textToImageSend($chat_id, 'assets/promo/bd/casino_people.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 6.18, 1.12, 45.504854368932, 255, 255, 255);
                    //casino_women
                    $this->textToImageSend($chat_id, 'assets/promo/bd/casino_women.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.02, 1.17, 420.13366336634, 255, 255, 255);
                    //messi_30
                    $this->textToImageSend($chat_id, 'assets/promo/bd/messi_30.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.02, 1.17, 432.63366336634, 255, 255, 255);
                    // monday
                    $this->textToImageSend($chat_id, 'assets/promo/eng/monday.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 32, 1.20, 1.1, 741, 255, 255, 255);
                    // instruction
                    $this->textToImageSend($chat_id, 'assets/promo/eng/instruction.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.20, 1.05, 749.33333333333, 0, 0, 0);
                    // MK
                    $this->textToImageSend($chat_id, 'assets/promo/eng/mk_1.jpg', $text, 'assets/font/Brothers Bold.ttf', 46, 2, 2.28, 404, 0, 0, 0);
                    // all sport
                    $this->textToImageSend($chat_id, 'assets/promo/eng/football_1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 1.22, 1.19, 785.74590163934, 0, 255, 6);
                    //myach
                    $this->textToImageSend($chat_id, 'assets/promo/eng/ufc.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 46, 2, 1.72, 383, 255, 255, 255);
                    // MK2
                    $this->textToImageSend($chat_id, 'assets/promo/eng/mortal_kombat_2_1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 1.51, 1.146, 535.23178807947, 0, 0, 0);
                    // tachka
                    $this->textToImageSend($chat_id, 'assets/promo/eng/tachka.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 34, 2.15, 1.11, 380.82558139535, 0, 0, 0);
                    // KYPALNIK
                    $this->textToImageSend($chat_id, 'assets/promo/eng/kypalnik.jpg', $text, 'assets/font/MorganBig__ExtraboldItalic.otf', 35, 1.92, 1.4, 431, 0, 0, 0);
                    //subSuro_en
                    $this->textToImageSend($chat_id, 'assets/promo/eng/subSuro_en.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.030, 1.320, 347.03448275862, 255, 255, 255);
                    //carMersedes_en
                    $this->textToImageSend($chat_id, 'assets/promo/eng/carMersedes_en.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.030, 1.120, 126.56576862124, 255, 255, 255);
                    //GTR_en
                    $this->textToImageSend($chat_id, 'assets/promo/eng/GTR_en.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 8.115, 1.080, 64.232593961799, 255, 255, 255);

                    header('Content-type: text/html; charset=utf-8');

                    //promo_linebet1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/eng/promo_linebet1.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/eng/promo_linebet2.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/eng/promo_linebet3.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet4
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/eng/promo_linebet4.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //promo_linebet5
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/eng/promo_linebet5.mp4',
                        $text,
                        'ofont.ru_Solomon Sans.ttf',
                        486,
                        [
                            ['maxLen' => 18, 'x' => 14, 'y' => 700, 'size' => 36],
                            ['maxLen' => 10, 'x' => 11, 'y' => 700, 'size' => 38],
                            ['maxLen' => 6, 'x' => 3, 'y' => 700, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //mbape
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/eng/mbape.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1000,
                        [
                            ['maxLen' => 18, 'x' => 80, 'y' => 650, 'size' => 36],
                            ['maxLen' => 10, 'x' => 80, 'y' => 650, 'size' => 40],
                            ['maxLen' => 6, 'x' => 140, 'y' => 650, 'size' => 46]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );

                    // EN
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/eng/EN.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        460,
                        [
                            ['maxLen' => 18, 'x' => 9, 'y' => 337, 'size' => 18],
                            ['maxLen' => 12, 'x' => 11, 'y' => 333, 'size' => 25],
                            ['maxLen' => 9, 'x' => 13, 'y' => 331, 'size' => 35]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // black_girl_en
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/eng/black_girl_en.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        316,
                        [
                            ['maxLen' => 16, 'x' => 11, 'y' => 277, 'size' => 15],
                            ['maxLen' => 10, 'x' => 13, 'y' => 275, 'size' => 20]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // EN_1_1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/eng/EN_1_1.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        640,
                        [
                            ['maxLen' => 18, 'x' => 9, 'y' => 385, 'size' => 27],
                            ['maxLen' => 12, 'x' => 11, 'y' => 381, 'size' => 35]
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    // kazino
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/kazino.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        990,
                        [
                            ['maxLen' => 18, 'x' => 7, 'y' => 470, 'size' => 30],
                            ['maxLen' => 15, 'x' => 9, 'y' => 468, 'size' => 35],
                            ['maxLen' => 13, 'x' => 9, 'y' => 465, 'size' => 40],
                            ['maxLen' => 12, 'x' => 11, 'y' => 464, 'size' => 45],
                            ['maxLen' => 10, 'x' => 11, 'y' => 457, 'size' => 55]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );
                    // bablo2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/uzb/bablo2.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1070,
                        [
                            ['maxLen' => 18, 'x' => 7, 'y' => 526, 'size' => 30],
                            ['maxLen' => 15, 'x' => 9, 'y' => 524, 'size' => 35],
                            ['maxLen' => 13, 'x' => 9, 'y' => 520, 'size' => 40],
                            ['maxLen' => 12, 'x' => 11, 'y' => 518, 'size' => 45],
                            ['maxLen' => 10, 'x' => 11, 'y' => 512, 'size' => 55]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );

                    $abzac = 'WE ARE LINEBET, THE BEST BOOKMAKING COMPANY

Enter in the promocode <b>' . $text . '</b>
and get a bonus up to $ 150 on your FIRST deposit.
24/7 player support!
Don\'t forget about your promo code <b>' . $text . '</b>!

    📲 Download mobile app👇';


                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }

                if ($file == "BD ватсап") {

                    $dataSend = array(
                        'text' => "Введите промо",
                        'chat_id' => $chat_id,
                        'reply_markup' => $otmena,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");
                    $this->fpaddwrite($chat_id, $text);
                    $text = (string)$text;
                    $this->fpaddwrite3($chat_id, "$text");
                    $this->fpaddwrite2($chat_id, "BD_промо");
                }
                if ($file == "BD телеграм") {

                    $dataSend = array(
                        'text' => "Введите промо",
                        'chat_id' => $chat_id,
                        'reply_markup' => $otmena,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");
                    $this->fpaddwrite($chat_id, $text);
                    $text = (string)$text;
                    $this->fpaddwrite3($chat_id, "$text");
                    $this->fpaddwrite2($chat_id, "BD_промо_tg");
                }


                // if ($file == "BD телеграм") {

                //     $dataSend = array(
                //         'text' => "Введите промо",
                //         'chat_id' => $chat_id,
                //         'reply_markup' => $otmena,
                //     );
                //     $this->requestToTelegram($dataSend, "sendMessage");
                //     $this->fpaddwrite($chat_id, $text);
                //     $text = (string)$text;
                //     $this->fpaddwrite3($chat_id, "$text");
                //     $this->fpaddwrite2($chat_id, "BD_промо_tg");


                // }
                if ($file == "BD старое") {
                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    header('Content-type: text/html; charset=utf-8');


                    //subSuro_en
                    $this->textToImageSend($chat_id, 'assets/promo/bd/subSuro_en.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.030, 1.320, 347.03448275862, 255, 255, 255);
                    //carMersedes_en
                    $this->textToImageSend($chat_id, 'assets/promo/eng/carMersedes_en.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.030, 1.120, 449.99014778325, 255, 255, 255);
                    //GTR_en
                    $this->textToImageSend($chat_id, 'assets/promo/eng/GTR_en.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 8.115, 1.080, 61.732593961799, 255, 255, 255);


                    // b-setka
                    $this->textToImageSend($chat_id, 'assets/promo/bd/b-setka.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 60, 2.03, 1.070, 236.0960591133, 255, 255, 255);
                    // m_myach
                    $this->textToImageSend($chat_id, 'assets/promo/bd/m_myach.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 10, 1.88, 1.26, 138.71276595745, 255, 255, 255, 7);
                    // zayac
                    $this->textToImageSend($chat_id, 'assets/promo/bd/zayac.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 50, 3.72, 7.17, 22.897849462366, 255, 255, 255);
                    // girl_Line
                    $this->textToImageSend($chat_id, 'assets/promo/bd/girl_Line.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.03, 1.172, 430.99014778325, 255, 255, 255);
                    // t_green
                    $this->textToImageSend($chat_id, 'assets/promo/bd/t_green.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 37, 2.0, 1.31, 430.5, 255, 255, 255);
                    // ufc_promo
                    $this->textToImageSend($chat_id, 'assets/promo/bd/ufc_promo.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.03, 1.172, 430.99014778325, 255, 255, 255);
                    // poc
                    $this->textToImageSend($chat_id, 'assets/promo/bd/poc.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 31, 2.01, 1.574, 445.80348258706, 255, 255, 255);
                    // lino-ogenio
                    $this->textToImageSend($chat_id, 'assets/promo/bd/lino-ogenio.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 120, 2.03, 1.088, 868.26600985222, 255, 255, 255);
                    // green_team
                    $this->textToImageSend($chat_id, 'assets/promo/bd/green_team.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.14, 334.24752475248, 255, 255, 255);
                    // sport_green
                    $this->textToImageSend($chat_id, 'assets/promo/bd/sport_green.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.16, 319.27722772277, 255, 255, 255);
                    // ryletka
                    $this->textToImageSend($chat_id, 'assets/promo/bd/ryletka.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 46, 3.6, 2.795, 180.5, 255, 255, 255);
                    // poker
                    $this->textToImageSend($chat_id, 'assets/promo/bd/poker.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 46, 2.19, 1.08, 373.65068493151, 255, 255, 255);
                    // btachka
                    $this->textToImageSend($chat_id, 'assets/promo/bd/btachka.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 46, 1.57, 2.125, 568.39808917197, 255, 255, 255);
                    // TACHKA2
                    $this->textToImageSend($chat_id, 'assets/promo/bd/tachka2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.03, 1.325, 412.5197044335, 255, 255, 255);
                    // MK
                    $this->textToImageSend($chat_id, 'assets/promo/bd/mk.jpg', $text, 'assets/font/Brothers Bold.ttf', 46, 2, 2.29, 404, 0, 0, 0);
                    // MK2
                    $this->textToImageSend($chat_id, 'assets/promo/bd/mortal_kombat_2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2, 1.146, 396.0197044335, 0, 0, 0);
                    // football
                    $this->textToImageSend($chat_id, 'assets/promo/bd/football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 1.2, 1.15, 747, 0, 255, 6);
                    // KYPALNIK
                    $this->textToImageSend($chat_id, 'assets/promo/bd/kypalnik.jpg', $text, 'assets/font/MorganBig__ExtraboldItalic.otf', 35, 1.92, 1.4, 431, 0, 0, 0);
                    // tachka
                    $this->textToImageSend($chat_id, 'assets/promo/bd/tachka.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 38, 2, 1.079, 424.5, 0, 0, 0);
                    //myach
                    $this->textToImageSend($chat_id, 'assets/promo/bd/ufc.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 46, 2, 1.72, 383, 255, 255, 255);




                    // 0
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/0.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        635,
                        [
                            ['maxLen' => 20, 'x' => 12, 'y' => 312, 'size' => 16],
                            ['maxLen' => 16, 'x' => 14, 'y' => 310, 'size' => 20]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    // poker
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/poker.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        635,
                        [
                            ['maxLen' => 20, 'x' => 12, 'y' => 312, 'size' => 16],
                            ['maxLen' => 16, 'x' => 14, 'y' => 310, 'size' => 20]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    // roulette
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/roulette.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        635,
                        [
                            ['maxLen' => 20, 'x' => 12, 'y' => 312, 'size' => 16],
                            ['maxLen' => 16, 'x' => 14, 'y' => 310, 'size' => 20]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //line1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/line1.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        670,
                        [
                            ['maxLen' => 20, 'x' => 17, 'y' => 317, 'size' => 25],
                            ['maxLen' => 13, 'x' => 22, 'y' => 315, 'size' => 33]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // MK_scorp
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/MK_scorp.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        510,
                        [
                            ['maxLen' => 19, 'x' => 20, 'y' => 435, 'size' => 32]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // line3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/line3.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        670,
                        [
                            ['maxLen' => 20, 'x' => 17, 'y' => 307, 'size' => 25],
                            ['maxLen' => 13, 'x' => 23, 'y' => 300, 'size' => 33]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // Bangladesh
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/Bangladesh.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        460,
                        [
                            ['maxLen' => 18, 'x' => 9, 'y' => 337, 'size' => 18],
                            ['maxLen' => 12, 'x' => 11, 'y' => 333, 'size' => 25],
                            ['maxLen' => 9, 'x' => 13, 'y' => 329, 'size' => 35]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // MK_zero
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/MK_zero.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        510,
                        [
                            ['maxLen' => 19, 'x' => 20, 'y' => 435, 'size' => 32]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );
                    // bablo2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/bablo2.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        850,
                        [
                            ['maxLen' => 18, 'x' => 10, 'y' => 463, 'size' => 33],
                            ['maxLen' => 14, 'x' => 9, 'y' => 459, 'size' => 40]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );
                    // bablo
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/bd/bablo.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        2000,
                        [
                            ['maxLen' => 17, 'x' => 10, 'y' => 987, 'size' => 60],
                            ['maxLen' => 13, 'x' => 11, 'y' => 973, 'size' => 80],
                            ['maxLen' => 10, 'x' => 12, 'y' => 962, 'size' => 100]
                        ],
                        'white',
                        '-vf',
                        '-strict -2 -y'
                    );

                    $abzac = 'WE ARE LINEBET, THE BEST BOOKMAKING COMPANY

Enter in the promocode <b>' . $text . '</b>
and get a bonus up to 13000 BDT on your FIRST deposit.
24/7 player support!
Don\'t forget about your promo code <b>' . $text . '</b>!

    📲 Download mobile app👇

    আমরা লাইনবেট, বিশ্বের সেরা বুকম্যাকিং কোম্পানি 

<b>' . $text . '</b>  প্রোমো কোডটি ব্যবহার করুন 
আর জিতে নিন বোনাস ১০,০০০ টাকা পর্যন্ত,  আপনার প্রথম ডিপসিটে। 
২৪/৭ প্লেয়ারস সাপোর্ট! 
<b>' . $text . '</b> প্রোমো কোডটি ব্যবহার করতে ভুলবেন না কিন্তু !  

📲 এপটি  ডাউনলোড করুন  👇';


                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "BD новое") {

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    //basketball
                    $this->textToImageSend($chat_id, 'assets/promo/bd/basketball.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 1.852, 1.320, 430.89308855292, 255, 255, 255);
                    //balondior
                    $this->textToImageSend($chat_id, 'assets/promo/bd/balondior.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 4.652, 1.240, 109.65821152193, 0, 0, 0);
                    //beshi_odd
                    $this->textToImageSend($chat_id, 'assets/promo/bd/beshi_odd.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 1.852, 1.270, 414.15442764579, 255, 255, 255);
                    //casino_event
                    $this->textToImageSend($chat_id, 'assets/promo/bd/casino_event.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.252, 1.620, 282.39698046181, 255, 255, 255);
                    //hocky
                    $this->textToImageSend($chat_id, 'assets/promo/bd/hocky.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.152, 1.210, 176.53345724907, 255, 255, 255);
                    //Iverson
                    $this->textToImageSend($chat_id, 'assets/promo/bd/Iverson.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 95, 1.252, 1.310, 1147.5734824281, 255, 255, 255);
                    //Jackpot
                    $this->textToImageSend($chat_id, 'assets/promo/bd/Jackpot.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.632, 1.250, 410.12745098039, 255, 255, 255);
                    //porajoi
                    $this->textToImageSend($chat_id, 'assets/promo/bd/porajoi.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 95, 2.012, 1.255, 605.03578528827, 255, 255, 255);
                    //register_korlei_bonus
                    $this->textToImageSend($chat_id, 'assets/promo/bd/register_korlei_bonus.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.012, 1.435, 329.41153081511, 255, 255, 255, 3);
                    //girl_cosmos
                    $this->textToImageSend($chat_id, 'assets/promo/bd/girl_cosmos.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.452, 1.320, 514.65702479339, 0, 0, 0);
                    //cas_people
                    $this->textToImageSend($chat_id, 'assets/promo/bd/cas_people.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 6.052, 1.210, 54.6424322538, 255, 255, 255);
                    //sera_offer
                    $this->textToImageSend($chat_id, 'assets/promo/bd/sera_offer.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.012, 1.335, 0, 255, 255, 255);
                    //men_kriket_black
                    $this->textToImageSend($chat_id, 'assets/promo/bd/men_kriket_black.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.262, 1.324, 759.78446909667, 255, 255, 255);
                    //neimar_fotball
                    $this->textToImageSend($chat_id, 'assets/promo/bd/neimar_fotball.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.012, 1.244, 265.12922465209, 255, 255, 255);


                    header('Content-type: text/html; charset=utf-8');


                    $abzac = 'WE ARE LINEBET, THE BEST BOOKMAKING COMPANY

Enter in the promocode <b>' . $text . '</b>
and get a bonus up to 13000 BDT on your FIRST deposit.
24/7 player support!
Don\'t forget about your promo code <b>' . $text . '</b>!

    📲 Download mobile app👇

    আমরা লাইনবেট, বিশ্বের সেরা বুকম্যাকিং কোম্পানি 

<b>' . $text . '</b>  প্রোমো কোডটি ব্যবহার করুন 
আর জিতে নিন বোনাস ১০,০০০ টাকা পর্যন্ত,  আপনার প্রথম ডিপসিটে। 
২৪/৭ প্লেয়ারস সাপোর্ট! 
<b>' . $text . '</b> প্রোমো কোডটি ব্যবহার করতে ভুলবেন না কিন্তু !  

📲 এপটি  ডাউনলোড করুন  👇';


                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "BD новое2") {

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    //red_girl2
                    $this->textToImageSend($chat_id, 'assets/promo/bd/red_girl2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.572, 1.365, 226.76438569207, 0, 0, 0);
                    //winzo
                    $this->textToImageSend($chat_id, 'assets/promo/bd/winzo.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.702, 1.285, 497.04759106933, 255, 255, 255);
                    //white_girl
                    $this->textToImageSend($chat_id, 'assets/promo/bd/white_girl.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 3.402, 1.285, 135.00146972369, 255, 255, 255);
                    //tiger_men
                    $this->textToImageSend($chat_id, 'assets/promo/bd/tiger_men.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.002, 1.235, 328.06393606394, 255, 255, 255);
                    //red_girl
                    $this->textToImageSend($chat_id, 'assets/promo/bd/red_girl.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.252, 1.205, 255.86589698046, 255, 255, 255);
                    //match_fotball
                    $this->textToImageSend($chat_id, 'assets/promo/bd/match_fotball.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.032, 1.465, 281.85433070866, 255, 255, 255);
                    //linebet100evro
                    $this->textToImageSend($chat_id, 'assets/promo/bd/linebet100evro.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 3.132, 1.225, 207.3275862069, 255, 255, 255);
                    //linebet_monitor
                    $this->textToImageSend($chat_id, 'assets/promo/bd/linebet_monitor.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.252, 1.065, 572.5303514377, 255, 255, 255);
                    //linebet_kub
                    $this->textToImageSend($chat_id, 'assets/promo/bd/linebet_kub.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 1.982, 1.265, 413.40413723512, 255, 255, 255);
                    //linebet_fotball_player2
                    $this->textToImageSend($chat_id, 'assets/promo/bd/linebet_fotball_player2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 3.882, 1.315, 120.20710973725, 255, 255, 255);
                    //linebet_fotball_player
                    $this->textToImageSend($chat_id, 'assets/promo/bd/linebet_fotball_player.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 1.382, 1.345, 651.47612156295, 255, 255, 255);
                    //linebet_dolar
                    $this->textToImageSend($chat_id, 'assets/promo/bd/linebet_dolar.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.682, 1.285, 542.09274673008, 255, 255, 255);
                    //green_men
                    $this->textToImageSend($chat_id, 'assets/promo/bd/green_men.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.002, 1.935, 349.58041958042, 255, 255, 255);
                    //green_women
                    $this->textToImageSend($chat_id, 'assets/promo/bd/green_women.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 1.452, 1.405, 612.30165289256, 255, 255, 255);
                    //fotbal_team_messi_dr
                    $this->textToImageSend($chat_id, 'assets/promo/bd/fotbal_team_messi_dr.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 1.902, 1.175, 418.82334384858, 255, 255, 255);
                    //green_girl
                    $this->textToImageSend($chat_id, 'assets/promo/bd/green_girl.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.052, 1.235, 328.95126705653, 255, 255, 255);
                    //black_women
                    $this->textToImageSend($chat_id, 'assets/promo/bd/black_women.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.412, 1.285, 669.87252124646, 255, 255, 255);
                    //black_men_fotball
                    $this->textToImageSend($chat_id, 'assets/promo/bd/black_men_fotball.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 3.312, 2.385, 150.07487922705, 255, 255, 255);
                    //black_girl3
                    $this->textToImageSend($chat_id, 'assets/promo/bd/black_girl3.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.012, 1.175, 360.31908548708, 255, 255, 255);
                    //black_girl2
                    $this->textToImageSend($chat_id, 'assets/promo/bd/black_girl2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.012, 1.225, 283.61133200795, 255, 255, 255);
                    ///black_girl
                    $this->textToImageSend($chat_id, 'assets/promo/bd/black_girl.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 3.212, 1.785, 152.11332503113, 255, 255, 255);

                    //A_men
                    $this->textToImageSend($chat_id, 'assets/promo/bd/A_men.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.002, 1.425, 328.07592407592, 255, 255, 255);
                    //casino_team
                    $this->textToImageSend($chat_id, 'assets/promo/bd/casino_team.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 25, 2.00, 1.10, 324, 0, 0, 0);
                    //kfc_men
                    $this->textToImageSend($chat_id, 'assets/promo/bd/kfc_men.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 25, 2.00, 1.065, 295, 255, 255, 255);
                    //big_wins
                    $this->textToImageSend($chat_id, 'assets/promo/bd/big_wins.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2.00, 1.125, 653.5, 255, 255, 255);
                    //casino_people
                    $this->textToImageSend($chat_id, 'assets/promo/bd/casino_people.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 6.18, 1.12, 45.504854368932, 255, 255, 255);

                    header('Content-type: text/html; charset=utf-8');

                    $abzac = 'WE ARE LINEBET, THE BEST BOOKMAKING COMPANY

Enter in the promocode <b>' . $text . '</b>
and get a bonus up to 13000 BDT on your FIRST deposit.
24/7 player support!
Don\'t forget about your promo code <b>' . $text . '</b>!

    📲 Download mobile app👇

    আমরা লাইনবেট, বিশ্বের সেরা বুকম্যাকিং কোম্পানি 

<b>' . $text . '</b>  প্রোমো কোডটি ব্যবহার করুন 
আর জিতে নিন বোনাস ১০,০০০ টাকা পর্যন্ত,  আপনার প্রথম ডিপসিটে। 
২৪/৭ প্লেয়ারস সাপোর্ট! 
<b>' . $text . '</b> প্রোমো কোডটি ব্যবহার করতে ভুলবেন না কিন্তু !  

📲 এপটি  ডাউনলোড করুন  👇';


                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "BD football_kriket") {

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    //
                    $this->textToImageSend($chat_id, 'assets/promo/bd/grab.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 3.422, 1.085, 191.1049094097, 255, 255, 255);
                    //yellow_football
                    $this->textToImageSend($chat_id, 'assets/promo/bd/yellow_football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 85, 2.052, 1.04, 192.81578947368, 255, 255, 255);
                    //blue_football
                    $this->textToImageSend($chat_id, 'assets/promo/bd/blue_football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.052, 1.44, 425.31578947368, 255, 255, 255);
                    //win_football
                    $this->textToImageSend($chat_id, 'assets/promo/bd/win_football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.052, 1.16, 371.31578947368, 255, 255, 255);
                    //salax_football
                    $this->textToImageSend($chat_id, 'assets/promo/bd/salax_football.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 3.242, 1.125, 175.12769895126, 1, 1, 1);
                    //ronald_promo
                    $this->textToImageSend($chat_id, 'assets/promo/bd/ronald_promo.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 2.052, 1.13, 437.81578947368, 1, 1, 1);
                    //ronald_promo1
                    $this->textToImageSend($chat_id, 'assets/promo/bd/ronald_promo1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 55, 5.552, 1.34, 65.244956772334, 1, 1, 1);
                    //ronald_promo2
                    $this->textToImageSend($chat_id, 'assets/promo/bd/ronald_promo2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 85, 3.052, 1.18, 152.67693315858, 1, 1, 1);
                    //messi_promo
                    $this->textToImageSend($chat_id, 'assets/promo/bd/messi_promo.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.052, 1.22, 432.26510721248, 1, 1, 1);
                    //neimar_fotball
                    $this->textToImageSend($chat_id, 'assets/promo/bd/neimar_promo.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.052, 1.20, 413.81578947368, 255, 255, 255);
                    //avis_promo
                    $this->textToImageSend($chat_id, 'assets/promo/bd/avis_promo.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 85, 2.052, 1.20, 293.81578947368, 255, 255, 255);


                    header('Content-type: text/html; charset=utf-8');

                    $abzac = 'WE ARE LINEBET, THE BEST BOOKMAKING COMPANY

Enter in the promocode <b>' . $text . '</b>
and get a bonus up to 13000 BDT on your FIRST deposit.
24/7 player support!
Don\'t forget about your promo code <b>' . $text . '</b>!

    📲 Download mobile app👇

    আমরা লাইনবেট, বিশ্বের সেরা বুকম্যাকিং কোম্পানি 

<b>' . $text . '</b>  প্রোমো কোডটি ব্যবহার করুন 
আর জিতে নিন বোনাস ১০,০০০ টাকা পর্যন্ত,  আপনার প্রথম ডিপসিটে। 
২৪/৭ প্লেয়ারস সাপোর্ট! 
<b>' . $text . '</b> প্রোমো কোডটি ব্যবহার করতে ভুলবেন না কিন্তু !  

📲 এপটি  ডাউনলোড করুন  👇';


                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "MN") {
                    // MK
                    $this->textToImageSend($chat_id, 'assets/promo/mn/mk_mn.jpg', $text, 'assets/font/Brothers Bold.ttf', 46, 2, 2.35, 404, 0, 0, 0);
                    // all sport
                    $this->textToImageSend($chat_id, 'assets/promo/mn/football_mn1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.2, 1.08, 335.90909090909, 0, 255, 6);
                    //myach
                    $this->textToImageSend($chat_id, 'assets/promo/mn/ufc_mn.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 46, 2, 1.72, 383, 255, 255, 255);
                    // MK2
                    $this->textToImageSend($chat_id, 'assets/promo/mn/mortal_kombat_2_mn1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 1.51, 1.146, 535.23178807947, 0, 0, 0);
                    // tachka
                    $this->textToImageSend($chat_id, 'assets/promo/mn/tachka_mn1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 34, 2.15, 1.11, 380.82558139535, 0, 0, 0);
                    // CSGO
                    $this->textToImageSend($chat_id, 'assets/promo/mn/csgo.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 34, 2.01, 1.095, 434.81343283582, 0, 0, 0);
                    // MESSI
                    $this->textToImageSend($chat_id, 'assets/promo/mn/messi_mn1.jpg', $text, 'assets/font/morganbig_extrabolditalic.otf', 36, 1.51, 1.12, 579.73178807947, 0, 0, 0);
                    // KYPALNIK
                    $this->textToImageSend($chat_id, 'assets/promo/mn/kypalnik_mn1.jpg', $text, 'assets/font/MorganBig__ExtraboldItalic.otf', 35, 1.92, 1.4, 431, 0, 0, 0);

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    header('Content-type: text/html; charset=utf-8');

                    // MN
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/mn/MN.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        460,
                        [
                            ['maxLen' => 18, 'x' => 9, 'y' => 337, 'size' => 18],
                            ['maxLen' => 12, 'x' => 11, 'y' => 333, 'size' => 25],
                            ['maxLen' => 9, 'x' => 13, 'y' => 331, 'size' => 35]
                        ],
                        'white',
                        '-filter_complex',
                        '-y'
                    );

                    header('Content-type: text/html; charset=utf-8');

$abzac = 'Сурталчилгааны кодыг оруулчихад <b>' . $text . '</b>
Эхний депозитын $ 100 хүртэлх урамшлуулал аваараай
24/7 тоглогчидын дэмжлэг
Сурталчилгааны код бүү мартаарай <b>' . $text . '</b>

📲 Гар утасны APP татаад авах';

                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "FR картинки") {
                    //🇫🇷
                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    //gold_linebet1
                    $this->textToImageSend($chat_id, 'assets/promo/fr/gold_linebet1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.012, 1.605, 258.76739562624, 255, 255, 255);
                    //big_bonuses
                    $this->textToImageSend($chat_id, 'assets/promo/fr/big_bonuses.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 65, 2.012, 1.335, 353.44632206759, 255, 255, 255);
                    //gros_bonus
                    $this->textToImageSend($chat_id, 'assets/promo/fr/gros_bonus.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.012, 1.235, 383.94632206759, 0, 0, 0);
                    //gros_bonus100
                    $this->textToImageSend($chat_id, 'assets/promo/fr/gros_bonus100.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 7.012, 2.085, 70.044209925841, 0, 0, 0);
                    //linebet_box_team
                    $this->textToImageSend($chat_id, 'assets/promo/fr/linebet_box_team.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.012, 1.175, 396.44632206759, 0, 0, 0);
                    //orange_play
                    $this->textToImageSend($chat_id, 'assets/promo/fr/orange_play.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.012, 1.145, 511.18290258449, 0, 0, 0);
                    //play_linebet
                    $this->textToImageSend($chat_id, 'assets/promo/fr/play_linebet.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.012, 1.165, 540.18290258449, 0, 0, 0);
                    //sur_tel
                    $this->textToImageSend($chat_id, 'assets/promo/fr/sur_tel.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 5.212, 1.115, 105.981580967, 0, 0, 0);
                    //volus_bones
                    $this->textToImageSend($chat_id, 'assets/promo/fr/volus_bones.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.012, 1.135, 362.44632206759, 0, 0, 0);
                    //black_girl_n_white
                    $this->textToImageSend($chat_id, 'assets/promo/fr/black_girl_n_white.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 25, 1.9908, 1.175, 572.45760498292, 255, 255, 255);
                    //black_men_in_red
                    $this->textToImageSend($chat_id, 'assets/promo/fr/black_men_in_red.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 25, 1.9908, 1.175, 572.45760498292, 255, 255, 255);
                    //mybux
                    $this->textToImageSend($chat_id, 'assets/promo/fr/mybux.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 25, 2.4908, 1.175, 423.27292436165, 0, 0, 0);
                    //messi_and_salah
                    $this->textToImageSend($chat_id, 'assets/promo/fr/messi_and_salah.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.02, 1.175, 406.93069306931, 0, 0, 0);
                    //xbox
                    $this->textToImageSend($chat_id, 'assets/promo/fr/xbox.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.02, 1.175, 435.13366336634, 255, 255, 255);
                    //ronaldo_manchester
                    $this->textToImageSend($chat_id, 'assets/promo/fr/ronaldo_manchester.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 6.72, 1.755, 28.309523809524, 255, 255, 255);
                    //girl_team
                    $this->textToImageSend($chat_id, 'assets/promo/fr/girl_team.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.002, 1.175, 416.48851148851, 255, 255, 255);
                    //fr_men
                    $this->textToImageSend($chat_id, 'assets/promo/fr/fr_men.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 6.02, 1.685, 59.566445182724, 255, 255, 255);
                    //fr_sub_ziro
                    $this->textToImageSend($chat_id, 'assets/promo/fr/fr_sub_ziro.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.002, 1.115, 416.48851148851, 255, 255, 255);
                    //france_team
                    $this->textToImageSend($chat_id, 'assets/promo/fr/france_team.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.9908, 1.17, 413.36608398634, 255, 255, 255);
                    //fr_kub
                    $this->textToImageSend($chat_id, 'assets/promo/fr/fr_kub.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.02, 1.54, 414.86608398634, 255, 255, 255, 5);
                    // grant
                    $this->textToImageSend($chat_id, 'assets/promo/fr/grant.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 38, 6.55, 1.19, 83.206106870229, 255, 255, 255);
                    // form
                    $this->textToImageSend($chat_id, 'assets/promo/fr/form.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.22, 1.09, 752.74590163934, 255, 255, 255);
                    // amerfoot1
                    $this->textToImageSend($chat_id, 'assets/promo/fr/amerfoot1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.23, 1.1, 933.15040650407, 255, 255, 255);
                    // hulk
                    //$this->textToImageSend($chat_id, 'assets/promo/fr/hulk.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 38, 2.01, 1.093, 209.45273631841, 255, 255, 255);
                    // zel
                    $this->textToImageSend($chat_id, 'assets/promo/fr/zel.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 38, 2.01, 1.24, 378.95273631841, 255, 255, 255);
                    // amerfoot
                    $this->textToImageSend($chat_id, 'assets/promo/fr/amerfoot.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 38, 2.01, 1.243, 392.95273631841, 255, 255, 255);
                    // nice
                    $this->textToImageSend($chat_id, 'assets/promo/fr/nice.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 30, 2.01, 1.07, 523.81592039801, 255, 255, 255);
                    // hand
                    $this->textToImageSend($chat_id, 'assets/promo/fr/hand.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 25, 2.01, 1.07, 213.70792079208, 255, 255, 255);
                    // instruction
                    $this->textToImageSend($chat_id, 'assets/promo/fr/instruction.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.20, 1.05, 749.33333333333, 0, 0, 0);
                    // ufc_promo_notext
                    $this->textToImageSend($chat_id, 'assets/promo/fr/ufc_promo_notext.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.03, 1.172, 430.99014778325, 255, 255, 255);
                    // sport_real
                    $this->textToImageSend($chat_id, 'assets/promo/fr/sport_real.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 150, 2.05, 1.16, 1386.012195122, 255, 255, 255);
                    // karta21
                    $this->textToImageSend($chat_id, 'assets/promo/fr/karta21.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 40, 2.02, 1.17, 433.63366336634, 255, 255, 255);
                    // MK
                    $this->textToImageSend($chat_id, 'assets/promo/fr/mk_fr.jpg', $text, 'assets/font/Brothers Bold.ttf', 46, 2, 2.27, 404, 0, 0, 0);
                    //myach
                    $this->textToImageSend($chat_id, 'assets/promo/fr/ufc_fr.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 46, 2, 1.72, 383, 255, 255, 255);
                    // MK2
                    $this->textToImageSend($chat_id, 'assets/promo/fr/mortal_kombat_2_fr.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 45, 2, 1.146, 367.5, 0, 0, 0);
                    // tachka
                    $this->textToImageSend($chat_id, 'assets/promo/fr/tachka_fr.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 34, 2.15, 1.11, 380.82558139535, 0, 0, 0);
                    // KYPALNIK
                    $this->textToImageSend($chat_id, 'assets/promo/fr/kypalnik_fr.jpg', $text, 'assets/font/MorganBig__ExtraboldItalic.otf', 35, 1.92, 1.4, 431, 0, 0, 0);

                    header('Content-type: text/html; charset=utf-8');

                    header('Content-type: text/html; charset=utf-8');

$abzac = 'LINEBET, LE MEILLEUR BOOKMAKER. Utilise le code <b>' . $text . '</b> et obtiens un bonus jusqu\'à 100€ sur ton 1er dépôt.
Service client 24/7 !
N\'oublie pas le code <b>' . $text . '</b> ! ';


                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "FR видео") {

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");



                    header('Content-type: text/html; charset=utf-8');


                    //linebet_sound
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/linebet_sound.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 300, 'size' => 30],
                            ['maxLen' => 10, 'x' => 25, 'y' => 300, 'size' => 40],
                            ['maxLen' => 6, 'x' => 25, 'y' => 300, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //linebet_sound2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/linebet_sound2.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 300, 'size' => 30],
                            ['maxLen' => 10, 'x' => 25, 'y' => 300, 'size' => 40],
                            ['maxLen' => 6, 'x' => 25, 'y' => 300, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //linebet_sound3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/linebet_sound3.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        600,
                        [
                            ['maxLen' => 18, 'x' => 15, 'y' => 300, 'size' => 30],
                            ['maxLen' => 10, 'x' => 25, 'y' => 300, 'size' => 40],
                            ['maxLen' => 6, 'x' => 25, 'y' => 300, 'size' => 46]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    //messi_gif
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/messi_gif.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        300,
                        [
                            ['maxLen' => 12, 'x' => 10, 'y' => 170, 'size' => 16],
                            ['maxLen' => 6, 'x' => 10, 'y' => 170, 'size' => 20],
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    //team_gif1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/team_gif1.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        350,
                        [
                            ['maxLen' => 12, 'x' => 10, 'y' => 270, 'size' => 16],
                            ['maxLen' => 6, 'x' => 10, 'y' => 270, 'size' => 20],
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    //team_gif
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/team_gif.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        300,
                        [
                            ['maxLen' => 12, 'x' => 10, 'y' => 270, 'size' => 16],
                            ['maxLen' => 6, 'x' => 10, 'y' => 270, 'size' => 20],
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    //salx_gif
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/salx_gif.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        300,
                        [
                            ['maxLen' => 12, 'x' => 10, 'y' => 280, 'size' => 16],
                            ['maxLen' => 6, 'x' => 10, 'y' => 280, 'size' => 20],
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    //ronald_gif
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/ronald_gif.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        300,
                        [
                            ['maxLen' => 12, 'x' => 25, 'y' => 175, 'size' => 16],
                            ['maxLen' => 6, 'x' => 25, 'y' => 175, 'size' => 20],
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    //ronald_gif1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/ronald_gif1.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        520,
                        [
                            ['maxLen' => 12, 'x' => 15, 'y' => 250, 'size' => 16],
                            ['maxLen' => 6, 'x' => 15, 'y' => 250, 'size' => 20],
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    //neimar_gif
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/neimar_gif.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        300,
                        [
                            ['maxLen' => 12, 'x' => 10, 'y' => 280, 'size' => 16],
                            ['maxLen' => 6, 'x' => 10, 'y' => 280, 'size' => 20],
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    //messi_gif1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/messi_gif1.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        150,
                        [
                            ['maxLen' => 12, 'x' => 10, 'y' => 175, 'size' => 16],
                            ['maxLen' => 6, 'x' => 10, 'y' => 175, 'size' => 20],
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    //foot
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/foot.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        540,
                        [
                            ['maxLen' => 25, 'x' => 18, 'y' => 821, 'size' => 24],
                            ['maxLen' => 16, 'x' => 25, 'y' => 818, 'size' => 35],
                            ['maxLen' => 10, 'x' => 35, 'y' => 815, 'size' => 50]
                        ],
                        'black',
                        '-filter_complex',
                        '-strict -2 -y',
                        ':enable=between(t\,0.35\,7)'
                    );
                    //foot1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/foot1.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        540,
                        [
                            ['maxLen' => 25, 'x' => 18, 'y' => 821, 'size' => 24],
                            ['maxLen' => 16, 'x' => 25, 'y' => 818, 'size' => 35],
                            ['maxLen' => 10, 'x' => 35, 'y' => 815, 'size' => 50]
                        ],
                        'black',
                        '-filter_complex',
                        '-strict -2 -y',
                        ':enable=between(t\,0.35\,7)'
                    );
                    //foot2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/foot2.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        540,
                        [
                            ['maxLen' => 25, 'x' => 18, 'y' => 821, 'size' => 24],
                            ['maxLen' => 16, 'x' => 25, 'y' => 818, 'size' => 35],
                            ['maxLen' => 10, 'x' => 35, 'y' => 815, 'size' => 50]
                        ],
                        'black',
                        '-filter_complex',
                        '-strict -2 -y',
                        ':enable=between(t\,0.35\,7)'
                    );
                    // foot3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/foot3.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        540,
                        [
                            ['maxLen' => 25, 'x' => 18, 'y' => 821, 'size' => 24],
                            ['maxLen' => 16, 'x' => 25, 'y' => 818, 'size' => 35],
                            ['maxLen' => 10, 'x' => 35, 'y' => 815, 'size' => 50]
                        ],
                        'black',
                        '-filter_complex',
                        '-strict -2 -y',
                        ':enable=between(t\,0.35\,7)'
                    );
                    // foot4
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/foot4.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        540,
                        [
                            ['maxLen' => 25, 'x' => 18, 'y' => 821, 'size' => 24],
                            ['maxLen' => 16, 'x' => 25, 'y' => 818, 'size' => 35],
                            ['maxLen' => 10, 'x' => 35, 'y' => 815, 'size' => 50]
                        ],
                        'black',
                        '-filter_complex',
                        '-strict -2 -y',
                        ':enable=between(t\,0.35\,7)'
                    );
                    // foot5
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/foot5.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        540,
                        [
                            ['maxLen' => 25, 'x' => 18, 'y' => 821, 'size' => 24],
                            ['maxLen' => 16, 'x' => 25, 'y' => 818, 'size' => 35],
                            ['maxLen' => 10, 'x' => 35, 'y' => 815, 'size' => 50]
                        ],
                        'black',
                        '-filter_complex',
                        '-strict -2 -y',
                        ':enable=between(t\,0.35\,7)'
                    );
                    // foot6
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/fr/foot6.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        540,
                        [
                            ['maxLen' => 25, 'x' => 18, 'y' => 821, 'size' => 24],
                            ['maxLen' => 16, 'x' => 25, 'y' => 818, 'size' => 35],
                            ['maxLen' => 10, 'x' => 35, 'y' => 815, 'size' => 50]
                        ],
                        'black',
                        '-filter_complex',
                        '-strict -2 -y',
                        ':enable=between(t\,0.35\,7)'
                    );

$abzac = 'LINEBET, LE MEILLEUR BOOKMAKER. Utilise le code <b>' . $text . '</b> et obtiens un bonus jusqu\'à 100€ sur ton 1er dépôt.
Service client 24/7 !
N\'oublie pas le code <b>' . $text . '</b> ! ';

                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                if ($file == "IN") {

                    $dataSend = array(
                        'text' => "Готово",
                        'chat_id' => $chat_id,
                        'reply_markup' => $justKeyboard,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");

                    // BG_2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/BG_2.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1050,
                        [
                            ['maxLen' => 16, 'x' => 28, 'y' => 1370, 'size' => 45],
                            ['maxLen' => 10, 'x' => 40, 'y' => 1360, 'size' => 65]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    // BG_3
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/BG_3.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1060,
                        [
                            ['maxLen' => 16, 'x' => 30, 'y' => 1580, 'size' => 45],
                            ['maxLen' => 10, 'x' => 40, 'y' => 1575, 'size' => 65]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );
                    // BG_1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/BG_1.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        1060,
                        [
                            ['maxLen' => 16, 'x' => 30, 'y' => 1518, 'size' => 45],
                            ['maxLen' => 10, 'x' => 43, 'y' => 1514, 'size' => 65]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );

                    //ind_africa
                    $this->textToImageSend($chat_id, 'assets/promo/in/ind_africa.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.9908, 1.17, 451.00472171991, 255, 255, 255);
                    //kriket_men
                    $this->textToImageSend($chat_id, 'assets/promo/in/kriket_men.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.9908, 1.17, 451.00472171991, 255, 255, 255);
                    //kriket_mens
                    $this->textToImageSend($chat_id, 'assets/promo/in/kriket_mens.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.9908, 1.17, 451.00472171991, 255, 255, 255);
                    //kriket_mens2
                    $this->textToImageSend($chat_id, 'assets/promo/in/kriket_mens2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.9908, 1.17, 451.00472171991, 255, 255, 255);

                    // BG_
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/BG_.mp4',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        500,
                        [
                            ['maxLen' => 18, 'x' => 19, 'y' => 756, 'size' => 26],
                            ['maxLen' => 15, 'x' => 24, 'y' => 754, 'size' => 33],
                            ['maxLen' => 10, 'x' => 24, 'y' => 752, 'size' => 35]
                        ],
                        'black',
                        '-vf',
                        '-strict -2 -y'
                    );

                    // vip_cash
                    $this->textToImageSend($chat_id, 'assets/promo/in/vip_cash.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.92, 1.255, 455, 255, 255, 255);
                    // card
                    $this->textToImageSend($chat_id, 'assets/promo/in/card.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 15, 2.0, 1.12, 151, 255, 255, 255);
                    // casino_monday
                    $this->textToImageSend($chat_id, 'assets/promo/in/casino_monday.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 38, 2.0, 1.173, 434.65346534653, 255, 255, 255);
                    // andar
                    $this->textToImageSend($chat_id, 'assets/promo/in/andar.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 38, 2.02, 1.29, 533.66336633663, 255, 255, 255);
                    // men
                    $this->textToImageSend($chat_id, 'assets/promo/in/men.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 32, 1.21, 1.09, 926.85123966942, 255, 255, 255);
                    // men1
                    $this->textToImageSend($chat_id, 'assets/promo/in/men1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 32, 2.03, 1.105, 405.43349753695, 255, 255, 255);
                    // men2
                    $this->textToImageSend($chat_id, 'assets/promo/in/men2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 39, 2.02, 1.075, 453.55940594059, 255, 255, 255);
                    // men3
                    $this->textToImageSend($chat_id, 'assets/promo/in/men3.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 20, 2.02, 1.16, 234.5297029703, 255, 255, 255);
                    // men4
                    $this->textToImageSend($chat_id, 'assets/promo/in/men4.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 2.0, 1.0655, 419, 255, 255, 255);
                    // squid
                    $this->textToImageSend($chat_id, 'assets/promo/in/squid.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 4.5, 1.66, 157.94444444444, 0, 0, 0);
                    // th1
                    $this->textToImageSend($chat_id, 'assets/promo/in/th1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 1.155, 1.09, 1001.2251082251, 255, 255, 255);
                    // th2
                    $this->textToImageSend($chat_id, 'assets/promo/in/th2.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 30, 1.175, 1.075, 874.6914893617, 255, 255, 255);
                    // women
                    $this->textToImageSend($chat_id, 'assets/promo/in/women.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 30, 2.02, 1.15, 258.13366336634, 255, 255, 255);
                    // women1
                    $this->textToImageSend($chat_id, 'assets/promo/in/women1.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 30, 2.02, 1.355, 428.43069306931, 255, 255, 255);
                    // photo_men
                    $this->textToImageSend($chat_id, 'assets/promo/in/photo_men.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 3.155, 1.385, 126.56576862124, 255, 255, 255);
                    // photo_women
                    $this->textToImageSend($chat_id, 'assets/promo/in/photo_women.jpg', $text, 'assets/font/ofont.ru_Solomon Sans.ttf', 35, 3.655, 1.185, 191.54993160055, 255, 255, 255);

                    // fon_20
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/fon_20.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        500,
                        [
                            ['maxLen' => 26, 'x' => 9, 'y' => 343, 'size' => 16],
                            ['maxLen' => 22, 'x' => 11, 'y' => 340, 'size' => 20]
                        ],
                        'white',
                        '-filter_complex',
                        '-y',
                        ':enable=between(t\,0\,10)'
                    );
                    // lv_0_2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/lv_0_2.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        500,
                        [
                            ['maxLen' => 26, 'x' => 11, 'y' => 379, 'size' => 16],
                            ['maxLen' => 22, 'x' => 13, 'y' => 376, 'size' => 20]
                        ],
                        'white',
                        '-filter_complex',
                        '-y',
                        ':enable=between(t\,1.2\,10)'
                    );

                    header('Content-type: text/html; charset=utf-8');

                    // gi1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/gi1.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        640,
                        [
                            ['maxLen' => 14, 'x' => 14, 'y' => 305, 'size' => 20]
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    // gi4
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/gi4.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        640,
                        [
                            ['maxLen' => 14, 'x' => 14, 'y' => 305, 'size' => 20]
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    // gi5
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/gi5.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        640,
                        [
                            ['maxLen' => 14, 'x' => 14, 'y' => 305, 'size' => 20]
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    // gi6
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/gi6.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        640,
                        [
                            ['maxLen' => 14, 'x' => 14, 'y' => 305, 'size' => 20]
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    // gi2
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/gi2.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        640,
                        [
                            ['maxLen' => 14, 'x' => 14, 'y' => 305, 'size' => 20]
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );
                    // gi1
                    $this->textToVideoSend(
                        $chat_id,
                        'assets/promo/in/gi1.gif',
                        $text,
                        'assets/font/ofont.ru_Solomon Sans.ttf',
                        640,
                        [
                            ['maxLen' => 14, 'x' => 14, 'y' => 303, 'size' => 20]
                        ],
                        'black',
                        '-filter_complex',
                        '-y'
                    );

$abzac = "  LINEBET THE BEST BOOKMAKING COMPANY!
The bookmaker you can trust!

Enter in the promocode  <b>$text</b>
and get 100% bonus on your FIRST deposit.
24/7 player support!
Don't forget about your promo code!

📲 Download mobile app👇

LINEBET सबसे अच्छी बुकिंग कंपनी!
LINEBET वह बुकमेकर जिस पर आप भरोसा कर सकते हैं!

प्रोमोकोड में दर्ज करें  <b>$text</b>
और अपनी पहली जमा राशि पर 100%  बोनस प्राप्त करें।
24/7 खिलाड़ी समर्थन!
अपने प्रोमो कोड के बारे में मत भूलना!

मोबाइल ऐप डाउनलोड करें👇 ";


                    $this->sendMessage($chat_id, $abzac);
                    $this->senddocument($chat_id, "assets/apk/linebet.apk");
                }
                $this->fpwritecount();


                $this->fwclose($chat_id);

                //$text = str_replace($st,'<b>'.$st.'</b>',$string)


                $files = glob("img/$chat_id/*"); // get all file names
                foreach ($files as $file) { // iterate files
                    if (is_file($file))
                        unlink($file); // delete file
                }
            }

            if ($message == "Ещё") {
                $dataSend = array(
                    'text' => "Выберите лого",
                    'chat_id' => $chat_id,
                    'reply_markup' => $ehe,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "<");
            }

            if ($message == "Экспресс дня") {

                if ($file == 'UZB') {
                    $lang = 'uz';
                    $img = 'img/promo/express.jpg';
                }
                if ($file == 'RUS') {
                    $lang = 'ru';
                    $img = 'img/promo/expressRu.jpg';
                }
                if ($file == 'ENG') {
                    $lang = 'en';
                    $img = 'img/promo/expressEn.jpg';
                }
                if (empty($lang)) {
                    $lang = 'en';
                    $img = 'img/promo/expressEn.jpg';
                }

                $this->sendMessage($chat_id, 'Готово', $justKeyboard);
                for ($j = 0; $j < 3; $j++) {
                    $resp = file_get_contents("https://jsonb.ru/grabber/expressDayLinebet/index.php?lang=$lang&page=$j");
                    $array = json_decode($resp, true);
                    if (!array_key_exists('error', $array)) {
                        $domen = file_get_contents('https://linebet.sytes.net/link.txt');
                        $url = "https://$domen/";

                        $express = mb_strtoupper($this->textLangArray[$lang]['express']);
                        $bonus = $this->textLangArray[$lang]['bonus'];
                        $totalKefText = $this->textLangArray[$lang]['totalKef'];
                        $event = $this->textLangArray[$lang]['event'];
                        $coefficient = $this->textLangArray[$lang]['coefficient'];
                        $viewEvent = $this->textLangArray[$lang]['viewEvent'];

                        $kefTotal = $array['collections']['cf_total'];
                        $kefBonus = $array['collections']['bonus']['koef'];

                        $text = "🔥🔥🔥<b>$express</b>" . "🔥🔥🔥\n\n";

                        $arrayExpress = $array['collections']['express'];
                        $text .= $this->selectTextExpress($arrayExpress, $lang, $event, $coefficient, $url, $viewEvent);
                        $text .= "🎁$bonus: <b>$kefBonus</b>\n<pre>.............................</pre>\n🔸 $totalKefText: <b>$kefTotal</b> 🔸";

                        $countArrayDate = count($this->arrayDate['day']);
                        array_multisort($this->arrayDate['day'], SORT_ASC);
                        if ($countArrayDate == 1) {
                            $dateTotal = $this->arrayDate['day'][0];
                        } elseif ($countArrayDate > 1) {
                            $dateTotal = '';
                            for ($i = 0; $i < $countArrayDate; $i++) {
                                $dateTotal .= $this->arrayDate['day'][$i];
                                if ($i + 1 != $countArrayDate) $dateTotal .= '-';
                            }
                        }
                        $dateTotal .= ' ' . mb_strtoupper($this->arrayMonths[$lang][$this->arrayDate['month']['0']]);

                        $this->textToImageSendExpress($chat_id, $img, $dateTotal, $kefTotal, 'assets/font/MontserratBold.ttf', 35, 0, 0, 0, 0, 0, 0, $text);
                    } else {
                        $this->sendMessage($chat_id, 'Ошибка получения данных, проверьте домен');
                    }
                }
                $files = glob("img/$chat_id/*"); // get all file names
                foreach ($files as $file) { // iterate files
                    if (is_file($file))
                        unlink($file); // delete file
                }
            }

            if ($message == "/infobot") {
                $file = file_get_contents("count.txt");
                $text = "Всего сделанных промокодов: $file";
                $this->sendMessage($chat_id, $text);
            }
            if ($message == "Старое промо") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpaddwrite($chat_id, " старое");
            }
            if ($message == "Старое промо BD") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpaddwrite($chat_id, " старое_bd");
            }
            if ($message == "Новое промо") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpaddwrite($chat_id, " новое");
            }
            if ($message == "Новое промо2") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpaddwrite($chat_id, " новое2");
            }
            if ($message == "football_kriket") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpaddwrite($chat_id, " football_kriket");
            }
            if ($message == "Ватсап") {
                $dataSend = array(
                    'text' => "Введите номер ватсап",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");

                $this->fpaddwrite($chat_id, " ватсап");
            }
            if ($message == "Телеграм") {
                $dataSend = array(
                    'text' => "Введите номер телеграм",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");

                $this->fpaddwrite($chat_id, " телеграм");
            }
            if ($message == "Картинки") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpaddwrite($chat_id, " картинки");
            }
            if ($message == "Видео") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpaddwrite($chat_id, " видео");
            }
            if ($message == "UZB 🇺🇿") {
                $dataSend = array(
                    'text' => "Выберите промо",
                    'chat_id' => $chat_id,
                    'reply_markup' => $buttons_time,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "UZB");
            }

            if ($message == "BD 🇧🇩") {
                $dataSend = array(
                    'text' => "Выберите опцию",
                    'chat_id' => $chat_id,
                    'reply_markup' => $buttons_time4,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "BD");
            }
            if ($message == "SW 🇰🇪") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "SW");
            }
            if ($message == "SO 🇸🇴") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "SO");
            }
            if ($message == "PK 🇩🇿") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "PK");
            }
            if ($message == "IN 🇮🇳") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "IN");
            }
            if ($message == "MN 🇲🇳") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "MN");
            }


            if ($message == "RUS 🇷🇺") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $express,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "RUS");
            }

            if ($message == "ENG 🇬🇧") {
                $dataSend = array(
                    'text' => "Введите название промокода",
                    'chat_id' => $chat_id,
                    'reply_markup' => $express,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "ENG");
            }
            if ($message == "FR 🇫🇷") {
                $dataSend = array(
                    'text' => "Выберите действие",
                    'chat_id' => $chat_id,
                    'reply_markup' => $buttons_time3,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fpwrite($chat_id, "FR");
            }
            

            if ($message == "Отмена") {
                $dataSend = array(
                    'text' => "Отмена действий",
                    'chat_id' => $chat_id,
                    'reply_markup' => $justKeyboard,
                );
                $this->requestToTelegram($dataSend, "sendMessage");
                $this->fwclose($chat_id);
            }
        } else {
            if ($data['message']['text'] != '/start') $this->sendMessage($chat_id, $textAd);
        }

        $linecms = 'https://line-cms.ru/wp-admin/';

        if (!file_get_contents($linecms)) {
            //            $this->sendMessage( 659025951, "не робит" );
        }
    }

    private function selectTextExpress($arrayExpress, $lang, $event, $coefficient, $url, $viewEvent)
    {
        for ($i = 0; $i < count($arrayExpress); $i++) {
            $date = $arrayExpress[$i]['date'];
            $time = $arrayExpress[$i]['time'];
            $dateAll = str_replace('.', '-', $date);
            $dateAll = $dateAll . "-" . date('Y') . " " . $time;
            $dateAll = $this->dateToTimeLang($lang, $dateAll);
            $day = date('d', $dateAll);
            $month = date('n', $dateAll);
            if (!in_array($day, $this->arrayDate['day'])) $this->arrayDate['day'][] = $day;
            if (!in_array($month, $this->arrayDate['month'])) $this->arrayDate['month'][] = $month;

            $sportEmodji = $this->sportEmodjiArray[$arrayExpress[$i]['sport_id']];
            $champ = $arrayExpress[$i]['champ'];
            $urlEvent = $arrayExpress[$i]['url'];
            $team = $arrayExpress[$i]['opp1'] . " - " . $arrayExpress[$i]['opp2'];
            $eventName = $arrayExpress[$i]['bet']['nameBet'];
            $kefEvent = $arrayExpress[$i]['bet']['koef'];
            $number = $this->arrayNumber[$i];
            $text .= "$number<u>$champ</u>\n$sportEmodji<b>$team</b>$sportEmodji\n\n✅$event: <b>$eventName</b>\n💥$coefficient: $kefEvent" . "💥\n👉<a href=\"$url$urlEvent\">$viewEvent</a>👈";
            //                if($i + 1 != count($arrayExpress)) {
            $text .= "\n<pre>.............................</pre>\n";
            //                }
        }
        return $text;
    }

    private function textToImageSendExpress($chatId, $urlImage, $text, $text_2, $font, $size, $pd, $yd, $startText, $red, $green, $blue, $caption, $angle = 0)
    {
        $namePhoto = explode('/', $urlImage);
        $namePhoto = end($namePhoto);
        $time = time();
        $namePhoto = explode('.', $namePhoto);
        $namePhoto = $namePhoto[0] . $time . "." . $namePhoto[1];
        $im = imagecreatefromjpeg($urlImage);
        $black = imagecolorallocate($im, 0, 0, 0);
        $white = imagecolorallocate($im, 255, 255, 255);
        $this->addTextImage($im, $black, $text, $font, $size, 4.3, 1.5, $startText, $angle);
        $this->addTextImage($im, $white, $text_2, $font, $size, 2.53, 1.76, $startText, $angle);
        imagejpeg($im, "img/$chatId/$namePhoto");
        imagedestroy($im);
        $this->sendphoto($chatId, "https://promobot.jsonb.ru/img/$chatId/$namePhoto", $caption);
    }

    private function addTextImage($im, $black, $text, $font, $size, $pd, $yd, $startText, $angle)
    {
        // создаем рамку вокруг текста
        $bbox = imageftbbox($size, $angle, $font, $text);
        // наши координаты для X и Y
        $px = $bbox[0] + (imagesx($im) / $pd) - ($bbox[4] / 2);
        $y = $bbox[1] + (imagesy($im) / $yd) - ($bbox[5] / 2);
        while ($px < $startText) {
            $size -= 1;
            $bbox = imageftbbox($size, 0, $font, $text);
            $px = $bbox[0] + (imagesx($im) / $pd) - ($bbox[4] / 2);
            $y = $bbox[1] + (imagesy($im) / $yd) - ($bbox[5] / 2);
        }
        imagettftext($im, $size, 0, $px, $y, $black, $font, $text);
    }

    private function dateToTimeLang($lang, $date)
    {
        switch ($lang) {
            case 'ru':
                $strtotime = strtotime("+0 hour $date");
                break;
            case 'en':
                $strtotime = strtotime("-2 hour $date");
                break;
            case 'uz':
                $strtotime = strtotime("+2 hour $date");
                break;
        }
        return $strtotime;
    }


    // добавления текста на картинку и её отправка
    private function textToImageSend($chatId, $urlImage, $text, $font, $size, $pd, $yd, $startText, $red, $green, $blue, $angle = 0)
    {
        $urlImage = $this->url_sites . $urlImage;
        $namePhoto = explode('/', $urlImage);
        $namePhoto = end($namePhoto);
        $time = time();
        $namePhoto = explode('.', $namePhoto);
        $namePhoto = $namePhoto[0] . $time . "." . $namePhoto[1];
        $im = imagecreatefromjpeg($urlImage);
        $black = imagecolorallocate($im, $red, $green, $blue);
        // создаем рамку вокруг текста
        $bbox = imageftbbox($size, $angle, $font, $text);
        // наши координаты для X и Y
        $px = $bbox[0] + (imagesx($im) / $pd) - ($bbox[4] / 2);
        $y = $bbox[1] + (imagesy($im) / $yd) - ($bbox[5] / 2);
        while ($px < $startText) {
            $size -= 1;
            $bbox = imageftbbox($size, $angle, $font, $text);
            $px = $bbox[0] + (imagesx($im) / $pd) - ($bbox[4] / 2);
            $y = $bbox[1] + (imagesy($im) / $yd) - ($bbox[5] / 2);
        }
        imagettftext($im, $size, $angle, $px, $y, $black, $font, $text);
        imagejpeg($im, "img/$chatId/$namePhoto");
        imagedestroy($im);

        $this->sendphoto($chatId, "https://promobot.jsonb.ru/img/$chatId/$namePhoto");
        return "img/$chatId/$namePhoto";
    }
    // тот же метод только вернёт путь до готовой картинки
    private function textToImageSend1($chatId, $urlImage, $text, $font, $size, $pd, $yd, $startText, $red, $green, $blue, $angle = 0)
    {
        $urlImage = $this->url_sites . $urlImage;
        $namePhoto = explode('/', $urlImage);
        $namePhoto = end($namePhoto);
        $time = time();
        $namePhoto = explode('.', $namePhoto);
        $namePhoto = $namePhoto[0] . $time . "." . $namePhoto[1];
        $im = imagecreatefromjpeg($urlImage);
        $black = imagecolorallocate($im, $red, $green, $blue);
        // создаем рамку вокруг текста
        $bbox = imageftbbox($size, $angle, $font, $text);
        // наши координаты для X и Y
        $px = $bbox[0] + (imagesx($im) / $pd) - ($bbox[4] / 2);
        $y = $bbox[1] + (imagesy($im) / $yd) - ($bbox[5] / 2);
        while ($px < $startText) {
            $size -= 1;
            $bbox = imageftbbox($size, $angle, $font, $text);
            $px = $bbox[0] + (imagesx($im) / $pd) - ($bbox[4] / 2);
            $y = $bbox[1] + (imagesy($im) / $yd) - ($bbox[5] / 2);
        }
        imagettftext($im, $size, $angle, $px, $y, $black, $font, $text);
        imagejpeg($im, "img/$chatId/$namePhoto");
        imagedestroy($im);

        // $this->sendphoto($chatId, "https://promobot.jsonb.ru/img/$chatId/$namePhoto");
        return "img/$chatId/$namePhoto";
    }
    // добавление gif и отправка
    private function textToVideoSend($chat_id, $urlVideo, $text, $font, $px, $paramsArray, $fontColor, $startFlags, $endFlags, $enable = '')
    {
        $urlVideo = $this->url_sites . $urlVideo;
        $nameVideo = explode('/', $urlVideo);
        $nameVideo = end($nameVideo);
        $time = time();
        $nameVideo = explode('.', $nameVideo);
        $nameVideo = $nameVideo[0] . $time . "." . $nameVideo[1];
        $x = $y = $size = 0;
        foreach ($paramsArray as $params) {
            if (strlen($text) <= $params['maxLen']) {
                $x = $params['x'];
                $y = $params['y'];
                $size = $params['size'];
            }
        }
        // корректировка ширины букв i, m, w (за единицу взята ширина буквы n)
        $correction = preg_match_all('/w/i', $text) * 0.32 + preg_match_all('/m/i', $text) * 0.16 + preg_match_all('/q/i', $text) * 0.22 + preg_match_all('/[go]/i', $text) * 0.08 - preg_match_all('/[i1]/i', $text) * 0.64 - preg_match_all('/[zsearfvthuk6890]/i', $text) * 0.16 - preg_match_all('/[bjp234]/i', $text) * 0.24 - preg_match_all('/[yl57]/i', $text) * 0.36;
        $resX = ($px - $x * (strlen($text) + $correction)) / 2;
        exec("/usr/bin/ffmpeg -i $urlVideo $startFlags 'drawtext=fontfile=$font:text=$text:fontcolor=$fontColor:x=$resX: y=$y: fontsize=$size$enable' $endFlags img/$chat_id/$nameVideo");
        $this->sendvideo($chat_id, "https://promobot.jsonb.ru/img/$chat_id/$nameVideo");
    }

    // Очистка файла
    private function fwclose($id)
    {
        $fd = fopen("file/$id.txt", 'w+') or die("не удалось создать файл");
        $str = "";
        fwrite($fd, $str);
        fclose($fd);
    }
    // Очистка файла
    private function fwclose2($id)
    {
        $fd = fopen("file/phone$id.txt", 'w+') or die("не удалось создать файл");
        $str = "";
        fwrite($fd, $str);
        fclose($fd);
    }
    // Очистка файла
    private function fwclose3($id)
    {
        $fd = fopen("file/number$id.txt", 'w+') or die("не удалось создать файл");
        $str = "";
        fwrite($fd, $str);
        fclose($fd);
    }

    // Запись в файл
    private function fpwrite($id, $text)
    {
        $fd = fopen("file/$id.txt", 'w+') or die("не удалось создать файл");
        $str = $text;
        fwrite($fd, $str);
        fclose($fd);
    }
    // Запись в файл
    private function fpwrite2($id, $text)
    {
        $fd = fopen("file/phone$id.txt", 'w+') or die("не удалось создать файл");
        $str = $text;
        fwrite($fd, $str);
        fclose($fd);
    }

    // Запись в файл количество сделанных промокодов
    private function fpwritecount()
    {

        $file = file_get_contents("count.txt");
        $str = $file + 1;
        file_put_contents("count.txt", $str);
    }

    // функция отправки фото
    private function sendphoto($chat_id, $text, $caption = false)
    {
        $this->requestToTelegram([
            'chat_id' => $chat_id,
            'photo' => $text,
            'caption' => $caption,
            "parse_mode" => "HTML",
        ], "sendPhoto");
    }

    // функция отправки файла
    private function senddocument($chat_id, $text)
    {
        $this->requestToTelegram([
            'chat_id' => $chat_id,
            'document' => curl_file_create($text, 'plain/apk', 'linebet.apk'),
        ], "sendDocument");
    }

    // функция отправки видео
    private function sendvideo($chat_id, $text)
    {
        $this->requestToTelegram([
            'chat_id' => $chat_id,
            'video' => $text,
        ], "sendVideo");
    }

    //проверка существование файла
    private function fwd($id)
    {
        $fd = fopen("file/$id.txt", 'r');
        return $fd;
        fclose($fd);
    }
    //проверка существование файла
    private function fwd2($id)
    {
        $fd = fopen("file/phone$id.txt", 'r');
        return $fd;
        fclose($fd);
    }
    //проверка существование файла
    private function fwd3($id)
    {
        $fd = fopen("file/number$id.txt", 'r');
        return $fd;
        fclose($fd);
    }

    //клавиатура
    private function getKeyBoard($data)
    {
        $keyboard = array(
            "keyboard" => $data,
            "one_time_keyboard" => false,
            "resize_keyboard" => true
        );
        return json_encode($keyboard);
    }

    // Дозапись в файл
    private function fpaddwrite($id, $text)
    {
        $fd = fopen("file/$id.txt", 'a+') or die("не удалось создать файл");
        $str = $text;
        fwrite($fd, $str);
        fclose($fd);
    }

    // Дозапись в файл телефона
    private function fpaddwrite2($id, $text_number)
    {
        $fd = fopen("file/phone$id.txt", 'a+') or die("не удалось создать файл");
        $str = $text_number;
        fwrite($fd, $str);
        fclose($fd);
    }
    // Дозапись в файл самого телефона
    private function fpaddwrite3($id, $number)
    {
        $fd = fopen("file/number$id.txt", 'a+') or die("не удалось создать файл");
        $str = $number;
        fwrite($fd, $str);
        fclose($fd);
    }

    // проверка на админа
    private function isAdmin($chat_id)
    {
        if (in_array($chat_id, $this->ADMIN)) {
            $text = "Привет админ";
        } else {
            $text = "PROMO ONLY FOR LINEBET PARTNERS

            🇬🇧🇬🇧🇬🇧  https://t.me/linebetpromoen        ▶️EN

            🇺🇿🇺🇿🇺🇿  https://t.me/LinebetPromo            ▶️UZ

            🇧🇩🇧🇩🇧🇩  https://t.me/LINEBETPROMOBD  ▶️BD

            🇷🇺🇷🇺🇷🇺  https://t.me/promolinebet             ▶️RU

            🇲🇳🇲🇳🇲🇳 https://t.me/linebetpromomng     ▶️MN

            🇹🇿🇰🇪🇹🇿 https://t.me/linebetpromotzke     ▶️SW

            🇫🇷🇫🇷🇫🇷 https://t.me/linebetpromofr    ▶️FR";
        }
        return $text;
    }

    // функция отправки текстового сообщения
    private function sendMessage($chat_id, $text, $buttons = false)
    {
        $this->requestToTelegram([
            'chat_id' => $chat_id,
            'text' => $text,
            "parse_mode" => "HTML",
            'reply_markup' => $buttons
        ], "sendMessage");
    }

    // общая функция загрузки картинки
    private function getPhoto($data)
    {
        // берем последнюю картинку в массиве
        $file_id = $data[count($data) - 1]['file_id'];
        // получаем file_path
        $file_path = $this->getPhotoPath($file_id);
        // возвращаем результат загрузки фото
        return $this->copyPhoto($file_path);
    }

    // функция получения метонахождения файла
    private function getPhotoPath($file_id)
    {
        // получаем объект File
        $array = json_decode($this->requestToTelegram(['file_id' => $file_id], "getFile"), TRUE);
        // возвращаем file_path
        return $array['result']['file_path'];
    }

    // функция логирования в файл
    private function setFileLog($data, $file)
    {
        $fh = fopen($file, 'a') or die('can\'t open file');
        ((is_array($data)) || (is_object($data))) ? fwrite($fh, print_r($data, TRUE) . "\n") : fwrite($fh, $data . "\n");
        fclose($fh);
    }

    /**
     * Парсим что приходит преобразуем в массив
     * @param $data
     * @return mixed
     */
    private function getData($data)
    {
        return json_decode(file_get_contents($data), TRUE);
    }

    /** Отправляем запрос в Телеграмм
     * @param $data
     * @param string $type
     * @return mixed
     */
    private function requestToTelegram($data, $type)
    {
        $result = null;

        if (is_array($data)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $this->botToken . '/' . $type);
            curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            curl_close($ch);
        }
        return $result;
    }
}
