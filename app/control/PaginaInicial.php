<?php

class PaginaInicial extends TPage
{

    protected $landpage = "";
    protected $form;
    
    public function __construct()
    {
        parent::__construct();
        
        

        $location = 'https://sandbox.adiantibuilder.com.br/ruiandersonsantos/sgs/licenca/1/getLicencaByUrl';
    
        $parameters = [
                        'dominio' => $_SERVER['HTTP_HOST']
                               
                    ];
                   
        $rest_key = Util::API_KEY;
        $retorno = AdiantiHttpClientModify::request($location, 'POST', $parameters, 'Basic '.$rest_key);
                    
        if($retorno && !empty($retorno[0])){
            
            $obj_array = json_decode($retorno[0]);
            
            if($obj_array->data->status == "sucesso"){
                
                $this->landpage = new THtmlRenderer('app/resources/pagina2.html');
                
                $this->onCreateFormulario();
                
               
               
            }else{
            
                $this->landpage =  new THtmlRenderer("app/resources/manutencao.html");
                
                
                $this->landpage->enableSection('main', false);
               
            
            }
        
        }
    
        
        
        parent::add($this->landpage);
    }
    
    
    public function onCreateFormulario(){
    
        $meuform = new Formulario();
        
        $this->form = $meuform->onCreateFormOutLabel();
        
        $array = [];
        
        $array['formulario'] = $this->form;
        
        $this->landpage->enableSection('main', $array);
    
    }
    
    public function enviaDadosFormularioContato($params = null){
    
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
           
            $rest_key = Util::API_KEY;
            $data = AdiantiHttpClientModify::request($location, 'POST', $parameters, 'Basic '.$rest_key);
            
            $this->form->setData($object);
            
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

