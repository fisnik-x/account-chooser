<?php
/**
 * template.php
 * 
 * @package Strings\Template
 * @author Fisnik
 * @copyright Fisnik
 * 
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
declare(strict_types=1);
namespace Strings\Template;
use \Exception, 
    \SplFileInfo;

/**
 * A Basic Template Class
 */
class Template {

    public ?string $template = null;
    private array $allowed_extensions = array('html', 'htm');
    private array $data = array();
    
    public function __construct() {}
    
    /**
     * Loads an Html or Htm file contents
     *
     * @param string $path
     */
    public function load(string $path) : void
    {
        
        if (!file_exists($path)) {
            throw new Exception("The file $path does not exist.");
        }

        $info = new SplFileInfo($path);
        if (!in_array($info->getExtension(), $this->allowed_extensions)) {
            throw new Exception("The " . $info->getExtension() . " file extension is not supported!");
        }

        $this->template = file_get_contents($path);
        assert($this->template != "", "No content!");
    }

    /**
     * Returns the content of an Html or Htm file 
     *
     * @param string $path
     * @return string
     */
    public function loads(string $path) : string 
    {
        if(!file_exists($path)) {
            throw new Exception("The file $path does not exist.");
        }

        $info = new SplFileInfo($path); 
        if (!in_array($info->getExtension(), $this->allowed_extensions)) {
            throw new Exception("The " . $info->getExtension() . " file extension is not supported!");
        }

        return file_get_contents($path);
    }

    /**
     * Sets a replacement tag along with a value
     *
     * @param string $tag
     * @param string $value
     */
    public function set_value(string $tag, string $value) : void
    {
        $this->data[$tag] = $value;
    }
    
    /**
     * Renders the output of a preprocessed HTML template
     */
    public function render() : void
    {
        ob_start();
        $this->preprocess();
        echo $this->template;
        ob_get_contents();
        ob_end_flush();
    }

    private function preprocess() : void
    {
        foreach($this->data as $k => $v) {
            $this->template = preg_replace('/{{'.$k.'}}/', $v, $this->template);
        }
    }
}

?>