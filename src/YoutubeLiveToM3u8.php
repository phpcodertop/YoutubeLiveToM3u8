<?php
namespace phpcodertop\YoutubeLiveToM3u8;


/**
 * @author Ahmed Maher Halima @phpcodertop
 * Class YoutubeLiveToM3u8
 * @package phpcodertop\YoutubeLiveToM3u8
 */
class YoutubeLiveToM3u8
{
    /**
     * id of youtube video
     * @var
     */
    private $videoId;
    /**
     * prepared url for request
     * @var
     */
    private $requestUrl;
    /**
     * final download url
     * @var
     */
    private $downloadUrl;

    /**
     * returns id of video from url
     * @param $urlString
     * @return bool
     */
    public function getId($urlString){
        return $this->isValidYoutubeUrl($urlString);
    }

    /**
     * returns a download link for m3u8 file
     * @param $youtubeLiveUrl
     * @return bool
     */
    public function getDownloadUrl($youtubeLiveUrl){
        $this->videoId = $this->isValidYoutubeUrl($youtubeLiveUrl);
        if($this->videoId)
            return $this->makeRequest($this->videoId);

        echo "Invalid Youtube Url.";
    }

    /**
     * download video m3u8 file
     * @param $youtubeLiveUrl
     */
    public function download($youtubeLiveUrl){
        $this->videoId = $this->isValidYoutubeUrl($youtubeLiveUrl);
        if($this->videoId)
            return $this->downloadById($this->videoId);

        echo "Invalid Youtube Url.";
    }

    /**
     * download video m3u8 file by given id
     * @param $videoId
     */
    public function downloadById($videoId){
        $this->downloadUrl = $this->makeRequest($videoId);
        if ($this->downloadUrl){
            header("Location: $this->downloadUrl");
        }
        echo "Invalid Live Youtube Video.";
    }

    /**
     * checks if it is valid youtube video and returns its id
     * @param $url
     * @return bool
     */
    private function isValidYoutubeUrl($url){
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
        if(!empty($matches)){
            return $matches[1];
        }
        return false;
    }

    /**
     * make a curl request to get video data
     * @param $videoId
     * @return bool
     */
    private function makeRequest($videoId){
        ini_set("user_agent","facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)");
        $this->requestUrl = "https://www.youtube.com/get_video_info?video_id=".$videoId."&el=detailpage";
        // make request
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $this->requestUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)");
        curl_setopt($ch, CURLOPT_REFERER, "http://facebook.com");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result = curl_exec($ch);
        curl_close($ch);
        parse_str($result, $query);
        if(array_key_exists('hlsvp',$query)){
            $downloadUrl = $query['hlsvp'];
            return $downloadUrl;
        }
        return false;
    }


}