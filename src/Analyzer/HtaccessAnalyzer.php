<?php

/*
 * This file is part of Contao.
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao\CoreBundle\Analyzer;

/**
 * Analyzes an .htaccess file.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class HtaccessAnalyzer
{
    /**
     * @var \SplFileInfo
     */
    private $file;

    /**
     * Stores the file object.
     *
     * @param \SplFileInfo $file
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(\SplFileInfo $file)
    {
        if (!$file->isFile()) {
            throw new \InvalidArgumentException(sprintf('%s is not a file.', $file));
        }

        $this->file = $file;
    }

    /**
     * Creates a new object instance.
     *
     * @param \SplFileInfo $file
     *
     * @return static
     */
    public static function create(\SplFileInfo $file)
    {
        return new static($file);
    }

    /**
     * Checks whether the .htaccess file grants access via HTTP.
     *
     * @return bool
     */
    public function grantsAccess()
    {
        $content = array_filter(file($this->file));

        foreach ($content as $line) {
            if ($this->hasRequireGranted($line)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Scans a line for an access definition.
     *
     * @param string $line
     *
     * @return bool
     */
    private function hasRequireGranted($line)
    {
        if ($this->isComment($line)) {
            return false;
        }

        return (false !== stripos($line, 'Allow from all')) || (false !== stripos($line, 'Require all granted'));
    }

    /**
     * Checks whether a line is a comment.
     *
     * @param string $line
     *
     * @return bool
     */
    private function isComment($line)
    {
        return 0 === strncmp('#', ltrim($line), 1);
    }
}
