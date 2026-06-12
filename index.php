<?php
/**
 * FactoryOS - Root Proxy
 * This file allows the application to run from the root directory
 * while keeping the core logic protected in the /app folder.
 */

// Load the public index
require_once __DIR__ . '/public/index.php';
