<?php

namespace JHV\Bundle\SeoBundle\Manager;

use Symfony\Component\HttpFoundation\Response;

/**
 * SitemapInterface.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
interface SitemapManagerInterface
{

    /**
     * Efetuar a geração do sitemap.
     *
     * @param   null|string     $filename
     * @param   bool            $onlyIndexed
     * @return  string
     */
    public function generate($filename = null, $onlyIndexed = true);

    /**
     * Efetuar a geração e mapeamento do arquivo XML.
     * Após efetuar o mapeamento, gerar o arquivo em disco físico.
     *
     * @param   string      $dir
     * @param   null|string $filename
     * @param   bool        $onlyIndexed
     * @return  string
     */
    public function generateOnDirectory($dir, $filename = null, $onlyIndexed = true);

    /**
     * Efetuar geração do mapa do site para um arquivo XML
     * e posteriormente efetuar o download deste arquivo.
     *
     * @param   null|string     $filename
     * @param   bool            $onlyIndexed
     * @throws  \RuntimeException
     * @return  Response
     */
    public function generateAndDownload($filename = null, $onlyIndexed = true);

    /**
     * Verificar o local no qual o arquivo de sitemap deve
     * ser salvo, retornando o caminho completo.
     *
     *
     * @param   null|string     $dir
     * @param   bool            $create
     * @return  string
     */
    public function getPath($dir = null, $create = true);

}