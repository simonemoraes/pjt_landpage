<?php
class Util{

    const API_KEY = 'ea34516d1556532a1cd95266277db00c60d261ba06f2acac7393dbb5f929';
    
    
    public static function carregaVariavelLicencaParaSecao($licenca){
    
    
        TSession::setValue('celular_licenca',$licenca->data->celular);
        TSession::setValue('responsavel_licenca',$licenca->data->responsavel);
        TSession::setValue('telefone_licenca',$licenca->data->telefone);
        TSession::setValue('nome_empresa_licenca',$licenca->data->nome_empresa);
        TSession::setValue('empresa_id_licenca',$licenca->data->empresa_id);
           
    
    }
    
    

}
