<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Symfony\Component\Filesystem\Filesystem;

class Acceptance extends \Codeception\Module
{
    /**
     * Build a local repo that Composer can use as a path repository.
     *
     * @param array $settings
     */
    public function _beforeSuite($settings = [])
    {
        $filesystem = new Filesystem();
        if ($filesystem->exists($this->_getPluginDir())) {
            $this->_afterSuite();
        }
        $filesystem->mkdir($this->_getPluginDir());
        $filesystem->mirror($this->_getProjectRoot() . '/src', $this->_getPluginDir() . '/src');
        $filesystem->copy($this->_getProjectRoot() . '/composer.json', $this->_getPluginDir() . '/composer.json');
    }

    public function _afterSuite()
    {
        $filesystem = new Filesystem();
        $filesystem->remove($this->_getPluginDir());
    }

    protected function _getFixturesDir()
    {
        return dirname(__DIR__, 2) . '/acceptance/fixtures';
    }

    protected function _getPluginDir()
    {
        return $this->_getFixturesDir() . '/composer-patches';
    }

    protected function _getProjectRoot()
    {
        return dirname(__DIR__, 3);
    }

}