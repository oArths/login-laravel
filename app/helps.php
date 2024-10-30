<?php
    function jsonResponse($mensagem, $status = 201, $data = []){
        return response()->json([
            'message'=> $mensagem,
            'data' =>$data,
        ], $status);
    }