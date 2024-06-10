<?php
function ouvidoriaController(): Response{    
    $methods = [
        "GET" => "ouvidoriaGet",
        "POST" => "ouvidoriaPost",
        "PUT" => "ouvidoriaPut",
        "DELETE" => "ouvidoriaDelete",
    ];

    if (!isset($_SESSION['userId'])) { 
        return new Response(401, [ ]);    
    }
    
    if(isset($methods[$_SERVER["REQUEST_METHOD"]]))
        return $methods[$_SERVER["REQUEST_METHOD"]]();
    
    return new Response(400,["error"=> "Metodo não permitido"]);
}

function ouvidoriaGet(): Response{
    $idOuvidoria = (int) $_REQUEST['id'];
    $page = (int) $_REQUEST['page'];
    $count = (int) $_REQUEST['count'];

    if($idOuvidoria != null){
        $oneResult = ouvidoriaRepoSelectOne($idOuvidoria);
        $ouvidoria = Ouvidoria::mapToOuvidoriaRetornoOne($oneResult);
        return new Response(200, $ouvidoria);
    }

    if($page == null && $count == null)
        $selectResults = ouvidoriaRepoSelectAll();
    else 
        $selectResults = ouvidoriaRepoSelectAll($page, $count);

    
    $ouvidorias = [];
    foreach($selectResults as $result) {
        array_push($ouvidorias, mapOuvidoriaResult($result));
    }

    foreach ($ouvidorias as $ouvidoria) {
        $anexos = anexoRepoSelectAll($ouvidoria->idOuvidoria);
        $anexosMapeados = [];
        foreach($anexos as $anexo){
            array_push($anexosMapeados, mapOuvidoriaAnexoResult($anexo));
        }
        $ouvidoria->anexos = $anexosMapeados;
    }
    
    return new Response(200, $ouvidorias);
}

function ouvidoriaPost(): Response{
    //Pegar dados enviados
    {
        $input = json_decode(file_get_contents('php://input'), TRUE);
        $ouvidoria = new Ouvidoria(
            0,
            $_SESSION["userId"],
            $input["descricao"],
            $input["tipoServico"],
            [],
            null
        );
    }
    
    //Validações
    //Talvez não seja necessario fazer selects nessa etapa e deixar para dar erro no insert
    {
        //idUsario
        $fieldErrors = [];
        if(userRepoCheckUser($ouvidoria->idUsuario)){
            $fieldErrors["idUsuario"] = "Usuario inexistente";    
        }

        //descricao
        //tipoServico
        //anexos
        if(count($fieldErrors)>0) 
            return new Response(400, ["error" => "Erros ao validar os Campos",  "fields" => $fieldErrors]);
    }


    //Salvar no banco de dados
    {
        $id = ouvidoriaRepoInsert($ouvidoria);
    }
    
    return new Response(201, ["idOuvidoria" => $id]);
}

function ouvidoriaPut(): Response{

}

function ouvidoriaDelete(): Response{

}