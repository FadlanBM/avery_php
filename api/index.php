<?php
// Vercel Entry Point

// Define the document root to be the parent directory of 'api'
// This maps to the project root in Vercel's environment
chdir(__DIR__ . '/../');

// Require the main index file
require __DIR__ . '/../index.php';
