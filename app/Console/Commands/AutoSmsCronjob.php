<?php

namespace App\Console\Commands;

use App\Models\Phone;
use App\Models\Sim;
use App\Models\SmsContent;
use DB;
use Illuminate\Console\Command;
use App\Models\SmsCronjob;

class AutoSmsCronjob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:cronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto SMS Cronjob';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('Start cronjob');
        $smsCronjobs = SmsCronjob::where('status', SmsCronjob::$ACTIVE)->get();
        if (!empty($smsCronjobs)) {
            foreach ($smsCronjobs as $smsCronjob) {
                $contents = SmsContent::select('content')->where('campaign_id', $smsCronjob->campaign_id)->get();
                if (!empty(json_decode($smsCronjob->list_phones))) {
                    $i = 0;
                    foreach (json_decode($smsCronjob->list_phones) as $phone) {
                        $content = $this->randomContent($contents);
                        $list_phones = json_decode($smsCronjob->list_phones);
                        if (strlen($list_phones[$i]) > 9 || strlen($list_phones[$i]) < 12) {
                            $this->sendSms($phone, $content, $smsCronjob->id);
                        }
                        unset($list_phones[$i]);
                        $list_phone_new = [];
                        foreach ($list_phones as $list_phone) {
                            $list_phone_new[] = $list_phone;
                        }
                        $smsCronjob->list_phones = json_encode($list_phone_new);
                        $smsCronjob->save();
                        if ($i == 4) {
                            break;
                        }
                        $i++;
                    }
                } else {
                    $smsCronjob->status = SmsCronjob::$UNACTIVE;
                    $smsCronjob->save();
                }
            }
        }
    }

    protected function sendSms($phone, $content, $cronjob_id)
    {
        $network = $this->checkPhone($phone);

        if ($network == 'viettel') {
            $query_sim = Sim::where('network', $network)->where('status', 0)->first();
            if (!isset($query_sim)) {
                DB::table('sims')->where('network', $network)->update(['status' => 0]);
                $query_sim = Sim::where('network', $network)->where('status', 0)->first();
                $sim = $query_sim->post;
            } else {
                $sim = $query_sim->post;
            }
        } elseif ($network = 'vinaphone') {
            $query_sim = Sim::where('network', $network)->first();
            $sim = $query_sim->post;
        } elseif ($network = 'mobiphone') {
            $query_sim = Sim::where('network', $network)->first();
            $sim = $query_sim->post;
        }
        if ($sim == 'KXD') {
            return 'Error';
        }
        if ($query_sim->status == 1) {
            $query_sim->status = 0;
        } else {
            $query_sim->status = 1;
        }
        $query_sim->save();
        echo $sim;
        $url = 'http://temazsms.ddns.net/cgi/WebCGI?1500101=account=apiuser&password=apipass&port=' . $sim . '&destination=' . $phone . '&content=' . urlencode($content);
        $response = $this->cUrl($url);
        //Save history phone
        preg_match_all('/.*?Response\: Success.*?/', $response, $status);
        if (isset($status[0][0]) && $status[0][0] == 'Response: Success') {
            $status = 1;
        } else {
            $status = 0;
        }
        $check = Phone::where('phone', $phone)->first();
        if (empty($check)) {
            try {
                $newPhone = new Phone();
                $newPhone->phone = $phone;
                $newPhone->cronjob_id = $cronjob_id;
                $newPhone->count_send_sms = 1;
                if ($status == 1) {
                    $newPhone->send_success = $newPhone->send_success + 1;
                } else {
                    $newPhone->send_error = $newPhone->send_error + 1;
                }
                $newPhone->created_at = date('Y-m-d H:i:s');
                $newPhone->save();
            } catch (\Exception $e) {

            }
        } else {
            $check->cronjob_id = $cronjob_id;
            $check->count_send_sms = $check->count_send_sms + 1;
            $check->save();
        }

        return 1;
    }

    protected function checkPhone($phone)
    {
        $dauso = substr($phone, 0, 3);
        if ($dauso == '086' || $dauso == '096' || $dauso == '097' || $dauso == '098' || substr($phone, 0, 2) == '03') {
            return 'viettel';
        } elseif ($dauso == '089' || $dauso == '090' || $dauso == '093' || substr($phone, 0, 2) == '07') {
            return 'mobiphone';
        } elseif ($dauso == '088' || $dauso == '091' || $dauso == '094' || $dauso == '083' || $dauso == '084' || $dauso == '085' || $dauso == '081' || $dauso == '082') {
            return 'vinaphone';
        } else {
            return 'KXD';
        }
    }

    protected function changePhone($phone)
    {
        $firstNumber = substr($phone, 0, 4);
        $array = [
            '0120' => '070',
            '0121' => '079',
            '0122' => '077',
            '0126' => '076',
            '0128' => '078',
            '0123' => '083',
            '0124' => '084',
            '0125' => '085',
            '0127' => '081',
            '0129' => '082',
            '0162' => '032',
            '0163' => '033',
            '0164' => '034',
            '0165' => '035',
            '0166' => '036',
            '0167' => '037',
            '0168' => '038',
            '0169' => '039',
            '0186' => '056',
            '0188' => '058',
            '0199' => '059',
        ];
        if (isset($array[$firstNumber])) {
            $phone = str_replace($firstNumber, $array[$firstNumber], $phone);
        }
        return $phone;
    }

    protected function randomContent($contents)
    {
        $content = $contents[rand(0, count($contents) - 1)]['content'];
        $random = ['Chào anh/chị', 'Chào Anh/Chị', 'Chào bạn', 'Chào Bạn', 'Hi bạn', 'Hi anh/chị', 'Hi Bạn', 'Hi Anh/Chị'];
        $random = $random[rand(0, count($random) - 1)];
        $content = str_replace('{random}', $random, $content);
        echo $content;
        return $content;
    }

    protected function cUrl($url)
    {
        $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $options = array(
            CURLOPT_CUSTOMREQUEST => "GET",        //set request type post or get
            CURLOPT_POST => false,        //set to GET
            CURLOPT_USERAGENT => $user_agent, //set user agent
            CURLOPT_COOKIEFILE => "cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR => "cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING => "",       // handle all encodings
            CURLOPT_AUTOREFERER => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT => 120,      // timeout on response
            CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);
        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $content;
    }
}
