<?php
function ouvidoriaRepoSelectAll(int $page = 0, int $count = 50): array{
    $db = connectToDatabase();
    $db->beginTransaction();

    $prepare = $db->prepare(
        "SELECT ou.*, us.nome AS usuario_nome FROM ouvidorias ou 
        INNER JOIN usuarios us ON (ou.id_usuario = us.id_usuario) 
        LIMIT :limit OFFSET :offset"
    );

    $offset = $page * $count;
    $prepare->bindParam(':limit', $count, PDO::PARAM_INT);
    $prepare->bindParam(':offset', $offset, PDO::PARAM_INT);
    $prepare->execute();
    $resultArray = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $db->commit();
    return $resultArray;
}

function ouvidoriaRepoSelectOne(int $idOuvidoria): array{
    $db = connectToDatabase();
    $db->beginTransaction();

    $prepare = $db->prepare(
        "SELECT ou.*, 
            an.id_anexo, 
            an.nome AS anexo_nome
        FROM ouvidorias ou 
        LEFT JOIN anexos an ON (an.id_ouvidoria = ou.id_ouvidoria) 
        WHERE ou.id_ouvidoria = :id"
    );
    
    $prepare->bindParam(':id', $idOuvidoria, PDO::PARAM_INT);
    $prepare->execute();
    $resultArray = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $db->commit();
    return $resultArray;
}


function ouvidoriaRepoInsert(Ouvidoria $ouvidoria): int{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("INSERT INTO ouvidorias VALUES (?, ?, ?, ?)");
    $prepare->execute([
        0, // id_ouvidoria
        $ouvidoria->idUsuario,
        $ouvidoria->descricao,
        $ouvidoria->tipoServico
    ]);
    $id = $db->lastInsertId();
    $db->commit();
    return $id;
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
        array_push($ouvidorias, Ouvidoria::mapToOuvidoriaRetornoAll($result));
    }
    return new Response(200, $ouvidorias);
}

function ouvidoriaPost(): Response{
    //Pegar dados enviados
    {
        $input = json_decode(file_get_contents('php://input'), TRUE);
        $ouvidoria = new Ouvidoria(
            0,
            $input["idUsuario"],
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