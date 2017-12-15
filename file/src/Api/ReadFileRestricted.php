<?php

namespace Zrcms\File\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\File\Exception\CanNotReadFile;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadFileRestricted extends ReadFileDefault implements ReadFile
{
    const SERVICE_ALIAS = 'restricted';
    const READER_SCHEME = 'restricted';

    protected $isAllowed;
    protected $isAllowedOptions = [];

    /**
     * @param IsAllowed $isAllowed
     * @param array     $isAllowedOptions
     */
    public function __construct(
        IsAllowed $isAllowed,
        array $isAllowedOptions = []
    ) {
        $this->isAllowed = $isAllowed;
        $this->isAllowedOptions = $isAllowedOptions;
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
        AssertValidReaderScheme::invoke(
            static::READER_SCHEME,
            $filePathUri
        );
        $allowed = $this->isAllowed->__invoke(
            $request,
            $this->isAllowedOptions
        );

        if (!$allowed) {
            throw new CanNotReadFile(
                'Not allowed to read file: ' . $filePathUri
                . ' from: ' . get_class($this->isAllowed)
                . ' with options: ' . json_encode($this->isAllowedOptions, 0, 5)
            );
        }

        return parent::__invoke(
            $request,
            $filePathUri,
            $options
        );
    }
}
