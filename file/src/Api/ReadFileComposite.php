<?php

namespace Zrcms\File\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\File\Exception\CanNotReadFile;
use Zrcms\File\Model\ServiceAliasFile;
use Zrcms\ServiceAlias\Api\GetServiceAliasesByNamespace;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadFileComposite implements ReadFile
{
    protected $getServiceAliasesByNamespace;
    protected $getServiceFromAlias;
    protected $fileReaderServiceAliasNamespace;

    /**
     * @param GetServiceAliasesByNamespace $getServiceAliasesByNamespace
     * @param GetServiceFromAlias          $getServiceFromAlias
     * @param string                       $fileReaderServiceAliasNamespace
     */
    public function __construct(
        GetServiceAliasesByNamespace $getServiceAliasesByNamespace,
        GetServiceFromAlias $getServiceFromAlias,
        string $fileReaderServiceAliasNamespace = ServiceAliasFile::ZRCMS_FILE_READER
    ) {
        $this->getServiceAliasesByNamespace = $getServiceAliasesByNamespace;
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->fileReaderServiceAliasNamespace = $fileReaderServiceAliasNamespace;
    }
    
    /**
     * @param ServerRequestInterface $request
     * @param string                 $filePathUri
     * @param array                  $options
     *
     * @return string
     * @throws CanNotReadFile
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $filePathUri,
        array $options = []
    ): string {
        $readFileServiceAliases = $this->getServiceAliasesByNamespace->__invoke(
            $this->fileReaderServiceAliasNamespace
        );

        foreach ($readFileServiceAliases as $serviceAlias => $readFileServiceName) {
            /** @var ReadFile $readFile */
            $readFile = $this->getServiceFromAlias->__invoke(
                $this->fileReaderServiceAliasNamespace,
                $serviceAlias,
                ReadFile::class,
                ''
            );
            try {
                $fileContents = $readFile->__invoke(
                    $request,
                    $filePathUri);
            } catch (CanNotReadFile $e) {
                continue;
            }

            return $fileContents;
        }

        throw new CanNotReadFile(
            'No valid file readers for file path uri: ' . $filePathUri
        );
    }
}
