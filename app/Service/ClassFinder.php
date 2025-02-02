<?php

namespace App\Service;

/**
 * Class ClassFinder
 *
 * A service class responsible for finding classes under a given namespace.
 * It utilizes composer configuration to locate the appropriate directory
 * for a namespace and retrieves PHP classes within that directory.
 *
 * @package App
 * @author Rashadul Shaon <codershaon@gmail.com>
 * @date 2025-01-23
 * @version 1.0
 * @link https://shaon.pages.dev
 */
class ClassFinder
{
    private string $appRoot;

    public function __construct()
    {
        $this->appRoot = realpath(__DIR__ . "/../../");
    }

    public function getClassesUnderNamespace(string $namespace): array
    {
        $directory = $this->getNamespaceDirectory($namespace);
        if ($directory === false) {
            return [];
        }

        $files = array_diff(scandir($directory), ['..', '.']);
        $classes = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $className = $namespace . '\\' . pathinfo($file, PATHINFO_FILENAME);
                if (class_exists($className)) {
                    $classes[] = $className;
                }
            }
        }

        return $classes;
    }

    private function getDefinedNamespaces(): array
    {
        $composerJsonPath = $this->appRoot . '/composer.json';
        if (!file_exists($composerJsonPath)) {
            return [];
        }

        $composerConfig = json_decode(file_get_contents($composerJsonPath), true);
        return $composerConfig['autoload']['psr-4'] ?? [];
    }

    private function getNamespaceDirectory(string $namespace): ?string
    {
        $composerNamespaces = $this->getDefinedNamespaces();
        $namespaceFragments = explode('\\', $namespace);
        $undefinedNamespaceFragments = [];

        while ($namespaceFragments) {
            $possibleNamespace = implode('\\', $namespaceFragments) . '\\';

            if (isset($composerNamespaces[$possibleNamespace])) {
                return realpath($this->appRoot . '/' . $composerNamespaces[$possibleNamespace] . implode('/', $undefinedNamespaceFragments));
            }

            array_unshift($undefinedNamespaceFragments, array_pop($namespaceFragments));
        }

        return null;
    }
}
