<?php
/**
 * Fck编辑器
 *
 * @package    helper
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Helper_Fck extends Zend_View_Helper_Abstract
{
    public $InstanceName ;

    /**
     * FCK 編輯器的路徑
     *
     */
    public $BasePath ;

    /**
     * FCK 編輯器的寬度
     *
     * @var unknown_type
     */
    public $Width = '80%' ;

    /**
     * FCK 編輯器的高度
     *
     * @var unknown_type
     */
    public $Height = '500' ;

    /**
     * FCK 編輯器的寬度
     *
     * @var unknown_type
     */
    public $ToolbarSet ;

    public $Value ;

    public $Config ;

    public function Fck()
    {
        $this->InstanceName = 'FCKcontent' ;
        $this->BasePath     = '/editors/fckeditor/' ;
        $this->ToolbarSet   = 'Default' ;
        $this->Config       = array() ;
        $this->Config['SkinPath'] = '/editors/fckeditor/editor/skins/silver/' ;
        return $this;
    }

    /**
     * 输出FCK编辑器
     *
     */
    public function Create()
    {
        echo $this->CreateHtml() ;
    }

    /**
     * Return the HTML code required to run FCKeditor.
     *
     * @return string
     */
    public function CreateHtml()
    {
        $HtmlValue = htmlspecialchars( $this->Value ) ;
        $Html = '' ;

        if ( $this->IsCompatible() )
        {
            if ( isset( $_GET['fcksource'] ) && $_GET['fcksource'] == "true" )
                $File = 'fckeditor.original.html' ;
            else
                $File = 'fckeditor.html' ;

            $Link = "{$this->BasePath}editor/{$File}?InstanceName={$this->InstanceName}" ;

            if ( $this->ToolbarSet != '' )
                $Link .= "&amp;Toolbar={$this->ToolbarSet}" ;

            // Render the linked hidden field.
            $Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}\" name=\"{$this->InstanceName}\" value=\"{$HtmlValue}\" style=\"display:none\" />" ;

            // Render the configurations hidden field.
            $Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}___Config\" value=\"" . $this->GetConfigFieldString() . "\" style=\"display:none\" />" ;

            // Render the editor IFRAME.
            $Html .= "<iframe id=\"{$this->InstanceName}___Frame\" src=\"{$Link}\" width=\"{$this->Width}\" height=\"{$this->Height}\" frameborder=\"0\" scrolling=\"no\"></iframe>" ;
        }
        else
        {
            if ( strpos( $this->Width, '%' ) === false )
                $WidthCSS = $this->Width . 'px' ;
            else
                $WidthCSS = $this->Width ;

            if ( strpos( $this->Height, '%' ) === false )
                $HeightCSS = $this->Height . 'px' ;
            else
                $HeightCSS = $this->Height ;

            $Html .= "<textarea name=\"{$this->InstanceName}\" rows=\"4\" cols=\"40\" style=\"width: {$WidthCSS}; height: {$HeightCSS}\">{$HtmlValue}</textarea>" ;
        }

        return $Html ;
    }

    /**
     * Returns true if browser is compatible with FCKeditor.
     *
     * @return boolean
     */
    public function IsCompatible()
    {
        return FCKeditor_IsCompatibleBrowser() ;
    }

    /**
     * Get settings from Config array as a single string.
     *
     * @access protected
     * @return string
     */
    public function GetConfigFieldString()
    {
        $sParams = '' ;
        $bFirst = true ;

        foreach ( $this->Config as $sKey => $sValue )
        {
            if ( $bFirst == false )
                $sParams .= '&amp;' ;
            else
                $bFirst = false ;

            if ( $sValue === true )
                $sParams .= $this->EncodeConfig( $sKey ) . '=true' ;
            else if ( $sValue === false )
                $sParams .= $this->EncodeConfig( $sKey ) . '=false' ;
            else
                $sParams .= $this->EncodeConfig( $sKey ) . '=' . $this->EncodeConfig( $sValue ) ;
        }

        return $sParams ;
    }

    /**
     * Encode characters that may break the configuration string
     * generated by GetConfigFieldString().
     *
     * @access protected
     * @param string $valueToEncode
     * @return string
     */
    public function EncodeConfig( $valueToEncode )
    {
        $chars = array(
            '&' => '%26',
            '=' => '%3D',
            '"' => '%22' ) ;

        return strtr( $valueToEncode,  $chars ) ;
    }
}
function FCKeditor_IsCompatibleBrowser()
{
    if ( isset( $_SERVER ) ) {
        $sAgent = $_SERVER['HTTP_USER_AGENT'] ;
    }
    else {
        global $HTTP_SERVER_VARS ;
        if ( isset( $HTTP_SERVER_VARS ) ) {
            $sAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'] ;
        }
        else {
            global $HTTP_USER_AGENT ;
            $sAgent = $HTTP_USER_AGENT ;
        }
    }

    if ( strpos($sAgent, 'MSIE') !== false && strpos($sAgent, 'mac') === false && strpos($sAgent, 'Opera') === false )
    {
        $iVersion = (float)substr($sAgent, strpos($sAgent, 'MSIE') + 5, 3) ;
        return ($iVersion >= 5.5) ;
    }
    else if ( strpos($sAgent, 'Gecko/') !== false )
    {
        $iVersion = (int)substr($sAgent, strpos($sAgent, 'Gecko/') + 6, 8) ;
        return ($iVersion >= 20030210) ;
    }
    else if ( strpos($sAgent, 'Opera/') !== false )
    {
        $fVersion = (float)substr($sAgent, strpos($sAgent, 'Opera/') + 6, 4) ;
        return ($fVersion >= 9.5) ;
    }
    else if ( preg_match( "|AppleWebKit/(\d+)|i", $sAgent, $matches ) )
    {
        $iVersion = $matches[1] ;
        return ( $matches[1] >= 522 ) ;
    }
    else
        return false ;
}