<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class func
{
    public static function crossposting($login, $password, $text, $mood='normal', $header='')
    {
        // Кросспостинг в ЖЖ
        define('LJ_HOST',   'www.livejournal.com');
        define('LJ_PATH',   '/interface/xmlrpc');
        // Создаем xml-rpc клиента
        $ljClient = new IXR_Client(LJ_HOST, LJ_PATH);
        // Посылаем challange-запрос (что такое - читайте ниже)
        if (!$ljClient->query('LJ.XMLRPC.getchallenge')) {
            //echo 'Ошибка [' . $ljClient->getErrorCode().'] '.$ljClient->getErrorMessage();
        }
        else {
            // Получаем ответ
            $ljResponse = $ljClient->getResponse();
            // Вытягиваем challenge
            $ljChallenge = $ljResponse['challenge'];
            // Заполняем поля XML-запроса
            $ljArgs = array();
            // Имя пользователя
            $ljArgs['username']       = $login;
            // Указываем способ идентификации
            $ljArgs['auth_method']    = 'challenge';
            // Указываем полученный challenge
            $ljArgs['auth_challenge'] = $ljChallenge;
            // Посылаем зафрованный пароль
            // формула md5(challenge + md5(password))
            $ljArgs['auth_response']  = md5($ljChallenge . md5($password));
            // Версия протокола, 1 - все данные в кодировке UTF-8
            $ljArgs['ver']            = "1";
            // Текст записи (перекодируем из windows-1251 в UTF-8)
            $ljArgs['event']          = $text; //iconv('windows-1251', 'UTF-8', $text);
            // Заголовок записи (перекодируем из windows-1251 в UTF-8)
            $ljArgs['subject']        = $header; //iconv('windows-1251', 'UTF-8', $header);
//            // Дата
            $ljArgs['year']           = date('Y'); // год
            $ljArgs['mon']            = date('n'); // месяц
            $ljArgs['day']            = date('d'); // день
            $ljArgs['hour']           = date('G'); // часы
            $ljArgs['min']            = date('i'); // минуты
            // Доп параметры
            $ljArgs['props']          = array(
                                            // Текст уже отформатирован (содержит HTML-теги)
                                            'opt_preformatted' => true,
                                            // Добавляем запись "задним числом"
                                            'opt_backdated'    => false,
                                            'current_mood' => $mood
                                        );
            // Доступность записи - доступна всем (по-умолчанию)
            $ljArgs['security']       = 'public';
            // Добавляем новое сообщение
            $ljMethod = 'LJ.XMLRPC.postevent';
            // Посылаем запрос
            if (!$ljClient->query($ljMethod, $ljArgs)) {
                //echo 'Ошибка ['.$ljClient->getErrorCode().'] '.$ljClient->getErrorMessage();
            }
            else {
                // Получаем ответ
                $ljResponse = $ljClient->getResponse();
                //echo $ljResponse;
            }
        }
    }
}
?>
