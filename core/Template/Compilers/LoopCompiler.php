<?php

namespace Chibi\Template\Compilers;


class LoopCompiler implements compilable {

    /**
     * Construct
     *
     * @param array $vars
     */
    public function __construct($vars = [])
    {
        $this->vars = $vars;
    }

    /**
     * Compile if statement
     *
     * @param $content
     * @return mixed
     */
    public function compile($content)
    {
        $content = preg_replace('/@for\((.*)\)/', '<?php for($1) : ?>', $content);
        $content = preg_replace('/@endfor/', '<?php endfor; ?>', $content);
        $content = preg_replace('/@foreach\((.*)\)/', '<?php foreach($1): ?>', $content);
        $content = preg_replace('/@endforeach\((.*)\)/', '<?php endforeach; ?>', $content);

        return $content;
    }
}