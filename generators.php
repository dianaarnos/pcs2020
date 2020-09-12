<?php

$function = function ()
{
    yield PHP_EOL . "Starting";

    echo PHP_EOL . "-";
    yield PHP_EOL . ".";

    $incoming = yield;

    echo PHP_EOL . $incoming;

    return PHP_EOL . "Generator's end.";
};

$generator = $function();

echo PHP_EOL . "Main flow";
echo $generator->current();

echo PHP_EOL . "Main flow";
$generator->next();
echo $generator->current();
$generator->next();

echo PHP_EOL . "Main flow";
$generator->send("aeeewww");
$generator->next();
echo $generator->getReturn() . PHP_EOL;

echo PHP_EOL . "Main flow";
