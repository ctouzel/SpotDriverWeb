<?php

// SIMPLEPLIE AUTOLOADER
spl_autoload_register(array(new SimplePie_Autoloader(), 'autoload'));
if (!class_exists('SimplePie'))
{
	trigger_error('Autoloader not registered properly', E_USER_ERROR);
}
class SimplePie_Autoloader
{
	/**
     * Constructor
     */
	public function __construct()
	{
		$this->path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library';
	}

	/**
     * Autoloader
     * @param string $class The name of the class to attempt to load.
     */
	public function autoload($class)
	{
		// Only load the class if it starts with "SimplePie"
		if (strpos($class, 'SimplePie') !== 0)
		{
			return;
		}

		$filename = $this->path . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
		include $filename;
	}
}

//
// SAVE TO FILE
//
function SaveToFile($filepath,$content)
{
	try
	{
		$fp = fopen($filepath,"wb");
		fwrite($fp,$content);
		fclose($fp);
	}
	catch (Exception $e)
	{
		ManageException($e, "Unable to save content to file ".$filepath);
	}
}

//
// READ FROM FILE
// 
function ReadFromFile($filepath)
{
	try
	{
		$fp = fopen($filepath,"r");
		$result = fread($fp, filesize($filepath));
		fclose($fp);
		return $result;
	}
	catch (Exception $e)
	{
		ManageException($e, "Unable to read content from file ".$filepath);
	}
}


//
// MANAGE EXCEPTION
//
function ManageException($exception, $addtionalInfo)
{
    LogThis("ERROR: ".$errorcontent.$exception->getCode()." : ".$errorcontent.$exception->getMessage());
}

//
// LOG THIS
//
function LogThis($line)
{
	if (LOG_VERBOSE) echo "<p>".$line."</p>";
	$logcontent    = array();
	$currentDayPos = 1;
	$daystr        = date("d");
	$monthstr      = date("m");
	$yearstr       = date("Y");
	$datestr       = strtoupper(date("l"));

	// EXISTING FILE?
	if (file_exists(FILE_LOG))
	{
		// GET ALL LINES OF EXISTING LOG
		$logcontent = file(FILE_LOG, FILE_IGNORE_NEW_LINES);

		// GET TODAY SECTION
		$lineIdx = 0;
		if (substr($logcontent[0], 0, 4) == $yearstr && substr($logcontent[0], 5, 2) == $monthstr && substr($logcontent[0], 8, 2) == $daystr)
		{
			// THE CURRENT SECTION IS TODAY!
			// FIND THE BLANK LINE...
			$lineIdx = $lineIdx + 1;
			while (count($logcontent) > $lineIdx && count($logcontent[$lineIdx])>2)
			{
				$lineIdx = $lineIdx + 1;
			}
			array_splice($logcontent, $lineIdx, 0, "  ".date("H:i:s")." ".$line);
		}
		else
		{
			// CREATE A NEW TODAY SECTION
			array_splice($logcontent, 0, 0, $yearstr."-".$monthstr."-".$daystr." ".$datestr);
			array_splice($logcontent, 1, 0, "  ".date("H:i:s")." ".$line);
			array_splice($logcontent, 2, 0, "");
		}
	}
	else
	{
		// NEW HEADER
		array_push($logcontent, $yearstr."-".$monthstr."-".$daystr." ".$datestr);
		array_push($logcontent, "  ".date("H:i:s")." ".$line);
		array_push($logcontent, "");
	}
	
	// NEED CLEANING (MAX LINES?)
	while (count($logcontent) > LOG_MAXLINES)
	{
		unset($logcontent[count($logcontent)-1]);
	}

	// SAVE FILE
	$fp = fopen(FILE_LOG,"wb");
	foreach($logcontent as $logline)
	{
		fwrite($fp, $logline.PHP_EOL);
	}
	fclose($fp);
}

//
// FATAL HANDLER
//
function fatal_handler() 
{
    $errfile = "unknown file";
    $errstr  = "shutdown";
    $errline = 0;
    $errno   = E_CORE_ERROR;
    $error   = error_get_last();
    if( $error !== NULL) 
    {
        $errfile = $error["file"];
        $errline = $error["line"];
        $errstr  = $error["message"];
    }
    if ($errno!=2048 && $errline!=0)
    {
        LogThis("File: ".$errfile.". Line: ".$errline);
        LogThis("ERROR: ".E_CORE_ERROR." - ".$errstr);
    }
}
register_shutdown_function( "fatal_handler" );

// GET RSS OBJECT
function GetRSSObject($feedsrc)
{
    $feedobj = new SimplePie();
    $feedobj->set_feed_url($feedsrc);
    $feedobj->handle_content_type();
    try
    {
            $feedobj->init();
    }
    catch (Exception $e)
    {
            return NULL;
    }
    return $feedobj;
}

// READ FROM RSS
function ReadFromRSS($feedsrc, $headerd, $max, $content, $dayinterval)
{
    $now = new DateTime();
    $retval = "";
    $feedobj = GetRSSObject($feedsrc);
    if (is_null($feedobj) || is_null($feedobj->get_item(0)))
    {
            return "";
    }
    $feedstamp = new DateTime($feedobj->get_item(0)->get_date());
    $feedstamp->setTimezone(new DateTimeZone('America/Montreal'));
    $since_start = floor(($now->format('U') - $feedstamp->format('U')) / (60*60*24));
    if ($dayinterval=="-1" || $since_start<=$dayinterval)
    {
    if ($headerd !== "")
    {
        $retval = $retval. "<h3>".$headerd."</h3>".PHP_EOL;
    }
    for ($i=0; $i<$max; $i++)
    {
        $retval = $retval . "<p><b>". $feedobj->get_item($i)->get_title(). "</b><br/>".PHP_EOL;
        if ($content)
        {
                $retval = $retval . $feedobj->get_item($i)->get_content()."</p>".PHP_EOL;
        }
        else
        {
                $retval = $retval . $feedobj->get_item($i)->get_description()."</p>".PHP_EOL;
        }
    }
    }
    return $retval;
}

// GET HEADLINES FROM RSS
function GetHeadlinesFromRSS($feedsrc, $max, $dayinterval)
{
    try
    {
        $now = new DateTime();
        $feedobj = GetRSSObject($feedsrc);
        $feedstamp = new DateTime($feedobj->get_item(0)->get_date());
        $feedstamp->setTimezone(new DateTimeZone('America/Montreal'));
        $since_start = floor(($now->format('U') - $feedstamp->format('U')) / (60*60*24));
        if ($dayinterval=="-1" || $since_start<=$dayinterval)
        {
            for ($i=0; $i<$max; $i++)
            {
                if (is_null($feedobj->get_item($i)))
                {
                    return "";
                }
                echo "<p><a href='".$feedobj->get_item($i)->get_link()."' target='_blank'>";
                echo $feedobj->get_item($i)->get_title();
                echo "</a></p>".PHP_EOL;
            }
        }
    }
    catch (Exception $e)
    {
        ManageException($e, "Unable to retrieve headlines from rss feed".($feedsrc));
    }
}

// READ FROM RSS NO IMAGE
function ReadFromRSS_NoImage($feedsrc, $headerd, $max, $content, $dayinterval)
{
    $output = ReadFromRSS($feedsrc, $headerd, $max, $content, $dayinterval);
    $output = preg_replace("/<img[^>]+\>/i", "", $output);
    return $output;
}
?>



