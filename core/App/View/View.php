<?php

namespace Kernel\Application\View;

use Exception;

/**
 * Class View
 *
 * Manages the rendering of view files. Supports passing data to views and locating view files
 * within a specified directory.
 */
class View
{
    /**
     * The directory where view files are located.
     */
    protected string $viewDirectory;

    /**
     * Constructor.
     *
     * Initializes the view manager with a directory for view files.
     * If no directory is provided, it defaults to the `resources/views` directory.
     *
     * @param  string  $viewDirectory  The directory containing view files.
     */
    public function __construct(string $viewDirectory = '')
    {
        $this->viewDirectory = $viewDirectory ?: APP_ROOT.'/resources/views';
    }

    /**
     * Renders a view file and outputs its content.
     *
     * The method also passes data to the view using variable extraction.
     *
     * @param  string  $view  The name of the view file (without extension).
     * @param  mixed  $data  The data to be passed to the view (associative array).
     * @return $this The current instance for method chaining.
     *
     * @throws Exception If the view file cannot be found.
     */
    public function render(string $view, mixed $data = []): View
    {
        echo $this->renderView($view, $data);

        return $this;
    }

    /**
     * Renders a view file and returns its content as a string.
     *
     * @param  string  $view  The name of the view file (without extension).
     * @param  mixed  $data  The data to be passed to the view (associative array).
     * @return string The rendered view content.
     *
     * @throws Exception If the view file cannot be found.
     */
    private function renderView(string $view, mixed $data): string
    {
        $viewPath = $this->getViewPath($view);

        if (! file_exists($viewPath)) {
            throw new Exception("View file not found: $viewPath");
        }

        ob_start();
        extract($data, EXTR_SKIP);
        include $viewPath;

        return ob_get_clean();
    }

    /**
     * Resolves the full file path of a view file.
     *
     * Combines the view directory and view name into a complete file path.
     *
     * @param  string  $view  The name of the view file (without extension).
     * @return string The full file path of the view.
     */
    private function getViewPath(string $view): string
    {
        return str_replace(DIRECTORY_SEPARATOR, '/', $this->viewDirectory.'/'.$view.'.php');
    }
}
