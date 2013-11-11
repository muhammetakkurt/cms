<?php
/**
 * 
 */
 class Helpers
 {
    /**
    *   @name Default Blog Picture Helper
    *   @author  Hilmi Erdem KEREN
    *   @version 1.0
    */
    public static function useDefaultBlogPicture($cols = 1)
    {
        $type=Array(1 => 'jpg', 2 => 'jpeg', 3 => 'png', 4 => 'gif');
        $fullImagePath = base_path('public/assets/img/default/blog/');
        $directoryTree = scandir($fullImagePath);
        $imageArray = array();
        $oneColsImageArray = array();
        $twoColsImageArray = array();
        foreach($directoryTree as $treeItem)
        {
            if(!is_dir($fullImagePath.$treeItem))
            {
                $ext = explode(".", $treeItem)[1];
                if(in_array($ext, $type))
                {
                    $imageWidth = getimagesize($fullImagePath.$treeItem)[0];
                    if($imageWidth == 622)
                    {
                        array_push($twoColsImageArray, $treeItem);
                    }
                    elseif($imageWidth = 306)
                    {
                        array_push($oneColsImageArray, $treeItem);
                    }
                }
            }
        }
        if($cols == 1)
        {
            $imageArray = $oneColsImageArray;
        }
        else
        {
            $imageArray = $twoColsImageArray;
        }
        return URL::asset("assets/img/default/blog/".$imageArray[array_rand($imageArray)]);
    }

    /**
    *   @name a.k.a Valery2Sessi Validation Errors Yield To Session
    *   @package Illuminate\Validation
    *   @author Hilmi Erdem KEREN
    *   @version 1.5
    *   @uses Validator
    *   @superpress: Validator
    */
    public static function validationErrorsYield2Sessions($validationMessagesObj)
    {
        //##########  [Validation Errors Block]  ###########\\
        $validationErrors = array();
        foreach($validationMessagesObj->toArray() as $validationError)
        {
            array_push($validationErrors, $validationError[0]);
        }
        Session::put('status_error', $validationErrors);
        //###################################################\\
    }

    /**
    *   Chop given text to maximum possible words according to number of 
    *   letters given. Will try to return nearest availible letters to param
    *   
    *   @param string $text, int $numLetters
    *   @return string
    */
    public static function cutShort($text, $numLettersPerLine, $numLines)
    {
        $firstWordFlag = true;
        $numLettersTotal = ($numLettersPerLine * $numLines) - 3;
        $htmlTagClearText = strip_tags($text);
        $newLineClearText = preg_replace('/\s+/', ' ', $htmlTagClearText);
        $wordList = explode(" ", $htmlTagClearText);
        $briefText = "";
        $i = 0;
        while(mb_strlen($briefText, mb_detect_encoding($briefText)) < $numLettersTotal && count($wordList) > $i)
        {
            // echo($briefText . "(" . $wordList[$i] . "-" . mb_strlen($wordList[$i],  mb_detect_encoding($briefText)) . ")" . "<br />");
            if (mb_strlen($wordList[$i],  mb_detect_encoding($briefText))>($numLettersPerLine)) {$i++;continue;}
            $testText = $briefText . $wordList[$i];
            if (mb_strlen($testText,  mb_detect_encoding($briefText))>($numLettersTotal)) break;
            $briefText .= $firstWordFlag ? "" : " ";
            $briefText .= $wordList[$i];
            $firstWordFlag = false;
            $i++;
        }
        $briefText .= "...";
        return $briefText;
    }

    /**
    *   @todo If there is if and only if one taxClass to implement on
    *   active price, we should not write "taxes price" but the name
    *   of the tax instead
    */
    public static function labelProduct($product)
    {
        
    }


    /**
    *   Formats a number as turkish currency string
    *
    *   @return string $formatNumber
    */
    public static function formatMoney($number)
    {
        $numberFloat = $number;
        $tryFormat = array(
            'decimals'  =>  2,
            'decPoint'  =>  ',',
            'thousandsSep'  =>  ".",
        );
        $formatNumber = number_format($numberFloat, $tryFormat['decimals'], $tryFormat['decPoint'], $tryFormat['thousandsSep']);
        return $formatNumber;
    }
        
    //Activity nesnesi oluşturur ve nesneye paremetreleri ekleyip kaydeder...
    public static function save_log($user_id, $action,$content= NULL, $to_id = NULL)
    {
        $activity = new Activity;
        $activity->user_id = $user_id;
        if(is_numeric($action)) $activity->action_id = $action;
        else{ 
             $act = Action::where('action', '=', $action)->first();
             if(! is_null($act)) $activity->action_id = $act->id;
        }
        if(!empty($content)) $activity->content =$content;
        if(!empty($to_user_id)) $activity->to_user_id =$to_user_id;
        if(!empty($to_id)) $activity->to_id = $to_id;
        $activity->ip = Request::getClientIp();
        $activity->save();
        return $activity;
    }

    /**
     * @name   Slice Formatted Money For Design
     * @author Hilmi Erdem KEREN
     * @param  formattedMoney String
     * @return Array
     */
    public static function sFMFD($formattedMoney)
    {
        $slicedMoneyText = explode(",", $formattedMoney);
        $slicedMoneyText[1] = ",".$slicedMoneyText[1];
        return $slicedMoneyText;
    }

    /*
    *   forceLogin($forceLoginEmail , $adminLoginId) Fonksiyonu Admin olarak giriş alan kişinin
    *   kullanıcı progiline giriş yapmasını sağlamaktadır. Route dosyasında Group=='Admin' olan kullanıcının 
    *   force-login URL adresine POST gönderildiğinde çağrılır.
    *
    *   @forceLoginEmail    Progiline girilecek kişinin Email string değişkeni
    *   @adminLoginId       Giriş yapan kişinin ID bilgisi 
    */
    public function forceLogin($forceLoginId , $adminLoginId)
    {
        
        $user = Sentry::getUserProvider()->findById($forceLoginId);
        // Log the user in

        Session::put('adminLoginId', $adminLoginId);
        
        Sentry::logout();
        Sentry::login($user, false);
        
        return Redirect::to(Request::root());
    }


    /*
    *   
    *   forceLogin fonksiyonu ile adına giriş yapılanın ekranında bulunan Geri Dön butonundan çağrılır.   
    *   Sentry::check()==true ise force-logout URL adresini dinler.
    *   Çağrıldığında Session değerini temizler.
    */
    public function forceLogout()
    {
        try
        {
            $user = Sentry::getUserProvider()->findById(Session::get('adminLoginId'));
            Sentry::login($user, false);
            Session::forget('adminLoginId');
            return Redirect::to(Request::root());
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            Session::put('status_error', array(0 => 'Kullanıcı bulunamadı'));
            return Redirect::back();
        }
    }

    /*
    *   urls() fonksiyonu Admin paneli için mevcut linkleri tutar. plugin/breadcrumb.blade.php dosyasın da kullanılır.
    */
    public function urls()
    {

        $urls = array
            (
                0 => array('link' => 'users', 'name' => 'Kullanıcılar'),
                1 => array('link' => 'users-groups', 'name' => 'Kullanıcı Grupları'),
                2 => array('link' => 'profile', 'name' => 'Profil'),
                3 => array('link' => 'file-manager', 'name' => 'Dosya Yönetimi'),
                4 => array('link' => 'cms-pages', 'name' => 'Sayfalar'),
                5 => array('link' => 'cms-articles', 'name' => 'Makaleler'),
                6 => array('link' => 'cms-article-comments', 'name' => 'Makale Yorumları'),
                
                 
             );
        return $urls;
    }

    /*
    *   createSeo() fonksiyonu aldığı $str değişkenini bölerek bir SEO URL oluşturur.  
    */
    public static function createSeo($str, $replace=array(), $delimiter='-') 
    {
        if(!empty($replace)) 
        {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        
        return $clean;

    }
  
    /*
    *   allCategories() fonksiyonu E-ticaret'in ön yüzünde nav bar da kullanılmaktadır.
    *   Aldığı $parent'e göre (Default 1 (Genel)) alt kategorilerini return eder.
    */
    public static function allCategories($parent = 1)
    {
        $productCategories = ProductCategory::where('parent_id','=',$parent)->where('status', '=', 1)->get();
        if (count($productCategories)>0) {
            $str = '<ul class="dropdown-menu">';    
        } else {
            $str = '<ul>';
        }
        foreach ($productCategories as $prodcutCategory) {
            if (ProductCategory::where('parent_id','=',$prodcutCategory->id)->where('status', '=', 1)->count()>0) {
                $str.='<li class="dropdown-submenu">';
            } else {
                $str.='<li>';  
            }
            $str .= '<a href="'.URL::to('category/'.$prodcutCategory->seo_name).'">'.$prodcutCategory->name.'</a>'.Helpers::allCategories($prodcutCategory->id).'</li>';
        }
        $str .= '</ul>';
        return $str;
    }

    public function createOrderRefNumber($orderId)
    {
        $order_ref_temp = Config::get('app.order_ref_template');

        $patterns = array();
        $patterns[0] = '/#Y/';
        $patterns[1] = '/#I/';                      
        
        $replacements = array();
        $replacements[2] = date('Y', time());
        $replacements[1] = $orderId;
        return preg_replace($patterns, $replacements, $order_ref_temp);
    }

    public static function extension($fileName)
    {
        $i = pathinfo($fileName); 
        return $i['extension'];
    }

    public static function parseFilename($fileName)
    {
        $i = pathinfo($fileName); 
        return $i;
    }
}


