<?php

namespace App\Utils\Cache;

use App\Utils\Debugger;

class File
{
    /**
     * Metodo responsavel por obter uma informacao do cache
     * @param  string
     * @param  int
     * @param  Closure
     * @return mixed|Response
     */
    public static function getCache($hash, $expiration, $function)
    {
        # VERIFICA O CONTEUDO GRAVADO
        if ($content = self::getContentCache($hash, $expiration)) {
            return $content;
        }

        # EXECUCAO DA FUNCAO
        $content = $function();

        # GRAVA O RETORNO DO CACHE
        self::storageCache($hash, $content);

        # RETORNA O CONTEUDO
        return $content;
    }

    /**
     * Metodo reponsavel por guardar informacoes no cache
     * @param  string
     * @param  mixed|Response
     * @return bool
     */
    private static function storageCache($hash, $content)
    {
        # SERIALIZA O CONTEUDO
        $serialize = serialize($content);

        # OBTEM O CAMINHO ATE O ARQUIVO DE CACHE
        $cacheFile = self::getFilePath($hash);

        # GRAVA AS INFORMACOES NO ARQUIVO
        return file_put_contents($cacheFile, $serialize);
    }

    /**
     * Metodo reponsavel por retornar o caminho ate o arquivo de cache
     * @param  string
     * @return string
     */
    private static function getFilePath($hash)
    {
        # DIRETORIO DE CACHE
        $dir =  getenv('CACHE_DIR');


        # VERIFICA A EXISTENCIA DO DIRETORIO
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        # RETORNA O CAMINHO ATE O ARQUIVO
        return $dir . '/' . $hash;
    }

    /**
     * Metodo responsavel por retornar o conteudo gravado on cache
     * @param  string
     * @param  int
     * @return mixed|Response
     */
    private static function getContentCache($hash, $expiration)
    {
        # OBTEM O CAMINHO DO ARQUIVO
        $cacheFile = self::getFilePath($hash);

        # VERIFICA A EXISTENCIA DO ARQUIVO
        if (!file_exists($cacheFile)) return false;

        # VALIDA A EXPIRACAO DO CACHE
        $createTime = filectime($cacheFile);
        $diffTime = time() - $createTime;
        if ($diffTime > $expiration) return false;

        # RETORNA O DADO REAL
        $serialize = file_get_contents($cacheFile);
        return unserialize($serialize);
    }
}
