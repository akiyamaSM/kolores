<?php

namespace Chibi\Template\Compilers;


class ConditionCompiler implements compilable {

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
        $content = preg_replace('/@when\((.*)\)/', '<?php if($1) : ?>', $content);
        $content = preg_replace('/@or\((.*)\)/', '<?php elseif($1) : ?>', $content);
        $content = preg_replace('/@otherwise/', '<?php else: ?>', $content);
        $content = preg_replace('/@end/', '<?php endif; ?>', $content);

        return $content;
    }
}