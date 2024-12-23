<?php

namespace App\Jobs;


class SMS extends Job{

    private $version = '1.9';

    private $api_url = 'https://userarea.sms-assistent.by/';
    private $user_login = '';
    private $user_password = '';
    private $user_token = '';
    private $webhook_url = '';
    private $subscribe_name = '';

    private $api_mode = 'json';

    private $error = 0;
    private $error_messages = array();

    function __construct($login, $password, $token = '')
    {

        $this->user_login = $login;
        $this->user_password = $password;
        $this->user_token = $token;

    }

    public function postContent($url, $postdata, $content_type = '')
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');

        $header = [];
        switch ($content_type) {

            case 'text/json' :
            case 'text/xml' :
            {

                $header = [
                    'Content-Type: ' . $content_type
                ];
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                break;
            }

        }

        if (!empty($this->user_token)) {

            $header[] = 'requestAuthToken: ' . $this->user_token;
            if (isset($postdata['password'])) {

                unset($postdata['password']);

            }

        }

        if (count($header) > 0) {

            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        $res_info = curl_exec($curl);

        $res = array(
            'curl_info' => curl_getinfo($curl),
            'curl_error' => curl_errno($curl),
            'curl_error_message' => curl_error($curl),
            'curl_result' => $res_info
        );

        curl_close($curl); // close the connection

        return $res;

    }

    public function getBalance()
    {

        $url = $this->api_url . 'api/v1.2/credits/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password
        );

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_balance');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    public function sendHlr($tels)
    {

        if ((is_array($tels)) || ($template_id !== false)) {

            if (!is_array($tels)) {

                $tels = array($tels);

            }

            switch ($this->api_mode) {

                // case 'xml' : return $this->sendHlrXML($tels); break;
                case 'json' :
                    return $this->sendHlrJson($tels);
                    break;

            }

        } else {

            // return $this->sendHlrPlain($tels);

        }

    }

    public function sendSms($sender, $tels, $sms_text, $sms_live = '48', $date_send = false, $template_id = false, $tags_replace = false)
    {

        if ((is_array($tels)) || ($template_id !== false)) {

            if (!is_array($tels)) $tels = array($tels);

            switch ($this->api_mode) {

                case 'xml' :
                    return $this->sendSmsXML($sender, $tels, $sms_text, $sms_live, $date_send, $template_id, $tags_replace);
                    break;
                case 'json' :
                    return $this->sendSmsJson($sender, $tels, $sms_text, $sms_live, $date_send, $template_id, $tags_replace);
                    break;

            }

        } else {

            return $this->sendSmsPlain($sender, $tels, $sms_text, $sms_live, $date_send, $template_id, $tags_replace);

        }

    }

    /**
     * Отправить вайбер сообщение
     * @param string $sender - отправитель Viber
     * @param string|array $tels - получатели сообщений в виде строчки или массива, если необходимо несколько
     * @param string $message_text - текст Viber сообщения
     * @param int $message_live - срок жизни сообщения в часах
     * @param bool|string $date_send - дата отправки сообщения в формате ГГГГММДДЧЧММ, false - если нужно отправить мгновенно
     * @param array $viber_rich - массив с параметрами рекламного сообщения. Все параметры обязательны, если планируется рекламное сообщение.
     * viber_image - URL изображения в формате JPG, JPEG, PNG
     * viber_button - наименование кнопки в сообщении
     * viber_url - URL с информацией, на который осуществляется переход после нажатия на кнопку
     * @param array $sms_resend - массив с параметрами для отправки SMS, в случае недоставки по Viber. Все параметры обязательны, если планируется отправка SMS
     * sms_sender - отправитель SMS
     * sms_text - текст SMS
     * @return array
     */
    public function sendViber(string $sender, $tels, string $message_text, int $message_live = 48, $date_send = false, array $viber_rich = [], array $sms_resend = [])
    {

        if (is_array($tels)) {

            switch ($this->api_mode) {

                case 'xml' :
                    return $this->sendViberXML($sender, $tels, $message_text, $message_live, $date_send, $viber_rich, $sms_resend);
                    break;
                case 'json' :
                    return $this->sendViberJson($sender, $tels, $message_text, $message_live, $date_send, $viber_rich, $sms_resend);
                    break;

            }

        } else {

            return $this->sendViberPlain($sender, $tels, $message_text, $message_live, $date_send, $viber_rich, $sms_resend);

        }

    }

    public function getHlrStatus($hlr_codes)
    {

        if (is_array($hlr_codes)) {

            switch ($this->api_mode) {

                // case 'xml' : return $this->getHlrStatusXML($hlr_codes); break;
                case 'json' :
                    return $this->getHlrStatusJson($hlr_codes);
                    break;

            }

        } else {

            // return $this->getHlrStatusPlain($hlr_codes);

        }

        return false;

    }

    public function getSmsStatus($sms_codes)
    {

        if (is_array($sms_codes)) {

            switch ($this->api_mode) {

                case 'xml' :
                    return $this->getSmsStatusXML($sms_codes);
                    break;
                case 'json' :
                    return $this->getSmsStatusJson($sms_codes);
                    break;

            }

        } else {

            return $this->getSmsStatusPlain($sms_codes);

        }

    }

    /**
     * Получить статусы по Viber сообщениям
     * @param array|int $viber_codes
     */
    public function getViberStatus($viber_codes)
    {

        if (is_array($viber_codes)) {

            switch ($this->api_mode) {

                case 'xml' :
                    return $this->getViberStatusXML($viber_codes);
                    break;
                case 'json' :
                    return $this->getViberStatusJson($viber_codes);
                    break;

            }

        } else {

            return $this->getViberStatusPlain($viber_codes);

        }

    }

    private function sendSmsPlain($sender, $tel, $sms_text, $sms_live = 48, $date_send = false)
    {

        $url = $this->api_url . 'api/v1.2/send_sms/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password,
            'sender' => $sender,
            'recipient' => $tel,
            'message' => $sms_text,
            'validity_period' => $sms_live
        );

        if (!empty($this->webhook_url)) {

            $postdata['webhook_url'] = $this->webhook_url;

        }

        if (!empty($this->subscribe_name)) {

            $postdata['name'] = $this->subscribe_name;

        }

        if ($date_send !== false) {

            $postdata['date_send'] = $date_send;

        }

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_send');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res,
            'type' => 'plain'
        );

    }

    private function sendViberPlain($sender, $tel, $message_text, $message_live = 48, $date_send = false, array $viber_rich = [], array $sms_resend = [])
    {

        $url = $this->api_url . 'api/v1.2/send_viber/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password,
            'sender' => $sender,
            'recipient' => $tel,
            'message' => $message_text,
            'validity_period' => $message_live
        );

        if (count($viber_rich) > 0) {

            $postdata['viber_image'] = $viber_rich['viber_image'];
            $postdata['viber_button_caption'] = $viber_rich['viber_button'];
            $postdata['viber_button_url'] = $viber_rich['viber_url'];

        }

        if (count($sms_resend) > 0) {

            $postdata['viber_sms_resend'] = 1;
            $postdata['viber_sms_text'] = $sms_resend['sms_text'];
            $postdata['viber_sms_sender'] = $sms_resend['sms_sender'];

        }

        if (!empty($this->webhook_url)) {

            $postdata['webhook_url'] = $this->webhook_url;

        }

        if (!empty($this->subscribe_name)) {

            $postdata['name'] = $this->subscribe_name;

        }

        if ($date_send !== false) {

            $postdata['date_send'] = $date_send;

        }

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_viber_send');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res,
            'type' => 'plain'
        );

    }

    private function sendSmsXML($sender, $tels, $sms_text, $sms_live = '48', $date_send = false, $template_id = false, $tags_replace = false)
    {

        $url = $this->api_url . 'api/v1.2/xml';

        if ((is_array($sms_text)) && (count($sms_text) != count($tels))) {

            $this->error = 1;
            $this->error_messages[] = $this->getErrorByCode(-100);

        }

        if ((is_array($template_id)) && (count($template_id) != count($template_id))) {

            $this->error = 1;
            $this->error_messages[] = $this->getErrorByCode(-101);

        }

        if ($this->error == 0) {

            $tags_replace_str = '';
            if ($tags_replace !== false) {

                if ((is_array($tags_replace)) && (count($tags_replace) > 0)) {

                    $tags_replace_arr_str = array();

                    foreach ($tags_replace as $k_tag => $v_tag) {

                        $tags_replace_arr_str[] = $k_tag . '::' . $v_tag;

                    }

                    $tags_replace_str = ' tags_replace = "' . implode($tags_replace_arr_str, ';;') . '"';

                }

            }

            $postdata = '<?xml version="1.0" encoding="UTF-8"?>
                    <package login="' . $this->user_login . '" password="' . $this->user_password . '" ' . (($date_send !== false) ? 'date_send="' . $date_send . '"' : '') . ' ' . ((!empty($this->subscribe_name)) ? 'name="' . $this->subscribe_name . '"' : '') . ' ' . ((!empty($this->webhook_url)) ? 'webhook_url="' . $this->webhook_url . '"' : '') . '>
                            <message>
            ';

            foreach ($tels as $k => $tel) {

                $template_str = '';
                if ($template_id !== false) {

                    $template_str .= ' template_id = "' . ((is_array($template_id)) ? $template_id[$k] : (int)$template_id) . '" ';

                }

                $postdata .= '<msg recipient="' . $tel . '" sender="' . $sender . '" validity_period="' . $sms_live . '" ' . $template_str . ' ' . $tags_replace_str . '>' . ((is_array($sms_text)) ? $sms_text[$k] : $sms_text) . '</msg>';

            }

            $postdata .= '	</message>
                    </package>
            ';

            $res = $this->postContent($url, $postdata, 'text/xml');

            $res = $this->getResult($res, 'xml_send');

        }

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res,
            'type' => 'xml'
        );

    }

    private function sendViberXML($sender, $tels, $message_text, $message_live = '48', $date_send = false, array $viber_rich = [], array $sms_resend = [])
    {

        $url = $this->api_url . 'api/v1.2/xml';

        if ($this->error == 0) {

            $postdata = '<?xml version="1.0" encoding="UTF-8"?>
                    <package command="viber_send" login="' . $this->user_login . '" password="' . $this->user_password . '" ' . (($date_send !== false) ? 'date_send="' . $date_send . '"' : '') . ' ' . ((!empty($this->subscribe_name)) ? 'name="' . $this->subscribe_name . '"' : '') . ' ' . ((!empty($this->webhook_url)) ? 'webhook_url="' . $this->webhook_url . '"' : '') . (((!empty($sms_resend))) ? ' viber_sms_resend = "1"' : '') . (((!empty($sms_resend)) && (isset($sms_resend['sms_sender']))) ? ' viber_sms_sender = "' . trim($sms_resend['sms_sender']) . '"' : '') . (((!empty($viber_rich)) && (isset($viber_rich['viber_image']))) ? ' viber_image = "' . trim($viber_rich['viber_image']) . '"' : '') . (((!empty($viber_rich)) && (isset($viber_rich['viber_button']))) ? ' viber_button_caption = "' . trim($viber_rich['viber_button']) . '"' : '') . (((!empty($viber_rich)) && (isset($viber_rich['viber_url']))) ? ' viber_button_url = "' . trim($viber_rich['viber_url']) . '"' : '') . '>
                            <message>
            ';

            foreach ($tels as $k => $tel) {

                $postdata .= '<msg recipient="' . $tel . '" sender="' . $sender . '" validity_period="' . $message_live . '" ' . (((!empty($sms_resend)) && (isset($sms_resend['sms_text']))) ? ' sms_text = "' . trim($sms_resend['sms_text']) . '"' : '') . '>' . $message_text . '</msg>';

            }

            $postdata .= '	</message>
                    </package>
            ';

            $res = $this->postContent($url, $postdata, 'text/xml');

            $res = $this->getResult($res, 'xml_send_viber');

        }

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res,
            'type' => 'xml'
        );

    }

    private function sendHlrJson($tels)
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'hlr_send'
        );

        if (!empty($this->webhook_url)) {

            $postdata['webhook_url'] = $this->webhook_url;

        }

        if ($this->error == 0) {

            foreach ($tels as $k => $v_tel) {

                $postdata['message']['msg'][] = $v_tel;

            }

            $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

            $res = $this->postContent($url, $json_postdata, 'text/json');

            $res = $this->getResult($res, 'json_hlr_send');

            return array(
                'error' => $this->error,
                'error_messages' => $this->error_messages,
                'result' => $res,
                'type' => 'json'
            );

        }

    }

    private function sendSmsJson($sender, $tels, $sms_text, $sms_live = '48', $date_send = false, $template_id = false, $tags_replace = false)
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'sms_send',
            'date_send' => $date_send,
            'message' => array(
                'msg' => array()
            )
        );

        if (!empty($this->subscribe_name)) {

            $postdata['name'] = $this->subscribe_name;

        }

        if (!empty($this->webhook_url)) {

            $postdata['webhook_url'] = $this->webhook_url;

        }

        if ((is_array($sms_text)) && (count($sms_text) != count($tels))) {

            $this->error = 1;
            $this->error_messages[] = $this->getErrorByCode(-100);

        }

        if ((is_array($template_id)) && (count($template_id) != count($template_id))) {

            $this->error = 1;
            $this->error_messages[] = $this->getErrorByCode(-101);

        }

        if ($this->error == 0) {

            foreach ($tels as $k => $v_tel) {

                $postdata['message']['msg'][] = array(
                    'recepient' => $v_tel,
                    'validity_period' => $sms_live,
                    'sms_text' => ((is_array($sms_text)) ? $sms_text[$k] : $sms_text),
                    'sender' => $sender
                );

                if ($template_id !== false) {

                    $postdata['message']['msg'][count($postdata['message']['msg']) - 1]['template_id'] = (is_array($template_id)) ? $template_id[$k] : $template_id;

                }

                if ($tags_replace !== false) {

                    $postdata['message']['msg'][count($postdata['message']['msg']) - 1]['tags_replace'] = $tags_replace;

                }
            }

            $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

            $res = $this->postContent($url, $json_postdata, 'text/json');

            $res = $this->getResult($res, 'json_send');

            return array(
                'error' => $this->error,
                'error_messages' => $this->error_messages,
                'result' => $res,
                'type' => 'json'
            );

        }

    }

    private function sendViberJson($sender, $tels, $message_text, $message_live = '48', $date_send = false, array $viber_rich = [], array $sms_resend = [])
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'viber_send',
            'message' => array(
                'msg' => array()
            )
        );

        if ($date_send !== false) {

            $postdata['date_send'] = $date_send;

        }

        if (count($viber_rich) > 0) {

            $postdata['viber_image'] = $viber_rich['viber_image'];
            $postdata['viber_button_caption'] = $viber_rich['viber_button'];
            $postdata['viber_button_url'] = $viber_rich['viber_url'];

        }

        if (count($sms_resend) > 0) {

            $postdata['viber_sms_resend'] = 1;
            $postdata['viber_sms_text'] = $sms_resend['sms_text'];
            $postdata['viber_sms_sender'] = $sms_resend['sms_sender'];

        }

        if (!empty($this->subscribe_name)) {

            $postdata['name'] = $this->subscribe_name;

        }

        if (!empty($this->webhook_url)) {

            $postdata['webhook_url'] = $this->webhook_url;

        }

        if ($this->error == 0) {

            foreach ($tels as $v_tel) {

                if (count($sms_resend) > 0) {

                    $postdata['message']['msg'][] = array(
                        'recepient' => $v_tel,
                        'validity_period' => $message_live,
                        'viber_text' => $message_text,
                        'viber_sms_text' => $sms_resend['sms_text'],
                        'sender' => $sender
                    );

                } else {

                    $postdata['message']['msg'][] = array(
                        'recepient' => $v_tel,
                        'validity_period' => $message_live,
                        'viber_text' => $message_text,
                        'sender' => $sender
                    );

                }

            }

            var_dump($postdata);

            $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

            $res = $this->postContent($url, $json_postdata, 'text/json');

            $res = $this->getResult($res, 'json_viber_send');

            return array(
                'error' => $this->error,
                'error_messages' => $this->error_messages,
                'result' => $res,
                'type' => 'json'
            );

        }

    }

    private function getSmsStatusPlain($sms_code)
    {

        $url = $this->api_url . 'api/v1.2/statuses/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password,
            'id' => $sms_code
        );

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_status', array('sms_code' => $sms_code));

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    private function getViberStatusPlain($viber_code)
    {

        $url = $this->api_url . 'api/v1.2/status_viber/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password,
            'message_id' => $viber_code
        );

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_status_viber', array('viber_code' => $viber_code));

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    function getSmsStatusXML($sms_codes)
    {

        $url = $this->api_url . 'api/v1.2/xml';

        $postdata = '<?xml version="1.0" encoding="UTF-8"?>
                    <package login="' . $this->user_login . '" password="' . $this->user_password . '">
                            <status>
            ';

        foreach ($sms_codes as $k => $sms_code) {

            $postdata .= '<msg sms_id="' . $sms_code . '"/>';

        }

        $postdata .= '	</status>
                    </package>
            ';

        $res = $this->postContent($url, $postdata, 'text/xml');

        $res = $this->getResult($res, 'xml_status');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    function getViberStatusXML($viber_codes)
    {

        $url = $this->api_url . 'api/v1.2/xml';

        $postdata = '<?xml version="1.0" encoding="UTF-8"?>
                    <package command="viber_status" login="' . $this->user_login . '" password="' . $this->user_password . '">
                            <status>
            ';

        foreach ($viber_codes as $k => $v_code) {

            $postdata .= '<msg message_id="' . $v_code . '"/>';

        }

        $postdata .= '	</status>
                    </package>
            ';

        $res = $this->postContent($url, $postdata, 'text/xml');

        $res = $this->getResult($res, 'xml_status_viber');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    public function getHlrStatusJson($hlr_codes)
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'hlr_status',
            'status' => array(
                'msg' => array()
            )
        );

        foreach ($hlr_codes as $k => $hlr_code) {

            $postdata['status']['msg'][] = array(
                'hlr_code' => $hlr_code
            );

        }

        $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

        $res = $this->postContent($url, $json_postdata, 'text/json');

        $res = $this->getResult($res, 'json_hlr_status');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    public function getSmsStatusJson($sms_codes)
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'statuses',
            'status' => array(
                'msg' => array()
            )
        );

        foreach ($sms_codes as $k => $sms_code) {

            $postdata['status']['msg'][] = array(
                'sms_id' => $sms_code
            );

        }

        $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

        $res = $this->postContent($url, $json_postdata, 'text/json');

        $res = $this->getResult($res, 'json_status');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    public function getViberStatusJson($viber_codes)
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'viber_status',
            'status' => array(
                'msg' => array()
            )
        );

        foreach ($viber_codes as $v_code) {

            $postdata['status']['msg'][] = $v_code;

        }

        $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

        $res = $this->postContent($url, $json_postdata, 'text/json');

        $res = $this->getResult($res, 'json_status_viber');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    public function getSenders()
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'get_senders'
        );

        $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

        $res = $this->postContent($url, $json_postdata, 'text/json');

        $res = $this->getResult($res, 'json_senders');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    public function getTemplates()
    {

        $url = $this->api_url . 'api/v1.2/json';

        $postdata = array(
            'login' => $this->user_login,
            'password' => $this->user_password,
            'command' => 'get_templates'
        );

        $json_postdata = json_encode($postdata, JSON_UNESCAPED_UNICODE);

        $res = $this->postContent($url, $json_postdata, 'text/json');

        $res = $this->getResult($res, 'json_templates');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res
        );

    }

    private function getResult($result, $rtype, $params = array())
    {

        $f_res = false;

        if ((int)$result['curl_error'] == 0) {

            switch ($rtype) {

                case 'plain_viber_send' :
                {

                    if ((int)$result['curl_result'] < 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                    } else {

                        $f_res[] = array(
                            'message_code' => (int)$result['curl_result'],
                            'message_count' => 0,
                            'message_error' => 0,
                            'messaqe_error_code' => 0,
                            'message_error_msg' => '',
                            'operator_code' => 0
                        );

                    }
                    break;

                }

                case 'plain_send' :
                {

                    if ((int)$result['curl_result'] < 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                    } else {

                        $f_res[] = array(
                            'sms_code' => (int)$result['curl_result'],
                            'sms_count' => 0,
                            'sms_error' => 0,
                            'sms_error_code' => 0,
                            'sms_error_msg' => '',
                            'operator_code' => 0
                        );

                    }
                    break;

                }

                case 'plain_balance' :
                {

                    if ((int)$result['curl_result'] < 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                    } else {

                        $f_res = $result['curl_result'];

                    }
                    break;

                }

                case 'plain_status' :
                {

                    if ((int)$result['curl_result'] != 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                    } else {

                        $f_res[] = array(
                            'sms_code' => $params['sms_code'],
                            'sms_count' => 0,
                            'sms_status' => $result['curl_result'],
                            'operator_code' => 0,
                            'sms_tel' => ''
                        );

                    }

                    break;

                }

                case 'plain_status_viber' :
                {

                    if ((int)$result['curl_result'] != 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                    } else {

                        $f_res[] = array(
                            'message_code' => $params['message_code'],
                            'message_count' => 0,
                            'message_status' => $result['curl_result'],
                            'operator_code' => 0,
                            'message_tel' => ''
                        );

                    }

                    break;

                }

                case 'plain_check_telephone' :
                {

                    if ((int)$result['curl_result'] < 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                    }

                    $f_res = array(
                        'check_hash' => $result['curl_result']
                    );

                    break;

                }

                case 'plain_check_code' :
                {

                    if ($result['curl_result'] < 0) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($result['curl_result']);

                        $f_res = array(
                            'result' => $result['curl_result']
                        );

                    }

                    $f_res = array(
                        'check_telephone' => $result['curl_result']
                    );

                    break;

                }

                case 'xml_send' :
                {

                    $f_res = array();

                    $valid = @simplexml_load_string($result['curl_result'], null, LIBXML_NOCDATA);
                    if ($valid) {

                        if (isset($valid->error)) {

                            $this->error = 1;
                            $this->error_messages[] = $this->getErrorByCode($valid->error);

                        } elseif (isset($valid->message)) {

                            if (count($valid->message->msg) > 0) {

                                foreach ($valid->message->msg as $k => $v_msg) {

                                    $f_res[] = array(
                                        'sms_code' => (int)$v_msg->attributes()->sms_id,
                                        'sms_count' => (int)$v_msg->attributes()->sms_count,
                                        'sms_error' => ((int)$v_msg->attributes()->sms_id == 0) ? 1 : 0,
                                        'sms_error_code' => ((int)$v_msg->attributes()->sms_id == 0) ? (int)$v_msg : 0,
                                        'sms_error_msg' => ((int)$v_msg->attributes()->sms_id == 0) ? $this->getErrorByCode($v_msg) : '',
                                        'operator_code' => (int)$v_msg->attributes()->operator,
                                        'sms_tel' => '' . $v_msg->attributes()->recipient
                                    );

                                }

                            }

                        } else {

                            $this->error = 1;
                            $this->error_messages[] = $this->getErrorByCode(-10);

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'xml_send_viber' :
                {

                    $f_res = array();

                    $valid = @simplexml_load_string($result['curl_result'], null, LIBXML_NOCDATA);
                    if ($valid) {

                        if (isset($valid->error)) {

                            $this->error = 1;
                            $this->error_messages[] = $this->getErrorByCode($valid->error);

                        } elseif (isset($valid->message)) {

                            if (count($valid->message->msg) > 0) {

                                foreach ($valid->message->msg as $k => $v_msg) {

                                    $f_res[] = array(
                                        'message_code' => (int)$v_msg->attributes()->message_id,
                                        'message_count' => (int)$v_msg->attributes()->message_count,
                                        'message_error' => ((int)$v_msg->attributes()->message_id == 0) ? 1 : 0,
                                        'message_error_code' => ((int)$v_msg->attributes()->message_id == 0) ? (int)$v_msg : 0,
                                        'message_error_msg' => ((int)$v_msg->attributes()->message_id == 0) ? $this->getErrorByCode($v_msg) : '',
                                        'operator_code' => (int)$v_msg->attributes()->operator,
                                        'message_tel' => '' . $v_msg->attributes()->recipient
                                    );

                                }

                            }

                        } else {

                            $this->error = 1;
                            $this->error_messages[] = $this->getErrorByCode(-10);

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'xml_status' :
                {

                    $f_res = array();

                    $valid = @simplexml_load_string($result['curl_result'], null, LIBXML_NOCDATA);
                    if ($valid) {

                        if (isset($valid->error)) {

                            $this->error = 1;
                            $this->error_messages[] = $this->getErrorByCode($valid->error);

                        } elseif (isset($valid->status)) {

                            if (count($valid->status->msg) > 0) {

                                foreach ($valid->status->msg as $k => $v_msg) {

                                    $f_res[] = array(
                                        'sms_code' => (int)$v_msg->attributes()->sms_id,
                                        'sms_count' => (int)$v_msg->attributes()->sms_count,
                                        'sms_status' => '' . $v_msg,
                                        'operator_code' => (int)$v_msg->attributes()->operator,
                                        'sms_tel' => '' . $v_msg->attributes()->recipient
                                    );

                                }

                            }

                        } else {

                            $this->error = 1;
                            $this->error_messages[] = $this->getErrorByCode(-10);

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'xml_status_viber' : {

                    $f_res = array();

                    $valid = @simplexml_load_string($result['curl_result'], null, LIBXML_NOCDATA);
                    if ($valid) {

                        if (isset($valid->error)) {

                            $this->error = 1;
                            $this->error_messages[] = $this->getErrorByCode($valid->error);

                        } elseif (isset($valid->status)) {

                            if (count($valid->status->msg) > 0) {

                                foreach ($valid->status->msg as $k => $v_msg) {

                                    $f_res[] = array(
                                        'message_code' => (int)$v_msg->attributes()->message_id,
                                        'message_count' => 1,
                                        'message_status' => '' . $v_msg,
                                        'operator_code' => (int)$v_msg->attributes()->operator,
                                        'message_tel' => '' . $v_msg->attributes()->recipient
                                    );

                                }

                            }

                        } else {

                            $this->error = 1;
                            $this->error_messages[] = $this->getErrorByCode(-10);

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'json_send' :
                {

                    $f_res = array();

                    $json_res = json_decode($result['curl_result']);

                    if (isset($json_res->error)) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($json_res->error);

                    } elseif (isset($json_res->message)) {

                        if (count($json_res->message->msg) > 0) {

                            foreach ($json_res->message->msg as $k => $v_msg) {

                                $f_res[] = array(
                                    'sms_code' => (int)$v_msg->sms_id,
                                    'sms_count' => (int)$v_msg->sms_count,
                                    'sms_error' => ((int)$v_msg->sms_id == 0) ? 1 : 0,
                                    'sms_error_code' => ((int)$v_msg->sms_id == 0) ? $v_msg->error_code : 0,
                                    'sms_error_msg' => ((int)$v_msg->sms_id == 0) ? $this->getErrorByCode($v_msg->error_code) : '',
                                    'operator_code' => (int)$v_msg->operator,
                                    'sms_tel' => $v_msg->recipient
                                );

                            }

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'json_viber_send' :
                {

                    $f_res = array();

                    $json_res = json_decode($result['curl_result']);

                    if (isset($json_res->error)) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($json_res->error);

                    } elseif (isset($json_res->message)) {

                        if (count($json_res->message->msg) > 0) {

                            foreach ($json_res->message->msg as $k => $v_msg) {

                                $f_res[] = array(
                                    'message_code' => (int)$v_msg->message_id,
                                    'message_count' => (int)$v_msg->message_count,
                                    'message_error' => ((int)$v_msg->message_id == 0) ? 1 : 0,
                                    'message_error_code' => ((int)$v_msg->message_id == 0) ? $v_msg->error_code : 0,
                                    'message_error_msg' => ((int)$v_msg->message_id == 0) ? $this->getErrorByCode($v_msg->error_code) : '',
                                    'operator_code' => (int)$v_msg->operator,
                                    'message_tel' => $v_msg->recipient
                                );

                            }

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'json_status' :
                {

                    $f_res = array();

                    $json_res = json_decode($result['curl_result']);

                    if (isset($json_res->error)) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($json_res->error);

                    } elseif (isset($json_res->status)) {

                        if (count($json_res->status->msg) > 0) {

                            foreach ($json_res->status->msg as $k => $v_msg) {

                                $f_res[] = array(
                                    'sms_code' => (int)$v_msg->sms_id,
                                    'sms_count' => (int)$v_msg->sms_count,
                                    'sms_status' => $v_msg->sms_status,
                                    'operator_code' => (int)$v_msg->operator,
                                    'sms_tel' => '' . $v_msg->recipient
                                );

                            }

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'json_status_viber' :
                {

                    $f_res = array();

                    $json_res = json_decode($result['curl_result']);

                    if (isset($json_res->error)) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($json_res->error);

                    } elseif (isset($json_res->status)) {

                        if (count($json_res->status->msg) > 0) {

                            foreach ($json_res->status->msg as $k => $v_msg) {

                                $f_res[] = array(
                                    'message_code' => (int)$v_msg->message_id,
                                    'message_count' => 1,
                                    'message_status' => $v_msg->message_status,
                                    'operator_code' => (int)$v_msg->operator,
                                    'message_tel' => '' . $v_msg->recipient
                                );

                            }

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'json_templates' :
                case 'json_senders' :
                {

                    $f_res = array();

                    $json_res = json_decode($result['curl_result']);

                    if (isset($json_res->error)) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($json_res->error);

                    } elseif (isset($json_res)) {

                        $f_res = $json_res;

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'json_hlr_send' :
                {

                    $f_res = array();

                    $json_res = json_decode($result['curl_result']);

                    if (isset($json_res->error)) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($json_res->error);

                    } elseif (isset($json_res->message)) {

                        if (count($json_res->message->msg) > 0) {

                            foreach ($json_res->message->msg as $k => $v_msg) {

                                $f_res[] = array(
                                    'hlr_code' => (int)$v_msg->hlr_code,
                                    'sms_error' => ((int)$v_msg->hlr_code == 0) ? 1 : 0,
                                    'sms_error_code' => ((int)$v_msg->hlr_code == 0) ? $v_msg->error_code : 0,
                                    'sms_error_msg' => ((int)$v_msg->hlr_code == 0) ? $this->getErrorByCode($v_msg->error_code) : '',
                                    'sms_tel' => $v_msg->recipient
                                );

                            }

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

                case 'json_hlr_status' :
                {

                    $f_res = array();

                    $json_res = json_decode($result['curl_result']);

                    if (isset($json_res->error)) {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode($json_res->error);

                    } elseif (isset($json_res->status)) {

                        if (count($json_res->status->msg) > 0) {

                            foreach ($json_res->status->msg as $k => $v_msg) {

                                $f_res[] = array(
                                    'error' => (int)$v_msg->error,
                                    'hlr_id' => (int)$v_msg->hlr_id,
                                    'hlr_status' => $v_msg->hlr_status,
                                    'recipient' => $v_msg->recipient,
                                    'hlr_error_code' => $v_msg->hlr_error_code,
                                    'hlr_error_name' => $v_msg->hlr_error_name,
                                    'hlr_error_desc' => $v_msg->hlr_error_desc,
                                    'hlr_error_permanent' => $v_msg->hlr_error_permanent,
                                    'hlr_original_tp_name' => $v_msg->hlr_original_tp_name,
                                    'hlr_original_tp_prefix' => $v_msg->hlr_original_tp_prefix,
                                    'hlr_original_c_name' => $v_msg->hlr_original_c_name,
                                    'hlr_original_c_prefix' => $v_msg->hlr_original_c_prefix,
                                    'hlr_ported' => $v_msg->hlr_ported,
                                    'hlr_ported_tp_name' => $v_msg->hlr_ported_tp_name,
                                    'hlr_ported_tp_prefix' => $v_msg->hlr_ported_tp_prefix,
                                    'hlr_ported_c_name' => $v_msg->hlr_ported_c_name,
                                    'hlr_ported_c_prefix' => $v_msg->hlr_ported_c_prefix
                                );

                            }

                        }

                    } else {

                        $this->error = 1;
                        $this->error_messages[] = $this->getErrorByCode(-10);

                    }

                    break;

                }

            }

        } else {

            $this->error = 1;
            $this->error_messages[] = 'Ошибка выполнения запроса к API серверу. Код ошибки CURL - ' . $result['curl_error'] . '. Пояснение по ошибке: ' . $result['curl_error_message'];

        }

        return $f_res;

    }

    private function getErrorByCode($error_code)
    {

        $f_res = '';

        switch ($error_code) {

            case '-1' :
                $f_res = 'Недостаточно средств';
                break;
            case '-2' :
                $f_res = 'Неверный логин или пароль, или другая ошибка аутентификации.';
                break;
            case '-3' :
                $f_res = 'Отсутствует текст сообщения';
                break;
            case '-4' :
                $f_res = 'Некорректное значение номера получателя';
                break;
            case '-5' :
                $f_res = 'Некорректное значение отправителя сообщения';
                break;
            case '-6' :
                $f_res = 'Отсутствует логин';
                break;
            case '-7' :
                $f_res = 'Отсутствует пароль';
                break;
            case '-10' :
                $f_res = 'Ошибка целосности или валидности пакета';
                break;
            case '-11' :
                $f_res = 'Некорректное значение ID сообщения';
                break;
            case '-12' :
                $f_res = 'API не включено в ЛК клиента на странице "SMS-рассылка" - "Рассылка по API"';
                break;
            case '-13' :
                $f_res = 'Заблокировано';
                break;
            case '-14' :
                $f_res = 'Запрос не укладывается в ограничения по времени на отправку SMS (ограничения по времени устанавливаются в разделе "Мои настройки" – вкладка "Персональные настройки")';
                break;
            case '-15' :
                $f_res = 'Некорректное значение даты отправки рассылки';
                break;
            case '-16' :
                $f_res = 'Нет шаблонов';
                break;
            case '-17' :
                $f_res = 'Нет ни одного отправителя, которые доступны для отправки SMS';
                break;
            case '-18' :
                $f_res = 'Не найден шаблон по коду';
                break;
            case '-19' :
                $f_res = 'При подтверждении номера телефона SMS-кодом не передано значение хэш для проверки';
                break;
            case '-20' :
                $f_res = 'При подтверждение номера телефона SMS-кодом не передано значение кода для проверки';
                break;
            case '-21' :
                $f_res = 'Превышено разрешенное количество проверок по одному номеру телефона';
                break;
            case '-22' :
                $f_res = 'При подтверждение номера телефона SMS-кодом текст SMS не укладывается в длину 1 SMS';
                break;
            case '-23' :
                $f_res = 'Введённый код неверен. Введите правильный код или отправьте еще одно SMS и повторите ввод кода';
                break;
            case '-24' :
                $f_res = 'URL вебхука не прошел валидацию.';
                break;
            case '-25' :
                $f_res = 'Не корректно передан список телефонов для отправки HLR.';
                break;
            case '-26' :
                $f_res = 'Не корректно передан список телефонов для проверки статусов HLR.';
                break;
            case '-27' :
                $f_res = 'Ваш аккаунт заблокирован. Обратитесь, пожалуйста, в службу технической поддержки.';
                break;
            case '-28' :
                $f_res = 'Текст Viber-сообщения больше 1000 символов.';
                break;
            case '-29' :
                $f_res = 'При передаче рекламного Viber-сообщения не указаны все три обязательных параметра (изображение, текст кнопки, ссылку на сайт).';
                break;
            case '-30' :
                $f_res = 'Ссылка на сайт в Viber-сообщении не проходит проверку на подлинность.';
                break;
            case '-31' :
                $f_res = 'Недопустимый формат изображения в Viber-сообщении (допустимы только jpg, jpeg, png).';
                break;
            case '-32' :
                $f_res = 'В каскадной рассылке Viber+SMS указано некорректное значение отправителя SMS.';
                break;
            case '-33' :
                $f_res = 'В каскадной рассылке Viber+SMS указан некорректно текст SMS.';
                break;
            case '-34' :
                $f_res = 'Не найден уникальный номер Viber-сообщения.';
                break;
            case '-35' :
                $f_res = 'Вы превысили максимальное количество SMS по API PLAIN, установленное вами на странице «SMS-рассылка» → «Рассылка по API» → блок «Ограничения по количеству на отправку SMS по API PLAIN»';
                break;
            case '-36' :
                $f_res = 'Вы превысили максимальное количество SMS по API PLAIN на 1 номер абонента, установленное вами на странице «SMS-рассылка» → «Рассылка по API» → блок «Ограничения по количеству на отправку SMS по API PLAIN»';
                break;
            case '-37' :
                $f_res = 'Вы превысили максимальное количество SMS по API PLAIN на 1 номер с одинаковым текстом SMS, установленное вами на странице «SMS-рассылка» → «Рассылка по API» → блок «Ограничения по количеству на отправку SMS по API PLAIN»';
                break;
            case '-100' :
                $f_res = 'Количество абонентов не равно количеству текстов SMS, которые переданы. Надо либо передавать 1 текст сообщения, либо количество равное количеству абонентов';
                break;
            case '-101' :
                $f_res = 'Количество абонентов не равно количеству шаблоново SMS, которые переданы. Надо либо передавать 1 шаблон, либо количество равное количеству абонентов';
                break;

        }

        return $f_res;

    }

    public function setModeApi($api_mode)
    {

        switch ($api_mode) {

            case 'xml' :
                $this->api_mode = 'xml';
                break;
            default :
                $this->api_mode = 'json';
                break;

        }

    }

    /*
     * Функция отправки кода для проверки номера телефона
     * string $sender - отправитель сообщения
     * string $tel - номер абонента, которому будет отправлена SMS для проверки
     * [string $sms_text] - текст смс, который будет отправлен для проверки. {KOD} - будет заменено на сгенерированный 5тизначный код. Если {KOD} не
     *                      встретится, то код вставится в конец смс
     * 
     * return 
     * string $check_hash - хэш для дальнейшей проверки
     * | 
     * false - в случае ошибки
     * 
     */
    public function checkTelehpone($sender, $tel, $sms_text = '', $type_command = 'sms_code_generate')
    {

        $url = $this->api_url . 'api/v1.2/' . $type_command . '/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password,
            'sender' => $sender,
            'recipient' => $tel,
            'message' => $sms_text
        );

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_check_telephone');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res['check_hash']
        );

    }

    /*
     * Функция проверки правильности введенного кода
     * string $check_hash - хэш код, полученный в checkTelephone
     * string $code - код, который ввел клиент
     * 
     * return 
     * string $telephone - телефон, который учавстовал в проверке
     * | 
     * false - в случае ошибки
     * 
     */
    public function checkCode($check_hash, $check_code)
    {

        $url = $this->api_url . 'api/v1.2/sms_code_check/plain';
        $postdata = array(
            'user' => $this->user_login,
            'password' => $this->user_password,
            'check_hash' => $check_hash,
            'check_code' => $check_code
        );

        $res = $this->postContent($url, $postdata);

        $res = $this->getResult($res, 'plain_check_code');

        return array(
            'error' => $this->error,
            'error_messages' => $this->error_messages,
            'result' => $res['check_telephone']
        );

    }

    public function setWebhookUrl($url)
    {

        $this->webhook_url = $url;

        return true;

    }

    public function setSubscribeName($name)
    {

        $this->subscribe_name = strip_tags($name);

        return true;

    }

    public function setUrl($url)
    {

        $this->api_url = $url;

        return true;

    }

    static function getErrorByCodeStatic($error_code)
    {

        return self::getErrorByCode($error_code);

    }

}