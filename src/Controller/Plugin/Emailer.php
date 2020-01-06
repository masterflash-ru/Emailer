<?php
/**
*плагин для контроллеров позволяет делать обращения к Emailer
*/

namespace Mf\Emailer\Controller\Plugin;


use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use Mf\Emailer\Exception;
use Mf\Emailer\View\Renderer\PhpRendererEmailer;
use Laminas\View\Resolver\AggregateResolver;

use Laminas\View\Resolver;
use Laminas\Mail;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part as MimePart;


/**
 * 
 */
class Emailer extends AbstractPlugin
{
    /*собственно рендер HTML*/
    protected $renderer;

    /**
    * получатели, email
    */
    protected $toEmails=[];
    
    /**
    * Тема письма
    */
    protected $Subject="";


    /**
    * обратный адрес письма
    */
    protected $mailFrom="";


public function __construct($config,$ViewHelperManager,$connection) 
{
    $renderer = new PhpRendererEmailer();
    $renderer->setConnectionADOdb($connection);
    $resolver = new AggregateResolver();
    $renderer->setResolver($resolver);
    $renderer->setHelperPluginManager($ViewHelperManager);
    $stack = new Resolver\TemplatePathStack(['script_paths'=>$config['view_manager']['template_path_stack']]);

   $resolver
    ->attach($stack)
    ->attach(new Resolver\RelativeFallbackResolver($stack));
    $this->renderer=$renderer;
    $this->Subject="Сообщение с сайта ".$_SERVER["SERVER_NAME"];
    $this->mailFrom="robot@".$_SERVER["SERVER_NAME"];
}

/*
* быстрый вызов Emailer, если вызвать без параметров, 
* возвращается сам Emailer (этот экземпляр)
* $nameOrModel - строка шаблона (имя) или экземпляр с интерфейсом Laminas\View\Model\ModelInterface, обычно это ViewModel
* $values - если $nameOrModel строка, тогда через $values можно передать переменные в сценарий вывода
* $toEmails - адрес/адреса получателей (стркоа или массив)
* $options - разные опции, ключи массива:
*   Subject - тема сообщения
*   mailFrom - обратный адрес письма
*/
public function __invoke($nameOrModel=null,$values = null, $toEmails=null,array $options=[])
{
    $this->setToEmails($toEmails);
    if (empty($nameOrModel) ){
        return $this;
    }
    $this->setOptions($options);
    //рендер страницы
    $page=$this->Render($nameOrModel,$values);
    $this->sendEmail($page,$toEmails,$options);
}

/**
* установить опции
*/
public function setOptions(array $options)
{
    $options=array_change_key_case($options,CASE_LOWER);
    if (!empty($options["subject"])){
        $this->Subject=$options["subject"];
    }
    if (!empty($options["mailfrom"])){
        $this->mailFrom=$options["mailfrom"];
    }
}

/**
* получить результат рендеринга
* возвращает строку
*/
public function Render($nameOrModel,$values = null)
{
    return $this->renderer->render($nameOrModel,$values);
}

/**
* установить адреса получателей
*/
public function setToEmails($toEmails)
{
    if (!empty($toEmails)){
        if (!is_array($toEmails)){
            $toEmails=[$toEmails];
        }
        $this->toEmails=$toEmails;
    }
}
/**
*получить список получателей, возвращается массив
*/
public function getToEmails()
{
    return $this->toEmails;
}
    
/**
* собственно отправка
* $message - HTML письмо
* $toEmails - получатели, пусто - берется $this->getToEmails();
*/ 
public function sendEmail(string $message, $toEmails=null)
{
    if (!empty($toEmails)){
        if (!is_array($toEmails)){
            $toEmails=[$toEmails];
        }
    } else {
        $toEmails=$this->getToEmails();
    }
    if (empty($toEmails)){
        throw new  Exception\EmptyToEmailsException("Список получателей письма пустой");
    }
    $html = new MimePart($message);
    $html->type = Mime::TYPE_HTML;
    $html->charset = 'utf-8';
    $html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
    $body = new MimeMessage();
    $body->setParts([$html]);
    
    $mail = new Mail\Message();
    $mail->setEncoding("UTF-8");
    $mail->setBody($body);
    $mail->setFrom($this->mailFrom);
    $mail->addTo($this->toEmails);
    $mail->setSubject($this->Subject);
    $transport = new Mail\Transport\Sendmail();
    $transport->send($mail);
}

/**
* установить тему сообщения
* Subject - строка темы
*/
public function setSubject(string $Subject)
{
    $this->Subject=$Subject;
}

/**
* получить тему сообщения
* возвращает строку
*/
public function getSubject()
{
    return $this->Subject;
}
    
/**
* установить обратный адрес сообщения
* Subject - строка темы
*/
public function setMailFrom(string $mailFrom)
{
    $this->mailFrom=$mailFrom;
}

/**
* получить обратный сообщения
* возвращает строку
*/
public function getmailFrom()
{
    return $this->mailFrom;
}

}