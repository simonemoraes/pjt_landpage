<?php

class Formulario extends TPage
{
    private $form;
    
    public function __construct($param = null)
    {
        parent::__construct();
        
    }
    
    public function onCreateFormOutLabel()
    {
        try
        {
            
            // criando Formulário
            $this->form = new TForm('my_form');
            $div_form_contato = new TElement('div');
            $div_form_contato->id = 'div_form_contato';
            
            /*
             * Criando uma div para cada os campos do formulário
             * Nessa div será atribuido uma classe row
             * Essa div representará uma linha para cada campo do formulário
             */
            $div_row1 = new TElement('div');
            $div_row2 = new TElement('div');
            $div_row3 = new TElement('div'); 
            $div_row4 = new TElement('div'); 
            
            $div_row1->{'class'} = 'row';       
            $div_row2->{'class'} = 'row';      
            $div_row3->{'class'} = 'row';      
            $div_row4->{'class'} = 'row justify-content-center';
            
            /*
             * Criando uma div para cada linha do formulário
             * Nessa div será atribuido uma classe col para determinar a largura de cada coluna
             */
            $div_col_nome = new TElement('div');
            $div_col_email = new TElement('div');
            $div_col_telefone = new TElement('div');
            $div_col_mensagem = new TElement('div');
            $div_col_button = new TElement('div');
            
            $div_col_nome->{'class'} = 'col';       
            $div_col_email->{'class'} = 'col';      
            $div_col_telefone->{'class'} = 'col';      
            $div_col_mensagem->{'class'} = 'col';
            $div_col_button->{'class'} = 'col-6';
            
            /*
             * Criando uma div para cada linha do formulário
             * Nessa div será atribuido uma classe form-group 
             * A classe form-group é uma classe padrão do bootstrap usada em formulário para cada input criado
             */
            $div_group_nome = new TElement('div');
            $div_group_email = new TElement('div');
            $div_group_telefone = new TElement('div');
            $div_group_mensagem = new TElement('div');
                        
            $div_group_nome->{'class'} = 'form-group';       
            $div_group_email->{'class'} = 'form-group';      
            $div_group_telefone->{'class'} = 'form-group';      
            $div_group_mensagem->{'class'} = 'form-group';
            
            
            
            //Criando os inputs
            $input_nome = new TEntry('input_nome');
            $input_email = new TEntry('input_email');
            $input_telefone = new TEntry('input_telefone');
            $input_mensagem = new TText('mensagem');
                                    
            // Atribuindo Ids aos inputs
            $input_nome->id = 'input_nome';
            $input_nome->{'class'} = 'form-control'; 
            $input_nome->placeholder = 'Seu Nome';
            $input_email->id = 'input_email';
            $input_email->{'class'} = 'form-control'; 
            $input_email->placeholder = 'Seu E-mail';
            $input_telefone->id = 'input_telefone';
            $input_telefone->{'class'} = 'form-control'; 
            $input_telefone->placeholder = 'Seu Telefone';
            $input_mensagem->id = 'input_mensagem';
            $input_mensagem->{'class'} = 'form-control'; 
            $input_mensagem->placeholder = 'Deixe sua mensagem';
            
             //Validando os campos
             $input_nome->addValidation('Nome', new TMinLengthValidator, array(3));
             $input_email->addValidation('Email', new TEmailValidator); 
             $input_telefone->addValidation('Telefone', new TNumericValidator);
             $input_mensagem->addValidation('Mensagem', new TRequiredValidator);
                 
             // Criando o botao que fará a submissao do formulário
             $button = new TButton('action1');
             $button->setAction(new TAction(array('PaginaInicial', 'enviaDadosFormularioContato')), 'Enviar');
             $button->id = 'botao_form_contato';
             
             // Adicionando os campos ao formulário
             $this->form->setFields([$input_nome, $input_email, $input_telefone, $input_mensagem, $button]);
             
             $div_group_nome->add($input_nome);
             $div_group_email->add($input_email);
             $div_group_telefone->add($input_telefone);
             $div_group_mensagem->add($input_mensagem); 
                                       
             $div_col_nome->add($div_group_nome); 
             $div_col_email->add($div_group_email);
             $div_col_telefone->add($div_group_telefone);
             $div_col_mensagem->add($div_group_mensagem);
             $div_col_button->add($button);
                         
             $div_row1->add($div_col_nome);
             $div_row2->add($div_col_email);
             $div_row2->add($div_col_telefone);
             $div_row3->add($div_col_mensagem);
             $div_row4->add($div_col_button);
                          
             $div_form_contato->add($div_row1);
             $div_form_contato->add($div_row2);
             $div_form_contato->add($div_row3);
             $div_form_contato->add($div_row4);
             
           
              $this->form->add($div_form_contato);
           
            return $this->form;
            
        }
        catch (Exception $e)
        {
             new TMessage('error', $e->getMessage());
        }
    }
    
    
}
