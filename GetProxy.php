<?php

/*
 *  Exemplo de uso:
 *  $example = new \rqdev\GetProxy\Proxy();
 *  $example->SetKey(' <Sua Chave> ');
 *  $example->SetParameters('area=US&page=100');
 *  $example->Get();
 *  $ProxyList = $example->GetProxys();
 *  var_dump($ProxyList);
 */
namespace rqdev\GetProxy;

class Proxy
{

    /**
     *  Por favor, cadastre-se no site e adquira sua própria chave, esta pode
     *  parar em algum momento.
     *  http://www.getproxy.jp/en/api
     *    Parameter        |   Value                  |	Description
     *    ApiKey(Not Null) |                          |
     *    area(Not Null)      Code                    |    Code Table
     *    page             |  1~100                   |
     *    type             |  all,https               |
     *    sort             |  requesttime,updatetime  | requesttime:order by 
     *     *               |                          | Response Time,
     *     *               |                          | updatetime:Order by 
     *     *               |                          | Update Time
     *    orderby          |   asc,desc               | asc:Ascend,desc:Descend
     *    
     *    @author   Henrique da Silva Santos <rique_dev@hotmail.com>
     **/


     #  Chave da Api para requisição da lista de proxys.
    protected  $Apikey      = 'f9a8949d5e2f8e56e28653fb3da4c3aeb16c279b';
    
    #   Parametros para requisição (ApiKey e area não podem ser nulos!
    protected  $parameters  = 'area=BR&page=10&sort=requesttime';
    
    #   Site da API
    protected  $url         = 'http://www.getproxy.jp/proxyapi?';
    
    #   URL final para requisição
    public     $requestUrl  = null;
    
    #   Listagem de Proxys
    public     $ProxyList   = array();

    
    #   Requisição
    public function Get()
    {
       $this->requestUrl = $this->url.'ApiKey='.$this->Apikey.'&'.$this->parameters;
       $this->RequestAndConvert();
    }
    
    #Setar a APIKey
    public function SetKey($key)
    {
        $this->Apikey = $key;
    }
     
    #Setar parametros
    public function SetParameters($parameters)
    {
        $this->parameters = $parameters;
    }
    
    #Requisição e conversão dos resultados.
    protected function RequestAndConvert()
    {
        $xml = simplexml_load_string(file_get_contents($this->requestUrl));
        $json = json_encode($xml);
     
        
        
        foreach(json_decode($json) as $key => $proxypos)
        {
            foreach($proxypos as $pos => $proxyinfo)
            {
                
                array_push($this->ProxyList, array(
                'IP'            => $proxyinfo->ip,
                'request_time'  => $proxyinfo->requesttime,
                'area'          => $proxyinfo->area,
                'http'          => $proxyinfo->http,
                'https'         => $proxyinfo->https,
                'anonymous'     => $proxyinfo->anonymous,
                'type'          => $proxyinfo->type,
                'twoch'         => $proxyinfo->twoch
                ));
                
            }
                
        }
        
    }
    
    #   Return dos dados capturados (não é necessário)
    public function GetProxys()
    {
        return $this->ProxyList;
    }
    
    
}



?>