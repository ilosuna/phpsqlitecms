<?php
/**
 * Mail class to send e-mails
 *
 * @author Mark Alexander Hoschek <alex at mylittlehomepage dot net>
 * @copyright 2010 Mark Alexander Hoschek
 */

class Mail
 {
  const MAIL_HEADER_SEPARATOR = "\n"; // "\r\n" complies with RFC 2822 but might cause problems in some cases (see http://php.net/manual/en/function.mail.php)
  const MAIL_HEADER_TRANSFER_ENCODING = 'Q'; // 'B' for Base64 or 'Q' for Quoted-Printable
  private $charset = 'utf-8';

  public function __construct()
   {
    mb_internal_encoding($this->charset);
   }

  /**
   * Sets charset of the e-mail.
   *
   * @param string $charset
   */
  public function set_charset($charset)
   {
    $this->charset = $charset;
    mb_internal_encoding($this->charset);
   }

  /**
   * Checks whether an e-mail address is (syntactically) valid or not.
   *
   * @param string $email
   * @return bool
   */
  public function is_valid_email($email)
   {
    if(preg_match("/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $email))
     {
      return true;
     }
    return false;
   }

  /**
   * escapes double-quotes and encloses display names in double-quotes if necessary
   *
   * @param string $display_name
   * @return string
   */
  public function escape_display_name($display_name)
   {
    $display_name = str_replace('"', '\\"', $display_name);
    if(preg_match("/(\.|\;|\")/", $display_name))
     {
      return '"'.mb_encode_mimeheader($display_name, $this->charset, self::MAIL_HEADER_TRANSFER_ENCODING, self::MAIL_HEADER_SEPARATOR).'"';
     }
    else
     {
      return mb_encode_mimeheader($display_name, $this->charset, self::MAIL_HEADER_TRANSFER_ENCODING, self::MAIL_HEADER_SEPARATOR);
     }
   }

  /**
   * puts together e-mail display and address (e.g. "Joe Q. Public" <john.q.public@example.com>)
   *
   * @param string $display_name
   * @param string $email
   * @return string
   */
  public function make_address($display_name, $email)
   {
    return $this->escape_display_name($display_name).' <'.$email.'>';
   }

  /**
   * removes line breaks to avoid e-mail header injections
   *
   * @param string $string
   * @return string
   */
  private function mail_header_filter($string)
   {
    #return preg_replace("/(\015\012|\015|\012|content-transfer-encoding:|mime-version:|content-type:|subject:|to:|cc:|bcc:|from:|reply-to:)/ims", '', $string);
    #return preg_replace("/(\015\012|\015|\012|to:|cc:|bcc:|from:|reply-to:)/ims", '', $string);
    return preg_replace("/(\015\012|\015|\012)/", '', $string);
   }

  /**
   * Encode string to quoted-printable.
   * Original written by Andy Prevost http://phpmailer.sourceforge.net
   * and distributed under the Lesser General Public License (LGPL) http://www.gnu.org/copyleft/lesser.html
   *
   * @return string
   */
  private function my_quoted_printable_encode($input, $line_max=76, $space_conv = false )
   {
    $hex = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
    $lines = preg_split('/(?:\r\n|\r|\n)/', $input);
    $eol = "\n";
    $escape = '=';
    $output = '';
    while(list(, $line) = each($lines))
     {
      $linlen = strlen($line);
      $newline = '';
      for($i = 0; $i < $linlen; $i++)
       {
        $c = substr($line, $i, 1);
        $dec = ord( $c );
        if(($i == 0) && ($dec == 46)) // convert first point in the line into =2E
         { 
          $c = '=2E';
         }
        if($dec == 32)
         {
          if($i==($linlen-1)) // convert space at eol only
           {
            $c = '=20';
           }
          elseif($space_conv)
           {
            $c = '=20';
           }
          }
         elseif(($dec == 61) || ($dec < 32) || ($dec > 126)) // always encode "\t", which is *not* required
          { 
           $h2 = floor($dec/16);
           $h1 = floor($dec%16);
           $c = $escape.$hex[$h2].$hex[$h1];
          }
         if((strlen($newline) + strlen($c)) >= $line_max) // CRLF is not counted
          { 
           $output .= $newline.$escape.$eol; //  soft line break; " =\r\n" is okay
           $newline = '';
           if($dec == 46) // check if newline first character will be point or not
            {
             $c = '=2E';
            }
          }
         $newline .= $c;
       } // end of for
      $output .= $newline.$eol;
     } // end of while
    return $output;
   }

  /**
  * sends an e-mail
  *
  * @param string $to
  * @param string $subject
  * @param string $message
  * @param string $headers
  * @return bool
  */
  public function send($to, $from, $subject, $message, $additional_parameters='')
   {
    $to = $this->mail_header_filter($to);
    $subject = mb_encode_mimeheader($this->mail_header_filter($subject), $this->charset, self::MAIL_HEADER_TRANSFER_ENCODING, self::MAIL_HEADER_SEPARATOR);
    $message = $this->my_quoted_printable_encode($message);

    $headers  = "From: " . $this->mail_header_filter($from) . self::MAIL_HEADER_SEPARATOR;
    $headers .= "MIME-Version: 1.0" . self::MAIL_HEADER_SEPARATOR;
    $headers .= "X-Sender-IP: ".$_SERVER["REMOTE_ADDR"] . self::MAIL_HEADER_SEPARATOR;
    #$headers .= "X-Mailer: " . BASE_URL . self::MAIL_HEADER_SEPARATOR;
    $headers .= "Content-Type: text/plain; charset=" . $this->charset . self::MAIL_HEADER_SEPARATOR;
    $headers .= "Content-Transfer-Encoding: quoted-printable";

    if($additional_parameters)
     {
      if(@mail($to, $subject, $message, $headers, $additional_parameters))
       {
        return true;
       }
      else
       {
        return false;
       }
     }
    else
     {
      if(@mail($to, $subject, $message, $headers))
       {
        return true;
       }
      else
       {
        return false;
       }
     }
   }
 }
?>
