<?php
$classes = get_declared_classes();

foreach ($classes as $class) {
    $refClass = new ReflectionClass($class);

    if ($refClass->hasMethod('__construct')) {
        $constructor = $refClass->getMethod('__construct');

        // Skip inherited constructors
        if ($constructor->class !== $class) {
            continue;
        }

        $params = $constructor->getParameters();

        // Only print if there are 2 or more parameters
        if (count($params) < 2) {
            continue;
        }

        echo "Class: $class\n";
        echo "Constructor: function __construct(";

        $paramStrs = [];
        foreach ($params as $param) {
            $paramStr = '$' . $param->getName();

            if ($param->isOptional()) {
                try {
                    $default = var_export($param->getDefaultValue(), true);
                    $paramStr .= ' = ' . $default;
                } catch (ReflectionException $e) {
                    $paramStr .= ' = ?';
                }
            }

            $paramStrs[] = $paramStr;
        }

        echo implode(', ', $paramStrs);
        echo ")\n\n";
    }
}
?>