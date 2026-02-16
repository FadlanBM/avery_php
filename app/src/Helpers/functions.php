<?php

if (!function_exists('dd')) {
    /**
     * Dump and Die function similar to Laravel's dd()
     *
     * @param mixed ...$vars
     * @return void
     */
    function dd(...$vars) {
        echo '<style>
            .dd-container {
                background-color: #18171B;
                color: #FF8400;
                padding: 25px;
                font-family: "Menlo", "Monaco", "Consolas", monospace;
                font-size: 13px;
                line-height: 1.6;
                z-index: 99999;
                position: relative;
                text-align: left;
                border: 1px solid #333;
                margin: 10px;
                border-radius: 4px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            }
            .dd-container pre {
                margin: 0;
                white-space: pre-wrap;
                word-wrap: break-word;
            }
            .dd-type {
                color: #A9A9A9;
                font-size: 0.9em;
            }
        </style>';
        
        foreach ($vars as $var) {
            echo '<div class="dd-container"><pre>';
            var_dump($var);
            echo '</pre></div>';
        }
        
        die(1);
    }
}
