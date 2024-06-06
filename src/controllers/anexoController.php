<?php
function ouvidoriaAnexosController(): Response{
    $methods = [
        "GET" => "anexoGet",
        "POST" => "anexoPost",
        "DELETE" => "anexoDelete",
    ];
    
    if (!isset($_SESSION['userId']))
        return new Response(401,[ ]);    

    if(isset($methods[$_SERVER["REQUEST_METHOD"]]))
        return $methods[$_SERVER["REQUEST_METHOD"]]();
    
    return new Response(400,["error"=> "Metodo não permitido"]);
}

function anexoGet(): Response{
    //Pegar os dados
    {
        $idAnexo = (int) $_REQUEST['idAnexo'];
    }
    //validar
    {
        $fieldErrors = [];
        if($idAnexo == null)
            $fieldErrors["$idAnexo"] = "id do anexo invalido";
        
        if(count($fieldErrors)>0) 
            return new Response(400, ["error" => "Erros ao validar os Parametros",  "fields" => $fieldErrors]);
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    echo base64_decode(anexoRepoSelectArquivo($idAnexo));
}
function anexoPost(): Response{
    //Pegar os dados
    {
        $idOuvidoria = $_REQUEST['idOuvidoria'];
        $fileTempPath = $_FILES["file"]['tmp_name'];
        $name = $_FILES["file"]['name'];
    }
    //validar
    {
        $fieldErrors = [];
        if($idOuvidoria == null)
            $fieldErrors["idOuvidoria"] = "id da Ouvidoria invalido";
        
        if(count($fieldErrors)>0) 
            return new Response(400, ["error" => "Erros ao validar os Parametros",  "fields" => $fieldErrors]);
    }

    // $idsAnexos = [];
    // foreach ($_FILES as $key => $file) {
    //     $id = ouvidoriaAnexoRepoInsert($idOuvidoria, base64_encode(file_get_contents($file['tmp_name'])));
    //     array_push($idsAnexos, $id); 
    // }
    // return new Response(201, ["idsOuvidorias" => $id]);
    $id = anexoRepoInsert($idOuvidoria, $name, base64_encode(file_get_contents($fileTempPath)));
    return new Response(201, ["idAnexo" => $id]);
}
function anexoDelete(): Response{
    //Pegar os dados
    {
        $idAnexo = $_REQUEST['idAnexo'];
    }
    //validar
    {
        if(!is_integer($idAnexo))
            $fieldErrors["idAnexo"] = "id do anexo invalido";
        
        if(count($fieldErrors)>0) 
            return new Response(400, ["error" => "Erros ao validar os Parametros",  "fields" => $fieldErrors]);
    }
    anexoRepoDelete($idAnexo);
    return new Response(200, ["idAnexo" => $idAnexo]);
}