<?php

class PaginaInicial extends TPage
{

    protected $landpage = "";
    protected $form;
    protected $nome_empresa;
    
    public function __construct()
    {
        parent::__construct();
        
        $location = 'https://sandbox.adiantibuilder.com.br/ruiandersonsantos/sgs/licenca/1/getLicencaByUrl';
        
        $parameters = ['dominio' => $_SERVER['HTTP_HOST'] ];
                   
        $rest_key = Util::API_KEY;
        $retorno = AdiantiHttpClientModify::request($location, 'POST', $parameters, 'Basic '.$rest_key);
                    
        if($retorno && !empty($retorno[0])){
            
            $obj_array = json_decode($retorno[0]);
            
            if($obj_array->data->status == "sucesso"){
            
                Util::carregaVariavelLicencaParaSecao($obj_array);
                
                $this->landpage = new THtmlRenderer('app/resources/interfaces/pagina2.html');                
                $this->onCreateFormulario();
                  
            }else{
            
                      
                $this->landpage =  new THtmlRenderer("app/resources/interfaces/manutencao.html");
                 //$this->landpage =  new THtmlRenderer("app/resources/interfaces/mensagem_sucesso.html");
//                 $this->landpage =  new THtmlRenderer("app/resources/interfaces/mensagem_erro.html"); 

                $array = [];
                $array['nome_empresa'] = TSession::getValue('nome_empresa_licenca');
                              
                $this->landpage->enableSection('main', $array);
            
            }        
        }
        
        parent::add($this->landpage);
    }
        
    public function onCreateFormulario(){
    
        $meuform = new Formulario();       
        $this->form = $meuform->onCreateFormOutLabel();
        $this->nome_empresa = TSession::getValue('nome_empresa_licenca');
               
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
//             $message = 'Nome : ' . $data->input_nome . '<br>';
//             $message.= 'Email : ' . $data->input_email . '<br>';
//             $message.= 'Telefone : ' . $data->input_telefone . '<br>';
//             $message.= 'Mensagem : ' . $data->mensagem . '<br>';
//             
             $object = new stdClass();
             $object->input_nome = '';
             $object->input_email = '';
             $object->input_telefone = '';
             $object->mensagem = '';
            
            // show the message
            // new TMessage('info', TSession::getValue('nome_empresa_licenca'));
            
            $location = 'https://sandbox.adiantibuilder.com.br/ruiandersonsantos/sgs/negociacao/1/onRegistraNegociacao';
       
            $parameters = [
                'empresa_id' => TSession::getValue('empresa_id_licenca'),
                'input_nome' => $data->input_nome,
                'input_email' => $data->input_email,
                'input_telefone' => $data->input_telefone,
                'mensagem' => $data->mensagem              
            ];
           
            $rest_key = Util::API_KEY;
            $data = AdiantiHttpClientModify::request($location, 'POST', $parameters, 'Basic '.$rest_key);
            $retorno = json_decode($data[0]);
            
            $this->form->setData($object);
            
            
            //new TMessage('info', 'Mensagem enviada com sucesso', null, 'Teste de Titulo');
            
            AdiantiCoreApplication::loadPage('MensagemSucesso','onShow',null);//alterado pelo Rui
            
            
        }
        catch (Exception $e)
        {
             new TMessage('error', $e->getMessage());
        }
    
    }
    
}






















