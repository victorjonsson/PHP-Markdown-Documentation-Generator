<?php
/**
 * The interface implemented by all table generators.
 *
 * @since TBD
 */

namespace PHPDocsMD;


/**
 * Any class that can create a markdown-formatted table describing class functions
 * referred to via FunctionEntity objects should implement this interface.
 *
 * @package PHPDocsMD
 */
interface TableGenerator
{

    /**
     * All example comments found while generating the table will be
     * appended to the end of the table. Set $toggle to false to
     * prevent this behaviour
     *
     * @param bool $toggle
     */
    function appendExamplesToEndOfTable($toggle);

    /**
     * Begin generating a new markdown-formatted table
     */
    function openTable();

    /**
     * Toggle whether or not methods being abstract (or part of an interface)
     * should be declared as abstract in the table
     *
     * @param bool $toggle
     */
    function doDeclareAbstraction($toggle);

    /**
     * Generates a markdown formatted table row with information about given function. Then adds the
     * row to the table and returns the markdown formatted string.
     *
     * @param FunctionEntity $func
     *
     * @return string
     */
    function addFunc(FunctionEntity $func);

    /**
     * @return string
     */
    function getTable();

    /**
     * Create a markdown-formatted code view out of an example comment
     *
     * @param string $example
     *
     * @return string
     */
    public static function formatExampleComment($example);
}
