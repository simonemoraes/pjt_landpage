<?php
/**
 * Template View pattern implementation
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class Pagina extends TPage
{
    /**
     * Constructor method
     */
     
     private $form;
     private $html;
     private $landpage;
     private $template;
     
    public function __construct()
    {
        parent::__construct();
        
        // create the HTML Renderer
        $this->landpage = new THtmlRenderer('app/resources/pagina2.html');
                
        $this->html = $this->onShow();

        parent::add($this->landpage);
    }
    
    public function onShow(){
        $meuform = new Formulario();
        
        $this->form = $meuform->onCreateFormOutLabel();
        $this->html = $this->landpage;
        
        $array = array();
    	$array['formulario'] = $this->form;
    	
    	// habilitando a sessao no html
    	$this->html->enableSection('main', $array);
    	
    	return $this->html;
    }
    
    public function onSend($param)
    {
        try
        {
            $data = $this->form->getData();
            
            // run form validation
            $this->form->validate();
            
            // creates a string with the form element's values
            $message = 'Nome : ' . $data->input_nome . '<br>';
            $message.= 'Email : ' . $data->input_email . '<br>';
            $message.= 'Telefone : ' . $data->input_telefone . '<br>';
            $message.= 'Mensagem : ' . $data->mensagem . '<br>';
            
            $object = new stdClass();
            $object->input_nome = '';
            $object->input_email = '';
            $object->input_telefone = '';
            $object->mensagem = '';
            
            //$this->form->setData($object);
            
            // show the message
            //new TMessage('info', $message);
            
            $location = 'https://sandbox.adiantibuilder.com.br/ruiandersonsantos/sgs/negociacao/1/onRegistraNegociacao';
       
            $parameters = [
                'empresa_id' => '1',
                'input_nome' => $data->input_nome,
                'input_email' => $data->input_email,
                'input_telefone' => $data->input_telefone,
                'mensagem' => $data->mensagem
            ];
           
            $rest_key = 'ea34516d1556532a1cd95266277db00c60d261ba06f2acac7393dbb5f929';
            $data = AdiantiHttpClient::request($location, 'POST', $parameters, 'Basic '.$rest_key);
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
        }
        catch (Exception $e)
        {
             new TMessage('error', $e->getMessage());
        }
    }
}
