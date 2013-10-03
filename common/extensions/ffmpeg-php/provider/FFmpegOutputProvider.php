<?php
/**
 * FFmpegOutputProvider ffmpeg provider implementation
 * 
 * @author char0n (Vladimír Gorej, gorej@codescale.net)
 * @package FFmpegPHP
 * @subpackage provider
 * @license New BSD
 * @version 2.6
 */
class FFmpegOutputProvider extends AbstractOutputProvider {
	
    protected static $EX_CODE_NO_FFMPEG = 334560;
		
    /**
     * Constructor
     * 
     * @param string $ffmpegBinary path to ffmpeg executable
     * @param boolean $persistent persistent functionality on/off
     */
    public function __construct($ffmpegBinary = 'ffmpeg', $persistent = false) {
        parent::__construct($ffmpegBinary, $persistent);
    }
	
    /**
     * Getting parsable output from ffmpeg binary
     * 
     * @return string
     */    
    public function getOutput() {
        
        // Persistent opening
        if ($this->persistent == true && array_key_exists(get_class($this).$this->binary.$this->movieFile, self::$persistentBuffer)) {
            return self::$persistentBuffer[get_class($this).$this->binary.$this->movieFile];
        }
        
        // File doesn't exist
        if (!file_exists($this->movieFile)) {
            throw new Exception('Movie file not found', self::$EX_CODE_FILE_NOT_FOUND);
        }
        
        // Get information about file from ffmpeg
        $output = array();
        
        exec($this->binary.' -i '.escapeshellarg($this->movieFile).' 2>&1', $output, $retVar);        
        $output = join(PHP_EOL, $output);
        
        // ffmpeg installed
        if (!preg_match('/FFmpeg version/i', $output)) {
            throw new Exception('FFmpeg is not installed on host server', self::$EX_CODE_NO_FFMPEG);
        }
        
        // Storing persistent opening
        if ($this->persistent == true) {
            self::$persistentBuffer[get_class($this).$this->binary.$this->movieFile] = $output;            
        }   

        return $output;
    }

    public function convertToFLV($width = null, $height = null)
    {
        $resize = '';
        if ($width && $height)
            $resize = '-s '.$width.'x'.$height;

        $processFile = TMP_PATH.DIRECTORY_SEPARATOR.'___'.basename($this->movieFile);
        exec($this->binary.' -i '.escapeshellarg($this->movieFile).' -b 700000 -ab 64 -ar 44100 -f flv '.$resize.' '.$processFile.' 2>&1 &> /tmp/o',$output);
        copy($processFile,$this->movieFile);
        unlink($processFile);
    }
}