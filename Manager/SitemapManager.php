<?php

namespace JHV\Bundle\SeoBundle\Manager;

use JHV\Bundle\SeoBundle\Templating\SeoRendererInterface;
use Symfony\Component\HttpFoundation\Response;
use JHV\Bundle\SeoBundle\Manager\SeoManagerInterface;

/**
 * SitemapManager.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
class SitemapManager implements SitemapManagerInterface
{

    protected $path;
    protected $manager;
    protected $sitemapEntities;
    protected $templating;

    protected $populated;
    protected $onlyIndexed;

    public function __construct(SeoManagerInterface $manager, SeoRendererInterface $templating, $path)
    {
        $this->manager          = $manager;
        $this->templating       = $templating;
        $this->path             = $path;
        $this->sitemapEntities  = array();

        $this->populated        = false;
        $this->onlyIndexed      = false;
    }

    /**
     * @inheritdoc
     */
    public function generate($filename = null, $onlyIndexed = true)
    {
        if (false === $this->populated || $this->onlyIndexed !== $onlyIndexed) {
            $this->populate($onlyIndexed);
        }

        // Renderização do XML
        $content = $this->render();
        return $this->save($content, $filename);
    }

    /**
     * @inheritdoc
     */
    public function generateOnDirectory($dir, $filename = null, $onlyIndexed = true)
    {
        if (false === $this->populated || $this->onlyIndexed !== $onlyIndexed) {
            $this->populate($onlyIndexed);
        }

        // Efetuar a geração dos itens
        $content = $this->render();
        return $this->save($content, $filename, $onlyIndexed, $dir);
    }

    /**
     * @inheritdoc
     */
    public function generateAndDownload($filename = null, $onlyIndexed = true)
    {
        $filename   = $this->generate($filename, $onlyIndexed);
        $contents   = file_get_contents($this->getPath() . '/' . $filename);

        $response = new Response($contents);
        $response->headers->set('Content-Type', 'application/xml');
        $response->headers->set('Content-Disposition', 'attachment; filename="sitemap.xml"');

        return $response;
    }

    /**
     * @inheritdoc
     */
    public function getPath($dir = null, $create = true)
    {
        $dir = $dir ?: $this->path;
        if (false === realpath($dir) && false === is_dir($dir)) {
            $dir = $this->path;
            if (true === $create && false === @mkdir($this->path, 0777, true)) {
                throw new \RuntimeException('Problems when creating a sitemap directory');
            }
        }

        return trim($dir, '/ ');
    }

    /**
     * Efetuar a renderização das entidades para o XML.
     *
     * @return  string
     */
    protected function render()
    {
        return $this->templating->renderSitemap($this->sitemapEntities);
    }

    /**
     * Efetuar a geração do arquivo e salvar em disco físico.
     *
     * @param   string      $content
     * @param   null|string $filename
     * @param   bool        $replace
     * @param   null|string $dir
     * @throws  \RuntimeException
     * @return  string
     */
    protected function save($content, $filename = null, $replace = true, $dir = null)
    {
        $filename   = $filename ?: md5(rand());
        if ('xml' != pathinfo($filename, PATHINFO_EXTENSION)) {
            $filename = sprintf('%s.%s', $filename, 'xml');
        }

        try {
            $fullName = $this->getPath($dir) .'/'. $filename;
            if (true === $replace && true === file_exists($fullName)) {
                @unlink($fullName);
            }

            file_put_contents($fullName, $content);
            return $filename;
        } catch (\Exception $e) {
            throw new \RuntimeException('Problems to save the file.');
        }
    }

    /**
     * Localizar e definir as entidades de SEO que devem ser mapeadas.
     *
     * @param   bool    $onlyIndexed
     * @return  void
     */
    protected function populate($onlyIndexed = true)
    {
        $entities = $this->manager->findAll();
        foreach ($entities as $entity) {
            // Verificar a opção de somentes indexados
            if (true === $onlyIndexed) {
                // Analisar os meta names, para verificar no caso o robots
                $metas = $entity->getMetas();
                if (isset($metas['name']['robots']) && false !== strpos($metas['name']['robots'], 'index') && false === strpos($metas['name']['robots'], 'noindex')) {
                    $this->sitemapEntities[] = $entity;
                }
            } else {
                $this->sitemapEntities[] = $entity;
            }
        }

        $this->populated    = true;
        $this->onlyIndexed  = $onlyIndexed;
    }

}