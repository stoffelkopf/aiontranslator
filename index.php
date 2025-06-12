<?PHP
$mysql_serv	= "localhost";
$mysql_user	= "root";
$mysql_pass	= "";
$mysql_db	= "aion";

function filter_str_get(string $string): string
{
    $str = preg_replace('/\x00|<[^>]*>?/', '', $string);
    return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
}

function filter_str(string $string): string
{  
    return str_replace(["'", '"', '<', '>', '^', '=', '`', '\\'], ['&#39;', '&#34;', '&#60;', '&#62;', '&#770;', '&#61;', '&#96;', '&#92;'], $string);
}

class translation {
	var $char_elyos = array (
		0 => array ( 'j', 'k', 'h', 'i', 'n', 'o', 'l', 'm', 'r', 's', 'p', 'q', 'v', 'w', 't', 'u', 'z', 'G', 'b', 'c', 'J', 'a', 'f', 'g', 'd', 'e' ),
		1 => array ( 'e', 'f', 'c', 'd', 'i', 'j', 'g', 'h', 'm', 'n', 'k', 'l', 'q', 'r', 'o', 'p', 'u', 'v', 's', 't', 'y', 'z', 'a', 'b', 'I', 'J'),
		2 => array ( 'f', 'g', 'd', 'e', 'j', 'k', 'h', 'i', 'n', 'o', 'l', 'm', 'r', 's', 'p', 'q', 'v', 'w', 't', 'u', 'z', 'G', 'b', 'c', 'J', 'a'),
		3 => array ( 'g', 'h', 'e', 'f', 'k', 'l', 'i', 'j', 'o', 'p', 'm', 'n', 's', 't', 'q', 'r', 'w', 'x', 'u', 'v', 'G', 'H', 'c', 'd', 'a', 'b')
	);
  
	var $index_elyos = array (
		0 => array ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 2, 2, 3, 2, 2, 2, 2, 2),
		1 => array ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2),
		2 => array ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 2, 2, 2, 2),
		3 => array ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 3, 2, 2, 2, 2)
	);
  
	var $char_asmo = array (
		0 => array ( 'i', 'h', 'k', 'j', 'm', 'l', 'o', 'n', 'q', 'p', 's', 'r', 'u', 't', 'w', 'v', 'y', 'x', 'a', 'z', 'c', 'b', 'e', 'd', 'g', 'f'),
		1 => array ( 'd', 'c', 'f', 'e', 'h', 'g', 'j', 'i', 'l', 'k', 'n', 'm', 'p', 'o', 'r', 'q', 't', 's', 'v', 'u', 'x', 'w', 'z', 'y', 'b', 'a'),
		2 => array ( 'e', 'd', 'g', 'f', 'i', 'h', 'k', 'j', 'm', 'l', 'o', 'n', 'q', 'p', 's', 'r', 'u', 't', 'w', 'v', 'y', 'x', 'a', 'z', 'c', 'b'),
	);
  
	var $index_asmo = array (
		0 => array ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1, 2, 2, 2, 2, 2, 2),
		1 => array ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2),
		2 => array ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1, 2, 2),
	);
  
	function translate($message,$race) {
		$message = strtolower($message);
		$message = preg_replace("/ö/", "oe", $message);
		$message = preg_replace("/ä/", "ae", $message);
		$message = preg_replace("/ü/", "ue", $message);
		$message = preg_replace("/ß/", "ss", $message);
		$message_length = strlen($message);
		$translated_message = "";
		$message_position = 0;
		$index = 0;
		while($message_position < $message_length) {
			$ascii_number = ord($message[$message_position]);
			if ((61 <= $ascii_number) && ($ascii_number <= 122)) {	
				if ($race == 'asmo') {
					$translated_message .= $this->char_elyos[$index][$ascii_number - 97];
					$index = $this->index_elyos[$index][$ascii_number - 97];	
				} else {
					$translated_message .= $this->char_asmo[$index][$ascii_number - 97];
					$index = $this->index_asmo[$index][$ascii_number - 97];
				}
			} else {
				$index = 0;
				$translated_message .=  $message[$message_position];
			}           
			$message_position = $message_position + 1;
		}
		return $translated_message;  
	}  
	
	function format_number($number)
	{
		return number_format($number, 0, '', '.');
	}
}
?>  

<!DOCTYPE html>
<html>
	<head>
		<meta HTTP-EQUIV="Content-Type" CONTENT="text/html" CHARSET="UTF8">
		<meta name="description" content="Aion Übersetzer/Translator um mit der anderen Fraktion zu sprechen">
		<meta name="keywords" content="aion,translator,Übersetzer,Übersetzung,translation,elyos,asmo,asmodian,asmodier,chat,language,sprache,ingame">
		<meta name="robots" content="index">
		<title>Aion Translator</title>
		<style type="text/css">
			.main {
				font-size:10.5pt; color:#FFFFFF; font-family:Verdana;
			}
			.hover {
				position:absolute;visibility:hidden;
			}
			td {
				font-size:10.5pt; font-family:Verdana;padding:10px;
			}
			th {
				font-size:10.5pt; font-family:Verdana; font-weight:bold;text-align:center;color:#383838;
			}
			form input {
				font-family:Verdana; color:#FFFFFF;background-color:#000000; border-color:#FFCC00; border-style:groove;
			}
			form option {
				font-family:Verdana; color:#FFFFFF;background-color:#000000; border-color:#FFCC00; border-style:groove
			}
			textarea {
				font-family:Verdana,Helvetica; color:#FFFFFF;background-color:#000000;border-color:#FFCC00; border-style:groove;
			}
			input {
			    padding: 5px;
			}
			A:link, A:visited  {
				text-decoration: none; color:#FFCC00; 
			}
			A:active { 
				text-decoration: underline; color:#FFFFFF; 
			}
			A:hover { 
				text-decoration: underline overline; color:#FFFFFF; 
			}      
		</style>
    </head>
<?PHP
	$p_german = filter_input(INPUT_POST, "german", FILTER_CALLBACK, ['options' => 'filter_str']);	
	$p_last = filter_input(INPUT_POST, "last_translation",  FILTER_CALLBACK, ['options' => 'filter_str']);
	$p_race = filter_input(INPUT_POST, "race",  FILTER_CALLBACK, ['options' => 'filter_str']);
	$p_lrace = filter_input(INPUT_POST, "last_race",  FILTER_CALLBACK, ['options' => 'filter_str']);
	foreach ($_GET as $key => $value) {
        $_GET[$key]=filter_input(INPUT_GET, $key, FILTER_CALLBACK, ['options' => 'filter_str_get']);
    }
	$mysql=mysqli_connect($mysql_serv, $mysql_user, $mysql_pass, $mysql_db) or die("Mysql Connection Failed");
	$translation = new translation();
	$sql_query = $mysql->query("SELECT Translations FROM Aion");
	$count_translations = $sql_query->fetch_object()->Translations;
	if (strlen($p_german) < 1) {
		echo "
	<body bgcolor=\"#101421\" text=\"#FFFFFF\" onLoad=\"document.trans.german.focus();\">";
	}else {
		if ( ($p_german != $p_last) || (($p_german == $p_last) && ($p_race != $p_lrace))) {
			$count_translations = $count_translations + 1;
			$sql_query = $mysql->query("UPDATE Aion SET Translations = $count_translations");
		}
		echo "
	<body bgcolor=\"#101421\" text=\"#FFFFFF\" onLoad=\"document.trans.bafflegab.select();\">";
	}
	echo "
	<SCRIPT language=JavaScript>
		<!--
		function insertText(chat_icon) {
			document.trans.german.focus();
			if(typeof document.selection != 'undefined') {
				var range = document.selection.createRange();
				range.text = chat_icon;
				if (chat_icon.length == 0) range.move('character', -1);
				else range.moveStart('character', chat_icon.length);  
			} else if(typeof document.trans.german.selectionStart != 'undefined') {
				var scrollPos = document.trans.german.scrollTop;
				var start = document.trans.german.selectionStart;
				var end = document.trans.german.selectionEnd;
				document.trans.german.value = document.trans.german.value.substr(0, start) + chat_icon + document.trans.german.value.substr(end);
				var pos = start + chat_icon.length;
				document.trans.german.selectionStart = pos;
				document.trans.german.selectionEnd = pos;
				document.trans.german.scrollTop = scrollPos;
			} else {
				document.trans.german.value += chat_icon;
			}
		}
		function clear_all() {
			document.trans.german.value = '';
			document.trans.bafflegab.value = '';
		}
		//-->
	</SCRIPT>
	<br>
	<table bgcolor=#383838 align=\"center\" border=\"0\" width=\"550px\">
	  <tr>
		<td class=\"main\" align=\"center\">        
		  <h2>
			<br>
			Aion Translator
		  </h2>
		  <br>
		  <form name=\"trans\" action=\"".$_SERVER['PHP_SELF']."\" method=post>
			<table cellpadding=\"5\" cellspacing=0 border=\"0\" align=\"center\">
			  <tr>
				<td align=right>
				  <FONT style=\"FONT-WEIGHT:bold\">
					Volk: &nbsp;
				  </font>
				</td>
				<td colspan=\"2\">";
	if ($p_race == "asmodier") {
		$bafflegab = $translation->translate($p_german,"asmo");
		echo "
                  <input type=\"radio\" name=\"race\" value=\"elyos\">&nbsp;Ich bin Elyos (oder &Uuml;bersetzung Elyos).
                  <br>
                  <input type=\"radio\" name=\"race\" value=\"asmodier\" checked>&nbsp;Ich bin Asmodier (oder &Uuml;bersetzung Asmodier).
                  <br>";
	} else {
		$bafflegab = $translation->translate($p_german,"elyos");
		echo "            
                  <input type=\"radio\" name=\"race\" value=\"elyos\" checked>&nbsp;Ich bin Elyos (oder &Uuml;bersetzung Elyos).
                  <br>
                  <input type=\"radio\" name=\"race\" value=\"asmodier\">&nbsp;Ich bin Asmodier (oder &Uuml;bersetzung Asmodier).
                  <br>";
	}
		echo "
                  <br>
                </td>
              </tr>
              <tr>
                <td align=right>
                  <FONT style=\"FONT-WEIGHT:bold\">
                    Text:&nbsp;
                  </font>
                </td>
                <td colspan=\"2\">
                  <textarea name=\"german\" cols=\"40\" rows=\"4\">".$p_german."</textarea>
                  <br>
                </td>
              </tr>
              <tr>
              <td align=right>
                <FONT style=\"FONT-WEIGHT:bold\">
                  Chat Icons:&nbsp;
                </font>
              </td>
              <td colspan=\"2\">
                <table cellpadding=\"5\" cellspacing=0 border=\"0\" align=left>
                  <tr align=left>
                    <td align=left>
                      <A href=\"javascript:insertText('&#57344; ')\"><IMG align=absMiddle border=0 src=\"pic/00.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57354; ')\"><IMG align=absMiddle border=0 src=\"pic/0A.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57355; ')\"><IMG align=absMiddle border=0 src=\"pic/0B.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57356; ')\"><IMG align=absMiddle border=0 src=\"pic/0C.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57371; ')\"><IMG align=absMiddle border=0 src=\"pic/1B.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57372; ')\"><IMG align=absMiddle border=0 src=\"pic/1C.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57373; ')\"><IMG align=absMiddle border=0 src=\"pic/1D.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57374; ')\"><IMG align=absMiddle border=0 src=\"pic/1E.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57375; ')\"><IMG align=absMiddle border=0 src=\"pic/1F.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57349; ')\"><IMG align=absMiddle border=0 src=\"pic/05.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57350; ')\"><IMG align=absMiddle border=0 src=\"pic/06.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57352; ')\"><IMG align=absMiddle border=0 src=\"pic/08.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57360; ')\"><IMG align=absMiddle border=0 src=\"pic/10.jpg\"></A>&nbsp;
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <A href=\"javascript:insertText('&#57376; ')\"><IMG align=absMiddle border=0 src=\"pic/20.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57377; ')\"><IMG align=absMiddle border=0 src=\"pic/21.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57378; ')\"><IMG align=absMiddle border=0 src=\"pic/22.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57379; ')\"><IMG align=absMiddle border=0 src=\"pic/23.jpg\"></A>&nbsp;
                      <A href=\"javascript:insertText('&#57380; ')\"><IMG align=absMiddle border=0 src=\"pic/24.jpg\"></A>&nbsp;
                      <br>
                    </td>
                  </tr>
                </table>
              </td>
              </tr>
              <tr>
                <td align=\"right\">
                  <FONT style=\"FONT-WEIGHT:bold\">
                    &Uuml;bersetzung:&nbsp;
                  </font>
                </td>
                <td colspan=\"2\">
                  <textarea name=\"bafflegab\" cols=\"40\" rows=\"4\">$bafflegab</textarea>
                </td>
              </tr>
              <tr>
                <td>
                  &nbsp;
                </td>
                <td align=\"left\">
                  <br>
                  <input type=\"submit\" value=\"&Uuml;bersetzen\">
                </td>
                <td align=\"right\">
                  <br>
                  <input onclick=\"clear_all();\" type=\"button\" value=\"L&ouml;schen\">
                </td>
              </tr>
            </table>
            <input type=\"hidden\" name=\"last_translation\" value=\"".$p_german."\">
            <input type=\"hidden\" name=\"last_race\" value=\"".$p_race."\">
          </form>
        </td>
      </tr>
      <tr>
        <td align=\"center\">
          <br>
          <Font style=\"font-size:8.5pt; font-family:Verdana; font-weight:bold;text-align:center;\">
            &Uuml;bersetzungen: ".$translation->format_number($count_translations)."
            <br>
          </Font>
          <br>
        </td>
      </tr>      
    </table>
	</body>
</html>";
	$mysql->close();
?>