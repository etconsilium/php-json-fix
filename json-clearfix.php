<?php call_user_func(function(){

//	http://forum.sources.ru/index.php?showtopic=307683&view=showall #19
runkit_function_copy('json_decode', '__json_decode__') ;
runkit_function_remove('json_decode');

if (!(function_exists('json_decode') || is_callable('json_decode')) ) {	//	без проверки транслятор генерирует ошибку на первом проходе
    function json_decode($json, $assoc=false, $depth=512, $options=JSON_BIGINT_AS_STRING){

    	//		http://php.net/manual/ru/function.json-decode.php#112735
    	//	comments
    	$json = preg_replace('~(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)~', '', $json);

    	//	trailing commas
    	$json=preg_replace('~,\s*([\]}])~mui', '$1', $json);

    	//	empty cells
    	$json = preg_replace('~(.+?:)(\s*)?([\]},])~mui', '$1null$3', $json);
    	// $json = preg_replace('~.+?({.+}).+~', '$1', $json);

    	//	codes	//	@TODO: add \x
    	$json = str_replace(["\n","\r","\t","\0"], '', $json);

    	//	@TODO кавычки
    	// $json = str_replace("'", '"', $json);

        $decode = __json_decode__($json, $assoc, $depth, $options);

        //	\Zend...\Json
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
		        return $decode;
                break;
            case JSON_ERROR_DEPTH:
                throw new RuntimeException('Decoding failed: Maximum stack depth exceeded');
                break;
            case JSON_ERROR_CTRL_CHAR:
                throw new RuntimeException('Decoding failed: Unexpected control character found');
                break;
            case JSON_ERROR_SYNTAX:
                throw new RuntimeException('Decoding failed: Syntax error');
                break;
            default:
                throw new RuntimeException('Decoding error message: '.json_last_error_msg());
                break;
        }
        return null;
    }
}


runkit_function_copy('json_encode', '__json_encode__') ;
runkit_function_remove('json_encode');

if (!(function_exists('json_encode') || is_callable('json_encode')) ) {
    function json_encode($value, $options=JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT){
    	$encode = __json_encode__($value, $options);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
		        return $encode;
                break;
            case JSON_ERROR_DEPTH:
                throw new RuntimeException('Decoding failed: Maximum stack depth exceeded');
                break;
            case JSON_ERROR_CTRL_CHAR:
                throw new RuntimeException('Decoding failed: Unexpected control character found');
                break;
            case JSON_ERROR_SYNTAX:
                throw new RuntimeException('Decoding failed: Syntax error');
                break;
            default:
                throw new RuntimeException('Decoding error message: '.json_last_error_msg());
                break;
        }
        return null;
	}
}

});
